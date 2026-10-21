<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionTimeout
{
    /**
     * Handle an incoming request.
     * Enforces inactivity session timeout for authenticated admin sessions.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $settings = AppSetting::instance();
            $timeoutMinutes = max(1, (int) ($settings->admin_session_lifetime_minutes ?? 15));
            $timeoutSeconds = $timeoutMinutes * 60;

            $lastActivity = session('admin_last_activity');
            $currentTime = time();

            if ($lastActivity && ($currentTime - $lastActivity) > $timeoutSeconds) {
                // Session expired due to inactivity
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->withErrors([
                    'email' => "Your administrative session expired after {$timeoutMinutes} minutes of inactivity. Please log in again to continue.",
                ]);
            }

            // Update activity timestamp
            session(['admin_last_activity' => $currentTime]);
        }

        return $next($request);
    }
}
