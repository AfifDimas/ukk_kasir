<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-brands fa-btc"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            KASIRKU 
            {{-- <sup><i class="fa-brands fa-btc"></i></sup> --}}
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fa-solid fa-house"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Nav Item - Penjualan -->
    <li class="nav-item {{ Nav::isRoute('penjualan*') }}">
        <a class="nav-link" href="{{ route('penjualan') }}">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>{{ __('Transaksi') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Menu Lainnya') }}
    </div>

    

    <!-- Nav Item - laporan -->
    <li class="nav-item {{ Nav::isRoute('produk*') }}">
        <a class="nav-link" href="{{ route('produk') }}">
            <i class="fa-regular fa-folder-open"></i>
            <span>{{ __('Data Barang') }}</span>
        </a>
    </li>

    @if (Auth::User()->level == '1')
        <!-- Nav Item - laporan -->
    <li class="nav-item {{ Nav::isRoute('laporan*') }}">
        <a class="nav-link" href="{{ route('laporan') }}">
            <i class="fa-regular fa-folder-open"></i>
            <span>{{ __('Laporan Penjualan') }}</span>
        </a>
    </li>

    <!-- Nav Item - Profile -->
    <li class="nav-item {{ Nav::isRoute('petugas') }}">
        <a class="nav-link" href="{{ route('petugas') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Daftar Petugas') }}</span>
        </a>
    </li>
    @endif
    
    



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
