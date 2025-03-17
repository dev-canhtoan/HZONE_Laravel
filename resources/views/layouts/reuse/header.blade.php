<header>
    <div class="header">
        <a href="{{ route('home') }}" id="link-home">
            <img src="{{ URL('image/logos/white-logo.png') }}" alt="img-logo" class="logo">
        </a>
        <div class="search-bar">
            <form action="{{ route('search') }}" method="post">
                @csrf
                <input type="text" name="search" id="searchInput" class="search-input" placeholder="Bạn cần tìm gì?">
                <button type="submit" class="btn-search">Tìm kiếm</button>
            </form>
            <div id="searchResults" aria-live="polite"></div>
        </div>
        <ul class="menu">
            <li><a href="{{ route('home') }}" class="menu-link"><i class="fa-solid fa-house"></i>Trang chủ</a></li>
            <li>
                @if (Auth::check() && auth()->user()->u_level == 1)
                    <a href="/profile" class="menu-link"><i class="fa-solid fa-user-check"></i>{{ Auth::user()->username }}</a>
                @elseif (Auth::check() && auth()->user()->u_level == 2)
                    <a href="{{ route('adminHome') }}" class="menu-link"><i class="fa-solid fa-user-gear"></i>Trang q.trị</a>
                @else
                    <a href="{{ route('login') }}" class="menu-link"><i class="fa-solid fa-user"></i>Đăng Nhập</a>
                @endif
            </li>
            <li><a href="{{ route('allProductsPage') }}" class="menu-link"><i class="fa-solid fa-mobile-screen-button"></i>Sản phẩm</a></li>
            <li>
                <a href="{{ route('cart') }}" class="menu-link">
                    <i class="fa-solid fa-cart-shopping" id="cartfix">
                        <span id="cart-count">{{ count(session('cart', [])) }}</span>
                    </i>Giỏ hàng
                </a>
            </li>
        </ul>
    </div>
    <script src="/jquery.js"></script>
    <script>
        $(document).ready(function() {
            const searchResults = $('#searchResults');
            const searchInput = $('#searchInput');

            $(document).on('click', function(event) {
                if (!searchResults.is(event.target) && searchResults.has(event.target).length === 0) {
                    searchResults.html('');
                }
            });

            searchInput.on('keyup', function() {
                const searchTerm = $(this).val();
                if (searchTerm.length === 0) {
                    searchResults.html('');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/search',
                    data: {
                        searchTerm: searchTerm,
                        _token: '{{ csrf_token() }}' // Gửi token CSRF
                    },
                    dataType: 'json',
                    success: function(response) {
                        const results = response.results;
                        let html = '';

                        if (results.length > 0) {
                            html += '<ul>';
                            results.forEach(result => {
                                html += `<li>
                                            <a href="/product-info-page/${result.id}">
                                                <img src="{{ URL('image/product-image/') }}/${result.img}" alt="" class="img-pdt">
                                                <p class="pro-name">${result.name}</p>
                                                <p class="pro-pri">${Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(result.price)}</p>
                                            </a>
                                        </li>`;
                            });
                            html += '</ul>';
                        } else {
                            html = `<p>Không tìm thấy kết quả.</p>`;
                        }

                        searchResults.html(html);
                    },
                    error: function() {
                        console.log('Có lỗi xảy ra.');
                    }
                });
            });
        });
    </script>
</header>
