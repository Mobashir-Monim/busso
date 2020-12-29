<?php

namespace App\Http\Controllers\SSOControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SSOHelpers\SAML\Login as SamlSSO;
use App\Helpers\SSOHelpers\SAML\Logout as SamlSLO;
use App\Helpers\SAMLEntityHelpers\MetadataFetcher;
use App\Helpers\AccessLogHelpers\SAMLLogger;
use App\Models\SAMLEntity;
use Auth;

class SAMLController extends Controller
{
    public function login(SAMLEntity $entity, Request $request)
    {
        if (!Auth::check()) return view('auth.login', ['entity' => $entity]);

        return $this->assertLogin($entity, $request);
    }

    public function assertLogin(SAMLEntity $entity, Request $request)
    {
        new SAMLLogger(auth()->user()->id,$entity->group->id);
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
        if (!in_array($type, ['download', 'url', 'certificate'])) return response('Not Found', 404)->header('Content-Type', 'text/plain');
        $helper = new MetadataFetcher($entity, $type);

        return $helper->getMetadata();
    }
}
