<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="BeautyCare Logo" width="100" height="100">
            BeautyCare
        </a>

        <ul class="navbar-nav">
            <li><a href="#hero" class="active">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#membership">Membership</a></li>
            <li><a href="{{ route('help.index') }}">Pusat Bantuan</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        <div class="navbar-actions">
            @auth
            @php
                $dashboardUrl = match (auth()->user()->role) {
                    'admin'      => route('admin.dashboard'),
                    'kasir'      => route('kasir.dashboard'),
                    'beautycian' => route('beautycian.dashboard'),
                    default      => route('dashboard'),
                };
            @endphp
            <a href="{{ $dashboardUrl }}" class="btn btn-primary btn-sm">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @endauth
            <button type="button" class="navbar-toggle" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>