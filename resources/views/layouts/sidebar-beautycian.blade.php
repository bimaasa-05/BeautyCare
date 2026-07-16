<!-- Sidebar Beautycian -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="8" fill="#FF4F87" />
            <path d="M16 8C14 8 10 10 10 16C10 22 14 24 16 24C18 24 22 22 22 16C22 10 18 8 16 8Z" fill="white"
                opacity="0.9" />
        </svg>
        <span>BeautyCare</span>
    </div>

    <div class="sidebar-profile">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}&background=FF4F87&color=fff&size=44"
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
            <a href="#" class="nav-item" title="Lihat jadwal treatment hari ini">
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
            <a href="#" class="nav-item" title="Update status treatment pelanggan">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </span>
                Status Treatment
            </a>
            <a href="#" class="nav-item" title="Riwayat treatment yang telah selesai">
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
            <a href="#" class="nav-item" title="Data pelanggan yang pernah ditangani">
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
            <a href="#" class="nav-item" title="Laporan reservasi dan treatment">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </span>
                Laporan Reservasi
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" style="display: contents;">
            @csrf
            <button type="submit" class="nav-item" title="Keluar dari sistem"
                style="background: none; border: none; cursor: pointer; width: 100%; display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: inherit; font: inherit;">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                </span>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
