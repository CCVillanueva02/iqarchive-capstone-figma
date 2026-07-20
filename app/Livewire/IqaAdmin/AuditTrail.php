<?php

namespace App\Livewire\IqaAdmin;

use App\Models\AuditLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AuditTrail extends Component
{
    use WithPagination;

    public $tab = 'general'; // general, authentication, documents
    public $search = '';
    public $userId = '';
    public $actionType = '';

    protected $queryString = [
        'tab' => ['except' => 'general'],
        'search' => ['except' => ''],
        'userId' => ['except' => ''],
        'actionType' => ['except' => ''],
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

    public function updatingUserId()
    {
        $this->resetPage();
    }

    public function updatingActionType()
    {
        $this->resetPage();
    }

    public function updatedTab()
    {
        $this->resetPage();
        $this->reset(['search', 'userId', 'actionType']);
    }

    public function clearFilters()
    {
        $this->reset(['search', 'userId', 'actionType']);
        $this->resetPage();
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->when($this->tab === 'authentication', function ($query) {
                $query->whereIn('action', ['login', 'logout']);
            })
            ->when($this->tab === 'documents', function ($query) {
                $query->where('action', 'like', 'document_%');
            })
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
        
        // Populate distinct action choices filtered by the active tab category
        $actionsQuery = AuditLog::select('action')->distinct()->orderBy('action');
        if ($this->tab === 'authentication') {
            $actionsQuery->whereIn('action', ['login', 'logout']);
        } elseif ($this->tab === 'documents') {
            $actionsQuery->where('action', 'like', 'document_%');
        }
        $actions = $actionsQuery->pluck('action');

        return view('livewire.iqa-admin.audit-trail', [
            'logs' => $logs,
            'users' => $users,
            'actions' => $actions,
        ]);
    }
}
