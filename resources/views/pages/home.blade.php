{{-- pages/home.blade.php --}}
{{-- Extends the public layout (layouts/home.blade.php -> app.blade.php) --}}
{{-- Navbar & Footer are injected automatically via app.blade.php         --}}

@extends('layouts.home')

@section('title', 'Taboc Elementary School - Home')
@section('meta_description', 'Taboc Elementary School - Nurturing young minds with quality education, character values, and a caring community.')

@section('page_content')

@php
    $featured = $featured ?? null;
    $secondary = $secondary ?? collect();
    $homeEvents = $homeEvents ?? collect();
    $homeAlbums = $homeAlbums ?? \App\Models\Album::query()
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
    $hero_pill          = \App\Models\SiteSettings::get('hero_pill', 'S.Y. 2025-2026 Enrollment Now Open');
    $hero_title_line1   = \App\Models\SiteSettings::get('hero_title_line1', 'Where Every Child');
    $hero_title_line2   = \App\Models\SiteSettings::get('hero_title_line2', 'Learns, Grows');
    $hero_title_line3   = \App\Models\SiteSettings::get('hero_title_line3', '& Thrives');
    $hero_description   = \App\Models\SiteSettings::get('hero_description', "Taboc Elementary School is committed to nurturing every learner's potential through quality, inclusive education grounded in Filipino values and excellence.");
    $hero_cta_primary   = \App\Models\SiteSettings::get('hero_cta_primary', 'Latest Updates');
    $hero_cta_secondary = \App\Models\SiteSettings::get('hero_cta_secondary', 'About Our School');
    $stats_students     = \App\Models\SiteSettings::get('stats_students', '500+');
    $stats_teachers     = \App\Models\SiteSettings::get('stats_teachers', '30+');
    $stats_years        = \App\Models\SiteSettings::get('stats_years', '20+');
    $stats_admins      = \App\Models\SiteSettings::get('stats_admins', '2');
    $school_head        = \App\Models\SiteSettings::get('school_head', 'Mrs. [Principal Name]');
    $school_head_title  = \App\Models\SiteSettings::get('school_head_title', 'Principal I');
    $class_hours        = \App\Models\SiteSettings::get('class_hours', '7:30 AM - 5:00 PM');
    $school_location    = \App\Models\SiteSettings::get('school_location', 'Taboc, Philippines');
@endphp


    <section class="hero" id="home" aria-label="Hero section">
        <div class="container">
            <div class="hero__content">

                {{-- Enrollment pill --}}
                <div class="hero__pill animate-fade-up">
                    <span class="hero__pill-dot" aria-hidden="true"></span>
                    {{ $hero_pill }}
                </div>

                {{-- Heading --}}
                <h1 class="hero__title animate-fade-up delay-100">
                    {{ $hero_title_line1 }}<br/>
                    <span class="hero__title-accent text-gradient">{{ $hero_title_line2 }}</span><br/>
                    {{ $hero_title_line3 }}
                </h1>

                {{-- Description --}}
                <p class="hero__desc animate-fade-up delay-200">
                    {{ $hero_description }}
                </p>

                {{-- CTA buttons --}}
                <div class="hero__actions animate-fade-up delay-300">
                    <a href="#announcements" class="btn btn--primary btn--lg">
                        {{ $hero_cta_primary }}
                        <svg class="btn__arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    <a href="#about" class="btn btn--ghost btn--lg">
                        {{ $hero_cta_secondary }}
                    </a>
                </div>

                {{-- Stats --}}
                <div class="hero__stats animate-fade-up delay-400">
                    <div>
                        <p class="hero__stat-number">{{ $stats_students }}</p>
                        <p class="hero__stat-label">Students</p>
                    </div>
                    <div class="hero__stat-divider" aria-hidden="true"></div>
                    <div>
                        <p class="hero__stat-number">{{ $stats_teachers }}</p>
                        <p class="hero__stat-label">Teachers</p>
                    </div>
                    <div class="hero__stat-divider" aria-hidden="true"></div>
                    <div>
                        <p class="hero__stat-number">{{ $stats_years }}</p>
                        <p class="hero__stat-label">Years</p>
                    </div>
                    <div class="hero__stat-divider" aria-hidden="true"></div>
                    <div>
                        <p class="hero__stat-number">{{ $stats_admins }}</p>
                        <p class="hero__stat-label">Admins</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="ticker" aria-label="News ticker" role="marquee">
        <div class="ticker__track">
            @php
                $tickerItems = \App\Models\Announcement::published()
                ->latest('post_date')
                ->take(10)
                ->pluck('title');
            @endphp

            @if($tickerItems->count())
            <div class="ticker" aria-label="News ticker" role="marquee">
                <div class="ticker__track">
                    {{-- First pass --}}
                    @foreach($tickerItems as $item)
                        <span class="ticker__item">
                            <span class="ticker__dot" aria-hidden="true"></span>
                            {{ $item }}
                        </span>
                    @endforeach
                    {{-- Duplicate for seamless loop --}}
                    @foreach($tickerItems as $item)
                        <span class="ticker__item" aria-hidden="true">
                            <span class="ticker__dot"></span>
                            {{ $item }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>


    <section class="section announcements" id="announcements" aria-labelledby="announcements-heading">
        <div class="container">

            <div class="section-header-row">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow" id="announcements-heading">Announcements</p>
                    <h2 class="section-header__title">Latest News &amp; Notices</h2>
                    <p class="section-header__subtitle">Stay informed with important updates from the school office.</p>
                </div>
                <a href="{{ route('announcements.index') }}" class="view-all-link">
                    View All
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="announcements__grid">

                @if(!$featured && $secondary->isEmpty())
                    <div class="empty-state" style="grid-column:1 / -1;">
                        <p class="empty-state__title">No announcements yet</p>
                        <p class="empty-state__text">Check back soon for updates from the school office.</p>
                    </div>
                @else
                    {{-- Featured card --}}
                    @if($featured)
                    <article class="card card--announcement card--featured animate-fade-up" aria-label="Pinned announcement">
                        <div class="card__body card__body--lg card__body--flex">
                                @if($featured->is_pinned)
                                    <span class="badge badge--dark card__badge-top">Pinned</span>
                                @endif
                                <h3 class="card__title">{{ $featured->title }}</h3>
                                <p class="card__excerpt">{{ Str::limit($featured->body, 180) }}</p>
                              <div class="card__footer">
                                <span class="card__date">{{ $featured->post_date->format('F j, Y') }}</span>
                                <a href="{{ route('announcements.index') }}#announcement-{{ $featured->id }}" class="card__read-more">
                                    Read More
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div></div></article>
                    @endif

                    {{-- Secondary 2x2 grid --}}
                    <div class="announcements__secondary">
                        @php
                            $homeCatStyles = [
                                'Academic'  => ['badge' => 'badge--green',  'accent' => 'card__accent-bar--green'],
                                'Notice'    => ['badge' => 'badge--orange', 'accent' => 'card__accent-bar--orange'],
                                'Health'    => ['badge' => 'badge--blue',   'accent' => 'card__accent-bar--blue'],
                                'Community' => ['badge' => 'badge--purple', 'accent' => 'card__accent-bar--purple'],
                                'General'   => ['badge' => 'badge--blue',   'accent' => 'card__accent-bar--blue'],
                            ];
                        @endphp
                        @foreach($secondary as $ann)
                        @php
                            $catStyle = $homeCatStyles[$ann->category] ?? $homeCatStyles['General'];
                        @endphp
                        <article class="card card--announcement animate-fade-up {{ $loop->iteration === 1 ? 'delay-100' : ($loop->iteration === 2 ? 'delay-200' : ($loop->iteration === 3 ? 'delay-300' : 'delay-400')) }}">
                            <div class="card__accent-bar {{ $catStyle['accent'] }}" aria-hidden="true"></div>
                            <div class="card__body card__body--flex">
                                <div>
                                    <div class="card__meta">
                                        <span class="badge {{ $catStyle['badge'] }}">{{ $ann->category }}</span>
                                        <span class="card__date">{{ $ann->post_date->format('M j, Y') }}</span>
                                    </div>
                                    <h3 class="card__title">{{ $ann->title }}</h3>
                                    <p class="card__excerpt">{{ Str::limit($ann->body, 120) }}</p>
                                </div>
                                <div class="card__footer">
                                    <a href="{{ route('announcements.index') }}#announcement-{{ $ann->id }}" class="card__read-more">
                                        Read More
                                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>


    <div class="stats-banner section--sm" aria-label="School statistics">
        <div class="container">
            <div class="stats-banner__grid">
                <div class="stats-banner__item">
                    <p class="stats-banner__number">{{ $stats_students }}</p>
                    <p class="stats-banner__label">Enrolled Students</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">{{ $stats_teachers }}</p>
                    <p class="stats-banner__label">Dedicated Teachers</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">7</p>
                    <p class="stats-banner__label">Grade Levels (K-6)</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">{{ $stats_years }}</p>
                    <p class="stats-banner__label">Years of Excellence</p>
                </div>
            </div>
        </div>
    </div>


    <section class="section events-section" id="events" aria-labelledby="events-heading">
        <div class="container">

            <div class="section-header-row">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow" id="events-heading">Calendar</p>
                    <h2 class="section-header__title">Upcoming School Events</h2>
                    <p class="section-header__subtitle">Mark your calendars and join us in these upcoming activities.</p>
                </div>
                <a href="{{ route('events.index') }}" class="view-all-link">
                    Full Calendar
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="events__grid">

                @php
                    $eventStyles = [
                        'Academic'  => ['badge' => 'badge--blue',   'dateClass' => 'card__date-block--blue'],
                        'Sports'    => ['badge' => 'badge--green',  'dateClass' => 'card__date-block--green'],
                        'Cultural'  => ['badge' => 'badge--orange', 'dateClass' => 'card__date-block--orange'],
                        'Program'   => ['badge' => 'badge--purple', 'dateClass' => 'card__date-block--purple'],
                        'Community' => ['badge' => 'badge--amber',  'dateClass' => 'card__date-block--amber'],
                        'Health'    => ['badge' => 'badge--red',    'dateClass' => 'card__date-block--red'],
                    ];
                    $delayMap = ['', 'delay-100', 'delay-200', 'delay-300', 'delay-400', 'delay-500'];
                @endphp

                @forelse ($homeEvents as $event)
                    @php
                        $categoryLabel = $event->category ?: 'Academic';
                        $style = $eventStyles[$categoryLabel] ?? $eventStyles['Academic'];
                        $delayClass = $delayMap[$loop->index] ?? '';
                        $startTime = $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('g:i A') : null;
                        $endTime = $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('g:i A') : null;
                        $timeLabel = $startTime ? $startTime : 'Time TBA';
                        if ($startTime && $endTime) {
                            $timeLabel = $startTime . ' - ' . $endTime;
                        }
                        $locationLabel = $event->location ?: 'Location TBA';
                        $desc = $event->description ? Str::limit($event->description, 120) : 'Details coming soon.';
                    @endphp
                    <article class="card animate-fade-up {{ $delayClass }}">
                        <div class="card__body">
                            <div class="card--event">
                                <div class="card__date-block {{ $style['dateClass'] }}" aria-label="{{ $event->event_date->format('M d') }}">
                                    <p class="card__date-day" aria-hidden="true">{{ $event->event_date->format('d') }}</p>
                                    <p class="card__date-month" aria-hidden="true">{{ $event->event_date->format('M') }}</p>
                                </div>
                                <div class="card__event-body">
                                    <span class="badge {{ $style['badge'] }} card__event-badge">{{ $categoryLabel }}</span>
                                    <h3 class="card__event-title">{{ $event->title }}</h3>
                                    <p class="card__excerpt card__excerpt--sm">{{ $desc }}</p>
                                    <p class="card__event-location">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $locationLabel }} &bull; {{ $timeLabel }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="public-empty" style="grid-column:1 / -1;">
                        <p class="public-empty__title">No upcoming events</p>
                        <p class="public-empty__text">Please check back for new activities.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>


    <section class="section achievements" id="achievements" aria-labelledby="achievements-heading">
        <div class="container">

            <div class="section-header">
                <p class="section-header__eyebrow" id="achievements-heading">Hall of Fame</p>
                <h2 class="section-header__title">Academic Achievements</h2>
                <p class="section-header__subtitle">Celebrating the dedication and excellence of our students and school community.</p>
            </div>

                        {{-- Top 3 honor students --}}
            <div class="achievements__podium">
                @php
                    $medals = ['#1', '#2', '#3'];
                    $avatarClasses = ['card__avatar--gold', 'card__avatar--silver', 'card__avatar--bronze'];
                    $delays = ['', 'delay-100', 'delay-200'];
                @endphp

                @forelse ($homeHonors as $index => $honoree)
                    @php
                        $nameParts = preg_split('/\s+/', trim($honoree->student_name));
                        $initials = collect($nameParts)->filter()->map(fn($p) => strtoupper(substr($p, 0, 1)))->take(2)->implode('');
                        $gradeLine = $honoree->grade . ($honoree->section ? ' &mdash; Section ' . $honoree->section : '');
                    @endphp
                    <article class="card card--achievement animate-scale-in {{ $delays[$index] ?? '' }}"
                             aria-label="Honor student: {{ $honoree->student_name }}">
                        <div class="card__body card__body--lg">
                            <span class="card__rank-badge" aria-hidden="true">{{ $medals[$index] ?? '#' }}</span>
                            <div class="card__avatar {{ $avatarClasses[$index] ?? '' }}" aria-hidden="true">
                                {{ $initials }}
                            </div>
                            <h3 class="card__student-name">{{ $honoree->student_name }}</h3>
                            <p class="card__student-grade">{!! $gradeLine !!}</p>
                            <div class="card__average">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                GWA: {{ $honoree->gwa }} &mdash; {{ $honoree->honors }}
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="public-empty">
                        <p class="public-empty__title">No honor roll records yet</p>
                        <p class="public-empty__desc">Honor students will appear here once published.</p>
                    </div>
                @endforelse

            </div>

                        {{-- Competition wins --}}
            <div class="achievements__wins">
                <h3 class="achievements__wins-title">Recent Competition Wins</h3>
                <div class="grid-2">
                    @php
                        $winIcons = [
                            'Science' => 'SCI',
                            'Arts' => 'ART',
                            'Language' => 'LAN',
                        'Sports'    => ['badge' => 'badge--green',  'dateClass' => 'card__date-block--green'],
                        ];
                        $winDelays = ['', 'delay-100', 'delay-200', 'delay-300'];
                    @endphp

                    @forelse ($homeWins as $index => $win)
                        @php
                            $icon = $winIcons[$win->category ?? ''] ?? 'WIN';
                            $dateLabel = $win->event_date ? $win->event_date->format('F Y') : 'Date TBA';
                            $meta = trim(($win->level ?? 'Competition') . ' Level &middot; ' . $dateLabel);
                        @endphp
                        <div class="win-item animate-fade-up {{ $winDelays[$index] ?? '' }}">
                            <span class="win-item__icon" aria-hidden="true">{{ $icon }}</span>
                            <div>
                                <p class="win-item__title">{{ $win->competition_name }}</p>
                                <p class="win-item__meta">{!! $meta !!}</p>
                            </div>
                            <span class="badge {{ $win->place_color }} win-item__place">{{ $win->place }}</span>
                        </div>
                    @empty
                        <div class="public-empty">
                            <p class="public-empty__title">No competition wins yet</p>
                            <p class="public-empty__desc">Competition wins will appear here once added.</p>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </section>


    <section class="section gallery-section" id="gallery" aria-labelledby="gallery-heading">
        <div class="container">
            <div class="section-header-row">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow" id="gallery-heading">School Gallery</p>
                    <h2 class="section-header__title">Moments &amp; Memories</h2>
                    <p class="section-header__subtitle">A glimpse of learning, celebrations, and community highlights.</p>
                </div>
                <a href="{{ route('gallery.index') }}" class="view-all-link">
                    View All Albums
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            @if($homeAlbums->count())
                <div class="album-grid">
                    @foreach($homeAlbums as $album)
                        @php
                            $albumPhotos = $album->photos->take(4);
                            $photoCount = $album->published_photos_count ?? $album->photos_count ?? $album->photos->count();
                        @endphp
                        <a href="{{ route('gallery.show', $album) }}" class="album-card">
                            <div class="album-collage">
                                @forelse($albumPhotos as $photo)
                                    @php
                                        $caption = $photo->caption ?: ($photo->original_name ?: 'Album photo');
                                        $slotClass = $loop->first ? 'album-collage__item--lg' : '';
                                    @endphp
                                    <div class="album-collage__item {{ $slotClass }}">
                                        <img src="{{ $photo->url }}"
                                             alt="{{ $caption }}"
                                             loading="lazy"
                                             decoding="async" />
                                    </div>
                                @empty
                                    <div class="album-collage__empty">
                                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>No photos yet</span>
                                    </div>
                                @endforelse
                            </div>
                            <div class="album-card__meta">
                                <p class="album-card__title">{{ $album->name }}</p>
                                <p class="album-card__count">{{ $photoCount }} photo{{ $photoCount === 1 ? '' : 's' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="public-empty">
                    <p class="public-empty__title">No gallery albums yet</p>
                    <p class="public-empty__desc">Albums will appear here once photos are published.</p>
                </div>
            @endif
        </div>
    </section>


    <section class="section about-preview" id="about" aria-labelledby="about-heading">
        <div class="container">
            <div class="split">

                {{-- Visual --}}
                <div class="about-preview__visual animate-scale-in">
                    <div class="about-preview__img-wrap">
                        <span class="about-preview__school-icon animate-float-slow" aria-hidden="true">School</span>
                    </div>
                    <div class="about-preview__values" aria-label="Core values">
                        <span class="about-preview__value">
                            <span class="about-preview__value-dot about-preview__value-dot--blue" aria-hidden="true"></span>
                            Excellence
                        </span>
                        <span class="about-preview__value">
                            <span class="about-preview__value-dot about-preview__value-dot--green" aria-hidden="true"></span>
                            Integrity
                        </span>
                        <span class="about-preview__value">
                            <span class="about-preview__value-dot about-preview__value-dot--orange" aria-hidden="true"></span>
                            Service
                        </span>
                    </div>
                </div>

                {{-- Text --}}
                <div class="animate-fade-up">
                    <p class="section-header__eyebrow" id="about-heading">About Us</p>
                    <h2 class="section-header__title about-preview__title">
                        A Place to Learn,<br/>Grow &amp; Belong
                    </h2>
                    <p class="text-lead about-preview__lead">
                        Taboc Elementary School is a public school dedicated to providing quality, inclusive, and relevant
                        basic education to every Filipino child in the community.
                    </p>
                    <p class="text-lead about-preview__lead">
                        Anchored on the DepEd vision of producing functionally literate and patriotic Filipinos, our teachers
                        nurture the holistic development of every learner - academically, physically, emotionally, and morally.
                    </p>

                    <div class="about-preview__info-grid">
                        <div class="about-info-card">
                            <p class="about-info-card__label">School Head</p>
                            <p class="about-info-card__value">{{ $school_head }}</p>
                            <p class="about-info-card__sub">{{ $school_head_title }}</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Grade Levels</p>
                            <p class="about-info-card__value">Kindergarten - Grade 6</p>
                            <p class="about-info-card__sub">DepEd Curriculum</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Class Hours</p>
                            <p class="about-info-card__value">{{ $class_hours }}</p>
                            <p class="about-info-card__sub">Monday to Friday</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Location</p>
                            <p class="about-info-card__value">{{ $school_location }}</p>
                            <p class="about-info-card__sub">DepEd Region I</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>


    <section class="section cta-section" id="contact" aria-labelledby="contact-heading">
        <div class="container cta-section__inner">

            <p class="section-header__eyebrow cta-section__eyebrow" id="contact-heading">Get In Touch</p>
            <h2 class="cta-section__title">We're Here to Help</h2>
            <p class="cta-section__subtitle">
                Have questions about enrollment, events, or school activities?
                Reach out to the Taboc Elementary School office anytime.
            </p>

            <div class="cta-contacts">
                <div class="cta-contact-item">
                    <div class="cta-contact-item__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="cta-contact-item__label">Address</p>
                        <p class="cta-contact-item__value">{{ $school_location }}</p>
                    </div>
                </div>
                <div class="cta-contact-item">
                    <div class="cta-contact-item__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="cta-contact-item__label">Phone</p>
                        <p class="cta-contact-item__value">(Insert phone number)</p>
                    </div>
                </div>
                <div class="cta-contact-item">
                    <div class="cta-contact-item__icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="cta-contact-item__label">Email</p>
                        <p class="cta-contact-item__value">taboc.es@deped.gov.ph</p>
                    </div>
                </div>
            </div>

            <a href="mailto:taboc.es@deped.gov.ph" class="btn btn--white btn--lg">
                Send Us a Message
                <svg class="btn__arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </a>

        </div>
    </section>


@endsection


@push('scripts')
<script>
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });

    const navToggle  = document.getElementById('navToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const iconMenu   = document.getElementById('iconMenu');
    const iconClose  = document.getElementById('iconClose');

    navToggle.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.toggle('open');
        mobileMenu.setAttribute('aria-hidden', String(!isOpen));
        iconMenu.classList.toggle('hidden', isOpen);
        iconClose.classList.toggle('hidden', !isOpen);
        navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    // Close menu on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            mobileMenu.setAttribute('aria-hidden', 'true');
            iconMenu.classList.remove('hidden');
            iconClose.classList.add('hidden');
            navToggle.setAttribute('aria-expanded', 'false');
        });
    });

    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar__link');

    const normalizeLink = (link) => {
        try {
            const url = new URL(link.getAttribute('href'), window.location.origin);
            return { path: url.pathname, hash: url.hash };
        } catch (error) {
            return { path: '', hash: '' };
        }
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            }

            const targetId = entry.target.id;
            navLinks.forEach(link => {
                const { path, hash } = normalizeLink(link);
                const isSamePage = path === window.location.pathname;
                const isSectionMatch = isSamePage && hash === `#${targetId}`;
                const isHomeMatch = isSamePage && targetId === 'home' && hash === '';

                link.classList.toggle('active', isSectionMatch || isHomeMatch);
            });
        });
    }, { rootMargin: '-30% 0px -60% 0px' });

    sections.forEach(section => observer.observe(section));
</script>
@endpush





