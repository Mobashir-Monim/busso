<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;

class AuthGrantChecker
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
        if ($request->grant_type != 'authorization_code') {
            dd('in grant');
            return response()->json([
                'success' => false,
                'message' => 'bad_request'
            ], 400);
        }

        return $next($request);
    }
}
