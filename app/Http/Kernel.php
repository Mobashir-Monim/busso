<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // 'auth:api',
            // \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'hasSystemRole' => \App\Http\Middleware\HasSystemRole::class,
        'sso.saml.login-verify' => \App\Http\Middleware\SSOMiddlewares\SAML\AuthnVerifier::class,
        'sso.saml.logout-verify' => \App\Http\Middleware\SSOMiddlewares\SAML\LogoutVerifier::class,
        'sso.oauth.access-token' => \App\Http\Middleware\SSOMiddlewares\Oauth\AccessTokenChecker::class,
        'sso.oauth.auth-code' => \App\Http\Middleware\SSOMiddlewares\Oauth\AuthCodeChecker::class,
        'sso.oauth.auth-grant' => \App\Http\Middleware\SSOMiddlewares\Oauth\AuthGrantChecker::class,
        'sso.oauth.client' => \App\Http\Middleware\SSOMiddlewares\Oauth\ClientChecker::class,
        'sso.oauth.client-cred' => \App\Http\Middleware\SSOMiddlewares\Oauth\ClientCredentialChecker::class,
        'sso.oauth.param' => \App\Http\Middleware\SSOMiddlewares\Oauth\ParamChecker::class,
        'sso.oauth.redirect' => \App\Http\Middleware\SSOMiddlewares\Oauth\RedirectChecker::class,
        'sso.oauth.session' => \App\Http\Middleware\SSOMiddlewares\Oauth\SessionChecker::class,
        'sso.credential-checher' => \App\Http\Middleware\SSOMiddlewares\CredentialChecker::class,
        'password-reset.enforced' => \App\Http\Middleware\PasswordReset\ForceReset::class,
        'password-reset.validity' => \App\Http\Middleware\PasswordReset\CheckLastUpdate::class,
        'roles.has-system-role' => \App\Http\Middleware\RoleMiddlewares\HasSystemRole::class,
    ];
}
