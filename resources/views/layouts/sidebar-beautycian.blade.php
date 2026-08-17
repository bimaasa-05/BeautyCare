<!-- Sidebar Beautycian -->
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
        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama) . '&background=FF4F87&color=fff&size=44' }}"
            alt="Profile">
        <div class="sp-info">
            <h4>{{ auth()->user()->nama }}</h4>
            <span class="sp-badge">{{ auth()->user()->role }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Utama</div>
            <a href="{{ route('beautycian.dashboard') }}"
                class="nav-item {{ request()->routeIs('beautycian.dashboard') ? 'active' : '' }}"
                title="Overview jadwal dan aktifitas treatment">
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
            <div class="nav-section-title">Treatment</div>
            <a href="{{ route('beautycian.jadwal-treatment.index') }}" class="nav-item {{ request()->routeIs('beautycian.jadwal-treatment.index') ? 'active' : '' }}" title="Lihat jadwal treatment hari ini">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                Jadwal Treatment
            </a>
            <a href="{{ route('beautycian.status-treatment.index') }}" class="nav-item {{ request()->routeIs('beautycian.status-treatment.index') ? 'active' : '' }}" title="Update status treatment pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </span>
                Status Treatment
            </a>
            <a href="{{ route('beautycian.riwayat-treatment.index') }}" class="nav-item {{ request()->routeIs('beautycian.riwayat-treatment.*') ? 'active' : '' }}" title="Riwayat treatment yang telah selesai">
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
            <div class="nav-section-title">Pelanggan</div>
            <a href="{{ route('beautycian.pelanggan.index') }}" class="nav-item {{ request()->routeIs('beautycian.pelanggan.index') ? 'active' : '' }}" title="Data pelanggan yang pernah ditangani">
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
            <div class="nav-section-title">Konsultasi</div>
            <a href="{{ route('beautycian.konsultasi.index') }}" class="nav-item {{ request()->routeIs('beautycian.konsultasi*') ? 'active' : '' }}" title="Konsultasi member yang ditugaskan ke Anda">
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
            <div class="nav-section-title">Laporan</div>
            <a href="{{ route('beautycian.laporan-reservasi.index') }}" class="nav-item {{ request()->routeIs('beautycian.laporan-reservasi.index') ? 'active' : '' }}" title="Laporan reservasi dan treatment">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Laporan Reservasi
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Bantuan</div>
            <a href="{{ route('beautycian.laporan-masalah.index') }}"
                class="nav-item {{ request()->routeIs('beautycian.laporan-masalah*') ? 'active' : '' }}"
                title="Laporkan masalah atau kendala yang Anda temui">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </span>
                Laporkan Masalah
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
