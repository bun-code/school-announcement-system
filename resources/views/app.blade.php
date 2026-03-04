<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('meta_description', 'Taboc Elementary School — Nurturing young minds with quality education, character values, and a caring community.')" />

    <title>@yield('title', 'Taboc Elementary School')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    {{-- Compiled CSS (7-1 architecture via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Per-page extra head content --}}
    @stack('styles')
</head>

    @include('partials.modal-curriculum')
    @include('partials.modal-policies')

<script>
    function openInfoModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeInfoModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    // Close on backdrop click
    document.querySelectorAll('.info-modal-overlay').forEach(el => {
        el.addEventListener('click', e => {
            if (e.target === el) closeInfoModal(el.id);
        });
    });
    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape')
            document.querySelectorAll('.info-modal-overlay.open')
                    .forEach(el => closeInfoModal(el.id));
    });
</script>

<body>

    {{-- Navbar partial --}}
    @include('partials.navbar')

    {{-- Page content --}}
    @yield('content')

    {{-- Footer partial --}}
    @include('partials.footer')

    {{-- Per-page extra scripts --}}
    @stack('scripts')

</body>
</html>