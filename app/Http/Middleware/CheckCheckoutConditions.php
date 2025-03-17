<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckCheckoutConditions
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
        if (Auth::check()) {
            $address = Auth::user()->address;
            $phone = Auth::user()->phone;
            $totalPrice = 0;
            if(session()->has('buynow')){
                $buynow = session('buynow');
                $totalPrice = $buynow['price'];
            }else {
                $cart = session('cart', []);
                foreach($cart as $product){
                    $totalPrice += $product['price'] * $product['quantity'];
                }
            }
            if ($address === null || $phone === null || $totalPrice <= 0) {
                return redirect()->back()->with('error', 'Để đặt hàng bạn cần cung cấp địa chỉ và số điện thoại và có giá trị đơn hàng tối thiểu!');
            }
        }
        return $next($request);
    }
}