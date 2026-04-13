<?php

use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================

// Homepage
Route::get('/', function () {
    return view('user.home');
})->name('home');

// Pitchbook page
Route::get('/pitchbook', function () {
    return view('user.pitchbook');
})->name('pitchbook');

// About page (with optional section parameter - default to 'overview')
Route::get('/about/{section?}', function ($section = 'overview') {
    return view('user.about', compact('section'));
})->name('about');

// Tenders page (with optional section parameter - default to 'active')
Route::get('/tenders/{section?}', function ($section = 'active') {
    return view('user.tenders', compact('section'));
})->name('tenders');

// Projects page (with optional status parameter - default to 'all')
Route::get('/projects/{status?}', function ($status = 'all') {
    return view('user.projects.index', compact('status'));
})->name('projects.index');

// Individual project detail page
Route::get('/project/{id}', function ($id) {
    return view('user.projects.show', compact('id'));
})->name('projects.show');

// Media Routes
Route::get('/news', function () {
    return view('user.news.index');
})->name('news.index');

Route::get('/news/{id}', function ($id) {
    return view('user.news.show', compact('id'));
})->name('news.show');

// Gallery Routes
Route::get('/gallery', function () {
    return view('user.gallery.index');
})->name('gallery.index');

Route::get('/gallery/album/{id}', function ($id) {
    return view('user.gallery.album', compact('id'));
})->name('gallery.album');

Route::get('/downloads', function () {
    return view('user.downloads', [
        'documents' => collect([
        ])
    ]);
})->name('media.downloads');

// API endpoint for downloading files
Route::post('/api/downloads/{id}', function ($id) {
    // We'll implement this in Step 4
    return response()->json(['success' => true]);
})->name('api.downloads.file');

// API endpoint for previewing files
Route::get('/api/downloads/{id}/preview', function ($id) {
    // We'll implement this in Step 4
    return response()->json(['success' => true]);
})->name('api.downloads.preview');

// Contact page
Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');