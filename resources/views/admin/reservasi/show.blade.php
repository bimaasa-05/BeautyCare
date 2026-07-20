<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .detail-label { font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .detail-value { font-size: 14px; font-weight: 600; color: #374151; }
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

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-info-circle text-pink-500 mr-2"></i>Detail Reservasi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-eye text-pink-300 mr-1"></i>RSV-{{ str_pad($reservasi->id_booking, 3, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.reservasi.edit', $reservasi->id_booking) }}"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <a href="{{ route('admin.reservasi.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    @php
                        $statusClass = match($reservasi->status) {
                            'menunggu' => 'bg-amber-100 text-amber-700',
                            'dikonfirmasi' => 'bg-blue-100 text-blue-700',
                            'diproses' => 'bg-violet-100 text-violet-700',
                            'selesai' => 'bg-emerald-100 text-emerald-700',
                            'dibatalkan' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                        $grandTotal = $reservasi->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0));
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-user text-pink-400 mr-1"></i>Pelanggan</p>
                            <p class="detail-value">{{ $reservasi->pelanggan->nm_pelanggan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-envelope text-pink-400 mr-1"></i>Email Pelanggan</p>
                            <p class="detail-value">{{ $reservasi->pelanggan->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-phone text-pink-400 mr-1"></i>No. HP Pelanggan</p>
                            <p class="detail-value">{{ $reservasi->pelanggan->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-user text-pink-400 mr-1"></i>Beautician</p>
                            <p class="detail-value">{{ $reservasi->karyawan->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-calendar text-pink-400 mr-1"></i>Tanggal</p>
                            <p class="detail-value">{{ \Carbon\Carbon::parse($reservasi->tanggal)->isoFormat('D MMMM Y') }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-clock text-pink-400 mr-1"></i>Jam</p>
                            <p class="detail-value">{{ $reservasi->jam }}</p>
                        </div>
                        <div>
                            <p class="detail-label"><i class="fa-regular fa-flag text-pink-400 mr-1"></i>Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                            <i class="fa-regular fa-list text-pink-500 mr-2"></i>Layanan
                        </h4>
                        <p class="text-[12px] text-gray-400 mb-4">Daftar layanan yang direservasi</p>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-pink-50/50">
                                        <th class="text-left px-4 py-2.5 text-[11px] font-bold text-gray-400 uppercase">#</th>
                                        <th class="text-left px-4 py-2.5 text-[11px] font-bold text-gray-400 uppercase">Layanan</th>
                                        <th class="text-right px-4 py-2.5 text-[11px] font-bold text-gray-400 uppercase">Harga</th>
                                        <th class="text-right px-4 py-2.5 text-[11px] font-bold text-gray-400 uppercase">Diskon</th>
                                        <th class="text-right px-4 py-2.5 text-[11px] font-bold text-gray-400 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservasi->detail as $i => $d)
                                    <tr class="border-t border-gray-100">
                                        <td class="px-4 py-3 text-[13px] text-gray-500 font-mono">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3 text-[13px] font-semibold text-gray-700">{{ $d->layanan->nm_layanan ?? '-' }}</td>
                                        <td class="px-4 py-3 text-[13px] text-gray-600 text-right">Rp {{ number_format($d->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-[13px] text-gray-600 text-right">{{ $d->diskon ? 'Rp ' . number_format($d->diskon, 0, ',', '.') : '-' }}</td>
                                        <td class="px-4 py-3 text-[13px] font-bold text-gray-800 text-right">Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-400 text-[13px]">Tidak ada layanan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] font-semibold text-gray-600">Grand Total</span>
                                <span class="text-[18px] font-bold text-pink-500">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($reservasi->catatan)
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                            <i class="fa-regular fa-note-sticky text-pink-500 mr-2"></i>Catatan
                        </h4>
                        <p class="text-[13px] text-gray-600 mt-2 bg-gray-50 rounded-xl p-4">{{ $reservasi->catatan }}</p>
                    </div>
                    @endif

                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
