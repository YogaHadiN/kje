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
		'https://api.github.com/*',
		'moota/*',
		"https://app.moota.co/*",
		'http://3.1.25.111/moota/*',
		'http://3.1.25.111/moota/callback/*',
		'http://3.1.25.111/woowa/*',
		'http://3.1.25.111/wablas/*',
    ];

	
}
