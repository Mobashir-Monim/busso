<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use App\Models\OidcResponseLogger;

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
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '400 auth grant', 'error' => true]);
            return response()->json([
                'success' => false,
                'message' => 'bad_request'
            ], 400);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => 'next clousure', 'error' => false]);

        return $next($request);
    }
}
