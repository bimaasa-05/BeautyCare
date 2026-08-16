<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Treatment #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }} - BeautyCare</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #374151; margin: 0; padding-bottom: 70px; }
        .doc-title { font-size: 18px; font-weight: 800; color: #1F2937; margin: 0; }
        .doc-subtitle { font-size: 11px; color: #9CA3AF; margin-top: 2px; }
        .doc-header { border-bottom: 2px solid #FF4F87; padding-bottom: 12px; margin-bottom: 16px; }
        .doc-header td { vertical-align: middle; }
        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 100px; font-size: 11px; font-weight: 700; }
        .status-badge.menunggu { background: #FEF3C7; color: #D97706; }
        .status-badge.dikonfirmasi { background: #DBEAFE; color: #2563EB; }
        .status-badge.diproses { background: #F3E8FF; color: #9333EA; }
        .status-badge.selesai { background: #D1FAE5; color: #059669; }
        .status-badge.dibatalkan { background: #FEE2E2; color: #DC2626; }
        .section-box { border: 1px solid #E5E7EB; border-radius: 10px; padding: 14px 16px; margin-bottom: 14px; }
        .section-title { font-size: 12px; font-weight: 800; color: #1F2937; margin-bottom: 10px; }
        .info-table { width: 100%; }
        .info-table td { padding: 4px 0; font-size: 11px; vertical-align: top; }
        .info-table td.label { width: 110px; color: #9CA3AF; }
        .info-table td.value { font-weight: 500; color: #1F2937; }
        .divider { border-bottom: 1px solid #E5E7EB; margin: 16px 0; }
        .section-title2 { font-size: 12px; font-weight: 800; color: #1F2937; margin-bottom: 10px; }
        .service-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .service-table th { padding: 8px 10px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: #FAFAFA; color: #9CA3AF; border-bottom: 1px solid #E5E7EB; text-align: left; }
        .service-table td { padding: 8px 10px; font-size: 11px; color: #1F2937; border-bottom: 1px solid #F5F5F5; }
        .service-table .total-row td { font-weight: 700; border-top: 2px solid #E5E7EB; border-bottom: none; }
        .text-right { text-align: right; }
        .pay-item { margin-bottom: 8px; }
        .pay-label { font-size: 9px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; }
        .pay-value { font-size: 13px; font-weight: 600; color: #1F2937; margin-top: 2px; }
        .pay-total { font-size: 18px; font-weight: 800; color: #1F2937; margin-top: 2px; }
        .photo-pair td { vertical-align: top; }
        .photo-card { border: 1px solid #E5E7EB; border-radius: 8px; overflow: hidden; margin-right: 12px; }
        .photo-card img { width: 100%; max-width: 240px; display: block; }
        .photo-label { padding: 6px; font-size: 9px; font-weight: 700; color: #9CA3AF; background: #FAFAFA; text-align: center; }
        .footer-note { position: fixed; bottom: 0; left: 0; right: 0; width: 100%; text-align: center; font-size: 10px; color: #9CA3AF; border-top: 1px solid #E5E7EB; padding-top: 10px; }
    </style>
</head>
<body>
    <table class="doc-header" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <p class="doc-title">Detail Treatment</p>
                <p class="doc-subtitle">Informasi lengkap treatment Anda</p>
            </td>
            <td style="text-align:right;">
                <span class="status-badge {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:50%; padding-right:10px;">
                <div class="section-box">
                    <div class="section-title">Informasi Pelanggan</div>
                    <table class="info-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="label">Nama</td>
                            <td class="value">{{ $booking->pelanggan->nm_pelanggan ?? auth()->user()->nama }}</td>
                        </tr>
                        <tr>
                            <td class="label">No HP</td>
                            <td class="value">{{ $booking->pelanggan->no_hp ?? auth()->user()->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td class="value">{{ $booking->pelanggan->email ?? auth()->user()->email }}</td>
                        </tr>
                        @if($booking->pelanggan && $booking->pelanggan->catatan_alergi)
                        <tr>
                            <td class="label">Catatan Alergi</td>
                            <td class="value" style="color:#DC2626;">{{ $booking->pelanggan->catatan_alergi }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </td>
            <td style="width:50%; padding-left:10px;">
                <div class="section-box">
                    <div class="section-title">Detail Booking</div>
                    <table class="info-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="label">ID Booking</td>
                            <td class="value">#BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jam</td>
                            <td class="value">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Terapis</td>
                            <td class="value">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #' . $booking->id_karyawan }}</td>
                        </tr>
                        @if($booking->catatan)
                        <tr>
                            <td class="label">Catatan</td>
                            <td class="value">{{ $booking->catatan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title2">Layanan Treatment</div>
    <table class="service-table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse($booking->detail as $detail)
            @php
                $harga = $detail->layanan ? $detail->layanan->harga : $detail->harga;
                $subtotal = $detail->subtotal;
                $total += $subtotal;
            @endphp
            <tr>
                <td>{{ $detail->layanan ? $detail->layanan->nm_layanan : 'Layanan #' . $detail->id_layanan }}</td>
                <td class="text-right">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->diskon ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#9CA3AF; padding:16px;">Tidak ada detail layanan</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align:right; font-size:12px;">Total</td>
                <td class="text-right" style="font-size:14px;">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($booking->transaksi)
    <div class="divider"></div>
    <div class="section-title2">Informasi Pembayaran</div>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="pay-item" style="width:33%;">
                <div class="pay-label">Status Bayar</div>
                <div class="pay-value">{{ $booking->transaksi->status }}</div>
            </td>
            <td class="pay-item" style="width:33%;">
                <div class="pay-label">Metode Bayar</div>
                <div class="pay-value">{{ $booking->transaksi->metode_byr ?? '-' }}</div>
            </td>
            <td class="pay-item" style="width:34%; text-align:right;">
                <div class="pay-label">Total Bayar</div>
                <div class="pay-total">Rp {{ number_format($booking->status_pembayaran === 'lunas' ? $total : $booking->transaksi->total, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>
    @endif

    @if($booking->riwayatTreatment)
    <div class="divider"></div>
    <div class="section-title2">Dokumentasi Treatment</div>
    <table class="photo-pair" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="photo-card">
                    @if($booking->riwayatTreatment->sebelum_foto && file_exists(public_path('storage/' . $booking->riwayatTreatment->sebelum_foto)))
                        <img src="{{ public_path('storage/' . $booking->riwayatTreatment->sebelum_foto) }}" alt="Sebelum Treatment">
                    @endif
                    <div class="photo-label">Sebelum Treatment</div>
                </div>
            </td>
            <td>
                <div class="photo-card">
                    @if($booking->riwayatTreatment->sesudah_foto && file_exists(public_path('storage/' . $booking->riwayatTreatment->sesudah_foto)))
                        <img src="{{ public_path('storage/' . $booking->riwayatTreatment->sesudah_foto) }}" alt="Sesudah Treatment">
                    @endif
                    <div class="photo-label">Sesudah Treatment</div>
                </div>
            </td>
        </tr>
    </table>
    @endif

    <div class="footer-note">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>
