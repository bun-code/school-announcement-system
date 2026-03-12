<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\GalleryPhoto;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        // -- Stat cards -----------------------------------------------------
        $stats = [
            'announcements' => Announcement::count(),
            'events'        => Event::upcoming()->count(),
            'achievements'  => Achievement::count(),
            'faculty'       => Faculty::active()->count(),
            'gallery'       => GalleryPhoto::count(),
            'subscribers_total' => Subscriber::count(),
            'subscribers_active' => Subscriber::active()->confirmed()->count(),
        ];

        // -- Next upcoming event date ---------------------------------------
        $nextEvent = Event::upcoming()->first();
        $eventsTitle = $nextEvent
            ? 'Next Event: ' . Str::limit($nextEvent->title, 40)
            : 'Upcoming Events';

        // -- Recent announcements (latest 5) --------------------------------
        $recentAnnouncements = Announcement::with('author')
            ->latest('post_date')
            ->take(5)
            ->get();

        $latestAnnouncement = $recentAnnouncements->first();
        $announcementTitle = $latestAnnouncement?->title;
        $announcementSnippet = $latestAnnouncement
            ? Str::limit(preg_replace('/\s+/', ' ', strip_tags($latestAnnouncement->body ?? '')), 90)
            : null;

        $calendarDescription = $announcementTitle
            ? 'Announcement: ' . Str::limit($announcementTitle, 70)
            : 'No announcements yet. Publish one to highlight updates here.';

        $eventsDescription = $announcementSnippet
            ? $announcementSnippet
            : 'Upcoming activities scheduled by the admin team.';

        // -- Upcoming events (next 4) ---------------------------------------
        $upcomingEvents = Event::upcoming()
            ->take(4)
            ->get();

        // -- Calendar: events this month ------------------------------------
        $calendarMonth = now()->startOfMonth();
        $calendarEvents = Event::inMonth($calendarMonth->year, $calendarMonth->month)
            ->selectRaw('DAY(event_date) as day')
            ->distinct()
            ->pluck('day')
            ->toArray();

        $calendarMeta = [
            'monthName'    => $calendarMonth->format('F Y'),
            'daysInMonth'  => $calendarMonth->daysInMonth,
            'startOfMonth' => $calendarMonth->dayOfWeek, // 0=Sun
            'today'        => now()->day,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'nextEvent',
            'recentAnnouncements',
            'upcomingEvents',
            'calendarEvents',
            'calendarMeta',
            'calendarDescription',
            'eventsDescription',
            'eventsTitle',
        ));
    }
}
