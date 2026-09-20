<?php

/**
 * ============================================================================
 * IQArchive v2 — OcrResult Model
 * ============================================================================
 * File: app/Models/OcrResult.php
 * Responsibility: Synchronous OCR extraction output (1:1 with documents).
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OcrResult extends Model
{
    use HasFactory;

    protected $table = 'ocr_results';

    public const UPDATED_AT = null;

    protected $fillable = [
        'document_id',
        'validated_by_user_id',
        'raw_text',
        'edited_text',
        'confidence_metrics',
        'pages_data',
        'average_confidence',
        'status',
        'duration_ms',
        'validated_at',
    ];

    protected function casts(): array
    {
        return [
            'confidence_metrics' => 'array',
            'pages_data' => 'array',
            'average_confidence' => 'decimal:4',
            'duration_ms' => 'integer',
            'validated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by_user_id');
    }
}
