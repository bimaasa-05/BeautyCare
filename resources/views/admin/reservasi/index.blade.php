<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

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
                <div class="space-y-4">

                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $bookingsPerDay = $reservasi->groupBy(fn($r) => \Carbon\Carbon::parse($r->tanggal)->format('Y-m-d'))->map->count();
                    @endphp

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                        <!-- Calendar Side -->
                        <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                            <div class="flex items-center justify-between mb-4">
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
                            <div class="grid grid-cols-7 gap-0.5 mb-1">
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">M</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">S</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">S</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">R</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">K</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">J</div>
                                <div class="text-center text-[10px] font-bold text-gray-400 py-1">S</div>
                            </div>
                            <div id="calendarDays" class="grid grid-cols-7 gap-0.5"></div>
                            <div id="calendarSummary" class="mt-4 p-3 bg-pink-50 rounded-xl hidden">
                                <p id="summaryDate" class="text-xs font-bold text-gray-700 mb-0.5"></p>
                                <p id="summaryTotal" class="text-2xl font-extrabold text-[#EC4899]"></p>
                                <p id="summaryMeta" class="text-[10px] text-gray-400"></p>
                            </div>
                        </div>

                        <!-- Table Side -->
                        <div class="lg:col-span-2 bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                            <div class="p-4 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                                <h3 class="font-bold text-gray-800">Daftar Reservasi</h3>
                                <div class="flex items-center gap-2">
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                        <input id="searchReservasi"
                                            class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                            placeholder="Cari reservasi...">
                                    </div>
                                    <a href="{{ route('admin.reservasi.create') }}"
                                        class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg> Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
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
                                        <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors reservasi-row">
                                            <td class="px-5 py-4 text-sm text-gray-600 font-mono">RSV-{{ str_pad($r->id_booking, 3, '0', STR_PAD_LEFT) }}</td>
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-2.5">
                                                    <div class="w-8 h-8 text-xs rounded-full bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                                                        {{ strtoupper(substr($r->pelanggan->nm_pelanggan ?? '?', 0, 2)) }}
                                                    </div>
                                                    <p class="text-sm font-semibold text-gray-800 nm_pelanggan">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600">{{ $r->karyawan->nama ?? '-' }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-600">
                                                @foreach ($r->detail as $d)
                                                    <span class="inline-block bg-pink-50 text-pink-600 text-[10px] font-semibold px-2 py-0.5 rounded-full mr-1 mb-1">{{ $d->layanan->nm_layanan ?? '-' }}</span>
                                                @endforeach
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($r->tanggal)->isoFormat('D MMM Y') }}</td>
                                            <td class="px-5 py-4 text-sm font-semibold text-gray-700">{{ $r->jam }}</td>
                                            <td class="px-5 py-4">
                                                @php
                                                    $statusColors = [
                                                        'menunggu' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                        'dikonfirmasi' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                        'diproses' => 'bg-violet-50 text-violet-600 border-violet-100',
                                                        'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                        'dibatalkan' => 'bg-red-50 text-red-500 border-red-100',
                                                    ];
                                                    $bgColors = [
                                                        'menunggu' => '#fffbeb',
                                                        'dikonfirmasi' => '#eff6ff',
                                                        'diproses' => '#f5f3ff',
                                                        'selesai' => '#ecfdf5',
                                                        'dibatalkan' => '#fef2f2',
                                                    ];
                                                    $textColors = [
                                                        'menunggu' => '#d97706',
                                                        'dikonfirmasi' => '#2563eb',
                                                        'diproses' => '#7c3aed',
                                                        'selesai' => '#059669',
                                                        'dibatalkan' => '#dc2626',
                                                    ];
                                                @endphp
                                                <select onchange="ubahStatus(this, {{ $r->id_booking }})"
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border cursor-pointer focus:outline-none focus:ring-2 focus:ring-pink-300"
                                                    style="background-color: {{ $bgColors[$r->status] ?? '#f9fafb' }}; color: {{ $textColors[$r->status] ?? '#6b7280' }}; border-color: transparent;">
                                                    <option value="menunggu" {{ $r->status == 'menunggu' ? 'selected' : '' }} style="background:#fffbeb;color:#d97706;">Menunggu</option>
                                                    <option value="dikonfirmasi" {{ $r->status == 'dikonfirmasi' ? 'selected' : '' }} style="background:#eff6ff;color:#2563eb;">Dikonfirmasi</option>
                                                    <option value="diproses" {{ $r->status == 'diproses' ? 'selected' : '' }} style="background:#f5f3ff;color:#7c3aed;">Diproses</option>
                                                    <option value="selesai" {{ $r->status == 'selesai' ? 'selected' : '' }} style="background:#ecfdf5;color:#059669;">Selesai</option>
                                                    <option value="dibatalkan" {{ $r->status == 'dibatalkan' ? 'selected' : '' }} style="background:#fef2f2;color:#dc2626;">Dibatalkan</option>
                                                </select>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="flex gap-1.5">
                                                    <a href="{{ route('admin.reservasi.show', $r->id_booking) }}"
                                                        class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.reservasi.edit', $r->id_booking) }}"
                                                        class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 hover:bg-amber-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                            <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.reservasi.destroy', $r->id_booking) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M3 6h18"></path>
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
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

        document.getElementById('searchReservasi').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.reservasi-row').forEach(function(row) {
                const nm = row.querySelector('.nm_pelanggan')?.textContent?.toLowerCase() || '';
                row.style.display = nm.includes(q) ? '' : 'none';
            });
        });

        function ubahStatus(el, id) {
            const status = el.value;
            fetch('/admin/reservasi/' + id + '/status', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const colors = {
                        menunggu: { bg: '#fffbeb', text: '#d97706' },
                        dikonfirmasi: { bg: '#eff6ff', text: '#2563eb' },
                        diproses: { bg: '#f5f3ff', text: '#7c3aed' },
                        selesai: { bg: '#ecfdf5', text: '#059669' },
                        dibatalkan: { bg: '#fef2f2', text: '#dc2626' },
                    };
                    const c = colors[status] || { bg: '#f9fafb', text: '#6b7280' };
                    el.style.backgroundColor = c.bg;
                    el.style.color = c.text;
                } else {
                    alert('Gagal mengubah status');
                    location.reload();
                }
            })
            .catch(() => { alert('Terjadi kesalahan'); location.reload(); });
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

                let classes = 'aspect-square rounded-lg flex flex-col items-center justify-center text-[10px] font-bold transition-all';

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
                    span.className = isSelected ? 'text-[7px] font-bold text-pink-200' : 'text-[7px] font-bold text-[#EC4899]';
                    span.textContent = count;
                    btn.appendChild(span);
                }

                btn.addEventListener('click', function() {
                    selectedDate = new Date(currentYear, currentMonth, d);
                    updateSummary(d, count);
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
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            selectedDate = null;
            renderCalendar();
        });

        renderCalendar();
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
