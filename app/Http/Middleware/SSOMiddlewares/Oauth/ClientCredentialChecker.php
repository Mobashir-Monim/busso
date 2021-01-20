<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class ClientCredentialChecker
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
        $client = Passport::client()->find($request->client_id);

        if ($client->secret != $request->client_secret || $client->redirect != $request->redirect_uri) {
            dd($client->secret, $request->client_secret, $client->redirect, $request->redirect_uri);
            return response()->json([
                'success' => false,
            ], 401);
        }
        
        return $next($request);
    }
}
