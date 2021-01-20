<?php

namespace App\Http\Controllers\SSOControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Helpers\SSOHelpers\OAuth\Login as OauthLogin;
use Laravel\Passport\Passport;
use App\Models\Passport\Token;

class OauthController extends Controller
{
    public function login($oauth, Request $request)
    {
        return view('auth.login', ['oauth' => $oauth]);
    }

    public function authenticator()
    {
        dd('henlo');
        dd(route('sso.oauth.login', ['oauth' => (new OauthLogin)->authenticatorParamCompactor([
            'client_id' => request()->client_id,
            'scope' => request()->scope,
            'state' => request()->state,
            'nonce' => request()->nonce,
            'redirect_uri' => request()->redirect_uri,
            'timestamp' => Carbon::now()->timestamp,
        ])]));
    }

    public function authenticate(Request $request)
    {
        $helper = new OauthLogin;
        $val = $helper->authenticatorParamDecompressor($request->stuff);

        return redirect($val->redirect_uri . "?state=$val->state&code=" . $helper->createAuthCode($val, Passport::authCode())->id . "&scope=$val->scope");
    }

    public function exchangeCodeToken()
    {
        $helper = new OauthLogin;
        $auth_code = Passport::authCode()->find(request()->code);
        $access_token = $helper->createAccessToken($auth_code->user_id, $auth_code->client_id, $auth_code->scopes, Passport::token());

        return response()->json($helper->exchangeCodeToken($auth_code, $access_token));
    }

    public function userInfo()
    {
        $token = Token::find(request()->bearerToken());

        return response()->json((new OauthLogin)->getUserInfo($token));
    }

    public function discoveryDoc()
    {
        return response()->json([
            'issuer' => url()->to('/'),
            'authorization_endpoint' => route('api.sso.oauth.auth'),
            'token_endpoint' => route('api.sso.oauth.token'),
            'userinfo_endpoint' => route('api.sso.oauth.user'),
            'jwks_uri' => route('sso.oauth.certs'),
            'scopes_supported' => url()->to('/'),
            'response_types_supported' => [
                'code',
                // 'id_token',
                // 'token id_token'
            ],
            'token_endpoint_auth_methods_supported' => [
                'client_secret_basic',
                'client_secret_post'
            ],
        ]);
    }

    public function jwksDoc()
    {
        $key = file_get_contents("../storage/oauth-public.key");
        $data = openssl_pkey_get_public($key);
        $data = openssl_pkey_get_details($data);

        return response()->json([
            "keys" => [
                [
                    // "kid" => "178ab1dc5913d929d37c23dcaa961872f8d70b68",
                    "kty" => "RSA",
                    "n" => base64url_encode($data['rsa']['n']),
                    "e" => base64url_encode($data['rsa']['e']),
                    "use" => "sig",
                    "alg" => "RS256"
                ],
              ]
        ]);
    }
}
