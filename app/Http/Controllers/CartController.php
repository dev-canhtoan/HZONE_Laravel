<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        $products = Product::where('quantity', '>', 0)->inRandomOrder()->take(4)->get();
        foreach ($products as $product) {
            $product->rates->avg_stars = $product->rates->avg('star');
        }
        return view('cart', compact('products'));
    }
    public function addToCart(Request $request)
    {
        $product = $request->input('product');
        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }
        $cart = $request->session()->get('cart');
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['id'] == $product['id']) {
                $cart[$key]['quantity'] += $product['quantity'];
                $found = true;
                break;
            }
        }
        if (!$found) {
            $cart[] = $product;
        }
        $request->session()->put('cart', $cart);
        $cartCount = count(session('cart', []));
        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng.', 'cartCount' => $cartCount]);
    }
    public function buyNow(Request $request){
        $product = $request->input('buynow');
        if ($request->session()->has('buynow')) {
            $oldProduct = $request->session()->get('buynow');
            $request->session()->forget('buynow');
        }
        $request->session()->put('buynow', $product);
        return response()->json(['success' => true]);
    }
    public function cancelBuynow(Request $request){
        $request->session()->forget('buynow');
        return response()->json(['success' => true]);
    }
    
    public function updateProductQuantity(Request $request){
        $product = $request->input('product');
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            foreach ($cart as $key => $item) {
                if ($item['id'] == $product['id']) {
                    $cart[$key]['quantity'] = $product['quantity'];
                    break;
                }
            }
            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            $request->session()->put('cart', $cart);
        }
        return response()->json(['message' => 'Số lượng sản phẩm đã được cập nhật thành công.', 'totalPrice' => number_format($totalPrice, 0, '.', '.')]);
    }
    public function removeProduct(Request $request){
        $product = $request->input('product');
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            //array_filter sẽ trả về một mảng mới chỉ chứa các sản phẩm muốn giữ lại trong giỏ hàng, và sản phẩm muốn xoá sẽ bị loại bỏ khỏi mảng.
            $cart = array_filter($cart, function ($item) use ($product) {
                return $item['id'] != $product['id'];
            });
            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
            $request->session()->put('cart', $cart);
        }
        return response()->json(['message' => 'Sản phẩm đã được xoá thành công.', 'totalPrice' => number_format($totalPrice, 0, '.', '.')]);
    }
    
}