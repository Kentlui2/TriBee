<?php
// G1 - Member 6: DevOps/Lead - Admin Role Middleware CAPAPAS
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

        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}