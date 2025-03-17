@extends('layouts.app3')
@section('content')
<section class="admin-page">
    <div class="title">
        <h2>Đơn hàng</h2>
        <div class="search-bar">
            <form action="{{ route('order-search') }}" method="post">
                @csrf
                <input type="text" name="search" id="searchInput" class="search-input" placeholder="Tìm đơn hàng theo mã hoặc tên người đặt">
                <button type="submit" class="my-btn1">Tìm kiếm</button>
            </form>
        </div>
    </div>
    @if ($orders->isEmpty())
        <h2>Không có đơn hàng nào.</h2>
    @else
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Ngày đặt</th>
            <th>Giá tiền</th>
            <th>Chi tiết</th>
            <th>Trạng thái</th>
            <th>In hoá đơn</th>
            <th>Xoá</th>
        </tr>
        @foreach ($orders as $order)
        <td>{{ $order->id }}</td>
        <td>{{ $order->order_code }}</td>
        <td>{{ $order->user->username }}</td>
        <td>{{ $order->user->phone }}</td>
        <td>{{ $order->created_at }}</td>
        <td>{{ number_format($order->total,0,'.','.') }}₫</td>
        <td><button class="udt-btn" id="udt-btn" onclick="openPopup({{ $order->id }})">Xem</button></td>
        <td id="status">
            <select name="status" class="status-select" onchange="updateStatus(this, {{ $order->id }})">
                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang chờ duyệt</option>
                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang giao hàng</option>
                <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đã giao hàng</option>
                <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đã huỷ</option>
            </select>
        </td>
        <td>@if ($order->status !== 4)
            <a href="{{ route('export-pdf', ['id' => $order->id]) }}" ><button class="print">In hoá đơn</button></a>
        @endif</td>
        <td>
            <form method="POST" action="{{ route('delete-order', $order->id) }}" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-btn">Xoá</button>
            </form>
        </td>
        </tr>
        @endforeach
    </table>
    @endif
    <div class="pagination">
        {{ $orders->render('layouts.reuse.paginateTem') }}
    </div>
    <div id="popup" style="display: none; width:600px">
        <table class="table" id="order-details-table">
                <thead>
                    <tr>
                        <th>Ảnh SP</th>
                        <th>Tên SP</th>
                        <th>Số lượng</th>
                        <th>Đơn giá/1sp</th>
                        <th>Tổng tiền sản phẩm</th>
                    </tr>
                </thead>
                <tbody></tbody>
        </table>
        <button type="reset" onclick="closePopup()" class="del-btn">Thoát</button>
    </div>
    <div id="overlay" style="display: none"></div>
</section>
<script src="/jquery.js"></script>
<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xoá đơn hàng này?');
    }
    //đổi màu status
    const selectElements = document.querySelectorAll('.status-select');
        selectElements.forEach(function(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const color = window.getComputedStyle(selectedOption, null).getPropertyValue('color');
        selectElement.style.color = color;
        });

    function updateStatus(selectElement, orderId) {
        const newStatus = selectElement.value;
        
        //đổi màu status onchange
        const selectElements = document.querySelectorAll('.status-select');
        selectElements.forEach(function(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const color = window.getComputedStyle(selectedOption, null).getPropertyValue('color');
            selectElement.style.color = color;
        });

        $.ajax({
            type: 'PUT',
            url: 'order/update-order-status/' + orderId,
            data: { status: newStatus },
            success: function (response) {
                console.log(response.message);
            },
            error: function (error) {
                console.log('Có lỗi xảy ra.');
            }
        });
    }
    function openPopup(orderId){
        $("#popup").show();
        $("#overlay").show();
        getOrderDetail(orderId);
    }
    function getOrderDetail(orderId){
        $.ajax({
            type: 'GET',
            url: 'getOrderDetail/' + orderId,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#order-details-table tbody').empty();
                $.each(response, function (index, product) {
                    const formattedPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.product.price);
                    const formattedPrice2 = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.total_pro);
                $('#order-details-table').append(
                    '<tr>' +
                    '<td><img src="{{ URL("image/product-image/") }}/' + product.product.img + '" style="height: 50px;"></td>' +
                    '<td>' + product.product.name + '</td>' +
                    '<td>' + product.quantity + '</td>' +
                    '<td>' + formattedPrice + '</td>' +
                    '<td>' + formattedPrice2 + '</td>' +
                    '</tr>'
                );
            });
            },
            error: function (error) {
                console.log('Có lỗi xảy ra.');
            }
        });
    }
</script>
@endsection