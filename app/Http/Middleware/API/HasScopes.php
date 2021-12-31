<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;

class HasScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$scopes)
    {
        $flag = true;
        $client = $this->getClient($request);

        foreach ($scopes as $scope)
            $flag = $flag && in_array($scope, $client->scopes);

        if ($flag)
            return $next($request);

        return response()->json([
            "message" => "The client does not have the required permissions"
        ], 403);
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
        }

        return $request->client_id;
    }
}
