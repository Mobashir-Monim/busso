<?php

namespace App\Http\Middleware\PasswordReset;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckLastUpdate
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
        dd('password-reset.validity');
        if (!is_null(auth()->user())) {
            if (Carbon::parse(auth()->user()->pass_change_at)->diffInDays(Carbon::now()) > 90) {
                flash("Your password has not been resetted in 90 days. Please reset it now.")->error();

                return redirect()->route('users.password.reset');
            }
        }

        return $next($request);
    }
}
