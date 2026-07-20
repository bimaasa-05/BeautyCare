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

        <div class="notif-wrapper" style="position:relative;">
            <button class="navbar-icon-btn notif-btn" id="notifBell" aria-label="Notifications">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <span class="notif-dot" id="notifBadge"></span>
            </button>
            <div class="notif-dropdown" id="notifDropdown"
                style="display:none;position:absolute;top:calc(100% + 8px);right:0;width:380px;max-height:480px;background:#fff;border-radius:16px;box-shadow:0 10px 40px rgba(0,0,0,0.12);z-index:999;overflow:hidden;border:1px solid rgba(0,0,0,0.04);">
                <div style="padding:16px 20px;border-bottom:1px solid #f1f1f1;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:14px;font-weight:700;color:#1e293b;">Notifikasi</span>
                    <button id="markAllRead" style="font-size:11px;color:#FF4F87;background:none;border:none;cursor:pointer;font-weight:600;">Tandai Dibaca</button>
                </div>
                <div id="notifList" style="overflow-y:auto;max-height:380px;">
                    <div style="padding:30px 20px;text-align:center;color:#94a3b8;font-size:13px;">Memuat...</div>
                </div>
            </div>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bell = document.getElementById('notifBell');
    const dropdown = document.getElementById('notifDropdown');
    const badge = document.getElementById('notifBadge');
    const list = document.getElementById('notifList');
    const markAllBtn = document.getElementById('markAllRead');

    if (!bell) return;

    function loadNotif() {
        fetch('/notif/get')
            .then(r => r.json())
            .then(d => {
                if (d.unread_count > 0) {
                    badge.textContent = '+' + d.unread_count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }

                if (!dropdown.style.display || dropdown.style.display === 'none') return;

                if (d.notifications.length === 0) {
                    list.innerHTML = '<div style="padding:40px 20px;text-align:center;color:#94a3b8;"><i class="fa-regular fa-bell-slash" style="font-size:24px;display:block;margin-bottom:8px;"></i><span style="font-size:13px;">Tidak ada notifikasi</span></div>';
                    return;
                }

                let html = '';
                d.notifications.forEach(function(n) {
                    const icons = { Booking: 'fa-regular fa-calendar-check', Promo: 'fa-solid fa-tags', Stok: 'fa-solid fa-boxes', Transaksi: 'fa-regular fa-credit-card', Lainnya: 'fa-regular fa-bell' };
                    const icon = icons[n.type] || icons.Lainnya;
                    const colors = { Booking: '#3B82F6', Promo: '#F59E0B', Stok: '#10B981', Transaksi: '#FF4F87', Lainnya: '#8B5CF6' };
                    const color = colors[n.type] || colors.Lainnya;
                    const bg = n.status === 0 ? '#FFF5F8' : 'transparent';
                    html += '<a href="/notif/' + n.id + '/read" class="notif-item" style="display:flex;gap:12px;padding:14px 20px;text-decoration:none;background:' + bg + ';border-bottom:1px solid #f8f8f8;transition:background 0.2s;" onmouseover="this.style.background=\'#FFF5F8\'" onmouseout="this.style.background=\'' + bg + '\'">';
                    html += '<div style="width:36px;height:36px;border-radius:10px;background:' + color + '15;color:' + color + ';display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;"><i class="' + icon + '"></i></div>';
                    html += '<div style="flex:1;min-width:0;">';
                    html += '<div style="font-size:13px;font-weight:600;color:#1e293b;margin-bottom:2px;">' + n.judul + '</div>';
                    html += '<div style="font-size:12px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + n.isi + '</div>';
                    html += '<div style="font-size:11px;color:#94a3b8;margin-top:3px;">' + n.waktu + '</div>';
                    html += '</div></a>';
                });
                list.innerHTML = html;
            })
            .catch(function() {});
    }

    bell.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = dropdown.style.display !== 'none';
        dropdown.style.display = isOpen ? 'none' : 'block';
        if (!isOpen) loadNotif();
    });

    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && e.target !== bell) {
            dropdown.style.display = 'none';
        }
    });

    if (markAllBtn) {
        markAllBtn.addEventListener('click', function() {
            fetch('/notif/mark-all-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content, 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(function() { loadNotif(); });
        });
    }

    setInterval(loadNotif, 30000);
    loadNotif();
});
</script>
