<?php

namespace App\Helpers\SSOHelpers;

use App\Helpers\Helper;
use App\Helpers\SAMLEntityHelpers\CertificateCreator;
use App\Helpers\SAMLEntityHelpers\MetadataCreator;
use App\Models\SAMLEntity;
use App\Models\ResourceGroup as RG;
use Laravel\Passport\Passport;

class RGOnboarder extends Helper
{
    protected $group = null;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function onboardGroup($request)
    {
        $oauth = $this->createOauthEntity($request);
        $saml = $this->createSAMLEntity($oauth->secret);
    }

    public function createSAMLEntity($pass)
    {
        $entity = SAMLENtity::create(['resource_group_id' => $this->group->id]);
        new CertificateCreator($pass, $entity);
        (new MetadataCreator($entity))->createMetadata();
        // new CertificateCreator($pass, $entity, $disk = 's3);
        // (new MetadataCreator($entity, $disk = 's3))->createMetadata();
    }

    public function createOauthEntity($request)
    {
        return Passport::client()->create([
            'name' => $request->name,
            'user_id' => $this->group->id,
            'user_type' => 'resource_group',
            'personal_access_client' => false,
            'password_client' => true,
            'redirect' => $request->url,
            'revoked' => false,
        ]);
    }
}