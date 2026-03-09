<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    // ── Index ───────────────────────────────────────────────

    public function index(Request $request): View
    {
        $query = Event::latest('event_date');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $events = $query->paginate(10)->withQueryString();

        // Calendar data — events for current month
        $year  = $request->integer('year',  now()->year);
        $month = $request->integer('month', now()->month);

        $calendarEvents = Event::inMonth($year, $month)
            ->get(['id', 'title', 'event_date', 'category'])
            ->groupBy(fn($e) => $e->event_date->day);

        // Category summary
        $categorySummary = Event::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('admin.events.index', compact(
            'events', 'calendarEvents', 'categorySummary', 'year', 'month'
        ));
    }

    // ── Store ───────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category'    => ['required', 'in:Academic,Sports,Cultural,Program,Community,Health'],
            'event_date'  => ['required', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:event_date'],
            'start_time'  => ['nullable', 'date_format:H:i'],
            'end_time'    => ['nullable', 'date_format:H:i', 'after:start_time'],
            'location'    => ['nullable', 'string', 'max:255'],
        ]);

        $validated['status'] = 'upcoming';

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event added to the calendar successfully.');
    }

    // ── Update ──────────────────────────────────────────────

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category'    => ['required', 'in:Academic,Sports,Cultural,Program,Community,Health'],
            'event_date'  => ['required', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:event_date'],
            'start_time'  => ['nullable', 'date_format:H:i'],
            'end_time'    => ['nullable', 'date_format:H:i'],
            'location'    => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:upcoming,completed,cancelled,scheduled'],
        ]);

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    // ── Destroy ─────────────────────────────────────────────

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event removed from the calendar.');
    }
}