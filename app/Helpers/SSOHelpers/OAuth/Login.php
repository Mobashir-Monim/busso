<?php

namespace App\Helpers\SSOHelpers\OAuth;

use App\Helpers\Helper;
use Carbon\Carbon;
use Auth;
use Laravel\Passport\Passport;
use App\Models\ResourceGroup;
use App\Models\User;
use App\Models\Passport\Token;
use App\Models\Passport\Client;
use \Firebase\JWT\JWT;

class Login extends Helper
{
    public function authenticatorParamCompactor($data = null)
    {
        return base64url_encode(json_encode([
            'client_id' => $data['client_id'],
            'scope' => $data['scope'],
            'state' => $data['state'],
            'nonce' => $data['nonce'],
            'redirect_uri' => $data['redirect_uri'],
            'timestamp' => $data['timestamp']
        ]));
    }

    public function authenticatorParamDecompressor($data)
    {
        return json_decode(base64url_decode($data));
    }

    public function authenticateCreds($request)
    {
        $credentials = request(['email', 'password']);
        return Auth::attempt($credentials);
    }

    public function generateIDToken($auth_code, $access_token)
    {
        return [
            "iss" => url()->to('/'),
            "azp" => $access_token->client_id,
            "aud" => $access_token->client_id,
            "sub" => $access_token->user_id,
            "at_hash" => hash('sha256', $access_token->id),
            "iat" => Carbon::parse($access_token->created_at)->timestamp,
            "exp" => Carbon::parse($access_token->expires_at)->timestamp,
            "nonce" => $auth_code->nonce,
        ];
    }

    public function createAuthCode($val, $passportAuthCode)
    {
        return $passportAuthCode->create([
            'user_id' => auth()->user()->id,
            'client_id' => $val->client_id,
            'nonce' => $val->nonce,
            'scopes' => is_null($val->scope) ? null : json_encode(explode(' ', $val->scope)),
            'revoked' => false,
            'expires_at' => Carbon::now()->addSeconds(60)
        ]);
    }

    public function createAccessToken($user_id, $client_id, $scopes, $passportToken)
    {
        return $passportToken->create([
            'user_id' => $user_id,
            'client_id' => $client_id,
            'scopes' => $scopes,
            'name' => 'SSO login for ' . Client::find($client_id)->name,
            'expires_at' => Carbon::now()->addSeconds(604800)->toDateTimeString(),
            'revoked' => false
        ]);
    }

    public function exchangeCodeToken($auth_code, $access_token)
    {
        $auth_code->revoked = true;
        $auth_code->save();

        return [
            'access_token' => $access_token->id,
            'token_type' => 'Bearer',
            'expires_in' => 604800,
            'id_token' => JWT::encode($this->generateIDToken($auth_code, $access_token), request()->client_secret, 'HS256'),
        ];
    }

    public function getUserInfo($token)
    {
        $user = User::find($token->user_id);
        $scopes = json_decode($token->scopes);
        $user_info = ['sub' => $user->id];

        if (in_array('email', $scopes)) {
            $user_info['email'] = $user->email;
        }
        
        if (in_array('name', $scopes)) {
            $user_info['name'] = $user->name;
        }

        if (in_array('profile', $scopes)) {
            $user_info['email'] = $user->email;
            $user_info['name'] = $user->name;
        }

        // foreach ($scopes as $key => $scope) {
        //     if ($scope != 'openid') {
        //         // loop trough scope attributes
        //             // if !array_key_exists(attribute, $user_info)
        //                 // $user_info[attribute] = attribute value
        //     }
        // }

        return $user_info;
    }
}