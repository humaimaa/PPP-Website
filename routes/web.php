<?php

use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================

// Homepage
Route::get('/', function () {
    return view('user.home');
})->name('home');

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

// Route::get('/gallery', function () {
//     return view('user.media.gallery');
// })->name('media.gallery');

Route::get('/downloads', function () {
    return view('user.downloads');
})->name('media.downloads');

// Contact page
Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');