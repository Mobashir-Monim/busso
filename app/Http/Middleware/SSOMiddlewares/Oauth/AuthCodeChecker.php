<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Models\OidcResponseLogger;

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
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '401 auth code no such auth code', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        if ($authCode->client_id != $request->client_id || $authCode->revoked || Carbon::now() > Carbon::parse($authCode->expires_at)) {
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '401 auth code client id miss match or revoked', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => 'next clousure', 'error' => false]);
        return $next($request);
    }
}
