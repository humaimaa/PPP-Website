<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\LeadershipMessageController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// ==================== ADMIN AUTH ROUTES ====================
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');

// ==================== PROTECTED ADMIN ROUTES ====================
Route::middleware(['admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile Management
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile');
    Route::put('/profile', [LoginController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [LoginController::class, 'updatePassword'])->name('profile.password');
    
    // ==================== project MANAGEMENT ====================
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [DashboardController::class, 'projectsIndex'])->name('index');
        Route::get('/add', [DashboardController::class, 'projectsCreate'])->name('add');
        Route::post('/', [DashboardController::class, 'projectsStore'])->name('store');
        Route::get('/{id}', [DashboardController::class, 'projectsShow'])->name('show');
        Route::get('/{id}/edit', [DashboardController::class, 'projectsEdit'])->name('edit');
        Route::put('/{id}', [DashboardController::class, 'projectsUpdate'])->name('update');
        Route::delete('/{id}', [DashboardController::class, 'projectsDestroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [DashboardController::class, 'projectsToggleStatus'])->name('toggle-status');
    });

    // ==================== NEWS/UPDATES MANAGEMENT ====================
    Route::prefix('updates')->name('updates.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/add', [NewsController::class, 'create'])->name('add');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::get('/{id}', [NewsController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('/{id}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{id}', [NewsController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [NewsController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ==================== TENDERS MANAGEMENT ====================
    Route::prefix('tenders')->name('tenders.')->group(function () {
        Route::get('/', [TenderController::class, 'index'])->name('index');
        Route::get('/add', [TenderController::class, 'create'])->name('add');
        Route::post('/', [TenderController::class, 'store'])->name('store');
        Route::get('/{id}', [TenderController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TenderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TenderController::class, 'update'])->name('update');
        Route::delete('/{id}', [TenderController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/extend', [TenderController::class, 'extendDate'])->name('extend');
        Route::post('/{id}/archive', [TenderController::class, 'archive'])->name('archive');
        Route::post('/{id}/unarchive', [TenderController::class, 'unarchive'])->name('unarchive');
    });
    
    // ==================== DOWNLOADS/DOCUMENTS MANAGEMENT ====================
    Route::prefix('downloads')->name('downloads.')->group(function () {
        Route::get('/', [DownloadController::class, 'index'])->name('index');
        Route::get('/add', [DownloadController::class, 'create'])->name('add');
        Route::post('/', [DownloadController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DownloadController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DownloadController::class, 'update'])->name('update');
        Route::delete('/{id}', [DownloadController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [DownloadController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ==================== GALLERY MANAGEMENT ====================
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/add', [GalleryController::class, 'create'])->name('add');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{id}', [GalleryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{id}', [GalleryController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/images', [GalleryController::class, 'storeImages'])->name('images.store');
        Route::delete('/images/{id}', [GalleryController::class, 'destroyImage'])->name('images.destroy');
        Route::post('/images/{id}/thumbnail', [GalleryController::class, 'setThumbnail'])->name('images.thumbnail');
        Route::post('/{id}/publish', [GalleryController::class, 'publish'])->name('publish');
        Route::post('/{id}/unpublish', [GalleryController::class, 'unpublish'])->name('unpublish');
    });
    
    // ==================== EVENTS MANAGEMENT ====================
    Route::resource('events', EventController::class);
    Route::post('/events/{event}/gallery', [EventController::class, 'storeGallery'])->name('events.gallery.store');
    Route::delete('/events/gallery/{id}', [EventController::class, 'destroyGallery'])->name('events.gallery.destroy');
    Route::post('/events/{event}/gallery/{id}/thumbnail', [EventController::class, 'setGalleryThumbnail'])->name('events.gallery.thumbnail');
    
    // ==================== SECTORS MANAGEMENT ====================
    Route::resource('sectors', SectorController::class);
    Route::post('/sectors/{sector}/toggle-status', [SectorController::class, 'toggleStatus'])->name('sectors.toggle-status');
    
    // ==================== DESIGNATIONS MANAGEMENT ====================
    Route::resource('designations', DesignationController::class)->except(['show']);
    Route::post('/designations/{designation}/toggle-status', [DesignationController::class, 'toggleStatus'])->name('designations.toggle-status');
    
    // ==================== TEAM MANAGEMENT ====================
    Route::resource('team', TeamController::class);
    Route::post('/team/{team}/toggle-status', [TeamController::class, 'toggleStatus'])->name('team.toggle-status');
    Route::post('/team/reorder', [TeamController::class, 'reorder'])->name('team.reorder');
    
    // ==================== LEADERSHIP MESSAGES MANAGEMENT ====================
    Route::resource('leadership-messages', LeadershipMessageController::class);
    Route::post('/leadership-messages/{message}/toggle-status', [LeadershipMessageController::class, 'toggleStatus'])->name('leadership-messages.toggle-status');
    
    // ==================== SETTINGS ====================
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/logo', [DashboardController::class, 'uploadLogo'])->name('settings.logo');
    Route::post('/settings/favicon', [DashboardController::class, 'uploadFavicon'])->name('settings.favicon');
    
    // ==================== REGISTRATIONS ====================
    Route::get('/registrations', [DashboardController::class, 'registrations'])->name('registrations.index');
    Route::get('/registrations/{id}', [DashboardController::class, 'registrationShow'])->name('registrations.show');
    Route::delete('/registrations/{id}', [DashboardController::class, 'registrationDestroy'])->name('registrations.destroy');
    Route::post('/registrations/export', [DashboardController::class, 'exportRegistrations'])->name('registrations.export');
    
    // ==================== BULK ACTIONS ====================
    Route::post('/bulk-delete', [DashboardController::class, 'bulkDelete'])->name('bulk.delete');
    Route::post('/bulk-publish', [DashboardController::class, 'bulkPublish'])->name('bulk.publish');
    Route::post('/bulk-unpublish', [DashboardController::class, 'bulkUnpublish'])->name('bulk.unpublish');
    
    // ==================== AJAX/API ROUTES FOR ADMIN ====================
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('/upload-temp', [DashboardController::class, 'uploadTemp'])->name('upload.temp');
        Route::delete('/delete-temp', [DashboardController::class, 'deleteTemp'])->name('delete.temp');
        Route::get('/search', [DashboardController::class, 'globalSearch'])->name('search');
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');
    });
});

