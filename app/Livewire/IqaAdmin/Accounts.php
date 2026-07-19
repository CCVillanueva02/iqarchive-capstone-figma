<?php

namespace App\Livewire\IqaAdmin;

use App\Models\User;
use App\Models\Role;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Accounts')]
class Accounts extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
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

    public function render()
    {
        $users = User::with(['roleRelation', 'program', 'college'])
            ->where('status', 'active')
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

        return view('pages.roles.iqa-admin.accounts', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
