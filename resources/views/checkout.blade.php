@extends('layouts.app')
@section('content')
<section class="checkout-page">
    <div class="checkout-page-content">
        <h2>Đơn hàng của bạn</h2>
        @php
        $cart = session('cart', []);
        $buynow = session('buynow');
        $totalPrice = 0;
        @endphp
        <h4>Danh sách sản phẩm:</h4>
        <table class="table">
            <tr>
                <th>Tên sản phẩm </th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
            </tr>
            @if (session()->has('buynow'))
                @php
                    $totalPrice = $buynow['price'];
                @endphp
                <tr>
                <td>{{ $buynow['name'] }}</td>
                <td>{{ $buynow['quantity'] }}</td>
                <td>{{ number_format($buynow['price'], 0, '.', '.') }}₫</td>
                </tr>
            @else
                @foreach($cart as $product)
                @php
                $totalPrice += $product['price'] * $product['quantity'];
                @endphp
                <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>{{ number_format($product['price'], 0, '.', '.') }}₫</td>
                </tr>
                @endforeach
            @endif
            
        </table>
        <h4>Tạm tính: {{ number_format($totalPrice, 0, '.', '.') }}₫</h4>
        <h4>Phí vận chuyển: Freeship</h4>
        <p>Địa chỉ giao hàng: {{ Auth::user()->address }}<br>Số điện thoại: {{ Auth::user()->phone }}<br>Người nhận: {{ Auth::user()->username }}</p>
        <h3>Tổng cộng: {{ number_format($totalPrice, 0, '.', '.') }}₫</h3>
        
        <form method="post" action="{{ route('checkout-confirm') }}">
            @csrf
            <input type="hidden" name="total" value="{{ $totalPrice }}">
            <button type="submit">Đặt hàng</button>
        </form>
    </div>
</section>
@endsection