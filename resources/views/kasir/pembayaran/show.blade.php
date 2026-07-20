<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - BeautyCare</title>
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
        .float-icon { position: absolute; pointer-events: none; opacity: 0.08; font-size: 100px; }
        .badge-status { display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }
        .info-box { background: #FFF8FA; border-radius: 16px; padding: 16px; border: 1px solid #FFE5EF; }
        .info-label { font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .info-value { font-size: 14px; font-weight: 600; color: #222; margin-top: 4px; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-20px;right:-5px;">💳</div>

                    @if (session('message'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-credit-card text-pink-500 mr-2"></i>Detail Pembayaran
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-file-lines text-pink-300 mr-1"></i>
                                Informasi lengkap pembayaran {{ $transaksi->no_invoice }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('kasir.invoice.show', $transaksi->id_transaksi) }}" target="_blank"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm">
                                <i class="fa-solid fa-print"></i> Cetak Invoice
                            </a>
                            <a href="{{ route('kasir.pembayaran.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-1">
                            <div class="flex flex-col items-center bg-gradient-to-br from-pink-50/80 to-white rounded-2xl p-6 border border-pink-100/50">
                                <div class="w-20 h-20 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-3xl mb-3 border-4 border-white shadow-sm">
                                    <i class="fa-regular fa-credit-card"></i>
                                </div>
                                <h4 class="text-[15px] font-bold text-gray-800">{{ $transaksi->no_invoice }}</h4>
                                <p class="text-[12px] text-gray-400">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}</p>

                                @php
                                    $statusMap = [
                                        'Pending' => ['label' => 'Pending', 'class' => 'status-proses', 'icon' => 'fa-regular fa-clock'],
                                        'Lunas' => ['label' => 'Lunas', 'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'],
                                        'Batal' => ['label' => 'Batal', 'class' => 'status-batal', 'icon' => 'fa-regular fa-circle-xmark'],
                                    ];
                                    $s = $statusMap[$transaksi->status] ?? $statusMap['Pending'];
                                @endphp
                                <span class="mt-3 badge-status {{ $s['class'] }}">
                                    <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
                                </span>

                                <div class="w-full mt-4 pt-4 border-t border-pink-100/50 text-center">
                                    <p class="text-[11px] text-gray-400">Total Pembayaran</p>
                                    <p class="text-[22px] font-bold text-pink-500 mt-1">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                                </div>

                                @if ($transaksi->metode_byr !== 'Tunai' && $transaksi->bukti_bayar)
                                    <div class="w-full mt-4 pt-4 border-t border-pink-100/50 text-center">
                                        <p class="text-[11px] text-gray-400 mb-2">Bukti Pembayaran</p>
                                        <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="Bukti Bayar"
                                                class="w-32 h-32 rounded-xl object-cover mx-auto border-2 border-pink-100 shadow-sm hover:scale-105 transition-transform">
                                        </a>
                                        <p class="text-[10px] text-gray-400 mt-1">Klik untuk perbesar</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-user mr-1 text-pink-300"></i> Pelanggan</p>
                                    <p class="info-value">{{ $transaksi->pelanggan->nm_pelanggan ?? '-' }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-hashtag mr-1 text-pink-300"></i> No. Invoice</p>
                                    <p class="info-value">{{ $transaksi->no_invoice }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-calendar mr-1 text-pink-300"></i> Tanggal</p>
                                    <p class="info-value">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-credit-card mr-1 text-pink-300"></i> Metode</p>
                                    <p class="info-value">{{ $transaksi->metode_byr }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-coins mr-1 text-pink-300"></i> Total</p>
                                    <p class="info-value text-pink-500">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-money-bill-1 mr-1 text-pink-300"></i> Dibayar</p>
                                    <p class="info-value">Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-coins mr-1 text-pink-300"></i> Kembali</p>
                                    <p class="info-value text-green-600">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</p>
                                </div>
                                <div class="info-box">
                                    <p class="info-label"><i class="fa-regular fa-user mr-1 text-pink-300"></i> Kasir</p>
                                    <p class="info-value">{{ $transaksi->user->nama ?? '-' }}</p>
                                </div>
                                <div class="info-box md:col-span-2">
                                    <p class="info-label"><i class="fa-regular fa-note-sticky mr-1 text-pink-300"></i> Catatan</p>
                                    <p class="info-value">{{ $transaksi->catatan ?: '-' }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-[13px] font-bold text-gray-600 mb-3 flex items-center gap-2">
                                    <i class="fa-regular fa-list text-pink-400"></i> Detail Layanan
                                </h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-[13px]">
                                        <thead>
                                            <tr class="border-b border-gray-100">
                                                <th class="text-left py-2 text-[11px] font-semibold text-gray-400 uppercase">Layanan</th>
                                                <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase">Harga</th>
                                                <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase">Diskon</th>
                                                <th class="text-right py-2 text-[11px] font-semibold text-gray-400 uppercase">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksi->detail as $d)
                                            <tr class="border-b border-gray-50">
                                                <td class="py-2 font-medium text-gray-700">{{ $d->nm_item }}</td>
                                                <td class="py-2 text-right text-gray-700">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                                <td class="py-2 text-right text-red-500">Rp {{ number_format($d->diskon ?? 0, 0, ',', '.') }}</td>
                                                <td class="py-2 text-right font-semibold text-emerald-600">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="py-3 text-right text-[13px] font-bold text-gray-600">Grand Total</td>
                                                <td class="py-3 text-right text-[16px] font-bold text-pink-500">Rp {{ number_format($transaksi->detail->sum('subtotal'), 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            @if ($transaksi->metode_byr === 'E-Wallet')
                                <div class="mt-4">
                                    <h4 class="text-[13px] font-bold text-teal-600 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-wallet"></i> Detail Pembayaran E-Wallet
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @if ($transaksi->atas_nama)
                                            <div class="info-box bg-teal-50/30 border-teal-100/50">
                                                <p class="info-label"><i class="fa-regular fa-user mr-1 text-teal-400"></i> Atas Nama</p>
                                                <p class="info-value">{{ $transaksi->atas_nama }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->bank_asal)
                                            <div class="info-box bg-teal-50/30 border-teal-100/50">
                                                <p class="info-label"><i class="fa-solid fa-wallet mr-1 text-teal-400"></i> E-Wallet</p>
                                                <p class="info-value">{{ $transaksi->bank_asal }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @elseif($transaksi->metode_byr !== 'Tunai' && $transaksi->metode_byr !== 'E-Wallet')
                                <div class="mt-4">
                                    <h4 class="text-[13px] font-bold text-amber-600 mb-3 flex items-center gap-2">
                                        <i class="fa-regular fa-circle-info"></i> Detail Pembayaran {{ $transaksi->metode_byr }}
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @if ($transaksi->atas_nama)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-user mr-1 text-amber-400"></i> Atas Nama</p>
                                                <p class="info-value">{{ $transaksi->atas_nama }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->bank_asal)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-building-columns mr-1 text-amber-400"></i> Bank Asal</p>
                                                <p class="info-value">{{ $transaksi->bank_asal }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->dari_rekening)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-arrow-right mr-1 text-amber-400"></i> Dari Rekening</p>
                                                <p class="info-value">{{ $transaksi->dari_rekening }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->bank_tujuan)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-building-columns mr-1 text-amber-400"></i> Bank Tujuan</p>
                                                <p class="info-value">{{ $transaksi->bank_tujuan }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->ke_rekening)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-arrow-left mr-1 text-amber-400"></i> Ke Rekening</p>
                                                <p class="info-value">{{ $transaksi->ke_rekening }}</p>
                                            </div>
                                        @endif
                                        @if ($transaksi->no_referensi)
                                            <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                <p class="info-label"><i class="fa-regular fa-hashtag mr-1 text-amber-400"></i> No. Referensi</p>
                                                <p class="info-value">{{ $transaksi->no_referensi }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
