@extends('layouts.app2')
@section('content')
<section class="log-in">
    <a href="{{ route('home') }}"><button type="button" class="nav-signup">Quay lại</button></a>
    <div class="login-form">
        <p>Đăng nhập tài khoản của bạn</p>
        <form method="POST" action="" class="form-group">
            @csrf
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Nhập email" style="margin-bottom: 20px;"
            required>
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            <a href="{{ route('reset-pass') }}">Quên mật khẩu ?</a>
            <button type="submit" class="login-btn">Đăng nhập</button>
            <p>nếu bạn chưa có tài khoản</p>
            <a href="signup"><button type="button" class="nav-signup">Đăng ký</button></a>
            <p>hoặc</p>
            <a href="{{ route('google-login') }}"><button type="button" class="gg-btn"><i class="fa-brands fa-google"></i> Google</button></a>
            <a href="{{ route('fb-login') }}"><button type="button" class="fb-btn"><i class="fa-brands fa-facebook"></i> Facebook</button></a>
        </form>
    </div>
</section>

@endsection