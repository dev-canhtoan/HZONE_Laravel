<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/add-to-cart',
        '/update-product-quantity',
        '/remove-product',
        'admin/order/update-order-status/*',
        '/search',
        '/buy-now',
        '/cancel-buynow'
    ];
}