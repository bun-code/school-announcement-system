{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening at Taboc Elementary School.')

@section('page-actions')
    <a href="{{ url('/') }}" target="_blank" class="btn btn--secondary btn--sm">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        View Site
    </a>
@endsection

@section('content')

    {{-- ── Stat cards ── --}}
    <div class="stat-cards">

        <div class="stat-card animate-fade-up">
            <div class="stat-card__icon stat-card__icon--blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Announcements</p>
                <p class="stat-card__value">{{ $stats['announcements'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    Total published
                </span>
            </div>
        </div>

        <div class="stat-card animate-fade-up delay-50">
            <div class="stat-card__icon stat-card__icon--orange">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Upcoming Events</p>
                <p class="stat-card__value">{{ $stats['events'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    @if($nextEvent)
                        Next: {{ $nextEvent->event_date->format('M j') }}
                    @else
                        No upcoming events
                    @endif
                </span>
            </div>
        </div>

        <div class="stat-card animate-fade-up delay-100">
            <div class="stat-card__icon stat-card__icon--purple">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Achievements</p>
                <p class="stat-card__value">{{ $stats['achievements'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    Total recorded
                </span>
            </div>
        </div>

        <div class="stat-card animate-fade-up delay-150">
            <div class="stat-card__icon stat-card__icon--green">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Faculty &amp; Staff</p>
                <p class="stat-card__value">{{ $stats['faculty'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    Active members
                </span>
            </div>
        </div>

        <div class="stat-card animate-fade-up delay-200">
            <div class="stat-card__icon stat-card__icon--blue">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Subscribers</p>
                <p class="stat-card__value">{{ $stats['subscribers_active'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    {{ $stats['subscribers_total'] }} total
                </span>
            </div>
        </div>

        <div class="stat-card animate-fade-up delay-250">
            <div class="stat-card__icon stat-card__icon--amber">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-card__body">
                <p class="stat-card__label">Gallery Photos</p>
                <p class="stat-card__value">{{ $stats['gallery'] }}</p>
                <span class="stat-card__change stat-card__change--up">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    Total uploaded
                </span>
            </div>
        </div>

    </div>

    {{-- ── Main content row ── --}}
    <div class="dashboard-grid">

        {{-- Recent Announcements --}}
        <div class="panel animate-fade-up delay-100">
            <div class="panel__header">
                <div>
                    <p class="panel__title">Recent Announcements</p>
                    <p class="panel__subtitle">Latest posts published to the public site</p>
                </div>
                <div class="panel__header-actions">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn--primary btn--sm">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        New Post
                    </a>
                </div>
            </div>
            <div class="panel__body--flush">
                @if($recentAnnouncements->isEmpty())
                    <div style="padding:var(--space-8);text-align:center;color:var(--admin-text-muted);">
                        <p>No announcements yet. <a href="{{ route('admin.announcements.index') }}">Create one →</a></p>
                    </div>
                @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="td-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $catColors = [
                                'Academic'  => 'badge--purple',
                                'Notice'    => 'badge--orange',
                                'Health'    => 'badge--amber',
                                'Community' => 'badge--green',
                                'General'   => 'badge--blue',
                            ];
                        @endphp
                        @foreach($recentAnnouncements as $ann)
                        <tr>
                            <td>
                                <p class="cell-title">{{ $ann->title }}</p>
                                <p class="cell-excerpt">{{ Str::limit($ann->body, 50) }}</p>
                            </td>
                            <td>
                                <span class="badge {{ $catColors[$ann->category] ?? 'badge--blue' }}">
                                    {{ $ann->category }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $ann->status === 'published' ? 'badge--green' : 'badge--gray' }}">
                                    {{ ucfirst($ann->status) }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;color:var(--admin-text-muted);">
                                {{ $ann->post_date->format('M j, Y') }}
                            </td>
                            <td class="td-actions">
                                <div class="table-actions">
                                    <a href="{{ route('admin.announcements.index') }}"
                                       class="btn btn--ghost btn--icon btn--sm tooltip" data-tip="Edit" aria-label="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <div class="panel__footer">
                <span style="font-size:var(--text-xs);color:var(--admin-text-muted);">
                    Showing {{ $recentAnnouncements->count() }} of {{ $stats['announcements'] }}
                </span>
                <a href="{{ route('admin.announcements.index') }}" class="btn btn--secondary btn--sm">View All</a>
            </div>
        </div>

        {{-- Right column --}}
        <div style="display:flex;flex-direction:column;gap:var(--space-5);">

            {{-- Events & Calendar --}}
            <div class="panel animate-fade-up delay-150">
                <div class="panel__header">
                    <div>
                        <p class="panel__title">Calendar — {{ $calendarMeta['monthName'] }}</p>
                        <p class="panel__subtitle">{{ $calendarDescription }}</p>
                    </div>
                    <a href="{{ route('admin.events.index') }}" class="btn btn--ghost btn--sm">View Calendar</a>
                </div>
                <div class="panel__body--flush">
                    <div class="calendar calendar--embedded">
                        <div class="calendar__header">
                            <p class="calendar__month">{{ $calendarMeta['monthName'] }}</p>
                            <div class="calendar__nav">
                                <button class="calendar__nav-btn" aria-label="Previous month">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button class="calendar__nav-btn" aria-label="Next month">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="calendar__grid">
                            <div class="calendar__weekdays">
                                @foreach(['S','M','T','W','T','F','S'] as $d)
                                    <div class="calendar__weekday">{{ $d }}</div>
                                @endforeach
                            </div>
                            <div class="calendar__days">
                                @for($b = 0; $b < $calendarMeta['startOfMonth']; $b++)
                                    <div class="calendar__day other-month"><span class="calendar__day-num"></span></div>
                                @endfor
                                @for($d = 1; $d <= $calendarMeta['daysInMonth']; $d++)
                                    <div class="calendar__day {{ $d === $calendarMeta['today'] ? 'today' : '' }} {{ in_array($d, $calendarEvents) ? 'has-event' : '' }}">
                                        <span class="calendar__day-num">{{ $d }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upcoming events list --}}
            <div class="panel animate-fade-up delay-200">
                <div class="panel__header">
                    <div>
                        <p class="panel__title">{{ $eventsTitle }}</p>
                        <p class="panel__subtitle">{{ $eventsDescription }}</p>
                    </div>
                    <a href="{{ route('admin.events.index') }}" class="btn btn--primary btn--sm">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add
                    </a>
                </div>
                <div class="panel__body" style="padding-block:var(--space-3);">
                    @php
                        $catColors = [
                            'Academic'  => 'badge--blue',
                            'Sports'    => 'badge--green',
                            'Cultural'  => 'badge--orange',
                            'Program'   => 'badge--purple',
                            'Community' => 'badge--amber',
                            'Health'    => 'badge--red',
                        ];
                    @endphp
                    @forelse($upcomingEvents as $event)
                    <div style="display:flex;align-items:center;gap:var(--space-3);padding:var(--space-3) 0;border-bottom:1px solid var(--admin-border);">
                        <div style="min-width:44px;text-align:center;background:var(--admin-bg);border-radius:var(--radius-md);padding:var(--space-2);">
                            <p style="font-family:var(--font-display);font-size:var(--text-lg);font-weight:800;color:var(--color-primary);line-height:1;">
                                {{ $event->event_date->format('d') }}
                            </p>
                            <p style="font-size:0.6rem;font-weight:700;color:var(--admin-text-muted);text-transform:uppercase;letter-spacing:.08em;">
                                {{ $event->event_date->format('M') }}
                            </p>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:var(--text-sm);font-weight:600;color:var(--admin-text-heading);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $event->title }}
                            </p>
                            <span class="badge {{ $catColors[$event->category] ?? 'badge--blue' }}" style="margin-top:3px;">
                                {{ $event->category }}
                            </span>
                        </div>
                        <a href="{{ route('admin.events.index') }}" class="btn btn--ghost btn--icon btn--sm" aria-label="Edit event">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </div>
                    @empty
                    <div style="padding:var(--space-6);text-align:center;color:var(--admin-text-muted);">
                        <p>No upcoming events.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

@endsection



