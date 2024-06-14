<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::check());
        /** @var User $user */

        $user = Auth::user();

        // dd(Auth::user()->isAdmin());
        if (Auth::check() && $user->isAdmin()) {
            return $next($request);
        }
        abort(403);
    }
}
