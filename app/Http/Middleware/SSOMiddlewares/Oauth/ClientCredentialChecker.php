<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Models\OidcResponseLogger;

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
        $flag = false;

        if (strlen($client->redirect) > strlen($request->redirect_uri)) {

        } else {

        }

        if ($client->secret != $request->client_secret || $client->redirect != $request->redirect_uri) {
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => '401 client cred', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 401);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all(), JSON_UNESCAPED_SLASHES), 'response' => 'next clousure', 'error' => false]);
        
        return $next($request);
    }
}
