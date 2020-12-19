<?php

namespace App\Helpers\SAMLEntityHelpers;

use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

class CertificateCreator extends Helper
{
    protected $key = null;
    protected $crt = null;
    protected $dn = null;

    public function __construct($pass, $entity, $disk = 'local')
    {
        $this->buildDN();
        $this->createX509($pass);
        $this->storeCertificates($entity, $disk);
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

    public function createX509($pass)
    {
        $privkey = openssl_pkey_new(array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ));
        $csr = openssl_csr_new($this->dn, $privkey, array('digest_alg' => 'sha256'));
        $x509 = openssl_csr_sign($csr, null, $privkey, $days = 365, array('digest_alg' => 'sha256'));
        openssl_csr_export($csr, $csrout);
        openssl_x509_export($x509, $this->crt);
        openssl_pkey_export($privkey, $this->key, hash('sha512', $this->base64url_encode($pass)));
    }

    public function storeCertificates($entity, $disk)
    {
        if (!Storage::disk($disk)->exists("cetificates")) Storage::disk($disk)->makeDirectory("cetificates", 0700, true);
        if (!Storage::disk($disk)->exists("cetificates/$entity->folder")) Storage::disk($disk)->makeDirectory("cetificates/$entity->folder", 0700, true);
        if (Storage::disk($disk)->exists("cetificates/$entity->folder/$entity->key.pem")) Storage::delete("cetificates/$entity->folder/$entity->key.pem");
        if (Storage::disk($disk)->exists("cetificates/$entity->folder/$entity->cert.crt")) Storage::delete("cetificates/$entity->folder/$entity->cert.crt");
        Storage::disk($disk)->put("cetificates/$entity->folder/$entity->key.pem", $this->key, 0600);
        Storage::disk($disk)->put("cetificates/$entity->folder/$entity->cert.crt", $this->crt, 0600);
    }
}