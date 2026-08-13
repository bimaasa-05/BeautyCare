<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaksi->no_invoice }} - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .invoice-page {
            max-width: 210mm;
            margin: 0 auto;
            min-height: 297mm;
        }
        @media (max-width: 768px) {
            .invoice-page { max-width: 100%; min-height: 0; }
            .invoice-header-flex { flex-direction: column; align-items: flex-start; gap: 16px; }
            .invoice-header-flex .text-right { text-align: left; }
        }
        .invoice-card {
            background: #fff;
            border-radius: 0;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .invoice-card { box-shadow: none; border-radius: 0; }
            @page { size: A4; margin: 15mm; }
        }
        .badge-status {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 14px; border-radius: 100px;
            font-size: 11px; font-weight: 600;
        }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }
        .item-table th {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.5px; padding: 12px 16px;
            background: #F9FAFB; color: #6B7280;
            border-bottom: 2px solid #E5E7EB;
        }
        .item-table td {
            padding: 12px 16px; font-size: 13px; color: #374151;
            border-bottom: 1px solid #F3F4F6;
        }
        .item-table tbody tr:last-child td { border-bottom: none; }
        .summary-table td {
            padding: 8px 0; font-size: 13px;
        }
        .summary-table td:last-child { text-align: right; font-weight: 600; }
    </style>
</head>
<body>

    <div class="no-print flex justify-center pt-6 pb-4">
        @php
            $isAdmin = request()->routeIs('admin.*');
            $pdfRoute = $isAdmin
                ? route('admin.transaksi.invoice-pdf', $transaksi->id_transaksi)
                : route('kasir.invoice.pdf', $transaksi->id_transaksi);
            $strukRoute = $isAdmin
                ? route('admin.transaksi.struk', $transaksi->id_transaksi)
                : route('kasir.struk', $transaksi->id_transaksi);
        @endphp
        <a href="{{ $strukRoute }}" target="_blank"
            class="flex items-center gap-2 border border-gray-200 bg-white text-gray-700 text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-gray-50 transition-all shadow-sm no-underline">
            <i class="fa-solid fa-receipt"></i> Cetak Struk
        </a>
        <a href="{{ $pdfRoute }}" target="_blank"
            class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm ml-2 no-underline">
            <i class="fa-solid fa-file-pdf"></i> Cetak PDF
        </a>
        <button onclick="window.close()"
            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[13px] font-medium px-6 py-2.5 rounded-full hover:bg-gray-50 transition-all ml-2">
            <i class="fa-solid fa-xmark"></i> Tutup
        </button>
    </div>

    <div class="invoice-page p-4 sm:p-8">
        <div class="invoice-card p-6 sm:p-10">

            <div class="flex justify-between items-start border-b-2 border-[#FF4F87] pb-6 mb-6 invoice-header-flex">
                <div>
                    <h1 class="text-[28px] font-extrabold text-[#FF4F87] tracking-wide m-0">BEAUTYCARE</h1>
                    <p class="text-[12px] text-gray-500 mt-1">Salon &amp; Beauty Treatment</p>
                    <p class="text-[11px] text-gray-400 mt-1">Jl. Contoh No. 123, Kota</p>
                    <p class="text-[11px] text-gray-400">Telp: 0812-3456-7890 | info@beautycare.com</p>
                </div>
                <div class="text-right">
                    <h2 class="text-[22px] font-bold text-gray-800 uppercase tracking-[3px] m-0">INVOICE</h2>
                    <p class="text-[13px] font-mono font-semibold text-gray-700 mt-2">{{ $transaksi->no_invoice }}</p>
                </div>
            </div>

            <div class="flex flex-wrap justify-between gap-2 mb-8 pb-6 border-b border-dashed border-gray-200">
                <div>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Kepada</p>
                    <p class="text-[15px] font-semibold text-gray-800">{{ $transaksi->pelanggan->nm_pelanggan ?? 'Umum' }}</p>
                    @if ($transaksi->pelanggan->no_hp ?? false)
                        <p class="text-[12px] text-gray-500">{{ $transaksi->pelanggan->no_hp }}</p>
                    @endif
                    @if ($transaksi->pelanggan->alamat ?? false)
                        <p class="text-[12px] text-gray-500">{{ $transaksi->pelanggan->alamat }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <div class="overflow-x-auto"><table class="text-[12px] table-card-mobile">
                        <tr>
                            <td data-label="" class="text-gray-400 pr-4">Tanggal</td>
                            <td data-label="" class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td data-label="" class="text-gray-400 pr-4">Status</td>
                            <td data-label="">
                                @php
                                    $statusMap = [
                                        'Pending' => ['label' => 'Pending', 'class' => 'status-proses', 'icon' => 'fa-regular fa-clock'],
                                        'Lunas' => ['label' => 'Lunas', 'class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check'],
                                        'Batal' => ['label' => 'Batal', 'class' => 'status-batal', 'icon' => 'fa-regular fa-circle-xmark'],
                                    ];
                                    $s = $statusMap[$transaksi->status] ?? $statusMap['Pending'];
                                @endphp
                                <span class="badge-status {{ $s['class'] }}">
                                    <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
                                </span>
                            </td>
                        </tr>
                        @if ($transaksi->kasir || $transaksi->user)
                        <tr>
                            <td data-label="" class="text-gray-400 pr-4">Kasir</td>
                            <td data-label="" class="font-semibold text-gray-700">{{ $transaksi->kasir?->nama ?? $transaksi->user?->nama }}</td>
                        </tr>
                        @endif
                    </table></div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-[12px] font-bold text-[#FF4F87] uppercase tracking-[1px] mb-4 pb-2 border-b-2 border-[#FF4F87]">
                    Detail Layanan & Produk
                </h3>
                <div class="overflow-x-auto"><table class="w-full text-left item-table table-card-mobile">
                    <thead>
                        <tr>
                            <th style="width:5%;text-align:center;">#</th>
                            <th style="width:48%;">Item</th>
                            <th style="width:10%;text-align:center;">Qty</th>
                            <th style="width:17%;text-align:right;">Harga</th>
                            <th style="width:20%;text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi->detail ?? [] as $item)
                            <tr>
                                <td data-label="#" style="text-align:center;">{{ $loop->iteration }}</td>
                                <td data-label="Item">{{ $item->nm_item }}</td>
                                <td data-label="Qty" style="text-align:center;">{{ $item->qty }}</td>
                                <td data-label="Harga" style="text-align:right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td data-label="Subtotal" style="text-align:right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:#999;padding:20px;">Tidak ada detail item</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table></div>
            </div>

            <div class="flex justify-end mb-8">
                <div class="overflow-x-auto"><table class="w-64 summary-table table-card-mobile">
                    <tr>
                        <td data-label="" class="text-gray-500">Subtotal</td>
                        <td data-label="">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td data-label="" class="text-gray-500">Diskon</td>
                        <td data-label="" class="text-red-500">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td data-label="" class="text-gray-500">Pajak</td>
                        <td data-label="">+ Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td data-label="" class="text-gray-500 border-t-2 border-gray-800 pt-3 font-bold text-gray-800">Grand Total</td>
                        <td data-label="" class="border-t-2 border-gray-800 pt-3 font-extrabold text-[18px] text-[#FF4F87]">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td data-label="" class="text-gray-500">Dibayar</td>
                        <td data-label="">Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td data-label="" class="text-gray-500">Kembali</td>
                        <td data-label="" class="text-green-600">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
                    </tr>
                </table></div>
            </div>

            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div class="overflow-x-auto"><table class="w-full text-[12px] table-card-mobile">
                    <tr>
                        <td data-label="" class="text-gray-400">Metode</td>
                        <td data-label="" class="font-semibold text-gray-700">{{ $transaksi->metode_byr }}</td>
                    </tr>
                    @if ($transaksi->no_referensi)
                    <tr>
                        <td data-label="" class="text-gray-400">No. Referensi</td>
                        <td data-label="" class="font-mono font-semibold text-gray-700">{{ $transaksi->no_referensi }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->ewallet_type && $transaksi->metode_byr === 'E-Wallet')
                    <tr>
                        <td data-label="" class="text-gray-400">E-Wallet</td>
                        <td data-label="" class="font-semibold text-gray-700">{{ $transaksi->ewallet_type }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->bukti_bayar)
                    <tr>
                        <td data-label="" class="text-gray-400">Bukti Bayar</td>
                        <td data-label="">
                            <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank"
                                class="text-blue-500 hover:underline font-medium">
                                <i class="fa-solid fa-image mr-1"></i> Lihat Bukti
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if ($transaksi->catatan)
                    <tr>
                        <td data-label="" class="text-gray-400">Catatan</td>
                        <td data-label="" class="text-gray-600">{{ $transaksi->catatan }}</td>
                    </tr>
                    @endif
                </table></div>
            </div>

            @if ($transaksi->bukti_bayar)
            <div class="mb-8 text-center">
                <p class="text-[11px] text-gray-400 mb-2">Bukti Pembayaran</p>
                <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank">
                    <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}"
                        alt="Bukti Bayar" class="max-w-[200px] mx-auto rounded-lg border border-gray-200">
                </a>
            </div>
            @endif

            <div class="border-t-2 border-[#FF4F87] pt-6 text-center">
                <p class="text-[16px] font-bold text-[#FF4F87] m-0">Terima Kasih</p>
                <p class="text-[11px] text-gray-400 mt-2">Semoga puas dengan layanan kami</p>
                <p class="text-[10px] text-gray-400 mt-1">BeautyCare Salon &amp; Beauty Treatment</p>
            </div>

        </div>
    </div>

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
</body>
</html>