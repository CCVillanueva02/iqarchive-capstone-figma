<?php

/**
 * ============================================================================
 * IQArchive v2 — AccreditationDocumentLink Model
 * ============================================================================
 * File: app/Models/AccreditationDocumentLink.php
 * Responsibility: Many-to-many junction linking uploaded documents to compliance requirements.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccreditationDocumentLink extends Model
{
    use HasFactory;

    protected $table = 'accreditation_document_links';

    public const UPDATED_AT = null;

    protected $fillable = [
        'compliance_requirement_id',
        'document_id',
        'relevance_notes',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function complianceRequirement(): BelongsTo
    {
        return $this->belongsTo(ComplianceRequirement::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
