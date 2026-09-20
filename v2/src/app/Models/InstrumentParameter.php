<?php

/**
 * ============================================================================
 * IQArchive v2 — InstrumentParameter Model
 * ============================================================================
 * File: app/Models/InstrumentParameter.php
 * Responsibility: Sub-sections (Parameters A-J) within an accreditation area.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentParameter extends Model
{
    use HasFactory;

    protected $table = 'instrument_parameters';

    public const UPDATED_AT = null;

    protected $fillable = [
        'instrument_area_id',
        'parameter_letter',
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(InstrumentArea::class, 'instrument_area_id');
    }

    public function criteria(): HasMany
    {
        return $this->hasMany(InstrumentCriterion::class);
    }
}
