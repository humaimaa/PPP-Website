<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\HierarchyController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\LeadershipMessageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
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

// ==================== EMAIL VERIFICATION ROUTES ====================
// These need to be accessible for the verification process
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'auth'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['throttle:6,1', 'auth'])
    ->name('verification.send');

Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware(['auth'])
    ->name('verification.notice');

// ==================== PROTECTED ADMIN ROUTES ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::prefix('profile')->name('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('');
        Route::put('/update', [ProfileController::class, 'update'])->name('.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('.password');
        // Use a different route name to avoid conflict with verification.send
        Route::post('/resend-verification', [ProfileController::class, 'resendVerification'])->name('.resend-verification');
    });

    
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
        Route::post('/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('verify-email')->middleware('can:users.edit');
        Route::post('/{user}/resend-verification', [UserController::class, 'resendVerification'])->name('resend-verification');
    });

    // ==================== ROLE MANAGEMENT ====================
    Route::prefix('roles')->name('roles.')->middleware('can:roles.view')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/add', [RoleController::class, 'create'])->name('add')->middleware('can:roles.create');
        Route::post('/', [RoleController::class, 'store'])->name('store')->middleware('can:roles.create');
        Route::post('/bulk-delete', [RoleController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('can:roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update')->middleware('can:roles.edit');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->middleware('can:roles.delete');
    });

/// ==================== PROJECT MANAGEMENT ====================
Route::prefix('projects')->name('projects.')->middleware('can:projects.view')->group(function () {
    // 1. STATIC ROUTES FIRST (no parameters)
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/add', [ProjectController::class, 'create'])->name('add')->middleware('can:projects.create');
    Route::post('/', [ProjectController::class, 'store'])->name('store')->middleware('can:projects.create');
    Route::post('/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
    
    // 2. CUSTOM ROUTES WITH PARAMETERS
    Route::patch('/{project}/toggle-publish', [ProjectController::class, 'togglePublish'])
        ->name('toggle-publish')
        ->where('project', '[0-9]+');
    
    // 3. RESOURCE ROUTES (with parameters)
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])
        ->name('edit')
        ->middleware('can:projects.edit')
        ->where('project', '[0-9]+');
    
    Route::put('/{project}', [ProjectController::class, 'update'])
        ->name('update')
        ->middleware('can:projects.edit')
        ->where('project', '[0-9]+');
    
    Route::delete('/{project}', [ProjectController::class, 'destroy'])
        ->name('destroy')
        ->middleware('can:projects.delete')
        ->where('project', '[0-9]+');
    
    // 4. SHOW ROUTE MUST BE LAST
    Route::get('/{project}', [ProjectController::class, 'show'])
        ->name('show')
        ->where('project', '[0-9]+');
});
    // ==================== NEWS/UPDATES MANAGEMENT ====================
Route::prefix('updates')->name('updates.')->middleware('can:news.view')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/create', [NewsController::class, 'create'])->name('create')->middleware('can:news.create');
    Route::post('/', [NewsController::class, 'store'])->name('store')->middleware('can:news.create');
    Route::post('/bulk-delete', [NewsController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
    
    // Toggle publish route - with numeric constraint
    Route::patch('/{news}/toggle-publish', [NewsController::class, 'togglePublish'])
        ->name('toggle-publish')
        ->where('news', '[0-9]+');
    
    // Feature routes
    Route::post('/{news}/feature', [NewsController::class, 'feature'])->name('feature')->middleware('can:news.edit');
    Route::post('/{news}/unfeature', [NewsController::class, 'unfeature'])->name('unfeature')->middleware('can:news.edit');
    Route::post('/{news}/toggle-featured', [NewsController::class, 'toggleFeatured'])->name('toggle-featured')->middleware('can:news.edit');
    
    // Resource routes - with numeric constraints
    Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit')->middleware('can:news.edit')->where('news', '[0-9]+');
    Route::put('/{news}', [NewsController::class, 'update'])->name('update')->middleware('can:news.edit')->where('news', '[0-9]+');
    Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy')->middleware('can:news.delete')->where('news', '[0-9]+');
    
    // Show route must be LAST
    Route::get('/{news}', [NewsController::class, 'show'])->name('show')->where('news', '[0-9]+');
});

    // ==================== TENDERS MANAGEMENT ====================
    Route::prefix('tenders')->name('tenders.')->middleware('can:tenders.view')->group(function () {
        Route::get('/', [TenderController::class, 'index'])->name('index');
        Route::get('/create', [TenderController::class, 'create'])->name('create')->middleware('can:tenders.create');
        Route::post('/', [TenderController::class, 'store'])->name('store')->middleware('can:tenders.create');
        Route::post('/bulk-delete', [TenderController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:tenders.delete');

        // Archive / Unarchive routes
        Route::post('/{tender}/archive', [TenderController::class, 'archive'])->name('archive')->middleware('can:tenders.edit');
        Route::post('/{tender}/unarchive', [TenderController::class, 'unarchive'])->name('unarchive')->middleware('can:tenders.edit');

        // Extend functionality routes
        Route::post('/{tender}/extend', [TenderController::class, 'extend'])->name('extend')->middleware('can:tenders.edit');
        Route::delete('/{tender}/remove-extension', [TenderController::class, 'removeExtension'])->name('remove-extension')->middleware('can:tenders.edit');

        Route::get('/{tender}', [TenderController::class, 'show'])->name('show');
        Route::get('/{tender}/edit', [TenderController::class, 'edit'])->name('edit')->middleware('can:tenders.edit');
        Route::put('/{tender}', [TenderController::class, 'update'])->name('update')->middleware('can:tenders.edit');
        Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy')->middleware('can:tenders.delete');

        // Additional document delete
        Route::delete('/additional-docs/{doc}', [TenderController::class, 'deleteAdditionalDoc'])
            ->name('delete-additional-doc')
            ->middleware('can:tenders.edit');
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

 // ==================== EVENTS MANAGEMENT ====================
Route::prefix('events')->name('events.')->middleware('can:events.view')->group(function () {
    // Static routes (no parameters) first
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/add', [EventController::class, 'create'])->name('add')->middleware('can:events.create');
    Route::post('/', [EventController::class, 'store'])->name('store')->middleware('can:events.create');
    Route::post('/bulk-delete', [EventController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
    
    // Custom routes with parameters - with numeric constraints
    Route::patch('/{event}/toggle-publish', [EventController::class, 'togglePublish'])
        ->name('toggle-publish')
        ->where('event', '[0-9]+');
    
    Route::post('/{event}/gallery', [EventController::class, 'storeGallery'])->name('gallery.store')->middleware('can:events.edit');
    Route::delete('/gallery/{gallery}', [EventController::class, 'destroyGallery'])->name('gallery.destroy')->middleware('can:events.delete');
    Route::post('/{event}/gallery/{gallery}/thumbnail', [EventController::class, 'setGalleryThumbnail'])->name('gallery.thumbnail')->middleware('can:events.edit');
    
    // Resource routes - with numeric constraints
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit')->middleware('can:events.edit')->where('event', '[0-9]+');
    Route::put('/{event}', [EventController::class, 'update'])->name('update')->middleware('can:events.edit')->where('event', '[0-9]+');
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->middleware('can:events.delete')->where('event', '[0-9]+');
    
    // Show route must be LAST
    Route::get('/{event}', [EventController::class, 'show'])->name('show')->where('event', '[0-9]+');
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

  // ==================== HIERARCHY MANAGEMENT ====================
    Route::prefix('hierarchy')->name('hierarchy.')->middleware('can:hierarchy.view')->group(function () {
        Route::get('/', [HierarchyController::class, 'index'])->name('index');
        Route::get('/add', [HierarchyController::class, 'create'])->name('add')->middleware('can:hierarchy.create');
        Route::post('/', [HierarchyController::class, 'store'])->name('store')->middleware('can:hierarchy.create');
        Route::post('/bulk-delete', [HierarchyController::class, 'bulkDelete'])->name('bulk-delete')->middleware('can:bulk.delete');
        Route::get('/{hierarchy}/edit', [HierarchyController::class, 'edit'])->name('edit')->middleware('can:hierarchy.edit');
        Route::put('/{hierarchy}', [HierarchyController::class, 'update'])->name('update')->middleware('can:hierarchy.edit');
        Route::delete('/{hierarchy}', [HierarchyController::class, 'destroy'])->name('destroy')->middleware('can:hierarchy.delete');
        Route::post('/update-order', [HierarchyController::class, 'updateOrder'])->name('update-order')->middleware('can:hierarchy.edit');
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