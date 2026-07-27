<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Landing gateway: redirects to the appropriate role-specific homepage
    Route::get('dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'iqa-admin') {
            return redirect()->route('documents.iqa-admin');
        }
        if ($role === 'college-head') {
            return redirect()->route('dashboard.program-chair');
        }
        return redirect()->route('dashboard.' . $role);
    })->name('dashboard');

    $roles = [
        'system-administrator',
        'iqa-admin',
        'iqa-member',
        'accreditor',
        'university-administrator',
        'task-force',
        'program-chair',
    ];

    foreach ($roles as $role) {
        Route::get("roles/{$role}/dashboard", function () use ($role) {
            $userRole = auth()->user()->role;
            if ($role !== $userRole && !($role === 'program-chair' && $userRole === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.dashboard");
        })->name("dashboard.{$role}");

        Route::get("roles/{$role}/documents", function () use ($role) {
            $userRole = auth()->user()->role;
            if ($role !== $userRole && !($role === 'program-chair' && $userRole === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.documents");
        })->name("documents.{$role}");

        Route::get("roles/{$role}/submissions", function () use ($role) {
            $userRole = auth()->user()->role;
            if ($role !== $userRole && !($role === 'program-chair' && $userRole === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.submissions");
        })->name("submissions.{$role}");

        Route::get("roles/{$role}/reports", function () use ($role) {
            $userRole = auth()->user()->role;
            if ($role !== $userRole && !($role === 'program-chair' && $userRole === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.reports");
        })->name("reports.{$role}");

        Route::get("roles/{$role}/settings", function () use ($role) {
            $userRole = auth()->user()->role;
            if ($role !== $userRole && !($role === 'program-chair' && $userRole === 'college-head')) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.settings");
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
});

if (app()->environment('local')) {
    // Render the beautiful dev dashboard
    Route::get('/dev', function () {
        return view('dev-login');
    })->name('dev.index');

    // Handle instant role login
    Route::get('/dev/login/{role}', function ($role) {
        $email = match($role) {
            'system-administrator' => 'sysadmin@example.com',
            'iqa-admin' => 'iqaadmin@example.com',
            'iqa-member' => 'iqamember@example.com',
            'accreditor' => 'accreditor@example.com',
            'university-administrator' => 'buadmin@example.com',
            'task-force' => 'taskforce@example.com',
            'dean' => 'dean@example.com',
            'program-chair' => 'chair@example.com',
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
