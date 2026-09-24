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
     * Determine whether the user can browse the document workspace.
     *
     * Security Reasoning: All authenticated university roles have workspace read access.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can upload to the Common Documents repository.
     *
     * Security Reasoning: Only IQA Staff and System Administrators can curate and
     * upload institutional policy documents to the university-wide Common Documents vault.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('system_admin')
            || $user->hasRole('iqa_staff')
            || $user->hasRole('iqa_member');
    }

    /**
     * Determine whether the user can view the document.
     *
     * Security Reasoning: Institutional common documents (college_id is null or visibility is univ)
     * are viewable across all colleges. College/program documents are strictly restricted to the user's college.
     */
    public function view(User $user, Document $document): bool
    {
        if ($document->college_id === null || $document->visibility === 'univ') {
            return true;
        }

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
