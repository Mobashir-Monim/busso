<?php

namespace App\Helpers\SSOHelpers;

use App\Helpers\Helper;
use App\Models\SAMLEntity;
use Laravel\Passport\Passport;

class RGOnboarder extends Helper
{
    protected $group = null;

    public function __construct($group, $request)
    {
        $this->group = $group;
    }

    public function onboardGroup()
    {

    }

    public function createSAMLEntity()
    {
        $pKey = openssl_pkey_new();
        return SAMLENtity::create(['id' => $this->group->id]);
    }

    public function createOauthEntity()
    {
        return Passport::client()->create([
            'user_id' => $this->group->id,
            'user_type' => 'resource_group',
        ]);
    }
}