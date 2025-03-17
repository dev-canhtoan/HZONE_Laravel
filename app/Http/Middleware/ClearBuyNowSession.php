<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearBuyNowSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedRoutes = [
            'checkout',
            'checkout-confirm',
            'vnpay',
            'momo',
            'zalo',
        ];
        $currentRoute = $request->route()->getName();

        if ($currentRoute === 'home') {
            if (strpos(request()->fullUrl(), '?') !== false) {
                array_push($allowedRoutes, 'home');
            }
        }

        if (!in_array($currentRoute, $allowedRoutes)) {
            $request->session()->forget('buynow');
        }

        return $next($request);
    }
}