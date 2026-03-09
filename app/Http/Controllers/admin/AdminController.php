<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\GalleryPhoto;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        // ── Stat cards ──────────────────────────────────────
        $stats = [
            'announcements' => Announcement::count(),
            'events'        => Event::upcoming()->count(),
            'achievements'  => Achievement::count(),
            'faculty'       => Faculty::active()->count(),
            'gallery'       => GalleryPhoto::count(),
        ];

        // ── Next upcoming event date ─────────────────────────
        $nextEvent = Event::upcoming()->first();

        // ── Recent announcements (latest 5) ─────────────────
        $recentAnnouncements = Announcement::with('author')
            ->latest('post_date')
            ->take(5)
            ->get();

        // ── Upcoming events (next 4) ─────────────────────────
        $upcomingEvents = Event::upcoming()
            ->take(4)
            ->get();

        // ── Calendar: events this month ──────────────────────
        $calendarEvents = Event::inMonth(now()->year, now()->month)
            ->pluck('event_date')
            ->map(fn($d) => $d->day)
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'nextEvent',
            'recentAnnouncements',
            'upcomingEvents',
            'calendarEvents',
        ));
    }
}