{{-- resources/views/partials/admin/sidebar.blade.php --}}

<aside class="sidebar" id="sidebar" aria-label="Admin navigation">

    {{-- Brand --}}
    <div class="sidebar__brand">
        <div class="sidebar__brand-icon">
            <img src="" alt="">
        </div>
        <div class="sidebar__brand-text">
            <p class="sidebar__brand-name">Taboc ES</p>
            <p class="sidebar__brand-sub">Admin Panel</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar__nav" role="navigation" aria-label="Sidebar menu">

        {{-- Overview --}}
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="sidebar__item-label">Overview</span>
        </a>

        {{-- Content section --}}
        <p class="sidebar__section-label">Content</p>

        <a href="{{ route('admin.announcements.index') }}"
           class="sidebar__item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <span class="sidebar__item-label">Announcements</span>
            <span class="sidebar__item-badge">3</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="sidebar__item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="sidebar__item-label">Events &amp; Calendar</span>
        </a>

        <a href="{{ route('admin.achievements.index') }}"
           class="sidebar__item {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <span class="sidebar__item-label">Achievements</span>
        </a>

        <a href="{{ route('admin.gallery.index') }}"
           class="sidebar__item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="sidebar__item-label">Gallery &amp; Media</span>
        </a>

        {{-- People section --}}
        <p class="sidebar__section-label">People</p>

        <a href="{{ route('admin.faculty.index') }}"
           class="sidebar__item {{ request()->routeIs('admin.faculty.*') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="sidebar__item-label">Faculty &amp; Staff</span>
        </a>

        {{-- Settings section --}}
        <p class="sidebar__section-label">System</p>

        <a href="#"
           class="sidebar__item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <svg class="sidebar__item-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="sidebar__item-label">Settings</span>
        </a>

    </nav>

    {{-- User footer --}}
    <div class="sidebar__footer">
        <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
            @csrf
            <div class="sidebar__user" onclick="document.getElementById('logoutForm').submit()">
                <div class="sidebar__user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <p class="sidebar__user-name">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="sidebar__user-role">Administrator</p>
                </div>
            </div>
        </form>
    </div>

</aside>