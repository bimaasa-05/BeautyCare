<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Produk - BeautyCare</title>
    @include('partials.head-meta')
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
    </style>
</head>

<body>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                                        <path d="M12 22V12"></path>
                                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                        <path d="m7.5 4.27 9 5.15"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $produk->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $produk->sum('stok') }} total stok</p>
                        </div>

                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" x2="12" y1="8" y2="12"></line>
                                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Hampir Habis</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $produk->where('stok', '<', 10)->where('stok', '>', 0)->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Stok &lt; 10 unit</p>
                        </div>

                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-rose-400 to-pink-600 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Stok Habis</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $produk->where('stok', 0)->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Perlu restok</p>
                        </div>

                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Stok Normal</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $produk->where('stok', '>=', 10)->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Aman</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                        <div class="p-5 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="font-bold text-gray-800">Daftar Produk</h3>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                    <input id="searchProduk"
                                        class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                        placeholder="Cari produk...">
                                </div>
                                <a href="{{ route('admin.produk.create') }}"
                                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full admin-table">
                                <thead>
                                    <tr class="bg-[#FFF7FA]">
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">#</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Nama Produk</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Kategori</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Supplier</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Satuan</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Harga Beli</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Harga Jual</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Stok</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Foto</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="produkTableBody">
                                    @forelse ($produk as $p)
                                    <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors produk-row">
                                        <td class="px-5 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-4" data-label="Nama Produk">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899]">
                                                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                                                        <path d="M12 22V12"></path>
                                                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                                        <path d="m7.5 4.27 9 5.15"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-800 nm_produk">{{ $p->nm_produk }}</p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4" data-label="Kategori">
                                            <span class="text-xs font-semibold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                                                {{ $p->kategori->nm_produk ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Supplier">{{ $p->supplier->nm_supplier ?? '-' }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Satuan">{{ $p->satuan }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Harga Beli">Rp. {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Harga Jual">Rp. {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4" data-label="Stok">
                                            @php
                                                $stokClass = $p->stok == 0 ? 'text-red-500' : ($p->stok < 10 ? 'text-amber-500' : 'text-gray-800');
                                            @endphp
                                            <p class="text-sm font-semibold {{ $stokClass }}">{{ $p->stok }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Foto">
                                            @if ($p->foto)
                                                <img src="{{ asset('storage/' . $p->foto) }}" class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4" data-label="Status">
                                            @php
                                                $statusBadge = match($p->status) {
                                                    'Tersedia' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'Habis' => 'bg-red-50 text-red-500 border-red-100',
                                                    'Belum Restok' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    default => 'bg-gray-50 text-gray-500 border-gray-100'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusBadge }}">
                                                {{ $p->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4" data-label="Aksi">
                                            <div class="flex gap-1.5">
                                                <a href="{{ route('admin.produk.edit', $p->id_produk) }}"
                                                    class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 hover:bg-amber-100 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.produk.destroy', $p->id_produk) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-7 h-7 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    <tr>
                                        <td colspan="12" class="px-5 py-10 text-center text-gray-400 text-sm">
                                            <i class="fa-regular fa-face-frown text-4xl block mb-3"></i>
                                            Belum ada data produk
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </main>
    </div>

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

        document.getElementById('searchProduk').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.produk-row').forEach(function(row) {
                const nm = row.querySelector('.nm_produk')?.textContent?.toLowerCase() || '';
                row.style.display = nm.includes(q) ? '' : 'none';
            });
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
