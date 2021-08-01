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
use App\Models\OauthClient;
use App\Helpers\AccessLogHelpers\OauthLogger;
use Illuminate\Support\Facades\Storage;

class Login extends Helper
{
    protected $entity;
    protected $headers = [
        'RS256' => ['typ' => 'JWT', 'alg' => 'RS256'],
        'HS256' => ['typ' => 'JWT', 'alg' => 'HS256'],
    ];

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

    public function generateIDTokenPayload($auth_code, $access_token)
    {
        return [
            "iss" => url()->to('/'),
            "azp" => $access_token->client_id,
            "aud" => $access_token->client_id,
            "sub" => $access_token->user_id,
            // "at_hash" => hash_hmac('sha256', $access_token->id),
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

    public function exchangeCodeToken($auth_code, $access_token, $client_id)
    {
        $auth_code->revoked = true;
        $auth_code->save();
        $this->entity = OauthClient::find($client_id);

        return [
            'access_token' => $access_token->id,
            'token_type' => 'Bearer',
            'expires_in' => 604800,
            'id_token' => $this->generateIDToken('RS256', $this->generateIDTokenPayload($auth_code, $access_token)),
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

    public function generateIDToken($type, $payload, $key = null)
    {
        if ($type == 'RS256') {
            return $this->generateRS256Token(
                $payload,
                Storage::disk('s3')->get("certificates/Oauth/" . $this->entity->folder . "/" . $this->entity->key . ".pem")
            );
        } else {
            return $this->generateHS256Token($payload, $key);
        }
    }

    public function generateRS256Token($payload, $key)
    {
        $penc = base64url_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));
        $header = base64url_encode(json_encode($this->headers['RS256'], JSON_UNESCAPED_SLASHES));
        $msg = $header . "." . $penc;
        $ossign = "";
        openssl_sign($msg, $ossign, $key, OPENSSL_ALGO_SHA256);
        
        return $msg . "." . base64url_encode($ossign);
    }

    public function generateHS256Token($payload, $key, $enc = false)
    {
        return JWT::encode($payload, $key, 'HS256');
    }

    public function loginStatus($val)
    {
        new OauthLogger(auth()->user()->id, OauthClient::find($val->client_id)->user_id);
            
        return redirect()->away($val->redirect_uri . "?code=" . $this->createAuthCode($val, Passport::authCode())->id . "&state=$val->state");
    }
}