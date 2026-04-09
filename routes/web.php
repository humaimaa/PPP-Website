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

// Contact page
Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');