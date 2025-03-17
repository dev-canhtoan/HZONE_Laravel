@if ($errors->any())
<div class="alert-danger" id="alert-success">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('error'))
<div class="alert-danger" id="alert-success">
    {{ session('error') }}
</div>
@endif

@if (session('success'))
<div class="alert-success" id="alert-success">
    {{ session('success') }}
</div>
@endif 
<script src="/jquery.js"></script>
<script>
    setTimeout(function() {
    $("#alert-success").hide();
    }, 3000);
    
    function closePopup() {
        $("#popup").hide();
        $("#overlay").hide();
    }
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xoá người dùng này?');
    }
</script>