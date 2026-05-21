<?php
// G1 - Member 6: DevOps/Lead - Authentication Gatekeeper CAPAPAS
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Store intended URL for redirect after login
            session()->put('url.intended', $request->url());
            
            return redirect()->route('login')
                ->with('error', 'Please log in to access this page.');
        }

        // Attach user_id to the route parameters so all downstream code has it
        $request->route()?->setParameter('user_id', Auth::id());

        return $next($request);
    }
}