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
        if ($request->client_id == null || $request->redirect_uri == null ||
            $request->response_type == null || $request->scope == null) {
            return response()->json([
                'success' => false,
            ], 400);
        }
        
        return $next($request);
    }
}
