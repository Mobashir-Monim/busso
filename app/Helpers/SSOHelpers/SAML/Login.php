<?php

namespace App\Helpers\SSOHelpers\SAML;

use App\Helpers\Helper;
use Auth;
use Carbon\Carbon;
use \LightSaml\Model\Context\DeserializationContext as DC;
use \LightSaml\Model\Protocol\AuthnRequest as ANR;
use \LightSaml\Credential\X509Certificate as X509;
use \LightSaml\Credential\KeyHelper as KH;
use \LightSaml\Model\Protocol\Response as LSR;
use \LightSaml\Model\Assertion\Assertion;
use \LightSaml\Helper as LSH;
use \LightSaml\Model\Assertion\Issuer;
use \LightSaml\Model\Assertion\Subject;
use \LightSaml\Model\Assertion\NameID;
use \LightSaml\SamlConstants as SConst;
use \LightSaml\Model\Assertion\SubjectConfirmation;
use \LightSaml\Model\Assertion\SubjectConfirmationData;
use \LightSaml\Model\Assertion\Conditions;
use \LightSaml\Model\Assertion\AudienceRestriction;
use \LightSaml\Model\Assertion\AttributeStatement;
use \LightSaml\Model\Assertion\Attribute;
use \LightSaml\ClaimTypes;
use \LightSaml\Model\Assertion\AuthnStatement;
use \LightSaml\Model\Assertion\AuthnContext;
use \LightSaml\Model\Protocol\Status;
use \LightSaml\Model\Protocol\StatusCode;
use \LightSaml\Model\XmlDSig\SignatureWriter;
use \LightSaml\Binding\BindingFactory;
use \LightSaml\Context\Profile\MessageContext;

class Login extends Helper
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

    public function assertionResponse()
    {
        $response = new LSR();
        $assertion = new Assertion();
        $this->buildXML($response, $assertion);
        
        return $response;
    }
    
    public function buildXML(&$response, &$assertion)
    {
        $this->buildAssertion($assertion);
        $this->setAssertionCondition($assertion);
        $this->addAttributeStatement($assertion);
        $this->addAuthNStatement($assertion);
        $this->buildResponse($response, $assertion);
    }

    public function buildResponse(&$response, &$assertion)
    {
        $response->addAssertion($assertion)
            ->setID(LSH::generateID())
            ->setIssueInstant(new \DateTime())
            ->setDestination($this->destination)
            ->setIssuer(new Issuer($this->issuer))
            ->setStatus(new Status(new StatusCode('urn:oasis:names:tc:SAML:2.0:status:Success')))
            ->setSignature(new SignatureWriter($this->cert, $this->key));
    }

    public function buildAssertion(&$assertion)
    {
        $assertion->setId(LSH::generateID())
            ->setIssueInstant(new \DateTime())
            ->setIssuer(new Issuer($this->issuer))
            ->setSubject($this->buildAssertionSubject());
    }

    public function buildAssertionSubject()
    {
        return (new Subject())
            ->setNameID(new NameID(
                Auth::user()->email,
                SConst::NAME_ID_FORMAT_EMAIL
            ))
            ->addSubjectConfirmation((new SubjectConfirmation())
                ->setMethod(SConst::CONFIRMATION_METHOD_BEARER)
                ->setSubjectConfirmationData(
                    (new SubjectConfirmationData())
                        ->setInResponseTo($this->authN->getId())
                        ->setNotOnOrAfter(new \DateTime('+1 MINUTE'))
                        ->setRecipient($this->authN->getAssertionConsumerServiceURL())
                    )
                );
    }

    public function setAssertionCondition(&$assertion)
    {
        $assertion->setConditions(
            (new Conditions())
                ->setNotBefore(new \DateTime())
                ->setNotOnOrAfter(new \DateTime('+1 MINUTE'))
                ->addItem(
                    new AudienceRestriction([$this->authN->getAssertionConsumerServiceURL()])
                )
            );
    }

    public function addAttributeStatement(&$assertion)
    {
        $statement = new AttributeStatement();
        $this->addAttributes($statement);
        $assertion->addItem($statement);
    }

    public function addAttributes(&$statement)
    {
        $statement->addAttribute(new Attribute(ClaimTypes::EMAIL_ADDRESS, Auth::user()->email));
        $statement->addAttribute(new Attribute(ClaimTypes::COMMON_NAME, Auth::user()->name));

        foreach ($this->entity->userAttributes as $uAt) {
            $attribute = new Attribute($uAt->name, $uAt->uav->where('user_id', Auth::user()->id)->value);
            $attribute->setNameFormat("urn:oasis:names:tc:SAML:2.0:attrname-format:basic");
            $statement->addAttribute($attribute);
        }
    }

    public function addAuthNStatement(&$assertion)
    {
        $assertion->addItem((new AuthnStatement())
            ->setAuthnInstant(new \DateTime('-10 MINUTE'))
            ->setSessionIndex(hash('sha512', json_encode([request(), csrf_token(), request()->session()->getId()])))
            ->setAuthnContext(
                    (new AuthnContext())
                ->setAuthnContextClassRef(SConst::AUTHN_CONTEXT_PASSWORD_PROTECTED_TRANSPORT)
                )
            );
    }

    public function sendResponse($response)
    {
        $postBinding = (new BindingFactory())->create(SConst::BINDING_SAML2_HTTP_POST);
        $messageContext = new MessageContext();
        $messageContext->setMessage($response)->asResponse();
        $httpResponse = $postBinding->send($messageContext);

        print $httpResponse->getContent()."\n\n";
    }
}