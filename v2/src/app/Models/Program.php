<?php

/**
 * ============================================================================
 * IQArchive v2 — Program Model
 * ============================================================================
 * File: app/Models/Program.php
 * Responsibility: Academic degree program evaluated during AACCUP surveys.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: Multi-tenant scoped by college_id.
 * ============================================================================
 */

namespace App\Models;

use App\Models\Concerns\BelongsToCollege;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use BelongsToCollege, HasFactory;

    protected $fillable = [
        'college_id',
        'name',
        'code',
        'current_level',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function taskForces(): HasMany
    {
        return $this->hasMany(TaskForce::class);
    }

    public function accreditations(): HasMany
    {
        return $this->hasMany(Accreditation::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
