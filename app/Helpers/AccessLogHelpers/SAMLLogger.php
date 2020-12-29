<?php

namespace App\Helpers\AccessLogHelpers;

use App\Helpers\Helper;

class SAMLLogger extends Logger
{
    public function __construct($user, $group)
    {
        parent::__construct($user, $group, null, 'SAML');
    }
}