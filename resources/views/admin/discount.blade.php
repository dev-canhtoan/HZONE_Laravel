@extends('layouts.app3')
@section('content')
   <section class="admin-page">
        <div class="title">
            <h2>Giảm giá</h2>
            <div class="search-bar">
                <form action="{{ route('dis-search') }}" method="post">
                    @csrf
                    <input type="text" name="search" id="searchInput" class="search-input" placeholder="Tìm chương trình giảm giá">
                    <button type="submit" class="my-btn1">Tìm kiếm</button>
                </form>
            </div>
            <button class="add-btn" id="add-btn" onclick="openPopup('add')">Thêm</button>
        </div>
        @if ($discounts->isEmpty())
            <h2>Không có danh mục giảm giá nào.</h2>
        @else
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Tên chương trình giảm giá</th>
                <th>Giảm giá (%)</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Sửa</th>
                <th>Xoá</th>
            </tr>
            @foreach ($discounts as $discount)
                <td>{{ $discount->id }}</td>
                <td>{{ $discount->name }}</td>
                <td>{{ $discount->percent }}</td>
                <td>{{ $discount->start_at }}</td>
                <td>{{ $discount->end_at }}</td>
                <td>{{ $discount->created_at }}</td>
                @if ($discount->start_at <= now() && $discount->end_at >= now())
                <td class="fst">Đang áp dụng</td>
                @elseif($discount->start_at > now() && $discount->end_at >= now())
                <td class="scd">Chưa bắt đầu</td>
                @else
                <td class="thd">Đã hết hạn</td>
                @endif
                <td><button class="udt-btn" id="udt-btn" onclick="openPopup('edit', {{ $discount->id }})">Sửa</button></td>
                <td><form method="POST" action="{{ route('delete-dis', $discount->id) }}" onsubmit="return confirmDelete()">
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
                <label for="name">Tên chương trình giảm giá:</label>
                <input type="text" class="text-field" name="name" id="name" placeholder="Nhập tên chương trình giảm giá">
                <label for="percent">Giảm giá (%):</label>
                <input type="text" class="text-field" name="percent" id="percent" placeholder="Nhập giảm giá (%)">
                <label for="end_at">Ngày bắt đầu giảm giá:</label>
                <input type="datetime-local" class="text-field" name="start_at" id="start_at" placeholder="Nhập ngày bắt đầu">
                <label for="end_at">Ngày kết thúc giảm giá:</label>
                <input type="datetime-local" class="text-field" name="end_at" id="end_at" placeholder="Nhập ngày kết thúc">
                <button type="submit" class="add-btn">Lưu</button>
                <button type="reset" onclick="closePopup()" class="del-btn">Hủy</button>
            </form>
        </div>
        <div id="overlay" style="display: none"></div>   
    </section> 
    <script>
        function openPopup(action, DisId) {
            if (action === 'add') {
            $("#form-popup").attr('action', "{{ route('create-dis') }}");
            
            $("#form-popup").trigger('reset');
        } else if (action === 'edit') {
            $("#form-popup").attr('action', "{{ url('admin/discount/update') }}/" + DisId);
            getDisInfo(DisId);
        }
            $("#popup").show();
            $("#overlay").show();
        }
        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xoá danh mục này?');
        }
        function convertToBrowserTimezone(serverTime) {
            // Chuyển đổi thời gian từ múi giờ server (UTC) sang múi giờ trình duyệt
            const serverTimeUTC = new Date(serverTime);
            return new Date(serverTimeUTC.getTime() - serverTimeUTC.getTimezoneOffset() * 60000);
        }
        function getDisInfo(DisId) {
            $.ajax({
                type: 'GET',
                url: 'discount/get-dis-info/' + DisId,
                dataType: 'json',
                success: function(response) {
                    $('#name').val(response.name);
                    $('#percent').val(response.percent);

                const startAt = convertToBrowserTimezone(response.start_at);
                const startAtFormatted = startAt.toISOString().slice(0, 16);
                $('#start_at').val(startAtFormatted);

                const endAt = convertToBrowserTimezone(response.end_at);
                const endAtFormatted = endAt.toISOString().slice(0, 16);
                $('#end_at').val(endAtFormatted);
                    
                    openPopup();
                },
                error: function(error) {
                    console.log(error);
                }  
            });
        }
    </script>
@endsection