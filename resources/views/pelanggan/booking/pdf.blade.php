<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Booking #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }} - BeautyCare</title>
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
        .section-title { font-size: 12px; font-weight: 800; color: #1F2937; margin-bottom: 4px; }
        .section-sub { font-size: 10px; color: #9CA3AF; margin-bottom: 10px; }
        .divider { border-bottom: 1px solid #E5E7EB; margin: 16px 0; }
        .detail-grid { width: 100%; }
        .detail-item { margin-bottom: 8px; }
        .di-label { font-size: 9px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; }
        .di-value { font-size: 13px; font-weight: 500; color: #1F2937; margin-top: 2px; }
        .services-table { width: 100%; border-collapse: collapse; }
        .services-table th { padding: 8px 10px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: #FAFAFA; color: #9CA3AF; border-bottom: 1px solid #E5E7EB; }
        .services-table td { padding: 8px 10px; font-size: 11px; color: #1F2937; border-bottom: 1px solid #F5F5F5; }
        .price-summary { width: 320px; margin-left: auto; margin-top: 12px; }
        .ps-row { padding: 4px 0; font-size: 12px; }
        .ps-label { color: #6B7280; }
        .ps-value { font-weight: 600; color: #1F2937; }
        .ps-row.ps-total { border-top: 2px solid #1F2937; padding-top: 8px; font-weight: 800; }
        .ps-row.ps-total .ps-value { font-size: 15px; color: #FF4F87; }
        .catatan-text { font-size: 12px; color: #1F2937; margin: 0; }
        .footer-note { position: fixed; bottom: 0; left: 0; right: 0; width: 100%; text-align: center; font-size: 10px; color: #9CA3AF; border-top: 1px solid #E5E7EB; padding-top: 10px; }
    </style>
</head>
<body>
    <table class="doc-header" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <p class="doc-title">Detail Booking #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</p>
                <p class="doc-subtitle">Informasi lengkap booking treatment Anda</p>
            </td>
            <td style="text-align:right;">
                <span class="status-badge {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Jadwal Treatment</div>
    <div class="section-sub">Tanggal dan jam booking treatment</div>
    <table class="detail-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:50%;">
                <div class="detail-item">
                    <div class="di-label">Tanggal</div>
                    <div class="di-value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</div>
                </div>
            </td>
            <td style="width:50%;">
                <div class="detail-item">
                    <div class="di-label">Jam</div>
                    <div class="di-value">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="section-title">Beauty Therapist</div>
    <div class="section-sub">Terapis yang akan menangani treatment Anda</div>
    <div class="di-value">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #' . $booking->id_karyawan }}</div>

    <div class="divider"></div>

    <div class="section-title">Layanan Treatment</div>
    <div class="section-sub">Daftar layanan yang akan dilakukan</div>
    <table class="services-table">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Layanan</th>
                <th style="text-align:right;">Harga</th>
                <th style="text-align:right;">Diskon</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalHarga = 0; $totalDiskon = 0; $totalSubtotal = 0; @endphp
            @foreach($booking->detail as $i => $d)
            @php
                $totalHarga += $d->harga;
                $totalDiskon += $d->diskon;
                $totalSubtotal += $d->subtotal;
            @endphp
            <tr>
                <td style="color:#9CA3AF;">{{ $i + 1 }}</td>
                <td>
                    <span style="font-weight:600;">{{ $d->layanan ? $d->layanan->nm_layanan : '-' }}</span>
                </td>
                <td style="text-align:right;">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                <td style="text-align:right; color:#DC2626;">- Rp {{ number_format($d->diskon, 0, ',', '.') }}</td>
                <td style="text-align:right; font-weight:600;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="price-summary" cellpadding="0" cellspacing="0">
        <tr>
            <td class="ps-label">Total Harga</td>
            <td class="ps-value" style="text-align:right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="ps-label">Total Diskon</td>
            <td class="ps-value" style="text-align:right; color:#DC2626;">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</td>
        </tr>
        <tr class="ps-total">
            <td>Total Bayar</td>
            <td style="text-align:right;">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
        </tr>
    </table>

    @if($booking->catatan)
    <div class="divider"></div>
    <div class="section-title">Catatan</div>
    <div class="section-sub">Pesan tambahan untuk terapis</div>
    <p class="catatan-text">{{ $booking->catatan }}</p>
    @endif

    <div class="footer-note">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>
