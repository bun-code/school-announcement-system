<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Not logged in
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Read allowed admins from config so it's easy to change
        $allowed = config('admin.allowed_emails', []);

        // If config is empty, allow ALL authenticated users
        // (safe fallback while you're setting up)
        if (!empty($allowed)) {
            if (!in_array(strtolower($user->email), array_map('strtolower', $allowed), true)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->with('login_error', 'You are not authorized to access the admin portal.');
            }
        }

        return $next($request);
    }
}