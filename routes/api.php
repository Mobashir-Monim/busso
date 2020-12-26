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
});