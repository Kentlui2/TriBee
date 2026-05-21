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

        // Check using role relationship (if Member 5 sets it up)
        if ($user->role && $user->role->name === 'admin') {
            return $next($request);
        }

        // Fallback: check is_admin boolean (for backward compatibility)
        if ($user->is_admin) {
            return $next($request);
        }

        abort(403, 'Unauthorized. Admin access only.');
    }
}