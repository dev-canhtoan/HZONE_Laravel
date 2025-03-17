<div class="admin-header">
    <i class="fa-solid fa-bars fa-2x" id="menu-toggle" aria-expanded="false"></i>
    <a href="home">
        <img src="{{ URL('image/logos/white-logo.png') }}" alt="img-logo" class="logo">
    </a>
    <div class="dropdown">
        <button class="drop-btn">{{ Auth::user()->username }} <span style="font-size: 10px">&#x25BC</span></button>
        <div class="dropdown-content">
            <a href="{{ route('home') }}">Trang người dùng</a>
            <a href="{{ route('logout') }}">Đăng xuất</a>
            <a href="{{ route('reset-pass') }}">Đổi mật khẩu</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.getElementById("menu-toggle");
        const menuLinks = document.querySelectorAll(".act-btn");
        const sndElements = document.querySelectorAll(".snd");

        // Khôi phục trạng thái của thẻ 'snd' từ localStorage sau khi trang được tải lại
        sndElements.forEach(function (element, index) {
            const savedState = localStorage.getItem(`sndState${index}`);
            if (savedState) {
                element.style.display = savedState;
            }
        });

        menuToggle.addEventListener("click", function () {
            sndElements.forEach(function (element) {
                element.style.display = (element.style.display === "block") ? "none" : "block";
            });
            // Cập nhật trạng thái aria-expanded
            const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";
            menuToggle.setAttribute("aria-expanded", !isExpanded);
        });

        menuLinks.forEach(function (link) {
            link.addEventListener("click", function () {
                // Lưu trạng thái của thẻ 'snd' vào localStorage khi nhấn liên kết
                sndElements.forEach(function (element, index) {
                    localStorage.setItem(`sndState${index}`, element.style.display);
                });
            });
        });
    });
</script>
