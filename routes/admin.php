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

    // Dashboard - Accessible to all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Management - Accessible to all authenticated users
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ==================== USER MANAGEMENT ====================
    Route::prefix('users')->name('users.')->middleware('can:users.view')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'create'])->name('add')->middleware('can:users.create');
        Route::post('/', [UserController::class, 'store'])->name('store')->middleware('can:users.create');
        Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::post('/bulk-activate', [UserController::class, 'bulkActivate'])->name('bulk-activate')->middleware('can:users.toggle_status');
        Route::post('/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('bulk-deactivate')->middleware('can:users.toggle_status');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware('can:users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->middleware('can:users.edit');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->middleware('can:users.delete');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status')->middleware('can:users.toggle_status');
    });

    // ==================== ROLE MANAGEMENT ====================
    Route::prefix('roles')->name('roles.')->middleware('can:roles.view')->group(function () {

        Route::get('/', [RoleController::class, 'index'])
            ->name('index');

        Route::get('/add', [RoleController::class, 'create'])
            ->name('add')
            ->middleware('can:roles.create');

        Route::post('/', [RoleController::class, 'store'])
            ->name('store')
            ->middleware('can:roles.create');

        Route::post('/bulk-delete', [RoleController::class, 'bulkDelete'])
            ->name('bulk-delete')
            ->middleware('can:bulk.delete');

        Route::get('/{role}', [RoleController::class, 'show'])
            ->name('show');

        Route::get('/{role}/edit', [RoleController::class, 'edit'])
            ->name('edit')
            ->middleware('can:roles.edit');

        Route::put('/{role}', [RoleController::class, 'update']) ->name('update')
            ->middleware('can:roles.edit');

        Route::delete('/{role}', [RoleController::class, 'destroy'])
            ->name('destroy')
            ->middleware('can:roles.delete');
    });
    // ==================== PROJECT MANAGEMENT ====================
    Route::prefix('projects')->name('projects.')->middleware('can:projects.view')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/add', [ProjectController::class, 'create'])->name('add')->middleware('can:projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('can:projects.create');
        Route::post('/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit')->middleware('can:projects.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update')->middleware('can:projects.edit');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->middleware('can:projects.delete');
    });

    // ==================== NEWS/UPDATES MANAGEMENT ====================
    Route::prefix('updates')->name('updates.')->middleware('can:news.view')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/add', [NewsController::class, 'create'])->name('add')->middleware('can:news.create');
        Route::post('/', [NewsController::class, 'store'])->name('store')->middleware('can:news.create');
        Route::post('/bulk-delete', [NewsController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{news}', [NewsController::class, 'show'])->name('show');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit')->middleware('can:news.edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('update')->middleware('can:news.edit');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy')->middleware('can:news.delete');
    });

    // ==================== TENDERS MANAGEMENT ====================
    Route::prefix('tenders')->name('tenders.')->middleware('can:tenders.view')->group(function () {
        Route::get('/', [TenderController::class, 'index'])->name('index');
        Route::get('/add', [TenderController::class, 'create'])->name('add')->middleware('can:tenders.create');
        Route::post('/', [TenderController::class, 'store'])->name('store')->middleware('can:tenders.create');
        Route::post('/bulk-delete', [TenderController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{tender}', [TenderController::class, 'show'])->name('show');
        Route::get('/{tender}/edit', [TenderController::class, 'edit'])->name('edit')->middleware('can:tenders.edit');
        Route::put('/{tender}', [TenderController::class, 'update'])->name('update')->middleware('can:tenders.edit');
        Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy')->middleware('can:tenders.delete');
        Route::post('/{tender}/extend', [TenderController::class, 'extendDate'])->name('extend')->middleware('can:tenders.edit');
        Route::post('/{tender}/archive', [TenderController::class, 'archive'])->name('archive')->middleware('can:tenders.edit');
        Route::post('/{tender}/unarchive', [TenderController::class, 'unarchive'])->name('unarchive')->middleware('can:tenders.edit');
    });

    // ==================== DOWNLOADS/DOCUMENTS MANAGEMENT ====================
    Route::prefix('downloads')->name('downloads.')->middleware('can:downloads.view')->group(function () {
        Route::get('/', [DownloadController::class, 'index'])->name('index');
        Route::get('/add', [DownloadController::class, 'create'])->name('add')->middleware('can:downloads.create');
        Route::post('/', [DownloadController::class, 'store'])->name('store')->middleware('can:downloads.create');
        Route::post('/bulk-delete', [DownloadController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{download}/edit', [DownloadController::class, 'edit'])->name('edit')->middleware('can:downloads.edit');
        Route::put('/{download}', [DownloadController::class, 'update'])->name('update')->middleware('can:downloads.edit');
        Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy')->middleware('can:downloads.delete');
    });

    // ==================== GALLERY MANAGEMENT ====================
    Route::prefix('gallery')->name('gallery.')->middleware('can:gallery.view')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/add', [GalleryController::class, 'create'])->name('add')->middleware('can:gallery.create');
        Route::post('/', [GalleryController::class, 'store'])->name('store')->middleware('can:gallery.create');
        Route::post('/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit')->middleware('can:gallery.edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update')->middleware('can:gallery.edit');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy')->middleware('can:gallery.delete');
        Route::post('/{gallery}/images', [GalleryController::class, 'storeImages'])->name('images.store')->middleware('can:gallery.edit');
        Route::delete('/images/{image}', [GalleryController::class, 'destroyImage'])->name('images.destroy')->middleware('can:gallery.delete');
        Route::post('/images/{image}/thumbnail', [GalleryController::class, 'setThumbnail'])->name('images.thumbnail')->middleware('can:gallery.edit');
    });

    // ==================== EVENTS MANAGEMENT ====================
    Route::prefix('events')->name('events.')->middleware('can:events.view')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/add', [EventController::class, 'create'])->name('add')->middleware('can:events.create');
        Route::post('/', [EventController::class, 'store'])->name('store')->middleware('can:events.create');
        Route::post('/bulk-delete', [EventController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit')->middleware('can:events.edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update')->middleware('can:events.edit');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->middleware('can:events.delete');
        Route::post('/{event}/gallery', [EventController::class, 'storeGallery'])->name('gallery.store')->middleware('can:events.edit');
        Route::delete('/gallery/{gallery}', [EventController::class, 'destroyGallery'])->name('gallery.destroy')->middleware('can:events.delete');
        Route::post('/{event}/gallery/{gallery}/thumbnail', [EventController::class, 'setGalleryThumbnail'])->name('gallery.thumbnail')->middleware('can:events.edit');
    });

    // ==================== SECTORS MANAGEMENT ====================
    Route::prefix('sectors')->name('sectors.')->middleware('can:sectors.view')->group(function () {
        Route::get('/', [SectorController::class, 'index'])->name('index');
        Route::get('/add', [SectorController::class, 'create'])->name('add')->middleware('can:sectors.create');
        Route::post('/', [SectorController::class, 'store'])->name('store')->middleware('can:sectors.create');
        Route::post('/bulk-delete', [SectorController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{sector}', [SectorController::class, 'show'])->name('show');
        Route::get('/{sector}/edit', [SectorController::class, 'edit'])->name('edit')->middleware('can:sectors.edit');
        Route::put('/{sector}', [SectorController::class, 'update'])->name('update')->middleware('can:sectors.edit');
        Route::delete('/{sector}', [SectorController::class, 'destroy'])->name('destroy')->middleware('can:sectors.delete');
    });

    // ==================== DESIGNATIONS MANAGEMENT ====================
    Route::prefix('designations')->name('designations.')->middleware('can:designations.view')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('index');
        Route::get('/add', [DesignationController::class, 'create'])->name('add')->middleware('can:designations.create');
        Route::post('/', [DesignationController::class, 'store'])->name('store')->middleware('can:designations.create');
        Route::post('/bulk-delete', [DesignationController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{designation}/edit', [DesignationController::class, 'edit'])->name('edit')->middleware('can:designations.edit');
        Route::put('/{designation}', [DesignationController::class, 'update'])->name('update')->middleware('can:designations.edit');
        Route::delete('/{designation}', [DesignationController::class, 'destroy'])->name('destroy')->middleware('can:designations.delete');
    });

    // ==================== TEAM MANAGEMENT ====================
    Route::prefix('team')->name('team.')->middleware('can:team.view')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index');
        Route::get('/add', [TeamController::class, 'create'])->name('add')->middleware('can:team.create');
        Route::post('/', [TeamController::class, 'store'])->name('store')->middleware('can:team.create');
        Route::post('/bulk-delete', [TeamController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::post('/reorder', [TeamController::class, 'reorder'])->name('reorder')->middleware('can:team.edit');
        Route::get('/{team}', [TeamController::class, 'show'])->name('show');
        Route::get('/{team}/edit', [TeamController::class, 'edit'])->name('edit')->middleware('can:team.edit');
        Route::put('/{team}', [TeamController::class, 'update'])->name('update')->middleware('can:team.edit');
        Route::delete('/{team}', [TeamController::class, 'destroy'])->name('destroy')->middleware('can:team.delete');
    });

    // ==================== LEADERSHIP MESSAGES MANAGEMENT ====================
    Route::prefix('leadership-messages')->name('leadership.')->middleware('can:leadership.view')->group(function () {
        Route::get('/', [LeadershipMessageController::class, 'index'])->name('index');
        Route::get('/add', [LeadershipMessageController::class, 'create'])->name('add')->middleware('can:leadership.create');
        Route::post('/', [LeadershipMessageController::class, 'store'])->name('store')->middleware('can:leadership.create');
        Route::post('/bulk-delete', [LeadershipMessageController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{message}', [LeadershipMessageController::class, 'show'])->name('show');
        Route::get('/{message}/edit', [LeadershipMessageController::class, 'edit'])->name('edit')->middleware('can:leadership.edit');
        Route::put('/{message}', [LeadershipMessageController::class, 'update'])->name('update')->middleware('can:leadership.edit');
        Route::delete('/{message}', [LeadershipMessageController::class, 'destroy'])->name('destroy')->middleware('can:leadership.delete');
    });

    // ==================== AJAX/API ROUTES FOR ADMIN ====================
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::post('/upload-temp', [DashboardController::class, 'uploadTemp'])->name('upload.temp');
        Route::delete('/delete-temp', [DashboardController::class, 'deleteTemp'])->name('delete.temp');
        Route::get('/search', [DashboardController::class, 'globalSearch'])->name('search');
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');
    });
});