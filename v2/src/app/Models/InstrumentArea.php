<?php

/**
 * ============================================================================
 * IQArchive v2 — InstrumentArea Model
 * ============================================================================
 * File: app/Models/InstrumentArea.php
 * Responsibility: The 10 standard accreditation areas of an AACCUP instrument.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentArea extends Model
{
    use HasFactory;

    protected $table = 'instrument_areas';

    public const UPDATED_AT = null;

    protected $fillable = [
        'instrument_id',
        'area_number',
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'area_number' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(InstrumentParameter::class);
    }

    public function taskForceMembers(): HasMany
    {
        return $this->hasMany(TaskForceMember::class);
    }
}
