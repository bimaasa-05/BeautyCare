<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Treatment - BeautyCare</title>
    @php $printMode = request('print') === '1'; @endphp
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @if(!$printMode)
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @endif

    <style>
    .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.3); z-index: 90; }
    .sidebar-overlay.active { display: block; }
    @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    .detail-card { background: var(--white); border-radius: 20px; box-shadow: 0 2px 12px -4px rgba(0,0,0,0.06); overflow: hidden; }
    .detail-card .dc-header { padding: 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .detail-card .dc-header .dc-title-wrap { display: flex; align-items: center; gap: 12px; }
    .detail-card .dc-header .dc-title-icon { width: 40px; height: 40px; border-radius: 12px; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .detail-card .dc-header .dc-title { font-size: 18px; font-weight: 700; color: var(--dark); }
    .detail-card .dc-header .dc-subtitle { font-size: 12px; color: var(--gray); margin-top: 2px; }
    .detail-card .dc-body { padding: 24px; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }

    .detail-section { border: 1px solid var(--border); border-radius: 16px; padding: 20px; }
    .detail-section .ds-header { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .detail-section .ds-header i { color: var(--primary); font-size: 16px; }

    .info-row { display: flex; padding: 7px 0; border-bottom: 1px solid #F5F5F5; }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label { width: 110px; font-size: 12px; color: var(--gray); flex-shrink: 0; }
    .info-row .info-value { flex: 1; font-size: 13px; color: var(--dark); font-weight: 500; }

    .detail-divider { height: 1px; background: var(--border); margin: 24px 0; }

    .detail-section-title { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .detail-section-title i { color: var(--primary); }

    .service-table { width: 100%; border-collapse: collapse; }
    .service-table thead th { padding: 10px 12px; font-size: 11px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; background: #FAFAFA; border-bottom: 1px solid var(--border); text-align: left; }
    .service-table tbody td { padding: 10px 12px; font-size: 13px; color: var(--dark); border-bottom: 1px solid #F5F5F5; }
    .service-table tbody tr:last-child td { border-bottom: none; }
    .service-table .text-right { text-align: right; }
    .total-row td { font-weight: 700; padding-top: 14px; border-top: 2px solid var(--border); }

    .photo-pair { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .photo-card { position: relative; border-radius: 16px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 2px 10px -4px rgba(0,0,0,0.08); }
    .photo-card img { width: 100%; height: auto; display: block; transition: transform 0.3s ease; }
    .photo-card:hover img { transform: scale(1.04); }
    .photo-card .photo-label { position: absolute; left: 12px; bottom: 12px; padding: 6px 14px; font-size: 11px; font-weight: 700; color: #fff; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); border-radius: 100px; text-align: center; display: inline-flex; align-items: center; gap: 6px; }
    .photo-card .photo-label i { font-size: 8px; }
    .photo-card.empty-photo { display: flex; align-items: center; justify-content: center; height: 240px; background: #FAFAFA; color: #CBD5E1; flex-direction: column; gap: 8px; border: 2px dashed #E5E7EB; border-radius: 16px; }
    .photo-card.empty-photo i { font-size: 36px; }

    .beautycian-strip { display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: linear-gradient(135deg, #FFF5F7, #FDF2F8); border: 1px solid #FBCFE8; border-radius: 14px; margin-bottom: 18px; }
    .beautycian-strip .bs-avatar { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; flex-shrink: 0; border: 2px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.10); }
    .beautycian-strip .bs-name { font-size: 14px; font-weight: 700; color: var(--dark); }
    .beautycian-strip .bs-role { font-size: 12px; color: var(--gray); margin-top: 2px; }
    .beautycian-strip .bs-role i { margin-right: 4px; color: var(--primary); }

    .doc-sub-title { font-size: 12px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; margin: 20px 0 10px; }
    .doc-sub-title i { color: var(--primary); }

    .produk-chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .produk-chip { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: #FDF2F8; border: 1px solid #FBCFE8; color: #BE185D; font-size: 12px; font-weight: 600; border-radius: 100px; }
    .produk-chip i { font-size: 11px; }

    .beautycian-note { display: flex; gap: 12px; padding: 14px 16px; background: #FFF7ED; border: 1px solid #FED7AA; border-left: 4px solid #F97316; border-radius: 12px; }
    .beautycian-note > i { color: #F97316; font-size: 16px; margin-top: 2px; flex-shrink: 0; }
    .beautycian-note .bn-label { font-size: 10px; font-weight: 700; color: #C2410C; text-transform: uppercase; letter-spacing: 0.5px; }
    .beautycian-note .bn-text { font-size: 13px; color: var(--dark); margin-top: 4px; line-height: 1.7; }

    .doc-empty { display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 40px 20px; background: #FAFAFA; border: 2px dashed #E5E7EB; border-radius: 16px; color: var(--gray); text-align: center; }
    .doc-empty i { font-size: 40px; color: #CBD5E1; }

    .pay-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    @media (max-width: 768px) { .pay-cards { grid-template-columns: 1fr; } }
    .pay-card { border: 1px solid var(--border); border-radius: 14px; padding: 16px; background: #FAFAFA; display: flex; flex-direction: column; gap: 6px; }
    .pay-card .pc-icon { width: 34px; height: 34px; border-radius: 10px; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 15px; }
    .pay-card .pc-label { font-size: 10px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
    .pay-card .pc-value { font-size: 14px; font-weight: 600; color: var(--dark); }
    .pay-card .pc-value.total { font-size: 20px; font-weight: 700; color: var(--primary); }
    .pay-card.total-card { background: linear-gradient(135deg, #FFF1F4, #FDF2F8); border-color: #FBCFE8; }

    .pay-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; letter-spacing: 0.2px; }
    .pay-badge .pb-dot { width: 6px; height: 6px; border-radius: 50%; }
    .pay-badge.lunas { background: #D1FAE5; color: #059669; }
    .pay-badge.lunas .pb-dot { background: #059669; }
    .pay-badge.pending { background: #FEF3C7; color: #D97706; }
    .pay-badge.pending .pb-dot { background: #D97706; }
    .pay-badge.dibatalkan { background: #FEE2E2; color: #DC2626; }
    .pay-badge.dibatalkan .pb-dot { background: #DC2626; }
    .pay-badge.umum { background: #F3F4F6; color: #6B7280; }
    .pay-badge.umum .pb-dot { background: #6B7280; }

    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; letter-spacing: 0.2px; }
    .status-badge .sb-dot { width: 6px; height: 6px; border-radius: 50%; animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    .status-badge.menunggu { background: #FEF3C7; color: #D97706; }
    .status-badge.menunggu .sb-dot { background: #D97706; }
    .status-badge.dikonfirmasi { background: #DBEAFE; color: #2563EB; }
    .status-badge.dikonfirmasi .sb-dot { background: #2563EB; }
    .status-badge.diproses { background: #F3E8FF; color: #9333EA; }
    .status-badge.diproses .sb-dot { background: #9333EA; }
    .status-badge.selesai { background: #D1FAE5; color: #059669; }
    .status-badge.selesai .sb-dot { background: #059669; }
    .status-badge.dibatalkan { background: #FEE2E2; color: #DC2626; }
    .status-badge.dibatalkan .sb-dot { background: #DC2626; }

    .action-bar { display: flex; align-items: center; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); }
    .btn-action { padding: 10px 24px; border-radius: 100px; font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif; border: none; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-action.btn-back { background: var(--hover); color: var(--dark); }
    .btn-action.btn-back:hover { background: #E5E7EB; }
    .btn-action.btn-print { background: var(--hover); color: var(--primary); }
    .btn-action.btn-print:hover { background: #FFD6E4; box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2); }

    @media (max-width: 768px) {
        .detail-card .dc-body { padding: 16px; }
        .detail-section { padding: 16px; }
        .photo-pair { grid-template-columns: 1fr; }
        .photo-card.empty-photo { height: 180px; }
        .action-bar { flex-wrap: wrap; }
    }

    @media (max-width: 576px) {
        .detail-card .dc-header { padding: 16px; }
        .btn-action { flex: 1; justify-content: center; }
    }

    @media print {
        .sidebar-toggle, .sidebar-overlay, .action-bar, .no-print { display: none !important; }
        .sidebar { display: none !important; }
        header, .header2, .navbar-top, .main-content > .header2, .dashboard-content > .page-header-premium { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .dashboard-layout { display: block !important; }
        .dashboard-content { padding: 20px !important; }
        .detail-card { box-shadow: none; border: 1px solid #ddd; }
        body { background: white; }
    }

    /* ─── Dokumen Cetak Standalone (?print=1) ─── */
    .print-toolbar { display: flex; justify-content: center; align-items: center; gap: 10px; padding: 18px 16px 8px; flex-wrap: wrap; }
    .print-toolbar .btn-print { display: inline-flex; align-items: center; gap: 8px; background: var(--primary); color: #fff; font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif; padding: 10px 26px; border: none; border-radius: 100px; cursor: pointer; box-shadow: 0 4px 14px rgba(255, 79, 135, 0.3); transition: all 0.2s ease; }
    .print-toolbar .btn-print:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255, 79, 135, 0.4); }
    .print-toolbar .btn-close { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: var(--gray); font-size: 13px; font-weight: 600; font-family: 'Poppins', sans-serif; padding: 10px 26px; border: 1.5px solid var(--border); border-radius: 100px; cursor: pointer; transition: all 0.2s ease; }
    .print-toolbar .btn-close:hover { background: #F5F5F5; }

    .invoice-page { max-width: 210mm; margin: 0 auto; min-height: 297mm; padding: 8px 16px 40px; }
    @media (max-width: 768px) {
        .invoice-page { max-width: 100%; min-height: 0; }
        .brand-head { flex-direction: column; align-items: flex-start; gap: 12px; }
        .brand-head .text-right { text-align: left; }
        .info-block { flex-direction: column; gap: 14px; }
        .info-block .text-right { text-align: left; }
    }
    .invoice-card { background: #fff; border-radius: 0; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }

    .brand-head { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--primary); padding-bottom: 18px; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
    .brand-name { font-size: 26px; font-weight: 800; color: var(--primary); letter-spacing: 1px; margin: 0; }
    .brand-sub { font-size: 12px; color: var(--gray); margin: 2px 0 0; }
    .doc-title { font-size: 20px; font-weight: 700; color: var(--dark); text-transform: uppercase; letter-spacing: 2px; margin: 0; }
    .doc-meta { font-size: 13px; font-weight: 600; color: var(--dark); margin-top: 6px; letter-spacing: 0.5px; }
    .doc-print-time { font-size: 10px; color: var(--gray); margin-top: 4px; }

    .info-block { display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-bottom: 22px; padding-bottom: 18px; border-bottom: 1px dashed #E5E7EB; }
    .info-block .ib-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--gray); margin: 0 0 6px; }
    .info-block p { margin: 2px 0; font-size: 13px; }
    .info-block .val { font-weight: 600; color: var(--dark); }
    .info-block .val.alert { color: #DC2626; }
    .info-block .meta-table td { padding: 3px 0; font-size: 12.5px; vertical-align: top; }
    .info-block .meta-table td.label { color: var(--gray); padding-right: 16px; white-space: nowrap; }
    .info-block .meta-table td.value { font-weight: 600; color: var(--dark); }

    .print-section-title { font-size: 12px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px; margin: 22px 0 12px; padding-bottom: 6px; border-bottom: 2px solid var(--primary); display: flex; align-items: center; gap: 8px; }

    .item-table { width: 100%; border-collapse: collapse; }
    .item-table th { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 12px; background: #F9FAFB; color: #6B7280; border-bottom: 2px solid #E5E7EB; text-align: left; }
    .item-table td { padding: 10px 12px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3F4F6; }
    .item-table tbody tr:last-child td { border-bottom: none; }
    .item-table .text-right { text-align: right; }
    .item-table .total-row td { font-weight: 800; font-size: 14px; border-top: 2px solid #E5E7EB; }
    .item-table .total-row .grand { color: var(--primary); }

    .pay-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 12px; }
    @media (max-width: 768px) { .pay-summary { grid-template-columns: 1fr; } }
    .pay-item { background: #F9FAFB; border: 1px solid #F3F4F6; border-radius: 10px; padding: 12px 14px; }
    .pay-item .label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray); font-weight: 600; }
    .pay-item .value { font-size: 14px; font-weight: 700; color: var(--dark); margin-top: 3px; }
    .pay-item .value.primary { color: var(--primary); font-size: 18px; }
    .pay-item .value.lunas { color: #059669; }
    .pay-item .value.pending { color: #D97706; }
    .pay-item .value.dibatalkan { color: #DC2626; }
    .pay-item .value.umum { color: #6B7280; }

    .print-photo-pair { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 12px; }
    @media (max-width: 576px) { .print-photo-pair { grid-template-columns: 1fr; } }
    .print-photo-card { border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .print-photo-card img { width: 100%; height: 200px; object-fit: cover; display: block; }
    .print-photo-card .photo-label { padding: 8px; font-size: 11px; font-weight: 600; color: var(--gray); background: #FAFAFA; text-align: center; }
    .print-photo-card .print-photo-empty { display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 8px; height: 200px; background: #FAFAFA; border: 1.5px dashed #D1D5DB; color: #9CA3AF; }
    .print-photo-card .print-photo-empty i { font-size: 28px; }

    .print-footer { border-top: 2px solid var(--primary); padding-top: 16px; margin-top: 28px; text-align: center; }
    .print-footer .thanks { font-size: 15px; font-weight: 700; color: var(--primary); margin: 0; }
    .print-footer .note { font-size: 11px; color: var(--gray); margin: 6px 0 0; }

    @media print {
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        .invoice-page { min-height: 0; padding: 0; }
        .invoice-card { box-shadow: none; border-radius: 0; }
        .brand-head, .info-block, .pay-summary, .print-photo-pair, .print-photo-card, .print-footer { page-break-inside: avoid; break-inside: avoid; }
        .print-section-title { page-break-after: avoid; break-after: avoid; }
        .status-badge .sb-dot { animation: none; }
        @page { size: A4; margin: 15mm; }
    }
    </style>
</head>

<body>
    @if($printMode)
    <div class="print-toolbar no-print">
        <button type="button" class="btn-print" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
        <button type="button" class="btn-close" onclick="window.close()">
            <i class="fa-solid fa-xmark"></i> Tutup
        </button>
    </div>

    <div class="invoice-page">
        <div class="invoice-card">
            <div class="brand-head">
                <div>
                    <h1 class="brand-name">BEAUTYCARE</h1>
                    <p class="brand-sub">Salon &amp; Beauty Treatment</p>
                    <p class="brand-sub">Jl. Contoh No. 123, Kota &bull; Telp: 0812-3456-7890 &bull; info@beautycare.com</p>
                </div>
                <div class="text-right">
                    <h2 class="doc-title">Detail Treatment</h2>
                    <p class="doc-meta">#BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</p>
                    <p class="doc-print-time">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="info-block">
                <div>
                    <p class="ib-title">Kepada</p>
                    <p class="val">{{ $booking->pelanggan->nm_pelanggan ?? auth()->user()->nama }}</p>
                    <p>{{ $booking->pelanggan->no_hp ?? auth()->user()->no_hp ?? '-' }}</p>
                    <p>{{ $booking->pelanggan->email ?? auth()->user()->email }}</p>
                    @if($booking->pelanggan && $booking->pelanggan->catatan_alergi)
                    <p class="val alert"><i class="fa-solid fa-triangle-exclamation"></i> Alergi: {{ $booking->pelanggan->catatan_alergi }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <table class="meta-table">
                        <tr>
                            <td class="label">Tanggal</td>
                            <td class="value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        @php
                            $durasiMenit = \App\Support\BookingSlot::durasiBooking($booking);
                            $jamSelesaiEstimasi = \Carbon\Carbon::parse($booking->tanggal . ' ' . substr($booking->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                        @endphp
                        <tr>
                            <td class="label">Jam</td>
                            <td class="value font-mono">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} - {{ $jamSelesaiEstimasi }}</td>
                        </tr>
                        @if($booking->status === 'selesai' && $booking->jam_mulai_aktual && $booking->jam_selesai_aktual)
                        <tr>
                            <td class="label">Mulai Aktual</td>
                            <td class="value font-mono">{{ \Carbon\Carbon::parse($booking->jam_mulai_aktual)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Selesai Aktual</td>
                            <td class="value font-mono">{{ \Carbon\Carbon::parse($booking->jam_selesai_aktual)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Durasi</td>
                            <td class="value font-mono">{{ gmdate('H:i:s', \Carbon\Carbon::parse($booking->jam_mulai_aktual)->diffInSeconds(\Carbon\Carbon::parse($booking->jam_selesai_aktual))) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label">Terapis</td>
                            <td class="value">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #'.$booking->id_karyawan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Status</td>
                            <td class="value">
                                <span class="status-badge {{ $booking->status }}">
                                    <span class="sb-dot"></span>{{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @if($booking->transaksi && $booking->transaksi->no_invoice)
                        <tr>
                            <td class="label">No. Invoice</td>
                            <td class="value">{{ $booking->transaksi->no_invoice }}</td>
                        </tr>
                        @endif
                        @if($booking->catatan)
                        <tr>
                            <td class="label">Catatan</td>
                            <td class="value">{{ $booking->catatan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <h3 class="print-section-title"><i class="fa-solid fa-spa"></i> Layanan Treatment</h3>
            <table class="item-table">
                <thead>
                    <tr>
                        <th style="width:5%;text-align:center;">#</th>
                        <th>Layanan</th>
                        <th style="width:13%;text-align:right;">Durasi</th>
                        <th style="width:15%;text-align:right;">Harga</th>
                        <th style="width:13%;text-align:right;">Diskon</th>
                        <th style="width:16%;text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @forelse($booking->detail as $detail)
                    @php
                        $harga = $detail->layanan ? $detail->layanan->harga : $detail->harga;
                        $subtotal = $detail->subtotal;
                        $total += $subtotal;
                        $durasi = $detail->layanan ? (int) $detail->layanan->durasi : 0;
                        $durasiText = $durasi ? $durasi . ' menit' : '-';
                    @endphp
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td>{{ $detail->layanan ? $detail->layanan->nm_layanan : 'Layanan #'.$detail->id_layanan }}</td>
                        <td class="text-right">{{ $durasiText }}</td>
                        <td class="text-right">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail->diskon ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:var(--gray);padding:20px;">Tidak ada detail layanan</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="5" style="text-align:right;">Total</td>
                        <td class="text-right grand">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            @if($booking->transaksi)
            @php
                $payStatus = $booking->transaksi->status;
                $payBadge = 'umum';
                if (str_contains(strtolower($payStatus), 'lunas')) { $payBadge = 'lunas'; }
                elseif (str_contains(strtolower($payStatus), 'pending') || str_contains(strtolower($payStatus), 'menunggu')) { $payBadge = 'pending'; }
                elseif (str_contains(strtolower($payStatus), 'batal')) { $payBadge = 'dibatalkan'; }
            @endphp
            <h3 class="print-section-title"><i class="fa-solid fa-credit-card"></i> Informasi Pembayaran</h3>
            <div class="pay-summary">
                <div class="pay-item">
                    <div class="label">Status Bayar</div>
                    <div class="value {{ $payBadge }}">{{ $payStatus }}</div>
                </div>
                <div class="pay-item">
                    <div class="label">Metode Bayar</div>
                    <div class="value">{{ $booking->transaksi->metode_byr ?? '-' }}</div>
                </div>
                <div class="pay-item">
                    <div class="label">Total Bayar</div>
                    <div class="value primary">Rp {{ number_format($booking->status_pembayaran === 'lunas' ? $total : $booking->transaksi->total, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif

            <h3 class="print-section-title"><i class="fa-solid fa-camera"></i> Dokumentasi Treatment</h3>
            @if($booking->riwayatTreatment)
            <div class="print-photo-pair">
                <div class="print-photo-card">
                    @if($booking->riwayatTreatment->sebelum_foto)
                        <img src="{{ asset('storage/' . $booking->riwayatTreatment->sebelum_foto) }}" alt="Sebelum Treatment">
                    @else
                        <div class="print-photo-empty">
                            <i class="fa-regular fa-image"></i>
                            <span style="font-size:12px;">Belum ada foto</span>
                        </div>
                    @endif
                    <div class="photo-label">Sebelum Treatment</div>
                </div>
                <div class="print-photo-card">
                    @if($booking->riwayatTreatment->sesudah_foto)
                        <img src="{{ asset('storage/' . $booking->riwayatTreatment->sesudah_foto) }}" alt="Sesudah Treatment">
                    @else
                        <div class="print-photo-empty">
                            <i class="fa-regular fa-image"></i>
                            <span style="font-size:12px;">Belum ada foto</span>
                        </div>
                    @endif
                    <div class="photo-label">Sesudah Treatment</div>
                </div>
            </div>

            @if($booking->riwayatTreatment->produk_digunakan)
            <div class="print-section-title"><i class="fa-solid fa-flask"></i> Produk yang Digunakan</div>
            <p style="font-size:13px;color:#374151;margin:0;line-height:1.7;">{{ $booking->riwayatTreatment->produk_digunakan }}</p>
            @endif

            @if($booking->riwayatTreatment->catatan)
            <div class="print-section-title"><i class="fa-solid fa-note-sticky"></i> Catatan Beautycian</div>
            <p style="font-size:13px;color:#374151;margin:0;line-height:1.7;font-style:italic;">{{ $booking->riwayatTreatment->catatan }}</p>
            @endif
            @else
            <div class="print-photo-pair">
                <div class="print-photo-card" style="grid-column:1/-1;">
                    <div class="print-photo-empty">
                        <i class="fa-regular fa-images"></i>
                        <span style="font-size:12px;">Dokumentasi belum tersedia — foto sebelum &amp; sesudah treatment akan tampil setelah beautycian melengkapi dokumentasi.</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="print-footer">
                <p class="thanks">Terima Kasih</p>
                <p class="note">Semoga puas dengan layanan kami</p>
                <p class="note">BeautyCare Salon &amp; Beauty Treatment</p>
            </div>
        </div>
    </div>
    @else
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="detail-card" id="printArea">
                    <div class="dc-header">
                        <div class="dc-title-wrap">
                            <div class="dc-title-icon">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <div class="dc-title">Detail Treatment</div>
                                <div class="dc-subtitle">Informasi lengkap treatment Anda</div>
                            </div>
                        </div>
                        <span class="status-badge {{ $booking->status }}">
                            <span class="sb-dot"></span>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="dc-body">
                        <div class="detail-grid">
                            <div class="detail-section">
                                <div class="ds-header">
                                    <i class="fa-solid fa-user"></i> Informasi Pelanggan
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Nama</span>
                                    <span class="info-value">{{ $booking->pelanggan->nm_pelanggan ?? auth()->user()->nama }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">No HP</span>
                                    <span class="info-value">{{ $booking->pelanggan->no_hp ?? auth()->user()->no_hp ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Email</span>
                                    <span class="info-value">{{ $booking->pelanggan->email ?? auth()->user()->email }}</span>
                                </div>
                                @if($booking->pelanggan && $booking->pelanggan->catatan_alergi)
                                <div class="info-row">
                                    <span class="info-label">Catatan Alergi</span>
                                    <span class="info-value" style="color:#DC2626;">{{ $booking->pelanggan->catatan_alergi }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="detail-section">
                                <div class="ds-header">
                                    <i class="fa-regular fa-calendar"></i> Detail Booking
                                </div>
                                <div class="info-row">
                                    <span class="info-label">ID Booking</span>
                                    <span class="info-value">#BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Tanggal</span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</span>
                                </div>
                                @php
                                    $durasiMenit = \App\Support\BookingSlot::durasiBooking($booking);
                                    $jamSelesaiEstimasi = \Carbon\Carbon::parse($booking->tanggal . ' ' . substr($booking->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                                @endphp
                                <div class="info-row">
                                    <span class="info-label">Jam</span>
                                    <span class="info-value font-mono">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} - {{ $jamSelesaiEstimasi }}</span>
                                </div>
                                @if($booking->status === 'selesai' && $booking->jam_mulai_aktual && $booking->jam_selesai_aktual)
                                <div class="info-row">
                                    <span class="info-label">Mulai Aktual</span>
                                    <span class="info-value font-mono">{{ \Carbon\Carbon::parse($booking->jam_mulai_aktual)->format('H:i') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Selesai Aktual</span>
                                    <span class="info-value font-mono">{{ \Carbon\Carbon::parse($booking->jam_selesai_aktual)->format('H:i') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Durasi</span>
                                    <span class="info-value font-mono">{{ gmdate('H:i:s', \Carbon\Carbon::parse($booking->jam_mulai_aktual)->diffInSeconds(\Carbon\Carbon::parse($booking->jam_selesai_aktual))) }}</span>
                                </div>
                                @endif
                                <div class="info-row">
                                    <span class="info-label">Terapis</span>
                                    <span class="info-value">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #'.$booking->id_karyawan }}</span>
                                </div>
                                @if($booking->catatan)
                                <div class="info-row">
                                    <span class="info-label">Catatan</span>
                                    <span class="info-value">{{ $booking->catatan }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-spa"></i> Layanan Treatment
                        </div>

                        <div style="overflow-x:auto;">
                            <table class="service-table">
                                <thead>
                                    <tr>
                                        <th>Layanan</th>
                                        <th>Durasi</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
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
                                        $durasi = $detail->layanan ? (int) $detail->layanan->durasi : 0;
                                        $durasiText = $durasi ? $durasi . ' menit' : '-';
                                    @endphp
                                    <tr>
                                        <td>{{ $detail->layanan ? $detail->layanan->nm_layanan : 'Layanan #'.$detail->id_layanan }}</td>
                                        <td>{{ $durasiText }}</td>
                                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->diskon ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;color:var(--gray);padding:20px;">Tidak ada detail layanan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="4" style="text-align:right;font-size:14px;">Total</td>
                                        <td class="text-right" style="font-size:16px;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($booking->transaksi)
                        @php
                            $payStatus = $booking->transaksi->status;
                            $payBadge = 'umum';
                            if (str_contains(strtolower($payStatus), 'lunas')) { $payBadge = 'lunas'; }
                            elseif (str_contains(strtolower($payStatus), 'pending') || str_contains(strtolower($payStatus), 'menunggu')) { $payBadge = 'pending'; }
                            elseif (str_contains(strtolower($payStatus), 'batal')) { $payBadge = 'dibatalkan'; }
                        @endphp
                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-credit-card"></i> Informasi Pembayaran
                        </div>

                        <div class="pay-cards">
                            <div class="pay-card">
                                <div class="pc-icon"><i class="fa-solid fa-circle-check"></i></div>
                                <div class="pc-label">Status Bayar</div>
                                <div class="pc-value">
                                    <span class="pay-badge {{ $payBadge }}"><span class="pb-dot"></span>{{ $payStatus }}</span>
                                </div>
                            </div>
                            <div class="pay-card">
                                <div class="pc-icon"><i class="fa-solid fa-wallet"></i></div>
                                <div class="pc-label">Metode Bayar</div>
                                <div class="pc-value">{{ $booking->transaksi->metode_byr ?? '-' }}</div>
                            </div>
                            <div class="pay-card total-card">
                                <div class="pc-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                                <div class="pc-label">Total Bayar</div>
                                <div class="pc-value total">Rp {{ number_format($booking->status_pembayaran === 'lunas' ? $total : $booking->transaksi->total, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        @if($booking->transaksi->no_invoice)
                        <div class="info-row" style="margin-top:14px;border:1px solid #F3F4F6;border-radius:12px;padding:10px 14px;">
                            <span class="info-label">No. Invoice</span>
                            <span class="info-value" style="letter-spacing:0.5px;">{{ $booking->transaksi->no_invoice }}</span>
                        </div>
                        @endif
                        @endif

                        @if($booking->riwayatTreatment)
                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-camera"></i> Dokumentasi Treatment
                        </div>

                        @if($booking->karyawan)
                        <div class="beautycian-strip">
                            <img class="bs-avatar" src="{{ $booking->karyawan->user?->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($booking->karyawan->nama) . '&background=FF4F87&color=fff&size=80' }}" alt="{{ $booking->karyawan->nama }}">
                            <div>
                                <div class="bs-name">{{ $booking->karyawan->nama }}</div>
                                <div class="bs-role">
                                    <i class="fa-solid fa-scissors"></i>
                                    {{ $booking->karyawan->karyawan?->jabatan ?? 'Beautycian' }} &bull; Penanganan treatment Anda
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="photo-pair">
                            <div class="photo-card">
                                @if($booking->riwayatTreatment->sebelum_foto)
                                    <img src="{{ asset('storage/' . $booking->riwayatTreatment->sebelum_foto) }}" alt="Sebelum Treatment">
                                @else
                                    <div class="empty-photo">
                                        <i class="fa-regular fa-image"></i>
                                        <span style="font-size:12px;">Belum ada foto</span>
                                    </div>
                                @endif
                                <div class="photo-label"><i class="fa-solid fa-circle"></i> Sebelum Treatment</div>
                            </div>
                            <div class="photo-card">
                                @if($booking->riwayatTreatment->sesudah_foto)
                                    <img src="{{ asset('storage/' . $booking->riwayatTreatment->sesudah_foto) }}" alt="Sesudah Treatment">
                                @else
                                    <div class="empty-photo">
                                        <i class="fa-regular fa-image"></i>
                                        <span style="font-size:12px;">Belum ada foto</span>
                                    </div>
                                @endif
                                <div class="photo-label"><i class="fa-solid fa-circle" style="color:#4ADE80;"></i> Sesudah Treatment</div>
                            </div>
                        </div>

                        @if($booking->riwayatTreatment->produk_digunakan)
                        <div class="doc-sub-title"><i class="fa-solid fa-flask"></i> Produk yang Digunakan</div>
                        <div class="produk-chips">
                            @php $daftarProduk = array_filter(array_map('trim', preg_split('/[,;\n]+/', $booking->riwayatTreatment->produk_digunakan))); @endphp
                            @foreach($daftarProduk as $produk)
                            <span class="produk-chip"><i class="fa-solid fa-droplet"></i>{{ $produk }}</span>
                            @endforeach
                        </div>
                        @endif

                        @if($booking->riwayatTreatment->catatan)
                        <div class="doc-sub-title"><i class="fa-solid fa-note-sticky"></i> Catatan Beautycian</div>
                        <div class="beautycian-note">
                            <i class="fa-solid fa-quote-left"></i>
                            <div>
                                <div class="bn-label">Keterangan</div>
                                <div class="bn-text">{{ $booking->riwayatTreatment->catatan }}</div>
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-camera"></i> Dokumentasi Treatment
                        </div>

                        <div class="doc-empty">
                            <i class="fa-regular fa-images"></i>
                            <div>
                                <div style="font-weight:600;color:var(--dark);">Dokumentasi belum tersedia</div>
                                <div style="font-size:12px;">Foto sebelum &amp; sesudah treatment akan ditampilkan di sini setelah beautycian melengkapi dokumentasi.</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="action-bar no-print">
                    <a href="{{ route('pelanggan.treatment', ['status' => request('status')]) }}" class="btn-action btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('pelanggan.treatment.pdf', $booking->id_booking) }}" class="btn-action btn-print">
                        <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                    </a>
                </div>
            </div>
        </main>
    </div>
    @endif

    <script>
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
