@extends('layouts.app2')
@section('content')
    <section class="sign-up">
        <div class="signup-form">
            <form method="POST" action="{{ route('signup') }}" class="form-group">
                @csrf
                <p>Đăng ký tài khoản của bạn</p>
                <label for="username">Tên đăng kí:</label>
                <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng kí" required>

                <label for="email">Email:</label>
                <input name="email" id="email" class="form-control" placeholder="Nhập email người dùng" required>
        
                <label for="phone">Số điện thoại:</label>
                <input name="phone" id="phone" class="form-control"  placeholder="Nhập số điện thoại">

                <label for="address">Địa chỉ:</label>
                <input name="address" id="address" class="form-control" placeholder="Nhập địa chỉ">

                <input type="hidden" name="level" id="level" value="1">

                <label for="password">Mật khẩu:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" required>
        
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
        
                <input type="submit" name="add_new" value="Đăng kí" class="login-btn">
                <p>nếu bạn đã có tài khoản</p>
                <a href="login" ><button type="button" class="nav-signup">Đăng nhập</button></a>
            </form>
        </div>
    </section>
@endsection