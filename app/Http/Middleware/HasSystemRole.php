<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasSystemRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if (auth()->user()->hasSystemRole($role)) {
                return $next($request);
            }
        }

        flash('You do not have the right permission to access the requested resource')->error();

        return redirect(route('home'));
    }
}
