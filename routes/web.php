<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    dd(getConfig('app.zone'));
    dd('nothing in test');
})->name('tester');

Auth::routes(['register' => false]);

Route::middleware(['password-reset.enforced', 'password-reset.validity'])->group(function () {
    Route::name('sso.')->group(function () {
        Route::name('saml.')->prefix('saml')->group(function () {
            Route::get('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login')->middleware('sso.saml.login-verify');
            Route::get('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout')->middleware('sso.saml.logout-verify');
            Route::post('/assertion/{entity}/login', [App\Http\Controllers\SSOControllers\SAMLController::class, 'assertLogin'])->name('assert-login')->middleware('sso.credential-checher');
            Route::get('/metadata/{entity}/{type}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'metaDoc'])->name('metadoc');
        });
        Route::name('oauth.')->prefix('oauth/v2')->group(function () {
            Route::get('/auth/{oauth}', [App\Http\Controllers\SSOControllers\OauthController::class, 'login'])->name('authenticate')->middleware('sso.oauth.session');
            Route::post('/auth', [App\Http\Controllers\SSOControllers\OauthController::class, 'authenticate'])->name('login')->middleware('sso.credential-checher', 'sso.oauth.session');
            Route::get('/.well-known/openid-configuration', [App\Http\Controllers\SSOControllers\OauthController::class, 'discoveryDoc'])->name('discovery-doc');
            Route::get('/oauth2/certs', [App\Http\Controllers\SSOControllers\OauthController::class, 'jwksDoc'])->name('certs');
        });
    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/access-log', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('access-logs');
        Route::get('/claims', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('claims');
        Route::get('/roles', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('roles');
        Route::get('/scopes', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('scopes');
        Route::get('/user-attribute-values', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('user-attribute-values');
        Route::get('/user-attributes', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('user-attributes');
        
        /** Resource Group and Resource Routes */
        Route::middleware(['hasSystemRole:resource-admin,super-admin'])->group(function () {
            Route::get('/resource-groups', [App\Http\Controllers\ResourceGroupController::class, 'index'])->name('resource-groups');
            Route::post('/resource-groups', [App\Http\Controllers\ResourceGroupController::class, 'create'])->name('resource-groups');
    
            Route::prefix('resource-groups')->group(function () {
                /** Resource Group Routes */
                Route::name('resource-groups.')->group(function () {
                    Route::get('/{group}', [App\Http\Controllers\ResourceGroupController::class, 'show'])->name('show');
                    Route::post('/{group}/{oauth}/oauth', [App\Http\Controllers\ResourceGroupController::class, 'oauthReset'])->name('oauth.reset');
                    Route::post('/{group}/{saml}/saml', [App\Http\Controllers\ResourceGroupController::class, 'samlConfig'])->name('saml.config');
                });
    
                /** Resource Routes */
                // Route::get('/{group}/resources', [App\Http\Controllers\ResourceController::class, 'index'])->name('resources');
                Route::name('resources.')->prefix('{group}/resources')->group(function () {
    
                });
            });
        });
    
        /** User Routes */
        Route::middleware(['hasSystemRole:user-admin,super-admin'])->group(function () {
            Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
            Route::name('users.')->prefix('/user')->group(function () {
                Route::post('/create', [App\Http\Controllers\UserController::class, 'create'])->name('create');
                Route::get('/{user}', [App\Http\Controllers\UserController::class, 'showUser']);
            });
        });

        Route::name('users.')->prefix('/user')->group(function () {
            Route::get('/logs/services', [App\Http\Controllers\UserController::class, 'accessLog'])->name('access-log');
        });
    });
});

Route::middleware(['auth'])->group(function () {
    Route::name('users.')->prefix('/user')->group(function () {
        Route::get('/password/reset', [App\Http\Controllers\UserController::class, 'passwordReset'])->name('password.reset')->middleware('password.confirm');
        Route::post('/password/reset', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('password.reset');
    });
});