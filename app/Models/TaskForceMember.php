<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskForceMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_force_id',
        'user_id',
        'role_in_team',
        'role_in_task_force',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function getRoleInTaskForceAttribute(): string
    {
        return $this->role_in_team ?? 'member';
    }

    public function setRoleInTaskForceAttribute($value): void
    {
        $this->attributes['role_in_team'] = $value;
    }

    public function taskForce()
    {
        return $this->belongsTo(TaskForce::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
