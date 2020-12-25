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
    dd('nothing in test');
})->name('tester');

Auth::routes(['register' => false]);

Route::name('sso.')->group(function () {
    Route::name('saml.')->prefix('saml')->group(function () {
        Route::middleware(['sso.saml.verify'])->group(function () {
            Route::get('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
            Route::get('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
            Route::post('/assertion/{entity}/login', [App\Http\Controllers\SSOControllers\SAMLController::class, 'assertLogin'])->name('assert-login')->middleware('sso.credential-checher');
        });

        Route::get('/metadata/{entity}/{type}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'metaDoc'])->name('metadoc');
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
    Route::get('/users', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('users');
    
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
            Route::get('/{group}/resources', [App\Http\Controllers\ResourceController::class, 'index'])->name('resources');
            Route::name('resources.')->prefix('{group}/resources')->group(function () {

            });
        });
    });
});

http://busso-staging.eveneer.xyz/saml/assertion/
yeWRwc2O5tOO07z25CPwZcBe6X9Tuyacb7DQ8mlEnyumHW7gbWGDqKSdKlNKNOrL8hoC0MfBWpJMERGrnWbuLGIgWkxOfjNr2DDd3o6snVUV8Lggtwvdn7ZDun2bmh4KsY3V7t597W2STq5UdN9VCc8awQH7RbFGjtLaftuXRoWxXubaiDYWXiDMn83iB7X5yJcMk9J336CwmA0v6P1lVMM581i9HWGpp0sMW
?SAMLRequest=jVJZc6owGP0rTN5RiLJl1I5K6wZqFcX60gGMSoUEs7j01xf19k7vS%2Bc%2BZs72Tc5pPF3yTDlhxlNKmkCvaEDBJKGblOyaYBG8qDZ4ajV4lGcFakuxJzN8lJgLpdQRju5AE0hGEI14yhGJcsyRSNC87XsIVjRUMCpoQjOgtDnHTJRBXUq4zDGbY3ZKE7yYeU2wF6LgqFq9OYoyALPKHjN6kFFRVBKaV99vCFDcEktJJO733kSlJpacU5WLaFeeXcEnTHApv1w%2F727V6Du3esXh7JzAiSEmE836hEZ3el4nHWyunEBeoyS23Fc7z57JVeb90NrFYc89juabUTYejSfMs%2Fe0q%2FnbTlgM%2FedZj5Ewll5vsAsPl8n2Y8yg625q1ORkuVja3m4nzqcNsdauJDDO9%2FURf6stLWE4VgjnwdFYbMbOspvY0fm1b83il96H8KKtkKsZDS8rGUep%2BxauUtcndi3tWCvjOkz8gzOs1czuOW9rJ3OqZ0vfN2w9dfphryg07odAGbhN8B5rjh3rzkatbzVTrZsaVu0arqux6SRYs83EduollXOJB6T8OyKaAGpQU3WoQiPQDQRNBOEaKNM%2FDXZS8tjFb3XHDxJH%2FSCYqtPJPADK8ntfJQE81oTuwezHjH63%2FdshaP3fUhrVHzGtx%2BvfCbe%2BAA%3D%3D&RelayState=/