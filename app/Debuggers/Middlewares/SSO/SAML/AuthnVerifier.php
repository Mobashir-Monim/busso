<?php

namespace App\Debuggers\Middlewares\SSO\SAML;

use App\Debuggers\Debugger;

class AuthnVerifier extends Debugger
{
    public function __construct()
    {
        parent::__construct('App\Http\Middleware\SSOMiddlewares\SAML\AuthnVerifier');
    }

    
}