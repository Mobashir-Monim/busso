<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class RedirectChecker
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
        if (Passport::client()->where('id', $request->client_id)->first()->redirect != $request->redirect_uri) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        return $next($request);
    }
}
