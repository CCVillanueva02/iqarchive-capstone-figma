<?php

/**
 * ============================================================================
 * IQArchive v2 — AuditLog Model
 * ============================================================================
 * File: app/Models/AuditLog.php
 * Responsibility: Append-only regulatory audit log for all system events.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: College-scoped tracking; immutable historical record.
 * ============================================================================
 */

namespace App\Models;

use App\Models\Concerns\BelongsToCollege;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use BelongsToCollege, HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'college_id',
        'user_id',
        'action',
        'target_type',
        'target_id',
        'ip_address',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }
}
