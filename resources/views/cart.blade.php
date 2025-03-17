@extends('layouts.app')
@section('content')
<section class="cart-page">
    <div class="cart-page-content">
        <div class="cart-count">
            <h2>Giỏ hàng của tôi ({{ count(session('cart', [])) }})</h2>
        </div>
        <div class="cart-content">
            <div class="list-cart">
                @php
                $cart = session('cart', []);
                $totalPrice = 0;
                @endphp
                @forelse ($cart as $product)
                <div class="cart-item">
                    <div class="info-item">
                        <a href="{{ route('product-info-page', ['id' => $product['id']]) }}"><img src="{{ URL('image/product-image/' . $product['image']) }}" alt="" class="img-pdt"></a>
                        <div class="order-info">
                            <div class="order-infos">
                                <a href="{{ route('product-info-page', ['id' => $product['id']]) }}"><h4>{{ $product['name'] }}</h4></a>
                                <p>Hãng: {{ $product['brand'] }}, Màn hình: {{ $product['screen'] }}, Dung lượng: {{ $product['storage'] }}</p>
                            </div>
                            <div class="choice-button">
                                <button class="remove-btn" data-product-id="{{ $product['id'] }}">Xoá sản phẩm</button>
                            </div>
                        </div>
                    </div>
                    <div class="price-count">
                        <h4>{{ number_format($product['price'], 0, '.', '.') }}₫</h4>
                        <div class="number-input" data-quantity-limit="{{ $product['quantityLimit'] }}">
                            <button class="minus">-</button>
                            <input type="number" class="value" value="{{ $product['quantity'] }}"
                                data-product-id="{{ $product['id'] }}">
                            <button class="plus">+</button>
                        </div>
                    </div>
                </div>
                @php
                $totalPrice += $product['price'] * $product['quantity'];
                @endphp
                @empty
                <h1>Giỏ hàng trống.</h1>
                @endforelse
            </div>
            <div class="payment">
                <div class="address">
                    <h4>Địa chỉ:</h4>
                    <p>{{ Auth::user()->address; }}</p>
                </div>
                <div class="bill-info">
                    <h4>Thông tin đơn hàng: </h4>
                    <p>Tạm tính ({{ count(session('cart', [])) }} sản phẩm): <span id="fst">{{ number_format($totalPrice, 0, '.', '.') }}₫</span></p>
                    <p>Phí vận chuyển: <span id="snd">Freeship</span></p>
                </div>
                <div class="pay">
                    <h3 class="total">Tổng cộng: <span id="total">{{ number_format($totalPrice, 0, '.', '.') }}₫</span></h3>
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
                        <button type="submit" class="zalo"><i class="fa-solid fa-wallet"></i> Thanh toán với Zalopay</button>
                    </form>
                </div>
            </div>
        </div>
        <h2>Sản phẩm đề xuất</h2>
        <div class="recommend-product-grid">
            @foreach ($products as $product)
            @include('layouts.reuse.productCard')
            @endforeach
        </div>
    </div>
</section>
<script src="/jquery.js"></script>
<script>
    const minusButtons = document.querySelectorAll('.minus');
    const plusButtons = document.querySelectorAll('.plus');
    const valueInputs = document.querySelectorAll('.value');

    minusButtons.forEach((minusButton, index) => {
        minusButton.addEventListener('click', () => {
            let currentValue = parseInt(valueInputs[index].value);
            if (currentValue > 1) {
                valueInputs[index].value = currentValue - 1;
                let product = {
                    id: valueInputs[index].getAttribute('data-product-id'),
                    quantity: currentValue - 1
                };
                updateProductQuantity(product);
            }
        });
    });

    plusButtons.forEach((plusButton, index) => {
        plusButton.addEventListener('click', () => {
            let currentValue = parseInt(valueInputs[index].value);
            let quantityLimit = parseInt(valueInputs[index].closest('.number-input').getAttribute('data-quantity-limit'));
            if (currentValue < quantityLimit) {
                valueInputs[index].value = currentValue + 1;
                let product = {
                id: valueInputs[index].getAttribute('data-product-id'),
                quantity: currentValue + 1
                };
                updateProductQuantity(product);
            }
        });
    });

    valueInputs.forEach((input, index) => {
        input.addEventListener('change', () => {
            let newValue = parseInt(input.value);
            let quantityLimit = parseInt(input.closest('.number-input').getAttribute('data-quantity-limit'));
            if (newValue < 1) {
                newValue = 1;
            }   
            else if (newValue > quantityLimit) {
            newValue = quantityLimit;
            }
            let product = {
                id: input.getAttribute('data-product-id'),
                quantity: newValue
            };
            input.value = newValue; // Đảm bảo hiển thị giá trị hợp lệ
            updateProductQuantity(product);
        });
    });
    function updateProductQuantity(product) {
        $.ajax({
            url: '/update-product-quantity',
            method: 'POST',
            data: { product: product },
            success: function(response) {
                $('#fst').text(response.totalPrice  + '₫');
                $('#total').text(response.totalPrice + '₫');
                console.log(response.message);
            }
        });
    }
    const removeButtons = document.querySelectorAll('.remove-btn');
        removeButtons.forEach((removeButton) => {
            removeButton.addEventListener('click', () => {
                const productID = removeButton.getAttribute('data-product-id');
                removeProduct(productID);
            });
    });

    function removeProduct(productID) {
        $.ajax({
            url: '/remove-product',
            method: 'DELETE',
            data: { product: { id: productID } },
            success: function (response) {
                $('#fst').text(response.totalPrice + '₫');
                $('#total').text(response.totalPrice + '₫');
                //xoá thẻ sản phẩm 
                const cartItem = document.querySelector(`[data-product-id="${productID}"]`).closest('.cart-item');
                cartItem.remove();
            }
        });
    }
</script>
@endsection