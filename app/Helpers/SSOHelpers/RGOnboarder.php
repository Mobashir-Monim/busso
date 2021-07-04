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
            new CertificateCreator('Oauth', $oauth);
        }

        if ($request->type == 'saml' || $request->type == 'both') {
            $saml = $this->createSAMLEntity($this->group->id);
            new CertificateCreator('SAML', $saml);
            (new MetadataCreator($saml))->createMetadata();
        }
    }

    public function createSAMLEntity($pass)
    {
        return SAMLENtity::create(['resource_group_id' => $this->group->id]);
    }

    public function createOauthEntity($request)
    {
        $values = $this->generateCertificateIdentificationValues();

        return Passport::client()->create([
            'name' => $request->name,
            'user_id' => $this->group->id,
            'user_type' => 'resource_group',
            'secret' => Str::random(rand(80, 100)),
            'personal_access_client' => false,
            'password_client' => true,
            'redirect' => $request->endpoint,
            'revoked' => false,
            'folder' => $values['folder'],
            'key' => $values['key'],
            'cert' => $values['cert']
        ]);
    }

    public function generateCertificateIdentificationValues()
    {
        $values = ['folder' => Str::random(rand(100, 250)), 'key' => Str::random(rand(100, 250)), 'cert' => Str::random(rand(100, 250))];

        foreach ($values as $key => $value) {
            while (!is_null(Passport::client()->where($key, $value)->first())) {
                $value = Str::random(rand(100, 250));
            }

            $values[$key] = $value;
        }

        return $values;
    }
}