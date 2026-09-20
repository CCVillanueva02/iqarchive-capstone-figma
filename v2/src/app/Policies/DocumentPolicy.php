<?php

/**
 * ============================================================================
 * IQArchive v2 — Document Authorization Policy
 * ============================================================================
 * File: app/Policies/DocumentPolicy.php
 * Responsibility: Authorizes viewing, uploading, endorsing, and reviewing evidence.
 * Architecture: Policy Layer (Server-Side Authorization Gate)
 * Security Context: Multi-tenant college isolation; two-tier review authorization.
 * ============================================================================
 */

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use App\Services\MultiTenantScopeService;

class DocumentPolicy
{
    public function __construct(
        protected MultiTenantScopeService $scopeService
    ) {}

    /**
     * Determine whether the user can view the document.
     *
     * Security Reasoning: University-wide roles can view any document; college faculty
     * and deans can only view documents scoped to their assigned college_id.
     */
    public function view(User $user, Document $document): bool
    {
        return $this->scopeService->canAccessModel($user, $document);
    }

    /**
     * Determine whether the user can endorse/approve the document at Tier 1 (Dean Gate).
     *
     * Security Reasoning: Only College Deans can approve evidence originating from their college.
     */
    public function endorse(User $user, Document $document): bool
    {
        if (! $user->hasRole('college_dean')) {
            return false;
        }

        return $this->scopeService->canAccessModel($user, $document);
    }

    /**
     * Determine whether the user can consolidate the document at Tier 2 (IQA Gate).
     *
     * Security Reasoning: Only IQA Staff can consolidate endorsed evidence into the master survey package.
     */
    public function consolidate(User $user, Document $document): bool
    {
        return $user->hasRole('iqa_staff') || $user->hasRole('iqa_member');
    }
}
