<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\User\ResourceController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\TenderController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MediaroomController;
use App\Http\Controllers\User\ProjectController;

// ==================== PUBLIC ROUTES ====================

// Homepage
Route::get('/', [HomeController::class, 'home'])->name('home');

// Pitchbook page
Route::get('/pitchbook', [PageController::class, 'pitchbook'])->name('pitchbook');

// About pages - simplified route structure
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/', [AboutController::class, 'about'])->name('index');
    Route::get('/functions', [AboutController::class, 'function'])->name('functions');
    Route::get('/message', [AboutController::class, 'message'])->name('message');
    Route::get('/mission-vision', [AboutController::class, 'missionVision'])->name('mission-vision');
    Route::get('/team', [AboutController::class, 'team'])->name('team');
    Route::get('/organogram', [AboutController::class, 'organogram'])->name('organogram');
});

// Tenders page (with optional section parameter)
Route::get('/tenders/{section?}', [TenderController::class, 'tenders'])->name('tenders');

// Projects page (with optional status parameter)
Route::get('/projects/{status?}', [ProjectController::class, 'index'])->name('projects.index');

// Individual project detail page
Route::get('/project/{id}', [ProjectController::class, 'show'])->name('projects.show');

// Resource Center (Downloads) with optional section parameter
Route::get('/resource-center/{section?}', [ResourceController::class, 'downloads'])->name('resource.center');

// Media Room Routes
Route::prefix('media-room')->name('media.room.')->group(function () {
    Route::get('/events', [MediaroomController::class, 'eventsIndex'])->name('events');
    Route::get('/updates', [MediaroomController::class, 'updatesIndex'])->name('updates');
    Route::get('/updates/{id}', [MediaroomController::class, 'updatesShow'])->name('updates.show');
    Route::get('/events/gallery/{id}', [MediaroomController::class, 'eventGallery'])->name('events.gallery');
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