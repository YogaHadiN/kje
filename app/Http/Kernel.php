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
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        /* \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, */
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
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
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
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
        'notready' => \App\Http\Middleware\NotReady::class,
        'normalisasi' => \App\Http\Middleware\normalisasi::class,
        'selesai' => \App\Http\Middleware\SudahSelesai::class,
        'selesaiPeriksa' => \App\Http\Middleware\SudahSelesaiPeriksa::class,
        'super' => \App\Http\Middleware\SuperAdminOnly::class,
        'filterBpjs' => \App\Http\Middleware\FilterBpjsDiNurseStation::class,
        'allowifnotcash' => \App\Http\Middleware\AllowIfNotCash::class,
        'admin' => \App\Http\Middleware\adminOnly::class,
        'keuangan' => \App\Http\Middleware\KeuanganAccessOnly::class,
        'protect' => \App\Http\Middleware\protectKaloSudahDikirim::class,
        'belum_masuk_kasir' => \App\Http\Middleware\BelumMasukKasir::class,
        'harusUrut' => \App\Http\Middleware\harusUrutDiPoliUmum::class,
        'backIfNotFound' => \App\Http\Middleware\backIfNotFound::class,
        'nomorAntrianUnik' => \App\Http\Middleware\nomorAntrianUnik::class,
        'inhealthTidakBisaDirujukKalauAdaObat' => \App\Http\Middleware\inhealthTidakBisaDirujukKalauAdaObat::class,
        'prolanisFlagging' => \App\Http\Middleware\CekDanMasukkanProlanis::class,
        'redirectBackIfIdAntrianNotFound' => \App\Http\Middleware\redirectBackIfIdAntrianNotFound::class,
    ];
}
