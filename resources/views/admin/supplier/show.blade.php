<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Supplier - BeautyCare</title>
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
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                                        <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                                        <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                                        <path d="M5 9H9V12H5V9Z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Supplier</h3>
                                <p>Informasi lengkap mitra bisnis dan produk yang disuplai.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">{{ $supplier->nm_supplier }}</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Informasi supplier & daftar produk yang disuplai
                            </p>
                        </div>
                        <a href="{{ route('admin.supplier.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase mb-1">No. HP</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $supplier->no_hp }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase mb-1">Alamat</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $supplier->alamat }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase mb-1">Status</p>
                            @php
                                $statusSup = $supplier->status ?? 'Aktif';
                                $statusSupClass = $statusSup === 'Aktif'
                                    ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                    : 'bg-gray-100 text-gray-500 border-gray-200';
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusSupClass }}">
                                {{ $statusSup }}
                            </span>
                        </div>
                    </div>

                    <h4 class="text-[13px] font-bold text-gray-800 mb-3">Produk yang Disuplai</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr class="bg-[#FFF7FA]">
                                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">#</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Nama Produk
                                    </th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Satuan</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Harga Beli</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($supplier->produk as $p)
                                    <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors">
                                        <td class="px-5 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-4 text-sm font-semibold text-gray-800">{{ $p->nm_produk }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600">{{ $p->satuan }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600">Rp {{ number_format($p->pivot->harga_beli, 0, ',', '.') }}</td>
                                        @php
                                            $stokSup = $p->stok;
                                            $stokSupClass = $stokSup == 0 ? 'text-red-500' : ($stokSup < 10 ? 'text-amber-500' : 'text-gray-800');
                                        @endphp
                                        <td class="px-5 py-4 text-sm font-semibold {{ $stokSupClass }}">{{ $stokSup }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                                            <i class="fa-regular fa-face-frown text-4xl block mb-3"></i>
                                            Belum ada produk yang disuplai
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                        <a href="{{ route('admin.supplier.edit', $supplier->id_supplier) }}"
                            class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.supplier.destroy', $supplier->id_supplier) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus supplier ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center gap-2 border border-red-200 text-red-500 text-[13px] font-medium px-6 py-2.5 rounded-full hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
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
