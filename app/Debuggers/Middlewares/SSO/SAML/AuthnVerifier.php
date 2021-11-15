<?php

namespace App\Debuggers\Middlewares\SSO\SAML;

use App\Debuggers\Debugger;

class AuthnVerifier extends Debugger
{
    public function __construct($data_object)
    {
        parent::__construct('App\Http\Middleware\SSOMiddlewares\SAML\AuthnVerifier', $data_object);
    }
}