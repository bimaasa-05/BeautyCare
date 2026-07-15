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
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-8">

                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full min-h-[580px] justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Semua Pelanggan</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $pelanggan->count() }} pelanggan
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="text" placeholder="Cari pelanggan..."
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400">
                                </div>
                                <button
                                    class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                </button>
                                <a href="{{ route('admin.pelanggan.create') }}"
                                    class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                    <i class="fa-solid fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-4">Nama Lengkap</th>
                                        <th class="py-3 px-4">Nomor Hp</th>
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Alamat</th>
                                        <th class="py-3 px-4">Member ID</th>
                                        <th class="py-3 px-4">Catatan Alergi</th>
                                        <th class="py-3 px-4">Foto</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($pelanggan as $p)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->nm_pelanggan }}</td>
                                            <td class="py-3.5 px-4 text-gray-500 font-medium">{{ $p->no_hp ?? '-' }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->email }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->alamat }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->id_member ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->catatan_alergi }}</td>
                                            <td class="py-3.5 px-4">
                                                @if ($p->foto)
                                                    <img src="{{ asset('storage/' . $p->foto) }}" alt="foto"
                                                        class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.pelanggan.edit', $p->id_pelanggan) }}"
                                                        class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                                                            class="fa-regular fa-pen-to-square text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('admin.pelanggan.destroy', $p->id_pelanggan) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors"><i
                                                                class="fa-regular fa-trash-can text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="py-8 text-center text-gray-400 text-[13px]">Belum ada
                                                data pelanggan</td>
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
        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>