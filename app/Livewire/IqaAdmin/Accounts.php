<?php

namespace App\Livewire\IqaAdmin;

use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Models\Program;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Accounts')]
class Accounts extends Component
{
    use WithPagination;

    // Search and filtering state
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    // Modal view states
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;

    // Form inputs state
    public $userId;
    public $userStatus = '';
    public $userName = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $email = '';
    public $role_id = '';
    public $selected_role_ids = [];
    public $college_id = '';
    public $program_id = '';

    // Deactivation target status ('active', 'pending_activation', or 'inactive')
    public $targetUserStatus = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function mount()
    {
        if (auth()->user()->role !== 'iqa-admin') {
            abort(403, 'Unauthorized action.');
        }
    }

    private function getSystemAdminRoleId(): ?int
    {
        return Role::where('role_name', 'system-administrator')->value('id');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
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

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->userStatus = '';
        $this->userName = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->role_id = '';
        $this->selected_role_ids = [];
        $this->college_id = '';
        $this->program_id = '';
        $this->resetValidation();
    }

    /**
     * 3.1 Pre-register User Account
     */
    public function createAccount()
    {
        if (!empty($this->selected_role_ids)) {
            $this->role_id = $this->selected_role_ids[0];
        }

        $selectedRole = Role::find($this->role_id);
        $roleName = $selectedRole ? $selectedRole->role_name : '';

        // College is required when Role is College Head, Program Chair, or IQA Member
        $requiresCollege = in_array($roleName, ['college-head', 'program-chair', 'iqa-member']);

        $rules = [
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'exists:roles,id'],
            'college_id' => $requiresCollege ? ['required', 'exists:colleges,id'] : ['nullable', 'exists:colleges,id'],
            'program_id' => ['nullable', 'exists:programs,id'],
        ];

        $messages = [
            'email.required' => 'Enter a valid university Gmail address.',
            'email.email' => 'Enter a valid university Gmail address.',
            'email.unique' => 'This email is already registered.',
            'role_id.required' => 'Please select a valid role.',
            'role_id.exists' => 'Please select a valid role.',
            'college_id.required' => 'Please select the college/department for this role.',
            'college_id.exists' => 'Please select the college/department for this role.',
        ];

        // Block creation of system-administrator accounts by IQA Admin
        $sysAdminRoleId = $this->getSystemAdminRoleId();
        if ($sysAdminRoleId && (int)$this->role_id === $sysAdminRoleId) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($rules, $messages);

        try {
            $newUser = null;
            DB::transaction(function () use (&$newUser) {
                $emailPrefix = explode('@', trim($this->email))[0];
                $defaultFirstName = ucwords(str_replace(['.', '_', '-'], ' ', $emailPrefix));

                $newUser = User::create([
                    'first_name' => $defaultFirstName ?: 'Pending',
                    'last_name' => 'User',
                    'email' => strtolower(trim($this->email)),
                    'password' => bcrypt(Str::random(32)), // Credential security delegated to Google Workspace
                    'role_id' => $this->role_id,
                    'college_id' => $this->college_id ?: null,
                    'program_id' => $this->program_id ?: null,
                    'status' => 'pending_activation',
                ]);

                $rolesToSync = array_values(array_unique(array_filter(array_merge([(int)$this->role_id], array_map('intval', $this->selected_role_ids)))));
                $newUser->roles()->sync($rolesToSync);

                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'CREATE_USER',
                    'target_type' => User::class,
                    'target_id' => $newUser->id,
                    'timestamp' => now(),
                ]);
            });

            $this->closeCreateModal();

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => __('User Pre-Registered!'),
                'text' => __('User pre-registered successfully — awaiting first sign-in'),
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => __('Registration Failed'),
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $user = User::findOrFail($id);

        if ($user->role === 'system-administrator') {
            abort(403, 'Unauthorized action.');
        }

        $this->userId = $user->id;
        $this->userStatus = $user->status;
        $this->userName = $user->name;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->selected_role_ids = $user->roles->pluck('id')->toArray();
        if (empty($this->selected_role_ids) && $user->role_id) {
            $this->selected_role_ids = [$user->role_id];
        }
        $this->college_id = $user->college_id;
        $this->program_id = $user->program_id;

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function updateAccount()
    {
        $user = User::findOrFail($this->userId);

        if ($user->role === 'system-administrator') {
            abort(403, 'Unauthorized action.');
        }

        if (!empty($this->selected_role_ids)) {
            $this->role_id = $this->selected_role_ids[0];
        }

        $selectedRole = Role::find($this->role_id);
        $roleName = $selectedRole ? $selectedRole->role_name : '';
        $requiresCollege = in_array($roleName, ['college-head', 'program-chair', 'iqa-member']);

        $rules = [
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->userId],
            'role_id' => ['required', 'exists:roles,id'],
            'college_id' => $requiresCollege ? ['required', 'exists:colleges,id'] : ['nullable', 'exists:colleges,id'],
            'program_id' => ['nullable', 'exists:programs,id'],
        ];

        $messages = [
            'email.required' => 'Enter a valid university Gmail address.',
            'email.email' => 'Enter a valid university Gmail address.',
            'email.unique' => 'This email is already registered.',
            'role_id.required' => 'Please select a valid role.',
            'role_id.exists' => 'Please select a valid role.',
            'college_id.required' => 'Please select the college/department for this role.',
            'college_id.exists' => 'Please select the college/department for this role.',
        ];

        $this->validate($rules, $messages);

        DB::transaction(function () use ($user) {
            $user->update([
                'email' => strtolower(trim($this->email)),
                'role_id' => $this->role_id,
                'college_id' => $this->college_id ?: null,
                'program_id' => $this->program_id ?: null,
            ]);

            $rolesToSync = !empty($this->selected_role_ids) ? $this->selected_role_ids : [$this->role_id];
            $user->roles()->sync($rolesToSync);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'UPDATE_USER',
                'target_type' => User::class,
                'target_id' => $user->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeEditModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Updated!'),
            'text' => __('User details updated successfully.'),
        ]);
    }

    public function openDeleteModal($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'system-administrator') {
            abort(403, 'Unauthorized action.');
        }

        $this->userId = $user->id;
        $this->targetUserStatus = $user->status;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userId = null;
        $this->targetUserStatus = '';
    }

    public function toggleAccountStatus()
    {
        $user = User::findOrFail($this->userId);

        if ($user->role === 'system-administrator') {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $user->status === 'inactive' ? 'active' : 'inactive';
        $logAction = $newStatus === 'inactive' ? 'DEACTIVATE_USER' : 'ACTIVATE_USER';

        DB::transaction(function () use ($user, $newStatus, $logAction) {
            $user->update(['status' => $newStatus]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => $logAction,
                'target_type' => User::class,
                'target_id' => $user->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeDeleteModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Status Changed'),
            'text' => $newStatus === 'inactive'
                ? __('User account deactivated.')
                : __('User account activated.'),
        ]);
    }

    public function render()
    {
        $sysAdminRoleId = $this->getSystemAdminRoleId();

        $usersQuery = User::where('id', '!=', auth()->id())
            ->when($sysAdminRoleId, function ($q) use ($sysAdminRoleId) {
                $q->where('role_id', '!=', $sysAdminRoleId);
            })
            ->with(['roleRelation', 'college', 'program']);

        if (!empty($this->search)) {
            $usersQuery->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->roleFilter)) {
            $usersQuery->whereHas('roleRelation', function ($q) {
                $q->where('role_name', $this->roleFilter);
            });
        }

        if (!empty($this->statusFilter)) {
            $usersQuery->where('status', $this->statusFilter);
        }

        $users = $usersQuery->orderBy('created_at', 'desc')->paginate(10);

        $roles = Role::when($sysAdminRoleId, function ($q) use ($sysAdminRoleId) {
            $q->where('id', '!=', $sysAdminRoleId);
        })->get();

        $colleges = College::orderBy('name', 'asc')->get();
        $programs = !empty($this->college_id)
            ? Program::where('college_id', $this->college_id)->orderBy('name', 'asc')->get()
            : collect();

        // Counts
        $baseQuery = User::where('id', '!=', auth()->id())
            ->when($sysAdminRoleId, function ($q) use ($sysAdminRoleId) {
                $q->where('role_id', '!=', $sysAdminRoleId);
            });

        $totalCount = (clone $baseQuery)->count();
        $activeCount = (clone $baseQuery)->where('status', 'active')->count();
        $pendingCount = (clone $baseQuery)->where('status', 'pending_activation')->count();
        $inactiveCount = (clone $baseQuery)->where('status', 'inactive')->count();

        return view('pages.roles.iqa-admin.accounts', [
            'users' => $users,
            'roles' => $roles,
            'colleges' => $colleges,
            'programs' => $programs,
            'totalCount' => $totalCount,
            'activeCount' => $activeCount,
            'pendingCount' => $pendingCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
