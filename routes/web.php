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
});

// Dev helper to switch user role in session
Route::get('/dev/switch-role/{role}', function ($role) {
    session(['preview_role' => $role]);
    return back();
})->name('dev.switch-role');

require __DIR__.'/settings.php';
