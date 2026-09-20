<?php

/**
 * ============================================================================
 * IQArchive v2 — College Scoped Global Eloquent Scope
 * ============================================================================
 * File: app/Models/Scopes/CollegeScoped.php
 * Responsibility: Enforces multi-tenant isolation by automatically restricting
 *                 database queries to the authenticated user's college_id.
 * Architecture: Model Layer (Global Scope)
 * Security Context: Rule 2: Multi-tenancy scoping: Every database query must
 *                   scope by college_id. Only university-wide roles bypass this.
 * ============================================================================
 */

namespace App\Models\Scopes;

use App\Services\MultiTenantScopeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CollegeScoped implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (! Auth::check()) {
            return;
        }

        $user = Auth::user();
        $scopeService = app(MultiTenantScopeService::class);

        // Security Reasoning: University-wide roles (System Admin, IQA Staff, BU Executive)
        // must inspect all 10 BU colleges for institutional compliance and accreditation oversight.
        if ($scopeService->isUniversityWideUser($user)) {
            return;
        }

        // College-locked users (Dean, Task Force Member, Faculty) can ONLY access records belonging to their college.
        $collegeId = $scopeService->getEnforcedCollegeId($user);

        if ($collegeId !== null) {
            $builder->where($model->qualifyColumn('college_id'), $collegeId);
        } else {
            // Fail-safe deny: If user is authenticated but has no college and no university-wide role, return zero results
            $builder->whereRaw('1 = 0');
        }
    }
}
