<?php

/**
 * ============================================================================
 * IQArchive v2 — Role Model
 * ============================================================================
 * File: app/Models/Role.php
 * Responsibility: The 7 institutional roles defined in IQArchive RBAC.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: Role-based access control definitions.
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }
}
