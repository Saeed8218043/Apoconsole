<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/vendors/*',
        'http://console.autooutletllc.com/order_creating',
        // 'http://console.autooutletllc.com/vendors/trq_order'
    ];
}
