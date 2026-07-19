<?php

namespace App\Livewire\IqaAdmin;

use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Models\Program;
use Flux\Flux;
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
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $role_id = '';
    public $college_id = '';
    public $program_id = '';

    // Deactivation target status ('active' or 'inactive')
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

    // Reset program selection when college changes
    public function updatedCollegeId($value)
    {
        $this->program_id = '';
    }

    /**
     * Create Modal Handlers
     */
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

    public function createAccount()
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'college_id' => 'nullable|exists:colleges,id',
            'program_id' => 'nullable|exists:programs,id',
        ]);

        User::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
            'college_id' => $this->college_id ?: null,
            'program_id' => $this->program_id ?: null,
            'status' => 'active',
        ]);

        $this->showCreateModal = false;
        $this->resetForm();
        
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Created!'),
            'text' => __('User account created successfully.'),
        ]);
    }

    /**
     * Edit Modal Handlers
     */
    public function openEditModal($id)
    {
        $this->resetForm();
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->college_id = $user->college_id;
        $this->program_id = $user->program_id;
        $this->password = '';

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function updateAccount()
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'college_id' => 'nullable|exists:colleges,id',
            'program_id' => 'nullable|exists:programs,id',
        ]);

        $user = User::findOrFail($this->userId);
        
        $data = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'college_id' => $this->college_id ?: null,
            'program_id' => $this->program_id ?: null,
        ];

        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        $user->update($data);

        $this->showEditModal = false;
        $this->resetForm();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Saved!'),
            'text' => __('User account updated successfully.'),
        ]);
    }

    /**
     * Delete/Deactivate Modal Handlers
     */
    public function openDeleteModal($id)
    {
        $this->userId = $id;
        $user = User::findOrFail($id);
        $this->targetUserStatus = $user->status;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userId = null;
    }

    public function toggleAccountStatus()
    {
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $newStatus = $user->status === 'active' ? 'inactive' : 'active';
            
            $user->update(['status' => $newStatus]);
            
            $this->showDeleteModal = false;
            $this->userId = null;

            $actionText = $newStatus === 'active' ? __('activated') : __('deactivated');
            $titleText = $newStatus === 'active' ? __('Activated!') : __('Deactivated!');

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => $titleText,
                'text' => sprintf(__('User account has been %s successfully.'), $actionText),
            ]);
        }
    }

    private function resetForm()
    {
        $this->reset([
            'userId',
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'password',
            'role_id',
            'college_id',
            'program_id',
            'targetUserStatus',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::with(['roleRelation', 'program', 'college'])
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roleRelation', function ($q) {
                    $q->where('role_name', $this->roleFilter);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $roles = Role::all();
        $colleges = College::all();
        $programs = Program::when($this->college_id, fn($q) => $q->where('college_id', $this->college_id))->get();

        // Calculate counts
        $activeCount = User::where('status', 'active')->count();
        $inactiveCount = User::where('status', 'inactive')->count();
        $totalCount = $activeCount + $inactiveCount;

        return view('pages.roles.iqa-admin.accounts', [
            'users' => $users,
            'roles' => $roles,
            'colleges' => $colleges,
            'programs' => $programs,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'totalCount' => $totalCount,
        ]);
    }
}
