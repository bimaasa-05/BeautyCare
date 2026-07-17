@php
use Illuminate\Support\Str;

if (!isset($pageTitle)) {
    $routeName = request()->route()?->getName();
    $pageTitle = 'Dashboard';

    if ($routeName) {
        $parts = explode('.', $routeName);
        $last = end($parts);

        $actionLabels = [
            'index' => '',
            'create' => 'Tambah',
            'edit' => 'Edit',
            'show' => 'Detail',
        ];

        if ($last === 'dashboard') {
            $roleLabels = ['admin' => 'Admin', 'kasir' => 'Kasir', 'beautycian' => 'Beautycian', 'pelanggan' => 'Pelanggan'];
            $role = $parts[0] ?? '';
            $pageTitle = 'Dashboard ' . ($roleLabels[$role] ?? Str::title($role));
        } elseif ($routeName === 'pelanggan.booking') {
            $pageTitle = 'Booking Saya';
        } elseif (isset($actionLabels[$last]) && count($parts) >= 2) {
            $entity = $parts[count($parts) - 2];
            $name = Str::title(str_replace(['-', '_'], ' ', $entity));
            $pageTitle = $actionLabels[$last] ? $actionLabels[$last] . ' ' . $name : $name;
        } else {
            $pageTitle = Str::title(str_replace(['-', '_'], ' ', $last));
        }
    }
}
@endphp

<!-- Navbar Top -->
<header class="navbar-top">
    <div class="left-section">
        <button class="sidebar-toggle" aria-label="Toggle sidebar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>
        <div>
            <h2>{{ $pageTitle }}</h2>
            <span class="page-title">Selamat datang, {{ auth()->user()->nama }}!</span>
        </div>
    </div>

    <div class="right-section">
        <div class="search-box">
            <span class="search-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </span>
            <input type="text" placeholder="Cari sesuatu..." aria-label="Search">
        </div>

        <span class="date-display">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            <span id="currentDate"></span>
        </span>

        <button class="navbar-icon-btn notif-btn" aria-label="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            <span class="notif-dot"></span>
        </button>

        <div class="user-profile">
            <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('assets/img/default-avatar.png') }}"
                alt="Profile">
            <div class="up-info">
                <h4>{{ auth()->user()->nama }}</h4>

                <span class="sp-badge">{{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </div>
    @include('partials.toast')
</header>
