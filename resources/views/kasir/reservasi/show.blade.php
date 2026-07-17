<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservasi - BeautyCare</title>
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
        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .badge { border-radius: 999px; font-size: 11px; font-weight: 600; padding: 4px 12px; display: inline-flex; align-items: center; gap: 4px; }
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
                    <div class="float-icon" style="top:-15px;right:-10px;">📅</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-receipt text-pink-500 mr-2"></i>Detail Reservasi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-info-circle text-pink-300 mr-1"></i>Informasi lengkap reservasi
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('kasir.reservasi.edit', $reservasi->id_booking) }}"
                                class="flex items-center gap-2 bg-yellow-50 text-yellow-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-yellow-100 transition-colors border border-yellow-200">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <a href="{{ route('kasir.reservasi.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="p-4 bg-gradient-to-br from-pink-50 to-white rounded-xl border border-pink-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-circle-info text-pink-400 mr-1"></i>Informasi Umum
                            </h4>
                            <table class="w-full text-[13px]">
                                <tr>
                                    <td class="py-1.5 text-gray-400 w-28">ID Booking</td>
                                    <td class="py-1.5 font-semibold text-gray-700">#{{ $reservasi->id_booking }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Status</td>
                                    <td class="py-1.5">
                                        @php
                                            $statusColor = match($reservasi->status) {
                                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                                'dikonfirmasi' => 'bg-blue-100 text-blue-700',
                                                'diproses' => 'bg-purple-100 text-purple-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'dibatalkan' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusColor }}">
                                            <i class="fa-regular fa-circle"></i> {{ ucfirst($reservasi->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Tanggal</td>
                                    <td class="py-1.5 font-medium text-gray-700">
                                        <i class="fa-regular fa-calendar text-pink-300 mr-1"></i>
                                        {{ \Carbon\Carbon::parse($reservasi->tanggal)->isoFormat('D MMMM YYYY') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Jam</td>
                                    <td class="py-1.5 font-medium text-gray-700">
                                        <i class="fa-regular fa-clock text-pink-300 mr-1"></i>
                                        {{ \Carbon\Carbon::parse($reservasi->jam)->format('H:i') }} WIB
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Catatan</td>
                                    <td class="py-1.5 text-gray-700">{{ $reservasi->catatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Dibuat</td>
                                    <td class="py-1.5 text-gray-500 text-[12px]">
                                        {{ $reservasi->created_at ? \Carbon\Carbon::parse($reservasi->created_at)->isoFormat('D MMM YYYY, HH:mm') : '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-white rounded-xl border border-sky-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-user text-sky-400 mr-1"></i>Pelanggan & Karyawan
                            </h4>
                            <table class="w-full text-[13px]">
                                <tr>
                                    <td class="py-1.5 text-gray-400 w-28">Pelanggan</td>
                                    <td class="py-1.5 font-semibold text-gray-700">
                                        <i class="fa-regular fa-user text-sky-300 mr-1"></i>
                                        {{ $reservasi->pelanggan->nm_pelanggan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">No. HP</td>
                                    <td class="py-1.5 text-gray-700">
                                        <i class="fa-regular fa-phone text-sky-300 mr-1"></i>
                                        {{ $reservasi->pelanggan->no_hp ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Alamat</td>
                                    <td class="py-1.5 text-gray-700">{{ $reservasi->pelanggan->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400 border-t border-sky-100/50 pt-2">Karyawan</td>
                                    <td class="py-1.5 font-semibold text-gray-700 border-t border-sky-100/50 pt-2">
                                        <i class="fa-regular fa-user text-sky-300 mr-1"></i>
                                        {{ $reservasi->karyawan->nama ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100">
                        <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                            <i class="fa-regular fa-list text-emerald-400 mr-1"></i>Detail Layanan
                        </h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-[13px]">
                                <thead>
                                    <tr class="border-b border-emerald-100">
                                        <th class="text-left py-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">#</th>
                                        <th class="text-left py-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Layanan</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Diskon</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservasi->detail as $i => $d)
                                    <tr class="border-b border-emerald-50">
                                        <td class="py-2 text-gray-400">{{ $i + 1 }}</td>
                                        <td class="py-2 font-medium text-gray-700">{{ $d->layanan->nm_layanan ?? '-' }}</td>
                                        <td class="py-2 text-right text-gray-700">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                        <td class="py-2 text-right text-red-500">Rp {{ number_format($d->diskon ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 text-right font-semibold text-emerald-600">Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-400 text-[13px]">Tidak ada layanan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="py-3 text-right text-[13px] font-bold text-gray-600">Grand Total</td>
                                        <td class="py-3 text-right text-[16px] font-bold text-pink-500">
                                            Rp {{ number_format($reservasi->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0)), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('kasir.reservasi.edit', $reservasi->id_booking) }}"
                            class="flex items-center gap-2 bg-yellow-50 text-yellow-600 text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-yellow-100 transition-colors border border-yellow-200">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Reservasi
                        </a>
                        <a href="{{ route('kasir.reservasi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[13px] font-medium px-6 py-2.5 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
