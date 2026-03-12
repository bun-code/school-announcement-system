{{-- pages/events.blade.php --}}
@extends('layouts.home')

@section('title', 'School Events — Taboc Elementary School')
@section('meta_description', 'See the full school events calendar and upcoming activities at Taboc Elementary School.')

@section('page_content')

@php
    $daysInMonth = $currentMonth->daysInMonth;
    $startBlank  = $currentMonth->dayOfWeek; // 0=Sun
    $today       = now();
    $dateBlockMap = [
        'Academic'  => 'card__date-block--blue',
        'Sports'    => 'card__date-block--green',
        'Cultural'  => 'card__date-block--orange',
        'Program'   => 'card__date-block--purple',
        'Community' => 'card__date-block--amber',
        'Health'    => 'card__date-block--red',
    ];
@endphp

<section class="page-hero">
    <div class="container">
        <p class="section-label">School Calendar</p>
        <div class="page-hero__actions">
            <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <h1 class="page-hero__title">Events &amp; Activities</h1>
        <p class="page-hero__subtitle">
            Track upcoming activities and important school dates throughout the year.
        </p>
    </div>
</section>

<section class="section events-section">
    <div class="container">
        <div class="events-page__grid">
            <div class="public-calendar">
                <div class="public-calendar__header">
                    <div>
                        <p class="public-calendar__month">{{ $currentMonth->format('F Y') }}</p>
                        <p class="public-calendar__sub">Highlighted days have scheduled events.</p>
                    </div>
                    <div class="public-calendar__nav">
                        <a class="public-calendar__nav-btn"
                           href="{{ route('events.index', ['month' => $prevMonth->format('Y-m')]) }}"
                           aria-label="Previous month">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <a class="public-calendar__nav-btn"
                           href="{{ route('events.index', ['month' => $nextMonth->format('Y-m')]) }}"
                           aria-label="Next month">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="public-calendar__grid">
                    <div class="public-calendar__weekdays">
                        @foreach(['S','M','T','W','T','F','S'] as $d)
                            <div class="public-calendar__weekday">{{ $d }}</div>
                        @endforeach
                    </div>
                    <div class="public-calendar__days">
                        @for($b = 0; $b < $startBlank; $b++)
                            <div class="public-calendar__day is-blank"></div>
                        @endfor
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php
                                $hasEvents = $eventsByDay->has($d);
                                $isToday = $currentMonth->isSameMonth($today) && $today->day === $d;
                            @endphp
                            <div class="public-calendar__day {{ $isToday ? 'today' : '' }} {{ $hasEvents ? 'has-event' : '' }}">
                                <span class="public-calendar__day-num">{{ $d }}</span>
                                @if($hasEvents)
                                    <span class="public-calendar__day-count">{{ $eventsByDay[$d]->count() }}</span>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="events-page__list">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow">Upcoming</p>
                    <h2 class="section-header__title">Next Activities</h2>
                    <p class="section-header__subtitle">What’s coming up in the school calendar.</p>
                </div>

                <div class="events-page__cards">
                    @forelse($upcomingEvents as $event)
                        @php
                            $categoryLabel = $event->category ?: 'Academic';
                            $dateBlockClass = $dateBlockMap[$categoryLabel] ?? 'card__date-block--blue';
                            $startTime = $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('g:i A') : null;
                            $endTime = $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('g:i A') : null;
                            $timeLabel = $startTime ? $startTime : 'Time TBA';
                            if ($startTime && $endTime) {
                                $timeLabel = $startTime . ' – ' . $endTime;
                            }
                        @endphp
                        <article class="card">
                            <div class="card__body">
                                <div class="card--event">
                                    <div class="card__date-block {{ $dateBlockClass }}">
                                        <p class="card__date-day">{{ $event->event_date->format('d') }}</p>
                                        <p class="card__date-month">{{ $event->event_date->format('M') }}</p>
                                    </div>
                                    <div class="card__event-body">
                                        <span class="badge {{ $event->category_color }} card__event-badge">{{ $categoryLabel }}</span>
                                        <h3 class="card__event-title">{{ $event->title }}</h3>
                                        @if($event->description)
                                            <p class="card__excerpt card__excerpt--sm">{{ $event->description }}</p>
                                        @endif
                                        <p class="card__event-location">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $event->location ?? 'Location TBA' }} &bull; {{ $timeLabel }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="public-empty">
                            <p class="public-empty__title">No upcoming events</p>
                            <p class="public-empty__text">Please check back for new activities.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
