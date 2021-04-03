<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Models\OidcResponseLogger;

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
        if (is_null(Passport::client()->where('id', $request->client_id)->first())) {
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all()), 'response' => '401 client checker', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all()), 'response' => 'next clousure', 'error' => false]);

        return $next($request);
    }
}
