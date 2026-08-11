<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Bank - BeautyCare</title>
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
            .admin-table thead {
                display: none;
            }

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

            .admin-table tbody td:first-child {
                padding-left: 0;
            }

            .admin-table tbody td:last-child {
                padding-right: 0;
            }
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

            <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6">
                <div class="space-y-4">

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
                                    <h3>Data Bank</h3>
                                    <p>Pusat informasi rekening bank untuk pembayaran transfer! Di sini Anda dapat
                                        mengelola daftar rekening bank yang digunakan sebagai metode pembayaran, lengkap
                                        dengan logo bank, nama pemilik, dan nomor rekening. Pastikan data rekening selalu
                                        akurat agar pelanggan dapat melakukan transfer dengan mudah dan aman.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div
                            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div
                        class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                        <div class="p-5 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h3 class="font-bold text-gray-800">Daftar Rekening Bank</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Total {{ $banks->count() }} rekening bank</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                    <input id="searchBank"
                                        class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                        placeholder="Cari bank...">
                                </div>
                                <a href="{{ route('admin.bank.create') }}"
                                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
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
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Nama Bank</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Kode Bank</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Tipe</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Atas Nama</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">No. Rekening</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bankTableBody">
                                    @forelse ($banks as $bank)
                                    <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors bank-row">
                                        <td class="px-5 py-4 text-sm text-gray-600">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-4" data-label="Nama Bank">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-xl bg-pink-50 flex items-center justify-center overflow-hidden">
                                                    @if (!empty($bank->logo))
                                                        <img src="{{ asset('storage/' . $bank->logo) }}"
                                                            alt="{{ $bank->nama_bank }}" class="w-8 h-8 object-contain">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="text-[#EC4899]">
                                                            <path d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                                                            <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                                                            <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                                                            <path d="M5 9H9V12H5V9Z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <p class="text-sm font-semibold text-gray-800 nm_bank">{{ $bank->nama_bank }}</p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600 font-mono" data-label="Kode Bank">{{ $bank->kode_bank ?? '-' }}</td>
                                        <td class="px-5 py-4" data-label="Tipe">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                                @if($bank->tipe === 'transfer') bg-blue-50 text-blue-600
                                                @elseif($bank->tipe === 'ewallet') bg-purple-50 text-purple-600
                                                @else bg-green-50 text-green-600 @endif">
                                                <i class="fa-solid @if($bank->tipe === 'transfer') fa-building-columns @elseif($bank->tipe === 'ewallet') fa-wallet @else fa-qrcode @endif text-[10px]"></i>
                                                {{ ucfirst($bank->tipe) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-600" data-label="Atas Nama">{{ $bank->atas_nama }}</td>
                                        <td class="px-5 py-4 text-sm text-gray-600 font-mono" data-label="No. Rekening">{{ $bank->no_rekening ?? '-' }}</td>
                                        <td class="px-5 py-4" data-label="Status">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                                {{ $bank->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-50 text-gray-500' }}">
                                                {{ $bank->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4" data-label="Aksi">
                                            <div class="flex gap-1.5">
                                                <a href="{{ route('admin.bank.edit', $bank->id) }}"
                                                    class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 hover:bg-amber-100 flex items-center justify-center"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.bank.destroy', $bank->id) }}" method="POST"
                                                    data-confirm-title="Hapus Bank" data-confirm-body="Apakah Anda yakin ingin menghapus bank ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-7 h-7 rounded-lg bg-red-50 text-red-400 hover:bg-red-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                            <i class="fa-regular fa-face-frown text-4xl block mb-3"></i>
                                            Belum ada data bank
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>

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

                document.getElementById('searchBank').addEventListener('input', function () {
                    const q = this.value.toLowerCase();
                    document.querySelectorAll('.bank-row').forEach(function (row) {
                        const nm = row.querySelector('.nm_bank')?.textContent?.toLowerCase() || '';
                        row.style.display = nm.includes(q) ? '' : 'none';
                    });
                });
            </script>
            <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
