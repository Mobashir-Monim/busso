<?php

namespace App\Helpers\SSOHelpers;

use App\Helpers\Helper;

class RGOnboarder extends Helper
{
    protected $group = null;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function onboardGroup()
    {

    }

    public function createSAMLEntity()
    {

    }

    public function createOauthEntity()
    {
        
    }
}