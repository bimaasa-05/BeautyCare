<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kategori - BeautyCare</title>
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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
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
                            <table class="w-full text-left border-collapse">
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
                                            <td class="py-3 px-3 font-medium">{{ $item->nm_layanan }}</td>
                                            <td class="py-3 px-3">
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
                                            <td class="py-3 px-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.kategori.edit', ['id' => $item->id_kategori_layanan, 'type' => 'layanan']) }}"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-sky-50 text-sky-500 border border-sky-200 hover:bg-sky-100 transition-colors"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen text-[11px]"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kategori.destroy', ['id' => $item->id_kategori_layanan, 'type' => 'layanan']) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 border border-rose-200 hover:bg-rose-100 transition-colors"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-[11px]"></i>
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
                            <table class="w-full text-left border-collapse">
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
                                            <td class="py-3 px-3 font-medium">{{ $item->nm_produk }}</td>
                                            <td class="py-3 px-3">
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
                                            <td class="py-3 px-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.kategori.edit', ['id' => $item->id_kategori_produk, 'type' => 'produk']) }}"
                                                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-sky-50 text-sky-500 border border-sky-200 hover:bg-sky-100 transition-colors"
                                                        title="Edit">
                                                        <i class="fa-solid fa-pen text-[11px]"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kategori.destroy', ['id' => $item->id_kategori_produk, 'type' => 'produk']) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 border border-rose-200 hover:bg-rose-100 transition-colors"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-[11px]"></i>
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
</body>

</html>
