<!-- Sidebar Admin -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="8" fill="#FF4F87" />
            <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z" fill="white"
                opacity="0.9" />
        </svg>
        <span>BeautyCare</span>
        <button class="sidebar-close" onclick="closeSidebar()" aria-label="Tutup menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <div class="sidebar-profile">
        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('assets/img/default-avatar.png') }}"
            alt="Profile">
        <div class="sp-info">
            <h4>{{ auth()->user()->nama }}</h4>
            <span class="sp-badge">{{ auth()->user()->role }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Utama</div>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                title="Overview bisnis dan statistik utama">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                </span>
                Dashboard
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Data Master</div>
            <a href="{{ route('admin.user.index') }}"
                class="nav-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                title="Kelola seluruh data pengguna sistem">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </span>
                Data User
            </a>
            <a href="{{ route('admin.pelanggan.index') }}"
                class="nav-item {{ request()->routeIs('admin.pelanggan.index') ? 'active' : '' }}" class="nav-item"
                title="Kelola data pelanggan yang terdaftar">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <polyline points="17 11 19 13 23 9" />
                    </svg>
                </span>
                Data Pelanggan
            </a>
            <a href="{{ route('admin.beautician.index') }}"
                class="nav-item {{ request()->routeIs('admin.beautician.index') ? 'active' : '' }}" class="nav-item"
                title="Kelola data beautician / terapis">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                        <path d="M19 7l1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2z" />
                    </svg>
                </span>
                Data Beautician
            </a>
            <a href="{{ route('admin.supplier.index') }}"
                class="nav-item {{ request()->routeIs('admin.supplier.index') ? 'active' : '' }}" class="nav-item"
                title="Kelola data supplier">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                        <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                        <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                        <path d="M5 9H9V12H5V9Z" />
                    </svg>
                </span>
                Data Supplier
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Layanan & Produk</div>
            <a href="{{ route('admin.layanan.index') }}"
                class="nav-item {{ request()->routeIs('admin.layanan.index') ? 'active' : '' }}" class="nav-item"
                title="Kelola daftar layanan yang tersedia">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                </span>
                Data Layanan
            </a>
            <a href="{{ route('admin.kategori.index') }}"
                class="nav-item {{ request()->routeIs('admin.kategori.index') ? 'active' : '' }}"
                title="Kelola kategori layanan dan produk">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="21" x2="20" y2="21" />
                        <line x1="4" y1="21" x2="4" y2="9" />
                        <line x1="20" y1="21" x2="20" y2="9" />
                        <line x1="2" y1="9" x2="22" y2="9" />
                        <rect x="7" y="12" width="3" height="6" />
                        <rect x="14" y="12" width="3" height="6" />
                    </svg>
                </span>
                Data Kategori
            </a>
            <a href="{{ route('admin.produk.index') }}"
                class="nav-item {{ request()->routeIs('admin.produk.index') ? 'active' : '' }}" class="nav-item"
                title="Kelola stok dan data produk">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    </svg>
                </span>
                Data Produk
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Marketing</div>
            <a href="{{ route('admin.membership.index') }}"
                class="nav-item {{ request()->routeIs('admin.membership.index') ? 'active' : '' }}"
                title="Kelola membership dan loyalitas pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </span>
                Data Membership
            </a>
            <a href="{{ route('admin.promo.index') }}"
                class="nav-item {{ request()->routeIs('admin.promo.index') ? 'active' : '' }}"
                title="Kelola promo dan diskon">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 12 20 22 4 22 4 12" />
                        <rect x="2" y="7" width="20" height="5" />
                        <line x1="12" y1="22" x2="12" y2="7" />
                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                    </svg>
                </span>
                Data Promo
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Operasional</div>
            <a href="{{ route('admin.reservasi.index') }}" class="nav-item {{ request()->routeIs('admin.reservasi.index') ? 'active' : '' }}" title="Kelola semua reservasi / booking">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Data Reservasi
            </a>
            <a href="{{ route('admin.transaksi.index') }}" class="nav-item {{ request()->routeIs('admin.transaksi.index') ? 'active' : '' }}" title="Kelola semua data transaksi">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Data Transaksi
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}" title="Lihat laporan pendapatan bisnis">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Laporan Pendapatan
            </a>
            <a href="{{ route('admin.laporan-pelanggan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan-pelanggan.*') ? 'active' : '' }}" title="Laporan data pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Laporan Pelanggan
            </a>
        </div>
    </nav>


</aside>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<script>
    function closeSidebar() {
        var s = document.getElementById('sidebar');
        var o = document.getElementById('sidebarOverlay');
        if (s) s.classList.remove('open');
        if (o) o.classList.remove('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('sidebarOverlay');
        if (overlay) {
            overlay.addEventListener('click', function() {
                closeSidebar();
            });
        }

        document.querySelectorAll('#sidebar .nav-item').forEach(function(item) {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    });
</script>
