<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;

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
            return response()->json([
                'success' => false,
            ], 400);
        }
        
        return $next($request);
    }
}
