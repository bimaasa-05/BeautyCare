<!-- Sidebar Pelanggan -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="8" fill="#FF4F87" />
            <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z" fill="white"
                opacity="0.9" />
        </svg>
        <span>BeautyCare</span>
        <button class="sidebar-close" onclick="closeSidebar()" aria-label="Tutup menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <div class="sidebar-profile">
        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->nama).'&background=FF4F87&color=fff&size=44' }}"
            alt="Profile" id="sidebarProfileImg">
        <div class="sp-info">
            <h4>{{ auth()->user()->nama }}</h4>
            <span class="sp-badge">{{ auth()->user()->role }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                title="Overview aktifitas dan riwayat Anda">
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
            <div class="nav-section-title">Booking</div>
            <a href="{{ route('pelanggan.booking') }}" class="nav-item {{ request()->routeIs('pelanggan.booking*') ? 'active' : '' }}" title="Booking treatment atau layanan baru">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </span>
                Booking Treatment
            </a>
            <a href="{{ route('pelanggan.reservasi') }}" class="nav-item {{ request()->routeIs('pelanggan.reservasi') ? 'active' : '' }}" title="Lihat riwayat reservasi Anda">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Riwayat Reservasi
            </a>
            <a href="{{ route('pelanggan.treatment') }}" class="nav-item {{ request()->routeIs('pelanggan.treatment') ? 'active' : '' }}" title="Lihat riwayat treatment Anda">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </span>
                Riwayat Treatment
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Promo</div>
            <a href="{{ route('pelanggan.promo') }}" class="nav-item {{ request()->routeIs('pelanggan.promo') ? 'active' : '' }}" title="Lihat promo dan diskon tersedia">
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
                Promo
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Membership</div>
            <a href="{{ route('pelanggan.membership') }}" class="nav-item {{ request()->routeIs('pelanggan.membership') ? 'active' : '' }}" title="Lihat keanggotaan dan benefit Anda">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                </span>
                Membership
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Produk</div>
            <a href="{{ route('pelanggan.produk') }}" class="nav-item {{ request()->routeIs('pelanggan.produk') ? 'active' : '' }}" title="Lihat produk dan layanan tersedia">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                        <line x1="12" y1="22.08" x2="12" y2="12" />
                    </svg>
                </span>
                Produk
            </a>
            <a href="{{ route('pelanggan.keranjang') }}" class="nav-item {{ request()->routeIs('pelanggan.keranjang') ? 'active' : '' }}" title="Lihat keranjang belanja Anda">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                </span>
                Keranjang
                <span id="cartBadgeSidebar" class="nav-badge" style="display: none; margin-left: auto; background: var(--primary); color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 100px; font-weight: 700;"></span>
            </a>
        </div>


    </nav>


</aside>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
function updateCartBadge() {
    var badge = document.getElementById('cartBadgeSidebar');
    if (!badge) return;
    if (localStorage.getItem('cart_seen')) return;
    var url = '{{ route("pelanggan.keranjang") }}';
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.count !== undefined) {
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? '' : 'none';
            }
        });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});

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
            if (window.innerWidth <= 768) closeSidebar();
        });
    });
});
</script>
