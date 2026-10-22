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
        // 1. SQL Injection Protection on Authentication Inputs
        $rawEmail = (string) $request->input('email', '');
        $sqliPatterns = [
            "/'\s*(or|and)\s*['\d]/i",
            '/union\s+(all\s+)?select/i',
            '/(\-\-|\#|\/\*)/',
            '/;\s*(drop|alter|delete|insert|update|truncate)/i',
            '/sleep\s*\(\s*\d+\s*\)/i',
            '/benchmark\s*\(/i',
            '/information_schema/i',
        ];

        foreach ($sqliPatterns as $pattern) {
            if (preg_match($pattern, $rawEmail)) {
                RateLimiter::hit('login_ip:' . $request->ip(), 18000);
                return back()->withErrors([
                    'email' => 'Security Alert: Malicious SQL injection sequence detected. Request blocked and IP logged.',
                ])->onlyInput('email');
            }
        }

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $maxAttempts = 3;
        $decaySeconds = 18000; // 5 hours lockout (5 * 3600 seconds)

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
        $ipThrottleKey = 'login_ip:' . $request->ip();

        // 2. Check IP-wide brute force lockout (10 attempts across all accounts per 10 mins)
        if (RateLimiter::tooManyAttempts($ipThrottleKey, 10)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Security Alert: Too many failed administrative attempts from this network. Temporarily blocked for {$seconds}s (~{$minutes} min).",
            ])->onlyInput('email');
        }

        // 3. Check targeted account brute force lockout (3 attempts per account+IP per 5 hours)
        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $hours = floor($seconds / 3600);
            $minutes = ceil(($seconds % 3600) / 60);
            $timeRemaining = $hours > 0 ? "{$hours} hr {$minutes} min" : "{$minutes} min";

            return back()->withErrors([
                'email' => "Security Alert: Maximum {$maxAttempts} login attempts exceeded. Account locked for 5 hours. Please retry in {$timeRemaining}.",
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
        RateLimiter::hit($ipThrottleKey, 18000);
        $remaining = RateLimiter::remaining($throttleKey, $maxAttempts);

        if ($remaining <= 0) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $hours = floor($seconds / 3600);
            $minutes = ceil(($seconds % 3600) / 60);
            $timeRemaining = $hours > 0 ? "{$hours} hr {$minutes} min" : "{$minutes} min";

            return back()->withErrors([
                'email' => "Maximum {$maxAttempts} attempts reached! Security lockout activated for 5 hours. Please try again in {$timeRemaining}.",
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => "Invalid administrative credentials. You have {$remaining} of {$maxAttempts} attempt(s) remaining before a 5-hour lockout.",
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
