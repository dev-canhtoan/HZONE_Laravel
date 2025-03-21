<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class VerifyCheck
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
        if (session()->has('verify_token') || session()->has('reset_token')) {
            return $next($request);
        }
        return redirect('/');
    }
}