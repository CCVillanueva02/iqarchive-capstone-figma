<?php

/**
 * ============================================================================
 * IQArchive v2 — DocumentCategory Model
 * ============================================================================
 * File: app/Models/DocumentCategory.php
 * Responsibility: Taxonomy classification for uploaded evidence.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $table = 'document_categories';

    public const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'scope',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'category_id');
    }
}
