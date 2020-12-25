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
            $this->configStatic($request->issuer, $request->acs, file_get_contents($request->cert));
        } else {
            $this->configDoc($request);
        }
    }

    public function configStatic($issuer, $acs, $cert)
    {
        $this->entity->issuer = $issuer;
        $this->entity->acs = $acs;
        Storage::disk(env('STORAGE_DISK', 'local'))->put("certificates/" . $this->entity->folder. "/" . $this->entity->id . ".crt", $cert, 0600);
        $this->entity->save();
    }

    public function configDoc($request)
    {
        $this->entity->doc = $request->meta_url;
        $this->entity->save();
        $content = $this->spreadDocContent(Http::get($request->meta_url)->body());
        
        $this->configStatic($content['issuer'], $content['acs'], $content['cert']);
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
            'cert' => trim($ed->getSignature()->getKey()->getX509Certificate())
        ];
    }
}