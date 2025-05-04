<?php

namespace App\Http\Middleware;

use App\Models\UserSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $deviceId = hash('sha256', $request->userAgent() . $request->ip());
            $session = \App\Models\UserSession::where('user_id', $user->id)->first();

            if ($session) {
                $expired = now()->diffInHours($session->last_login_at) >= 4;

                if (!$expired && $session->device_id !== $deviceId) {
                    Auth::logout();

                    if ($request->ajax()) {
                        return response()->json(['error' => 'Akun sedang digunakan di perangkat lain.'], 403);
                    }

                    return redirect('/')
                        ->with('device_conflict', 'Akun sedang digunakan di perangkat lain. Silakan coba lagi setelah 4 jam.');
                }
            }

            // Simpan atau update sesi
            \App\Models\UserSession::updateOrCreate(
                ['user_id' => $user->id],
                ['device_id' => $deviceId, 'last_login_at' => now()]
            );
        }

        return $next($request);
    }
}
