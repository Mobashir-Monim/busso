<?php

namespace App\Http\Middleware\RoleMiddlewares;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

class HasSystemRole
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
        if (!auth()->user()->hasRole('system-user'))
            auth()->user()->roles()->attach(Role::where('name', 'system-user')->first()->id);

        return $next($request);
    }
}
