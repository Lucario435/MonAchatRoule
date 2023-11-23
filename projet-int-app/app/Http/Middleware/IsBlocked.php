<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class IsBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->is_blocked) {
            error_log("User ".Auth::user()->username." got blocked");
            Auth::logout(); // Log out the user
            return redirect()->route('login')->withErrors([
                'error' => 'Votre compte a été bloqué par un administrateur.',
            ]);
            
        }

        return $next($request);
    }
}
