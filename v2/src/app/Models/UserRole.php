<?php

/**
 * ============================================================================
 * IQArchive v2 — UserRole Model
 * ============================================================================
 * File: app/Models/UserRole.php
 * Responsibility: Many-to-many role assignments for institutional users.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: Grants role capabilities to users.
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
