<div id="popup" style="display: none">
    <form method="POST" action="" enctype="multipart/form-data" id="form-popup">
        @csrf
        <label for="name">Tên người dùng:</label>
        <input type="text" class="text-field" name="username" id="name" placeholder="Nhập tên người dùng">

        <label for="phone">Số điện thoại:</label>
        <input name="phone" class="text-field" id="phone" placeholder="Nhập số điện thoại">

        <label for="email">Email:</label>
        <input name="email" class="text-field" id="email" placeholder="Nhập email người dùng" >

        @if (request()->is('admin/customer*'))
            <label for="address">Địa chỉ:</label>
            <input name="address" class="text-field" id="address" placeholder="Nhập địa chỉ">
        @elseif (request()->is('admin/admin*'))
            <input type="hidden" name="address" value="">
        @endif

        <input type="hidden" name="level" id="level" value="{{ request()->is('admin/customer*') ? 1 : 2}}">

        <label for="password" id="password-label">Mật khẩu:</label>
        <input type="password" class="text-field" name="password" id="password" placeholder="Nhập mật khẩu">
        <button type="submit" class="add-btn">Lưu</button>
        <button type="reset" onclick="closePopup()" class="del-btn">Hủy</button>
    </form>
</div>
<div id="overlay" style="display: none"></div>
<script>
    function openPopup(action, adminId) {
        let authUserId = {{ Auth::user()->id }};
        if (action === 'add') {
        $("#form-popup").attr('action', "{{ route('create-user') }}");
        $("#form-popup").trigger('reset');
        $("#email").prop('disabled', false);
        $("#password").show();
        $("#password-label").show();
    } else if (action === 'edit') {
        $("#form-popup").attr('action', "{{ url('admin/user/update') }}/" + adminId);
        $("#email").prop('disabled', true);
        $("#password").hide();
        $("#password-label").hide();
        if (authUserId == adminId){
            $("#password").show();
            $("#password-label").show();
        }
        getUserInfo(adminId);
    }
        $("#popup").show();
        $("#overlay").show();
    }
    function getUserInfo(adminId) {
        $.ajax({
            type: 'GET',
            url: 'user/get-user-info/' + adminId,
            dataType: 'json',
            success: function(response) {
                $('#name').val(response.username);
                $('#phone').val(response.phone);
                $('#email').val(response.email);
                $('#address').val(response.address);
                openPopup();
            },
            error: function(error) {
                console.log(error);
            }  
        });
    }
</script>
