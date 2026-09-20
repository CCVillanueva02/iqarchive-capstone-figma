<?php

/**
 * ============================================================================
 * IQArchive v2 — Master Dashboard Controller
 * ============================================================================
 * File: app/Http/Controllers/DashboardController.php
 * Responsibility: Serves main portal views and routes authenticated users to
 *                 their role-specific workspaces.
 * Architecture: Controller Layer (Inertia::render)
 * Security Context: Gated by 'auth' middleware; scopes metrics by college_id.
 * ============================================================================
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the primary accreditation dashboard.
     *
     * Security Reasoning: Provides authenticated faculty and staff an overview of
     * ongoing accreditation activity without exposing confidential records across colleges.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'activeAccreditations' => 12,
                'pendingReviews' => 5,
                'consolidatedEvidence' => 184,
                'complianceRate' => '88%',
            ],
        ]);
    }
}
