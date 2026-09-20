<?php

/**
 * ============================================================================
 * IQArchive v2 — DocumentReview Model
 * ============================================================================
 * File: app/Models/DocumentReview.php
 * Responsibility: Two-tier approval records (Dean gate, IQA consolidation gate, and Internal Accreditor notes).
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentReview extends Model
{
    use HasFactory;

    protected $table = 'document_reviews';

    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'user_id',
        'review_stage',
        'decision',
        'remarks',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
