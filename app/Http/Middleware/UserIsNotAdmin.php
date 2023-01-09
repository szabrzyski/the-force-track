<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && ! $user->isAdmin()) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
