<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kategori - BeautyCare</title>
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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Data Kategori</h3>
                            <p>Atur kategori layanan dan produk untuk memudahkan pengelompokan.</p>
                        </div>
                    </div>
                </div>
            </div>
                @if (session('success'))
                    <div class="mb-4 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] px-4 py-3 rounded-xl">
                        <i class="fa-solid fa-check-circle text-emerald-500"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Kategori Layanan</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $kategoriLayanan->count() }} kategori</p>
                            </div>
                            <a href="{{ route('admin.kategori.create', ['type' => 'layanan']) }}"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </a>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-3 w-10">#</th>
                                        <th class="py-3 px-3">Nama Layanan</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($kategoriLayanan as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3 px-3 text-gray-400">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-3 font-medium" data-label="Nama">{{ $item->nm_layanan }}</td>
                                            <td class="py-3 px-3" data-label="Status">
                                                @if ($item->status === 'tersedia')
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                        Tersedia
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full border border-rose-200">
                                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                                        Belum Tersedia
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3" data-label="Aksi">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.kategori.edit', ['id' => $item->id_kategori_layanan, 'type' => 'layanan']) }}"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-50 text-amber-500 border border-amber-200 hover:bg-amber-100 transition-colors"
                                                        title="Edit">
                                                        <i class="fa-regular fa-pen-to-square text-[11px]"></i>
                                                    </a>
<form action="{{ route('admin.kategori.destroy', ['id' => $item->id_kategori_layanan, 'type' => 'layanan']) }}" method="POST"
                                                         data-confirm-title="Hapus Kategori" data-confirm-body="Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button type="submit"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-500 border border-red-200 hover:bg-red-100 transition-colors"
                                                            title="Hapus">
                                                            <i class="fa-regular fa-trash-can text-[11px]"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-gray-400 text-[13px]">
                                                <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300"></i>
                                                Belum ada kategori layanan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Kategori Produk</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $kategoriProduk->count() }} kategori</p>
                            </div>
                            <a href="{{ route('admin.kategori.create', ['type' => 'produk']) }}"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </a>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-3 w-10">#</th>
                                        <th class="py-3 px-3">Nama Produk</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($kategoriProduk as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3 px-3 text-gray-400">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-3 font-medium" data-label="Nama">{{ $item->nm_produk }}</td>
                                            <td class="py-3 px-3" data-label="Status">
                                                @if ($item->status == 'tersedia')
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                        Tersedia
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full border border-rose-200">
                                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                                        Tidak Tersedia
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3" data-label="Aksi">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.kategori.edit', ['id' => $item->id_kategori_produk, 'type' => 'produk']) }}"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-50 text-amber-500 border border-amber-200 hover:bg-amber-100 transition-colors"
                                                        title="Edit">
                                                        <i class="fa-regular fa-pen-to-square text-[11px]"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kategori.destroy', ['id' => $item->id_kategori_produk, 'type' => 'produk']) }}" method="POST"
                                                        data-confirm-title="Hapus Kategori" data-confirm-body="Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-500 border border-red-200 hover:bg-red-100 transition-colors"
                                                            title="Hapus">
                                                            <i class="fa-regular fa-trash-can text-[11px]"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-400 text-[13px]">
                                                <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300"></i>
                                                Belum ada kategori produk
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
