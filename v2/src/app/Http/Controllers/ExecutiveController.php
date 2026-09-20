<?php

/**
 * ============================================================================
 * IQArchive v2 — BU Executive Controller
 * ============================================================================
 * File: app/Http/Controllers/ExecutiveController.php
 * Responsibility: Delivers macro compliance analytics, cross-college benchmarks,
 *                 and accreditation status to university leadership.
 * Architecture: Controller Layer (Read-Only Views)
 * Security Context: Access restricted to BU Executives; read-only operations.
 * ============================================================================
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExecutiveController extends Controller
{
    /**
     * Display the executive macro compliance overview.
     *
     * Security Reasoning: Provides university leadership read-only visibility into
     * accreditation readiness across all 10 colleges without modification authority.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('BuExec/Index');
    }
}
