<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // Custom mock routes for frontend objectives
    Route::view('admin/users', 'pages.admin.users')->name('admin.users');
    Route::view('documents', 'pages.documents.index')->name('documents.index');
    Route::view('admin/audit-logs', 'pages.admin.audit-logs')->name('admin.audit-logs');
});

// Dev helper to switch user role in session
Route::get('/dev/switch-role/{role}', function ($role) {
    session(['preview_role' => $role]);
    return back();
})->name('dev.switch-role');

require __DIR__.'/settings.php';
