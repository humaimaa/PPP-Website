<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\LeadershipMessageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// ==================== ADMIN AUTH ROUTES ====================
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');

// ==================== PROTECTED ADMIN ROUTES ====================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // ==================== USER MANAGEMENT ====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'create'])->name('add');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        
        // Bulk actions
        Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-activate', [UserController::class, 'bulkActivate'])->name('bulk-activate');
        Route::post('/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('bulk-deactivate');
    });
    
    // ==================== ROLE MANAGEMENT ====================
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/add', [RoleController::class, 'create'])->name('add');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== USER MANAGEMENT ====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'create'])->name('add');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        
        // Bulk actions
        Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-activate', [UserController::class, 'bulkActivate'])->name('bulk-activate');
        Route::post('/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('bulk-deactivate');
    });
    
    // ==================== PROJECT MANAGEMENT ====================
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/add', [ProjectController::class, 'create'])->name('add');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::post('/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ==================== NEWS/UPDATES MANAGEMENT ====================
    Route::prefix('updates')->name('updates.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/add', [NewsController::class, 'create'])->name('add');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::get('/{news}', [NewsController::class, 'show'])->name('show');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        Route::post('/{news}/toggle-status', [NewsController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ==================== TENDERS MANAGEMENT ====================
    Route::prefix('tenders')->name('tenders.')->group(function () {
        Route::get('/', [TenderController::class, 'index'])->name('index');
        Route::get('/add', [TenderController::class, 'create'])->name('add');
        Route::post('/', [TenderController::class, 'store'])->name('store');
        Route::get('/{tender}', [TenderController::class, 'show'])->name('show');
        Route::get('/{tender}/edit', [TenderController::class, 'edit'])->name('edit');
        Route::put('/{tender}', [TenderController::class, 'update'])->name('update');
        Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy');
        Route::post('/{tender}/extend', [TenderController::class, 'extendDate'])->name('extend');
        Route::post('/{tender}/archive', [TenderController::class, 'archive'])->name('archive');
        Route::post('/{tender}/unarchive', [TenderController::class, 'unarchive'])->name('unarchive');
    });
    
    // ==================== DOWNLOADS/DOCUMENTS MANAGEMENT ====================
    Route::prefix('downloads')->name('downloads.')->group(function () {
        Route::get('/', [DownloadController::class, 'index'])->name('index');
        Route::get('/add', [DownloadController::class, 'create'])->name('add');
        Route::post('/', [DownloadController::class, 'store'])->name('store');
        Route::get('/{download}/edit', [DownloadController::class, 'edit'])->name('edit');
        Route::put('/{download}', [DownloadController::class, 'update'])->name('update');
        Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy');
        Route::post('/{download}/toggle-status', [DownloadController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ==================== GALLERY MANAGEMENT ====================
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/add', [GalleryController::class, 'create'])->name('add');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
        Route::post('/{gallery}/images', [GalleryController::class, 'storeImages'])->name('images.store');
        Route::delete('/images/{image}', [GalleryController::class, 'destroyImage'])->name('images.destroy');
        Route::post('/images/{image}/thumbnail', [GalleryController::class, 'setThumbnail'])->name('images.thumbnail');
        Route::post('/{gallery}/publish', [GalleryController::class, 'publish'])->name('publish');
        Route::post('/{gallery}/unpublish', [GalleryController::class, 'unpublish'])->name('unpublish');
    });
    
    // ==================== EVENTS MANAGEMENT ====================
    Route::resource('events', EventController::class);
    Route::post('/events/{event}/gallery', [EventController::class, 'storeGallery'])->name('events.gallery.store');
    Route::delete('/events/gallery/{gallery}', [EventController::class, 'destroyGallery'])->name('events.gallery.destroy');
    Route::post('/events/{event}/gallery/{gallery}/thumbnail', [EventController::class, 'setGalleryThumbnail'])->name('events.gallery.thumbnail');
    
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

// ==================== FALLBACK FOR ADMIN ====================
Route::fallback(function () {
    if (request()->is('admin/*')) {
        return redirect()->route('admin.dashboard');
    }
    abort(404);
});