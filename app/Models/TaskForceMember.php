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
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function taskForce()
    {
        return $this->belongsTo(TaskForce::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
