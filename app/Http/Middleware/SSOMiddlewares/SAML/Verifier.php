<?php

namespace App\Http\Middleware\SSOMiddlewares\SAML;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \LightSaml\Model\Context\DeserializationContext as DC;
use \LightSaml\Model\Protocol\AuthnRequest as ANR;
use App\Models\SAMLEntity as SE;

class Verifier
{
    protected $saml = null;
    protected $entity = null;
    protected $destination = null;
    protected $issuer = null;
    protected $issueInstant = null;
    protected $acs = null;
    private $status = ['next' => true];
    public $count = 0;
    // dd($x, $x->getIssuer()->getValue(), $x->getDestination(), $x->getAssertionConsumerServiceURL(), $x->getIssueInstantTimestamp());
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->deserializer($request->SAMLRequest);
        $verificationArray = $this->generateCheckArray();

        for ($i = 0; $i < sizeof($verificationArray) && $this->status['next']; $i++) {
            $this->verifyPart($verificationArray[$i][0], $verificationArray[$i][1]);
            $this->count++;
        }

        if (!$this->status['next']) return response($this->status['message'], $this->status['code'])->header('Content-Type', 'text/plain');

        return $next($request);
    }

    public function deserializer($SAMLRequest)
    {
        $deserializationContext = new DC();
        $deserializationContext->getDocument()->loadXML(gzinflate(base64_decode($SAMLRequest)));
        $authnRequest = new ANR();
        $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);
        $this->spreadSAML($authnRequest);
    }

    public function spreadSAML($authN)
    {
        $this->entity = request()->route('entity');
        $this->destination = $authN->getDestination();
        $this->issuer = $authN->getIssuer()->getValue();
        $this->issueInstant = $authN->getIssueInstantTimestamp();
        $this->acs = $authN->getAssertionConsumerServiceURL();
    }

    public function generateCheckArray()
    {
        dd(is_null($this->entity));
        return [
            [is_null($this->entity), 404],
            [request()->url() != $this->destination, 400],
            [$this->entity->issuer != $this->issuer, 404],
            [$this->entity->acs != $this->acs, 404],
            [Carbon::now() < Carbon::parse($this->issueInstant), 425],
            [Carbon::now()->diffInSeconds(Carbon::parse($this->issueInstant)) > 300, 406],
        ];
    }

    public function verifyPart($status, $code = 404)
    {
        if (!$status) {
            $this->status['code'] = $code;
            $this->status['message'] = $this->getMessage($code) . $this->count;
            $this->status['next'] = false;
        } else {
            $this->status['next'] = true;
        }
    }

    public function getMessage($code)
    {
        $message = '';
        
        switch ($code) {
            case 200:
                $message = 'Ok';
                break;
            case 400:
                $message = 'Bad Request';
                break;
            case 404:
                $message = 'Not Found';
                break;
            case 406:
                $message = 'Not Acceptable';
                break;
            case 425:
                $message = 'Too Early';
                break;
            default:
                $message = 'No Message Found';
                break;
        }

        return $message;
    }
}
