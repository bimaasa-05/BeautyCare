<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Reservasi - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <style>
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .detail-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 20px; }
        .detail-card h4 { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-row .label { color: var(--gray); }
        .detail-row .value { font-weight: 500; color: var(--text-primary); text-align: right; }
        .service-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .service-table th { text-align: left; padding: 10px 12px; background: var(--bg-gray); color: var(--gray); font-weight: 600; font-size: 11px; text-transform: uppercase; }
        .service-table td { padding: 10px 12px; border-bottom: 1px solid var(--border); }
        .service-table tfoot td { font-weight: 700; border-top: 2px solid var(--border); padding: 12px; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-weight: 500; font-size: 13px; margin-bottom: 16px; }

        @media (max-width: 768px) {
            .detail-grid { grid-template-columns: 1fr; }
            .service-table thead { display: none; }
            .service-table tbody tr { display: block; padding: 10px 0; border-bottom: 1px solid var(--border); }
            .service-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 4px 0; border: none; font-size: 13px; text-align: right; }
            .service-table tbody td:before { content: attr(data-label); font-weight: 600; color: var(--gray); font-size: 11px; text-transform: uppercase; }
            .service-table tbody td:first-child { padding-top: 0; }
            .service-table tbody td:last-child { padding-bottom: 0; }
            .service-table tfoot td { display: flex; justify-content: space-between; }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Reservasi</h3>
                                <p>Informasi lengkap reservasi #BK{{ str_pad($reservasi->id_booking, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('beautycian.laporan-reservasi.index') }}" class="back-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="detail-card">
                        <h4>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Informasi Pelanggan
                        </h4>
                        <div class="detail-row">
                            <span class="label">Nama</span>
                            <span class="value">{{ $reservasi->pelanggan->nm_pelanggan ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">No. HP</span>
                            <span class="value">{{ $reservasi->pelanggan->no_hp ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Email</span>
                            <span class="value">{{ $reservasi->pelanggan->email ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Alamat</span>
                            <span class="value">{{ $reservasi->pelanggan->alamat ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h4>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Informasi Reservasi
                        </h4>
                        <div class="detail-row">
                            <span class="label">ID Booking</span>
                            <span class="value">#BK{{ str_pad($reservasi->id_booking, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Tanggal</span>
                            <span class="value">{{ \Carbon\Carbon::parse($reservasi->tanggal)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Jam</span>
                            <span class="value">{{ \Carbon\Carbon::parse($reservasi->jam)->format('H:i') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Status</span>
                            <span class="value">
                                <span class="status-badge {{ $reservasi->status }}">
                                    <span class="sb-dot"></span>
                                    {{ $statusLabels[$reservasi->status] ?? ucfirst($reservasi->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Catatan</span>
                            <span class="value">{{ $reservasi->catatan ?: 'Tidak ada catatan' }}</span>
                        </div>
                    </div>
                </div>

                <div class="booking-card-premium" style="margin-top:20px;">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </div>
                            <div>
                                <div class="bc-title">Daftar Layanan</div>
                                <div class="bc-subtitle">Layanan yang dipesan dalam reservasi ini</div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto"><table class="service-table">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th style="text-align:right;">Harga</th>
                                    <th style="text-align:right;">Diskon</th>
                                    <th style="text-align:right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @forelse($reservasi->detail as $detail)
                                @php $total += $detail->subtotal; @endphp
                                <tr>
                                    <td data-label="Layanan">{{ $detail->layanan->nm_layanan ?? 'Layanan #'.$detail->id_layanan }}</td>
                                    <td data-label="Harga" style="text-align:right;">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td data-label="Diskon" style="text-align:right;">{{ $detail->diskon ? 'Rp '.number_format($detail->diskon, 0, ',', '.') : '-' }}</td>
                                    <td data-label="Subtotal" style="text-align:right;font-weight:600;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:24px;color:var(--gray);">
                                        Tidak ada layanan dalam reservasi ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right;">Total</td>
                                    <td style="text-align:right;font-weight:700;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
