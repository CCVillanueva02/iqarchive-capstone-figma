<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'pages.development')->name('dashboard');
    Route::view('documents', 'pages.documents.index')->name('documents.index');
    
    // Stub views for other sections
    Route::view('submissions', 'pages.development')->name('submissions');
    Route::view('reports', 'pages.development')->name('reports');
    Route::view('settings', 'pages.development')->name('settings');
});

// Dev helper to switch user role in session
Route::get('/dev/switch-role/{role}', function ($role) {
    session(['preview_role' => $role]);
    return back();
})->name('dev.switch-role');

require __DIR__.'/settings.php';
