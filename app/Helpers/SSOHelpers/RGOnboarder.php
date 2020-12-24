<?php

namespace App\Helpers\SSOHelpers;

use Illuminate\Support\Str;
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
        if ($request->type == 'oauth' || $request->type == 'both') {
            $oauth = $this->createOauthEntity($request);
        }

        if ($request->type == 'saml' || $request->type == 'both') {
            $saml = $this->createSAMLEntity($this->group->id);
        }
    }

    public function createSAMLEntity($pass)
    {
        $entity = SAMLENtity::create(['resource_group_id' => $this->group->id]);
        new CertificateCreator($pass, $entity);
        (new MetadataCreator($entity))->createMetadata();
    }

    public function createOauthEntity($request)
    {
        return Passport::client()->create([
            'name' => $request->name,
            'user_id' => $this->group->id,
            'user_type' => 'resource_group',
            'secret' => Str::random(rand(50, 60)),
            'personal_access_client' => false,
            'password_client' => true,
            'redirect' => $request->endpoint,
            'revoked' => false,
        ]);
    }
}