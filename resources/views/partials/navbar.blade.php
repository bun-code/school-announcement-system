{{-- partials/navbar.blade.php --}}
{{-- Included automatically via app.blade.php --}}

@php
    /*
     * request()->path() returns '' (empty string) on Laravel's root URL, NOT '/'.
     * We check both to be safe, with routeIs() as a named-route fallback.
     */
    $onHome  = in_array(request()->path(), ['', '/'])
               || request()->routeIs('home');

    $onEnrollment = request()->is('enrollment')
                    || request()->routeIs('enrollment');

    $onFaculty    = request()->is('faculty')
                    || request()->routeIs('faculty');

    $onCalendar   = request()->is('academic-calendar')
                    || request()->routeIs('academic-calendar');

    $onGallery    = request()->is('gallery')
                    || request()->is('gallery/*')
                    || request()->routeIs('gallery.*');
@endphp

<nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
    <div class="container navbar__inner">

        {{-- ── Logo ── --}}
        <a href="{{ url('/') }}" class="navbar__logo" aria-label="Taboc Elementary School — Home">
            <div class="navbar__logo-icon navbar__logo-icon--img">
                <img src="{{ asset('images/Taboc-Logo-removebg-preview.png') }}"
                     alt="Taboc Elementary School logo" />
            </div>
            <div class="navbar__logo-text">
                <span class="navbar__logo-name">Taboc</span>
                <span class="navbar__logo-sub">Elementary School</span>
            </div>
        </a>

        {{-- ── Desktop Links ── --}}
        <div class="navbar__links" role="list">

            <a href="{{ url('/') }}"
               class="navbar__link {{ $onHome ? 'active' : '' }}"
               aria-current="{{ $onHome ? 'page' : 'false' }}"
               role="listitem">Home</a>

            {{-- Anchor links: active only on homepage (JS scroll-spy takes over there) --}}
            <a href="{{ url('/#announcements') }}"
               class="navbar__link"
               role="listitem">Announcements</a>

            <a href="{{ url('/#events') }}"
               class="navbar__link"
               role="listitem">Events</a>

            <a href="{{ url('/#achievements') }}"
               class="navbar__link"
               role="listitem">Achievements</a>

            <a href="{{ route('gallery.index') }}"
               class="navbar__link {{ $onGallery ? 'active' : '' }}"
               aria-current="{{ $onGallery ? 'page' : 'false' }}"
               role="listitem">School Gallery</a>

        </div>

        {{-- ── CTA + Mobile Toggle ── --}}
        <div class="navbar__cta">
            <a href="{{ url('/#contact') }}" class="btn btn--primary btn--sm">
                Contact Us
                <svg class="btn__arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            <button class="navbar__toggle"
                    id="navToggle"
                    aria-label="Toggle mobile menu"
                    aria-expanded="false"
                    aria-controls="mobileMenu">
                <svg id="iconMenu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="iconClose" class="hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- ── Mobile Menu ── --}}
    <div class="navbar__mobile container" id="mobileMenu" role="menu" aria-hidden="true">

        <a href="{{ url('/') }}"
           class="navbar__mobile-link {{ $onHome ? 'active' : '' }}"
           aria-current="{{ $onHome ? 'page' : 'false' }}"
           role="menuitem">Home</a>

        <a href="{{ url('/#announcements') }}"
           class="navbar__mobile-link"
           role="menuitem">Announcements</a>

        <a href="{{ url('/#events') }}"
           class="navbar__mobile-link"
           role="menuitem">Events</a>

        <a href="{{ url('/#achievements') }}"
           class="navbar__mobile-link"
           role="menuitem">Achievements</a>

        <a href="{{ route('gallery.index') }}"
           class="navbar__mobile-link {{ $onGallery ? 'active' : '' }}"
           aria-current="{{ $onGallery ? 'page' : 'false' }}"
           role="menuitem">School Gallery</a>

        <div class="navbar__mobile-divider" aria-hidden="true"></div>

        <p style="font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:8px;padding:0 12px;margin-top:12px;">School Info</p>
        <a href="{{ route('enrollment.index') }}"
           class="navbar__mobile-link"
           role="menuitem">Enrollment</a>
        <a href="{{ route('academic-calendar.index') }}"
           class="navbar__mobile-link"
           role="menuitem">Academic Calendar</a>
        <a href="{{ route('curriculum.index') }}"
           class="navbar__mobile-link"
           role="menuitem">Curriculum (DepEd)</a>
        <a href="{{ route('faculty.index') }}"
           class="navbar__mobile-link"
           role="menuitem">Faculty & Staff</a>
        <a href="{{ route('school-policies.index') }}"
           class="navbar__mobile-link"
           role="menuitem">School Policies</a>

        <div class="navbar__mobile-divider" aria-hidden="true"></div>
        <a href="{{ url('/#contact') }}" class="btn btn--primary btn--sm" style="width:100%;justify-content:center;">
            Contact Us
        </a>
    </div>
</nav>
