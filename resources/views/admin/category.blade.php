@extends('layouts.app3')
@section('content')
<section class="admin-page">
    <div class="title">
        <h2>Danh mục</h2>
        <div class="search-bar">
            <form action="{{ route('cate-search') }}" method="post">
                @csrf
                <input type="text" name="search" id="searchInput" class="search-input" placeholder="Tìm danh mục">
                <button type="submit" class="my-btn1">Tìm kiếm</button>
            </form>
        </div>
        <button class="add-btn" id="add-btn" onclick="openPopup('add')">Thêm</button>
    </div>
    @if ($categories->isEmpty())
        <h2>Không có danh mục nào.</h2>
    @else
    <table class="table">
        <tr>
            <th>STT</th>
            <th>Tên danh mục</th>
            <th>Sửa</th>
            <th>Xoá</th>
        </tr>
        @foreach ($categories as $category)
            <td>{{$category->id}}</td>
            <td><span class="category">{{$category->name}}</span></td>
            <td><button class="udt-btn" id="udt-btn" onclick="openPopup('edit', {{ $category->id }})">Sửa</button></td>
            <td><form method="POST" action="{{ route('delete-cate', $category->id) }}" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-btn">Xoá</button>
            </form></td>
            </tr>
        @endforeach
    </table>
    @endif
    <div id="popup" style="display: none">
        <form method="POST" action="" enctype="multipart/form-data" id="form-popup">
            @csrf
            <label for="name">Tên danh mục:</label>
            <input type="text" class="text-field" name="name" id="name" placeholder="Nhập tên danh mục">
            <button type="submit" class="add-btn">Lưu</button>
            <button type="reset" onclick="closePopup()" class="del-btn">Hủy</button>
        </form>
    </div>
    <div id="overlay" style="display: none"></div>   
</section>
<script>
    function openPopup(action, CateId) {
        if (action === 'add') {
        $("#form-popup").attr('action', "{{ route('create-cate') }}");
        $("#form-popup").trigger('reset');
    } else if (action === 'edit') {
        $("#form-popup").attr('action', "{{ url('admin/category/update') }}/" + CateId);
        getCateInfo(CateId);
    }
        $("#popup").show();
        $("#overlay").show();
    }
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xoá danh mục này?');
    }
    function getCateInfo(CateId) {
        $.ajax({
            type: 'GET',
            url: 'category/get-cate-info/' + CateId,
            dataType: 'json',
            success: function(response) {
                $('#name').val(response.name);
                openPopup();
            },
            error: function(error) {
                console.log(error);
            }  
        });
    }
</script>
@endsection