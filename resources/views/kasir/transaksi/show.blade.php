<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Transaksi - BeautyCare</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
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

        .float-icon {
            position: absolute;
            pointer-events: none;
            opacity: 0.08;
            font-size: 100px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-selesai {
            background: #E8F8EE;
            color: #22C55E;
        }

        .status-proses {
            background: #FEF3C7;
            color: #F59E0B;
        }

        .status-batal {
            background: #FDE8E8;
            color: #EF4444;
        }

        .info-box {
            background: #FFF8FA;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #FFE5EF;
        }

        .info-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #222;
            margin-top: 4px;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -6px rgba(0, 0, 0, 0.08);
        }

        .struk-line,
        .struk-row,
        .struk-total,
        .struk-footer,
        .struk-header,
        .struk-section,
        .struk-table,
        .struk-th,
        .struk-td,
        .struk-info {
            display: none;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html,
            body {
                width: 210mm;
                height: auto;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            body * {
                visibility: hidden;
            }

            .struk-area,
            .struk-area * {
                visibility: visible;
            }

            .struk-area {
                position: relative;
                width: 170mm;
                min-height: 267mm;
                margin: 15mm auto;
                padding: 0;
                font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
                font-size: 13px;
                color: #1a1a1a;
                background: #fff;
                display: flex;
                flex-direction: column;
            }

            .struk-area .no-print {
                display: none !important;
            }

            .struk-area .struk-header {
                display: block !important;
            }

            .struk-area .struk-section {
                display: block !important;
            }

            .struk-area .struk-info {
                display: block !important;
                padding: 10mm 0;
            }

            .struk-area .struk-line {
                display: block !important;
            }

            .struk-area .struk-row {
                display: flex !important;
                justify-content: space-between;
            }

            .struk-area .struk-total {
                display: flex !important;
                justify-content: space-between;
            }

            .struk-area .struk-footer {
                display: block !important;
            }

            .struk-area .struk-table {
                display: table !important;
                width: 100%;
                border-collapse: collapse;
            }

            .struk-area .struk-th {
                display: table-cell !important;
            }

            .struk-area .struk-td {
                display: table-cell !important;
            }

            .struk-header {
                text-align: center;
                padding-bottom: 6mm;
                border-bottom: 3px solid #FF4F87;
                margin-bottom: 5mm;
            }

            .struk-header .brand-name {
                font-size: 28px;
                font-weight: 800;
                color: #FF4F87;
                letter-spacing: 1px;
                margin: 0;
            }

            .struk-header .brand-tagline {
                font-size: 11px;
                color: #888;
                margin: 2px 0;
                font-weight: 400;
            }

            .struk-header .brand-detail {
                font-size: 11px;
                color: #666;
                margin: 1px 0;
            }

            .struk-header .invoice-title {
                font-size: 20px;
                font-weight: 700;
                color: #222;
                margin-top: 4mm;
                text-transform: uppercase;
                letter-spacing: 3px;
            }

            .struk-info {
                display: flex !important;
                justify-content: space-between;
                margin-bottom: 5mm;
                padding: 4mm 0;
                border-bottom: 1px dashed #ddd;
            }

            .struk-info .info-left {
                text-align: left;
            }

            .struk-info .info-right {
                text-align: right;
            }

            .struk-info p {
                margin: 1px 0;
                font-size: 12px;
                color: #444;
            }

            .struk-info .info-label-print {
                color: #888;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .struk-info .info-value-print {
                font-weight: 600;
                color: #222;
                font-size: 13px;
            }

            .struk-section .section-title {
                font-size: 12px;
                font-weight: 700;
                color: #FF4F87;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-bottom: 3mm;
                padding-bottom: 1mm;
                border-bottom: 2px solid #FF4F87;
            }

            .struk-table {
                margin-bottom: 5mm;
            }

            .struk-table thead {
                display: table-header-group;
            }

            .struk-table tbody {
                display: table-row-group;
            }

            .struk-table tr {
                display: table-row;
            }

            .struk-table th,
            .struk-table td {
                display: table-cell;
            }

            .struk-table thead th {
                font-size: 10px;
                font-weight: 700;
                color: #fff;
                background: #FF4F87;
                padding: 3mm 2mm;
                text-align: left;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .struk-table thead th:first-child {
                border-radius: 4px 0 0 0;
            }

            .struk-table thead th:last-child {
                border-radius: 0 4px 0 0;
            }

            .struk-table tbody td {
                font-size: 12px;
                color: #333;
                padding: 2.5mm 2mm;
                border-bottom: 1px solid #eee;
            }

            .struk-table tbody tr:nth-child(even) td {
                background: #fafafa;
            }

            .struk-summary {
                margin-top: 3mm;
                margin-left: auto;
                width: 60%;
                border-collapse: collapse;
            }

            .struk-summary td {
                font-size: 12px;
                padding: 2mm 2mm;
                color: #444;
            }

            .struk-summary td:last-child {
                text-align: right;
                font-weight: 600;
            }

            .struk-summary .total-row td {
                font-size: 16px;
                font-weight: 800;
                color: #FF4F87;
                border-top: 2px solid #333;
                padding-top: 3mm;
            }

            .struk-payment-detail {
                margin-top: 3mm;
                padding: 3mm;
                background: #f9f9f9;
                border-radius: 4px;
                border: 1px solid #eee;
            }

            .struk-payment-detail p {
                margin: 1px 0;
                font-size: 11px;
                color: #555;
            }

            .struk-footer {
                margin-top: auto;
                padding-top: 5mm;
                border-top: 3px double #FF4F87;
                text-align: center;
            }

            .struk-footer .footer-thanks {
                font-size: 16px;
                font-weight: 700;
                color: #FF4F87;
                margin: 0 0 2mm;
            }

            .struk-footer .footer-info {
                font-size: 10px;
                color: #888;
                margin: 1px 0;
            }
        }
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
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-20px;right:-5px;">📋</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-receipt text-pink-500 mr-2"></i>Detail Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-file-lines text-pink-300 mr-1"></i>
                                Informasi lengkap transaksi {{ $transaksi->no_invoice }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 no-print">
                            <button onclick="window.print()"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-solid fa-print"></i> Cetak Invoice
                            </button>
                            <a href="{{ route('kasir.transaksi.edit', $transaksi->id_transaksi) }}"
                                class="flex items-center gap-2 bg-amber-50 text-amber-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-amber-100 transition-colors">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <a href="{{ route('kasir.transaksi.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="struk-area">

                        <div class="struk-header">
                            <p class="brand-name">BEAUTYCARE</p>
                            <p class="brand-tagline">Salon &amp; Beauty Treatment</p>
                            <p class="brand-detail">Jl. Contoh No. 123, Kota</p>
                            <p class="brand-detail">Telp: 0812-3456-7890 | Email: info@beautycare.com</p>
                            <p class="invoice-title">Invoice</p>
                        </div>

                        <div class="struk-info">
                            <div class="info-left">
                                <p class="info-label-print">Kepada</p>
                                <p class="info-value-print">{{ $transaksi->pelanggan->nm_pelanggan ?? 'Umum' }}</p>
                                @if ($transaksi->pelanggan->no_hp ?? false)
                                    <p style="font-size:11px;color:#666;">{{ $transaksi->pelanggan->no_hp }}</p>
                                @endif
                                @if ($transaksi->pelanggan->alamat ?? false)
                                    <p style="font-size:11px;color:#666;">{{ $transaksi->pelanggan->alamat }}</p>
                                @endif
                            </div>
                            <div class="info-right">
                                <p class="info-label-print">No. Invoice</p>
                                <p class="info-value-print">{{ $transaksi->no_invoice }}</p>
                                <p style="margin-top:2mm;">
                                    <span class="info-label-print">Tanggal</span><br>
                                    <span
                                        class="info-value-print">{{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMMM YYYY') }}</span>
                                </p>
                                <p style="margin-top:2mm;">
                                    <span class="info-label-print">Status</span><br>
                                    @if ($transaksi->status == 1)
                                        <span style="color:#22C55E;font-weight:600;">LUNAS</span>
                                    @elseif ($transaksi->status == 0)
                                        <span style="color:#F59E0B;font-weight:600;">PENDING</span>
                                    @else
                                        <span style="color:#EF4444;font-weight:600;">BATAL</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="struk-section">
                            <p class="section-title">Detail Layanan</p>
                            <table class="struk-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%;text-align:center;">#</th>
                                        <th style="width:45%;">Layanan / Produk</th>
                                        <th style="width:12%;text-align:center;">Qty</th>
                                        <th style="width:18%;text-align:right;">Harga</th>
                                        <th style="width:20%;text-align:right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaksi->detail ?? [] as $item)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                                            <td>{{ $item->nm_item }}</td>
                                            <td style="text-align:center;">{{ $item->qty }}</td>
                                            <td style="text-align:right;">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td style="text-align:right;">Rp
                                                {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align:center;color:#999;">Tidak ada detail
                                                item</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 no-print mt-6 pt-6 border-t border-gray-100">
                            <div class="lg:col-span-1">
                                <div
                                    class="flex flex-col items-center bg-gradient-to-br from-pink-50/80 to-white rounded-2xl p-6 border border-pink-100/50">
                                    <div
                                        class="w-20 h-20 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-3xl mb-3 border-4 border-white shadow-sm">
                                        <i class="fa-regular fa-receipt"></i>
                                    </div>
                                    <h4 class="text-[15px] font-bold text-gray-800">{{ $transaksi->no_invoice }}</h4>
                                    <p class="text-[12px] text-gray-400">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}</p>

                                    @php
                                        $statusMap = [
                                            0 => [
                                                'label' => 'Proses',
                                                'class' => 'status-proses',
                                                'icon' => 'fa-regular fa-clock',
                                            ],
                                            1 => [
                                                'label' => 'Selesai',
                                                'class' => 'status-selesai',
                                                'icon' => 'fa-regular fa-circle-check',
                                            ],
                                            2 => [
                                                'label' => 'Batal',
                                                'class' => 'status-batal',
                                                'icon' => 'fa-regular fa-circle-xmark',
                                            ],
                                        ];
                                        $s = $statusMap[$transaksi->status] ?? $statusMap[0];
                                    @endphp
                                    <span class="mt-3 badge-status {{ $s['class'] }}">
                                        <i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}
                                    </span>

                                    <div class="w-full mt-4 pt-4 border-t border-pink-100/50 text-center">
                                        <p class="text-[11px] text-gray-400">Total Pembayaran</p>
                                        <p class="text-[22px] font-bold text-pink-500 mt-1">Rp
                                            {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                                    </div>

                                    @if ($transaksi->metode_byr !== 'Tunai' && $transaksi->bukti_bayar)
                                        <div class="w-full mt-4 pt-4 border-t border-pink-100/50 text-center">
                                            <p class="text-[11px] text-gray-400 mb-2">Bukti Pembayaran</p>
                                            <a href="{{ asset('storage/' . $transaksi->bukti_bayar) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}"
                                                    alt="Bukti Bayar"
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
                                        <p class="info-label"><i class="fa-regular fa-user mr-1 text-pink-300"></i>
                                            Pelanggan</p>
                                        <p class="info-value">{{ $transaksi->pelanggan->nm_pelanggan ?? '-' }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i class="fa-regular fa-hashtag mr-1 text-pink-300"></i>
                                            No.
                                            Invoice</p>
                                        <p class="info-value">{{ $transaksi->no_invoice }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i
                                                class="fa-regular fa-calendar mr-1 text-pink-300"></i>
                                            Tanggal</p>
                                        <p class="info-value">
                                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i
                                                class="fa-regular fa-credit-card mr-1 text-pink-300"></i>
                                            Metode</p>
                                        <p class="info-value">{{ $transaksi->metode_byr }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i
                                                class="fa-regular fa-money-bill-1 mr-1 text-pink-300"></i> Subtotal</p>
                                        <p class="info-value">Rp
                                            {{ number_format($transaksi->subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i
                                                class="fa-regular fa-money-bill-wave mr-1 text-pink-300"></i> Diskon
                                        </p>
                                        <p class="info-value text-red-500">- Rp
                                            {{ number_format($transaksi->diskon, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i class="fa-regular fa-percent mr-1 text-pink-300"></i>
                                            Pajak</p>
                                        <p class="info-value">+ Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i class="fa-regular fa-coins mr-1 text-pink-300"></i>
                                            Total
                                        </p>
                                        <p class="info-value text-pink-500">Rp
                                            {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i
                                                class="fa-regular fa-money-bill-1 mr-1 text-pink-300"></i> Dibayar</p>
                                        <p class="info-value">Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="info-box">
                                        <p class="info-label"><i class="fa-regular fa-coins mr-1 text-pink-300"></i>
                                            Kembali</p>
                                        <p class="info-value text-green-600">Rp
                                            {{ number_format($transaksi->kembali, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="info-box md:col-span-2">
                                        <p class="info-label"><i
                                                class="fa-regular fa-note-sticky mr-1 text-pink-300"></i>
                                            Catatan</p>
                                        <p class="info-value">{{ $transaksi->catatan ?: '-' }}</p>
                                    </div>
                                </div>

                                @if ($transaksi->metode_byr === 'Qris' && $transaksi->atas_nama)
                                    <div class="mt-4">
                                        <h4 class="text-[13px] font-bold text-purple-600 mb-3 flex items-center gap-2">
                                            <i class="fa-solid fa-qrcode"></i> Detail Pembayaran QRIS
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div class="info-box bg-purple-50/30 border-purple-100/50">
                                                <p class="info-label"><i
                                                        class="fa-regular fa-user mr-1 text-purple-400"></i> Atas Nama
                                                </p>
                                                <p class="info-value">{{ $transaksi->atas_nama }}</p>
                                            </div>
                                            @if ($transaksi->no_referensi)
                                                <div class="info-box bg-purple-50/30 border-purple-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-hashtag mr-1 text-purple-400"></i> No.
                                                        Referensi</p>
                                                    <p class="info-value">{{ $transaksi->no_referensi }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($transaksi->metode_byr === 'E-Wallet')
                                    <div class="mt-4">
                                        <h4 class="text-[13px] font-bold text-teal-600 mb-3 flex items-center gap-2">
                                            <i class="fa-solid fa-wallet"></i> Detail Pembayaran E-Wallet
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @if ($transaksi->atas_nama)
                                                <div class="info-box bg-teal-50/30 border-teal-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-user mr-1 text-teal-400"></i> Atas
                                                        Nama
                                                    </p>
                                                    <p class="info-value">{{ $transaksi->atas_nama }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->bank_asal)
                                                <div class="info-box bg-teal-50/30 border-teal-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-solid fa-wallet mr-1 text-teal-400"></i> E-Wallet
                                                    </p>
                                                    <p class="info-value">{{ $transaksi->bank_asal }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($transaksi->metode_byr !== 'Tunai' && $transaksi->metode_byr !== 'Qris' && $transaksi->metode_byr !== 'E-Wallet')
                                    <div class="mt-4">
                                        <h4 class="text-[13px] font-bold text-amber-600 mb-3 flex items-center gap-2">
                                            <i class="fa-regular fa-circle-info"></i> Detail Pembayaran
                                            {{ $transaksi->metode_byr }}
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @if ($transaksi->atas_nama)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-user mr-1 text-amber-400"></i> Atas
                                                        Nama
                                                    </p>
                                                    <p class="info-value">{{ $transaksi->atas_nama }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->bank_asal)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-building-columns mr-1 text-amber-400"></i>
                                                        Bank Asal</p>
                                                    <p class="info-value">{{ $transaksi->bank_asal }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->dari_rekening)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-arrow-right mr-1 text-amber-400"></i>
                                                        Dari
                                                        Rekening</p>
                                                    <p class="info-value">{{ $transaksi->dari_rekening }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->bank_tujuan)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-building-columns mr-1 text-amber-400"></i>
                                                        Bank Tujuan</p>
                                                    <p class="info-value">{{ $transaksi->bank_tujuan }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->ke_rekening)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-arrow-left mr-1 text-amber-400"></i>
                                                        Ke
                                                        Rekening</p>
                                                    <p class="info-value">{{ $transaksi->ke_rekening }}</p>
                                                </div>
                                            @endif
                                            @if ($transaksi->no_referensi)
                                                <div class="info-box bg-amber-50/30 border-amber-100/50">
                                                    <p class="info-label"><i
                                                            class="fa-regular fa-hashtag mr-1 text-amber-400"></i> No.
                                                        Referensi</p>
                                                    <p class="info-value">{{ $transaksi->no_referensi }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-pink-100/50 no-print">
                            <button onclick="window.print()"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-solid fa-print"></i> Cetak Invoice
                            </button>
                            <a href="{{ route('kasir.transaksi.edit', $transaksi->id_transaksi) }}"
                                class="flex items-center gap-2 bg-amber-50 text-amber-600 text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-amber-100 transition-colors">
                                <i class="fa-regular fa-pen-to-square"></i> Edit Transaksi
                            </a>
                            <form action="{{ route('kasir.transaksi.destroy', $transaksi->id_transaksi) }}"
                                method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $transaksi->no_invoice }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center gap-2 bg-red-50 text-red-500 text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-red-100 transition-colors">
                                    <i class="fa-regular fa-trash-can"></i> Hapus
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
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
