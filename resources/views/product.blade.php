@extends('layouts.app')
@section('content')
<section class="productPage">
    @if (Route::currentRouteName() !== 'allProductsPage')
    <div class="productPage-content">
        <div class="filter-clm">
            <button class="clp-button">
                <h3>Danh mục</h3>
            </button>
            <div class="clp-content">
                <a class="cate-link" href="{{ route('allProductsPage') }}">Tất cả</a><br>
                @foreach ($categories as $category)
                <a class="cate-link" href="{{ route('filterByCategory', $category->id) }}">{{ $category->name }}</a><br>
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
                {{ $products->render('layouts.reuse.paginateTem') }}
            </div>
        </div>
    </div>
    @else 
    @livewire('product-filter')
    @endif
    
</section>
@endsection