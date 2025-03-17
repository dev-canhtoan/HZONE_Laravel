@extends('layouts.app3')
@section('content')
<section class="admin-page" id="pm">
    <div class="title">
        <h2>Sản phẩm</h2>
        <div class="search-bar">
            <form action="{{ route('pro-search') }}" method="post">
                @csrf
                <input type="text" name="search" id="searchInput" class="search-input" placeholder="Tìm sản phẩm">
                <button type="submit" class="my-btn1">Tìm kiếm</button>
            </form>
        </div>
        <div class="filter-bar">
            <form action="{{ route('pro-search') }}" method="post">
                @csrf
                    <select name="category_filter" id="category-filter">
                        <option value="">Tất cả danh mục</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                <button type="submit" class="my-btn1">Lọc</button>
            </form>
        </div>
        <button class="add-btn" id="add-btn" onclick="openPopup('add')">Thêm</button>
    </div>
    @if ($products->isEmpty())
        <h2>Không có sản phẩm nào.</h2>
    @else
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Ảnh sán phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>SL còn lại</th>
            <th>Mô tả sản phẩm</th>
            <th>Giảm giá (%)</th>
            <th>Thời gian tạo</th>
            <th>Thời gian sửa</th>
            <th>Sửa</th>
            <th>Xoá</th>
        </tr>
        @foreach ($products as $product)
        <td>{{$product->id}}</td>
        <td>
            <div class="infoM"><img src="{{ URL('image/product-image/' . $product->img) }}" alt="" class="img-pdt">
            </div>
        </td>
        <td>{{$product->name}}</td>
        <td>{{$product->category->name}}</td>
        <td>{{ number_format($product->price, 0, '.', '.') }}₫</td>
        <td>{{$product->quantity}}</td>
        <td id="des-field">{{$product->des}}</td>
        <td>@if ($product->discount)
            {{$product->discount->percent}}
            @else
            Không có
            @endif
        </td>
        <td>{{$product->created_at}}</td>
        <td>{{$product->updated_at}}</td>
        <td><button class="udt-btn" id="udt-btn" onclick="openPopup('edit', {{ $product->id }})">Sửa</button></td>
        <td>
            <form method="POST" action="{{ route('delete-product', $product->id) }}" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-btn">Xoá</button>
            </form>
        </td>
        </tr>
        @endforeach
    </table>
    @endif
    <div class="pagination">
        {{ $products->render('layouts.reuse.paginateTem') }}
    </div>
    <div id="popup" style="display: none">
        <form method="POST" action="" enctype="multipart/form-data" id="form-popup">
            @csrf
            <div class="row">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="text-field" name="name" id="name" placeholder="Nhập tên sản phẩm">
            </div>

            <div class="row">
                <label for="category">Danh mục:</label>
                <select name="category" id="category">
                    <option value="">None</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <label for="discount">Chương trình giảm giá:</label>
                <select name="discount" id="discount">
                    <option value="">None</option>
                    @foreach ($discounts as $discount)
                    <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <label for="price">Giá:</label>
                <input type="text" class="text-field" name="price" id="price" placeholder="Nhập giá sản phẩm">
            </div>

            <div class="row">
                <label for="fileInput" id="choose-img">Chọn ảnh</label>
                <input type="file" name="image" id="fileInput" style="display:none;">
            </div>

            <div class="row">
                <label for="quanity">Số lượng sản phẩm:</label>
                <input type="text" class="text-field" name="quantity" id="quantity" placeholder="Nhập số lượng sản phẩm">
            </div>

            <div class="row">
                <label for="description">Mô tả sản phẩm:</label>
                <input name="description" id="description" placeholder="Nhập mô tả sản phẩm" class="text-field">
            </div>
            <div class="row">
                <label for="brand">Hãng sản xuất:</label>
                <input name= "brand" id="brand" class="text-field" placeholder="Nhập tên hãng">
            </div>
            <div class="row">
                <label for="screen">Màn hình:</label>
                <input name= "screen" id="screen" class="text-field" placeholder="Nhập kích thước màn hình">
            </div>
            <div class="row">
                <label for="storage">Dung lượng:</label>
                <input name= "storage" id="storage" class="text-field" placeholder="Nhập dung lượng">
            </div> 
            <div class="row">
                <label for="ram">Ram:</label>
                <input name="ram" id="ram" class="text-field" placeholder="Nhập ram">
            </div>
            <div class="row">
                <label for="chip">Chipset:</label>
                <input name= "chip" id="chip" class="text-field" placeholder="Nhập tên chip">
            </div>
            <div class="row">
                <label for="pin">Pin:</label>
                <input name= "pin" id="pin" class="text-field" placeholder="Nhập dung lượng pin">
            </div>
            <div class="row">
                <label for="camera">Camera:</label>
                <input name= "camera" id="camera" class="text-field" placeholder="Nhập thông tin camera">
            </div>
            <div class="row">
                <label for="vga">Vga:</label>
                <input name= "vga" id="vga" class="text-field" placeholder="Nhập thông tin vga">
            </div>

            <div class="row">
                <label for="os">Hệ điều hành:</label>
                <input name= "os" id="os" class="text-field" placeholder="Nhập tên hệ điều hành">
            </div>

            <div class="btn-layout">
                <button type="submit" class="add-btn">Lưu</button>
                <button type="reset" onclick="closePopup()" class="del-btn">Hủy</button>
            </div>
        </form>
    </div>
    <div id="overlay" style="display: none"></div>
</section>
<script>
    function openPopup(action, productId) {
        if (action === 'add') {
        $("#form-popup").attr('action', "{{ route('create-product') }}");
        $("#form-popup").trigger('reset');
    } else if (action === 'edit') {
        $("#form-popup").attr('action', "{{ url('admin/product/update') }}/" + productId);
        getProductInfo(productId);
    }
        $("#popup").show();
        $("#overlay").show();
    }
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?');
    }
    function getProductInfo(productId) {
        $.ajax({
            type: 'GET',
            url: 'product/get-product-info/' + productId,
            dataType: 'json',
            success: function(response) {
                $('#name').val(response.name);
                $('#category').val(response.cate_id);
                $('#discount').val(response.dis_id);
                $('#price').val(response.price);
                $('#quantity').val(response.quantity);
                $('#description').val(response.des);
                $('#ram').val(response.spec.ram);
                $('#storage').val(response.spec.storage);
                $('#brand').val(response.spec.brand);
                $('#screen').val(response.spec.screen);
                $('#chip').val(response.spec.chip);
                $('#pin').val(response.spec.pin);
                $('#camera').val(response.spec.camera);
                $('#vga').val(response.spec.vga);
                $('#os').val(response.spec.os);
                openPopup();
            },
            error: function(error) {
                console.log(error);
            }  
        });
    }
    document.getElementById("fileInput").addEventListener("change", function() {
        console.log("File changed!");
        let fileName = this.files[0].name;
        let label = document.querySelector("label[for='fileInput']");
        label.innerHTML = fileName;
    });
</script>
@endsection