<?php

namespace App\Helpers\SSOHelpers\OAuth;

use App\Helpers\Helper;
use App\Helpers\FileHelpers\LocalCache as LC;
use App\Models\OauthClient;

class JwksHelper extends Helper
{
    protected $client;
    protected $doc;

    public function __construct($group)
    {
        $this->client = $group->oauth;
        $this->createLocalCache();
        $this->generateJwksDoc();
    }

    public function createLocalCache()
    {
        new LC("certificates/Oauth/" . $this->client->folder, "certificates/Oauth/" . $this->client->folder, $this->client->cert . ".crt");
        new LC("certificates/Oauth/" . $this->client->folder, "certificates/Oauth/" . $this->client->folder, $this->client->key . ".pem");
    }

    public function generateJwksDoc()
    {
        $key = file_get_contents(
            storage_path(
                "app/certificates/Oauth/" .
                $this->client->folder . "/" .
                $this->client->cert . ".crt"
            )
        );
        $data = openssl_pkey_get_public($key);
        $this->constructJwksDoc(openssl_pkey_get_details($data));
    }

    public function constructJwksDoc($data)
    {
        $this->doc = [
            "keys" => [
                [
                    // "kid" => "178ab1dc5913d929d37c23dcaa961872f8d70b68",
                    "kty" => "RSA",
                    "n" => base64_encode($data['rsa']['n']),
                    "e" => base64_encode($data['rsa']['e']),
                    "use" => "sig",
                    "alg" => "RS256"
                ],
              ]
        ];
    }

    public function getJwksDoc()
    {
        return $this->doc;
    }
}