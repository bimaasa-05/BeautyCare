<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Treatment - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <style>
        .bc-actions form { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .filter-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .search-input-wrap input { max-width: 100%; box-sizing: border-box; }
        @media (max-width: 1200px) { .search-input-wrap input { width: 180px; } }
        @media (max-width: 768px) { .search-input-wrap input { width: 150px; } }
        @media (max-width: 430px) { .search-input-wrap input { width: 100%; } }

        .doc-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .doc-badge.has-doc { background: #D1FAE5; color: #059669; }
        .doc-badge.no-doc { background: #FEF3C7; color: #D97706; }

        /* ─── Filter custom select (pola pelanggan custom-select-wrap) ─── */
        .csw-pill { position: relative; min-width: 150px; }
        .csw-pill .custom-select-trigger {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            width: 100%; padding: 8px 16px; border-radius: 100px;
            border: 1.5px solid #E5E7EB; background: #fff; font-size: 12px;
            font-family: 'Poppins', sans-serif; color: var(--dark); cursor: pointer;
            transition: all 0.2s ease; user-select: none; box-sizing: border-box;
        }
        .csw-pill .custom-select-trigger:hover { border-color: #FFB6CD; }
        .csw-pill .custom-select-trigger.open { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1); }
        .csw-pill .custom-select-trigger .cst-placeholder { color: #bbb; }
        .csw-pill .custom-select-trigger .cst-text { color: var(--dark); }
        .csw-pill .custom-select-trigger .cst-arrow { font-size: 11px; color: #999; transition: transform 0.2s ease; flex-shrink: 0; }
        .csw-pill .custom-select-trigger.open .cst-arrow { transform: rotate(180deg); }
        .csw-pill .custom-select-dropdown {
            position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff;
            border: 1.5px solid var(--border); border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            z-index: 100; display: none; max-height: 200px; overflow-y: auto; padding: 4px;
        }
        .csw-pill .custom-select-dropdown.open { display: block; }
        .csw-pill .custom-select-dropdown.open-up { top: auto; bottom: calc(100% + 4px); }
        .csw-pill .custom-select-dropdown .csd-item {
            padding: 9px 12px; font-size: 12px; border-radius: 8px; cursor: pointer;
            transition: background 0.15s ease; color: var(--dark);
        }
        .csw-pill .custom-select-dropdown .csd-item:hover { background: #FFF0F5; }
        .csw-pill .custom-select-dropdown .csd-item.selected { background: #FFE4EC; color: var(--primary); font-weight: 600; }
        .csw-pill .custom-select-dropdown::-webkit-scrollbar { width: 5px; }
        .csw-pill .custom-select-dropdown::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
</head>

<body>
    @php
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Riwayat Treatment</h3>
                                <p>Arsip treatment yang telah selesai Anda kerjakan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="stat-change up">+{{ $total_selesai }}</span>
                        </div>
                        <div class="stat-value">{{ $total_selesai }}</div>
                        <div class="stat-label">Total Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <span class="stat-change up">+{{ $total_bulan_ini }}</span>
                        </div>
                        <div class="stat-value">{{ $total_bulan_ini }}</div>
                        <div class="stat-label">Bulan Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <span class="stat-change up">+{{ $total_minggu_ini }}</span>
                        </div>
                        <div class="stat-value">{{ $total_minggu_ini }}</div>
                        <div class="stat-label">Minggu Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 11 12 14 22 4"/></svg>
                            </div>
                            <span class="stat-change up">+{{ $total_dengan_dokumen }}</span>
                        </div>
                        <div class="stat-value">{{ $total_dengan_dokumen }}</div>
                        <div class="stat-label">Terdokumentasi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <span class="stat-change up">+{{ $total_selesai - $total_dengan_dokumen }}</span>
                        </div>
                        <div class="stat-value">{{ $total_selesai - $total_dengan_dokumen }}</div>
                        <div class="stat-label">Belum Dokumentasi</div>
                    </div>
                </div>

                <div class="booking-card-premium">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <div class="bc-title">Riwayat Treatment</div>
                                <div class="bc-subtitle">Daftar treatment yang telah selesai</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <form action="{{ route('beautycian.riwayat-treatment.index') }}" method="GET">
                                <div class="filter-group">
                                    <input type="hidden" name="filter_bulan" id="filterBulanInput" value="{{ request('filter_bulan') }}">
                                    <div class="csw-pill" id="filterBulanWrap">
                                        <div class="custom-select-trigger" id="filterBulanTrigger">
                                            <span class="cst-placeholder">Semua Bulan</span>
                                            <span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                                        </div>
                                        <div class="custom-select-dropdown" id="filterBulanDropdown">
                                            <div class="csd-item {{ request('filter_bulan') == '' ? 'selected' : '' }}" data-value="">Semua Bulan</div>
                                            @foreach($bulanList as $val => $label)
                                            <div class="csd-item {{ request('filter_bulan') == $val ? 'selected' : '' }}" data-value="{{ $val }}">{{ $label }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="search-input-wrap" style="display:inline-block;">
                                        <svg class="si-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        <input type="text" name="search" placeholder="Cari pelanggan..." value="{{ $search }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto"><table class="booking-table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Layanan</th>
                                    <th>Dokumentasi</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $item)
                                <tr>
                                    <td>
                                        <span class="booking-id-badge">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2h16v20l-4-2-4 2-4-2-4 2V2z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                            #BK{{ str_pad($item->id_booking, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td data-label="Pelanggan">
                                        <div class="therapist-cell">
                                            <div class="th-avatar"><img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block;"></div>
                                            <span class="th-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : '#' . $item->id_pelanggan }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            @php
                                                $durasiMenit = \App\Support\BookingSlot::durasiBooking($item);
                                                $jamSelesai = \Carbon\Carbon::parse($item->tanggal . ' ' . substr($item->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                                            @endphp
                                            <span class="font-mono">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} - {{ $jamSelesai }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Layanan">
                                        <span style="font-weight:500;">
                                            @if($item->detail && $item->detail->isNotEmpty())
                                                @foreach($item->detail as $dt)
                                                    {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                                @endforeach
                                            @else - @endif
                                        </span>
                                    </td>
                                    <td data-label="Dokumentasi">
                                        @if($item->riwayatTreatment)
                                        <span class="doc-badge has-doc">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            Ada
                                        </span>
                                        @else
                                        <span class="doc-badge no-doc">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Tidak Ada
                                        </span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi" style="text-align:center;">
                                        <a href="{{ route('beautycian.riwayat-treatment.show', $item->id_booking) }}" class="action-btn detail" title="Detail riwayat">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            </div>
                                            <h4>Belum Ada Riwayat</h4>
                                            <p>Belum ada treatment yang selesai.</p>
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
                            Menampilkan {{ $riwayat->firstItem() ?? 0 }}-{{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} riwayat
                        </div>
                        <div class="tf-pagination">
                            @if ($riwayat->onFirstPage())
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </span>
                            @else
                                <a href="{{ $riwayat->previousPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </a>
                            @endif

                            @foreach ($riwayat->getUrlRange(max(1, $riwayat->currentPage() - 2), min($riwayat->lastPage(), $riwayat->currentPage() + 2)) as $page => $url)
                                <a href="{{ $url }}" class="page-btn {{ $page == $riwayat->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            @if ($riwayat->hasMorePages())
                                <a href="{{ $riwayat->nextPageUrl() }}" class="page-btn">
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

    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
        function initFilterPill(inputId, wrapId, triggerId, dropdownId) {
            const input = document.getElementById(inputId);
            const wrap = document.getElementById(wrapId);
            const trigger = document.getElementById(triggerId);
            const dropdown = document.getElementById(dropdownId);
            if (!input || !wrap || !trigger || !dropdown) return;
            const placeholderText = trigger.querySelector('.cst-placeholder') ? trigger.querySelector('.cst-placeholder').textContent : 'Semua';

            function syncSelected() {
                dropdown.querySelectorAll('.csd-item').forEach(function(item) {
                    item.classList.toggle('selected', item.getAttribute('data-value') === input.value);
                });
            }

            function updateTrigger() {
                const selected = dropdown.querySelector('.csd-item.selected');
                if (selected) {
                    trigger.innerHTML = '<span class="cst-text">' + selected.textContent.trim() + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
                } else {
                    trigger.innerHTML = '<span class="cst-placeholder">' + placeholderText + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
                }
            }

            syncSelected();
            updateTrigger();

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                const open = dropdown.classList.contains('open');
                document.querySelectorAll('.custom-select-dropdown.open').forEach(function(d) {
                    if (d.id !== dropdownId) d.classList.remove('open');
                });
                document.querySelectorAll('.custom-select-trigger.open').forEach(function(t) {
                    if (t.id !== triggerId) t.classList.remove('open');
                });
                dropdown.classList.toggle('open');
                trigger.classList.toggle('open');
                if (dropdown.classList.contains('open')) {
                    const rect = dropdown.getBoundingClientRect();
                    const flip = rect.bottom > window.innerHeight - 8 && rect.top > window.innerHeight / 2;
                    dropdown.classList.toggle('open-up', flip);
                }
            });

            dropdown.addEventListener('click', function(e) {
                const item = e.target.closest('.csd-item');
                if (!item) return;
                input.value = item.getAttribute('data-value');
                syncSelected();
                updateTrigger();
                dropdown.classList.remove('open');
                trigger.classList.remove('open');
                if (input.closest('form')) input.closest('form').submit();
            });

            document.addEventListener('click', function() {
                dropdown.classList.remove('open');
                trigger.classList.remove('open');
            });
        }

        initFilterPill('filterBulanInput', 'filterBulanWrap', 'filterBulanTrigger', 'filterBulanDropdown');
    </script>
</body>

</html>
