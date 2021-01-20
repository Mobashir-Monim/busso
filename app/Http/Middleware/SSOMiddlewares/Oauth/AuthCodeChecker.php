<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Passport\Passport;

class AuthCodeChecker
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
        $authCode = Passport::authCode()->find(request()->code);

        if (is_null($authCode)) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        if ($authCode->client_id != $request->client_id || $authCode->revoked || Carbon::now() > Carbon::parse($authCode->expires_at)) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        return $next($request);
    }
}
