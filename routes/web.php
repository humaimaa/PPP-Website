<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

// ==================== PUBLIC ROUTES ====================

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Pitchbook page
Route::get('/pitchbook', [PageController::class, 'pitchbook'])->name('pitchbook');

// About pages - simplified route structure
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/', [PageController::class, 'about'])->name('index');
    Route::get('/functions', [PageController::class, 'function'])->name('functions');
    Route::get('/message', [PageController::class, 'message'])->name('message');
    Route::get('/mission-vision', [PageController::class, 'missionVision'])->name('mission-vision');
    Route::get('/team', [PageController::class, 'team'])->name('team');
    Route::get('/organogram', [PageController::class, 'organogram'])->name('organogram');
});

// Tenders page (with optional section parameter)
Route::get('/tenders/{section?}', [PageController::class, 'tenders'])->name('tenders');

// Projects page (with optional status parameter)
Route::get('/projects/{status?}', [PageController::class, 'projectsIndex'])->name('projects.index');

// Individual project detail page
Route::get('/project/{id}', [PageController::class, 'projectShow'])->name('projects.show');

// Resource Center (Downloads) with optional section parameter
Route::get('/resource-center/{section?}', [PageController::class, 'downloads'])->name('resource.center');

// Keep the old downloads route for backward compatibility (redirects to resource center)
Route::get('/downloads', function() {
    return redirect()->route('resource.center', 'legal-framework');
})->name('media.downloads');

// Media Room Routes
Route::prefix('media-room')->name('media.room.')->group(function () {
    Route::get('/events', [PageController::class, 'eventsIndex'])->name('events');
    Route::get('/updates', [PageController::class, 'updatesIndex'])->name('updates');
    Route::get('/updates/{id}', [PageController::class, 'updatesShow'])->name('updates.show');
    Route::get('/events/gallery/{id}', [PageController::class, 'eventGallery'])->name('events.gallery');
});

// API endpoint for downloading files
Route::post('/api/downloads/{id}', [PageController::class, 'apiDownloadFile'])->name('api.downloads.file');

// API endpoint for previewing files
Route::get('/api/downloads/{id}/preview', [PageController::class, 'apiPreviewFile'])->name('api.downloads.preview');

// Contact page
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
});