<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AccessTokenChecker
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
        $token = Passport::token()->find($request->bearerToken());

        if (is_null($token)) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        if ($token->revoked || Carbon::now() > Carbon::parse($token->expires_at)) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        return $next($request);
    }
}
