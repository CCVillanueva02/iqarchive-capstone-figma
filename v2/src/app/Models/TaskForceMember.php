<?php

/**
 * ============================================================================
 * IQArchive v2 — TaskForceMember Model
 * ============================================================================
 * File: app/Models/TaskForceMember.php
 * Responsibility: Faculty subject-matter experts assigned to specific AACCUP areas.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskForceMember extends Model
{
    use HasFactory;

    protected $table = 'task_force_members';

    public $timestamps = false;

    protected $fillable = [
        'task_force_id',
        'user_id',
        'instrument_area_id',
        'role_in_team',
        'assigned_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    public function taskForce(): BelongsTo
    {
        return $this->belongsTo(TaskForce::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(InstrumentArea::class, 'instrument_area_id');
    }
}
