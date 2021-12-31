<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use App\Models\OauthClient;

class Enabled
{
    protected $messge = "API consumption not enabled";
    protected $code = 403;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        $client = $this->getClient($request);

        if (!is_null($client)) {
            if ($client->api_enabled)
                return $next($request);
        } else {
            $this->messge = "Client not found";
            $this->code = 404;
        }

        return response()->json([
            "message" => $this->messge
        ], $this->code);
    }

    public function getClient($request)
    {
        if (!is_null($request->api_client))
            return $request->api_client;

        $client = OauthClient::find($this->findClientID($request));
        $request->request->add(['api_client' => $client]);

        return $client;
    }

    public function findClientID($request)
    {
        if (!is_null($request->bearerToken())) {
            return json_decode(base64url_decode(explode(".", $request->bearerToken())[1]), true)['aud'];
        } else {
            return $request->client_id;
        }
    }
}
