<div class="pdt-card">
    <a href="{{ route('product-info-page', ['id' => $product->id]) }}" style="color:black;">
        @if ($product->quantity === 0)
        <img src="{{ asset('image/other-img/hethang.png') }}" alt="sold out" class="sold-out">
        @endif
        <img src="{{ URL('image/product-image/' . $product->img) }}" alt="" class="img-pdt">
        <p id="pdt-title">{{$product->name}}</p>
        <div class="price">
            @if ($product->discount && $product->discount->start_at <= now() &&$product->discount->end_at >= now())
                <i class="fa-solid fa-tag fa-3x" id="dis-tag"><p>{{ $product->discount->percent }}%</p></i>
                <p style="font-weight:bold">{{ number_format($product->price-($product->price * $product->discount->percent/ 100), 0, '.', '.') }}₫</p>
                <p style="text-decoration: line-through; font-size:12px">{{ number_format($product->price, 0, '.', '.') }}₫</p>
            @else
                <p style="font-weight:bold">{{ number_format($product->price, 0, '.', '.') }}₫</p>
            @endif
        </div>
        <p style="color: #00B517; font-size: 12px">Freeship</p>
        <div class="rate">
            @for ($i = 0; $i < 5; $i++) 
            @if ($i< $product->rates->avg_stars)
                <i class="fa-solid fa-star" style="color: #FFD700;"></i>
            @else
                <i class="fa-solid fa-star" style="color: #ddd;"></i>
            @endif
            @endfor
            @if (count($product->rates) > 0)
                ({{ count($product->rates) }})
            @endif
        </div>
    </a>
</div>