<?php

namespace App\Http\Middleware\UserMiddlewares;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\UserHelpers\AccessHelper;

class IsActive
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
        $helper = new AccessHelper;
        
        if ($helper->status['success']) {
            return $next($request);
        } else {
            return $helper->accessDenied();
        }
    }
}
