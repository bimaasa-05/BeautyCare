<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">

    <style>
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
    </style>
    <style>

        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">🧾</div>

                    <div class="flex flex-wrap justify-between items-center gap-2 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-receipt text-pink-500 mr-2"></i>Detail Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-circle-info text-pink-300 mr-1"></i>
                                Invoice <span class="font-mono font-semibold text-pink-500">{{ $transaksi->no_invoice }}</span>
                            </p>
                        </div>
                        <a href="{{ route('kasir.riwayat-transaksi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div class="p-4 bg-gradient-to-br from-pink-50 to-white rounded-xl border border-pink-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-circle-info text-pink-400 mr-1"></i>Informasi Transaksi
                            </h4>
                            <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400 w-28">Invoice</td>
                                    <td data-label="" class="py-1.5 font-mono font-semibold text-gray-700">{{ $transaksi->no_invoice }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Tanggal</td>
                                    <td data-label="" class="py-1.5 font-medium text-gray-700">
                                        <i class="fa-solid fa-calendar text-pink-300 mr-1"></i>
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMMM YYYY') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Status</td>
                                    <td data-label="" class="py-1.5">
                                    @include('partials.badge-status', ['status' => $transaksi->status])
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Metode</td>
                                    <td data-label="" class="py-1.5 font-medium text-gray-700">{{ $transaksi->metode_byr }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Catatan</td>
                                    <td data-label="" class="py-1.5 text-gray-600">{{ $transaksi->catatan ?? '-' }}</td>
                                </tr>
                            </table></div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-white rounded-xl border border-sky-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-solid fa-user text-sky-400 mr-1"></i>Pelanggan & Kasir
                            </h4>
                            <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400 w-28">Pelanggan</td>
                                    <td data-label="" class="py-1.5 font-semibold text-gray-700">{{ $transaksi->pelanggan->nm_pelanggan ?? 'Umum' }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">No. HP</td>
                                    <td data-label="" class="py-1.5 text-gray-600">{{ $transaksi->pelanggan->no_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400 border-t border-sky-100/50 pt-2">Kasir</td>
                                    <td data-label="" class="py-1.5 font-semibold text-gray-700 border-t border-sky-100/50 pt-2">{{ $transaksi->kasir?->nama ?? $transaksi->user?->nama ?? '-' }}</td>
                                </tr>
                            </table></div>
                        </div>
                    </div>

                    <div class="p-4 bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100 mb-6">
                        <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                            <i class="fa-solid fa-money-bill-1 text-emerald-400 mr-1"></i>Rincian Pembayaran
                        </h4>
                        <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400 w-36">Subtotal</td>
                                <td data-label="" class="py-1.5 text-right text-gray-700">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">Diskon</td>
                                <td data-label="" class="py-1.5 text-right text-red-500">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">Pajak</td>
                                <td data-label="" class="py-1.5 text-right text-gray-700">Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-t border-emerald-100">
                                <td data-label="" class="py-2 text-[15px] font-bold text-gray-800">Grand Total</td>
                                <td data-label="" class="py-2 text-right text-[18px] font-bold text-emerald-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-t border-emerald-50">
                                <td data-label="" class="py-1.5 text-gray-400">Dibayar</td>
                                <td data-label="" class="py-1.5 text-right text-gray-700">Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">Kembali</td>
                                <td data-label="" class="py-1.5 text-right text-emerald-600 font-medium">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
                            </tr>
                        </table></div>
                    </div>

                    @if (in_array($transaksi->metode_byr, ['Transfer', 'Debit', 'QRIS', 'E-Wallet']))
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100">
                        <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                            <i class="fa-solid fa-building-columns text-blue-400 mr-1"></i>Detail Pembayaran {{ $transaksi->metode_byr }}
                        </h4>
                        <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">@if ($transaksi->no_referensi)
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">No. Referensi</td>
                                <td data-label="" class="py-1.5 font-mono font-semibold text-gray-700">{{ $transaksi->no_referensi }}</td>
                            </tr>
                        @endif
                        @if ($transaksi->ewallet_type && $transaksi->metode_byr === 'E-Wallet')
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">E-Wallet</td>
                                <td data-label="" class="py-1.5 font-semibold text-gray-700">{{ $transaksi->ewallet_type }}</td>
                            </tr>
                        @endif
                        @if ($transaksi->bukti_bayar)
                            <tr>
                                <td data-label="" class="py-1.5 text-gray-400">Bukti Bayar</td>
                                <td data-label="" class="py-1.5">
                                    <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank"
                                        class="text-blue-500 hover:underline text-[12px] font-medium">
                                        <i class="fa-solid fa-image mr-1"></i> Lihat Bukti
                                    </a>
                                </td>
                            </tr>
                        @endif
                        </table></div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
