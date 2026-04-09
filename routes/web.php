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

Route::get('/projects/{status?}', function ($status = 'all') {
    return view('user.projects.index', compact('status'));
})->name('projects.index');

// Individual project detail page
Route::get('/project/{id}', function ($id) {
    return view('user.projects.show', compact('id'));
})->name('projects.show');

// Contact page
Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');