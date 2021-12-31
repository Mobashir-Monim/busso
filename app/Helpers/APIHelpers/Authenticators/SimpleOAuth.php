<?php

namespace App\Helpers\APIHelpers\Authenticators;

use App\Helpers\Helper;
use App\Models\OauthClient;
use Laravel\Passport\Passport;
use App\Models\Passport\Token;
use Auth;

class SimpleOAuth extends Helper
{
    protected $status;
    protected $client;
    protected $response;

    public function __construct($client_id, $client_secret)
    {
        if ($this->clientExists($client_id)) {
            if ($this->checkSecret($client_secret)) {
                if ($this->apiEnabled()) {
                    $this->setStausToTrue('Authenticated');
                }
            }
        }
    }

    public function clientExists($client_id)
    {
        $this->client = OAuthClient::find($client_id);

        if (!is_null($this->client))
            return true;

        $this->setStatusToFalse('Client not found', 404);

        return false;
    }

    public function checkSecret($client_secret)
    {
        if ($this->client->secret == $client_secret)
            return true;

        $this->setStatusToFalse('Client authentication failed', 403);

        return false;
    }

    public function apiEnabled()
    {
        if ($this->client->api_enabled)
            return true;

        $this->setStatusToFalse('API consumption not enabled', 403);

        return false;
    }

    public function setStatusToFalse($message = "", $code = 500)
    {
        $this->status = [
            'success' => false,
            'message' => $message,
            'code' => $code
        ];
    }

    public function setStausToTrue($message = "")
    {
        $this->status = [
            'success' => true,
            'message' => $message,
            'code' => 200
        ];
    }

    public function getResponse()
    {
        if ($this->status['success']) {

            return response()->json([
                'token_type' => 'Bearer',
                'expires_in' => 604770,
                'access_token' => $this->createAccessToken(),
            ]);
        } else {
            return response()->json([
                'message' => $this->status['message']
            ], $this->status['code']);
        }
    }

    public function revokeExistingTokens()
    {
        $existing = Passport::token()->where('client_id', $this->client->id)->where('revoked', false)->get();

        foreach ($existing as $token) {
            $token->revoked = true;
            $token->save();
        }
    }
}