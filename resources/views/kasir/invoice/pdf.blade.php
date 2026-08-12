<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->no_invoice }} - BeautyCare</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #374151; margin: 0; }
        .invoice-card { padding: 10px 0 90px; }
        .invoice-header { border-bottom: 2px solid #FF4F87; padding-bottom: 16px; margin-bottom: 20px; }
        .invoice-header td { vertical-align: top; }
        .brand-name { font-size: 26px; font-weight: 800; color: #FF4F87; letter-spacing: 1px; margin: 0; }
        .brand-sub { font-size: 10px; color: #6B7280; margin-top: 2px; }
        .brand-contact { font-size: 10px; color: #9CA3AF; margin-top: 2px; }
        .invoice-title { font-size: 20px; font-weight: 700; color: #1F2937; text-transform: uppercase; letter-spacing: 3px; margin: 0; text-align: right; }
        .invoice-no { font-size: 12px; font-weight: 600; color: #374151; margin-top: 6px; text-align: right; font-family: 'DejaVu Sans Mono', monospace; }
        .info-section { margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px dashed #E5E7EB; }
        .info-label-mini { font-size: 9px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .customer-name { font-size: 14px; font-weight: 700; color: #1F2937; margin: 0; }
        .customer-meta { font-size: 11px; color: #6B7280; margin: 2px 0; }
        .meta-table td { font-size: 11px; padding: 2px 0; }
        .meta-table td:first-child { color: #9CA3AF; padding-right: 16px; }
        .meta-table td:last-child { font-weight: 600; color: #374151; }
        .badge-status { display: inline-block; padding: 3px 10px; border-radius: 100px; font-size: 10px; font-weight: 700; }
        .status-selesai { background: #E8F8EE; color: #16A34A; }
        .status-proses { background: #FEF3C7; color: #D97706; }
        .status-batal { background: #FDE8E8; color: #DC2626; }
        .section-title { font-size: 11px; font-weight: 800; color: #FF4F87; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #FF4F87; padding-bottom: 6px; margin-bottom: 12px; }
        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .item-table th { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 10px; background: #F9FAFB; color: #6B7280; border-bottom: 2px solid #E5E7EB; }
        .item-table td { padding: 8px 10px; font-size: 11px; color: #374151; border-bottom: 1px solid #F3F4F6; }
        .item-table tbody tr:last-child td { border-bottom: none; }
        .summary-table { width: 280px; margin-left: auto; }
        .summary-table td { padding: 4px 0; font-size: 12px; }
        .summary-table td:last-child { text-align: right; font-weight: 600; }
        .summary-table .total-row td { border-top: 2px solid #1F2937; padding-top: 8px; }
        .grand-total { font-size: 17px; font-weight: 800; color: #FF4F87; }
        .payment-box { background: #F9FAFB; border: 1px solid #F3F4F6; padding: 12px 14px; margin-bottom: 20px; }
        .payment-table { width: 100%; font-size: 11px; }
        .payment-table td { padding: 3px 0; }
        .payment-table td:first-child { color: #9CA3AF; width: 130px; }
        .payment-table td:last-child { font-weight: 600; color: #374151; }
        .payment-img { text-align: center; margin: 12px 0; }
        .payment-img img { max-width: 200px; border: 1px solid #E5E7EB; border-radius: 8px; }
        .footer-thanks { position: fixed; bottom: 0; left: 0; right: 0; width: 100%; border-top: 2px solid #FF4F87; padding-top: 14px; text-align: center; }
        .thanks-title { font-size: 15px; font-weight: 700; color: #FF4F87; margin: 0; }
        .thanks-sub { font-size: 10px; color: #9CA3AF; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="invoice-card">

        <table class="invoice-header" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <p class="brand-name">BEAUTYCARE</p>
                    <p class="brand-sub">Salon &amp; Beauty Treatment</p>
                    <p class="brand-contact">Jl. Contoh No. 123, Kota</p>
                    <p class="brand-contact">Telp: 0812-3456-7890 | info@beautycare.com</p>
                </td>
                <td style="text-align:right;">
                    <p class="invoice-title">INVOICE</p>
                    <p class="invoice-no">{{ $transaksi->no_invoice }}</p>
                </td>
            </tr>
        </table>

        <table class="info-section" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div class="info-label-mini">Kepada</div>
                    <p class="customer-name">{{ $transaksi->pelanggan->nm_pelanggan ?? 'Umum' }}</p>
                    @if ($transaksi->pelanggan->no_hp ?? false)
                        <p class="customer-meta">{{ $transaksi->pelanggan->no_hp }}</p>
                    @endif
                    @if ($transaksi->pelanggan->alamat ?? false)
                        <p class="customer-meta">{{ $transaksi->pelanggan->alamat }}</p>
                    @endif
                </td>
                <td style="text-align:right;">
                    <table class="meta-table" align="right">
                        <tr>
                            <td>Tanggal</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                @php
                                    $statusMap = [
                                        'Pending' => ['label' => 'Pending', 'class' => 'status-proses'],
                                        'Lunas' => ['label' => 'Lunas', 'class' => 'status-selesai'],
                                        'Batal' => ['label' => 'Batal', 'class' => 'status-batal'],
                                    ];
                                    $s = $statusMap[$transaksi->status] ?? $statusMap['Pending'];
                                @endphp
                                <span class="badge-status {{ $s['class'] }}">{{ $s['label'] }}</span>
                            </td>
                        </tr>
                        @if ($transaksi->kasir || $transaksi->user)
                        <tr>
                            <td>Kasir</td>
                            <td>{{ $transaksi->kasir?->nama ?? $transaksi->user?->nama }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <div class="section-title">Detail Layanan &amp; Produk</div>
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width:5%; text-align:center;">#</th>
                    <th style="width:48%;">Item</th>
                    <th style="width:10%; text-align:center;">Qty</th>
                    <th style="width:17%; text-align:right;">Harga</th>
                    <th style="width:20%; text-align:right;">Subtotal</th>
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
                        <td colspan="5" style="text-align:center; color:#9CA3AF; padding:16px;">Tidak ada detail item</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="summary-table" cellpadding="0" cellspacing="0">
            <tr>
                <td>Subtotal</td>
                <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td style="color:#DC2626;">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pajak</td>
                <td>+ Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td style="font-weight:700; color:#1F2937;">Grand Total</td>
                <td class="grand-total">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Dibayar</td>
                <td>Rp {{ number_format($transaksi->dibayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td style="color:#16A34A;">Rp {{ number_format($transaksi->kembali, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="height:20px;"></div>

        <div class="payment-box">
            <table class="payment-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td>Metode</td>
                    <td>{{ $transaksi->metode_byr }}</td>
                </tr>
                @if ($transaksi->no_referensi)
                <tr>
                    <td>No. Referensi</td>
                    <td>{{ $transaksi->no_referensi }}</td>
                </tr>
                @endif
                @if ($transaksi->ewallet_type && $transaksi->metode_byr === 'E-Wallet')
                <tr>
                    <td>E-Wallet</td>
                    <td>{{ $transaksi->ewallet_type }}</td>
                </tr>
                @endif
                @if ($transaksi->catatan)
                <tr>
                    <td>Catatan</td>
                    <td>{{ $transaksi->catatan }}</td>
                </tr>
                @endif
            </table>
        </div>

        @if ($transaksi->bukti_bayar && file_exists(public_path('storage/' . $transaksi->bukti_bayar)))
        <div class="payment-img">
            <p style="font-size:10px; color:#9CA3AF; margin-bottom:6px;">Bukti Pembayaran</p>
            <img src="{{ public_path('storage/' . $transaksi->bukti_bayar) }}" alt="Bukti Bayar">
        </div>
        @endif

        <div class="footer-thanks">
            <p class="thanks-title">Terima Kasih</p>
            <p class="thanks-sub">Semoga puas dengan layanan kami</p>
            <p class="thanks-sub">BeautyCare Salon &amp; Beauty Treatment</p>
        </div>

    </div>
</body>
</html>
