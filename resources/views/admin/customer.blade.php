@extends('layouts.app3')
@section('content')
<section class="admin-page">
    <div class="title">
        <h2>Khách hàng</h2>
        <div class="search-bar">
            <form action="{{ route('cus-search') }}" method="post">
                @csrf
                <input type="text" name="search" id="searchInput" class="search-input" placeholder="Tìm người dùng theo tên hoặc email">
                <button type="submit" class="my-btn1">Tìm kiếm</button>
            </form>
        </div>
        <button class="add-btn" id="add-btn" onclick="openPopup('add')">Thêm</button>
    </div>
    @if ($customers->isEmpty())
    <h2>Không có khách hàng nào.</h2>
    @else
    <table class="table">
        <tr>
            <th>STT</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Sửa</th>
            <th>Xoá</th>
        </tr>
        @foreach ($customers as $user)
            <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->address}}</td>
            <td><button class="udt-btn" id="udt-btn" onclick="openPopup('edit', {{ $user->id }})">Sửa</button></td>
            <td><form method="POST" action="{{ route('delete-user', $user->id) }}" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-btn">Xoá</button>
            </form></td>
            </tr>
        @endforeach
    </table>
    @endif
    <div class="pagination">
        {{ $customers->render('layouts.reuse.paginateTem') }}
    </div>
    @include('layouts.reuse.userPopup')
</section>
@endsection
