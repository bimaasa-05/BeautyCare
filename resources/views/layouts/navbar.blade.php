<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="8" fill="#FF4F87" />
                <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z" fill="white"
                    opacity="0.9" />
                <path d="M14 14L18 18M18 14L14 18" stroke="#FF4F87" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            BeautyCare
        </a>

        <ul class="navbar-nav">
            <li><a href="#hero" class="active">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#pricing">Harga</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>

        <div class="navbar-actions">
            <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            <button type="button" class="navbar-toggle" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>