<?php

namespace App\Http\Controllers\SSOControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SSOHelpers\SAML\Login as SamlSSO;
use App\Helpers\SSOHelpers\SAML\Logout as SamlSLO;
use App\Helpers\SAMLEntityHelpers\MetadataFetcher;
use App\Models\SAMLEntity;

class SAMLController extends Controller
{
    public function login(SAMLEntity $entity, Request $request)
    {
        $helper = new SamlSSO($request->SAMLRequest, $entity);
        $response = $helper->loginResponse();
        $helper->sendResponse($response);
    }

    public function logout(SAMLEntity $entity, Request $request)
    {
        $helper = new SamlSLO($request->SAMLRequest, $entity);
        $response = $helper->logoutResponse();
        $helper->sendResponse($response);
    }

    public function metaDoc(SAMLEntity $entity, $type)
    {
        if (!in_array($type, ['download', 'url'])) return response('Not Found', 404)->header('Content-Type', 'text/plain');
        $helper = new MetadataFetcher($entity, $type);

        return $helper->getMetadata();
    }
}
