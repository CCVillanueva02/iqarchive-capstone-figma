<?php

/**
 * ============================================================================
 * IQArchive v2 — College Model
 * ============================================================================
 * File: app/Models/College.php
 * Responsibility: Primary multi-tenant boundary representing a Bicol University academic unit.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: Multi-tenant root entity; college_id is mandatory on all scoped queries.
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'campus',
        'logo_image',
    ];

    protected $appends = [
        'logo_url',
    ];

    /**
     * Resolves absolute asset URL for the college logo.
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_image) {
            return asset('logos/' . $this->logo_image);
        }

        return asset('logos/' . $this->code . '.png');
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
