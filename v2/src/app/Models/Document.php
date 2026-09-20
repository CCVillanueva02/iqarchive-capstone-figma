<?php

/**
 * ============================================================================
 * IQArchive v2 — Document Model
 * ============================================================================
 * File: app/Models/Document.php
 * Responsibility: Master evidence registry containing file paths, cryptographic hashes, and multi-tenant scoping.
 * Architecture: Model Layer (3NF Schema)
 * Security Context: Strictly carries college_id foreign key for multi-tenant isolation.
 * ============================================================================
 */

namespace App\Models;

use App\Models\Concerns\BelongsToCollege;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    use BelongsToCollege, HasFactory;

    protected $table = 'documents';

    public const UPDATED_AT = null;

    protected $fillable = [
        'college_id',
        'program_id',
        'category_id',
        'user_id',
        'title',
        'original_filename',
        'file_path',
        'file_hash',
        'file_size_bytes',
        'mime_type',
        'status',
        'visibility',
    ];

    protected function casts(): array
    {
        return [
            'file_size_bytes' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ocrResult(): HasOne
    {
        return $this->hasOne(OcrResult::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DocumentReview::class);
    }

    public function complianceRequirements(): BelongsToMany
    {
        return $this->belongsToMany(ComplianceRequirement::class, 'accreditation_document_links')
            ->withPivot(['id', 'relevance_notes', 'created_at']);
    }

    public function documentLinks(): HasMany
    {
        return $this->hasMany(AccreditationDocumentLink::class);
    }
}
