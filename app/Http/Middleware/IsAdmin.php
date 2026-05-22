<?php

// G1 - Member 6: DevOps/Lead - Admin Role Middleware / CAPAPAS JUSTINE

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in first.');
        }

        $user = Auth::user();

        // 1. Check using role relationship (Restored Member 5's work)
        if ($user->role && $user->role->name === 'admin') {
            return $next($request);
        }

        // 2. Fallback: Loose check (Handles true, 1, or '1' perfectly for everyone)
        if ($user->is_admin) {
            return $next($request);
        }

        abort(403, 'Unauthorized: Admin access only.');
    }
}