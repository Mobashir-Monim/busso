<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    // \Auth::login(App\Models\User::where('email', 'mobashirmonim@gmail.com')->first());
    // $entity = App\Models\SAMLEntity::first();
    // $helper = new App\Helpers\Helper;
    // $authnRequest = new \LightSaml\Model\Protocol\AuthnRequest();
    // $authnRequest
    //     ->setAssertionConsumerServiceURL($entity->acs)
    //     ->setProtocolBinding(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST)
    //     ->setID(\LightSaml\Helper::generateID())
    //     ->setIssueInstant(new \DateTime())
    //     ->setDestination(route('sso.saml.login', ['entity' => $entity->id]))
    //     ->setIssuer(new \LightSaml\Model\Assertion\Issuer('https://my.entity.id'))
    // ;
    // // dd(file_get_contents(storage_path("app/certificates/$entity->folder/$entity->cert.crt")));
    // $certificate = \LightSaml\Credential\X509Certificate::fromFile(storage_path("app/certificates/$entity->folder/$entity->cert.crt"));
    // $privateKey = \LightSaml\Credential\KeyHelper::createPrivateKey(
    //     file_get_contents(storage_path("app/certificates/$entity->folder/$entity->key.pem")),
    //     $entity->pemPass,
    //     false);

    // $authnRequest->setSignature(new \LightSaml\Model\XmlDSig\SignatureWriter($certificate, $privateKey));

    // $serializationContext = new \LightSaml\Model\Context\SerializationContext();
    // $authnRequest->serialize($serializationContext->getDocument(), $serializationContext);
    
    // $saml = base64_encode(gzdeflate($serializationContext->getDocument()->saveXML()));

    // $asserter = new App\Helpers\SSOHelpers\SAML\Login($saml, $entity);
    // $response = $asserter->assertionResponse();
    // // $asserter->sendResponse($response);
    // $sc = new \LightSaml\Model\Context\SerializationContext();
    // $response->serialize($sc->getDocument(), $sc);
    // // dd(base64_encode(($sc->getDocument()->saveXML())));
    // return response($sc->getDocument()->saveXML(), 200)->header('Content-Type', 'text/xml');
    // dd($response, $sc->getDocument()->saveXML());
    
    // /** Signature verification code */
    // $deserializationContext = new \LightSaml\Model\Context\DeserializationContext();
    // $deserializationContext->getDocument()->loadXML($serializationContext->getDocument()->saveXML());
    // $authnRequest = new \LightSaml\Model\Protocol\AuthnRequest();
    // $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);

    // $key = \LightSaml\Credential\KeyHelper::createPublicKey(
    //     \LightSaml\Credential\X509Certificate::fromFile(storage_path("app/certificates/$entity->folder/$entity->cert.crt"))
    // );

    // /** @var \LightSaml\Model\XmlDSig\SignatureXmlReader $signatureReader */
    // $signatureReader = $authnRequest->getSignature();

    // try {
    //     $ok = $signatureReader->validate($key);

    //     if ($ok) {
    //         print "Signature OK\n";
    //     } else {
    //         print "Signature not validated";
    //     }
    // } catch (\Exception $ex) {
    //     print "Signature validation failed\n";
    // }

    // $deserializationContext = new \LightSaml\Model\Context\DeserializationContext();
    // $deserializationContext->getDocument()->loadXML($serializationContext->getDocument()->saveXML());
    // $x = new \LightSaml\Model\Protocol\AuthnRequest();
    // $x->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);
    // dd($x, $x->getIssuer()->getValue(), $x->getDestination(), $x->getAssertionConsumerServiceURL(), $x->getIssueInstantTimestamp());
    dd('nothing in test');
})->name('tester');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/saml');

Route::name('sso.')->group(function () {
    Route::name('saml.')->prefix('saml')->group(function () {
        Route::middleware(['sso.saml.verify'])->group(function () {
            Route::get('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
            Route::get('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
            Route::post('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
            Route::post('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
            Route::post('/assertion/{entity}/login', [App\Http\Controllers\SSOControllers\SAMLController::class, 'assertLogin'])->name('assert-login')->middleware('sso.credential-checher');
        });
        Route::get('/metadata/{entity}/{type}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'metaDoc'])->name('metadoc');
    });
});
