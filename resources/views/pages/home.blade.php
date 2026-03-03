{{-- pages/home.blade.php --}}
{{-- Extends the public layout (layouts/home.blade.php → app.blade.php) --}}
{{-- Navbar & Footer are injected automatically via app.blade.php         --}}

@extends('layouts.home')

@section('title', 'Taboc Elementary School — Home')
@section('meta_description', 'Taboc Elementary School — Nurturing young minds with quality education, character values, and a caring community.')

@section('page_content')


    {{-- ╔══════════════════════════════════════════════╗
         ║                  HERO                        ║
         ╚══════════════════════════════════════════════╝ --}}
    <section class="hero" id="home" aria-label="Hero section">
        <div class="container">
            <div class="hero__content">

                {{-- Enrollment pill --}}
                <div class="hero__pill animate-fade-up">
                    <span class="hero__pill-dot" aria-hidden="true"></span>
                    S.Y. 2025–2026 Enrollment Now Open
                </div>

                {{-- Heading --}}
                <h1 class="hero__title animate-fade-up delay-100">
                    Where Every Child<br/>
                    <span class="hero__title-accent text-gradient">Learns, Grows</span><br/>
                    &amp; Thrives
                </h1>

                {{-- Description --}}
                <p class="hero__desc animate-fade-up delay-200">
                    Taboc Elementary School is committed to nurturing every learner's potential through quality,
                    inclusive education grounded in Filipino values and excellence.
                </p>

                {{-- CTA buttons --}}
                <div class="hero__actions animate-fade-up delay-300">
                    <a href="#announcements" class="btn btn--primary btn--lg">
                        Latest Updates
                        <svg class="btn__arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                    <a href="#about" class="btn btn--ghost btn--lg">
                        About Our School
                    </a>
                </div>

                {{-- Stats --}}
                <div class="hero__stats animate-fade-up delay-400">
                    <div>
                        <p class="hero__stat-number">500+</p>
                        <p class="hero__stat-label">Students</p>
                    </div>
                    <div class="hero__stat-divider" aria-hidden="true"></div>
                    <div>
                        <p class="hero__stat-number">30+</p>
                        <p class="hero__stat-label">Teachers</p>
                    </div>
                    <div class="hero__stat-divider" aria-hidden="true"></div>
                    <div>
                        <p class="hero__stat-number">20+</p>
                        <p class="hero__stat-label">Years</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ╔══════════════════════════════════════════════╗
         ║             NEWS TICKER STRIP                ║
         ╚══════════════════════════════════════════════╝ --}}
    <div class="ticker" aria-label="News ticker" role="marquee">
        <div class="ticker__track">
            {{-- First set --}}
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Enrollment for S.Y. 2025-2026 is now open — Grades Kinder to 6</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> 3rd Quarter Examinations — March 15 to 19, 2026</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Taboc ES wins 1st Place at Regional Science Quiz Bee 2026</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Early dismissal on February 26 — Classes end at 11:00 AM</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Intramurals 2026 — March 22 at the School Grounds</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> School Feeding Program resumes March 3, 2026</span>
            {{-- Duplicated for seamless infinite loop --}}
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Enrollment for S.Y. 2025-2026 is now open — Grades Kinder to 6</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> 3rd Quarter Examinations — March 15 to 19, 2026</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Taboc ES wins 1st Place at Regional Science Quiz Bee 2026</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Early dismissal on February 26 — Classes end at 11:00 AM</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> Intramurals 2026 — March 22 at the School Grounds</span>
            <span class="ticker__item"><span class="ticker__dot" aria-hidden="true"></span> School Feeding Program resumes March 3, 2026</span>
        </div>
    </div>


    {{-- ╔══════════════════════════════════════════════╗
         ║             ANNOUNCEMENTS                    ║
         ╚══════════════════════════════════════════════╝ --}}
    <section class="section announcements" id="announcements" aria-labelledby="announcements-heading">
        <div class="container">

            <div class="section-header-row">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow" id="announcements-heading">Announcements</p>
                    <h2 class="section-header__title">Latest News &amp; Notices</h2>
                    <p class="section-header__subtitle">Stay informed with important updates from the school office.</p>
                </div>
                <a href="#" class="view-all-link">
                    View All
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="announcements__grid">

                {{-- Featured card --}}
                <article class="card card--announcement card--featured animate-fade-up" aria-label="Pinned announcement">
                    <div class="card__body card__body--lg card__body--flex">
                        <div>
                            <span class="badge badge--dark card__badge-top">📌 &nbsp;Pinned</span>
                            <h3 class="card__title">School Year 2025–2026 Enrollment is Now Open</h3>
                            <p class="card__excerpt">
                                Enrollment for incoming Grade 1 and qualified transferees is officially open.
                                Visit the school registrar's office during school hours. Slots are limited — secure your child's place today.
                            </p>
                        </div>
                        <div class="card__footer">
                            <span class="card__date">March 1, 2026</span>
                            <a href="#" class="card__read-more">
                                Read More
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Secondary 2×2 grid --}}
                <div class="announcements__secondary">

                    <article class="card card--announcement animate-fade-up delay-100">
                        <div class="card__accent-bar card__accent-bar--green" aria-hidden="true"></div>
                        <div class="card__body card__body--flex">
                            <div>
                                <div class="card__meta">
                                    <span class="badge badge--green">Academic</span>
                                    <span class="card__date">Feb 28, 2026</span>
                                </div>
                                <h3 class="card__title">3rd Quarter Exam Schedule Released</h3>
                                <p class="card__excerpt">The examination schedule for all grade levels has been posted. Parents are advised to help students review and prepare.</p>
                            </div>
                            <div class="card__footer">
                                <a href="#" class="card__read-more">
                                    Read More
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>

                    <article class="card card--announcement animate-fade-up delay-200">
                        <div class="card__accent-bar card__accent-bar--orange" aria-hidden="true"></div>
                        <div class="card__body card__body--flex">
                            <div>
                                <div class="card__meta">
                                    <span class="badge badge--orange">Notice</span>
                                    <span class="card__date">Feb 25, 2026</span>
                                </div>
                                <h3 class="card__title">Early Dismissal — February 26</h3>
                                <p class="card__excerpt">Classes will end at 11:00 AM due to a faculty development seminar. Parents are requested to pick up children promptly.</p>
                            </div>
                            <div class="card__footer">
                                <a href="#" class="card__read-more">
                                    Read More
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>

                    <article class="card card--announcement animate-fade-up delay-300">
                        <div class="card__accent-bar card__accent-bar--blue" aria-hidden="true"></div>
                        <div class="card__body card__body--flex">
                            <div>
                                <div class="card__meta">
                                    <span class="badge badge--blue">Health</span>
                                    <span class="card__date">Feb 20, 2026</span>
                                </div>
                                <h3 class="card__title">School Feeding Program Resumes</h3>
                                <p class="card__excerpt">The DepEd-funded feeding program for identified learners resumes starting March 3. Contact the guidance office for inquiries.</p>
                            </div>
                            <div class="card__footer">
                                <a href="#" class="card__read-more">
                                    Read More
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>

                    <article class="card card--announcement animate-fade-up delay-400">
                        <div class="card__accent-bar card__accent-bar--purple" aria-hidden="true"></div>
                        <div class="card__body card__body--flex">
                            <div>
                                <div class="card__meta">
                                    <span class="badge badge--purple">Community</span>
                                    <span class="card__date">Feb 18, 2026</span>
                                </div>
                                <h3 class="card__title">Brigada Eskwela Volunteers Needed</h3>
                                <p class="card__excerpt">We invite parents and community members to join Brigada Eskwela prep activities. Sign up at the principal's office.</p>
                            </div>
                            <div class="card__footer">
                                <a href="#" class="card__read-more">
                                    Read More
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            </div>

        </div>
    </section>


    {{-- ╔══════════════════════════════════════════════╗
         ║              STATS BANNER                    ║
         ╚══════════════════════════════════════════════╝ --}}
    <div class="stats-banner section--sm" aria-label="School statistics">
        <div class="container">
            <div class="stats-banner__grid">
                <div class="stats-banner__item">
                    <p class="stats-banner__number">500<span class="stats-banner__plus">+</span></p>
                    <p class="stats-banner__label">Enrolled Students</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">30<span class="stats-banner__plus">+</span></p>
                    <p class="stats-banner__label">Dedicated Teachers</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">7</p>
                    <p class="stats-banner__label">Grade Levels (K–6)</p>
                </div>
                <div class="stats-banner__item">
                    <p class="stats-banner__number">20<span class="stats-banner__plus">+</span></p>
                    <p class="stats-banner__label">Years of Excellence</p>
                </div>
            </div>
        </div>
    </div>


    {{-- ╔══════════════════════════════════════════════╗
         ║                 EVENTS                       ║
         ╚══════════════════════════════════════════════╝ --}}
    <section class="section events-section" id="events" aria-labelledby="events-heading">
        <div class="container">

            <div class="section-header-row">
                <div class="section-header section-header--left">
                    <p class="section-header__eyebrow" id="events-heading">Calendar</p>
                    <h2 class="section-header__title">Upcoming School Events</h2>
                    <p class="section-header__subtitle">Mark your calendars and join us in these upcoming activities.</p>
                </div>
                <a href="#" class="view-all-link">
                    Full Calendar
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="events__grid">

                @php
                    $events = [
                        [
                            'day'      => '15',
                            'month'    => 'MAR',
                            'badge'    => ['label' => 'Academic', 'class' => 'badge--blue'],
                            'dateClass'=> 'card__date-block--blue',
                            'title'    => '3rd Quarter Academic Awards Day',
                            'desc'     => 'Recognizing outstanding students for academic excellence and commendable conduct throughout the third quarter.',
                            'location' => 'School Gymnasium',
                            'time'     => '8:00 AM',
                            'delay'    => '',
                        ],
                        [
                            'day'      => '22',
                            'month'    => 'MAR',
                            'badge'    => ['label' => 'Sports', 'class' => 'badge--green'],
                            'dateClass'=> 'card__date-block--green',
                            'title'    => 'Intramurals 2026 — Sports Festival',
                            'desc'     => 'A full day of friendly competition in basketball, volleyball, track and field, and many more exciting events.',
                            'location' => 'School Grounds',
                            'time'     => 'All Day',
                            'delay'    => 'delay-100',
                        ],
                        [
                            'day'      => '28',
                            'month'    => 'MAR',
                            'badge'    => ['label' => 'Cultural', 'class' => 'badge--orange'],
                            'dateClass'=> 'card__date-block--orange',
                            'title'    => 'Nutrition Month — Poster & Essay Making',
                            'desc'     => 'Students compete in poster-making and essay contests promoting good nutrition and healthy eating habits.',
                            'location' => 'Classrooms',
                            'time'     => '9:00 AM',
                            'delay'    => 'delay-200',
                        ],
                        [
                            'day'      => '05',
                            'month'    => 'APR',
                            'badge'    => ['label' => 'Program', 'class' => 'badge--purple'],
                            'dateClass'=> 'card__date-block--purple',
                            'title'    => 'Culminating Program — 3rd Quarter',
                            'desc'     => 'A celebration of learning, talent, and culture where each class showcases what they have learned throughout the quarter.',
                            'location' => 'School Gymnasium',
                            'time'     => '7:30 AM',
                            'delay'    => 'delay-300',
                        ],
                    ];
                @endphp

                @foreach ($events as $event)
                    <article class="card animate-fade-up {{ $event['delay'] }}">
                        <div class="card__body">
                            <div class="card--event">
                                <div class="card__date-block {{ $event['dateClass'] }}" aria-label="{{ $event['month'] }} {{ $event['day'] }}">
                                    <p class="card__date-day" aria-hidden="true">{{ $event['day'] }}</p>
                                    <p class="card__date-month" aria-hidden="true">{{ $event['month'] }}</p>
                                </div>
                                <div class="card__event-body">
                                    <span class="badge {{ $event['badge']['class'] }} card__event-badge">{{ $event['badge']['label'] }}</span>
                                    <h3 class="card__event-title">{{ $event['title'] }}</h3>
                                    <p class="card__excerpt card__excerpt--sm">{{ $event['desc'] }}</p>
                                    <p class="card__event-location">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $event['location'] }} &bull; {{ $event['time'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>
        </div>
    </section>


    {{-- ╔══════════════════════════════════════════════╗
         ║              ACHIEVEMENTS                    ║
         ╚══════════════════════════════════════════════╝ --}}
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
                    $honorees = [
                        ['initials' => 'MS', 'name' => 'Maria Santos',   'grade' => 'Grade 6 — Section Maharlika', 'gwa' => '99.2', 'medal' => '🥇', 'avatarClass' => 'card__avatar--gold',   'delay' => ''],
                        ['initials' => 'JC', 'name' => 'Juan dela Cruz', 'grade' => 'Grade 6 — Section Kalayaan',  'gwa' => '98.8', 'medal' => '🥈', 'avatarClass' => 'card__avatar--silver', 'delay' => 'delay-100'],
                        ['initials' => 'AR', 'name' => 'Ana Reyes',      'grade' => 'Grade 5 — Section Katipunan','gwa' => '98.4', 'medal' => '🥉', 'avatarClass' => 'card__avatar--bronze', 'delay' => 'delay-200'],
                    ];
                @endphp

                @foreach ($honorees as $honoree)
                    <article class="card card--achievement animate-scale-in {{ $honoree['delay'] }}"
                             aria-label="Honor student: {{ $honoree['name'] }}">
                        <div class="card__body card__body--lg">
                            <span class="card__rank-badge" aria-hidden="true">{{ $honoree['medal'] }}</span>
                            <div class="card__avatar {{ $honoree['avatarClass'] }}" aria-hidden="true">
                                {{ $honoree['initials'] }}
                            </div>
                            <h3 class="card__student-name">{{ $honoree['name'] }}</h3>
                            <p class="card__student-grade">{{ $honoree['grade'] }}</p>
                            <div class="card__average">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                GWA: {{ $honoree['gwa'] }} — With Highest Honors
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>

            {{-- Competition wins --}}
            <div class="achievements__wins">
                <h3 class="achievements__wins-title">🏅 Recent Competition Wins</h3>
                <div class="grid-2">

                    @php
                        $wins = [
                            ['icon' => '🔬', 'title' => 'Regional Science Quiz Bee',     'meta' => 'Regional Level · February 2026',  'badge' => ['label' => '1st Place', 'class' => 'badge--blue'],   'delay' => ''],
                            ['icon' => '🎨', 'title' => 'Division Poster Making Contest', 'meta' => 'Division Level · January 2026',   'badge' => ['label' => '2nd Place', 'class' => 'badge--green'],  'delay' => 'delay-100'],
                            ['icon' => '📖', 'title' => 'District Spelling Bee Champion', 'meta' => 'District Level · December 2025',  'badge' => ['label' => '1st Place', 'class' => 'badge--blue'],   'delay' => 'delay-200'],
                            ['icon' => '🏃', 'title' => 'Athletics — 100m Sprint',        'meta' => 'District Meet · November 2025',   'badge' => ['label' => '1st Place', 'class' => 'badge--orange'], 'delay' => 'delay-300'],
                        ];
                    @endphp

                    @foreach ($wins as $win)
                        <div class="win-item animate-fade-up {{ $win['delay'] }}">
                            <span class="win-item__icon" aria-hidden="true">{{ $win['icon'] }}</span>
                            <div>
                                <p class="win-item__title">{{ $win['title'] }}</p>
                                <p class="win-item__meta">{{ $win['meta'] }}</p>
                            </div>
                            <span class="badge {{ $win['badge']['class'] }} win-item__place">{{ $win['badge']['label'] }}</span>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>


    {{-- ╔══════════════════════════════════════════════╗
         ║              ABOUT PREVIEW                   ║
         ╚══════════════════════════════════════════════╝ --}}
    <section class="section about-preview" id="about" aria-labelledby="about-heading">
        <div class="container">
            <div class="split">

                {{-- Visual --}}
                <div class="about-preview__visual animate-scale-in">
                    <div class="about-preview__img-wrap">
                        <span class="about-preview__school-icon animate-float-slow" aria-hidden="true">🏫</span>
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
                        nurture the holistic development of every learner — academically, physically, emotionally, and morally.
                    </p>

                    <div class="about-preview__info-grid">
                        <div class="about-info-card">
                            <p class="about-info-card__label">School Head</p>
                            <p class="about-info-card__value">Mrs. [Principal Name]</p>
                            <p class="about-info-card__sub">Principal I</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Grade Levels</p>
                            <p class="about-info-card__value">Kindergarten — Grade 6</p>
                            <p class="about-info-card__sub">DepEd Curriculum</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Class Hours</p>
                            <p class="about-info-card__value">7:30 AM – 5:00 PM</p>
                            <p class="about-info-card__sub">Monday to Friday</p>
                        </div>
                        <div class="about-info-card">
                            <p class="about-info-card__label">Location</p>
                            <p class="about-info-card__value">Taboc, Philippines</p>
                            <p class="about-info-card__sub">DepEd Region I</p>
                        </div>
                    </div>

                    <a href="{{ url('/about') }}" class="btn btn--primary btn--lg">
                        Learn More About Us
                        <svg class="btn__arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>


    {{-- ╔══════════════════════════════════════════════╗
         ║              CTA / CONTACT                   ║
         ╚══════════════════════════════════════════════╝ --}}
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
                        <p class="cta-contact-item__value">Taboc, Philippines</p>
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


{{-- ── Page-specific JS pushed to app.blade.php @stack('scripts') ── --}}
@push('scripts')
<script>
    // ── Navbar scroll shadow ──
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });

    // ── Mobile menu toggle ──
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

    // ── Highlight active nav link on scroll ──
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar__link');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.toggle(
                        'active',
                        link.getAttribute('href') === '#' + entry.target.id
                    );
                });
            }
        });
    }, { rootMargin: '-30% 0px -60% 0px' });

    sections.forEach(s => observer.observe(s));
</script>
@endpush