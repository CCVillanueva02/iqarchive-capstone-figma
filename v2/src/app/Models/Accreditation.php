<?php

/**
 * ============================================================================
 * IQArchive v2 — Accreditation Model
 * ============================================================================
 * File: app/Models/Accreditation.php
 * Responsibility: Formal accreditation survey instance for an academic program.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accreditation extends Model
{
    use HasFactory;

    protected $table = 'accreditations';

    public const UPDATED_AT = null;

    protected $fillable = [
        'program_id',
        'task_force_id',
        'applied_level',
        'current_stage',
        'stage_status',
        'target_date',
    ];

    protected function casts(): array
    {
        return [
            'current_stage' => 'integer',
            'target_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function taskForce(): BelongsTo
    {
        return $this->belongsTo(TaskForce::class);
    }

    public function stageHistories(): HasMany
    {
        return $this->hasMany(AccreditationStageHistory::class);
    }

    public function complianceRequirements(): HasMany
    {
        return $this->hasMany(ComplianceRequirement::class);
    }
}
