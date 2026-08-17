<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Masalah - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

    .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
    .badge-baru { background: #FEF3C7; color: #D97706; }
    .badge-diproses { background: #DBEAFE; color: #2563EB; }
    .badge-selesai { background: #E8F8EE; color: #22C55E; }
    .badge-role { background: #F3E8FF; color: #9333EA; }

    .alert-success-premium {
        border-radius: 16px; padding: 16px 20px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 500;
        background: linear-gradient(135deg, #F0FDF4, #DCFCE7); border: 1px solid #BBF7D0; color: #166534;
        animation: slideDown .4s ease;
    }
    .alert-success-premium .ae-icon {
        width: 36px; height: 36px; border-radius: 50%; background: #BBF7D0; color: #16A34A;
        display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }

    .btn-detail {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 100px;
        background: linear-gradient(135deg, var(--primary), #FF6B9C); color: #fff; font-size: 12px; font-weight: 600;
        text-decoration: none; transition: all .2s; box-shadow: 0 4px 12px rgba(255,79,135,0.25);
    }
    .btn-detail:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,79,135,0.35); color: #fff; }

    @media (max-width: 768px) {
        .table-enhanced thead { display: none; }
        .table-enhanced tbody tr {
            display: block; padding: 16px; border: 1px solid var(--border);
            border-radius: 14px; margin-bottom: 10px; background: #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }
        .table-enhanced tbody td {
            display: flex; justify-content: space-between; align-items: center;
            gap: 12px; padding: 7px 0; border: none; text-align: right;
        }
        .table-enhanced tbody td::before {
            content: attr(data-label); font-weight: 600; color: var(--gray);
            font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px;
        }
        .table-enhanced tbody td .max-w-[200px] { max-width: 55vw; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @if(session('message'))
                <div class="alert-success-premium">
                    <div class="ae-icon"><i class="fa-solid fa-check"></i></div>
                    <span>{{ session('message') }}</span>
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-triangle-exclamation text-pink-500 mr-2"></i>Laporan Masalah
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            Total {{ $laporan->count() }} laporan masalah dari kasir, beautycian, dan pelanggan
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-amber">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Baru</p>
                                    <p class="text-[24px] font-bold text-amber-600 mt-1">{{ $summary['baru'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-blue">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Diproses</p>
                                    <p class="text-[24px] font-bold text-blue-600 mt-1">{{ $summary['diproses'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-gears text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $summary['selesai'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <div class="relative flex-1 sm:flex-none sm:min-w-[200px] max-w-full">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari laporan..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ Request()->keyword }}">
                        </div>
                        <select name="role" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-4 pr-8 py-2 focus:outline-none focus:border-pink-300 transition-all w-full sm:w-auto">
                            <option value="">Semua Pelapor</option>
                            <option value="kasir" {{ $filterRole === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="beautycian" {{ $filterRole === 'beautycian' ? 'selected' : '' }}>Beautycian</option>
                            <option value="pelanggan" {{ $filterRole === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        <select name="status" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-4 pr-8 py-2 focus:outline-none focus:border-pink-300 transition-all w-full sm:w-auto">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ $filterStatus === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $filterStatus === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $filterStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-enhanced">
                            <thead>
                                <tr class="text-[11px] uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                    <th class="px-3 py-3 font-semibold">Pelapor</th>
                                    <th class="px-3 py-3 font-semibold">Kategori</th>
                                    <th class="px-3 py-3 font-semibold">Deskripsi</th>
                                    <th class="px-3 py-3 font-semibold">Bukti</th>
                                    <th class="px-3 py-3 font-semibold">Status</th>
                                    <th class="px-3 py-3 font-semibold">Waktu</th>
                                    <th class="px-3 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan as $item)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3" data-label="Pelapor">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-[12px] font-bold flex-shrink-0">
                                                {{ substr($item->user->nama ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-[12px] font-semibold text-gray-700">{{ $item->user->nama ?? '-' }}</div>
                                                <span class="badge-status badge-role mt-0.5">{{ ucfirst($item->role) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3" data-label="Kategori">
                                        <span class="text-[12px] font-medium text-gray-600">{{ $item->kategori }}</span>
                                    </td>
                                    <td class="px-3 py-3" data-label="Deskripsi">
                                        <div class="text-[12px] font-semibold text-gray-700 max-w-[220px] truncate">{{ $item->deskripsi }}</div>
                                    </td>
                                    <td class="px-3 py-3" data-label="Bukti">
                                        @if(!empty($item->bukti))
                                        <span class="inline-flex items-center gap-1 text-[12px] text-gray-600">
                                            <i class="fa-solid fa-paperclip text-pink-400"></i> {{ count($item->bukti) }} file
                                        </span>
                                        @else
                                        <span class="text-[11px] text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3" data-label="Status">
                                        <span class="badge-status badge-{{ $item->status }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3" data-label="Waktu">
                                        <div class="text-[12px] text-gray-600 font-medium">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $item->created_at ? $item->created_at->format('H:i') : '' }}</div>
                                    </td>
                                    <td class="px-3 py-3" data-label="Aksi">
                                        <a href="{{ route('admin.laporan-masalah.show', $item->id_laporan) }}" class="btn-detail">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="w-16 h-16 mx-auto rounded-2xl bg-pink-50 flex items-center justify-center text-[24px] text-pink-300 mb-3">
                                            <i class="fa-solid fa-flag"></i>
                                        </div>
                                        <p class="text-[13px] font-semibold text-gray-500">Belum ada laporan masalah</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Laporan dari kasir, beautycian, dan pelanggan akan muncul di sini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>