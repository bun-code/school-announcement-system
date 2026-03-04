<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('pages.home'))->name('home');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/',               [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('events',        EventController::class);
    Route::resource('achievements',  AchievementController::class);
    Route::resource('gallery',       GalleryController::class);
    Route::resource('faculty',       FacultyController::class);
});


