<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Landing gateway: redirects to the appropriate role-specific homepage
    Route::get('dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'iqa-admin') {
            return redirect()->route('documents.iqa-admin');
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
        'faculty-member',
    ];

    foreach ($roles as $role) {
        Route::get("roles/{$role}/dashboard", function () use ($role) {
            if ($role !== auth()->user()->role) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.dashboard");
        })->name("dashboard.{$role}");

        Route::get("roles/{$role}/documents", function () use ($role) {
            if ($role !== auth()->user()->role) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.documents");
        })->name("documents.{$role}");

        Route::get("roles/{$role}/submissions", function () use ($role) {
            if ($role !== auth()->user()->role) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.submissions");
        })->name("submissions.{$role}");

        Route::get("roles/{$role}/reports", function () use ($role) {
            if ($role !== auth()->user()->role) {
                abort(403, 'Unauthorized action.');
            }
            return view("pages.roles.{$role}.reports");
        })->name("reports.{$role}");

        Route::get("roles/{$role}/settings", function () use ($role) {
            if ($role !== auth()->user()->role) {
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

// Dev helper to switch user role in session
Route::get('/dev/switch-role/{role}', function ($role) {
    session(['preview_role' => $role]);
    return back();
})->name('dev.switch-role');

if (app()->environment('local')) {
    Route::get('/dev/preview-auth/{page}', function ($page) {
        if ($page === 'confirm-password') {
            return view('pages.auth.confirm-password');
        }
        if ($page === 'two-factor-challenge') {
            return view('pages.auth.two-factor-challenge');
        }
        if ($page === 'verify-email') {
            return view('pages.auth.verify-email');
        }
        if ($page === 'reset-password') {
            return view('pages.auth.reset-password');
        }
        abort(404);
    })->name('dev.preview-auth');
}

require __DIR__.'/settings.php';
