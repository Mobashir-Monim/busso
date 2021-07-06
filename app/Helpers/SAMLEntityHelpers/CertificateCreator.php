<?php

namespace App\Helpers\SAMLEntityHelpers;

use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

class CertificateCreator extends Helper
{
    protected $key = null;
    protected $crt = null;
    protected $dn = null;

    public function __construct($path = 'SAML', $entity, $use_password = true)
    {
        $this->use_password = $use_password;
        $this->buildDN();
        $this->createX509($entity, $use_password);
        $this->storeCertificates($entity, $path, config('app.storage'));
    }

    public function buildDN()
    {
        $this->dn = [
            "countryName" => env('DN_COUNTRY_NAME', 'BD'),
            "stateOrProvinceName" => env('DN_STATE_OR_PROVINCE_NAME', 'Dhaka'),
            "localityName" => env('DN_LOCALITY_NAME', 'Uttara'),
            "organizationName" => env('DN_ORGANIZATION_NAME', 'Eveneer'),
            "organizationalUnitName" => env('DN_ORGANIZATIONAL_UNIT_NAME', 'Web Wiz Team'),
            "commonName" => env('DN_COMMON_NAME', 'Eveneer Dev'),
            "emailAddress" => env('DN_EMAIL_ADDRESS', 'sales@eveneer.xyz')
        ];
    }

    public function createX509($entity, $use_password)
    {
        $privkey = openssl_pkey_new(array(
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ));
        $csr = openssl_csr_new($this->dn, $privkey, array('digest_alg' => 'sha256'));
        $x509 = openssl_csr_sign($csr, null, $privkey, $days = 365, array('digest_alg' => 'sha256'));
        openssl_csr_export($csr, $csrout);
        openssl_x509_export($x509, $this->crt);
        
        if ($use_password) {
            openssl_pkey_export($privkey, $this->key, $entity->pemPass);
        } else {
            openssl_pkey_export($privkey, $this->key);
        }
    }

    public function storeCertificates($entity, $path, $disk)
    {
        $this->checkFolders($entity, $path, $disk);
        $this->checkFiles($entity, $path, $disk);
        Storage::disk($disk)->put("certificates/$path/$entity->folder/$entity->key.pem", $this->key, 0600);
        Storage::disk($disk)->put("certificates/$path/$entity->folder/$entity->cert.crt", $this->crt, 0600);
    }

    public function checkFolders($entity, $path, $disk)
    {
        if (!Storage::disk($disk)->exists("certificates")) Storage::disk($disk)->makeDirectory("certificates", 0700, true);
        if (!Storage::disk($disk)->exists("certificates/$path")) Storage::disk($disk)->makeDirectory("certificates/$path", 0700, true);
        if (!Storage::disk($disk)->exists("certificates/$path/$entity->folder")) Storage::disk($disk)->makeDirectory("certificates/$path/$entity->folder", 0700, true);
    }

    public function checkFiles($entity, $path, $disk)
    {
        if (Storage::disk($disk)->exists("certificates/$path/$entity->folder/$entity->key.pem")) Storage::delete("certificates/$path/$entity->folder/$entity->key.pem");
        if (Storage::disk($disk)->exists("certificates/$path/$entity->folder/$entity->cert.crt")) Storage::delete("certificates/$path/$entity->folder/$entity->cert.crt");
    }
}