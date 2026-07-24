<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Aktivitas - BeautyCare</title>
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
        body { font-family: 'Poppins', sans-serif; }
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
        @media (max-width: 768px) {
            .data-table thead { display: none; }
            .data-table tbody tr { display: block; padding: 16px; border-bottom: 1px solid var(--border); }
            .data-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; font-size: 13px; text-align: right; }
            .data-table tbody td::before { content: attr(data-label); font-weight: 600; color: var(--gray); font-size: 11px; text-transform: uppercase; }
            .data-table tbody td:first-child { padding-left: 0; }
            .data-table tbody td:last-child { padding-right: 0; }
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .table-row-hover { transition: all 0.3s ease; }
        .table-row-hover:hover { background: #FFF5F8 !important; transform: scale(1.002); }
        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -6px rgba(0,0,0,0.08); }
        .role-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .role-admin { background: #FEE2E2; color: #DC2626; }
        .role-kasir { background: #DBEAFE; color: #2563EB; }
        .role-beautycian { background: #D1FAE5; color: #059669; }
        .role-pelanggan { background: #FEF3C7; color: #D97706; }
        .aksi-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 500; background: #F3F4F6; color: #4B5563; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">

                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-clock-rotate-left text-pink-500 mr-2"></i>Riwayat Aktivitas
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            {{ $totalAktivitas }} aktivitas tercatat
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        @php
                            $roleColors = [
                                'admin' => ['bg' => 'from-red-50 to-white', 'border' => 'border-red-100', 'icon' => 'text-red-500', 'iconBg' => 'bg-red-100', 'label' => 'Admin'],
                                'kasir' => ['bg' => 'from-blue-50 to-white', 'border' => 'border-blue-100', 'icon' => 'text-blue-500', 'iconBg' => 'bg-blue-100', 'label' => 'Kasir'],
                                'beautycian' => ['bg' => 'from-emerald-50 to-white', 'border' => 'border-emerald-100', 'icon' => 'text-emerald-500', 'iconBg' => 'bg-emerald-100', 'label' => 'Beautycian'],
                                'pelanggan' => ['bg' => 'from-amber-50 to-white', 'border' => 'border-amber-100', 'icon' => 'text-amber-500', 'iconBg' => 'bg-amber-100', 'label' => 'Pelanggan'],
                            ];
                        @endphp
                        @foreach ($roleColors as $key => $rc)
                        <div class="stat-card bg-gradient-to-br {{ $rc['bg'] }} rounded-xl p-4 border {{ $rc['border'] }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">{{ $rc['label'] }}</p>
                                    <p class="text-[22px] font-bold text-gray-800 mt-1">{{ $totalByRole[$key] ?? 0 }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full {{ $rc['iconBg'] }} flex items-center justify-center">
                                    <i class="fa-solid fa-user {{ $rc['icon'] }} text-sm"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <select name="role" class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[130px] focus:outline-none focus:border-pink-300 transition-all">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ request()->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="beautycian" {{ request()->role == 'beautycian' ? 'selected' : '' }}>Beautycian</option>
                            <option value="pelanggan" {{ request()->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        <select name="tipe" class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[150px] focus:outline-none focus:border-pink-300 transition-all">
                            <option value="">Semua Tipe</option>
                            <option value="transaksi" {{ request()->tipe == 'transaksi' ? 'selected' : '' }}>Transaksi</option>
                            <option value="booking" {{ request()->tipe == 'booking' ? 'selected' : '' }}>Booking</option>
                            <option value="pelanggan" {{ request()->tipe == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            <option value="pembayaran" {{ request()->tipe == 'pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                            <option value="user" {{ request()->tipe == 'user' ? 'selected' : '' }}>User</option>
                            <option value="produk" {{ request()->tipe == 'produk' ? 'selected' : '' }}>Produk</option>
                            <option value="layanan" {{ request()->tipe == 'layanan' ? 'selected' : '' }}>Layanan</option>
                        </select>
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari aktivitas..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[180px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ request()->keyword }}">
                        </div>
                        <input type="date" name="dari" value="{{ request()->dari }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <span class="text-gray-400 text-[12px] hidden sm:inline">—</span>
                        <input type="date" name="sampai" value="{{ request()->sampai }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <button type="submit"
                            class="bg-pink-50 text-pink-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                        @if (request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe)
                            <a href="{{ route('admin.riwayat.index') }}"
                                class="text-gray-400 hover:text-gray-600 text-[12px] px-1">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        @endif
                    </form>

                    <div class="overflow-x-auto">
                        <table class="data-table w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                    <th class="py-3 px-4 w-10">#</th>
                                    <th class="py-3 px-4">Waktu</th>
                                    <th class="py-3 px-4">User</th>
                                    <th class="py-3 px-4">Role</th>
                                    <th class="py-3 px-4">Aksi</th>
                                    <th class="py-3 px-4">Tipe</th>
                                    <th class="py-3 px-4">Deskripsi</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($riwayat as $r)
                                    <tr class="table-row-hover">
                                        <td data-label="#" class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td data-label="Waktu" class="py-3.5 px-4 whitespace-nowrap">
                                            <span class="text-[12px] text-gray-500">{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td data-label="User" class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                    {{ $r->user ? strtoupper(substr($r->user->nama, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $r->user->nama ?? 'System' }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Role" class="py-3.5 px-4">
                                            @php
                                                $roleClass = match($r->role) {
                                                    'admin' => 'role-admin',
                                                    'kasir' => 'role-kasir',
                                                    'beautycian' => 'role-beautycian',
                                                    'pelanggan' => 'role-pelanggan',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                            @endphp
                                            <span class="role-badge {{ $roleClass }}">
                                                <i class="fa-solid fa-circle text-[6px]"></i> {{ ucfirst($r->role) }}
                                            </span>
                                        </td>
                                        <td data-label="Aksi" class="py-3.5 px-4">
                                            <span class="aksi-badge">{{ $r->aksi }}</span>
                                        </td>
                                        <td data-label="Tipe" class="py-3.5 px-4">
                                            @if ($r->tipe)
                                                <span class="text-[12px] font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $r->tipe }}</span>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Deskripsi" class="py-3.5 px-4 max-w-[250px]">
                                            <p class="truncate text-gray-600">{{ $r->deskripsi }}</p>
                                        </td>
                                        <td data-label="Detail" class="py-3.5 px-4 text-center">
                                            <a href="{{ route('admin.riwayat.show', $r->id) }}"
                                                class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors inline-flex items-center justify-center"
                                                title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-clock-rotate-left text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">
                                                    {{ request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe ? 'Aktivitas tidak ditemukan' : 'Belum ada riwayat aktivitas' }}
                                                </p>
                                                <p class="text-gray-300 text-[12px] -mt-2">
                                                    {{ request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe ? 'Coba gunakan filter yang berbeda' : 'Aktivitas dari semua pengguna akan tercatat di sini' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($riwayat->hasPages())
                        <div class="mt-4 px-4 pagination-custom">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
