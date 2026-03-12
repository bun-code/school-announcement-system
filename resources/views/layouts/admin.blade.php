{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @php
        $rawTitle = $title ?? trim($__env->yieldContent('title', 'Admin'));
        $rawTitle = str_replace('&amp;', '&', $rawTitle);
    @endphp
    <title>{{ $rawTitle }} - Taboc Elementary</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700;9..144,800;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @livewireStyles
    @stack('styles')
</head>

    @include('partials.admin.modal-scripts')

<body>

<div class="admin-shell">

    {{-- SIDEBAR --}}
    @include('partials.admin.sidebar')

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- MAIN --}}
    <main class="admin-main" id="adminMain">

        {{-- TOP BAR --}}
        <header class="topbar">
            @php
                $adminNotifAnnouncements = \App\Models\Announcement::published()
                    ->active()
                    ->latest('post_date')
                    ->take(3)
                    ->get();
                $adminNotifEvents = \App\Models\Event::upcoming()
                    ->take(3)
                    ->get();
                $adminNotifCount = $adminNotifAnnouncements->count() + $adminNotifEvents->count();
            @endphp
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <nav class="topbar__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="topbar__breadcrumb-sep">/</span>
                <span class="topbar__breadcrumb-current">
                    {{ $breadcrumb ?? (
                        request()->routeIs('admin.faculty.*') ? 'Faculty & Staff' :
                        (request()->routeIs('admin.events.*') ? 'Events & Calendar' :
                        (request()->routeIs('admin.settings.*') ? 'Settings' :
                        (request()->routeIs('admin.announcements.*') ? 'Announcements' : 'Overview')))
                    ) }}
                </span>
            </nav>

            <div class="topbar__spacer"></div>

            <div class="topbar__actions">
                <button
                    type="button"
                    class="topbar__icon-btn"
                    aria-label="Notifications"
                    aria-controls="modalAdminNotifications"
                    onclick="openModal('modalAdminNotifications')"
                >
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($adminNotifCount > 0)
                        <span class="topbar__notif-dot" aria-hidden="true"></span>
                    @endif
                </button>

                <a href="{{ url('/') }}" target="_blank" class="topbar__icon-btn" aria-label="View public site">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <div class="topbar__avatar" aria-label="Admin user">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="admin-content">

            {{-- Page header --}}
            @php
                $hidePageHeader = $suppressPageHeader ?? 
                    request()->routeIs('admin.announcements.*') ||
                    request()->routeIs('admin.faculty.*') ||
                    request()->routeIs('admin.events.*') ||
                    request()->routeIs('admin.settings.*');
            @endphp
            @if(!$hidePageHeader)
                <div class="page-header animate-fade-up">
                    <div>
                        <h1 class="page-header__title">
                            {!! $pageTitle ?? trim($__env->yieldContent('page-title', 'Dashboard')) !!}
                        </h1>
                        <p class="page-header__subtitle">
                            {!! $pageSubtitle ?? trim($__env->yieldContent('page-subtitle', '')) !!}
                        </p>
                    </div>
                    <div class="page-header__actions" id="page-actions-target">
                        @if(!empty($pageActions))
                            {!! $pageActions !!}
                        @else
                            @yield('page-actions')
                        @endif
                    </div>
                </div>
            @endif

            {{-- Main page content --}}
            {{ $slot ?? '' }}
            @yield('content')

        </div>
    </main>

</div>{{-- /admin-shell --}}

{{-- Modal helper scripts --}}
@include('partials.admin.modal-scripts')

    {{-- Sidebar toggle --}}
<script>
    const sidebarEl = document.getElementById('sidebar');
    const overlayEl = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebarEl.classList.add('open');
        overlayEl.classList.add('open');
        toggleBtn.setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        sidebarEl.classList.remove('open');
        overlayEl.classList.remove('open');
        toggleBtn.setAttribute('aria-expanded', 'false');
    }

    toggleBtn.addEventListener('click', () => {
        sidebarEl.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlayEl.addEventListener('click', closeSidebar);
</script>


<div id="admin-toast" class="admin-toast" role="status" aria-live="polite" style="display:none;"></div>
<script>
    (function () {
        const toast = document.getElementById('admin-toast');
        if (!toast) return;

        let toastTimer = null;

        function showAdminToast(type, message) {
            toast.className = `admin-toast admin-toast--${type}`;
            toast.textContent = message;
            toast.style.display = 'flex';
            if (toastTimer) clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.style.display = 'none';
            }, 3500);
        }

        window.showAdminToast = showAdminToast;

        window.addEventListener('notify', (event) => {
            const detail = event.detail || {};
            const type = detail.type || 'success';
            const message = detail.message || 'Saved successfully.';
            showAdminToast(type, message);
        });

        @if (session('success'))
            showAdminToast('success', @json(session('success')));
        @endif
        @if (session('error'))
            showAdminToast('error', @json(session('error')));
        @endif
    })();
</script>

@livewireScripts
@stack('scripts')

@include('partials.admin.modal-notifications', [
    'adminNotifAnnouncements' => $adminNotifAnnouncements,
    'adminNotifEvents' => $adminNotifEvents,
    'adminNotifCount' => $adminNotifCount,
])
@include('partials.admin.modal-logout-confirm')

</body>
</html>
