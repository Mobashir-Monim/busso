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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/saml');

Route::name('sso.')->group(function () {
    Route::name('saml.')->prefix('saml')->group(function () {
        Route::get('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
        Route::get('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
        Route::post('/assertion/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'login'])->name('login');
        Route::post('/logout/{entity}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'logout'])->name('logout');
        Route::get('/metadata/{entity}/{type}', [App\Http\Controllers\SSOControllers\SAMLController::class, 'metaDoc'])->name('metadoc');
    });
});
