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

    protected $appends = [
        'severity',
        'category',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Compute event severity for badges and UI categorization.
     */
    public function getSeverityAttribute(): string
    {
        $action = strtolower($this->action ?? '');
        if (str_contains($action, 'reject') || str_contains($action, 'security') || str_contains($action, 'fail') || str_contains($action, 'unauthorized') || str_contains($action, 'deficit')) {
            return 'security';
        }
        if (str_contains($action, 'warning') || str_contains($action, 'return') || str_contains($action, 'elevat')) {
            return 'warning';
        }
        if (str_contains($action, 'approv') || str_contains($action, 'upload') || str_contains($action, 'endorse') || str_contains($action, 'complete') || str_contains($action, 'transition')) {
            return 'success';
        }
        return 'info';
    }

    /**
     * Compute event category group for filtering.
     */
    public function getCategoryAttribute(): string
    {
        $action = strtolower($this->action ?? '');
        if (str_starts_with($action, 'auth.') || str_contains($action, 'login') || str_contains($action, 'session')) {
            return 'auth';
        }
        if (str_starts_with($action, 'document.') || str_contains($action, 'evidence')) {
            return 'document';
        }
        if (str_starts_with($action, 'accreditation.') || str_contains($action, 'stage') || str_contains($action, 'instrument') || str_contains($action, 'task_force')) {
            return 'accreditation';
        }
        return 'admin';
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
