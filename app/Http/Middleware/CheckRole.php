<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Get authenticated user
        $user = $request->user();

        // If not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user's role matches allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Role mismatch - redirect to appropriate dashboard
        if ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // For other roles (admin, super_admin, guru)
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
