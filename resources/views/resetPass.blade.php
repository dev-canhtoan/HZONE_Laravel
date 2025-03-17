@extends('layouts.app2')
@section('content')
<section class="log-in">
    <div class="login-form">
        <p>Reset mật khẩu</p>
        <form method="POST" action="{{ route('reset-cfm') }}" class="form-group">
            @csrf

            <label for="email">Email người dùng:</label>
            <input type="text" name="email" class="form-control" placeholder="Nhập email"
                value="{{ Auth::check() ? Auth::user()->email : ''}}" required>

            <label for="password">Mật khẩu mới:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" required>

            <label for="confirm_password">Xác nhận mật khẩu mới:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                placeholder="Xác nhận mật khẩu" required>
            <button type="submit" class="verify-btn" style="">Xác nhận reset mật khẩu</button>
        </form>
    </div>
</section>

@endsection