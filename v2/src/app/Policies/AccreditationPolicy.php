<?php

/**
 * ============================================================================
 * IQArchive v2 — Accreditation Authorization Policy
 * ============================================================================
 * File: app/Policies/AccreditationPolicy.php
 * Responsibility: Authorizes accreditation state changes and survey package views.
 * Architecture: Policy Layer (Server-Side Authorization Gate)
 * Security Context: Only IQA Staff can transition stages; external accreditors
 *                   can only view during Stage 8+ (Submitted).
 * ============================================================================
 */

namespace App\Policies;

use App\Models\Accreditation;
use App\Models\User;
use App\Services\MultiTenantScopeService;

class AccreditationPolicy
{
    public function __construct(
        protected MultiTenantScopeService $scopeService
    ) {}

    /**
     * Determine whether the user can view the accreditation cycle.
     *
     * Security Reasoning: University-wide roles can view all accreditation cycles;
     * external accreditors can only view when submitted (Stage 8+);
     * college task forces can only view their college's programs.
     */
    public function view(User $user, Accreditation $accreditation): bool
    {
        if ($this->scopeService->isUniversityWideUser($user)) {
            return true;
        }

        if ($user->hasRole('external_accreditor')) {
            return (int) $accreditation->current_stage >= 8;
        }

        $programCollegeId = $accreditation->program?->college_id;

        return (int) $user->college_id === (int) $programCollegeId;
    }

    /**
     * Determine whether the user can advance the accreditation stage.
     *
     * Security Reasoning: Stage transitions are the exclusive authority of IQA Staff.
     */
    public function advanceStage(User $user): bool
    {
        return $user->hasRole('iqa_staff') || $user->hasRole('iqa_member');
    }
}
