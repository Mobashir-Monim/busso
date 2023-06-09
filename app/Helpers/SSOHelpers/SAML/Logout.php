<?php

namespace App\Helpers\SSOHelpers\SAML;

use App\Helpers\Helper;
use Auth;
use \LightSaml\Model\Protocol\Response as LSR;

class Logout extends Base
{
    public function __construct($saml, $entity)
    {
        parent::__construct($saml, $entity, 'logout');
    }

    public function logoutResponse()
    {
        $response = new LSR();
        $this->buildXML($response);
        
        return $response;
    }

    public function buildXML(&$response)
    {
        $this->buildResponse($response, true);
    }

    public function logoutUser()
    {
        Auth::logout();
        request()->session()->invalidate();
    }
}