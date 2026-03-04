{{-- resources/views/layouts/admin.blade.php --}}
{{-- Admin shell layout. Usage in every admin page:
     @extends('layouts.admin')
     @section('title', 'Page Title')
     @section('breadcrumb') ... @endsection
     @section('page-actions') ... @endsection
     @section('content') ... @endsection
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin') — Taboc Elementary</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700;9..144,800;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
</head>

    @include('partials.admin.modal-scripts')

<body>

<div class="admin-shell">

    {{-- ══════════════════════════ SIDEBAR ══════════════════════════ --}}
    @include('partials.admin.sidebar')

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- ══════════════════════════ MAIN ══════════════════════════ --}}
    <main class="admin-main" id="adminMain">

        {{-- TOP BAR --}}
        <header class="topbar">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <nav class="topbar__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="topbar__breadcrumb-sep">/</span>
                <span class="topbar__breadcrumb-current">@yield('breadcrumb', 'Overview')</span>
            </nav>

            <div class="topbar__spacer"></div>

            <div class="topbar__actions">
                {{-- Notifications --}}
                <button class="topbar__icon-btn tooltip" data-tip="Notifications" aria-label="Notifications">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="topbar__notif-dot" aria-hidden="true"></span>
                </button>

                {{-- View site --}}
                <a href="{{ url('/') }}" target="_blank" class="topbar__icon-btn tooltip" data-tip="View Site" aria-label="View public site">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                {{-- Admin avatar --}}
                <div class="topbar__avatar" aria-label="Admin user">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="admin-content">

            {{-- Page header --}}
            <div class="page-header animate-fade-up">
                <div>
                    <h1 class="page-header__title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-header__subtitle">@yield('page-subtitle', '')</p>
                </div>
                <div class="page-header__actions">
                    @yield('page-actions')
                </div>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="alert alert--success animate-fade-up" role="alert">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert--danger animate-fade-up" role="alert">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Main page content --}}
            @yield('content')

        </div>
    </main>

</div>{{-- /admin-shell --}}


{{-- ══════════════════════════ SCRIPTS ══════════════════════════ --}}
<script>
    // ── Sidebar toggle (mobile) ──
    const sidebarEl  = document.getElementById('sidebar');
    const overlayEl  = document.getElementById('sidebarOverlay');
    const toggleBtn  = document.getElementById('sidebarToggle');

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

@stack('scripts')

</body>
</html>