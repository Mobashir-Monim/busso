<?php

namespace App\Http\Middleware\SSOMiddlewares\Oauth;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionChecker
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
        $val = json_decode(base64url_decode(request()->val));
        
        if (property_exists($val, 'timestamp')) {
            if (!is_null($val->timestamp) && Carbon::parse($val->timestamp)->addSeconds(60) < Carbon::now()) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'bad_request'
        ], 400);
    }
}
