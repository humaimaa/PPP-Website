<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// ==================== PUBLIC ROUTES ====================

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Pitchbook page
Route::get('/pitchbook', [PageController::class, 'pitchbook'])->name('pitchbook');

// About page (with optional section parameter - default to 'overview')
Route::get('/about/{section?}', [PageController::class, 'about'])->name('about');

// Tenders page (with optional section parameter - default to 'active')
Route::get('/tenders/{section?}', [PageController::class, 'tenders'])->name('tenders');

// Projects page (with optional status parameter - default to 'all')
Route::get('/projects/{status?}', [PageController::class, 'projectsIndex'])->name('projects.index');

// Individual project detail page
Route::get('/project/{id}', [PageController::class, 'projectsShow'])->name('projects.show');

// Media Routes
Route::get('/news', [PageController::class, 'newsIndex'])->name('news.index');

Route::get('/news/{id}', [PageController::class, 'newsShow'])->name('news.show');

// Gallery Routes
Route::get('/gallery', [PageController::class, 'galleryIndex'])->name('gallery.index');

Route::get('/gallery/album/{id}', [PageController::class, 'galleryAlbum'])->name('gallery.album');

Route::get('/downloads', [PageController::class, 'downloads'])->name('media.downloads');

// API endpoint for downloading files
Route::post('/api/downloads/{id}', [PageController::class, 'apiDownloadFile'])->name('api.downloads.file');

// API endpoint for previewing files
Route::get('/api/downloads/{id}/preview', [PageController::class, 'apiPreviewFile'])->name('api.downloads.preview');

// Contact page
Route::get('/contact', [PageController::class, 'contact'])->name('contact');