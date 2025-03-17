@extends('layouts.app')
@section('content')
    <div class="profile-page">
        <div class="profile-page-content" >
            <form method="POST" action="{{ route('update-user-profile', ['id' => Auth::user()->id]) }}" enctype="multipart/form-data" class="form-group">
                @csrf
                @if (Auth::User()->password == null)
                <p>Bạn chưa có mật khẩu ,<br> hãy tạo mới để cập nhật thông tin<br> tài khoản một cách dễ dàng</p>
                <label for="password" id="password-label">Mật khẩu:</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu mới" class="form-control" required>
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
                @else
                <h2>Thông tin người dùng</h2>
                <label for="name">Tên người dùng:</label>
                <input type="text" name="username" id="name" placeholder="Nhập tên người dùng" value="{{ Auth::User()->username }}" class="form-control">
        
                <label for="phone">Số điện thoại:</label>
                <input name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ Auth::User()->phone }}" class="form-control">
        
                <label for="email">Email:</label>
                <input id="email" value="{{ Auth::User()->email }}" class="form-control" disabled>
        
                <label for="address">Địa chỉ:</label>
                <input name="address" id="address" placeholder="Nhập địa chỉ" value="{{ Auth::User()->address }}" class="form-control" >

                <input type="hidden" name="level" id="level" value="{{ Auth::User()->u_level }}">
 
                <label for="password" id="password-label">Mật khẩu:</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" class="form-control" required>
                @endif
                <button type="submit" class="add-btn">Lưu</button>
                <a href="{{  route('logout') }}" class="del-btn">Đăng xuất</a>
            </form>
            <div class="order-list">
                <h2>Lịch sử đơn hàng</h2>
                @if ($orders->count() > 0)
                <table class="table">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tên người đặt</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đặt</th>
                        <th>Giá tiền</th>
                        <th>Chi tiết</th>
                        <th>Trạng thái</th>
                    </tr>
                    @foreach ($orders as $order)
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->user->username }}</td>
                    <td>{{ $order->user->phone }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ number_format($order->total,0,'.','.') }}₫</td>
                    <td><button class="udt-btn" id="udt-btn" onclick="openPopup({{ $order->id }})">Xem</button></td>
                    <td class="status">@switch($order->status)
                            @case(1)
                                <span id="pending">Đang chờ duyệt</span>
                                @break
                            @case(2)
                                <span id="in-progress">Đang giao hàng</span>
                                @break
                            @case(3)
                                <span id="delivered">Đã giao hàng</span>
                                @break
                            @case(4)
                                <span id="cancelled">Đã huỷ</span>
                                @break
                            @default
                                <span id="error">Lỗi</span>
                        @endswitch</td>
                    </tr>
                    @endforeach
                    </table>
                    @else
                        <p>Bạn chưa có đơn hàng nào.</p>
                    @endif
                <div class="pagination">
                    {{ $orders->render('layouts.reuse.paginateTem') }}
                </div>
            </div>
        </div>  

    </div>
    <div id="popup" style="display: none; width:600px">
        <table class="table" id="order-details-table">
                <thead>
                    <tr>
                        <th>Ảnh SP</th>
                        <th>Tên SP</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng tiền sản phẩm</th>
                    </tr>
                </thead>
                <tbody></tbody>
        </table>
        <button type="reset" onclick="closePopup()" class="del-btn">Thoát</button>
    </div>
    <div id="overlay" style="display: none"></div>
<script src="/jquery.js"></script>
<script>
    function openPopup(orderId){
        $("#popup").show();
        $("#overlay").show();
        getOrderDetail(orderId);
    }
    function getOrderDetail(orderId){
        $.ajax({
            type: 'GET',
            url: 'admin/getOrderDetail/' + orderId,
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
