<footer>
    <div class="footer">
        <div class="logo-clm">
            <img src="{{ URL('image/logos/white-logo.png') }}" alt="img-logo" class="logo">
            <p>H-zone là một cửa hàng chuyên về thiết bị điện tử, đặc biệt là các sản phẩm công nghệ hàng đầu như điện thoại di động, máy tính bảng, laptop, máy tính cá nhân (PC), và đồng hồ thông minh (smart watch). Chúng tôi tự hào cung cấp một loạt các sản phẩm điện tử với chất lượng tốt nhất và sự đa dạng trong các thương hiệu và mẫu mã.</p>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2632.896260156399!2d105.76365029639227!3d21.05357863870112!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454e7f0fbbcc3%3A0xbf968b3371c0cf6!2zQ2jhu6MgUGjDuiBEaeG7hW4!5e0!3m2!1svi!2s!4v1698760280144!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <div class="payment-clm">
            <span style="font-weight: bold;">Phương thức thanh toán</span>
            <div class="payment-layout">
                @foreach (File::files(public_path('image/payment-logos/')) as $image)
                    <img src="{{ asset('image/payment-logos/' . basename($image)) }}" alt="" class="payment-logo">
                @endforeach
            </div>
            <div>
                <form action="{{ route('feedback') }}" method="post">
                @csrf
                <input type="text" name="feedback" class="form-control" placeholder="Gửi phản hồi đến chúng tôi" required>
                <button type="submit" class="my-btn1" >Gửi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="copy-right">
        <div class="copy-right-content">
            <p>Copyright &#169; 2023 by Công ty TNHH Chỉ Mình Tôi.</p>
            <p>Trụ sở chính: Phú Diễn, Bắc Từ Liêm, Hà Nội</p>
        </div>
    </div>
</footer>