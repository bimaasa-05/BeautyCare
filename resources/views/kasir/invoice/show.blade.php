<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaksi->no_invoice }} - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .invoice-page {
            max-width: 210mm;
            margin: 0 auto;
            min-height: 297mm;
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
        <button onclick="window.print()"
            class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[13px] font-medium px-6 py-2.5 rounded-full hover:bg-gray-50 transition-all ml-2">
            <i class="fa-solid fa-xmark"></i> Tutup
        </button>
    </div>

    <div class="invoice-page p-4 sm:p-8">
        <div class="invoice-card p-6 sm:p-10">

            <div class="flex justify-between items-start border-b-2 border-[#FF4F87] pb-6 mb-6">
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

            <div class="flex justify-between mb-8 pb-6 border-b border-dashed border-gray-200">
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
                    <table class="text-[12px]">
                        <tr>
                            <td class="text-gray-400 pr-4">Tanggal</td>
                            <td class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-400 pr-4">Status</td>
                            <td>
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
                        @if ($transaksi->user)
                        <tr>
                            <td class="text-gray-400 pr-4">Kasir</td>
                            <td class="font-semibold text-gray-700">{{ $transaksi->user->nama }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-[12px] font-bold text-[#FF4F87] uppercase tracking-[1px] mb-4 pb-2 border-b-2 border-[#FF4F87]">
                    Detail Layanan & Produk
                </h3>
                <table class="w-full text-left item-table">
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
                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                <td>{{ $item->nm_item }}</td>
                                <td style="text-align:center;">{{ $item->qty }}</td>
                                <td style="text-align:right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td style="text-align:right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:#999;padding:20px;">Tidak ada detail item</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mb-8">
                <table class="w-64 summary-table">
                    <tr>
                        <td class="text-gray-500">Subtotal</td>
                        <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500">Diskon</td>
                        <td class="text-red-500">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500">Pajak</td>
                        <td>+ Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 border-t-2 border-gray-800 pt-3 font-bold text-gray-800">Grand Total</td>
                        <td class="border-t-2 border-gray-800 pt-3 font-extrabold text-[18px] text-[#FF4F87]">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-gray-500">Dibayar</td>
                        <td>Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500">Kembali</td>
                        <td class="text-green-600">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <table class="w-full text-[12px]">
                    <tr>
                        <td class="text-gray-400 w-28">Metode</td>
                        <td class="font-semibold text-gray-700">{{ $transaksi->metode_byr }}</td>
                    </tr>
                    @if ($transaksi->atas_nama)
                    <tr>
                        <td class="text-gray-400">Atas Nama</td>
                        <td class="font-semibold text-gray-700">{{ $transaksi->atas_nama }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->bank_asal)
                    <tr>
                        <td class="text-gray-400">Bank/E-Wallet</td>
                        <td class="font-semibold text-gray-700">{{ $transaksi->bank_asal }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->dari_rekening)
                    <tr>
                        <td class="text-gray-400">Dari Rekening</td>
                        <td class="font-mono text-gray-700">{{ $transaksi->dari_rekening }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->bank_tujuan)
                    <tr>
                        <td class="text-gray-400">Bank Tujuan</td>
                        <td class="font-semibold text-gray-700">{{ $transaksi->bank_tujuan }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->ke_rekening)
                    <tr>
                        <td class="text-gray-400">Ke Rekening</td>
                        <td class="font-mono text-gray-700">{{ $transaksi->ke_rekening }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->no_referensi)
                    <tr>
                        <td class="text-gray-400">No. Referensi</td>
                        <td class="font-mono font-semibold text-gray-700">{{ $transaksi->no_referensi }}</td>
                    </tr>
                    @endif
                    @if ($transaksi->bukti_bayar)
                    <tr>
                        <td class="text-gray-400">Bukti Bayar</td>
                        <td>
                            <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}" target="_blank"
                                class="text-blue-500 hover:underline font-medium">
                                <i class="fa-regular fa-image mr-1"></i> Lihat Bukti
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if ($transaksi->catatan)
                    <tr>
                        <td class="text-gray-400">Catatan</td>
                        <td class="text-gray-600">{{ $transaksi->catatan }}</td>
                    </tr>
                    @endif
                </table>
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