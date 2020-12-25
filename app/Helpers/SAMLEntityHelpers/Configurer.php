<?php

namespace App\Helpers\SAMLEntityHelpers;

use App\Helpers\Helper;

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
            $this->configStatic($request);
        } else {
            $this->configDoc($request);
        }

        $this->entity->save();
    }

    public function configStatic($request)
    {
        $this->entity->issuer = $request->issuer;
        $this->entity->acs = $request->acs;
        $this->entity->sig = $request->file('cert')->storeAs('certificates/' . $this->entity->folder, $this->entity->id . "." . $request->file('cert')->extension(), getStorageDisk());
    }
}