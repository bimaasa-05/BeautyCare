<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pelanggan - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .search-input-plg {
            padding: 9px 16px 9px 36px;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            background: #FAFAFA;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            width: 220px;
            max-width: 100%;
            transition: all 0.2s ease;
            outline: none;
            box-sizing: border-box;
        }
        .search-input-plg:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1);
        }
        .mini-list-card { background: #fff; border-radius: 16px; border: 1px solid var(--border); padding: 20px; }
        .mini-list-card .ml-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .mini-list-card .ml-header h4 { font-size: 13px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .mini-list-card .ml-header h4 svg { width: 16px; height: 16px; color: var(--primary); }
        .ml-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
        .ml-item:last-child { border-bottom: none; }
        .ml-item .ml-rank { width: 22px; height: 22px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; flex-shrink: 0; }
        .ml-item .ml-rank.gold { background: #FEF3C7; color: #D97706; }
        .ml-item .ml-rank.silver { background: #F1F5F9; color: #64748B; }
        .ml-item .ml-rank.bronze { background: #FDE8E8; color: #DC2626; }
        .ml-item .ml-rank.normal { background: #F8F9FC; color: #94A3B8; }
        .ml-item .ml-info { flex: 1; min-width: 0; }
        .ml-item .ml-info .ml-name { font-size: 12px; font-weight: 600; color: var(--dark); }
        .ml-item .ml-info .ml-count { font-size: 11px; color: var(--gray); }
        .ml-item .ml-value { font-size: 12px; font-weight: 700; color: var(--primary); }

        .dashboard-grid-plg { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 24px; }
        @media (max-width: 900px) { .dashboard-grid-plg { grid-template-columns: 1fr; } }

        .donut-wrap { display: flex; flex-direction: column; align-items: center; position: relative; }
        .donut-wrap canvas { max-height: 170px; max-width: 170px; }
        .donut-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }
        .donut-center-text .dct-value { font-size: 28px; font-weight: 800; color: var(--primary); line-height: 1; }
        .donut-center-text .dct-label { font-size: 10px; color: var(--gray); font-weight: 500; margin-top: 2px; }

        @media (max-width: 768px) {
            .search-input-plg { width: 150px; }
        }
        @media (max-width: 430px) {
            .search-input-plg { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Riwayat Pelanggan</h3>
                                <p>Informasi lengkap pelanggan yang pernah ditangani</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $total_pelanggan }}</div>
                        <div class="stat-label">Total Pelanggan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $total_member }}</div>
                        <div class="stat-label">Member</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $pelanggan_baru_bulan_ini }}</div>
                        <div class="stat-label">Pelanggan Baru</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $total_treatment_selesai }}</div>
                        <div class="stat-label">Treatment Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $total_reservasi }}</div>
                        <div class="stat-label">Total Reservasi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $rata_rata_treatment }}</div>
                        <div class="stat-label">Rata-rata Treatment</div>
                    </div>
                </div>

                <div class="dashboard-grid-plg">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Pertumbuhan Pelanggan</h3>
                            <div class="chart-actions">
                                <span style="font-size:11px;color:var(--gray);">Tahun {{ now()->year }}</span>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPelanggan" height="280"></canvas>
                        </div>
                    </div>
                    <div class="mini-charts">
                        <div class="mini-list-card">
                            <div class="ml-header">
                                <h4>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                    Layanan Favorit
                                </h4>
                            </div>
                            <div>
                                @forelse($layananFavorit as $i => $item)
                                <div class="ml-item">
                                    <div class="ml-rank {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : 'normal')) }}">#{{ $i + 1 }}</div>
                                    <div class="ml-info">
                                        <div class="ml-name">{{ $item->layanan->nm_layanan ?? '-' }}</div>
                                        <div class="ml-count">{{ $item->total }} kali dipesan</div>
                                    </div>
                                    <div class="ml-value">{{ $item->total }}x</div>
                                </div>
                                @empty
                                <div style="padding:20px;text-align:center;color:var(--gray);font-size:12px;">Belum ada data</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="mini-list-card" style="margin-top:16px;">
                            <div class="ml-header">
                                <h4>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Komposisi Pelanggan
                                </h4>
                                <span style="font-size:11px;color:var(--gray);background:#F8F9FC;padding:2px 10px;border-radius:100px;">Total {{ $total_pelanggan }}</span>
                            </div>
                            <div class="donut-wrap">
                                <canvas id="donutMember"></canvas>
                                <div class="donut-center-text">
                                    <div class="dct-value">{{ $total_pelanggan > 0 ? round(($total_member / $total_pelanggan) * 100) : 0 }}%</div>
                                    <div class="dct-label">Member</div>
                                </div>
                                <div style="display:flex;gap:20px;margin-top:12px;font-size:11px;">
                                    <span style="display:flex;align-items:center;gap:6px;background:#FFF8FA;padding:4px 12px;border-radius:100px;">
                                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#FF4F87;"></span>
                                        Member <strong>{{ $total_member }}</strong>
                                    </span>
                                    <span style="display:flex;align-items:center;gap:6px;background:#F8F9FC;padding:4px 12px;border-radius:100px;">
                                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#E5E7EB;"></span>
                                        Non Member <strong>{{ $total_non_member }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-card-premium" style="margin-top:24px;">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </div>
                            <div>
                                <div class="bc-title">Daftar Pelanggan</div>
                                <div class="bc-subtitle">Semua data pelanggan yang terdaftar</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <form action="{{ route('beautycian.pelanggan.index') }}" method="GET">
                                <div class="filter-group">
                                    <div class="search-input-wrap">
                                        <svg class="si-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        <input type="text" name="search" placeholder="Cari pelanggan..." value="{{ $search }}" class="search-input-plg">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="overflow-x:auto;">
                        <div class="overflow-x-auto"><table class="booking-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Member</th>
                                    <th>Catatan Alergi</th>
                                    <th>Status</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggan as $p)
                                <tr>
                                    <td>
                                        <span class="booking-id-badge">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2h16v20l-4-2-4 2-4-2-4 2V2z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                            #P{{ str_pad($p->id_pelanggan, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td data-label="Foto">
                                        <div class="therapist-cell">
                                            <div class="th-avatar" style="background:#FFE5EF;color:#FF4F87;font-weight:600;">
                                                @if($p->foto)
                                                    <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nm_pelanggan }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;display:block;">
                                                @else
                                                    {{ substr($p->nm_pelanggan, 0, 1) }}
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Nama">
                                        <span class="th-name">{{ $p->nm_pelanggan }}</span>
                                    </td>
                                    <td data-label="No. HP">
                                        <div style="display:flex;align-items:center;gap:6px;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                            <span>{{ $p->no_hp ?: '-' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Email">
                                        <div style="display:flex;align-items:center;gap:6px;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                            <span>{{ $p->email ?: '-' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Alamat">
                                        <span class="catatan-text" title="{{ $p->alamat }}">
                                            {{ $p->alamat ?: '-' }}
                                        </span>
                                    </td>
                                    <td data-label="Member">
                                        @if($p->membership)
                                            <span class="status-badge" style="background:#D1FAE5;color:#059669;border:none;">
                                                <span class="sb-dot" style="background:#059669;"></span>
                                                {{ $p->membership->nm_member }}
                                            </span>
                                        @else
                                            <span style="color:#999;font-size:12px;">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Catatan Alergi">
                                        <span class="catatan-text {{ !$p->catatan_alergi ? 'no-catatan' : '' }}" title="{{ $p->catatan_alergi }}">
                                            {{ $p->catatan_alergi ?: 'Tidak ada' }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        @php
                                            $statusLabels = [
                                                'dikonfirmasi' => 'Terjadwal',
                                                'diproses'     => 'Diproses',
                                                'selesai'      => 'Selesai',
                                                'dibatalkan'   => 'Dibatalkan',
                                            ];
                                        @endphp
                                        @if($p->status && isset($statusLabels[$p->status]))
                                            <span class="status-badge {{ $p->status }}">
                                                <span class="sb-dot"></span>
                                                {{ $statusLabels[$p->status] }}
                                            </span>
                                        @else
                                            <span style="color:#999;font-size:12px;">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Bergabung">
                                        <div style="display:flex;align-items:center;gap:6px;white-space:nowrap;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            <span>{{ $p->created_at ? \Carbon\Carbon::parse($p->created_at)->isoFormat('D MMM YYYY') : '-' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="18" y1="21" x2="18" y2="12"/><line x1="15" y1="18" x2="21" y2="18"/></svg>
                                            </div>
                                            <h4>Belum Ada Pelanggan</h4>
                                            <p>Tidak ada data pelanggan yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table></div>
                    </div>

                    <div class="table-footer">
                        <div class="tf-info">
                            <span class="tf-dot"></span>
                            Menampilkan {{ $pelanggan->firstItem() ?? 0 }}-{{ $pelanggan->lastItem() ?? 0 }} dari {{ $pelanggan->total() }} pelanggan
                        </div>
                        <div class="tf-pagination">
                            @if ($pelanggan->onFirstPage())
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </span>
                            @else
                                <a href="{{ $pelanggan->previousPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </a>
                            @endif

                            @foreach ($pelanggan->getUrlRange(max(1, $pelanggan->currentPage() - 2), min($pelanggan->lastPage(), $pelanggan->currentPage() + 2)) as $page => $url)
                                <a href="{{ $url }}" class="page-btn {{ $page == $pelanggan->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            @if ($pelanggan->hasMorePages())
                                <a href="{{ $pelanggan->nextPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </a>
                            @else
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const animOpts = {
        duration: 1200,
        easing: 'easeOutQuart'
    };

    function setupClickReplay(chart) {
        chart.options.onClick = function() {
            this.reset();
            this.update();
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        var lineCtx = document.getElementById('chartPelanggan');
        if (!lineCtx) return;
        var lineLabels = @json($chartBulan);
        var lineData = @json($chartPelanggan);

        var gradient = lineCtx.getContext('2d').createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(255, 79, 135, 0.25)');
        gradient.addColorStop(1, 'rgba(255, 79, 135, 0.01)');

        var lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Pelanggan',
                    data: lineData,
                    borderColor: '#FF4F87',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FF4F87',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animOpts,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        borderColor: '#FCE7F3',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 12 }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#F3E8F5', borderDash: [3, 3] },
                        ticks: { maxTicksLimit: 6, stepSize: 1 }
                    }
                }
            }
        });
        setupClickReplay(lineChart);

        var donutCtx = document.getElementById('donutMember');
        if (donutCtx) {
            var donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Member', 'Non Member'],
                    datasets: [{
                        data: [{{ $total_member }}, {{ $total_non_member }}],
                        backgroundColor: ['#FF4F87', '#E5E7EB'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '75%',
                    animation: {
                        duration: 1000,
                        easing: 'easeOutBack',
                        animateRotate: true
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1F2937',
                            bodyColor: '#4B5563',
                            borderColor: '#FCE7F3',
                            borderWidth: 1,
                            padding: 8,
                            cornerRadius: 8,
                        }
                    }
                }
            });
            setupClickReplay(donutChart);
        }
    });
    </script>
    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
