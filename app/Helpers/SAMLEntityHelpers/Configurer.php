<?php

namespace App\Helpers\SAMLEntityHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use \LightSaml\Model\Context\DeserializationContext;
use \LightSaml\Model\Metadata\EntityDescriptor;

class Configurer extends Helper
{
    protected $entity = null;
    protected $status = [];

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function updateConfig($request)
    {
        if (is_null($request->meta_url)) {
            if ($request->hasFile('cert')) {
                $this->configStatic($request->issuer, $request->acs, $request->aud, file_get_contents($request->cert));
            } else {
                $this->configStatic($request->issuer, $request->acs, $request->aud);
            }
        } else {
            $this->configDoc($request);
        }
    }

    public function configStatic($issuer, $acs, $aud, $cert = null)
    {
        $this->entity->issuer = $issuer;
        $this->entity->acs = $acs;
        $this->entity->aud = $aud;
        
        if (!is_null($cert)) {
            Storage::disk(config('app.storage'))->put("certificates/SAML/" . $this->entity->folder. "/" . $this->entity->id . ".crt", $cert, 0600);
            $this->entity->sig = "certificates/SAML/" . $this->entity->folder. "/" . $this->entity->id . ".crt";
        }

        $this->entity->save();
    }

    public function configDoc($request)
    {
        $this->entity->doc = $request->meta_url;
        $this->entity->save();
        $content = $this->spreadDocContent(Http::get($request->meta_url)->body());

        $this->configStatic($content['issuer'], $content['acs'], $request->aud, $content['cert']);
    }

    public function spreadDocContent($content)
    {
        $deserializationContext = new DeserializationContext();
        $ed = new EntityDescriptor;
        $deserializationContext->getDocument()->loadXML($content);
        $ed->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);

        return [
            'issuer' => $ed->getEntityID(),
            'acs' => $ed->getAllItems()[0]->getAllAssertionConsumerServices()[0]->getLocation(),
            'cert' => !is_null($ed->getSignature()) ? trim($ed->getSignature()->getKey()->getX509Certificate()) : null
        ];
    }
}