<div class="productPage-content">
        <div class="filter-clm">
            <button class="clp-button">
                <h3>Danh mục</h3></button>
                <div class="clp-content">
                    <a class="cate-link" href="{{ route('allProductsPage') }}">Tất cả</a><br>
                    @foreach ($categories as $category)
                        <div class="ckb">
                            <input type="checkbox" wire:model="selectedCategory" wire:click="applyFilters" name="ckb" value="{{ $category->id }}" class="ckb" >
                            <label for="ckb" class="ckb" id="test">{{ $category->name }}</label>
                        </div>
                    @endforeach
 
                </div>
                <button class="clp-button">
                    <h3>Thương hiệu</h3>
                </button>
                <div class="clp-content">
                    @foreach ($brands as $brand)
                    <div class="ckb">
                        <input type="checkbox" wire:model="filter" wire:click="applyFilters" name="ckb" value="{{ $brand }}" class="ckb" >
                        <label for="ckb" class="ckb" id="test">{{ $brand }}</label>
                    </div>
                    @endforeach
                </div>
                <button class="clp-button">
                    <h3>Chương trình<br>giảm giá</h3>
                </button>
                <div class="clp-content">
                    @foreach ($discounts as $discount)
                    <div class="ckb">
                        <input type="checkbox" wire:model="discount" wire:click="applyFilters" name="ckb" value="{{ $discount->id }}" class="ckb" >
                        <label for="ckb" class="ckb" id="test">{{ $discount->name }}</label>
                    </div>
                    @endforeach
                </div>
                <button class="clp-button">
                    <h3>Dung lượng</h3>
                </button>
                <div class="clp-content">
                    @foreach ($storages as $storage)
                    <div class="ckb">
                        <input type="checkbox" wire:model="filter" wire:click="applyFilters" name="ckb" value="{{ $storage }}" class="ckb">
                        <label for="ckb" class="ckb" id="test">{{ $storage }}</label>
                    </div>
                    @endforeach
                </div>
                <button class="clp-button">
                    <h3>Ram</h3>
                </button>
                <div class="clp-content">
                    @foreach ($rams as $ram)
                    <div class="ckb">
                        <input type="checkbox" wire:model="ram" wire:click="applyFilters" name="ckb" value="{{ $ram }}" class="ckb">
                        <label for="ckb" class="ckb" id="test">{{ $ram }}</label>
                    </div>
                    @endforeach
                </div>
                <button class="clp-button">
                    <h3>Đánh giá</h3>
                </button>
                <div class="clp-content">
                    @for ($i = 0; $i < 5; $i++) 
                    <div class="ckb">
                        <input type="checkbox" wire:model="star" wire:click="applyFilters" name="ckb" value="{{ 5-$i }}" class="ckb">
                        <label for="ckb" class="ckb" id="test">
                            @for ($j = 0; $j < 5; $j++) 
                            @if ($j < 5 - $i)
                                <i class="fa-solid fa-star" style="color: #FFD700;"></i>
                            @else
                                <i class="fa-solid fa-star" style="color: #ddd;"></i>
                            @endif
                            @endfor
                        </label>
                    </div>
                    @endfor
                </div>
                <button class="clp-button">
                    <h3>Giá</h3>
                </button>
                @php
                    $prices = [
                        'Dưới 1 triệu' => ['min' => 0, 'max' => 1000000],
                        '1-3 triệu' => ['min' => 1000000, 'max' => 3000000],
                        '3-5 triệu' => ['min' => 3000000, 'max' => 5000000],
                        '5-10 triệu' => ['min' => 5000000, 'max' => 10000000],
                        '10-20 triệu' => ['min' => 10000000, 'max' => 20000000],
                        'Trên 20 triệu' => ['min' => 20000000, 'max' => 1000000000]
                        ]
                @endphp
                <div class="clp-content">
                    <select name="ckb" wire:model="sort"  wire:click="applyFilters" class="status-select">
                        <option value="">Xếp theo giá</option>
                        <option value="asc">Thấp -> cao</option>
                        <option value="desc">Cao -> thấp</option>
                    </select>
                    @foreach ($prices as $label => $range)
                        <div class="ckb">
                            <input type="checkbox" wire:model="selectedPriceRanges" wire:click="applyFilters"  name="ckb" value="{{ $range['min'] }}-{{ $range['max'] }}" class="ckb">
                            <label for="ckb" class="ckb" id="test">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
    </div>
    <div class="pro-clm">
        <div class="main-product-grid">
            @if ($products->isEmpty())
                <h1>Không có sản phẩm nào.</h1>
            @endif
            @foreach ($products as $product)
            @include('layouts.reuse.productCard')
            @endforeach
        </div>
        <div class="pagination">
            {{ $products->render('livewire.paginateLW') }}
        </div>
    </div>