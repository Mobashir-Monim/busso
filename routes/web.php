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
    $res = json_decode(\Http::get('https://busso-staging.eveneer.xyz/oauth/v2/oauth2/certs')->body());
    $rsa = new phpseclib\Crypt\RSA();
    $rsa->loadKey([
        'e' => new phpseclib\Math\BigInteger(base64_decode($res->keys[0]->e), 256),
        'n' => new phpseclib\Math\BigInteger(base64url_decode($res->keys[0]->n), 256)
    ]);
    $key = $rsa->getPublicKey();
    $x = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwczovL2J1c3NvLXN0YWdpbmcuZXZlbmVlci54eXoiLCJhenAiOiJkNjA5ZmMzMy00MzBmLTRhYTYtYTYyOC0wYjAzZjE5MGU2MGQiLCJhdWQiOiJkNjA5ZmMzMy00MzBmLTRhYTYtYTYyOC0wYjAzZjE5MGU2MGQiLCJzdWIiOiI0MjFiZDdjNC0zMDM1LTQ5MTUtYTY4MS0wNTczYTA3Y2Q4MmIiLCJhdF9oYXNoIjoiMWIyNWI0ZWFkYzliZTRiMWFiOGZkMzViYTIxOGQ2NzA3NDBjOThiZTM3NjNkMmM3NTAwZmQwYjE1NmNmYmViNiIsImlhdCI6MTYxNjI3MDM5OSwiZXhwIjoxNjE2ODc1MTk5LCJub25jZSI6bnVsbH0.wl2atC0or7ys2j6mDnP3H0iqZ5iSc8BbtZct4fUSg1Fr-O98rJ_7ZbvMbu1S_Wu_Pus4Jn_cyREUjf9lvcz82WSMYH5bsRg2r1u2Y-2UfvcIBJb__4UTnstMzvuVO40UvSskECd-YWfxMlEkg-YQOXJGYxQGpbY03szqKhlbBGY04tVeliEGub_rqbI8G0Xcbg3sNuSFvqGTEmcXlGXUpKqszZU4qu0KIT-UTH21vVXuEPdMdqSD85thxeFwSXPmVNqz5ODY0Op-bx8yNzXeYsZUCG4M-9vZMI-A6_9qLdynLW2Qon2JfOMRc2jdFu1bBArS5XQb0zrE0PY1M0oLtegksIs0_o0MWzepKf75G1kGFzVJ87YJiivAg4_8BhAUG-_QbsWNqcBwZ6wJla70UAwRyOwQBDPH2_2UIea64lywIie53cN1EDi-urSJ-jKnTJtZabBcn5Eb4i1PxtwrgXOui62OGcnDnPO1g31lwsEeMD0U-Qt3osUmdSxkdMJZ6DWDYivG57RI9hWz3C-q-szYfcNPh7RJoVMGlMODB4taiqe4x8gDK0sIph7Ffyp2J584ETUbRi1t7mLX3-z2TcRajWajT0aVozU9McuOxffywHUJosbRJrMT_T5d4JrH_JnEa9ls6P_SGGWWRr0Axp-iU986-VEtEJjINqjoZrE';
    $token = explode(".", $x);
    $msg = $token[0] . "." . $token[1];
    $header = json_decode(base64url_decode($token[0]));
    $payload = json_decode(base64url_decode($token[1]));
    $signature = base64url_decode($token[2]);
    $rsa->setHash('sha256');

    dd(openssl_verify($msg, $signature, $key, OPENSSL_ALGO_SHA256), $rsa->verify($msg, $signature));
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
                    Route::post('/{group}/{oauth}/oauth/redirect', [App\Http\Controllers\ResourceGroupController::class, 'redirectSet'])->name('oauth.redirect-set');
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
                Route::get('/{user}', [App\Http\Controllers\UserController::class, 'showUser'])->name('show');
                Route::post('/search/results', [App\Http\Controllers\UserController::class, 'search'])->name('search');
                Route::post('/{user}/password/override', [App\Http\Controllers\UserController::class, 'overridePassword'])->name('password.override')->middleware('hasSystemRole:super-admin');
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