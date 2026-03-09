{{-- resources/views/components/layouts/auth.blade.php --}}
{{-- Standalone layout used by the AdminLogin Livewire component via #[Layout] --}}
{{-- Does NOT include navbar or footer --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ $title ?? 'Admin Login — Taboc Elementary School' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css'])

    <style>
        /* ══════════════════════════════════════════
           LOGIN PAGE — scoped styles
           (same CSS as the original login.blade.php)
        ═══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Livewire wraps content in a <div> — make it stretch full height */
        body > div {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .login-shell {
            display: flex;
            flex: 1;
            width: 100%;
            min-height: 100vh;
        }

        /* LEFT PANEL */
        .login-left {
            width: 45%;
            background: #1a56db;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            overflow: hidden;
            flex-shrink: 0;
            min-height: 100vh;    /* always full height */
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 420px; height: 420px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            pointer-events: none;
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }

        .login-left__pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .login-brand {
            position: relative; z-index: 1;
            display: flex; align-items: center; gap: .875rem;
        }

        .login-brand__icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }

        .login-brand__icon svg { width: 22px; height: 22px; color: white; }

        .login-brand__name {
            font-family: 'Fraunces', serif;
            font-size: 1.1rem; font-weight: 700;
            color: white; line-height: 1.15;
        }

        .login-brand__sub {
            font-size: .72rem; color: rgba(255,255,255,0.65);
            letter-spacing: .06em; font-weight: 500;
        }

        .login-left__center {
            position: relative; z-index: 1;
            flex: 1; display: flex; flex-direction: column;
            justify-content: center; padding-block: 2rem;
        }

        .login-left__badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 999px;
            padding: .3rem .875rem;
            font-size: .72rem; font-weight: 600;
            color: rgba(255,255,255,0.9);
            letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 1.75rem; width: fit-content;
        }

        .login-left__badge-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 8px rgba(74,222,128,.7);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.6; transform:scale(.85); }
        }

        .login-left__heading {
            font-family: 'Fraunces', serif;
            font-size: clamp(2rem, 3.5vw, 2.75rem);
            font-weight: 900; color: white;
            line-height: 1.08; letter-spacing: -.02em;
            margin-bottom: 1.25rem;
        }

        .login-left__heading em {
            font-style: normal; position: relative; display: inline-block;
        }

        .login-left__heading em::after {
            content: '';
            position: absolute; left: 0; right: 0; bottom: -4px;
            height: 3px; border-radius: 999px;
            background: rgba(255,255,255,0.45);
        }

        .login-left__quote {
            font-size: .95rem; color: rgba(255,255,255,0.72);
            line-height: 1.75; max-width: 360px;
            border-left: 3px solid rgba(255,255,255,0.25);
            padding-left: 1rem; margin-bottom: 2.5rem;
        }

        .login-stats { display: flex; gap: 1.5rem; }

        .login-stat { display: flex; flex-direction: column; }

        .login-stat__num {
            font-family: 'Fraunces', serif;
            font-size: 1.6rem; font-weight: 800;
            color: white; line-height: 1;
        }

        .login-stat__label {
            font-size: .68rem; color: rgba(255,255,255,0.55);
            text-transform: uppercase; letter-spacing: .08em;
            font-weight: 600; margin-top: 3px;
        }

        .login-stat-divider {
            width: 1px; background: rgba(255,255,255,0.15); align-self: stretch;
        }

        .login-left__footer {
            position: relative; z-index: 1;
            font-size: .72rem; color: rgba(255,255,255,0.4);
            display: flex; align-items: center; gap: .5rem;
        }

        .login-left__footer::before {
            content: ''; width: 20px; height: 1px;
            background: rgba(255,255,255,0.25);
        }

        /* RIGHT PANEL */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background: white;
            min-height: 100vh;
            overflow-y: auto;
        }

        .login-form-wrap { width: 100%; max-width: 400px; }

        .login-form-header { margin-bottom: 2rem; }

        .login-form-eyebrow {
            font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: #1a56db; margin-bottom: .5rem;
        }

        .login-form-title {
            font-family: 'Fraunces', serif;
            font-size: 1.85rem; font-weight: 800;
            color: #0f172a; line-height: 1.1;
            letter-spacing: -.02em; margin-bottom: .5rem;
        }

        .login-form-subtitle {
            font-size: .875rem; color: #64748b; line-height: 1.6;
        }

        /* Alerts */
        .login-alert {
            display: flex; align-items: flex-start; gap: .75rem;
            padding: .875rem 1rem; border-radius: 10px;
            font-size: .825rem; line-height: 1.5;
            margin-bottom: 1.5rem; border: 1px solid transparent;
            animation: fadeSlideDown .3s ease both;
        }

        @keyframes fadeSlideDown {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .login-alert svg { width:16px; height:16px; flex-shrink:0; margin-top:1px; }
        .login-alert--error   { background:#fef2f2; border-color:#fecaca; color:#991b1b; }
        .login-alert--locked  { background:#fff7ed; border-color:#fed7aa; color:#92400e; }
        .login-alert--warning { background:#fefce8; border-color:#fef08a; color:#854d0e; }

        /* Fields */
        .login-field { margin-bottom: 1.25rem; }

        .login-label {
            display: block; font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #334155; margin-bottom: .5rem;
        }

        .login-field-error {
            font-size: .75rem; color: #dc2626;
            margin-top: .375rem;
        }

        .login-input-wrap { position: relative; }

        .login-input {
            width: 100%;
            padding: .75rem 1rem .75rem 2.75rem;
            font-family: inherit; font-size: .9rem;
            color: #0f172a; background: #f8fafc;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            transition: border-color .15s, box-shadow .15s, background .15s;
            outline: none;
        }

        .login-input:focus {
            border-color: #1a56db; background: white;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        .login-input.error {
            border-color: #ef4444; background: #fef2f2;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
        }

        .login-input-icon {
            position: absolute; left: .875rem; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; color: #94a3b8;
            pointer-events: none; transition: color .15s;
        }

        .login-input-wrap:focus-within .login-input-icon { color: #1a56db; }

        .login-pw-toggle {
            position: absolute; right: .875rem; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px; color: #94a3b8; cursor: pointer;
            transition: color .15s; background: none; border: none; padding: 0;
            display: flex; align-items: center; justify-content: center;
        }

        .login-pw-toggle:hover { color: #1a56db; }
        .login-pw-toggle svg { width: 16px; height: 16px; }

        .login-input-wrap:has(.login-pw-toggle) .login-input { padding-right: 2.75rem; }

        /* Meta row */
        .login-meta {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem; flex-wrap: wrap; gap: .5rem;
        }

        .login-check {
            display: flex; align-items: center; gap: .5rem;
            cursor: pointer; user-select: none;
        }

        .login-check input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: #1a56db; cursor: pointer;
        }

        .login-check-label { font-size: .8rem; color: #64748b; }

        .login-attempts {
            font-size: .75rem; color: #94a3b8;
            display: flex; align-items: center; gap: .35rem;
        }

        .login-attempts svg { width: 12px; height: 12px; }

        /* Submit button */
        .login-btn {
            width: 100%; padding: .8rem 1.5rem;
            background: #1a56db; color: white;
            font-family: inherit; font-size: .9rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            transition: background .15s, box-shadow .15s, transform .1s;
            box-shadow: 0 4px 14px rgba(26,86,219,.3);
            letter-spacing: .01em;
        }

        .login-btn:hover { background: #1342b0; box-shadow: 0 6px 20px rgba(26,86,219,.4); }
        .login-btn:active { transform: scale(.98); }
        .login-btn:disabled { background: #94a3b8; box-shadow: none; cursor: not-allowed; transform: none; }
        .login-btn--loading { opacity: .85; }
        .login-btn svg { width: 16px; height: 16px; }

        .login-btn__spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Countdown */
        .login-countdown {
            font-weight: 700; font-variant-numeric: tabular-nums; color: #d97706;
        }

        /* Security badges */
        .login-security {
            display: flex; align-items: center; justify-content: center;
            gap: 1rem; margin-top: 1.5rem; padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .login-security-badge {
            display: flex; align-items: center; gap: .35rem;
            font-size: .68rem; font-weight: 600; color: #94a3b8;
            text-transform: uppercase; letter-spacing: .06em;
        }

        .login-security-badge svg { width: 12px; height: 12px; color: #16a34a; }

        .login-security-sep {
            width: 3px; height: 3px; border-radius: 50%; background: #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-shell { flex-direction: column; }
            .login-left { width: 100%; min-height: 280px; padding: 2rem; }
            .login-left__center { padding-block: 1.5rem; }
            .login-left__heading { font-size: 1.75rem; }
            .login-right { padding: 2rem 1.25rem; }
            .login-stats { gap: 1rem; }
        }

        /* Entrance animations */
        .login-left__badge   { animation: fadeUp .5s .1s both; }
        .login-left__heading { animation: fadeUp .5s .2s both; }
        .login-left__quote   { animation: fadeUp .5s .3s both; }
        .login-stats         { animation: fadeUp .5s .4s both; }
        .login-form-header   { animation: fadeUp .5s .15s both; }
        .login-field         { animation: fadeUp .45s both; }
        .login-field:nth-child(1) { animation-delay: .2s; }
        .login-field:nth-child(2) { animation-delay: .28s; }
        .login-meta          { animation: fadeUp .45s .35s both; }
        .login-btn           { animation: fadeUp .45s .42s both; }
        .login-security      { animation: fadeUp .45s .5s both; }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }
    </style>

    @livewireStyles
</head>
<body>

    {{ $slot }}

    @livewireScripts
</body>
</html>