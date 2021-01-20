<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('sso.')->group(function () {
    Route::name('saml.')->prefix('saml')->group(function () {
        Route::post('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login-api')->middleware('sso.saml.login-verify');
        Route::post('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout-api')->middleware('sso.saml.logout-verify');
    });

    Route::name('oauth.')->prefix('oauth')->group(function () {
        Route::get('/auth', [App\Http\Controllers\SSOControllers\OauthController::class, 'authenticator'])->middleware(['sso.oauth.param', 'sso.oauth.client']);
        Route::get('/token', [App\Http\Controllers\SSOControllers\OauthController::class, 'exchangeCodeToken'])->middleware(['sso.oauth.auth-grant', 'sso.oauth.client', 'sso.oauth.client-cred', 'sso.oauth.auth-code']);
        Route::post('/token', [App\Http\Controllers\SSOControllers\OauthController::class, 'exchangeCodeToken'])->middleware(['sso.oauth.auth-grant', 'sso.oauth.client', 'sso.oauth.client-cred', 'sso.oauth.auth-code']);
        Route::get('/userinfo', [App\Http\Controllers\SSOControllers\OauthController::class, 'userInfo'])->middleware(['sso.oauth.access-token']);
    });
});