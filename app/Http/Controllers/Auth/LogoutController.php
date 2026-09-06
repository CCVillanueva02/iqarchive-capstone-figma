<?php

/**
 * IQArchive Authentication: Session Logout Controller
 *
 * Architectural Role:
 * Handles authenticated session termination, security token invalidation,
 * and redirect to application root. Operates within the Google Workspace SSO
 * authentication architecture.
 *
 * Security & Auditing:
 * Calling Auth::guard('web')->logout() automatically dispatches the standard
 * Laravel Illuminate\Auth\Events\Logout event, which is intercepted by the
 * audit trail listener in AppServiceProvider to record the security audit log.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Terminate the authenticated user session and invalidate tokens.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // 1. Log out the authenticated web guard user (fires Logout event for audit trail)
        Auth::guard('web')->logout();

        // 2. Invalidate existing session data to prevent session fixation
        $request->session()->invalidate();

        // 3. Regenerate CSRF token for subsequent requests
        $request->session()->regenerateToken();

        // 4. Redirect user to home page
        return redirect('/');
    }
}
