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
</head>

<body>
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl mx-5 mt-5 flex items-center gap-2 text-sm text-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-emerald-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="flex-1 overflow-y-auto p-5 bg-[#FFF7FA]">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <div class="lg:col-span-2 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card text-white">
                                            <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                            <line x1="2" x2="22" y1="10" y2="10"></line>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Transaksi Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $transaksiToday }}</p>
                                <p class="text-xs text-gray-400 mt-1">Rp {{ number_format($totalToday, 0, ',', '.') }} total</p>
                            </div>
                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-white">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Lunas</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $lunasCount }}</p>
                                @php $total = $lunasCount + $menungguCount; @endphp
                                <p class="text-xs text-gray-400 mt-1">{{ $total > 0 ? round(($lunasCount / $total) * 100, 1) : 0 }}% success rate</p>
                            </div>
                            <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock text-white">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400 font-medium mb-1">Menunggu</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $menungguCount }}</p>
                                <p class="text-xs text-gray-400 mt-1">Perlu konfirmasi</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                            <div class="p-4 border-b border-pink-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <h3 class="font-bold text-gray-800">Riwayat Transaksi</h3>
                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <div class="relative flex-1 sm:flex-initial">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <path d="m21 21-4.3-4.3"></path>
                                        </svg>
                                        <input type="text" id="searchTransaksi" value="{{ request('keyword') }}" class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-40" placeholder="Cari transaksi...">
                                    </div>
                                    <a href="{{ route('admin.transaksi.create') }}"
                                        class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-semibold hover:shadow-md transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                            <path d="M5 12h14"></path><path d="M12 5v14"></path>
                                        </svg>
                                        Transaksi Baru
                                    </a>
                                    <a href="javascript:void(0)" onclick="exportTransaksi()"
                                        class="flex items-center gap-1.5 px-3 py-2 border border-pink-100 rounded-xl text-xs text-gray-500 hover:border-pink-300 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" x2="12" y1="15" y2="3"></line>
                                        </svg>
                                        Export
                                    </a>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-[#FFF7FA]">
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">ID</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Pelanggan</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Layanan</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Total</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Pembayaran</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Tanggal</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase">Status</th>
                                            <th class="text-left px-4 py-3 text-[10px] font-bold text-gray-400 uppercase"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="transaksiTableBody">
                                        @forelse ($transaksi as $t)
                                        <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors">
                                            <td class="px-4 py-3.5 text-[10px] font-mono text-gray-400">{{ $t->no_invoice }}</td>
                                            <td class="px-4 py-3.5">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 text-xs rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                                                        {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '?' }}
                                                    </div>
                                                    <span class="text-xs font-bold text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3.5 text-xs text-gray-500 max-w-[120px] truncate">
                                                {{ $t->detail->pluck('nm_item')->implode(', ') ?: '-' }}
                                            </td>
                                            <td class="px-4 py-3.5 text-xs font-bold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3.5 text-xs text-gray-500">{{ $t->metode_byr }}</td>
                                            <td class="px-4 py-3.5 text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                                            <td class="px-4 py-3.5">
                                                @php
                                                $statusClass = $t->status === 'Lunas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                                    {{ $t->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3.5">
                                                <div class="flex items-center gap-1.5">
                                                    <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                                                        class="w-6 h-6 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.transaksi.edit', $t->id_transaksi) }}"
                                                        class="w-6 h-6 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                                            <path d="m15 5 4 4"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $t->no_invoice }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-6 h-6 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                                                                <path d="M3 6h18"></path>
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="border-t border-pink-50">
                                            <td colspan="8" class="px-4 py-10 text-center text-gray-400 text-xs">Belum ada transaksi</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @php $inv = $transaksi->first(); @endphp
                    <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] p-5 h-fit">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-800">Invoice</h3>
                            @if ($inv)
                            <a href="{{ route('admin.transaksi.invoice', $inv->id_transaksi) }}" target="_blank"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-pink-50 text-[#EC4899] rounded-xl text-xs font-bold hover:bg-pink-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer">
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path>
                                    <rect x="6" y="14" width="12" height="8" rx="1"></rect>
                                </svg>
                                Cetak
                            </a>
                            @endif
                        </div>
                        @if ($inv)
                        <div class="text-center p-4 bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl mb-4">
                            <div class="w-14 h-14 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-2xl mx-auto mb-2">
                                <i class="fa-regular fa-receipt"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-800">{{ $inv->no_invoice }}</p>
                            <p class="text-xs text-gray-400">{{ $inv->pelanggan->nm_pelanggan ?? '-' }}</p>
                            <p class="text-lg font-bold text-pink-500 mt-2">Rp {{ number_format($inv->total, 0, ',', '.') }}</p>
                            @php
                                $badge = $inv->status === 'Lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700';
                            @endphp
                            <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $inv->status }}</span>
                        </div>
                        @else
                        <div class="text-center p-4 bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl mb-4">
                            <p class="text-xs text-gray-400">Belum ada transaksi</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function getFilterParamsTransaksi() {
            const params = new URLSearchParams();
            const q = document.getElementById('searchTransaksi').value.trim();
            if (q) params.set('keyword', q);
            return params.toString();
        }

        function fetchTransaksi() {
            const url = '{{ route('admin.transaksi.index') }}?' + getFilterParamsTransaksi();
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('transaksiTableBody').innerHTML = html;
            })
            .catch(() => location.reload());
        }

        function exportTransaksi() {
            const params = getFilterParamsTransaksi();
            window.location.href = '{{ route('admin.transaksi.export') }}' + (params ? '?' + params : '');
        }

        let searchTimer;
        document.getElementById('searchTransaksi').addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchTransaksi, 400);
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
