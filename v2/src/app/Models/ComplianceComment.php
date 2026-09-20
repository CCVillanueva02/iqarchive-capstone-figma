<?php

/**
 * ============================================================================
 * IQArchive v2 — ComplianceComment Model
 * ============================================================================
 * File: app/Models/ComplianceComment.php
 * Responsibility: Advisory commentary and gap notes left on criteria.
 * Architecture: Model Layer (3NF Schema)
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplianceComment extends Model
{
    use HasFactory;

    protected $table = 'compliance_comments';

    public const UPDATED_AT = null;

    protected $fillable = [
        'compliance_requirement_id',
        'user_id',
        'comment_type',
        'comment_text',
        'is_resolved',
    ];

    protected function casts(): array
    {
        return [
            'is_resolved' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function complianceRequirement(): BelongsTo
    {
        return $this->belongsTo(ComplianceRequirement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
