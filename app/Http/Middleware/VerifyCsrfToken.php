<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
		'https://app.moota.co',
		'moota/*',
		"https://app.moota.co/*",
		'http://45.77.253.188/moota/*',
		'http://45.77.253.188/moota/callback/*',
		'http://45.77.253.188/woowa/*',
		'http://45.77.253.188/wablas/*',
    ];

	
}
