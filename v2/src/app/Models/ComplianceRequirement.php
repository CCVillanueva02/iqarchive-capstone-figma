<?php

/**
 * ============================================================================
 * IQArchive v2 — ComplianceRequirement Model
 * ============================================================================
 * File: app/Models/ComplianceRequirement.php
 * Responsibility: Compliance checklist item for each criterion in an active survey.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComplianceRequirement extends Model
{
    use HasFactory;

    protected $table = 'compliance_requirements';

    public const UPDATED_AT = null;

    protected $fillable = [
        'accreditation_id',
        'instrument_criteria_id',
        'status',
        'due_date',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function accreditation(): BelongsTo
    {
        return $this->belongsTo(Accreditation::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(InstrumentCriterion::class, 'instrument_criteria_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ComplianceComment::class);
    }

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'accreditation_document_links')
            ->withPivot(['id', 'relevance_notes', 'created_at']);
    }

    public function documentLinks(): HasMany
    {
        return $this->hasMany(AccreditationDocumentLink::class);
    }
}
