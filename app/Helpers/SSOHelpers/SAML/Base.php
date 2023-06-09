<?php

namespace App\Helpers\SSOHelpers\SAML;

use App\Helpers\Helper;
use Carbon\Carbon;
use \LightSaml\Model\Protocol\LogoutRequest;
use \LightSaml\Model\Context\SerializationContext as SC;
use \LightSaml\Model\Context\DeserializationContext as DC;
use \LightSaml\Model\Protocol\AuthnRequest as ANR;
use \LightSaml\Credential\X509Certificate as X509;
use \LightSaml\Credential\KeyHelper as KH;
use \LightSaml\Helper as LSH;
use \LightSaml\Model\Assertion\Issuer;
use \LightSaml\SamlConstants as SConst;
use \LightSaml\Model\Protocol\Status;
use \LightSaml\Model\Protocol\StatusCode;
use \LightSaml\Model\XmlDSig\SignatureWriter;
use \LightSaml\Binding\BindingFactory;
use \LightSaml\Context\Profile\MessageContext;
use App\Helpers\FileHelpers\LocalCache as LC;
use Illuminate\Support\Facades\Storage;

class Base extends Helper
{
    protected $authN = null;
    protected $entity = null;
    protected $destination = null;
    protected $issuer = null;
    protected $cert = null;
    protected $key = null;

    public function __construct($saml, $entity, $type)
    {
        $deserializationContext = new DC();
        $deserializationContext->getDocument()->loadXML(gzinflate(base64_decode($saml)));
        $authnRequest = $type == 'login' ? new ANR() : new LogoutRequest();
        $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);
        $this->spreadEssentials($authnRequest, $entity);
    }

    public function spreadEssentials($authN, $entity)
    {
        new LC("certificates/SAML/" . $entity->folder, "certificates/SAML/" . $entity->folder, $entity->cert . ".crt");
        $this->authN = $authN;
        $this->entity = $entity;
        $this->destination = $entity->acs;
        $this->issuer = $entity->entityID;
        $this->cert = X509::fromFile(storage_path("app/certificates/SAML/$entity->folder/$entity->cert.crt"));
        $this->key = KH::createPrivateKey(Storage::disk('s3')->get("certificates/SAML/" . $entity->folder . "/" . $entity->key . ".pem"), $this->entity->pemPass, false);
    }

    public function buildResponse(&$response, $sign = false)
    {
        $response->setID(LSH::generateID())
            ->setIssueInstant(new \DateTime())
            ->setDestination($this->destination)
            ->setIssuer(new Issuer($this->issuer))
            ->setStatus(new Status(new StatusCode('urn:oasis:names:tc:SAML:2.0:status:Success')))
            ->setSignature(new SignatureWriter($this->cert, $this->key))
            ->setRelayState(request()->RelayState);

        // if ($sign) $response->setSignature(new SignatureWriter($this->cert, $this->key));
    }

    public function sendResponse($response)
    {
        $postBinding = (new BindingFactory())->create(SConst::BINDING_SAML2_HTTP_POST);
        $messageContext = new MessageContext();
        $messageContext->setMessage($response)->asResponse();
        // $sc = new SC;
        // $response->serialize($sc->getDocument(), $sc);
        // dd($sc, $sc->getDocument(), $sc->getDocument()->saveXML());
        $httpResponse = $postBinding->send($messageContext);

        print $httpResponse->getContent();
    }
}