<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi - BeautyCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-decoration { position: absolute; pointer-events: none; opacity: 0.15; font-size: 60px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }

        .table-row-hover { transition: all 0.3s ease; }
        .table-row-hover:hover { background: #FFF5F8 !important; transform: scale(1.002); }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }
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

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-decoration" style="top:-10px;right:-10px;">🛍️</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">✨</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-receipt text-pink-500 mr-2"></i>Data Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                                Total {{ $TotalTransaksi }} transaksi tercatat
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                <form action="" class="input-group">
                                    <input type="text" placeholder="Cari invoice..." name="keyword"
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                        value={{ Request()->keyword }}>
                                </form>
                            </div>
                            <a href="{{ route('kasir.transaksi.create') }}"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-solid fa-plus"></i> Transaksi Baru
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
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
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($transaksi as $t)
                                    <tr class="table-row-hover">
                                        <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-semibold text-gray-800 text-[12px]">{{ $t->no_invoice }}</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                    {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-medium 
                                                @if($t->metode_byr == 'Tunai') bg-blue-50 text-blue-600
                                                @elseif($t->metode_byr == 'Qris') bg-green-50 text-green-600
                                                @elseif($t->metode_byr == 'E-Wallet') bg-teal-50 text-teal-600
                                                @elseif($t->metode_byr == 'Transfer') bg-purple-50 text-purple-600
                                                @elseif($t->metode_byr == 'Debit') bg-amber-50 text-amber-600
                                                @else bg-red-50 text-red-600 @endif">
                                                @if($t->metode_byr == 'Tunai') <i class="fa-solid fa-money-bill-wave text-[10px]"></i>
                                                @elseif($t->metode_byr == 'Qris') <i class="fa-solid fa-qrcode text-[10px]"></i>
                                                @elseif($t->metode_byr == 'E-Wallet') <i class="fa-solid fa-wallet text-[10px]"></i>
                                                @elseif($t->metode_byr == 'Transfer') <i class="fa-solid fa-building-columns text-[10px]"></i>
                                                @elseif($t->metode_byr == 'Debit') <i class="fa-solid fa-credit-card text-[10px]"></i>
                                                @else <i class="fa-solid fa-credit-card text-[10px]"></i> @endif
                                                {{ $t->metode_byr }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            @php
                                                $statusMap = [0 => ['label' => 'Proses', 'class' => 'status-proses', 'icon' => 'fa-regular fa-clock'], 1 => ['label' => 'Selesai', 'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'], 2 => ['label' => 'Batal', 'class' => 'status-batal', 'icon' => 'fa-regular fa-circle-xmark']];
                                                $s = $statusMap[$t->status] ?? $statusMap[0];
                                            @endphp
                                            <span class="badge-status {{ $s['class'] }}">
                                                <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('kasir.transaksi.show', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                                <a href="{{ route('kasir.transaksi.edit', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Edit"><i class="fa-regular fa-pen-to-square text-xs"></i></a>
                                                <form action="{{ route('kasir.transaksi.destroy', $t->id_transaksi) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $t->no_invoice }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors flex items-center justify-center"
                                                        title="Hapus"><i class="fa-regular fa-trash-can text-xs"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-receipt text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">Belum ada data transaksi</p>
                                                <p class="text-gray-300 text-[12px] -mt-2">Mulai buat transaksi baru untuk pelanggan</p>
                                                <a href="{{ route('kasir.transaksi.create') }}"
                                                    class="text-[#FF4F87] text-[12px] font-semibold hover:underline inline-flex items-center gap-1 mt-1">
                                                    <i class="fa-solid fa-plus-circle"></i> Buat transaksi sekarang
                                                </a>
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

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
