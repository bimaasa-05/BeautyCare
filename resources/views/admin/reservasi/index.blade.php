<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .sidebar-toggle svg {
            width: 24px;
            height: 24px;
            color: var(--dark);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 90;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: flex;
                align-items: center;
            }
        }
    </style>

    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media (max-width: 768px) {
            .admin-table thead { display: none; }
            .admin-table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid #f0f0f0;
            }
            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }
            .admin-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #9ca3af;
                font-size: 11px;
                text-transform: uppercase;
            }
            .admin-table tbody td:first-child { padding-left: 0; }
            .admin-table tbody td:last-child { padding-right: 0; }
        }

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
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: 30%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium .ph-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-premium .ph-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
            flex-shrink: 0;
        }

        .page-header-premium .ph-text h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-header-premium .ph-text p {
            font-size: 13px;
            color: var(--gray);
            margin: 2px 0 0;
        }

    </style>
</head>

<body>
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Data Reservasi</h3>
                            <p>Kelola jadwal reservasi pelanggan dan beautician.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="space-y-4">

                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $bookingsPerDay = $reservasi->groupBy(fn($r) => \Carbon\Carbon::parse($r->tanggal)->format('Y-m-d'))->map->count();
                    @endphp

                    <div class="grid grid-cols-1 lg:grid-cols-[400px_1fr] lg:items-start gap-5">

                        <!-- Calendar Side -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                            <div class="p-4 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                                <h3 id="calendarMonthYear" class="font-bold text-gray-800"></h3>
                                <div class="flex gap-1">
                                    <button id="prevMonth" class="w-7 h-7 rounded-lg bg-pink-50 text-[#EC4899] flex items-center justify-center hover:bg-pink-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                                    </button>
                                    <button id="nextMonth" class="w-7 h-7 rounded-lg bg-pink-50 text-[#EC4899] flex items-center justify-center hover:bg-pink-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="grid grid-cols-7 gap-0.5 mb-1">
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">M</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">S</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">S</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">R</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">K</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">J</div>
                                <div class="text-center text-xs sm:text-sm font-bold text-gray-400 py-1">S</div>
                                </div>
                                <div id="calendarDays" class="grid grid-cols-7 gap-0.5"></div>
                                <div id="calendarSummary" class="mt-4 p-3 bg-pink-50 rounded-xl hidden">
                                    <p id="summaryDate" class="text-xs font-bold text-gray-700 mb-0.5"></p>
                                    <p id="summaryTotal" class="text-2xl font-extrabold text-[#EC4899]"></p>
                                    <p id="summaryMeta" class="text-[10px] text-gray-400"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Table Side -->
                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden min-w-0">
                            <div class="p-4 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                                <h3 class="font-bold text-gray-800">Daftar Reservasi</h3>
                                <div class="flex items-center gap-2">
                                    <div id="filterBadge" class="hidden items-center gap-1.5 bg-pink-50 text-pink-600 border border-pink-100 rounded-full px-3 py-1.5 text-[11px] font-semibold">
                                        <i class="fa-solid fa-calendar-day"></i>
                                        <span id="filterBadgeText"></span>
                                        <button type="button" onclick="clearDateFilter()" class="hover:text-pink-800 font-bold" title="Hapus filter">×</button>
                                    </div>
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                        <input id="searchReservasi"
                                            class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                            placeholder="Cari reservasi...">
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
<table class="w-full min-w-full admin-table">
                                <thead>
                                        <tr class="bg-[#FFF7FA]">
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">#</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Pelanggan</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Beautician</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Layanan</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Jam</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                                            <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reservasiTableBody">
                                        @forelse ($reservasi as $r)
                                        <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors reservasi-row" data-tanggal="{{ \Carbon\Carbon::parse($r->tanggal)->format('Y-m-d') }}">
                                            <td class="px-5 py-4 text-sm text-gray-600 font-mono">RSV-{{ str_pad($r->id_booking, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-5 py-4" data-label="Pelanggan">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 text-xs rounded-full bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                                                    {{ strtoupper(substr($r->pelanggan->nm_pelanggan ?? '?', 0, 2)) }}
                                                </div>
                                                <p class="text-sm font-semibold text-gray-800 nm_pelanggan">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Beautician">{{ $r->karyawan->nama ?? '-' }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Layanan">
                                                @foreach ($r->detail as $d)
                                                    <span class="inline-block bg-pink-50 text-pink-600 text-[10px] font-semibold px-2 py-0.5 rounded-full mr-1 mb-1">{{ $d->layanan->nm_layanan ?? '-' }}</span>
                                                @endforeach
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="Tanggal">{{ \Carbon\Carbon::parse($r->tanggal)->isoFormat('D MMM Y') }}</td>
                                            <td class="px-5 py-4 text-sm font-semibold text-gray-700" data-label="Jam">
                                                @php
                                                    $jamMulai = \Carbon\Carbon::parse($r->jam)->format('H:i');
                                                    $durasiMenit = \App\Support\BookingSlot::durasiBooking($r);
                                                    $jamSelesaiEstimasi = \Carbon\Carbon::parse($r->tanggal . ' ' . substr($r->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                                                @endphp
                                                <span class="font-mono">{{ $jamMulai }}</span>
                                                <span class="text-gray-400">-</span>
                                                <span class="font-mono text-gray-500">{{ $jamSelesaiEstimasi }}</span>
                                            </td>
                                            <td class="px-5 py-4" data-label="Status">
                                                @php
                                                    $statusColors = [
                                                        'menunggu' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                        'dikonfirmasi' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                        'diproses' => 'bg-violet-50 text-violet-600 border-violet-100',
                                                        'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                        'dibatalkan' => 'bg-red-50 text-red-500 border-red-100',
                                                    ];
                                                    $statusLabels = [
                                                        'menunggu' => 'Menunggu',
                                                        'dikonfirmasi' => 'Dikonfirmasi',
                                                        'diproses' => 'Diproses',
                                                        'selesai' => 'Selesai',
                                                        'dibatalkan' => 'Dibatalkan',
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$r->status] ?? 'bg-gray-50 text-gray-500 border-gray-200' }}" data-rt-booking="{{ $r->id_booking }}" data-rt-status="{{ $r->status }}">
                                                    {{ $statusLabels[$r->status] ?? ucfirst($r->status) }}
                                                </span>
                                                @if ($r->status === 'diproses')
                                                    @php
                                                        $durasiMenit = \App\Support\BookingSlot::durasiBooking($r);
                                                        $durasiTxt = $durasiMenit >= 60
                                                            ? (($durasiMenit % 60)
                                                                ? floor($durasiMenit / 60) . ' jam ' . ($durasiMenit % 60) . ' menit'
                                                                : ($durasiMenit / 60) . ' jam')
                                                            : $durasiMenit . ' menit';
                                                        $mulaiPengerjaan = $r->jam_mulai_aktual
                                                            ? \Carbon\Carbon::parse($r->jam_mulai_aktual)
                                                            : \Carbon\Carbon::parse($r->tanggal . ' ' . substr($r->jam, 0, 5));
                                                        $estimasiSelesai = $mulaiPengerjaan->copy()->addMinutes($durasiMenit);
                                                    @endphp
                                                    <div class="mt-1.5 flex items-center gap-1 text-[10px] font-semibold text-violet-500">
                                                        <i class="fa-regular fa-clock"></i> Waktu pengerjaan: {{ $durasiTxt }}
                                                    </div>
                                                    <div class="countdown-row mt-0.5 flex items-center gap-1 text-[10px] font-bold text-violet-600" data-akhir="{{ $estimasiSelesai->format('Y-m-d H:i:s') }}">
                                                        <i class="fa-solid fa-hourglass-half"></i> Sisa: <span class="countdown-value font-mono">--:--:--</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4" data-label="Aksi">
                                                <a href="{{ route('admin.reservasi.show', $r->id_booking) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 text-[11px] font-semibold" title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                                <i class="fa-regular fa-face-frown text-4xl block mb-3"></i>
                                                Belum ada data reservasi
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($reservasi->hasPages())
                            <div class="px-5 py-3 border-t border-pink-50">
                                {{ $reservasi->links() }}
                            </div>
                            @endif
                        </div>

                    </div>

                </div>
            </main>

    <script>
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

        let filterDate = null;

        function applyFilters() {
            const q = (document.getElementById('searchReservasi').value || '').toLowerCase();
            document.querySelectorAll('.reservasi-row').forEach(function(row) {
                const nm = row.querySelector('.nm_pelanggan')?.textContent?.toLowerCase() || '';
                const tanggal = row.dataset.tanggal || '';
                const matchSearch = nm.includes(q);
                const matchDate = !filterDate || tanggal === filterDate;
                row.style.display = (matchSearch && matchDate) ? '' : 'none';
            });
        }

        document.getElementById('searchReservasi').addEventListener('input', applyFilters);

        function updateFilterBadge() {
            const badge = document.getElementById('filterBadge');
            if (filterDate) {
                const parts = filterDate.split('-').map(Number);
                document.getElementById('filterBadgeText').textContent = 'Menampilkan: ' + parts[2] + ' ' + monthNames[parts[1] - 1] + ' ' + parts[0];
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        }

        function clearDateFilter() {
            filterDate = null;
            selectedDate = null;
            updateFilterBadge();
            applyFilters();
            renderCalendar();
            document.getElementById('calendarSummary').classList.add('hidden');
        }

        const bookingsPerDay = @json($bookingsPerDay);
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const dayNames = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
        let currentMonth = now.getMonth();
        let currentYear = now.getFullYear();
        let selectedDate = null;

        function getBookingsForDate(year, month, day) {
            const key = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
            return bookingsPerDay[key] || 0;
        }

        function renderCalendar() {
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const today = new Date();
            const todayDate = today.getDate();
            const todayMonth = today.getMonth();
            const todayYear = today.getFullYear();

            document.getElementById('calendarMonthYear').textContent = monthNames[currentMonth] + ' ' + currentYear;

            const container = document.getElementById('calendarDays');
            container.innerHTML = '';

            for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
                const empty = document.createElement('div');
                container.appendChild(empty);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const btn = document.createElement('button');
                const count = getBookingsForDate(currentYear, currentMonth, d);
                const isToday = (d === todayDate && currentMonth === todayMonth && currentYear === todayYear);
                const isSelected = selectedDate && d === selectedDate.getDate() && currentMonth === selectedDate.getMonth() && currentYear === selectedDate.getFullYear();

                let classes = 'aspect-square rounded-lg flex flex-col items-center justify-center text-xs sm:text-base font-bold transition-all';

                if (isSelected) {
                    classes += ' bg-gradient-to-br from-[#EC4899] to-[#BE185D] text-white shadow-sm';
                } else if (isToday) {
                    classes += ' bg-pink-100 text-gray-700 hover:bg-pink-200';
                } else if (count > 0) {
                    classes += ' bg-pink-50 text-gray-700 hover:bg-pink-100';
                } else {
                    classes += ' text-gray-300 hover:bg-gray-50';
                }

                btn.className = classes;
                btn.textContent = d;

                if (count > 0) {
                    const span = document.createElement('span');
                    span.className = isSelected ? 'text-[9px] sm:text-xs font-bold text-pink-200' : 'text-[9px] sm:text-xs font-bold text-[#EC4899]';
                    span.textContent = count;
                    btn.appendChild(span);
                }

                btn.addEventListener('click', function() {
                    const key = currentYear + '-' + String(currentMonth + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                    if (filterDate === key) {
                        clearDateFilter();
                        return;
                    }
                    filterDate = key;
                    selectedDate = new Date(currentYear, currentMonth, d);
                    updateSummary(d, count);
                    updateFilterBadge();
                    applyFilters();
                    renderCalendar();
                });

                container.appendChild(btn);
            }

            if (!selectedDate && currentMonth === todayMonth && currentYear === todayYear) {
                const count = getBookingsForDate(currentYear, currentMonth, todayDate);
                selectedDate = new Date(currentYear, currentMonth, todayDate);
                updateSummary(todayDate, count);
                renderCalendar();
                return;
            } else if (!selectedDate) {
                document.getElementById('calendarSummary').classList.add('hidden');
            }
        }

        function updateSummary(day, count) {
            const el = document.getElementById('calendarSummary');
            el.classList.remove('hidden');
            document.getElementById('summaryDate').textContent = day + ' ' + monthNames[currentMonth] + ' ' + currentYear;
            document.getElementById('summaryTotal').textContent = count + ' Booking' + (count !== 1 ? '' : '');
        }

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            selectedDate = null;
            filterDate = null;
            updateFilterBadge();
            applyFilters();
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            selectedDate = null;
            filterDate = null;
            updateFilterBadge();
            applyFilters();
            renderCalendar();
        });

        renderCalendar();

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
                        val.classList.add('text-red-500');
                        row.querySelector('i')?.classList.add('text-red-500');
                    }
                }
            });
        }
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.realtime-booking', ['rtScope' => 'umum'])
</body>

</html>
