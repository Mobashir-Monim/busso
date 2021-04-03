<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use App\Models\OidcResponseLogger;

class ParamChecker
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
        if (is_null($request->client_id) || is_null($request->redirect_uri) ||
            is_null($request->response_type) || is_null($request->scope)) {
            OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all()), 'response' => '400 param checker', 'error' => true]);
            return response()->json([
                'success' => false,
            ], 400);
        }

        OidcResponseLogger::create([ 'route' => $request->url(), 'data' => json_encode($request->all()), 'response' => 'next clousure', 'error' => false]);
        
        return $next($request);
    }
}
