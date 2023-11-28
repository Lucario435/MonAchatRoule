<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // https://laracasts.com/discuss/channels/general-discussion/create-middleware-to-auth-admin-users
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}