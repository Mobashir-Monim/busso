<?php

namespace App\Helpers\APIHelpers;

use App\Helpers\Helper;

class Authenticator extends Helper
{
    protected $status;
    protected $client;
    protected $user;
    protected $response;

    public function __construct($client_id, $grant_type)
    {
        if ($this->clientExists($client_id)) {

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

    public function revokeExistingTokens()
    {
        $existing = Passport::token()->where('client_id', $this->client->id)->where('revoked', false)->get();

        foreach ($existing as $token) {
            $token->revoked = true;
            $token->save();
        }
    }
}