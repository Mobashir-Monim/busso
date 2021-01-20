<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class ClientChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Passport::client()->where('id', $request->client_id)->first());
        if (is_null(Passport::client()->where('id', $request->client_id)->first())) {
            dd('in here');
            return response()->json([
                'success' => false,
            ], 401);
        }

        return $next($request);
    }
}
