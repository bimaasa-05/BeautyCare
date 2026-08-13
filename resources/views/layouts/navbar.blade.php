<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="BeautyCare Logo" width="100" height="100" style="border-radius: 10px;">
            BeautyCare
        </a>

        <ul class="navbar-nav">
            <li><a href="#hero" class="active">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#membership">Membership</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        <div class="navbar-actions">
            <a href="{{ route('help.index') }}" class="navbar-help-btn" title="Pusat Bantuan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" /><line x1="12" y1="17" x2="12.01" y2="17" /></svg>
                <span>Bantuan</span>
            </a>
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