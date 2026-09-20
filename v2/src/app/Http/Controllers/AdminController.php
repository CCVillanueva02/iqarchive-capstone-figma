<?php

/**
 * ============================================================================
 * IQArchive v2 — System Administration Controller
 * ============================================================================
 * File: app/Http/Controllers/AdminController.php
 * Responsibility: Manages user access, college & program records, and audit logs.
 * Architecture: Controller Layer
 * Security Context: Strictly gated to users with role == 'system_admin'.
 * ============================================================================
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    /**
     * Display the administration console.
     *
     * Security Reasoning: Access restricted strictly to System Administrators.
     * Content evaluations are prohibited; strictly operational governance.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Index');
    }
}
