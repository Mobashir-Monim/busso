<?php

namespace App\Http\Middleware\SSOMiddlewares;

use Closure;
use Auth;
use Illuminate\Http\Request;

class CredentialChecker
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
        $credentials = request(['email', 'password']);
        
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Credentials not found', 'password' => 'Credentials not found'])
                ->with('val', request()->val);
        }
        
        return $next($request);
    }
}
