<h2>Đơn hàng của bạn</h2>
<h4>Danh sách sản phẩm:</h4>
<table class="table">
    <tr>
        <th style="border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;">Tên sản phẩm</th>
        <th style="border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;">Số lượng</th>
        <th style="border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;">Đơn giá</th>
    </tr>
    @if (session()->has('buynow'))
        @php
            $cart = session()->get('buynow');
        @endphp
        <tr>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ $cart['name'] }}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ $cart['quantity'] }}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ number_format($cart['price'], 0, '.', '.') }}₫</td>
        </tr>
    @else
        @foreach($cart as $product)
        <tr>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ $product['name'] }}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ $product['quantity'] }}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{ number_format($product['price'], 0, '.', '.') }}₫</td>
        </tr>
        @endforeach
    @endif 
</table>
<h4>Tạm tính: {{ number_format($total, 0, '.', '.') }}₫</h4>
<h4>Phí vận chuyển: Freeship</h4>
<p>Địa chỉ giao hàng: {{ $address }}<br>Số điện thoại:{{ $phone }}<br>Người nhận: {{ $username }} </p>
<h3>Tổng cộng: {{ number_format($total, 0, '.', '.') }}₫</h3>