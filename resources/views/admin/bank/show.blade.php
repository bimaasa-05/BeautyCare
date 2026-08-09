<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Bank - BeautyCare</title>
    @include('partials.head-meta')
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
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

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

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                                    <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                                    <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                                    <path d="M5 9H9V12H5V9Z" />
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Detail Bank</h3>
                            <p>Informasi lengkap data rekening bank</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.bank.edit', $bank->id) }}"
                            class="flex items-center gap-1.5 px-3 py-2 bg-amber-500 text-white rounded-xl text-xs font-bold shadow-sm hover:bg-amber-600 transition">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <a href="{{ route('admin.bank.index') }}"
                            class="flex items-center gap-1.5 px-3 py-2 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if (session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2 text-sm text-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-emerald-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                <div class="float-icon" style="top:-15px;right:-10px;">🏦</div>

                <div class="flex flex-wrap items-start sm:items-center justify-between gap-3 mb-6">
                    <div>
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-building-columns text-blue-500 mr-2"></i>Detail Bank: {{ $bank->nama_bank }}
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-solid fa-circle-info text-pink-300 mr-1"></i>Informasi detail rekening bank
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-5">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Bank</label>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if (!empty($bank->logo))
                                        <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->nama_bank }}" class="w-12 h-12 object-contain">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899]">
                                            <path d="M5 18H19M5 18C3.89543 18 3 17.1046 3 16V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V16C21 17.1046 20.1046 18 19 18M5 18L5 20M19 18L19 20" />
                                            <circle cx="7" cy="14" r="1.5" fill="currentColor" />
                                            <circle cx="17" cy="14" r="1.5" fill="currentColor" />
                                            <path d="M5 9H9V12H5V9Z" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-lg font-bold text-gray-800">{{ $bank->nama_bank }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Kode Bank</label>
                            <p class="text-lg font-mono font-semibold text-gray-800">{{ $bank->kode_bank ?? '-' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Tipe Pembayaran</label>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold
                                @if($bank->tipe === 'transfer') bg-blue-50 text-blue-700
                                @elseif($bank->tipe === 'ewallet') bg-purple-50 text-purple-700
                                @else bg-green-50 text-green-700 @endif">
                                <i class="fa-solid @if($bank->tipe === 'transfer') fa-building-columns @elseif($bank->tipe === 'ewallet') fa-wallet @else fa-qrcode @endif text-[11px]"></i>
                                {{ ucfirst($bank->tipe) }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Atas Nama</label>
                            <p class="text-gray-800">{{ $bank->atas_nama }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Rekening</label>
                            <p class="text-lg font-mono font-semibold text-gray-800">{{ $bank->no_rekening ?? '-' }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</label>
                            <p class="text-gray-800">{{ $bank->nomor_telepon ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</label>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold
                                {{ $bank->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-50 text-gray-500' }}">
                                <span class="w-2 h-2 rounded-full {{ $bank->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ $bank->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Dibuat Pada</label>
                            <p class="text-gray-800">{{ $bank->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Diperbarui Pada</label>
                            <p class="text-gray-800">{{ $bank->updated_at->format('d M Y H:i') }}</p>
                        </div>

                        @if ($bank->deleted_at)
                        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                            <label class="text-[11px] font-semibold text-red-400 uppercase tracking-wider mb-1">Dihapus Pada (Soft Delete)</label>
                            <p class="text-red-700">{{ $bank->deleted_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif

                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">ID</label>
                            <p class="text-gray-800 font-mono">{{ $bank->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>