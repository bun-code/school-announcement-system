<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    // ── Logout ──────────────────────────────────────────────
    // showLogin() and login() have been replaced by the
    // App\Livewire\Auth\AdminLogin Livewire component.
    // Only logout() remains here as a standard POST action.

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $email  = Auth::user()?->email;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Admin logout', [
            'user_id' => $userId,
            'email'   => $email,
            'ip'      => $request->ip(),
        ]);

        return redirect()
            ->route('admin.login')
            ->with('success', 'You have been signed out successfully.');
    }
}