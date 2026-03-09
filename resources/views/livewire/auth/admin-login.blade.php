{{-- resources/views/livewire/auth/admin-login.blade.php --}}
{{-- Livewire v4 component view for AdminLogin --}}

<div
    {{-- Poll every second ONLY when locked out — zero cost otherwise --}}
    @if($isLockedOut) wire:poll.1000ms="tickLockout" @endif
>

    {{-- ════════════════════════════════════════
         TWO-COLUMN SHELL
    ════════════════════════════════════════ --}}
    <div class="login-shell">

        {{-- ══════════════════════
             LEFT PANEL
        ══════════════════════ --}}
        <div class="login-left">
            <div class="login-left__pattern" aria-hidden="true"></div>

            {{-- Brand --}}
            <div class="login-brand">
                <div class="login-brand__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6zM2 17l10 6 10-6M2 13l10 6 10-6"/>
                    </svg>
                </div>
                <div>
                    <p class="login-brand__name">Taboc Elementary</p>
                    <p class="login-brand__sub">School — Admin Portal</p>
                </div>
            </div>

            {{-- Center --}}
            <div class="login-left__center">

                <div class="login-left__badge">
                    <span class="login-left__badge-dot" aria-hidden="true"></span>
                    Secured Admin Access
                </div>

                <h1 class="login-left__heading">
                    Educating<br/>
                    <em>Minds</em> That<br/>
                    Shape Tomorrow
                </h1>

                <p class="login-left__quote">
                    "The function of education is to teach one to think intensively
                    and to think critically. Intelligence plus character — that is
                    the goal of true education."
                    <br/><br/>
                    <strong style="color:rgba(255,255,255,0.6);font-size:.8rem;">— Martin Luther King Jr.</strong>
                </p>


            </div>

            <p class="login-left__footer">
                DepEd Philippines &bull; S.Y. 2025–2026
            </p>
        </div>

        {{-- ══════════════════════
             RIGHT PANEL
        ══════════════════════ --}}
        <div class="login-right">
            <div class="login-form-wrap">

                {{-- Form header --}}
                <div class="login-form-header">
                    <p class="login-form-eyebrow">Administrator Portal</p>
                    <h2 class="login-form-title">Welcome back</h2>
                    <p class="login-form-subtitle">
                        Sign in with your admin credentials. This portal is restricted
                        to authorized personnel only.
                    </p>
                </div>

                {{-- ── LOCKOUT ALERT ── --}}
                @if ($isLockedOut)
                    <div class="login-alert login-alert--locked" role="alert" aria-live="assertive">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <div>
                            <strong>Account temporarily locked.</strong>
                            Too many failed attempts. Please wait
                            {{-- Live countdown driven by wire:poll + tickLockout() --}}
                            <span class="login-countdown">
                                {{ str_pad(floor($lockoutSeconds / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($lockoutSeconds % 60, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            before trying again.
                        </div>
                    </div>
                @endif

                {{-- ── ERROR / WARNING ALERT ── --}}
                @if ($loginError && !$isLockedOut)
                    <div
                        class="login-alert {{ $attemptsRemaining <= 2 && $attemptsRemaining > 0 ? 'login-alert--warning' : 'login-alert--error' }}"
                        role="alert"
                        aria-live="polite"
                    >
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            @if($attemptsRemaining <= 2 && $attemptsRemaining > 0)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                        <span>{{ $loginError }}</span>
                    </div>
                @endif

                {{-- ── Validation errors (from #[Validate]) ── --}}
                @if ($errors->any())
                    <div class="login-alert login-alert--error" role="alert" aria-live="polite">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul style="margin:0;padding-left:1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ══════════════════════
                     FORM
                ══════════════════════ --}}
                <form wire:submit="login" novalidate>

                    {{-- Email --}}
                    <div class="login-field">
                        <label class="login-label" for="email">Email Address</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input
                                wire:model="email"
                                class="login-input {{ $errors->has('email') ? 'error' : '' }}"
                                type="email"
                                id="email"
                                placeholder="Enter your email"
                                autocomplete="email"
                                {{ $isLockedOut ? 'disabled' : '' }}
                                aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                            />
                        </div>
                        @error('email')
                            <p id="email-error" class="login-field-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="login-field">
                        <label class="login-label" for="password">Password</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input
                                wire:model="password"
                                class="login-input"
                                type="{{ $showPassword ? 'text' : 'password' }}"
                                id="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                {{ $isLockedOut ? 'disabled' : '' }}
                            />
                            {{-- Password toggle — calls Livewire, no JS needed --}}
                            <button
                                type="button"
                                wire:click="togglePassword"
                                class="login-pw-toggle"
                                aria-label="{{ $showPassword ? 'Hide password' : 'Show password' }}"
                                aria-pressed="{{ $showPassword ? 'true' : 'false' }}"
                            >
                                @if ($showPassword)
                                    {{-- Eye-off --}}
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                @else
                                    {{-- Eye --}}
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                @endif
                            </button>
                        </div>
                        @error('password')
                            <p class="login-field-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember + failed attempts counter --}}
                    <div class="login-meta">
                        <label class="login-check">
                            <input wire:model="remember" type="checkbox" id="remember"/>
                            <span class="login-check-label">Keep me signed in</span>
                        </label>

                        @if ($failedAttempts > 0 && !$isLockedOut)
                            <span class="login-attempts" aria-live="polite">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                {{ $failedAttempts }} failed attempt{{ $failedAttempts > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="login-btn"
                        {{ $isLockedOut ? 'disabled' : '' }}
                        wire:loading.attr="disabled"
                        wire:loading.class="login-btn--loading"
                    >
                        {{-- Spinner — shown automatically by wire:loading --}}
                        <span
                            class="login-btn__spinner"
                            wire:loading
                            wire:target="login"
                            aria-hidden="true"
                        ></span>

                        {{-- Icon — hidden while loading --}}
                        <svg
                            wire:loading.remove
                            wire:target="login"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>

                        <span wire:loading.remove wire:target="login">Sign In to Dashboard</span>
                        <span wire:loading wire:target="login">Signing in…</span>
                    </button>

                </form>

                {{-- Security badges --}}
                <div class="login-security" aria-label="Security features">
                    <span class="login-security-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        SSL Encrypted
                    </span>
                    <div class="login-security-sep" aria-hidden="true"></div>
                    <span class="login-security-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Rate Limited
                    </span>
                    <div class="login-security-sep" aria-hidden="true"></div>
                    <span class="login-security-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        2-Admin Limit
                    </span>
                </div>

            </div>
        </div>

    </div>
</div>