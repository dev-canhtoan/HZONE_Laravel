@extends('layouts.app2')
@section('content')
 <section class="log-in">
    <div class="login-form">
        <p>Nhập mã xác thực</p>
        <form method="POST" action="{{ route('verify-cfm') }}" class="form-group">
        @csrf
        <label for="token"></label>
        <input type="text" name="token" class="form-control" placeholder="Nhập mã xác thực tại đây" style="margin-bottom: 20px;" required>
        <div class="resend-module">
            <p id="resend">Gửi lại mã.</p>
            <p id="countdown"></p>
        </div>
        <button type="submit" class="verify-btn" style="">Xác thực</button>
    </form>
    </div>
 </section>
 <script src="/jquery.js"></script>
 <script>
    $(document).ready(function() {
        let countdownValue = 60;
        $("#resend").click(function() {
            $(this).off("click");
            let countdownInterval = setInterval(function() {
                countdownValue--;
                if (countdownValue >= 0) {
                    $("#countdown").text("Đợi " + countdownValue + " giây trước khi gửi lại");
                } else {
                    clearInterval(countdownInterval);
                    $("#countdown").text(""); 
                    $(this).on("click");
                }
            }, 1000);
            $.ajax({
                type: "POST",
                url: "{{ route('resend') }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    let successDiv = '<div class="alert-success" id="alert-success">' + response.message + '</div>';
                    $('body').append(successDiv);
                },
            });
        });
    });
 </script>
@endsection