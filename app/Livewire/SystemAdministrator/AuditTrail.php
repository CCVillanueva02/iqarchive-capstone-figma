<?php

namespace App\Livewire\SystemAdministrator;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class AuditTrail extends Component
{
    use WithPagination;

    public $tab = 'sessions'; // sessions, accounts, files

    public $search = '';

    public $actionType = '';

    protected $queryString = [
        'tab' => ['except' => 'sessions'],
        'search' => ['except' => ''],
        'actionType' => ['except' => ''],
    ];

    public function updatingSearch()
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
        $this->reset(['search', 'actionType']);
    }

    public function clearFilters()
    {
        $this->reset(['search', 'actionType']);
        $this->resetPage();
    }

    public function render()
    {
        if ($this->tab === 'sessions') {
            $loginsQuery = AuditLog::where('action', 'login')
                ->with('user')
                ->when($this->search, function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('first_name', 'like', '%'.$this->search.'%')
                            ->orWhere('last_name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    });
                })
                ->orderBy('timestamp', 'desc');

            $logs = $loginsQuery->paginate(10);

            // Pair each login event with its corresponding logout event
            foreach ($logs as $loginLog) {
                $nextLoginTimestamp = AuditLog::where('user_id', $loginLog->user_id)
                    ->where('action', 'login')
                    ->where('timestamp', '>', $loginLog->timestamp)
                    ->orderBy('timestamp', 'asc')
                    ->value('timestamp');

                $logoutQuery = AuditLog::where('user_id', $loginLog->user_id)
                    ->where('action', 'logout')
                    ->where('timestamp', '>=', $loginLog->timestamp);

                if ($nextLoginTimestamp) {
                    $logoutQuery->where('timestamp', '<', $nextLoginTimestamp);
                }

                $loginLog->logout_log = $logoutQuery->orderBy('timestamp', 'asc')->first();
            }
        } elseif ($this->tab === 'accounts') {
            $logs = AuditLog::with('user')
                ->whereIn('action', ['CREATE_USER', 'UPDATE_USER', 'DEACTIVATE_USER', 'ACTIVATE_USER', 'account_create', 'account_update', 'password_reset'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('action', 'like', '%'.$this->search.'%')
                            ->orWhereHas('user', function ($u) {
                                $u->where('first_name', 'like', '%'.$this->search.'%')
                                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                                    ->orWhere('email', 'like', '%'.$this->search.'%');
                            });
                    });
                })
                ->when($this->actionType, function ($query) {
                    $query->where('action', $this->actionType);
                })
                ->orderBy('timestamp', 'desc')
                ->paginate(10);
        } else {
            // File Modifications tab
            $logs = AuditLog::with('user')
                ->where('action', 'like', 'document_%')
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('action', 'like', '%'.$this->search.'%')
                            ->orWhereHas('user', function ($u) {
                                $u->where('first_name', 'like', '%'.$this->search.'%')
                                    ->orWhere('last_name', 'like', '%'.$this->search.'%')
                                    ->orWhere('email', 'like', '%'.$this->search.'%');
                            });
                    });
                })
                ->when($this->actionType, function ($query) {
                    $query->where('action', $this->actionType);
                })
                ->orderBy('timestamp', 'desc')
                ->paginate(10);
        }

        $actionsQuery = AuditLog::select('action')->distinct()->orderBy('action');
        if ($this->tab === 'sessions') {
            $actionsQuery->whereIn('action', ['login', 'logout']);
        } elseif ($this->tab === 'accounts') {
            $actionsQuery->whereIn('action', ['CREATE_USER', 'UPDATE_USER', 'DEACTIVATE_USER', 'ACTIVATE_USER', 'account_create', 'account_update', 'password_reset']);
        } else {
            $actionsQuery->where('action', 'like', 'document_%');
        }
        $actions = $actionsQuery->pluck('action');

        return view('livewire.system-administrator.audit-trail', [
            'logs' => $logs,
            'actions' => $actions,
        ]);
    }
}
