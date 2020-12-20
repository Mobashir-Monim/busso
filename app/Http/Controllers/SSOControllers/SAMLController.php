<?php

namespace App\Http\Controllers\SSOControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SAMLEntityHelpers\MetadataFetcher;
use App\Models\SAMLEntity;

class SAMLController extends Controller
{
    public function login()
    {

    }

    public function logout()
    {

    }

    public function metaDoc(SAMLEntity $entity, $type)
    {
        if (!in_array($type, ['download', 'url'])) return response('Not Found', 404)->header('Content-Type', 'text/plain');
        $helper = new MetadataFetcher($entity, $type);

        return $helper->getMetadata();
    }
}
