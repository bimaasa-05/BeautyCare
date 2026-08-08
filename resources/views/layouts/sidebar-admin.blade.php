<!-- Sidebar Admin -->
@php
    $masterDataActive = request()->routeIs('admin.user.index', 'admin.pelanggan.index', 'admin.karyawan.index', 'admin.supplier.index');
    $layananProdukActive = request()->routeIs('admin.layanan.index', 'admin.kategori.index', 'admin.produk.index', 'admin.stok.*');
@endphp
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
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
            <div class="nav-item {{ $masterDataActive ? 'active' : '' }}" onclick="toggleSubnav(this)"
                title="Kelola data utama sistem">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <ellipse cx="12" cy="5" rx="9" ry="3" />
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                    </svg>
                </span>
                Data Master
                <span class="nav-arrow {{ $masterDataActive ? 'open' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </span>
            </div>
            <div class="sub-nav {{ $masterDataActive ? 'open' : '' }}">
                <a href="{{ route('admin.user.index') }}"
                    class="sub-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                    title="Kelola seluruh data pengguna sistem">Data User</a>
                <a href="{{ route('admin.pelanggan.index') }}"
                    class="sub-item {{ request()->routeIs('admin.pelanggan.index') ? 'active' : '' }}"
                    title="Kelola data pelanggan yang terdaftar">Data Pelanggan</a>
                <a href="{{ route('admin.karyawan.index') }}"
                    class="sub-item {{ request()->routeIs('admin.karyawan.index') ? 'active' : '' }}"
                    title="Kelola data karyawan: gaji, komisi, dan status">Data Karyawan</a>
                <a href="{{ route('admin.supplier.index') }}"
                    class="sub-item {{ request()->routeIs('admin.supplier.index') ? 'active' : '' }}"
                    title="Kelola data supplier">Data Supplier</a>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-item {{ $layananProdukActive ? 'active' : '' }}" onclick="toggleSubnav(this)"
                title="Kelola layanan dan produk">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                        <line x1="12" y1="22.08" x2="12" y2="12" />
                    </svg>
                </span>
                Layanan & Produk
                <span class="nav-arrow {{ $layananProdukActive ? 'open' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </span>
            </div>
            <div class="sub-nav {{ $layananProdukActive ? 'open' : '' }}">
                <a href="{{ route('admin.layanan.index') }}"
                    class="sub-item {{ request()->routeIs('admin.layanan.index') ? 'active' : '' }}"
                    title="Kelola daftar layanan yang tersedia">Data Layanan</a>
                <a href="{{ route('admin.kategori.index') }}"
                    class="sub-item {{ request()->routeIs('admin.kategori.index') ? 'active' : '' }}"
                    title="Kelola kategori layanan dan produk">Data Kategori</a>
                <a href="{{ route('admin.produk.index') }}"
                    class="sub-item {{ request()->routeIs('admin.produk.index') ? 'active' : '' }}"
                    title="Kelola data produk; stok diatur melalui menu Mutasi Stok">Data Produk</a>
                <a href="{{ route('admin.stok.index') }}"
                    class="sub-item {{ request()->routeIs('admin.stok.*') ? 'active' : '' }}"
                    title="Catat barang masuk, refund, dan lihat riwayat mutasi stok">
                    Mutasi Stok
                    @if (hitungMutasiStokBaru() > 0)
                    <span class="nav-badge badge-primary">{{ hitungMutasiStokBaru() > 99 ? '99+' : hitungMutasiStokBaru() }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Marketing</div>
            <a href="{{ route('admin.membership.index') }}"
                class="nav-item {{ request()->routeIs('admin.membership.index') ? 'active' : '' }}"
                title="Kelola membership dan loyalitas pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
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
            <a href="{{ route('admin.reservasi.index') }}"
                class="nav-item {{ request()->routeIs('admin.reservasi.index') ? 'active' : '' }}"
                title="Kelola semua reservasi / booking">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Data Reservasi
            </a>
            <a href="{{ route('admin.transaksi.index') }}"
                class="nav-item {{ request()->routeIs('admin.transaksi.index') ? 'active' : '' }}"
                title="Kelola semua data transaksi">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </span>
                Data Transaksi
            </a>
            <a href="{{ route('admin.pengeluaran.index') }}"
                class="nav-item {{ request()->routeIs('admin.pengeluaran.*') ? 'active' : '' }}"
                title="Kelola semua data pengeluaran">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Pengeluaran
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Laporan</div>
            <a href="{{ route('admin.laporan.index') }}"
                class="nav-item {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}"
                title="Lihat laporan pendapatan bisnis">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </span>
                Laporan Pendapatan
            </a>
            <a href="{{ route('admin.laporan-pelanggan.index') }}"
                class="nav-item {{ request()->routeIs('admin.laporan-pelanggan.*') ? 'active' : '' }}"
                title="Laporan data pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Laporan Pelanggan
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Monitoring</div>
            <a href="{{ route('admin.riwayat.index') }}"
                class="nav-item {{ request()->routeIs('admin.riwayat.*') ? 'active' : '' }}"
                title="Lihat riwayat aktivitas semua pengguna">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Riwayat Aktivitas
                @if (hitungPerubahanData() > 0)
                <span class="nav-badge badge-primary">{{ hitungPerubahanData() > 99 ? '99+' : hitungPerubahanData() }}</span>
                @endif
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

    function toggleSubnav(item) {
        var sub = item.nextElementSibling;
        var arrow = item.querySelector('.nav-arrow');
        if (sub) sub.classList.toggle('open');
        if (arrow) arrow.classList.toggle('open');
    }

    document.addEventListener('DOMContentLoaded', function () {
        var overlay = document.getElementById('sidebarOverlay');
        if (overlay) {
            overlay.addEventListener('click', function () {
                closeSidebar();
            });
        }

        document.querySelectorAll('#sidebar .nav-item[href], #sidebar .sub-item').forEach(function (item) {
            item.addEventListener('click', function () {
                if (window.innerWidth <= 1024) {
                    closeSidebar();
                }
            });
        });
    });
</script>