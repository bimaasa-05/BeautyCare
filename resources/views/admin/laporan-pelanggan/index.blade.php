<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Pelanggan - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .growth-positive { color: #059669; background: #ECFDF5; }
        .growth-negative { color: #DC2626; background: #FEF2F2; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        <main class="main-content">
            @include('layouts.header2')
            <div class="dashboard-content">
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <div class="space-y-5">

                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                @php
                                    $periodes = [
                                        '7hari' => '7 Hari',
                                        '30hari' => '30 Hari',
                                        '3bulan' => '3 Bulan',
                                        'tahunini' => 'Tahun Ini',
                                    ];
                                @endphp
                                @foreach ($periodes as $key => $label)
                                    <a href="{{ route('admin.laporan-pelanggan.index', ['periode' => $key]) }}"
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all {{ $periode === $key ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm' : 'bg-white border border-pink-100 text-gray-500 hover:border-pink-300' }}">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.laporan-pelanggan.export-pdf', ['periode' => $periode]) }}"
                                    class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 bg-white rounded-xl text-xs text-gray-600 hover:border-pink-300 font-bold">
                                    <i data-lucide="download" class="w-3 h-3"></i> Export PDF
                                </a>
                                <a href="{{ route('admin.laporan-pelanggan.export-excel', ['periode' => $periode]) }}"
                                    class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 bg-white rounded-xl text-xs text-gray-600 hover:border-pink-300 font-bold">
                                    <i data-lucide="download" class="w-3 h-3"></i> Export Excel
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="users" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                        <i data-lucide="list" class="w-3 h-3"></i>total
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Total Pelanggan</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPelanggan, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">Sepanjang waktu</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="user-plus" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full {{ $pelangganBaruGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                        <i data-lucide="{{ $pelangganBaruGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>{{ $pelangganBaruGrowth >= 0 ? '+' : '' }}{{ $pelangganBaruGrowth }}%
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Pelanggan Baru</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($pelangganBaru, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="award" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                        <i data-lucide="list" class="w-3 h-3"></i>member
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Pelanggan Member</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($pelangganMember, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $totalPelanggan > 0 ? round(($pelangganMember / $totalPelanggan) * 100) : 0 }}% dari total</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="shopping-cart" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-amber-600 bg-amber-50">
                                        <i data-lucide="list" class="w-3 h-3"></i>periode
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Transaksi Pelanggan</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($transaksiPelanggan, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">Periode {{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                            <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                <h3 class="font-bold text-gray-800 mb-1">Pelanggan Baru {{ in_array($periode, ['7hari', '30hari']) ? 'Harian' : 'Bulanan' }}</h3>
                                <p class="text-xs text-gray-400 mb-4">{{ date('d M', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                                <div style="width: 100%; height: 200px;">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                <h3 class="font-bold text-gray-800 mb-1">Distribusi Membership</h3>
                                <p class="text-xs text-gray-400 mb-4">{{ $totalPelanggan }} pelanggan terdaftar</p>
                                <div style="width: 100%; height: 200px;">
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_16px_rgba(236,72,153,0.07)] border border-pink-50">
                            <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                                <div>
                                    <h3 class="font-bold text-gray-800">
                                        <i data-lucide="users" class="w-4 h-4 inline text-pink-500 mr-1"></i>
                                        Daftar Pelanggan
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $totalPelanggan }} pelanggan — {{ $pelangganMember }} member
                                    </p>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('admin.laporan-pelanggan.index') }}" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                                <input type="hidden" name="periode" value="{{ $periode }}">
                                <div class="relative">
                                    <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" placeholder="Cari nama, no hp, atau email..." name="keyword"
                                        class="bg-gray-50 border border-gray-100 text-xs rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                        value="{{ $search }}">
                                </div>
                                <input type="date" name="dari" value="{{ $dari }}"
                                    class="bg-gray-50 border border-gray-100 text-xs rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                                <span class="text-gray-400 text-xs">—</span>
                                <input type="date" name="sampai" value="{{ $sampai }}"
                                    class="bg-gray-50 border border-gray-100 text-xs rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                                <button type="submit"
                                    class="bg-pink-50 text-pink-600 text-xs font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                                    <i data-lucide="filter" class="w-3 h-3 inline mr-1"></i> Filter
                                </button>
                                @if ($search || $dari || $sampai)
                                    <a href="{{ route('admin.laporan-pelanggan.index', ['periode' => $periode]) }}"
                                        class="text-gray-400 hover:text-gray-600 text-xs px-1">
                                        <i data-lucide="refresh-cw" class="w-3 h-3"></i>
                                    </a>
                                @endif
                            </form>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-xs font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                            <th class="py-3 px-4 w-10">#</th>
                                            <th class="py-3 px-4">Pelanggan</th>
                                            <th class="py-3 px-4">No. HP</th>
                                            <th class="py-3 px-4">Email</th>
                                            <th class="py-3 px-4">Member</th>
                                            <th class="py-3 px-4 text-center">Transaksi</th>
                                            <th class="py-3 px-4">Total Belanja</th>
                                            <th class="py-3 px-4">Terakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700 divide-y divide-gray-50">
                                        @forelse($pelanggan as $p)
                                            <tr class="hover:bg-gray-100 transition-colors duration-150">
                                                <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-xs">{{ $loop->iteration }}</td>
                                                <td class="py-3.5 px-4">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                            {{ strtoupper(substr($p->nm_pelanggan, 0, 2)) }}
                                                        </div>
                                                        <span class="font-medium text-gray-700">{{ $p->nm_pelanggan }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 text-gray-500 text-xs">{{ $p->no_hp ?? '-' }}</td>
                                                <td class="py-3.5 px-4 text-gray-500 text-xs">{{ $p->email }}</td>
                                                <td class="py-3.5 px-4">
                                                    @if ($p->membership)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-purple-50 text-purple-600 border border-purple-200">
                                                            <i data-lucide="award" class="w-3 h-3"></i> {{ $p->membership->nm_member }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400 text-xs">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-3.5 px-4 text-center font-semibold text-gray-800">{{ $p->total_transaksi ?? 0 }}</td>
                                                <td class="py-3.5 px-4 font-semibold text-gray-800">{{ $fmt($p->total_belanja ?? 0) }}</td>
                                                <td class="py-3.5 px-4 text-gray-500 text-xs">
                                                    {{ $p->tgl_terakhir ? \Carbon\Carbon::parse($p->tgl_terakhir)->format('d/m/Y') : '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="py-14 text-center">
                                                    <div class="flex flex-col items-center gap-3">
                                                        <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                            <i data-lucide="users" class="w-8 h-8 text-pink-200"></i>
                                                        </div>
                                                        <p class="text-gray-400 font-medium text-sm">
                                                            {{ $search || $dari || $sampai ? 'Pelanggan tidak ditemukan' : 'Belum ada pelanggan' }}
                                                        </p>
                                                        <p class="text-gray-300 text-xs -mt-2">
                                                            {{ $search || $dari || $sampai ? 'Coba gunakan filter yang berbeda' : 'Data pelanggan akan muncul di sini' }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($pelanggan->hasPages())
                                <div class="mt-4 px-4 pagination-custom">
                                    {{ $pelanggan->links() }}
                                </div>
                            @endif
                        </div>

                    </div>
                </main>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();

        Chart.defaults.font.family = 'Poppins, sans-serif';
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.font.size = 10;

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
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
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false }
                },
                y: {
                    border: { display: false },
                    grid: { color: '#F9EEF4', borderDash: [3, 3] },
                    ticks: { maxTicksLimit: 5 }
                }
            }
        };

        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);
        const memberLabels = @json($memberLabels);
        const memberValues = @json($memberValues);

        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pelanggan Baru',
                    data: chartData,
                    backgroundColor: '#8B5CF6',
                    borderRadius: { topLeft: 6, topRight: 6 },
                    barPercentage: 0.5
                }]
            },
            options: commonOptions
        });

        const doughnutColors = ['#EC4899', '#8B5CF6', '#F59E0B', '#10B981', '#3B82F6', '#EF4444'];
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: memberLabels,
                datasets: [{
                    data: memberValues,
                    backgroundColor: doughnutColors.slice(0, memberLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Poppins', size: 10 },
                            color: '#6B7280',
                            padding: 12,
                            usePointStyle: true,
                            pointStyleWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        borderColor: '#FCE7F3',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                return ' ' + context.label + ': ' + context.parsed + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });

        const now = new Date();
        const dateOpts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
