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
    $dn = array(
        "countryName" => "GB",
        "stateOrProvinceName" => "Somerset",
        "localityName" => "Glastonbury",
        "organizationName" => "The Brain Room Limited",
        "organizationalUnitName" => "PHP Documentation Team",
        "commonName" => "Wez Furlong",
        "emailAddress" => "wez@example.com"
    );
    
    // Generate a new private (and public) key pair
    $privkey = openssl_pkey_new(array(
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ));
    
    // Generate a certificate signing request
    $csr = openssl_csr_new($dn, $privkey, array('digest_alg' => 'sha256'));
    
    // Generate a self-signed cert, valid for 365 days
    $x509 = openssl_csr_sign($csr, null, $privkey, $days=365, array('digest_alg' => 'sha256'));
    
    // Save your private key, CSR and self-signed cert for later use
    openssl_csr_export($csr, $csrout) and var_dump($csrout);
    openssl_x509_export($x509, $certout) and var_dump($certout);
    openssl_pkey_export($privkey, $pkeyout, "mypassword") and var_dump($pkeyout);
    dd(Laravel\Passport\Passport::client()->all());
    dd('nothing in test');
})->name('tester');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
