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
        $oauth = json_decode(base64url_decode(request()->oauth));
        dd($oauth, !is_null($oauth->timestamp), Carbon::parse($oauth->timestamp)->diffInSeconds(Carbon::now()), Carbon::parse($oauth->timestamp) < Carbon::now());
        
        if (property_exists($oauth, 'timestamp')) {
            if (!is_null($oauth->timestamp) && Carbon::parse($oauth->timestamp)->addSeconds(60) < Carbon::now()) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'bad_request'
        ], 400);
    }
}
