<?php

namespace App\Livewire\TaskForce;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Task Force Management')]
class TaskForceOverview extends Component
{
    use WithPagination;

    // Search and filter state
    public $search = '';

    public $collegeFilter = '';

    public $statusFilter = '';

    // Modal state for Create Task Force (6.1 Input Screen)
    public bool $showCreateModal = false;

    public string $name = '';

    public string $college_id = '';

    public string $program_id = '';

    public array $proposedMembers = [];

    public string $newName = '';

    public string $newEmail = '';

    public string $newPhone = '';

    // Modal state for Member Roster / Detail view (6.2 Output Screen)
    public bool $showRosterModal = false;

    public ?TaskForce $selectedTaskForce = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'collegeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCollegeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedCollegeId($value)
    {
        $this->program_id = '';
    }

    /**
     * Check if current user can create/propose Task Forces
    /**
     * Check if current user can create/propose Task Forces
     */
    #[Computed]
    public function canCreate(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole(['iqa-staff', 'iqa-admin', 'university-administrator', 'college-head', 'system-administrator']);
    }

    /**
     * Check if current user has administrative rights to approve/manage Task Forces
     */
    #[Computed]
    public function canManage(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole(['iqa-staff', 'iqa-admin', 'university-administrator', 'system-administrator']);
    }

    public function openCreateModal()
    {
        if (! $this->canCreate) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Unauthorized Action',
                'text' => 'You do not have permission to create a task force.',
            ]);

            return;
        }

        $this->resetCreateForm(false);

        // Pre-define assigned college based on logged in user or default college
        $user = auth()->user();
        if ($user->college_id) {
            $this->college_id = (string) $user->college_id;
        } else {
            $firstCollege = College::first();
            $this->college_id = $firstCollege ? (string) $firstCollege->id : '';
        }

        if ($user->program_id) {
            $this->program_id = (string) $user->program_id;
        }

        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetCreateForm();
    }

    private function resetCreateForm($resetSelection = true)
    {
        $this->name = '';
        if ($resetSelection) {
            $this->college_id = '';
            $this->program_id = '';
        }
        $this->proposedMembers = [];
        $this->reset(['newName', 'newEmail', 'newPhone']);
        $this->resetValidation();
    }

    public function addMember()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newEmail' => 'required|email|max:255',
            'newPhone' => 'required|string|max:20',
        ]);

        $this->proposedMembers[] = [
            'name' => $this->newName,
            'email' => $this->newEmail,
            'phone' => $this->newPhone,
        ];

        $this->reset(['newName', 'newEmail', 'newPhone']);
    }

    public function removeMember($index)
    {
        if (isset($this->proposedMembers[$index])) {
            unset($this->proposedMembers[$index]);
            $this->proposedMembers = array_values($this->proposedMembers); // re-index
        }
    }

    /**
     * 6.1 Create / Propose Task Force (Atomic Operation)
     */
    public function createTaskForce()
    {
        if (! $this->canCreate) {
            abort(403, 'Unauthorized action.');
        }

        $rules = [
            'name' => 'required|string|min:3|max:150|unique:task_forces,name',
            'college_id' => 'required|exists:colleges,id',
            'program_id' => 'required|exists:programs,id',
            'proposedMembers' => 'required|array|min:1',
        ];

        $messages = [
            'name.required' => 'Task force name is required and must be unique.',
            'name.min' => 'Task force name must be between 3 and 150 characters.',
            'name.max' => 'Task force name must be between 3 and 150 characters.',
            'name.unique' => 'Task force name is required and must be unique.',
            'college_id.required' => 'Please select the assigned college/program.',
            'college_id.exists' => 'Please select a valid college.',
            'program_id.required' => 'Please select the assigned program.',
            'program_id.exists' => 'Please select a valid program.',
            'proposedMembers.required' => 'Add at least one proposed member.',
            'proposedMembers.min' => 'Add at least one proposed member.',
        ];

        if (empty($this->proposedMembers)) {
            $this->addError('proposedMembers', 'Add at least one proposed member.');

            return;
        }

        $this->validate($rules, $messages);

        $currentUser = auth()->user();
        $isCollegeHeadProposal = $currentUser->hasRole('college-head');
        $initialStatus = $isCollegeHeadProposal ? 'pending_approval' : 'active';

        try {
            DB::transaction(function () use ($initialStatus, $isCollegeHeadProposal, $currentUser) {
                // 1. Create Task Force record
                $taskForce = TaskForce::create([
                    'name' => trim($this->name),
                    'college_id' => $this->college_id,
                    'program_id' => $this->program_id ? $this->program_id : null,
                    'status' => $initialStatus,
                    'proposed_members' => $this->proposedMembers,
                    'created_by' => $currentUser->id,
                ]);

                // 2. Members are proposed, not directly attached unless it's IQA converting them later.
                // For now, we skip direct User attachment since they are manually entered.

                // 3. If submitted by College Head, send notification to all IQA Staff
                if ($isCollegeHeadProposal) {
                    $iqaStaffRoleIds = Role::whereIn('role_name', ['iqa-staff', 'iqa-admin'])->pluck('id');
                    $iqaStaffUsers = User::whereIn('role_id', $iqaStaffRoleIds)->get();

                    foreach ($iqaStaffUsers as $staff) {
                        Notification::create([
                            'user_id' => $staff->id,
                            'type' => 'alert',
                            'message' => "New Task Force submission from {$currentUser->name} ({$taskForce->college->code}): {$taskForce->name} (Pending Approval)",
                            'is_read' => false,
                        ]);
                    }
                }

                // 4. Log in AuditLog
                AuditLog::create([
                    'user_id' => $currentUser->id,
                    'action' => $isCollegeHeadProposal ? 'Task Force Proposed' : 'Task Force Created',
                    'target_type' => 'TaskForce',
                    'target_id' => $taskForce->id,
                    'timestamp' => now(),
                ]);
            });

            $this->closeCreateModal();

            if ($isCollegeHeadProposal) {
                $this->dispatch('swal', [
                    'icon' => 'success',
                    'title' => 'Task Force Submitted for Approval!',
                    'text' => 'Your task force proposal has been sent to the IQA Admin. They will review and approve the member list.',
                ]);
            } else {
                $this->dispatch('swal', [
                    'icon' => 'success',
                    'title' => 'Task Force Created!',
                    'text' => 'The task force was successfully assembled and notifications sent to assigned members.',
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Creation Failed',
                'text' => 'An error occurred while creating the task force: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Check current system status of a proposed member email.
     */
    public function getProposedMemberStatus(?string $email): array
    {
        if (empty($email)) {
            return [
                'type' => 'unlisted',
                'label' => 'Will Pre-Register',
                'class' => 'bg-slate-100 text-slate-600 border-slate-200',
            ];
        }

        $cleanEmail = strtolower(trim($email));
        $user = User::where('email', $cleanEmail)->first();

        if (! $user) {
            return [
                'type' => 'unlisted',
                'label' => 'Will Pre-Register',
                'class' => 'bg-slate-100 text-slate-600 border-slate-200',
            ];
        }

        if (in_array($user->status, ['inactive', 'deactivated', 'revoked'])) {
            return [
                'type' => 'inactive',
                'label' => 'Will Reactivate',
                'class' => 'bg-amber-50 text-amber-800 border-amber-200',
            ];
        }

        if ($user->status === 'pending_activation') {
            return [
                'type' => 'pending',
                'label' => 'Pending Activation',
                'class' => 'bg-blue-50 text-blue-800 border-blue-200',
            ];
        }

        return [
            'type' => 'active',
            'label' => 'Active Account',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        ];
    }

    /**
     * IQA Admin approves pending task force proposal and member roster.
     * Pre-registers unlisted accounts as pending_activation, reactivates existing/inactive accounts,
     * auto-assigns the Dean as Task Force Lead, and advances linked Accreditation to task_force_approved.
     *
     * Security Reasoning: Centralized IQA verification ensures institutional legitimacy of accreditation
     * task force memberships while enforcing OAuth-only authentication, role-based access control, and complete audit trails.
     */
    public function approveTaskForce($taskForceId)
    {
        if (! $this->canManage) {
            abort(403, 'Only IQA Staff and Administrators can formalize task forces.');
        }

        $taskForce = TaskForce::with(['college', 'program', 'members', 'creator'])->findOrFail($taskForceId);

        $taskForceRole = Role::firstOrCreate(['role_name' => 'task-force-member'], ['description' => 'Task Force Member']);
        $deanRole = Role::firstOrCreate(['role_name' => 'college-head'], ['description' => 'College Head / Dean']);

        $prelistedCount = 0;
        $reactivatedCount = 0;
        $activeMembers = [];

        try {
            DB::transaction(function () use ($taskForce, $taskForceRole, $deanRole, &$prelistedCount, &$reactivatedCount, &$activeMembers) {
                // 1. Process proposed members from nomination
                if (is_array($taskForce->proposed_members) && ! empty($taskForce->proposed_members)) {
                    foreach ($taskForce->proposed_members as $memberData) {
                        $email = strtolower(trim($memberData['email'] ?? ''));
                        if (empty($email)) {
                            continue;
                        }

                        $rawName = trim($memberData['name'] ?? '');
                        $existingUser = User::where('email', $email)->first();

                        if ($existingUser) {
                            // If user is inactive/deactivated/revoked, reactivate account
                            if (in_array($existingUser->status, ['inactive', 'deactivated', 'revoked'])) {
                                $existingUser->status = 'active';
                                $existingUser->save();
                                $reactivatedCount++;
                            }

                            // Ensure task force member role is assigned
                            $existingUser->roles()->syncWithoutDetaching([$taskForceRole->id]);

                            // Attach to task force
                            TaskForceMember::updateOrCreate(
                                ['task_force_id' => $taskForce->id, 'user_id' => $existingUser->id],
                                ['role_in_team' => 'member', 'assigned_at' => now()]
                            );

                            $activeMembers[] = $existingUser;
                        } else {
                            // Pre-register user in pending_activation status
                            $nameParts = explode(' ', $rawName, 2);
                            $firstName = $nameParts[0] ?: 'Pending';
                            $lastName = $nameParts[1] ?? 'Faculty';

                            $newUser = User::create([
                                'first_name' => $firstName,
                                'last_name' => $lastName,
                                'email' => $email,
                                'role_id' => $taskForceRole->id,
                                'college_id' => $taskForce->college_id,
                                'program_id' => $taskForce->program_id,
                                'password' => bcrypt(Str::random(32)),
                                'status' => 'pending_activation',
                            ]);

                            $newUser->roles()->sync([$taskForceRole->id]);

                            TaskForceMember::create([
                                'task_force_id' => $taskForce->id,
                                'user_id' => $newUser->id,
                                'role_in_team' => 'member',
                                'assigned_at' => now(),
                            ]);

                            $prelistedCount++;
                            $activeMembers[] = $newUser;
                        }
                    }
                }

                // 2. Auto-assign College Dean as Task Force Lead
                $dean = User::where('college_id', $taskForce->college_id)
                    ->where(function ($q) use ($deanRole) {
                        $q->where('role_id', $deanRole->id)
                            ->orWhereHas('roles', fn ($rq) => $rq->where('role_name', 'college-head'));
                    })
                    ->first();

                if ($dean) {
                    TaskForceMember::updateOrCreate(
                        ['task_force_id' => $taskForce->id, 'user_id' => $dean->id],
                        ['role_in_team' => 'lead', 'assigned_at' => now()]
                    );
                }

                // 3. Update Task Force status to active
                $taskForce->update(['status' => 'active']);

                // 4. Advance linked Accreditation status to task_force_approved
                $accreditation = Accreditation::where('task_force_id', $taskForce->id)
                    ->orWhere(function ($q) use ($taskForce) {
                        $q->where('program_id', $taskForce->program_id)
                            ->whereIn('status', ['scheduled', 'task_force_setup']);
                    })
                    ->first();

                if ($accreditation) {
                    $accreditation->update([
                        'task_force_id' => $taskForce->id,
                        'status' => 'task_force_approved',
                    ]);
                }

                // 5. Notifications
                if ($dean) {
                    Notification::create([
                        'user_id' => $dean->id,
                        'type' => 'info',
                        'message' => "Task Force roster for {$taskForce->name} has been officially approved and activated by the IQA Office.",
                        'is_read' => false,
                    ]);
                }

                foreach ($activeMembers as $mem) {
                    Notification::create([
                        'user_id' => $mem->id,
                        'type' => 'info',
                        'message' => "You have been assigned to the {$taskForce->name} Task Force roster.",
                        'is_read' => false,
                    ]);
                }

                // 6. Audit Trail
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => "Approved Task Force roster for {$taskForce->name} ({$prelistedCount} pre-registered, {$reactivatedCount} reactivated)",
                    'target_type' => 'TaskForce',
                    'target_id' => $taskForce->id,
                    'timestamp' => now(),
                ]);
            });

            if ($this->selectedTaskForce && $this->selectedTaskForce->id === $taskForce->id) {
                $this->selectedTaskForce = TaskForce::with(['college', 'program', 'members.roleRelation', 'creator'])->find($taskForce->id);
            }

            $msgParts = [];
            if ($prelistedCount > 0) {
                $msgParts[] = "{$prelistedCount} account(s) pre-registered";
            }
            if ($reactivatedCount > 0) {
                $msgParts[] = "{$reactivatedCount} account(s) reactivated";
            }
            $summaryText = ! empty($msgParts) ? ' ('.implode(', ', $msgParts).')' : '';

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Task Force Approved & Activated!',
                'text' => "Task force '{$taskForce->name}' has been formalized{$summaryText}. Dean auto-assigned as Lead.",
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Approval Failed',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function openRosterModal($taskForceId)
    {
        $this->selectedTaskForce = TaskForce::with(['college', 'program', 'members.roleRelation', 'creator'])->find($taskForceId);
        if ($this->selectedTaskForce) {
            $this->showRosterModal = true;
        }
    }

    public function closeRosterModal()
    {
        $this->showRosterModal = false;
        $this->selectedTaskForce = null;
    }

    public function updateTaskForceStatus($taskForceId, $newStatus)
    {
        if (! $this->canManage) {
            abort(403);
        }

        $taskForce = TaskForce::findOrFail($taskForceId);
        $oldStatus = $taskForce->status;
        $taskForce->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => "Task Force Status Changed ({$oldStatus} -> {$newStatus})",
            'target_type' => 'TaskForce',
            'target_id' => $taskForce->id,
            'timestamp' => now(),
        ]);

        if ($this->selectedTaskForce && $this->selectedTaskForce->id === $taskForce->id) {
            $this->selectedTaskForce->status = $newStatus;
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Status Updated',
            'text' => 'Task force status updated to '.ucfirst(str_replace('_', ' ', $newStatus)).'.',
        ]);
    }

    public function render()
    {
        // Allowed role names for Task Force member assignment
        $allowedRoleNames = ['task-force-member', 'college-head', 'iqa-staff', 'iqa-member', 'accreditor'];
        $allowedRoleIds = Role::whereIn('role_name', $allowedRoleNames)->pluck('id');

        // Query active users restricted to task force eligible roles
        $activeUsersQuery = User::where('status', 'active')
            ->whereIn('role_id', $allowedRoleIds)
            ->with(['roleRelation', 'college', 'program']);

        // Filter active members by defined college if college_id is set
        if (! empty($this->college_id)) {
            $targetCollegeId = (int) $this->college_id;
            $activeUsersQuery->where(function ($q) use ($targetCollegeId) {
                $q->where('college_id', $targetCollegeId)
                    ->orWhereNull('college_id'); // Include university-wide IQA members & accreditors
            });
        }

        if (! empty($this->memberSearch)) {
            $activeUsersQuery->where(function ($q) {
                $q->where('first_name', 'like', '%'.$this->memberSearch.'%')
                    ->orWhere('last_name', 'like', '%'.$this->memberSearch.'%')
                    ->orWhere('email', 'like', '%'.$this->memberSearch.'%');
            });
        }

        $activeUsers = $activeUsersQuery->orderBy('first_name', 'asc')->get();

        // Query task forces for Overview dashboard cards
        $taskForcesQuery = TaskForce::with(['college', 'program', 'members', 'creator']);

        $currentUser = auth()->user();
        if ($currentUser && $currentUser->hasRole('college-head')) {
            $taskForcesQuery->where(function ($q) use ($currentUser) {
                $q->where('college_id', $currentUser->college_id)
                    ->orWhere('created_by', $currentUser->id);
            });
        }

        if (! empty($this->search)) {
            $taskForcesQuery->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('purpose', 'like', '%'.$this->search.'%');
            });
        }

        if (! empty($this->collegeFilter)) {
            $taskForcesQuery->where('college_id', $this->collegeFilter);
        }

        if (! empty($this->statusFilter)) {
            $taskForcesQuery->where('status', $this->statusFilter);
        }

        $taskForces = $taskForcesQuery->orderBy('created_at', 'desc')->paginate(9);

        // Fetch colleges and programs for select dropdowns
        $colleges = College::orderBy('name', 'asc')->get();
        $definedCollege = ! empty($this->college_id) ? College::find($this->college_id) : null;
        $availablePrograms = ! empty($this->college_id)
            ? Program::where('college_id', $this->college_id)->orderBy('name', 'asc')->get()
            : collect();

        // Summary Statistics
        $totalAllCount = TaskForce::count();
        $totalActiveCount = TaskForce::where('status', 'active')->count();
        $totalPendingCount = TaskForce::where('status', 'pending_approval')->count();
        $totalCompletedCount = TaskForce::where('status', 'completed')->count();
        $totalDisbandedCount = TaskForce::where('status', 'disbanded')->count();
        $totalMembersAssignedCount = DB::table('task_force_members')
            ->join('task_forces', 'task_forces.id', '=', 'task_force_members.task_force_id')
            ->where('task_forces.status', 'active')
            ->distinct('user_id')
            ->count('user_id');

        return view('livewire.task-force.task-force-overview', [
            'taskForces' => $taskForces,
            'activeUsers' => $activeUsers,
            'colleges' => $colleges,
            'definedCollege' => $definedCollege,
            'availablePrograms' => $availablePrograms,
            'totalAllCount' => $totalAllCount,
            'totalActiveCount' => $totalActiveCount,
            'totalPendingCount' => $totalPendingCount,
            'totalCompletedCount' => $totalCompletedCount,
            'totalDisbandedCount' => $totalDisbandedCount,
            'totalMembersAssignedCount' => $totalMembersAssignedCount,
        ]);
    }
}
