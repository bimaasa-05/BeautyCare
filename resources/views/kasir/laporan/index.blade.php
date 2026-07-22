<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Pendapatan - BeautyCare</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
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
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }
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
                                    <a href="{{ route('kasir.laporan.index', ['periode' => $key]) }}"
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all {{ $periode === $key ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm' : 'bg-white border border-pink-100 text-gray-500 hover:border-pink-300' }}">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('kasir.laporan.export-pdf', ['periode' => $periode]) }}"
                                    class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 bg-white rounded-xl text-xs text-gray-600 hover:border-pink-300 font-bold">
                                    <i data-lucide="download" class="w-3 h-3"></i> Export PDF
                                </a>
                                <a href="{{ route('kasir.laporan.export-excel', ['periode' => $periode]) }}"
                                    class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 bg-white rounded-xl text-xs text-gray-600 hover:border-pink-300 font-bold">
                                    <i data-lucide="download" class="w-3 h-3"></i> Export Excel
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="dollar-sign" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full {{ $pendapatanGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                        <i data-lucide="{{ $pendapatanGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Pendapatan Periode</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $fmt($periodePendapatan) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="receipt" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                        <i data-lucide="list" class="w-3 h-3"></i>{{ $periodeCount }} transaksi
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Total Transaksi</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">Sepanjang waktu</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="split-square-horizontal" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                        <i data-lucide="calculator" class="w-3 h-3"></i>rata-rata
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Rata-rata / Transaksi</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $fmt($rataTransaksi) }}</p>
                                <p class="text-xs text-gray-400 mt-1">Dari {{ $totalTransaksi }} transaksi</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="credit-card" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-amber-600 bg-amber-50">
                                        <i data-lucide="bar-chart-3" class="w-3 h-3"></i>#1
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Metode Terbanyak</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $metodeTerbanyak->metode_byr ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-1">Paling sering digunakan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                            <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                <h3 class="font-bold text-gray-800 mb-1">Pendapatan {{ in_array($periode, ['7hari', '30hari']) ? 'Harian' : 'Bulanan' }}</h3>
                                <p class="text-xs text-gray-400 mb-4">{{ date('d M', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                                <div style="width: 100%; height: 200px;">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                <h3 class="font-bold text-gray-800 mb-1">Metode Pembayaran</h3>
                                <p class="text-xs text-gray-400 mb-4">Distribusi {{ $periodeCount }} transaksi periode ini</p>
                                <div style="width: 100%; height: 200px;">
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                            <h3 class="font-bold text-gray-800 mb-1">Tren Transaksi {{ in_array($periode, ['7hari', '30hari']) ? 'Harian' : 'Bulanan' }}</h3>
                            <p class="text-xs text-gray-400 mb-4">{{ date('d M', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            <div style="width: 100%; height: 200px;">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_16px_rgba(236,72,153,0.07)] border border-pink-50">
                            <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                                <div>
                                    <h3 class="font-bold text-gray-800">
                                        <i data-lucide="clock" class="w-4 h-4 inline text-pink-500 mr-1"></i>
                                        Riwayat Transaksi
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $totalTransaksi }} transaksi — Total pendapatan <span class="font-semibold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('kasir.laporan.index') }}" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                                <input type="hidden" name="periode" value="{{ $periode }}">
                                <div class="relative">
                                    <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" placeholder="Cari invoice atau pelanggan..." name="keyword"
                                        class="bg-gray-50 border border-gray-100 text-xs rounded-full pl-9 pr-4 py-2 w-[180px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
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
                                    <a href="{{ route('kasir.laporan.index', ['periode' => $periode]) }}"
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
                                            <th class="py-3 px-4">No. Invoice</th>
                                            <th class="py-3 px-4">Pelanggan</th>
                                            <th class="py-3 px-4">Tanggal</th>
                                            <th class="py-3 px-4">Total</th>
                                            <th class="py-3 px-4">Metode</th>
                                            <th class="py-3 px-4">Status</th>
                                            <th class="py-3 px-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700 divide-y divide-gray-50">
                                        @forelse($transaksi as $t)
                                            <tr class="hover:bg-gray-100 transition-colors duration-150">
                                                <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-xs">{{ $loop->iteration }}</td>
                                                <td class="py-3.5 px-4">
                                                    <span class="font-mono font-semibold text-gray-700 text-xs">{{ $t->no_invoice }}</span>
                                                </td>
                                                <td class="py-3.5 px-4">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                            {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                        </div>
                                                        <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                                <td class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                                <td class="py-3.5 px-4">
                                                    @php
                                                        $metodeIcon = match($t->metode_byr) {
                                                            'Tunai' => 'fa-solid fa-money-bill-wave text-emerald-500',
                                                            'Transfer' => 'fa-solid fa-building-columns text-purple-500',
                                                            'Debit' => 'fa-regular fa-credit-card text-amber-500',
                                                            'E-Wallet' => 'fa-solid fa-wallet text-pink-500',
                                                            default => 'fa-regular fa-circle text-gray-400',
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600">
                                                        <i class="{{ $metodeIcon }}"></i> {{ $t->metode_byr }}
                                                    </span>
                                                </td>
                                                <td class="py-3.5 px-4">
                                                    @if ($t->status == 'Lunas')
                                                        <span class="badge-status status-selesai"><i class="fa-regular fa-circle-check"></i> Lunas</span>
                                                    @elseif ($t->status == 'Pending')
                                                        <span class="badge-status status-proses"><i class="fa-regular fa-clock"></i> Pending</span>
                                                    @else
                                                        <span class="badge-status status-batal"><i class="fa-regular fa-circle-xmark"></i> Batal</span>
                                                    @endif
                                                </td>
                                                <td class="py-3.5 px-4 text-center">
                                                    <a href="{{ route('kasir.riwayat-transaksi.show', $t->id_transaksi) }}"
                                                        class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors inline-flex items-center justify-center"
                                                        title="Detail"><i data-lucide="eye" class="w-3.5 h-3.5"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="py-14 text-center">
                                                    <div class="flex flex-col items-center gap-3">
                                                        <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                            <i data-lucide="bar-chart-3" class="w-8 h-8 text-pink-200"></i>
                                                        </div>
                                                        <p class="text-gray-400 font-medium text-sm">
                                                            {{ $search || $dari || $sampai ? 'Transaksi tidak ditemukan' : 'Belum ada transaksi' }}
                                                        </p>
                                                        <p class="text-gray-300 text-xs -mt-2">
                                                            {{ $search || $dari || $sampai ? 'Coba gunakan filter yang berbeda' : 'Transaksi yang sudah selesai akan muncul di sini' }}
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($transaksi->hasPages())
                                <div class="mt-4 px-4 pagination-custom">
                                    {{ $transaksi->links() }}
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
        const chartRevenue = @json($chartRevenue);
        const chartTransaksi = @json($chartTransaksi);
        const chartMetodeLabels = @json($chartMetodeLabels);
        const chartMetodeValues = @json($chartMetodeValues);
        const maxRevenue = {{ $maxRevenue }};

        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: chartRevenue,
                    backgroundColor: '#EC4899',
                    borderRadius: { topLeft: 6, topRight: 6 },
                    barPercentage: 0.5
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        ticks: maxRevenue > 1000000 ? {
                            callback: function(value) {
                                return (value / 1000000).toFixed(1) + 'jt';
                            }
                        } : {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        const doughnutColors = ['#EC4899', '#8B5CF6', '#F59E0B', '#10B981', '#3B82F6', '#EF4444'];
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: chartMetodeLabels,
                datasets: [{
                    data: chartMetodeValues,
                    backgroundColor: doughnutColors.slice(0, chartMetodeLabels.length),
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

        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Transaksi',
                    data: chartTransaksi,
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#8B5CF6',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: commonOptions
        });

        const now = new Date();
        const dateOpts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>