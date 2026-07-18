<?php

namespace App\Livewire\SystemAdministrator;

use App\Models\AuditLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AuditTrail extends Component
{
    use WithPagination;

    public $search = '';
    public $userId = '';
    public $actionType = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'userId' => ['except' => ''],
        'actionType' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingUserId()
    {
        $this->resetPage();
    }

    public function updatingActionType()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'userId', 'actionType']);
        $this->resetPage();
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('action', 'like', '%' . $this->search . '%')
                      ->orWhere('target_type', 'like', '%' . $this->search . '%')
                      ->orWhere('target_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->userId, function ($query) {
                $query->where('user_id', $this->userId);
            })
            ->when($this->actionType, function ($query) {
                $query->where('action', $this->actionType);
            })
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        $users = User::orderBy('first_name')->get();
        
        $actions = AuditLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('livewire.system-administrator.audit-trail', [
            'logs' => $logs,
            'users' => $users,
            'actions' => $actions,
        ]);
    }
}
