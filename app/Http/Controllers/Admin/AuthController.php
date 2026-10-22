<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $maxAttempts = 3;
        $decaySeconds = 300; // 5 minutes lockout after 3 failed attempts

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
        $ipThrottleKey = 'login_ip:' . $request->ip();

        // 1. Check IP-wide brute force lockout (10 attempts across all accounts per 10 mins)
        if (RateLimiter::tooManyAttempts($ipThrottleKey, 10)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Security Alert: Too many failed administrative attempts from this network. Temporarily blocked for {$seconds}s (~{$minutes} min).",
            ])->onlyInput('email');
        }

        // 2. Check targeted account brute force lockout (3 attempts per account+IP per 5 mins)
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Security Alert: Too many failed login attempts (Maximum {$maxAttempts}). Access locked for safety. Please retry in {$seconds} seconds (~{$minutes} min).",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Reset rate limiters on successful authentication
            RateLimiter::clear($throttleKey);
            RateLimiter::clear($ipThrottleKey);

            $request->session()->regenerate();
            // Store activity timestamp for idle session expiration
            session(['admin_last_activity' => time()]);

            return redirect()->intended(route('admin.dashboard'));
        }

        // Login failed -> increment both rate limiters
        RateLimiter::hit($throttleKey, $decaySeconds);
        RateLimiter::hit($ipThrottleKey, 600);
        $remaining = RateLimiter::remaining($throttleKey, $maxAttempts);

        if ($remaining <= 0) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Maximum {$maxAttempts} attempts reached! Security lockout activated. Please try again in {$seconds} seconds.",
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => "Invalid administrative credentials. You have {$remaining} of {$maxAttempts} attempt(s) remaining before account lockout.",
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
    }
}
