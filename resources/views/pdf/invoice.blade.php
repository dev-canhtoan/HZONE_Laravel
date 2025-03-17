<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1 style="text-align:center;padding-bottom: 10px;border-bottom: 2px dashed black;">Hoá đơn đặt hàng</h1>
    <h4>Danh sách sản phẩm:</h4>
    <table class="table">
        <tr>
            <th style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">Tên sản phẩm </th>
            <th style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">Số lượng</th>
            <th style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">Đơn giá</th>
            <th style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">Tổng giá sản phẩm</th>
        </tr>
        @foreach ($orderDetails as $orderDetail)
        <tr>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{$orderDetail->product->name }}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{$orderDetail->quantity}}</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{number_format($orderDetail->product->price,0, '.', ',')}} VND</td>
            <td style="border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;">{{number_format($orderDetail->total_pro, 0, '.',',')}} VND</td>
        </tr>
        @endforeach
    </table>
    <p>Mã đơn hàng: {{ $order->order_code }}</p>
    <p>Tên người đặt: {{ $order->user->username }}</p>
    <p>Số điện thoại đặt hàng: {{ $order->user->phone }}</p>
    <p>Địa chỉ nhận hàng: {{ $order->user->address }}</p>
    <p>Ngày đặt: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
    <h4>Phí vận chuyển: Freeship</h4>
    <h4 style="padding-top: 10px;border-top: 2px dashed black;">Tổng cộng: {{ number_format($order->total, 0, '.', ',') }} VND</h4>
</body>
</html>