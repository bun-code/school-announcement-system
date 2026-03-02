{{-- partials/navbar.blade.php --}}
{{-- Included automatically via app.blade.php --}}

<nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
    <div class="container navbar__inner">

        {{-- ── Logo ── --}}
        <a href="{{ url('/') }}" class="navbar__logo" aria-label="Taboc Elementary School — Home">
            <div class="navbar__logo-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6zM2 17l10 6 10-6M2 13l10 6 10-6"/>
                </svg>
            </div>
            <div class="navbar__logo-text">
                <span class="navbar__logo-name">Taboc</span>
                <span class="navbar__logo-sub">Elementary School</span>
            </div>
        </a>

        {{-- ── Desktop Links ── --}}
        <div class="navbar__links" role="list">
            <a href="{{ url('/') }}"
               class="navbar__link {{ request()->is('/') ? 'active' : '' }}"
               role="listitem">Home</a>

            <a href="{{ url('/#announcements') }}"
               class="navbar__link"
               role="listitem">Announcements</a>

            <a href="{{ url('/#events') }}"
               class="navbar__link"
               role="listitem">Events</a>

            <a href="{{ url('/#achievements') }}"
               class="navbar__link"
               role="listitem">Achievements</a>

            <a href="{{ url('/about') }}"
               class="navbar__link {{ request()->is('about') ? 'active' : '' }}"
               role="listitem">About</a>
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
        <a href="{{ url('/') }}"              class="navbar__mobile-link" role="menuitem">Home</a>
        <a href="{{ url('/#announcements') }}" class="navbar__mobile-link" role="menuitem">Announcements</a>
        <a href="{{ url('/#events') }}"        class="navbar__mobile-link" role="menuitem">Events</a>
        <a href="{{ url('/#achievements') }}"  class="navbar__mobile-link" role="menuitem">Achievements</a>
        <a href="{{ url('/about') }}"          class="navbar__mobile-link" role="menuitem">About</a>
        <div class="navbar__mobile-divider" aria-hidden="true"></div>
        <a href="{{ url('/#contact') }}" class="btn btn--primary btn--sm" style="width:100%;justify-content:center;">
            Contact Us
        </a>
    </div>
</nav>