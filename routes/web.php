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
Route::get('/updates', [PageController::class, 'updatesIndex'])->name('updates.index');

Route::get('/updates/{id}', [PageController::class, 'updatesShow'])->name('updates.show');

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



// ==================== ADMIN ROUTES ====================
// Admin dashboard
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
 //project routes
Route::get('/admin/projects/add', function () {
    return view('admin.projects.add');
})->name('admin.projects.add');

Route::get('/admin/projects', function () {
    return view('admin.projects.index');
})->name('admin.projects.index');

Route::get('/admin/projects/{id}/edit', function ($id) {
            return view('admin.projects.edit', ['id' => $id]);
        })->name('admin.projects.edit');

Route::get('/admin/updates/add', function () {
    return view('admin.updates.add');
})->name('admin.updates.add');

Route::get('/admin/updates', function () {
    return view('admin.updates.index');
})->name('admin.updates.index');

Route::get('/admin/updates/{id}/edit', function ($id) {
            return view('admin.updates.edit', ['id' => $id]);
        })->name('admin.updates.edit');

//tenders routes
Route::get('/admin/tenders/add', function () {
    return view('admin.tenders.add');
})->name('admin.tenders.add');

Route::get('/admin/tenders', function () {
    return view('admin.tenders.index');
})->name('admin.tenders.index');

Route::get('/admin/tenders/{id}/edit', function ($id) {
            return view('admin.tenders.edit', ['id' => $id]);
        })->name('admin.tenders.edit');

//dowloads routes
Route::get('/admin/downloads/add', function () {
    return view('admin.downloads.add');
})->name('admin.downloads.add');

Route::get('/admin/downloads', function () {
    return view('admin.downloads.index');
})->name('admin.downloads.index');

Route::get('/admin/downloads/{id}/edit', function ($id) {
            return view('admin.downloads.edit', ['id' => $id]);
        })->name('admin.downloads.edit');


//gallery routes
Route::get('/admin/gallery/add', function () {
    return view('admin.gallery.add');
})->name('admin.gallery.add');

Route::get('/admin/gallery', function () {
    return view('admin.gallery.index');
})->name('admin.gallery.index');

Route::get('/admin/gallery/{id}/edit', function ($id) {
            return view('admin.gallery.edit', ['id' => $id]);
        })->name('admin.gallery.edit');