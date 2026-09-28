<?php

/**
 * ============================================================================
 * IQArchive v2 — Audit Log & Compliance Ledger Controller
 * ============================================================================
 * File: app/Http/Controllers/AuditLogController.php
 * Responsibility: Query and display immutable audit trail entries with
 *                 multi-tenant college scoping, search, and metric rollups.
 * Architecture: Controller Layer (Controller -> Service -> Model)
 * Security Context: Strictly gated to System Admin, IQA Staff, and College Deans.
 * ============================================================================
 */

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\College;
use App\Services\MultiTenantScopeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuditLogController extends Controller
{
    /**
     * Display the filterable audit trail interface.
     *
     * Security Reasoning: Audit trails contain sensitive operational and security
     * events. Only university administrators (System Admin, IQA) and College Deans
     * (scoped to their college) are permitted to inspect compliance records.
     */
    public function index(Request $request, MultiTenantScopeService $scopeService): Response
    {
        $user = $request->user();

        // Security Gate: Ensure user has an authorized auditing role
        $authorizedRoles = ['system_admin', 'iqa_staff', 'iqa_member', 'college_dean'];
        if (! $user || ! $user->hasRole($authorizedRoles)) {
            abort(403, 'Unauthorized access to institutional audit logs.');
        }

        $isUniversityWide = $scopeService->isUniversityWideUser($user);
        $userCollegeId = $scopeService->isCollegeScopedUser($user) ? $user->college_id : null;

        // Base query with eager loading to prevent N+1 issues
        $query = $isUniversityWide
            ? AuditLog::withoutGlobalScopes()->with(['user:id,name,email', 'college:id,name,code'])
            : AuditLog::with(['user:id,name,email', 'college:id,name,code']);

        // Scope by college: Enforced strictly for college deans, optional filter for admins
        if (! $isUniversityWide && $userCollegeId) {
            $query->where('college_id', $userCollegeId);
        } elseif ($request->filled('college_id')) {
            $query->where('college_id', $request->input('college_id'));
        }

        // Search filter: Actor name/email, action string, IP, or target ID
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('target_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Category filter
        if ($category = $request->input('category')) {
            match ($category) {
                'auth' => $query->where('action', 'like', 'auth.%'),
                'document' => $query->where(function ($q) {
                    $q->where('action', 'like', 'document.%')
                        ->orWhere('action', 'like', 'evidence.%');
                }),
                'accreditation' => $query->where(function ($q) {
                    $q->where('action', 'like', 'accreditation.%')
                        ->orWhere('action', 'like', 'stage.%')
                        ->orWhere('action', 'like', 'instrument.%')
                        ->orWhere('action', 'like', 'task_force.%');
                }),
                'admin' => $query->where(function ($q) {
                    $q->where('action', 'like', 'admin.%')
                        ->orWhere('action', 'like', 'role.%')
                        ->orWhere('action', 'like', 'user.%');
                }),
                default => null,
            };
        }

        // Severity filter
        if ($severity = $request->input('severity')) {
            match ($severity) {
                'security', 'error' => $query->where(function ($q) {
                    $q->where('action', 'like', '%reject%')
                        ->orWhere('action', 'like', '%fail%')
                        ->orWhere('action', 'like', '%unauthorized%')
                        ->orWhere('action', 'like', '%deficit%');
                }),
                'warning' => $query->where(function ($q) {
                    $q->where('action', 'like', '%warning%')
                        ->orWhere('action', 'like', '%return%')
                        ->orWhere('action', 'like', '%elevat%');
                }),
                'success' => $query->where(function ($q) {
                    $q->where('action', 'like', '%approv%')
                        ->orWhere('action', 'like', '%upload%')
                        ->orWhere('action', 'like', '%endorse%')
                        ->orWhere('action', 'like', '%transition%');
                }),
                'info', 'normal' => $query->where(function ($q) {
                    $q->where('action', 'like', '%login%')
                        ->orWhere('action', 'like', '%view%')
                        ->orWhere('action', 'like', '%get%');
                }),
                default => null,
            };
        }

        // Date range filter
        if ($dateRange = $request->input('date_range')) {
            match ($dateRange) {
                'today' => $query->where('created_at', '>=', Carbon::today()),
                '7days' => $query->where('created_at', '>=', Carbon::now()->subDays(7)),
                '30days' => $query->where('created_at', '>=', Carbon::now()->subDays(30)),
                default => null,
            };
        }

        // Calculate KPI rollups based on scoped visibility
        $metricsBase = $isUniversityWide
            ? AuditLog::withoutGlobalScopes()
            : AuditLog::where('college_id', $userCollegeId);

        $metrics = [
            'total_today' => (clone $metricsBase)->where('created_at', '>=', Carbon::today())->count(),
            'document_mutations' => (clone $metricsBase)->where(function ($q) {
                $q->where('action', 'like', 'document.%')->orWhere('action', 'like', 'evidence.%');
            })->count(),
            'security_events' => (clone $metricsBase)->where(function ($q) {
                $q->where('action', 'like', 'auth.%')
                    ->orWhere('action', 'like', '%reject%')
                    ->orWhere('action', 'like', '%fail%');
            })->count(),
            'active_tenants' => (clone $metricsBase)->whereNotNull('college_id')
                ->where('created_at', '>=', Carbon::today())
                ->distinct('college_id')
                ->count('college_id'),
        ];

        // Paginated results with query strings preserved
        $auditLogs = $query->latest('id')->paginate(25)->withQueryString();

        // Available colleges for filtering
        $colleges = $isUniversityWide
            ? College::select('id', 'name', 'code')->orderBy('name')->get()
            : College::where('id', $userCollegeId)->select('id', 'name', 'code')->get();

        return Inertia::render('Admin/AuditLogs/Index', [
            'auditLogs' => $auditLogs,
            'colleges' => $colleges,
            'metrics' => $metrics,
            'filters' => [
                'search' => $request->input('search', ''),
                'category' => $request->input('category', ''),
                'college_id' => $request->input('college_id', ''),
                'severity' => $request->input('severity', ''),
                'date_range' => $request->input('date_range', ''),
            ],
            'isUniversityWide' => $isUniversityWide,
        ]);
    }
}
