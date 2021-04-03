<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Models\OidcResponseLogger;

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
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '401 access token no such access token', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        if ($token->revoked || Carbon\Carbon::now() > Carbon\Carbon::parse($token->expires_at)) {
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '401 access token token revoked or expired', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => 'next clousure', 'error' => false]);

        return $next($request);
    }
}
