<?php

/**
 * ============================================================================
 * IQArchive v2 — Multi-Tenancy College Scoping Service
 * ============================================================================
 * File: app/Services/MultiTenantScopeService.php
 * Responsibility: Centralized service to inspect user college boundaries,
 *                 enforce tenant isolation, and validate cross-tenant access.
 * Architecture: Service Layer (Security & Scoping)
 * Security Context: Enforces Rule 2 (Multi-tenancy scoping: Every query must
 *                   scope by college_id. Server-side authorization gates).
 * ============================================================================
 */

namespace App\Services;

use App\Models\College;
use App\Models\User;

class MultiTenantScopeService
{
    /**
     * University-wide roles authorized to view records across all 10 BU colleges.
     */
    private const UNIVERSITY_WIDE_ROLES = [
        'system_admin',
        'iqa_staff',
        'iqa_member', // backward-compatible alias
        'bu_executive',
    ];

    /**
     * Determine if user has university-wide unscoped access.
     *
     * Security Reasoning: System Admin, IQA Staff, and BU Executive require institutional
     * access to monitor, consolidate, and audit accreditation across all colleges.
     */
    public function isUniversityWideUser(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        // Check if user has any university-wide role assigned
        foreach (self::UNIVERSITY_WIDE_ROLES as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if user is locked to a specific college tenant.
     *
     * Security Reasoning: Deans, Task Force members, and college faculty must
     * never see another college's documents or preparatory evidence.
     */
    public function isCollegeScopedUser(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return ! $this->isUniversityWideUser($user) && $user->college_id !== null;
    }

    /**
     * Get the enforced college_id for querying resources.
     *
     * Returns null if user is authorized for university-wide view.
     */
    public function getEnforcedCollegeId(?User $user): ?int
    {
        if ($this->isUniversityWideUser($user)) {
            return null;
        }

        return $user?->college_id ? (int) $user->college_id : null;
    }

    /**
     * Determine if a user can access a specific college entity or ID.
     */
    public function canAccessCollege(?User $user, int|College $college): bool
    {
        if (! $user) {
            return false;
        }

        if ($this->isUniversityWideUser($user)) {
            return true;
        }

        $targetId = $college instanceof College ? (int) $college->id : (int) $college;

        return (int) $user->college_id === $targetId;
    }

    /**
     * Determine if a user can access a model scoped by college_id.
     */
    public function canAccessModel(?User $user, mixed $model): bool
    {
        if (! $user) {
            return false;
        }

        if ($this->isUniversityWideUser($user)) {
            return true;
        }

        $modelCollegeId = $model->college_id ?? null;

        if ($modelCollegeId === null) {
            return false;
        }

        return (int) $user->college_id === (int) $modelCollegeId;
    }
}
