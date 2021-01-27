<?php

namespace App\Helpers\AccessLogHelpers;

use App\Helpers\Helper;

class OauthLogger extends Logger
{
    public function __construct($user, $group, $resource = null)
    {
        parent::__construct($user, $group, $resource, is_null($resource) ? 'OIDC' : 'authorization');
    }
}