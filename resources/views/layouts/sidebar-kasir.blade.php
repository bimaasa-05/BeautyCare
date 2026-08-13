<!-- Sidebar Kasir -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="BeautyCare Logo" width="100" height="100" style="border-radius: 10px;">
        <span>BeautyCare</span>
        <button class="sidebar-close" onclick="closeSidebar()" aria-label="Tutup menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            <a href="{{ route('kasir.dashboard') }}"
                class="nav-item {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}"
                title="Overview transaksi dan aktifitas kasir">
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
            <div class="nav-section-title">Transaksi</div>
            <a href="{{ route('kasir.transaksi.index') }}"
                class="nav-item {{ request()->routeIs('kasir.transaksi.*') ? 'active' : '' }}"
                title="Buat transaksi penjualan baru">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                </span>
                Transaksi
            </a>
            <a href="{{ route('kasir.checkin.index') }}"
                class="nav-item {{ request()->routeIs('kasir.checkin.*') ? 'active' : '' }}"
                title="Proses check in pelanggan yang datang">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </span>
                Check In Pelanggan
            </a>
            <a href="{{ route('kasir.pembayaran.index') }}"
                class="nav-item {{ request()->routeIs('kasir.pembayaran.*') ? 'active' : '' }}"
                title="Proses pembayaran pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Pembayaran
            </a>
            <a href="{{ route('kasir.invoice.index') }}"
                class="nav-item {{ request()->routeIs('kasir.invoice.*') ? 'active' : '' }}"
                title="Cetak invoice transaksi">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </span>
                Invoice
            </a>
            <a href="{{ route('kasir.riwayat-transaksi.index') }}"
                class="nav-item {{ request()->routeIs('kasir.riwayat-transaksi.*') ? 'active' : '' }}"
                title="Lihat riwayat transaksi">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Riwayat Transaksi
            </a>
            <a href="{{ route('kasir.pengeluaran.index') }}"
                class="nav-item {{ request()->routeIs('kasir.pengeluaran.*') ? 'active' : '' }}"
                title="Catat dan lihat pengeluaran kasir">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Pengeluaran
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Reservasi</div>
            <a href="{{ route('kasir.reservasi.index') }}" class="nav-item {{ request()->routeIs('kasir.reservasi.*') ? 'active' : '' }}" title="Kelola reservasi pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Reservasi
            </a>
            <a href="{{ route('kasir.konsultasi.index') }}" class="nav-item {{ request()->routeIs('kasir.konsultasi*') ? 'active' : '' }}" title="Kelola permintaan konsultasi member">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </span>
                Konsultasi
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Pelanggan</div>
            <a href="{{ route('kasir.pelanggan.index') }}"
                class="nav-item {{ request()->routeIs('kasir.pelanggan.*') ? 'active' : '' }}"
                title="Data pelanggan yang terdaftar">
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
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="{{ route('kasir.laporan.index') }}"
                class="nav-item {{ request()->routeIs('kasir.laporan.*') ? 'active' : '' }}"
                title="Laporan pendapatan harian / bulanan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Laporan Pendapatan
            </a>
            <a href="{{ route('kasir.laporan-pelanggan.index') }}" class="nav-item {{ request()->routeIs('kasir.laporan-pelanggan.*') ? 'active' : '' }}" title="Laporan data pelanggan">
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
<div class="sidebar-overlay" id="sidebarOverlay"></div>

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
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });
});
</script>
