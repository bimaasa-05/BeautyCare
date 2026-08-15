<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal Treatment - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
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
    </style>
</head>

<body>
    @php
        $statusLabels = [
            'dikonfirmasi' => 'Terjadwal',
            'diproses'     => 'Diproses',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><polyline points="9 16 11 18 15 14"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Jadwal Treatment</h3>
                                <p>Kelola semua jadwal treatment yang akan Anda tangani</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $total_jadwal }}</span>
                        </div>
                        <div class="stat-value">{{ $total_jadwal }}</div>
                        <div class="stat-label">Total Jadwal</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $dikonfirmasi }}</span>
                        </div>
                        <div class="stat-value">{{ $dikonfirmasi }}</div>
                        <div class="stat-label">Terjadwal</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $diproses }}</span>
                        </div>
                        <div class="stat-value">{{ $diproses }}</div>
                        <div class="stat-label">Diproses</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $selesai }}</span>
                        </div>
                        <div class="stat-value">{{ $selesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                    <line x1="9" y1="9" x2="15" y2="15" />
                                </svg>
                            </div>
                            <span class="stat-change down">-{{ $dibatalkan }}</span>
                        </div>
                        <div class="stat-value">{{ $dibatalkan }}</div>
                        <div class="stat-label">Dibatalkan</div>
                    </div>
                </div>

                <div class="booking-card-premium">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </div>
                            <div>
                                <div class="bc-title">Jadwal Treatment</div>
                                <div class="bc-subtitle">Daftar jadwal treatment yang harus ditangani</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <form action="{{ route('beautycian.jadwal-treatment.index') }}" method="GET">
                                <div class="filter-group">
                                    <select name="filter_status" onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="dikonfirmasi" {{ request('filter_status') == 'dikonfirmasi' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="diproses" {{ request('filter_status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    </select>
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
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwal as $item)
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
                                            <span class="th-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : 'Pelanggan #'.$item->id_pelanggan }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        <div style="display:flex;flex-direction:column;align-items:center;gap:2px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            @if($item->status === 'diproses')
                                                @php
                                                    $jamMulai = \Carbon\Carbon::parse($item->jam)->format('H:i');
                                                    $durasiMenit = $item->durasi_menit;
                                                    $jamSelesaiEstimasi = \Carbon\Carbon::parse($item->tanggal . ' ' . substr($item->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                                                    
                                                    $adaAktual = $item->jam_mulai_aktual;
                                                    $mulaiAktual = $adaAktual ? \Carbon\Carbon::parse($item->jam_mulai_aktual)->format('H:i') : null;
                                                    $bedaWaktu = $adaAktual && $mulaiAktual !== $jamMulai;
                                                    
                                                    $selesaiAktual = null;
                                                    if ($adaAktual) {
                                                        $mulaiCarbon = \Carbon\Carbon::parse($item->jam_mulai_aktual);
                                                        $selesaiEstCarbon = $mulaiCarbon->copy()->addMinutes($durasiMenit);
                                                        $selesaiAktual = $selesaiEstCarbon->format('H:i');
                                                    }
                                                @endphp
                                                <span class="font-mono text-xs">{{ $jamMulai }}</span>
                                                <span class="text-gray-400 text-xs">-</span>
                                                <span class="font-mono text-xs text-gray-500">{{ $jamSelesaiEstimasi }}</span>
                                                
                                                @if ($bedaWaktu)
                                                    <div class="countdown-row" data-akhir="{{ $item->estimasi_selesai }}" style="display:flex;align-items:center;gap:4px;margin-top:2px;">
                                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                        <span class="countdown-value font-mono text-xs font-bold text-amber-600">--:--:--</span>
                                                    </div>
                                                    <div style="font-size:10px;color:#f59e0b;font-weight:600;">Mulai: {{ $mulaiAktual }} · Est. Selesai: {{ $selesaiAktual }}</div>
                                                @else
                                                    <div class="countdown-row" data-akhir="{{ $item->estimasi_selesai }}" style="display:flex;align-items:center;gap:4px;">
                                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                        <span class="countdown-value font-mono text-xs font-bold text-violet-600">--:--:--</span>
                                                    </div>
                                                    <div style="font-size:10px;color:#8b5cf6;font-weight:600;">Waktu: {{ $durasiMenit >= 60 ? (($durasiMenit % 60) ? floor($durasiMenit / 60) . ' jam ' . ($durasiMenit % 60) . ' menit' : ($durasiMenit / 60) . ' jam') : $durasiMenit . ' menit' }}</div>
                                                @endif
                                            @else
                                                <span>{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="Layanan">
                                        <span style="font-weight:500;">
                                            @if($item->detail && $item->detail->isNotEmpty())
                                                @foreach($item->detail as $dt)
                                                    {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $item->status }}">
                                            <span class="sb-dot"></span>
                                            {{ $statusLabels[$item->status] ?? ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Catatan">
                                        <span class="catatan-text {{ !$item->catatan ? 'no-catatan' : '' }}" title="{{ $item->catatan }}">
                                            {{ $item->catatan ?: 'Tidak ada catatan' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="10" y1="14" x2="14" y2="18"/><line x1="14" y1="14" x2="10" y2="18"/></svg>
                                            </div>
                                            <h4>Belum Ada Jadwal</h4>
                                            <p>Tidak ada jadwal treatment yang perlu ditangani saat ini.</p>
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
                            Menampilkan {{ $jadwal->firstItem() ?? 0 }}-{{ $jadwal->lastItem() ?? 0 }} dari {{ $jadwal->total() }} jadwal
                        </div>
                        <div class="tf-pagination">
                            @if ($jadwal->onFirstPage())
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </span>
                            @else
                                <a href="{{ $jadwal->previousPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </a>
                            @endif

                            @foreach ($jadwal->getUrlRange(max(1, $jadwal->currentPage() - 2), min($jadwal->lastPage(), $jadwal->currentPage() + 2)) as $page => $url)
                                <a href="{{ $url }}" class="page-btn {{ $page == $jadwal->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            @if ($jadwal->hasMorePages())
                                <a href="{{ $jadwal->nextPageUrl() }}" class="page-btn">
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
        function updateCountdowns() {
            const now = new Date();
            document.querySelectorAll('.countdown-row').forEach(function(row) {
                const end = new Date((row.dataset.akhir || '').replace(' ', 'T'));
                const diff = Math.max(0, end - now);
                const h = String(Math.floor(diff / 3600000)).padStart(2, '0');
                const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
                const val = row.querySelector('.countdown-value');
                if (val) {
                    val.textContent = h + ':' + m + ':' + s;
                    if (diff <= 0) {
                        val.style.color = '#ef4444';
                    } else if (diff < 300000) {
                        val.style.color = '#ef4444';
                    } else if (diff < 600000) {
                        val.style.color = '#f59e0b';
                    } else {
                        val.style.color = '#8b5cf6';
                    }
                }
            });
        }
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
</body>

</html>