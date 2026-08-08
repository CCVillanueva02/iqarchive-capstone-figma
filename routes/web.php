<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SubmissionController;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Landing gateway: redirects to the appropriate role-specific homepage
    Route::get('dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'iqa-admin') {
            return redirect()->route('dashboard.iqa-admin');
        }
        if ($role === 'college-head') {
            return redirect()->route('dashboard.program-chair');
        }
        if ($role === 'accreditor') {
            return redirect()->route('submissions.accreditor');
        }
        if ($role === 'university-administrator') {
            return redirect()->route('analytics.university-administrator');
        }
        return redirect()->route('dashboard.' . $role);
    })->name('dashboard');

    // Accreditor explicit route mapping (no sidebar, no header/footer, loads submission view)
    Route::get("roles/accreditor/submission", function () {
        if (auth()->user()->role !== 'accreditor') {
            abort(403, 'Unauthorized action.');
        }
        return view("pages.roles.accreditor.submission");
    })->name("submissions.accreditor");

    Route::get("roles/accreditor/dashboard", function () {
        if (auth()->user()->role !== 'accreditor') {
            abort(403, 'Unauthorized action.');
        }
        return redirect()->route('submissions.accreditor');
    })->name("dashboard.accreditor");

    // University Administrator explicit route mapping (analytics as landing page)
    Route::get("roles/university-administrator/analytics", function () {
        if (auth()->user()->role !== 'university-administrator') {
            abort(403, 'Unauthorized action.');
        }
        return view("pages.roles.university-administrator.analytics");
    })->name("analytics.university-administrator");

    Route::get("roles/university-administrator/dashboard", function () {
        if (auth()->user()->role !== 'university-administrator') {
            abort(403, 'Unauthorized action.');
        }
        return redirect()->route('analytics.university-administrator');
    })->name("dashboard.university-administrator");

    Route::get("roles/university-administrator/reports", function () {
        if (auth()->user()->role !== 'university-administrator') {
            abort(403, 'Unauthorized action.');
        }
        return view("pages.roles.university-administrator.reports");
    })->name("reports.university-administrator");

    // Active role switcher route for multi-role users
    Route::post('switch-role', function (\Illuminate\Http\Request $request) {
        $role = $request->input('role');
        $user = auth()->user();

        if ($user && $user->hasRole($role)) {
            session(['active_role' => $role]);
            return redirect()->route('dashboard')->with('status', 'Switched active role to ' . ucwords(str_replace('-', ' ', $role)));
        }

        return back()->with('error', 'Unauthorized role switch request.');
    })->name('switch-role');

    $roles = [
        'system-administrator',
        'iqa-admin',
        'iqa-member',
        'task-force',
        'task-force-member',
        'program-chair',
    ];

    foreach ($roles as $role) {
        Route::get("roles/{$role}/dashboard", function () use ($role) {
            $user = auth()->user();
            if (!$user->hasRole($role) && !($role === 'program-chair' && $user->role === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            if ($user->hasRole($role)) {
                session(['active_role' => $role]);
            }
            if (!view()->exists("pages.roles.{$role}.dashboard")) {
                return view("pages.roles.task-force.dashboard");
            }
            return view("pages.roles.{$role}.dashboard");
        })->name("dashboard.{$role}");

        Route::get("roles/{$role}/documents", function () use ($role) {
            $user = auth()->user();
            if (!$user->hasRole($role) && !($role === 'program-chair' && $user->role === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            if ($user->hasRole($role)) {
                session(['active_role' => $role]);
            }
            return view('pages.documents.index');
        })->name("documents.{$role}");

        Route::get("roles/{$role}/submissions", function () use ($role) {
            $user = auth()->user();
            if (!$user->hasRole($role) && !($role === 'program-chair' && $user->role === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            if ($user->hasRole($role)) {
                session(['active_role' => $role]);
            }
            return view('pages.workspace.placeholder', [
                'title' => 'Submissions',
                'roleName' => ucwords(str_replace('-', ' ', $role)),
            ]);
        })->name("submissions.{$role}");

        Route::get("roles/{$role}/reports", function () use ($role) {
            $user = auth()->user();
            if (!$user->hasRole($role) && !($role === 'program-chair' && $user->role === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            if ($user->hasRole($role)) {
                session(['active_role' => $role]);
            }
            return view('pages.workspace.placeholder', [
                'title' => 'Reports',
                'roleName' => ucwords(str_replace('-', ' ', $role)),
            ]);
        })->name("reports.{$role}");

        Route::get("roles/{$role}/settings", function () use ($role) {
            $user = auth()->user();
            if (!$user->hasRole($role) && !($role === 'program-chair' && $user->role === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            if ($user->hasRole($role)) {
                session(['active_role' => $role]);
            }
            return view('pages.workspace.placeholder', [
                'title' => 'Settings',
                'roleName' => ucwords(str_replace('-', ' ', $role)),
            ]);
        })->name("settings.{$role}");
    }

    Route::get('roles/iqa-admin/audit-trail', function () {
        if (auth()->user()->role !== 'iqa-admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.roles.iqa-admin.audit-trail');
    })->name('audit-trail.iqa-admin');

    Route::get('roles/iqa-admin/accounts', \App\Livewire\IqaAdmin\Accounts::class)
        ->name('accounts.iqa-admin');

    Route::get('roles/system-administrator/accounts', \App\Livewire\SystemAdministrator\Accounts::class)
        ->name('accounts.system-administrator');

    // Task Force Management Overview & Create Modal (Accessible to authenticated roles)
    Route::get('task-forces', \App\Livewire\TaskForce\TaskForceOverview::class)
        ->name('task-forces.index');

    // Document Submission Store (Program Chair / College Head / Task Force / IQA Member)
    Route::post('submissions/store', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::post('submissions/{id}/review', [SubmissionController::class, 'review'])->name('submissions.review');
    Route::get('documents/{id}/serve', [SubmissionController::class, 'serveDocument'])->name('documents.serve');

    // Program Management & Accreditation API routes
    Route::get('api/programs', [\App\Http\Controllers\ProgramController::class, 'index'])->name('api.programs.index');
    Route::post('api/programs', [\App\Http\Controllers\ProgramController::class, 'store'])->name('api.programs.store');
    Route::get('api/colleges', [\App\Http\Controllers\ProgramController::class, 'getColleges'])->name('api.colleges.index');

    // Document Categories & Common Documents API routes
    Route::get('api/categories', [\App\Http\Controllers\DocumentCategoryController::class, 'index'])->name('api.categories.index');
    Route::post('api/categories', [\App\Http\Controllers\DocumentCategoryController::class, 'store'])->name('api.categories.store');
    Route::get('api/common-documents', [\App\Http\Controllers\DocumentCategoryController::class, 'getDocuments'])->name('api.common-documents.index');
    Route::post('api/common-documents', [\App\Http\Controllers\DocumentCategoryController::class, 'storeDocument'])->name('api.common-documents.store');
    Route::delete('api/common-documents/{id}', [\App\Http\Controllers\DocumentCategoryController::class, 'destroyDocument'])->name('api.common-documents.destroy');
    Route::get('documents/{id}/view', [\App\Http\Controllers\DocumentCategoryController::class, 'serveDocument'])->name('documents.serve');

    // Self-Survey API routes (Institutional Accreditation)
    Route::get('api/self-survey/areas', [\App\Http\Controllers\SelfSurveyController::class, 'getAreas'])->name('api.self-survey.areas');
    Route::get('api/self-survey/ratings', [\App\Http\Controllers\SelfSurveyController::class, 'getRatings'])->name('api.self-survey.ratings');
    Route::post('api/self-survey/ratings', [\App\Http\Controllers\SelfSurveyController::class, 'saveRating'])->name('api.self-survey.ratings.save');
    Route::post('api/self-survey/best-practices', [\App\Http\Controllers\SelfSurveyController::class, 'saveBestPractices'])->name('api.self-survey.best-practices');
});

if (app()->environment('local')) {
    // Render the beautiful dev dashboard
    Route::get('/dev', function () {
        return view('dev-login');
    })->name('dev.index');

    // Handle instant role login
    Route::get('/dev/login/{role}', function ($role) {
        $email = match ($role) {
            'system-administrator' => 'sysadmin@example.com',
            'iqa-admin' => 'iqaadmin@example.com',
            'iqa-member' => 'iqamember@example.com',
            'iqa-member-multi' => 'iqamember-multirole@example.com',
            'accreditor' => 'accreditor@example.com',
            'university-administrator' => 'buadmin@example.com',
            'task-force' => 'taskforce@example.com',
            'task-force-member' => 'taskforcemember@example.com',
            'dean' => 'dean@example.com',
            'dean-multi' => 'dean-multirole@example.com',
            'program-chair' => 'chair@example.com',
            'program-chair-multi' => 'chair-multirole@example.com',
            default => abort(404),
        };

        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => ucwords(str_replace('-', ' ', $role)),
                'email' => $email,
                'role' => $role === 'dean' ? 'college-head' : $role,
                'password' => bcrypt('password'),
            ]);
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    })->name('dev.login');

    // Dev helper to switch user role in session
    Route::get('/dev/switch-role/{role}', function ($role) {
        session(['preview_role' => $role]);
        return back();
    })->name('dev.switch-role');
}

require __DIR__ . '/settings.php';
