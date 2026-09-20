<?php

/**
 * ============================================================================
 * IQArchive v2 — Instrument Model
 * ============================================================================
 * File: app/Models/Instrument.php
 * Responsibility: Master evaluation tools released by AACCUP.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrument extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'code',
        'type',
        'version',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function areas(): HasMany
    {
        return $this->hasMany(InstrumentArea::class);
    }
}
