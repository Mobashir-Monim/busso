<?php

namespace App\Http\Controllers\SSOControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Helpers\SSOHelpers\OAuth\Login as OauthLogin;
use App\Helpers\SSOHelpers\OAuth\JwksHelper;
use Laravel\Passport\Passport;
use App\Models\Passport\Token;
use App\Models\Passport\Client;
use App\Helpers\AccessLogHelpers\OauthLogger;
use App\Models\ResourceGroup;

class OauthController extends Controller
{
    public function login($oauth, Request $request)
    {
        if (!Auth::check()) return view('auth.login', ['oauth' => $oauth]);

        $helper = new OauthLogin;
        $val = $helper->authenticatorParamDecompressor($oauth);

        return $helper->loginStatus($val);
    }

    public function authenticator()
    {
        return redirect()->route('sso.oauth.authenticate', ['oauth' => (new OauthLogin)->authenticatorParamCompactor([
            'client_id' => request()->client_id,
            'scope' => request()->scope,
            'state' => request()->state,
            'nonce' => request()->nonce,
            'redirect_uri' => request()->redirect_uri,
            'timestamp' => Carbon::now()->timestamp,
            'all' => request()->all()
        ])]);
    }

    public function authenticate(Request $request)
    {
        $helper = new OauthLogin;
        $val = $helper->authenticatorParamDecompressor($request->stuff);

        return $helper->loginStatus($val);
    }

    public function exchangeCodeToken()
    {
        $helper = new OauthLogin;
        $auth_code = Passport::authCode()->find(request()->code);
        $access_token = $helper->createAccessToken($auth_code->user_id, $auth_code->client_id, $auth_code->scopes, Passport::token());

        return response()->json($helper->exchangeCodeToken($auth_code, $access_token, $auth_code->client_id));
    }

    public function userInfo()
    {
        $token = Token::find(request()->bearerToken());

        return response()->json((new OauthLogin)->getUserInfo($token));
    }

    public function discoveryDoc(ResourceGroup $group)
    {
        return response()->json([
            'issuer' => url()->to('/'),
            'authorization_endpoint' => route('api.sso.oauth.auth'),
            'token_endpoint' => route('api.sso.oauth.token'),
            'userinfo_endpoint' => route('api.sso.oauth.user'),
            'jwks_uri' => route('sso.oauth.certs', ['group' => $group->id]),
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
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_SLASHES);
    }

    public function jwksDoc(ResourceGroup $group)
    {
        $helper = new JwksHelper($group);

        return response()->json(
            $helper->getJwksDoc(),
            200,
            [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ],
            JSON_UNESCAPED_SLASHES
        );
    }
}
