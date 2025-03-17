@extends('layouts.app')
@section('content')
<section class="pro-info-page">
    <div class="pro-info-page-content">
        <div class="fisrt-pro-info">
            <div class="fst-clm">
                <img src="{{ URL('image/product-image/' . $productInfo->img) }}" alt="" class="img-pdt">
                @if ($productInfo->quantity === 0)
                <img src="{{ asset('image/other-img/hethang.png') }}" alt="sold out" class="sold-out">
                @endif
            </div>
            <div class="scd-clm">
                <div class="pro-name">
                    <h2>{{$productInfo->name}}</h2>
                </div>
                <div class="mini-info">
                    <div class="rate">
                        @php
                        if (count($reviews)>0) {
                            $avgstar = $reviews->avg('star');
                        } 
                        else {
                            $avgstar = 0;
                        }
                        @endphp
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $avgstar)
                                <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                            @else
                                <i class="fa-solid fa-star" style="color: #ddd;"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="cmt">
                        <i class="fa-solid fa-comment-dots"></i> {{ count($reviews)}} đánh giá 
                    </div>
                    <div class="sold">
                        <i class="fa-solid fa-basket-shopping"></i>
                        @if ( $totalQuantitySold->total_sold > 0)
                            {{ $totalQuantitySold->total_sold }}
                        @else
                            0
                        @endif đã bán
                    </div>
                </div>
                <div class="pro-price">
                    <div class="pro-prices">
                        <div class="price">
                            @if ($productInfo->discount && $productInfo->discount->start_at <= now() && $productInfo->discount->end_at >= now())
                            <i class="fa-solid fa-tag fa-3x" id="dis-tag"><p>{{ $productInfo->discount->percent }}%</p></i>
                            <p style="font-weight:bold">{{ number_format($productInfo->price-($productInfo->price * $productInfo->discount->percent/ 100), 0, '.', '.') }}₫</p>
                            <p style="text-decoration: line-through; font-size:12px">{{ number_format($productInfo->price, 0, '.', '.') }}₫</p>
                            @else
                                <p style="font-weight:bold">{{ number_format($productInfo->price, 0, '.', '.') }}₫</p>
                            @endif
                            <p style="color: #00B517; font-size: 12px">Phờ ri síp</p>
                        </div>
                    </div>
                    @if ($productInfo->discount && $productInfo->discount->start_at <= now() && $productInfo->discount->end_at >= now())
                    <div class="countdown">
                        <ul>
                            <li><span id="daysinfo"></span>Ngày</li>
                            <li><span id="hoursinfo"></span>Giờ</li>
                            <li><span id="minutesinfo"></span>Phút</li>
                            <li><span id="secondsinfo"></span>Giây</li>
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="rv-info">
                    <h4>Thông tin sản phẩm</h4>
                    <li><i class="fa-solid fa-mobile-screen-button"></i> Máy mới 100% , chính hãng.</li>
                    <li><i class="fa-solid fa-box-open"></i> Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning - Type C
                    </li>
                    <li><i class="fa-solid fa-hospital-user"></i> 1 ĐỔI 1 trong 30 ngày nếu có lỗi phần cứng nhà sản
                        xuất. Bảo hành 12 tháng tại trung tâm bảo hành chính hãng</li>
                    <li><i class="fa-solid fa-money-check-dollar"></i> Giá sản phẩm đã bao gồm VAT</li>
                </div>
            </div>
            <div class="thrd-clm">
                <div class="buy-form">    
                    @if (Auth::check())
                        @if ($productInfo->quantity > 0)
                        <button class="buy-btn" id="buy-now" 
                        data-product-id="{{ $productInfo->id }}"
                        data-product-name="{{ $productInfo->name }}" 
                        data-product-price="{{ $productInfo->discount && $productInfo->discount->start_at <= now() && $productInfo->discount->end_at >= now() ?
                            $productInfo->price-($productInfo->price * $productInfo->discount->percent/ 100) : $productInfo->price }}"
                        data-product-quantity=1>
                        <i class="fa-solid fa-credit-card"></i> Mua ngay
                        </button>
                        <div id="popup" style="display: none">
                            <a href="{{ route('checkout') }}"><button class="payment-btn">Thanh toán</button></a>
                            <form action="{{ route('vnpay')}}" method="post">
                                @csrf
                                <button type="submit" class="vnpay"><i class="fa-solid fa-credit-card"></i> Thanh toán với Vnpay</button>
                            </form>
                            <form action="{{ route('momo')}}" method="post">
                                @csrf
                                <button type="submit" class="momo"><i class="fa-solid fa-money-check-dollar"></i></i> Thanh toán với Momo</button>
                            </form>
                            <form action="{{ route('zalo')}}" method="post">
                                @csrf
                                <button type="submit" class="zalo"><i class="fa-solid fa-wallet"></i></i> Thanh toán với Zalopay</button>
                            </form>
                            <button type="reset" class="del-btn" id="cancel-buynow">Hủy</button>
                        </div>
                        <div id="overlay" style="display: none"></div> 
                        <button class="add-btn" id="add-to-cart-button" 
                        data-product-id="{{ $productInfo->id }}"
                        data-product-name="{{ $productInfo->name }}" data-product-price="{{ $productInfo->discount && $productInfo->discount->start_at <= now() && $productInfo->discount->end_at >= now() ?
                            $productInfo->price-($productInfo->price * $productInfo->discount->percent/ 100) : $productInfo->price }}"
                        data-product-brand="{{ $productInfo->spec->brand }}"
                        data-product-screen="{{ $productInfo->spec->screen }}"
                        data-product-storage="{{ $productInfo->spec->storage }}"
                        data-product-img="{{ $productInfo->img }}"
                        data-product-quantity-limit="{{ $productInfo->quantity }}"
                        data-product-quantity=1>
                        <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng</button>
                        @else
                        <button class="buy-btn"><i class="fa-solid fa-credit-card"></i> Hết hàng</button>
                        <button class="add-btn"><i class="fa-solid fa-cart-shopping"></i> Hết hàng</button>    
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="buy-btn" id="fix"><i class="fa-solid fa-credit-card"></i> Mua ngay</a>
                        <a href="{{ route('login') }}" class="add-btn" id="fix"><i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="description">
            <h4>Mô tả sản phẩm</h4>
            <p>{{$productInfo->des}}</p>
            @php
                $fields = [
                    'brand' => 'Hãng sản xuất',
                    'screen' => 'Màn hình',
                    'storage' => 'Dung lượng',
                    'ram' => 'Ram',
                    'chip' => 'Chipset',
                    'pin' => 'Pin',
                    'camera' => 'Camera',
                    'vga' => 'Vga',
                    'os' => 'Hệ điều hành'
                ];
            @endphp
            <table class="info-pro-table">
                @foreach ($fields as $field => $label)
                    @if (!is_null($productInfo->spec) && !is_null($productInfo->spec->$field))
                        <tr>
                            <td>{{ $label }}:</td>
                            <td>{{ $productInfo->spec->$field }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
        <div class="pro-rate">
            <h4>Đánh giá & nhận xét {{$productInfo->name}}</h4>
            <form action="{{ route('rate') }}" method="post">
                @csrf
                <div id="rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label class = "full" for="star5" title="5 stars"></label>
                 
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label class = "full" for="star4" title="4 stars"></label>
                 
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label class = "full" for="star3" title="3 stars"></label>
                 
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label class = "full" for="star2" title="2 stars"></label>
                 
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label class = "full" for="star1" title="1 star"></label>
                </div>
                <div id="comment">
                    <input type="text" class="text-field" name="comment" placeholder="Nhập nhận xét">
                </div>
                <input type="hidden" value="{{ $productInfo->id }}" name="product-id">
                <button type="submit" class="my-btn1">Đánh giá</button>
            </form>
            @livewire('review-filter', ['productId' => $productInfo->id]) 
        </div>
        
       <div >
        <h2>Sản phẩm liên quan</h2>
        <div class="relate-product-grid">
            @foreach ($products as $product)
            @include('layouts.reuse.productCard')
            @endforeach
        </div>
       </div>
    </div>
</section>
<script src="/jquery.js"></script>
@if ($productInfo->discount && $productInfo->discount->start_at <= now() && $productInfo->discount->end_at >= now())
<script>
  const endAt = new Date("{{ $productInfo->discount->end_at }}");
    (function () {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;
  const now = new Date();
  const targetDate = new Date(endAt.getFullYear(), endAt.getMonth(), endAt.getDate(), 23, 59, 59); 
  const x = setInterval(function() {    
    const now = new Date().getTime(),
    distance = targetDate - now;
    if (distance <= 0) {
      targetDate.setDate(now.getDate() + 1);
      targetDate.setHours(23, 59, 59);
    }
    const newDistance = targetDate - now;
    document.getElementById("daysinfo").innerText = Math.floor(newDistance / (day)),
    document.getElementById("hoursinfo").innerText = Math.floor((newDistance % (day)) / (hour)),
    document.getElementById("minutesinfo").innerText = Math.floor((newDistance % (hour)) / (minute)),
    document.getElementById("secondsinfo").innerText = Math.floor((newDistance % (minute)) / second);
  }, 1000);
  })();
</script>
@endif
<script>
    function openPopup(){
        $("#popup").show();
        $("#overlay").show();
    }
    $(document).ready(function() {
    $('#buy-now').click(function(){
        let buynow = {
            id: $(this).data('product-id'),
            name: $(this).data('product-name'),
            price: $(this).data('product-price'),
            quantity : $(this).data('product-quantity') || 1
        } 
        $.ajax({
            url: '/buy-now',
            method: 'POST',
            data: { buynow: buynow },
            success: function(response){
                console.log(response.success);
            }
        });
        openPopup()
    });    
    $('#cancel-buynow').click(function(){
        $.ajax({
            url: '/cancel-buynow',
            method: 'POST',
            data: {},
            success: function(response){
                console.log(response.success);
            }
        });
        closePopup();
    });   
    $('#add-to-cart-button').click(function() {
        let product = {
            id: $(this).data('product-id'),
            name: $(this).data('product-name'),
            price: $(this).data('product-price'),
            image: $(this).data('product-img'),
            brand: $(this).data('product-brand'),
            screen: $(this).data('product-screen'),
            storage: $(this).data('product-storage'),
            quantityLimit: $(this).data('product-quantity-limit'),
            quantity : $(this).data('product-quantity') || 1
        };
        $.ajax({
            url: '/add-to-cart',
            method: 'POST',
            data: { product: product },
            success: function(response) {
                let successDiv = '<div class="alert-success" id="alert-success">' + response.message + '</div>';
                $('body').append(successDiv);
                $('#cart-count').text(response.cartCount);
                setTimeout(function() {
                $('#alert-success').remove();
                }, 3000);
            }
        });
    });
    });
</script>
@endsection