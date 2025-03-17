<div class="nav-menu">
    <a href="{{ route('adminHome') }}" class="act-btn {{ request()->is('admin/home*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-house"></i></div>
        <div class="snd">Trang chủ</div>
    </a>
    <a href="{{ route('adminCate') }}" class="act-btn {{ request()->is('admin/category*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-clipboard"></i></div>
        <div class="snd">Danh mục</div>
    </a>
    <a href="{{ route('adminPro') }}" class="act-btn {{ request()->is('admin/product*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-shop"></i></div>
        <div class="snd">Sản phẩm</div>
    </a>
    <a href="{{ route('adminCus') }}" class="act-btn {{ request()->is('admin/customer*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-users"></i></div>
        <div class="snd">Khách hàng</div>
    </a>
    <a href="{{ route('adminOrder') }}" class="act-btn {{ request()->is('admin/order*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-cart-shopping"></i></div>
        <div class="snd">Đơn hàng</div>
    </a>
    <a href="{{ route('adminAdm') }}" class="act-btn {{ request()->is('admin/admin*') ? 'active' : '' }}" >
        <div class="fst-clm"><i class="fa-solid fa-user-tie"></i></div>
        <div class="snd">Admin</div>
    </a>
    <a href="{{ route('adminDis') }}" class="act-btn {{ request()->is('admin/discount*') ? 'active' : '' }}">
        <div class="fst-clm"><i class="fa-solid fa-tag"></i></div>
        <div class="snd">Giảm giá</div>
    </a>
</div>
