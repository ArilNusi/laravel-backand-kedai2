<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <div class="login-brand">
                <!-- Ganti width dari 150 menjadi ukuran yang lebih kecil, misal 80 -->
                <img src="{{ asset('img/kedai.png') }}" alt="logo" width="80">
            </div>
            <a href="index.html">my-KEDAI</a>
            <!-- Alternatif logo yang bisa diaktifkan dengan menghapus komentar -->
            {{-- <a href="index.html"><img src="{{ asset('img/resto.png') }}" alt="logo" width="80"></a> --}}
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">MK</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('home*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}">
                    <i class="fas fa-chart-line"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="{{ Request::is('user*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-user"></i><span>All Users</span>
                </a>
            </li>

            <li class="{{ Request::is('product*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="fas fa-box"></i><span>All Products</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
