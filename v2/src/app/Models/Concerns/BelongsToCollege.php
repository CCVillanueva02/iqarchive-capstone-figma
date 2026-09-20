<?php

/**
 * ============================================================================
 * IQArchive v2 — BelongsToCollege Model Concern
 * ============================================================================
 * File: app/Models/Concerns/BelongsToCollege.php
 * Responsibility: Trait that attaches the CollegeScoped global scope,
 *                 defines the college() BelongsTo relation, and automatically
 *                 populates college_id on model creation for college users.
 * Architecture: Model Layer (Concern / Trait)
 * Security Context: Multi-tenant boundary enforcement at the model level.
 * ============================================================================
 */

namespace App\Models\Concerns;

use App\Models\College;
use App\Models\Scopes\CollegeScoped;
use App\Services\MultiTenantScopeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait BelongsToCollege
{
    /**
     * Boot the BelongsToCollege trait.
     */
    protected static function bootBelongsToCollege(): void
    {
        static::addGlobalScope(new CollegeScoped());

        // Automatically assign tenant college_id on creation if not explicitly set
        static::creating(function ($model) {
            if (empty($model->college_id) && Auth::check()) {
                $user = Auth::user();
                $scopeService = app(MultiTenantScopeService::class);

                if ($scopeService->isCollegeScopedUser($user)) {
                    $model->college_id = $user->college_id;
                }
            }
        });
    }

    /**
     * Relationship to the tenant College.
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Local query scope to explicitly filter by a specific college.
     */
    public function scopeForCollege(Builder $query, int $collegeId): Builder
    {
        return $query->where($this->qualifyColumn('college_id'), $collegeId);
    }
}
