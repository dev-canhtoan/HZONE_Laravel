@extends('layouts.app')
@section('content')
<section class="home-page">
    <div class="home-page-content">
        <div class="first-content-board">
            <div class="category">
                @foreach ($categories as $category)
                <a class="cate-nav" href="{{ route('allProductsPage', ['selectedCategory' => [$category->id]]) }}">{{ $category->name }}</a>
                @endforeach
            </div>
            <button class="swp" id="prevButton"><</button>
            <div class="carousel-container">
                <div class="carousel-slider">
                    @foreach (File::files(public_path('image/poster')) as $image)
                    <div class="carousel-item">
                        <img src="{{ asset('image/poster/' . basename($image)) }}" alt="" class="poster">
                    </div>
                    @endforeach
                </div>
            </div>
            <button class="swp" id="nextButton">></button>
            <div class="user-sign">
                @if (Auth::check())
                <h1>Xin chào, <br> hãy bắt đầu nào!</h1>
                <h1>{{ Auth::user()->username; }}</h1>
                <a href="{{ route('logout') }}"><button class="del-btn">Đăng xuất</button></a>
                @else
                <h1>Hãy tham gia <br> với chúng tôi!</h1>
                <a href="signup"><button class="nav-sign-up-btn" style="width:100%;">Tham gia ngay</button></a>
                <a href="login"><button class="nav-log-in-btn" style="width:100%;">Đăng nhập</button></a>
                @endif
            </div>
        </div>
        <div class="sales-product-content-board">
            <div class="sales-countdown">
                <h1>Giảm giá hôm nay</h1>
                <div class="countdown">
                    <ul>
                        <li><span id="days"></span>Ngày</li>
                        <li><span id="hours"></span>Giờ</li>
                        <li><span id="minutes"></span>Phút</li>
                        <li><span id="seconds"></span>Giây</li>
                    </ul>
                </div>
            </div>
            @php
                $discountedProducts = $products->filter(function($product) {
                    return $product->discount && 
                        $product->discount->start_at <= now() && 
                        $product->discount->end_at >= now()->endOfDay();
                });
            @endphp

            <div class="sale-lists">
                @if ($discountedProducts->count() >= 5)
                    @foreach ($discountedProducts->random(5) as $product)
                    <a href="{{ route('product-info-page', ['id' => $product->id]) }}">
                        <div class="sale-list">
                            <img src="{{ URL('image/product-image/' . $product->img) }}" alt="" class="img-product">
                            <p class="product-name">{{$product->name}}</p>
                            <div class="sale-percent">{{ $product->discount->percent }}%</div>
                        </div>
                    </a>
                    @endforeach
                @else
                    @foreach ($discountedProducts as $product)
                    <a href="{{ route('product-info-page', ['id' => $product->id]) }}">
                        <div class="sale-list">
                            <img src="{{ URL('image/product-image/' . $product->img) }}" alt="" class="img-product">
                            <p class="product-name">{{$product->name}}</p>
                            <div class="sale-percent">{{ $product->discount->percent }}%</div>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="all-category-list-content-board">
            <div class="all-category-title">
                <h1>Tất cả danh mục</h1>
                <button class="view-all-product-btn"><a href="{{ route('allProductsPage') }}">Xem tất cả</a></button>
            </div>
            <div class="category-grid">
                @foreach ($proByCategories as $proByCategory)
                <div class="category-card">
                    <a href="{{ route('allProductsPage', ['selectedCategory' => [$proByCategory->category->id], 'sort' => 'asc']) }}">
                        <div class="info-cate">
                            <p id="p1">{{$proByCategory->category->name}}</p>
                            @if ($proByCategory->discount && $proByCategory->discount->start_at <= now() &&$proByCategory->discount->end_at >= now())
                            <p id="p2">chỉ từ {{ number_format($proByCategory->price-($proByCategory->price * $proByCategory->discount->percent/ 100), 0, '.', '.') }}₫</p>
                            @else
                            <p id="p2">chỉ từ {{ number_format($proByCategory->price, 0, '.', '.') }}₫</p>
                            @endif
                        </div>
                        <img src="{{ URL('image/product-image/' . $proByCategory->img) }}" alt="" class="img-cate">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="rcm-items-content-board">
            <h1>Sản phẩm đề xuất</h1>
            <div class="home-product-grid">
                @foreach ($products->random(8) as $product)
                @include('layouts.reuse.productCard')
                @endforeach
            </div>
        </div>
    </div>
</section>
<script>
    if (window.location.search) {
        const baseUrl = window.location.href.split('?')[0];
        window.history.replaceState({}, document.title, baseUrl);
    }
    const slider = document.querySelector('.carousel-slider');
    const items = document.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    let currentIndex = 0;
    const itemWidth = items[0].clientWidth;

    function slideTo(index) {
        currentIndex = index;
        const translateX = -currentIndex * itemWidth;
        slider.style.transform = `translateX(${translateX}px)`;
    }

    function nextSlide() {
        if (currentIndex < totalItems - 1) {
            slideTo(currentIndex + 1);
        } else {
            slideTo(0);
        }
    }

    setInterval(nextSlide, 5000);
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            slideTo(currentIndex - 1);
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < totalItems - 1) {
            slideTo(currentIndex + 1);
        } else {
            slideTo(0);
        }
    });

</script>
@endsection