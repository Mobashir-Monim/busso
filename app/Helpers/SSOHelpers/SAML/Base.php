<?php

namespace App\Helpers\SSOHelpers\SAML;

use App\Helpers\Helper;
use Carbon\Carbon;
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

class Base extends Helper
{
    protected $authN = null;
    protected $entity = null;
    protected $destination = null;
    protected $issuer = null;
    protected $cert = null;
    protected $key = null;

    public function __construct($saml, $entity)
    {
        $deserializationContext = new DC();
        $deserializationContext->getDocument()->loadXML(gzinflate(base64_decode($saml)));
        $authnRequest = new ANR();
        $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);
        $this->spreadEssentials($authnRequest, $entity);
    }

    public function spreadEssentials($authN, $entity)
    {
        $this->authN = $authN;
        $this->entity = $entity;
        $this->destination = $entity->acs;
        $this->issuer = $entity->entityID;
        $this->cert = X509::fromFile(storage_path("app/certificates/$entity->folder/$entity->cert.crt"));
        $this->key = KH::createPrivateKey(file_get_contents(storage_path("app/certificates/$entity->folder/$entity->key.pem")), $this->entity->pemPass, false);
    }

    public function buildResponse(&$response)
    {
        $response->setID(LSH::generateID())
            ->setIssueInstant(new \DateTime())
            ->setDestination($this->destination)
            ->setIssuer(new Issuer($this->issuer))
            ->setStatus(new Status(new StatusCode('urn:oasis:names:tc:SAML:2.0:status:Success')))
            ->setSignature(new SignatureWriter($this->cert, $this->key))
            ->setRelayState(request()->RelayState);
    }

    public function sendResponse($response)
    {
        $postBinding = (new BindingFactory())->create(SConst::BINDING_SAML2_HTTP_POST);
        $messageContext = new MessageContext();
        $messageContext->setMessage($response);
        $message = $messageContext->getMessage();
        $message->setRelayState(request()->get('RelayState'));
        $messageContext->setMessage($message);
        dd($messageContext, $message, $response, request()->RelayState);
        $httpResponse = $postBinding->send($messageContext);

        print $httpResponse->getContent();
    }
}