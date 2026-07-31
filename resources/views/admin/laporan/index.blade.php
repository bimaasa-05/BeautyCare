<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - BeautyCare</title>
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
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        <main class="main-content">
            @include('layouts.header2')


            <div class="dashboard-content">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Laporan Keuangan</h3>
                            <p>Pantau arus keuangan dan kinerja bisnis BeautyCare secara keseluruhan.</p>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <a href="{{ route('admin.laporan.index', ['periode' => $key]) }}"
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all {{ $periode === $key ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm' : 'bg-white border border-pink-100 text-gray-500 hover:border-pink-300' }}">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.laporan.export-pdf', ['periode' => $periode]) }}"
                                    class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 bg-white rounded-xl text-xs text-gray-600 hover:border-pink-300 font-bold">
                                    <i data-lucide="download" class="w-3 h-3"></i> Export PDF
                                </a>
                                <a href="{{ route('admin.laporan.export-excel', ['periode' => $periode]) }}"
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
                                <p class="text-sm text-gray-400 font-medium mb-1">Total Pendapatan</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $fmt($totalPendapatan) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="calendar" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full {{ $reservasiGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                        <i data-lucide="{{ $reservasiGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>{{ $reservasiGrowth >= 0 ? '+' : '' }}{{ $reservasiGrowth }}%
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Total Reservasi</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalReservasi, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="users" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full {{ $pelangganGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }}">
                                        <i data-lucide="{{ $pelangganGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Pelanggan Baru</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($pelangganBaru, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                            </div>

                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                        <i data-lucide="trending-up" class="text-white w-5 h-5"></i>
                                    </div>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>{{ $jumlahHari }} hari
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Rata-rata Pendapatan / Hari</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $fmt($rataPendapatan) }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
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
                                <h3 class="font-bold text-gray-800 mb-1">Tren Reservasi</h3>
                                <p class="text-xs text-gray-400 mb-4">{{ date('d M', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</p>
                                <div style="width: 100%; height: 200px;">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
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
        const chartBookings = @json($chartBookings);
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

        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Reservasi',
                    data: chartBookings,
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
