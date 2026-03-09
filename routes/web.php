<?php

// ============================================================
//  routes/web.php — complete admin section
// ============================================================

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Middleware\AdminOnly;
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Admin\AnnouncementManager;
use App\Livewire\Admin\EventManager;

// ── Public homepage ──────────────────────────────────────────
Route::get('/', fn() => view('pages.home'))->name('home');

// ── Public: login / logout ───────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',   AdminLogin::class)->name('login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

});

// ── Protected: all admin pages ───────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminOnly::class])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/announcements', AnnouncementManager::class)->name('announcements.index');
    Route::get('/events',        EventManager::class)->name('events.index');

    Route::resource('achievements', AchievementController::class)
         ->names([
             'index'   => 'achievements.index',
             'create'  => 'achievements.create',
             'store'   => 'achievements.store',
             'show'    => 'achievements.show',
             'edit'    => 'achievements.edit',
             'update'  => 'achievements.update',
             'destroy' => 'achievements.destroy',
         ]);

    Route::resource('gallery', GalleryController::class)
         ->names([
             'index'   => 'gallery.index',
             'create'  => 'gallery.create',
             'store'   => 'gallery.store',
             'show'    => 'gallery.show',
             'edit'    => 'gallery.edit',
             'update'  => 'gallery.update',
             'destroy' => 'gallery.destroy',
         ]);

    Route::post('/gallery/bulk-destroy',     [GalleryController::class, 'bulkDestroy'])->name('gallery.bulk-destroy');
    Route::post('/gallery/albums',           [GalleryController::class, 'storeAlbum'])->name('gallery.albums.store');
    Route::delete('/gallery/albums/{album}', [GalleryController::class, 'destroyAlbum'])->name('gallery.albums.destroy');

    Route::resource('faculty', FacultyController::class)
         ->names([
             'index'   => 'faculty.index',
             'create'  => 'faculty.create',
             'store'   => 'faculty.store',
             'show'    => 'faculty.show',
             'edit'    => 'faculty.edit',
             'update'  => 'faculty.update',
             'destroy' => 'faculty.destroy',
         ]);

    Route::post('/announcements/bulk-destroy', [AnnouncementController::class, 'bulkDestroy'])
         ->name('announcements.bulk-destroy');

});