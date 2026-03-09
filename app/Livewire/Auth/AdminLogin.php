<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

#[Layout('components.layouts.auth')]   // uses resources/views/components/layouts/auth.blade.php
#[Title('Admin Login — Taboc Elementary School')]
class AdminLogin extends Component
{
    // ── Form fields ──
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|min:6')]
    public string $password = '';

    public bool $remember = false;

    // ── UI state ──
    public bool  $showPassword    = false;
    public bool  $isLoading       = false;
    public bool  $isLockedOut     = false;
    public int   $lockoutSeconds  = 0;
    public int   $failedAttempts  = 0;
    public int   $attemptsRemaining = 0;

    // ── Error messages ──
    public string $loginError = '';

    // ── Security constants ──
    private const MAX_ATTEMPTS     = 5;
    private const LOCKOUT_SECONDS  = 300;   // 5 minutes
    private const RATE_PER_MINUTE  = 10;
    // Allowed admins pulled from config/admin.php
    // Update that file to match your seeded emails
    private function getAllowedAdmins(): array
    {
        return array_map('strtolower', config('admin.allowed_emails', []));
    }

    // ─────────────────────────────────────────
    //  Mount — check if already locked out
    // ─────────────────────────────────────────

    public function mount(): void
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            $this->redirectRoute('admin.dashboard');
            return;
        }

        // Restore lockout state from cache on page load/refresh
        $this->checkLockoutState();
    }

    // ─────────────────────────────────────────
    //  Reactive: poll every second when locked
    // ─────────────────────────────────────────

    /**
     * Called by wire:poll.1000ms when $isLockedOut is true.
     * Counts down the lockout timer and unlocks when done.
     */
    public function tickLockout(): void
    {
        if (!$this->isLockedOut) return;

        $this->checkLockoutState();

        if ($this->lockoutSeconds > 0) {
            $this->lockoutSeconds--;
        } else {
            // Lockout expired — clear state
            $this->isLockedOut   = false;
            $this->lockoutSeconds = 0;
            $this->loginError    = '';
        }
    }

    // ─────────────────────────────────────────
    //  Toggle password visibility
    // ─────────────────────────────────────────

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    // ─────────────────────────────────────────
    //  Submit login
    // ─────────────────────────────────────────

    public function login(): void
    {
        // Clear previous error
        $this->loginError = '';

        // Already locked out — reject immediately
        if ($this->isLockedOut) {
            $this->loginError = 'Account is temporarily locked. Please wait for the timer.';
            return;
        }

        // 1. Validate fields
        $this->validate();

        $this->isLoading = true;

        $email = strtolower(trim($this->email));

        // 2. Honeypot is handled in blade — nothing to check here
        //    (Livewire forms don't expose hidden inputs the same way)

        // 3. Rate limit by IP
        $ipKey = 'login_ip:' . request()->ip();

        if (RateLimiter::tooManyAttempts($ipKey, self::RATE_PER_MINUTE)) {
            $seconds = RateLimiter::availableIn($ipKey);
            $this->triggerLockout($seconds, 'Too many requests. Please slow down.');
            return;
        }

        RateLimiter::hit($ipKey, 60);

        // 4. Whitelist check — same error message as bad password (no enumeration)
        if (!empty($this->getAllowedAdmins()) && !in_array($email, $this->getAllowedAdmins(), true)) {
            Log::warning('Unauthorized admin login attempt', [
                'email' => $email,
                'ip'    => request()->ip(),
            ]);
            $this->handleFailedAttempt($email);
            return;
        }

        // 5. Per-account lockout check
        $lockKey = 'login_lock:' . $email;

        if (Cache::has($lockKey)) {
            $expiry  = Cache::get($lockKey . '_expiry', time() + self::LOCKOUT_SECONDS);
            $seconds = max(0, $expiry - time());
            $this->triggerLockout($seconds, 'Account is temporarily locked.');
            return;
        }

        // 6. Attempt authentication
        if (!Auth::attempt(['email' => $email, 'password' => $this->password], $this->remember)) {
            $this->handleFailedAttempt($email);
            return;
        }

        // 7. Success — clear counters, regenerate session
        Cache::forget('login_attempts:' . $email);
        Cache::forget('login_lock:' . $email);
        RateLimiter::clear($ipKey);

        session()->regenerate();

        Log::info('Admin login successful', [
            'user_id' => Auth::id(),
            'email'   => $email,
            'ip'      => request()->ip(),
        ]);

        $this->isLoading = false;

        $this->redirectRoute('admin.dashboard');
    }

    // ─────────────────────────────────────────
    //  Render
    // ─────────────────────────────────────────

    public function render()
    {
        return view('livewire.auth.admin-login');
    }

    // ─────────────────────────────────────────
    //  Private helpers
    // ─────────────────────────────────────────

    private function checkLockoutState(): void
    {
        $email   = strtolower(trim($this->email));
        $lockKey = 'login_lock:' . ($email ?: 'unknown');

        if (Cache::has($lockKey)) {
            $expiry = Cache::get($lockKey . '_expiry', time() + self::LOCKOUT_SECONDS);
            $remaining = max(0, $expiry - time());

            $this->isLockedOut    = true;
            $this->lockoutSeconds = $remaining;
        }
    }

    private function handleFailedAttempt(string $email): void
    {
        $attemptsKey = 'login_attempts:' . $email;
        $lockKey     = 'login_lock:' . $email;

        $attempts  = Cache::get($attemptsKey, 0) + 1;
        Cache::put($attemptsKey, $attempts, now()->addMinutes(10));

        $remaining = max(0, self::MAX_ATTEMPTS - $attempts);

        $this->failedAttempts      = $attempts;
        $this->attemptsRemaining   = $remaining;

        Log::warning('Failed admin login attempt', [
            'email'     => $email,
            'ip'        => request()->ip(),
            'attempts'  => $attempts,
            'remaining' => $remaining,
        ]);

        // Lock if max reached
        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::put($lockKey,             true,  now()->addSeconds(self::LOCKOUT_SECONDS));
            Cache::put($lockKey . '_expiry', time() + self::LOCKOUT_SECONDS, now()->addSeconds(self::LOCKOUT_SECONDS));
            Cache::forget($attemptsKey);

            Log::warning('Admin account locked', [
                'email'    => $email,
                'ip'       => request()->ip(),
                'duration' => self::LOCKOUT_SECONDS,
            ]);

            $this->triggerLockout(self::LOCKOUT_SECONDS, 'Too many failed attempts. Account locked for 5 minutes.');
            return;
        }

        // Warning on last 2 attempts
        $this->loginError = $remaining <= 2
            ? 'Invalid credentials. ' . $remaining . ' attempt' . ($remaining === 1 ? '' : 's') . ' remaining before lockout.'
            : 'Invalid email or password.';

        $this->isLoading = false;

        // Clear password field on failure
        $this->reset('password');
    }

    private function triggerLockout(int $seconds, string $message): void
    {
        $this->isLockedOut    = true;
        $this->lockoutSeconds = $seconds;
        $this->loginError     = $message;
        $this->isLoading      = false;
        $this->reset('password');
    }
}