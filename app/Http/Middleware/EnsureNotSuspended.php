<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isSuspended()) {
            $reason = Auth::user()->suspend_reason ?? 'Pelanggaran ketentuan komunitas kampus.';

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', "Akun Anda telah ditangguhkan oleh Admin Kampus. Alasan: {$reason}");
        }

        return $next($request);
    }
}
