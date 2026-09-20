<?php

/**
 * ============================================================================
 * IQArchive v2 — TaskForce Model
 * ============================================================================
 * File: app/Models/TaskForce.php
 * Responsibility: Program accreditation committee formed per academic cycle.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskForce extends Model
{
    use HasFactory;

    protected $table = 'task_forces';

    public const UPDATED_AT = null;

    protected $fillable = [
        'program_id',
        'dean_lead_user_id',
        'academic_year',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function deanLead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dean_lead_user_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TaskForceMember::class);
    }

    public function accreditations(): HasMany
    {
        return $this->hasMany(Accreditation::class);
    }
}
