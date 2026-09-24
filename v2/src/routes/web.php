<?php

/**
 * ============================================================================
 * IQArchive v2 — Master Web Routes
 * ============================================================================
 * File: routes/web.php
 * Responsibility: Maps web endpoints to controllers returning Inertia SPA views.
 * Security Context: Role-specific route boundaries, Google OAuth redirect,
 *                   and multi-tenant scoping.
 * ============================================================================
 */

use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevAuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExecutiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Authentication & Landing Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/google/redirect', [AuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Local Developer Sandbox (Strictly disabled in staging & production)
if (app()->environment(['local', 'testing'])) {
    Route::get('/dev', [DevAuthController::class, 'index'])->name('dev.index');
    Route::get('/dev/login/{role}', [DevAuthController::class, 'login'])->name('dev.login');
}

// Main Portal & Account Settings
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return app(DashboardController::class)->index($request);
    }

    return app(AuthController::class)->login($request);
})->name('dashboard');

Route::get('/settings', [AuthController::class, 'settings'])->name('account.settings');

// Role-Scoped Workspaces
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::prefix('iqa')->group(function () {
    Route::get('/', [AccreditationController::class, 'iqaIndex'])->name('iqa.dashboard');
});

Route::prefix('dean')->group(function () {
    Route::get('/', [AccreditationController::class, 'deanIndex'])->name('dean.dashboard');
});

Route::prefix('task-force')->group(function () {
    Route::get('/', [AccreditationController::class, 'taskForceIndex'])->name('taskforce.dashboard');
});

Route::prefix('internal-accreditor')->group(function () {
    Route::get('/', [AccreditationController::class, 'internalAccreditorIndex'])->name('internal-accreditor.dashboard');
});

Route::prefix('executive')->group(function () {
    Route::get('/', [ExecutiveController::class, 'index'])->name('executive.dashboard');
});

Route::prefix('external-accreditor')->group(function () {
    Route::get('/', [AccreditationController::class, 'externalAccreditorIndex'])->name('external-accreditor.dashboard');
});

// Document Management
Route::middleware('auth')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents/common', [DocumentController::class, 'storeCommon'])->name('documents.store.common');
    Route::post('/documents/offices', [DocumentController::class, 'storeOffice'])->name('documents.store.office');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});

