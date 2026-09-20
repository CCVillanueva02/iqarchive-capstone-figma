<?php

/**
 * ============================================================================
 * IQArchive v2 — Program Authorization Policy
 * ============================================================================
 * File: app/Policies/ProgramPolicy.php
 * Responsibility: Authorizes academic program access and compliance inspection.
 * Architecture: Policy Layer (Server-Side Authorization Gate)
 * Security Context: Multi-tenant scoping per college_id; role-scoped gates.
 * ============================================================================
 */

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use App\Services\MultiTenantScopeService;

class ProgramPolicy
{
    public function __construct(
        protected MultiTenantScopeService $scopeService
    ) {}

    /**
     * Determine whether the user can view the program records.
     *
     * Security Reasoning: University-wide roles can view any academic program;
     * college users (Dean, Task Force, Faculty) are strictly confined to their own college.
     */
    public function view(User $user, Program $program): bool
    {
        return $this->scopeService->canAccessModel($user, $program);
    }
}
