<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request and enforce RBAC authorization.
     *
     * Security Reasoning: Enforces role authorization using multi-role pivot relationships
     * ($user->hasRole()) rather than legacy single-role strings, preventing privilege
     * escalation and establishing single-point boundary control for role-scoped routes.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole($roles)) {
            abort(403, 'Unauthorized action.');
        }

        if (count($roles) === 1 && $user->hasRole($roles[0])) {
            session(['active_role' => $roles[0]]);
        }

        return $next($request);
    }
}
