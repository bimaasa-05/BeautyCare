<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konsultasi Saya - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
    .sidebar-overlay.active { display: block; }
    @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }
    .page-header-premium::before {
        content: ''; position: absolute; top: -60px; right: -60px; width: 200px; height: 200px;
        border-radius: 50%; background: radial-gradient(circle, rgba(255,79,135,0.12) 0%, transparent 70%);
    }
    .page-header-premium .ph-content { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; }
    .page-header-premium .ph-left { display: flex; align-items: center; gap: 16px; }
    .page-header-premium .ph-icon-wrap {
        width: 52px; height: 52px; border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 20px; box-shadow: 0 8px 20px rgba(255, 79, 135, 0.25);
    }
    .page-header-premium .ph-text h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin: 0; }
    .page-header-premium .ph-text p { font-size: 13px; color: var(--gray); margin: 4px 0 0; }
    .btn-primary-rounded {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, var(--primary), #FF6B9C);
        color: #fff; font-weight: 600; font-size: 13px;
        padding: 11px 22px; border-radius: 100px; border: none; cursor: pointer;
        box-shadow: 0 6px 16px rgba(255, 79, 135, 0.3);
        transition: all .2s ease; text-decoration: none;
    }
    .btn-primary-rounded:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(255, 79, 135, 0.4); color: #fff; }

    .kuota-card {
        background: #fff; border: 1px solid var(--border); border-radius: 16px;
        padding: 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;
    }
    .kuota-icon {
        width: 46px; height: 46px; border-radius: 13px; flex-shrink: 0;
        background: linear-gradient(135deg, #FEE7EF, #FFD6E6);
        display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 18px;
    }
    .kuota-text h4 { font-size: 14px; font-weight: 700; color: var(--dark); margin: 0 0 2px; }
    .kuota-text p { font-size: 12px; color: var(--gray); margin: 0; }
    .kuota-bar {
        margin-top: 8px; height: 6px; border-radius: 100px; background: #F1F5F9; overflow: hidden; max-width: 260px;
    }
    .kuota-bar span { display: block; height: 100%; border-radius: 100px; background: linear-gradient(90deg, var(--primary), #FF7BA6); }

    .booking-card-premium {
        background: #fff; border: 1px solid var(--border); border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04); overflow: hidden;
    }
    .bc-header {
        display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
        padding: 20px 24px; border-bottom: 1px solid var(--border);
    }
    .bc-title-wrap { display: flex; align-items: center; gap: 12px; }
    .bc-title-icon {
        width: 38px; height: 38px; border-radius: 12px; background: #FEE7EF;
        display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 15px;
    }
    .bc-title { font-size: 15px; font-weight: 700; color: var(--dark); }
    .bc-subtitle { font-size: 12px; color: var(--gray); margin-top: 2px; }
    .bc-actions { display: flex; align-items: center; gap: 10px; }
    .search-input-wrap { position: relative; }
    .search-input-wrap .si-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--gray); }
    .search-input-wrap input {
        border: 1px solid var(--border); border-radius: 100px; padding: 9px 14px 9px 32px;
        font-size: 12px; outline: none; width: 220px; background: #FAFAFA; transition: all .2s;
    }
    .search-input-wrap input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255,79,135,0.08); }

    .booking-table { width: 100%; border-collapse: collapse; }
    .booking-table thead th {
        background: #FAFAFC; font-size: 11px; text-transform: uppercase; letter-spacing: .5px;
        color: var(--gray); font-weight: 600; padding: 13px 18px; text-align: left; border-bottom: 1px solid var(--border);
    }
    .booking-table tbody td { padding: 15px 18px; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--dark); vertical-align: middle; }
    .booking-table tbody tr:last-child td { border-bottom: none; }
    .booking-table tbody tr:hover { background: #FFF9FB; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600;
        padding: 5px 12px; border-radius: 100px;
    }
    .status-badge.menunggu { background: #FEF3C7; color: #B45309; }
    .status-badge.dikonfirmasi { background: #DBEAFE; color: #1D4ED8; }
    .status-badge.selesai { background: #D1FAE5; color: #047857; }
    .status-badge.ditolak { background: #FEE2E2; color: #B91C1C; }
    .sb-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .topik-cell { max-width: 260px; }
    .topik-cell .tk { font-weight: 600; font-size: 13px; color: var(--dark); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .topik-cell .tp { font-size: 11px; color: var(--gray); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .mode-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 100px; }
    .mode-badge.online { background: #F3E8FF; color: #7E22CE; }
    .mode-badge.offline { background: #E0F2FE; color: #0369A1; }

    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state .es-illustration {
        width: 72px; height: 72px; margin: 0 auto 14px; border-radius: 22px;
        background: linear-gradient(135deg, #FEE7EF, #FFD6E6);
        display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 28px;
    }
    .empty-state h4 { font-size: 15px; font-weight: 700; color: var(--dark); margin: 0 0 6px; }
    .empty-state p { font-size: 12px; color: var(--gray); margin: 0 0 16px; }
    .btn-empty {
        display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        background: linear-gradient(135deg, var(--primary), #FF6B9C); color: #fff;
        font-size: 12px; font-weight: 600; padding: 10px 20px; border-radius: 100px;
        box-shadow: 0 6px 16px rgba(255,79,135,0.3); transition: all .2s;
    }
    .btn-empty:hover { transform: translateY(-2px); color: #fff; }

    .table-footer { display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; border-top: 1px solid var(--border); }
    .tf-info { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--gray); }
    .tf-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--primary); }

    .alert-premium {
        display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 14px;
        font-size: 13px; margin-bottom: 16px;
    }
    .alert-premium.success { background: #D1FAE5; color: #047857; border: 1px solid #A7F3D0; }
    .alert-premium.error { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
    .alert-premium.info { background: #DBEAFE; color: #1D4ED8; border: 1px solid #BFDBFE; }
    .alert-premium .alert-icon { font-size: 15px; }

    .wa-link { color: #25D366; font-size: 16px; text-decoration: none; transition: all .2s; }
    .wa-link:hover { transform: scale(1.15); display: inline-block; }

    @media (max-width: 768px) {
        .booking-table thead { display: none; }
        .booking-table, .booking-table tbody, .booking-table tr, .booking-table td { display: block; width: 100%; }
        .booking-table tr { padding: 16px; border-bottom: 1px solid var(--border); }
        .booking-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; font-size: 13px; }
        .booking-table tbody td::before { content: attr(data-label); font-weight: 600; color: var(--gray); font-size: 11px; text-transform: uppercase; }
        .booking-table tbody td:first-child { padding-left: 0; }
        .page-header-premium { padding: 22px 20px; }
        .search-input-wrap input { width: 100%; }
        .search-input-wrap { flex: 1 1 100%; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-regular fa-comments"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Konsultasi Saya</h3>
                                <p>Konsultasi gratis dengan beautycian, khusus member</p>
                            </div>
                        </div>
                        @if($sisaKuota > 0)
                        <a href="{{ route('pelanggan.konsultasi.create') }}" class="btn-primary-rounded">
                            <i class="fa-solid fa-plus"></i> Konsultasi Baru
                        </a>
                        @endif
                    </div>
                </div>

                <div class="kuota-card">
                    <div class="kuota-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div class="kuota-text">
                        <h4>{{ $memberLabel }}</h4>
                        <p>Sisa kuota konsultasi bulan ini: <strong>{{ $sisaKuota }}</strong> dari {{ $totalKuota }} konsultasi</p>
                        @if($totalKuota > 0)
                        <div class="kuota-bar">
                            <span style="width: {{ min(100, round(($totalKuota - $sisaKuota) / $totalKuota * 100)) }}%;"></span>
                        </div>
                        @endif
                    </div>
                </div>

                @if(session('message'))
                <div class="alert-premium success">
                    <div class="alert-icon"><i class="fa-regular fa-circle-check"></i></div>
                    {{ session('message') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert-premium error">
                    <div class="alert-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    {{ session('error') }}
                </div>
                @endif

                <div class="booking-card-premium">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon"><i class="fa-solid fa-list"></i></div>
                            <div>
                                <div class="bc-title">Daftar Konsultasi</div>
                                <div class="bc-subtitle">Riwayat konsultasi Anda bersama beautycian</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <div class="search-input-wrap">
                                <i class="fa-solid fa-search si-icon"></i>
                                <input type="text" id="searchKonsultasi" placeholder="Cari konsultasi..." oninput="cariKonsultasi()">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Terapis</th>
                                    <th>Topik</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($konsultasi as $item)
                                <tr>
                                    <td data-label="Tanggal">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-gray-300 text-[11px]"></i>
                                            <span>{{ str_replace(':', '.', substr($item->jam, 0, 5)) }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Terapis">
                                        <div class="therapist-cell">
                                            <div class="th-avatar" style="background:#FEE7EF;color:var(--primary);font-weight:700;">
                                                {{ $item->karyawan ? substr($item->karyawan->nama, 0, 1) : '?' }}
                                            </div>
                                            <span class="th-name">{{ $item->karyawan ? $item->karyawan->nama : 'Menunggu penugasan' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Topik">
                                        <div class="topik-cell">
                                            <div class="tk">{{ $item->topik }}</div>
                                            <div class="tp">{{ $item->pesan ?: 'Tanpa keterangan' }}</div>
                                        </div>
                                    </td>
                                    <td data-label="Mode">
                                        <span class="mode-badge {{ $item->mode }}">
                                            <i class="fa-solid {{ $item->mode === 'online' ? 'fa-globe' : 'fa-store' }}"></i>
                                            {{ ucfirst($item->mode) }}
                                            @if($item->mode === 'online' && $item->media)
                                            <span style="opacity:.75;">· {{ $item->media === 'whatsapp_chat' ? 'Chat' : 'Video Call' }}</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $item->status }}">
                                            <span class="sb-dot"></span>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <i class="fa-regular fa-comments"></i>
                                            </div>
                                            <h4>Belum Ada Konsultasi</h4>
                                            <p>Ajukan konsultasi pertama Anda dan dapatkan saran dari beautycian profesional.</p>
                                            @if($sisaKuota > 0)
                                            <a href="{{ route('pelanggan.konsultasi.create') }}" class="btn-empty">
                                                <i class="fa-solid fa-plus"></i> Konsultasi Baru
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <div class="tf-info">
                            <span class="tf-dot"></span>
                            Menampilkan {{ $konsultasi->count() }} konsultasi
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function cariKonsultasi() {
        var keyword = document.getElementById('searchKonsultasi').value.toLowerCase().trim();
        var rows = document.querySelectorAll('.booking-table tbody tr');
        var visible = 0;
        rows.forEach(function(row) {
            if (row.querySelector('.empty-state')) return;
            var text = row.textContent.toLowerCase();
            var match = keyword === '' || text.includes(keyword);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        var infoEl = document.querySelector('.tf-info');
        if (infoEl) {
            infoEl.innerHTML = '<span class="tf-dot"></span> Menampilkan ' + visible + ' konsultasi';
        }
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
