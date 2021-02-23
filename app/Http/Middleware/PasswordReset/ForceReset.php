<?php

namespace App\Http\Middleware\PasswordReset;

use Closure;
use Illuminate\Http\Request;

class ForceReset
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
        dd('password-reset.enforced');
        if (!is_null(auth()->user())) {
            if (auth()->user()->force_reset) {
                flash("You need to reset your password before you can access the requested resource!")->error();

                return redirect()->route('users.password.reset');
            }
        }

        return $next($request);
    }
}
