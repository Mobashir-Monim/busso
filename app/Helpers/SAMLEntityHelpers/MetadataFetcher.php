<?php

namespace App\Helpers\SAMLEntityHelpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;

class MetadataFetcher extends Helper
{
    protected $entity = null;
    protected $type = null;
    protected $disk = null;

    public function __construct($entity, $type)
    {
        $this->entity = $entity;
        $this->type = $type;
        $this->disk = config('app.storage');
    }

    public function getMetadata()
    {
        return $this->type == 'url' ? $this->urlResponse() : $this->downloadResponse();
    }

    public function downloadResponse()
    {
        return $this->type == 'download' ? $this->downloadMetadata() : $this->downloadCertificate();
    }

    public function urlResponse()
    {
        return response(
            Storage::disk($this->disk)->get('certificates/SAML/' . $this->entity->folder. "/" . $this->entity->metadataDocName . ".xml"),200
        )->header('Content-Type', 'text/xml');
    }

    public function downloadMetadata()
    {
        return Storage::disk($this->disk)->download(
            'certificates/SAML/' . $this->entity->folder. "/" . $this->entity->metadataDocName . ".xml",
            $this->entity->group->name.'-metadata.xml',
            ['Content-Type: text/xml']
        );
    }

    public function downloadCertificate()
    {
        return Storage::disk($this->disk)->download(
            'certificates/SAML/' . $this->entity->folder. "/" . $this->entity->cert . ".crt",
            $this->entity->group->name.'-public certificate.crt',
            ['Content-Type: text/xml']
        );
    }
}