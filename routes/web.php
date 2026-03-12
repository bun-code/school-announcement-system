<?php

// ============================================================
//  routes/web.php — complete admin section
// ============================================================

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
use App\Livewire\Admin\FacultyManager;
use App\Http\Controllers\Public\SubscriberController;
use App\Models\Announcement;
use App\Models\Achievement;
use App\Models\Album;
use App\Models\Event;
use App\Models\Faculty;
use App\Livewire\Admin\SiteSettingsManager;
use App\Models\SiteSettings;

Route::get('/', function () {
    $featured = Announcement::published()
        ->active()
        ->where('is_pinned', true)
        ->latest('post_date')
        ->first();

    $secondary = Announcement::published()
        ->active()
        ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
        ->latest('post_date')
        ->take(4)
        ->get();

    if (!$featured) {
        $featured = $secondary->shift();
    }

    $homeEvents = Event::query()
        ->where(function ($q) {
            $q->whereNull('status')
              ->orWhere('status', '!=', 'cancelled');
        })
        ->where('event_date', '>=', now()->startOfDay())
        ->orderBy('event_date')
        ->take(6)
        ->get();

    $homeHonors = Achievement::honors()
        ->orderByDesc('gwa')
        ->take(3)
        ->get();

    $homeWins = Achievement::competitions()
        ->latest('event_date')
        ->take(4)
        ->get();

    $homeAlbums = Album::query()
        ->whereHas('photos', fn($q) => $q->published())
        ->with([
            'photos' => fn($q) => $q->published()->latest()->take(4),
        ])
        ->withCount([
            'photos as published_photos_count' => fn($q) => $q->published(),
        ])
        ->latest()
        ->take(3)
        ->get();

    return view('pages.home', compact('featured', 'secondary', 'homeEvents', 'homeHonors', 'homeWins', 'homeAlbums'));
})->name('home');
// -- Public: announcements + events ----------------------------------------
Route::get('/announcements', function () {
    $announcements = Announcement::published()
        ->active()
        ->orderByDesc('is_pinned')
        ->orderByDesc('post_date')
        ->paginate(8)
        ->withQueryString();

    return view('pages.announcements', compact('announcements'));
})->name('announcements.index');

Route::get('/events', function (Request $request) {
    $monthParam = $request->query('month');

    try {
        $currentMonth = $monthParam
            ? Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth()
            : now()->startOfMonth();
    } catch (\Exception $e) {
        $currentMonth = now()->startOfMonth();
    }

    $eventsForMonth = Event::query()
        ->where(function ($q) {
            $q->whereNull('status')
              ->orWhere('status', '!=', 'cancelled');
        })
        ->whereYear('event_date', $currentMonth->year)
        ->whereMonth('event_date', $currentMonth->month)
        ->orderBy('event_date')
        ->get();

    $eventsByDay = $eventsForMonth->groupBy(fn($event) => $event->event_date->day);

    $upcomingEvents = Event::query()
        ->where(function ($q) {
            $q->whereNull('status')
              ->orWhere('status', '!=', 'cancelled');
        })
        ->where('event_date', '>=', now()->startOfDay())
        ->orderBy('event_date')
        ->take(12)
        ->get();

    $prevMonth = $currentMonth->copy()->subMonth();
    $nextMonth = $currentMonth->copy()->addMonth();

    return view('pages.events', compact(
        'currentMonth',
        'prevMonth',
        'nextMonth',
        'eventsByDay',
        'upcomingEvents'
    ));
})->name('events.index');

Route::get('/gallery', function () {
    $albums = Album::query()
        ->with([
            'photos' => fn($q) => $q->published()->latest()->take(4),
        ])
        ->withCount([
            'photos as published_photos_count' => fn($q) => $q->published(),
        ])
        ->orderBy('name')
        ->get();

    return view('pages.gallery', compact('albums'));
})->name('gallery.index');

Route::get('/gallery/{album}', function (Album $album) {
    $photos = $album->photos()
        ->published()
        ->latest()
        ->paginate(18)
        ->withQueryString();

    return view('pages.gallery-album', compact('album', 'photos'));
})->name('gallery.show');

Route::get('/faculty', function () {
    $teaching = Faculty::visibleOnSite()
        ->teaching()
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    $nonTeaching = Faculty::visibleOnSite()
        ->where('type', 'non-teaching')
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    $administrative = Faculty::visibleOnSite()
        ->where('type', 'administrative')
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    return view('pages.faculty', compact('teaching', 'nonTeaching', 'administrative'));
})->name('faculty.index');

Route::get('enrollment', function () {
    return view('pages.enrollment', [
        'enrollment_info' => SiteSettings::get('enrollment_info', 'No information available.')
    ]);
})->name('enrollment.index');

Route::get('academic-calendar', function () {
    return view('pages.academic-calendar', [
        'academic_calendar_info' => SiteSettings::get('academic_calendar_info', 'No information available.')
    ]);
})->name('academic-calendar.index');

Route::get('curriculum', function () {
    return view('pages.curriculum', [
        'curriculum_info' => SiteSettings::get('curriculum_info', 'No information available.')
    ]);
})->name('curriculum.index');

Route::get('school-policies', function () {
    return view('pages.school-policies', [
        'school_policies_info' => SiteSettings::get('school_policies_info', 'No information available.')
    ]);
})->name('school-policies.index');

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe.store');
Route::get('/subscribe/confirm/{token}', [SubscriberController::class, 'confirm'])->name('subscribe.confirm');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('subscribe.unsubscribe');

// ── Public: login / logout ───────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',   AdminLogin::class)->name('login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

});

// ── Protected: all admin pages ───────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminOnly::class, 'no.cache'])->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/announcements', AnnouncementManager::class)->name('announcements.index');
    Route::get('/events',        EventManager::class)->name('events.index');
    Route::get('/settings',      SiteSettingsManager::class)->name('settings.index');

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
         ->only(['store', 'edit', 'update', 'destroy'])
         ->names([
             'store'   => 'faculty.store',
             'edit'    => 'faculty.edit',
             'update'  => 'faculty.update',
             'destroy' => 'faculty.destroy',
         ]);
    Route::get('faculty', FacultyManager::class)->name('faculty.index');
    Route::post('/faculty/bulk-destroy', [FacultyController::class, 'bulkDestroy'])->name('faculty.bulk-destroy');

    Route::post('/announcements/bulk-destroy', [AnnouncementController::class, 'bulkDestroy'])
         ->name('announcements.bulk-destroy');

});

