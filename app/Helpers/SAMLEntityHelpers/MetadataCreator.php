<?php

namespace App\Helpers\SAMLEntityHelpers;

use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use \LightSaml\Helper as LSH;
use \LightSaml\SamlConstants as SConst;
use \LightSaml\Credential\X509Certificate as X509;
use \LightSaml\Model\Metadata\EntityDescriptor as ED;
use \LightSaml\Model\Metadata\IdpSsoDescriptor as IdpD;
use \LightSaml\Model\Metadata\KeyDescriptor as KD;
use \LightSaml\Model\Metadata\SingleSignOnService as SSO;
use \LightSaml\Model\Metadata\SingleLogoutService as SLO;
use \LightSaml\Model\Context\SerializationContext as SC;

class MetadataCreator extends Helper
{
    protected $entity = null;
    protected $disk = null;

    public function __construct($entity)
    {
        $this->entity = $entity;
        $this->disk = env('STORAGE_DISK', 'local');
    }

    public function createMetadata()
    {
        $entityDescriptor = new ED();
        $entityDescriptor->setID(LSH::generateID())->setEntityID(route('sso.saml.login', ['entity' => $this->entity->id]));
        $entityDescriptor->addItem($this->addIdpD());
        $this->storeMetadata($entityDescriptor);
    }

    public function addIdpD()
    {
        $idpDescriptor = (new IdpD())->setWantAuthnRequestsSigned(false);
        $idpDescriptor->addKeyDescriptor($this->addKey());
        $this->addSSOs($idpDescriptor);
        $this->addSLOs($idpDescriptor);
        $idpDescriptor->addNameIDFormat(SConst::NAME_ID_FORMAT_EMAIL);

        return $idpDescriptor;
    }

    public function addKey()
    {
        return (new KD())
        ->setUse(KD::USE_SIGNING)
        ->setCertificate(X509::fromFile(storage_path("app/certificates/") . $this->entity->folder . "/" . $this->entity->cert . ".crt"));
    }

    public function addSLOs(&$idpDescriptor)
    {
        $idpDescriptor->addSingleLogoutService((new SLO())
            ->setBinding(SConst::BINDING_SAML2_HTTP_POST)
            ->setLocation(route('sso.saml.logout-api', ['entity' => $this->entity->id])));

        $idpDescriptor->addSingleLogoutService((new SLO())
            ->setBinding(SConst::BINDING_SAML2_HTTP_REDIRECT)
            ->setLocation(route('sso.saml.logout', ['entity' => $this->entity->id])));
    }

    public function addSSOs(&$idpDescriptor)
    {
        $idpDescriptor->addSingleSignOnService((new SSO())
            ->setBinding(SConst::BINDING_SAML2_HTTP_POST)
            ->setLocation(route('sso.saml.login-api', ['entity' => $this->entity->id])));

        $idpDescriptor->addSingleSignOnService((new SSO())
            ->setBinding(SConst::BINDING_SAML2_HTTP_REDIRECT)
            ->setLocation(route('sso.saml.login', ['entity' => $this->entity->id])));
    }

    public function storeMetadata($entityDescriptor)
    {
        $context = new SC;
        $context->getDocument()->encoding = "UTF-8";
        $entityDescriptor->serialize($context->getDocument(), $context);
        $name = $this->entity->metadataDocName;
        $content = $context->getDocument()->saveXML();
        if (Storage::disk($this->disk)->exists("certificates/" . $this->entity->folder. "/$name.xml")) Storage::delete("certificates/" . $this->entity->folder. "/$name.xml");
        Storage::disk($this->disk)->put("certificates/" . $this->entity->folder. "/$name.xml", $context->getDocument()->saveXML(), 0600);
    }
}