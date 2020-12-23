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
    // return view('auth.passwords.confirm', ['token' => 'some token']);
    // \Auth::login(App\Models\User::where('email', 'mobashirmonim@gmail.com')->first());
    // return view('test');
    dd('nothing in test');
})->name('tester');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::name('sso.')->group(function () {
    Route::name('saml.')->prefix('saml')->group(function () {
        Route::middleware(['sso.saml.verify'])->group(function () {
            Route::get('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
            Route::get('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
            Route::post('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
            Route::post('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
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
    Route::get('/resource-groups', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('resource-groups');
    Route::get('/roles', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('roles');
    Route::get('/scopes', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('scopes');
    Route::get('/user-attribute-values', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('user-attribute-values');
    Route::get('/user-attributes', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('user-attributes');
    Route::get('/users', [App\Http\Controllers\HomeController::class, 'needToImplement'])->name('users');
});