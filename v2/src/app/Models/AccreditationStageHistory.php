<?php

/**
 * ============================================================================
 * IQArchive v2 — AccreditationStageHistory Model
 * ============================================================================
 * File: app/Models/AccreditationStageHistory.php
 * Responsibility: State machine transition audit log for all 9 accreditation stages.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccreditationStageHistory extends Model
{
    use HasFactory;

    protected $table = 'accreditation_stage_histories';

    public $timestamps = false;

    protected $fillable = [
        'accreditation_id',
        'from_stage',
        'to_stage',
        'initiated_by',
        'approved_by',
        'remarks',
        'transitioned_at',
    ];

    protected function casts(): array
    {
        return [
            'from_stage' => 'integer',
            'to_stage' => 'integer',
            'transitioned_at' => 'datetime',
        ];
    }

    public function accreditation(): BelongsTo
    {
        return $this->belongsTo(Accreditation::class);
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
