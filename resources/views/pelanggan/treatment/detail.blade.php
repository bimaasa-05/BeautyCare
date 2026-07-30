<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Treatment - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

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

    .photo-card { border-radius: 12px; overflow: hidden; border: 1px solid var(--border); }
    .photo-card img { width: 100%; height: 220px; object-fit: cover; display: block; }
    .photo-card .photo-label { padding: 8px 12px; font-size: 11px; font-weight: 600; color: var(--gray); background: #FAFAFA; text-align: center; }
    .photo-card.empty-photo { display: flex; align-items: center; justify-content: center; height: 220px; background: #FAFAFA; color: #ccc; flex-direction: column; gap: 8px; }
    .photo-card.empty-photo i { font-size: 36px; }

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
    .btn-action.btn-print { background: #F3E8FF; color: #9333EA; }
    .btn-action.btn-print:hover { background: #E9D5FF; box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2); }

    @media print {
        .sidebar-toggle, .sidebar-overlay, .main-content .dashboard-content > .action-bar { display: none !important; }
        .no-print { display: none !important; }
        .sidebar { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .dashboard-layout { display: block !important; }
        .dashboard-content { padding: 20px !important; }
        .detail-card { box-shadow: none; border: 1px solid #ddd; }
        body { background: white; }
        header, .header2, .main-content > .header2, .dashboard-content > .page-header-premium { display: none !important; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="detail-card" id="printArea">
                    <div class="dc-header">
                        <div class="dc-title-wrap">
                            <div class="dc-title-icon">
                                <i class="fa-regular fa-receipt"></i>
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
                                <div class="info-row">
                                    <span class="info-label">Jam</span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</span>
                                </div>
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
                                    @endphp
                                    <tr>
                                        <td>{{ $detail->layanan ? $detail->layanan->nm_layanan : 'Layanan #'.$detail->id_layanan }}</td>
                                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->diskon ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;color:var(--gray);padding:20px;">Tidak ada detail layanan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="3" style="text-align:right;font-size:14px;">Total</td>
                                        <td class="text-right" style="font-size:16px;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($booking->transaksi)
                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-credit-card"></i> Informasi Pembayaran
                        </div>

                        <div class="detail-grid">
                            <div class="detail-item" style="display:flex;flex-direction:column;gap:4px;">
                                <span style="font-size:11px;font-weight:600;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;">Status Bayar</span>
                                <span style="font-size:14px;font-weight:500;color:var(--dark);">{{ $booking->transaksi->status }}</span>
                            </div>
                            <div class="detail-item" style="display:flex;flex-direction:column;gap:4px;">
                                <span style="font-size:11px;font-weight:600;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;">Metode Bayar</span>
                                <span style="font-size:14px;font-weight:500;color:var(--dark);">{{ $booking->transaksi->metode_byr ?? '-' }}</span>
                            </div>
                            <div class="detail-item" style="display:flex;flex-direction:column;gap:4px;grid-column:1/-1;">
                                <span style="font-size:11px;font-weight:600;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;">Total Bayar</span>
                                <span style="font-size:20px;font-weight:700;color:var(--dark);">Rp {{ number_format($booking->transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif

                        @if($booking->riwayatTreatment)
                        <div class="detail-divider"></div>

                        <div class="detail-section-title">
                            <i class="fa-solid fa-camera"></i> Dokumentasi Treatment
                        </div>

                        <div class="photo-pair">
                            <div class="photo-card">
                                @if($booking->riwayatTreatment->sebelum_foto)
                                    <img src="{{ asset('storage/' . $booking->riwayatTreatment->sebelum_foto) }}" alt="Sebelum Treatment">
                                @else
                                    <div class="empty-photo">
                                        <i class="fa-regular fa-image"></i>
                                        <span style="font-size:12px;">Tidak ada foto</span>
                                    </div>
                                @endif
                                <div class="photo-label">Sebelum Treatment</div>
                            </div>
                            <div class="photo-card">
                                @if($booking->riwayatTreatment->sesudah_foto)
                                    <img src="{{ asset('storage/' . $booking->riwayatTreatment->sesudah_foto) }}" alt="Sesudah Treatment">
                                @else
                                    <div class="empty-photo">
                                        <i class="fa-regular fa-image"></i>
                                        <span style="font-size:12px;">Tidak ada foto</span>
                                    </div>
                                @endif
                                <div class="photo-label">Sesudah Treatment</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="action-bar no-print">
                    <a href="{{ route('pelanggan.treatment', ['status' => request('status')]) }}" class="btn-action btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button onclick="window.print()" class="btn-action btn-print">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

    const params = new URLSearchParams(window.location.search);
    if (params.get('print') === '1') {
        window.print();
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
