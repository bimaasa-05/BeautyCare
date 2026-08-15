<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Riwayat Treatment - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <style>
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }

        .detail-section { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid var(--border); }
        .detail-section .ds-header { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .detail-section .ds-header svg { width: 18px; height: 18px; color: var(--primary); }

        .info-row { display: flex; padding: 8px 0; border-bottom: 1px solid #F5F5F5; }
        .info-row:last-child { border-bottom: none; }
        .info-row .info-label { width: 120px; font-size: 12px; color: var(--gray); flex-shrink: 0; }
        .info-row .info-value { flex: 1; font-size: 13px; color: var(--dark); font-weight: 500; }

        .photo-card { border-radius: 12px; overflow: hidden; border: 1px solid var(--border); }
        .photo-card img { width: 100%; height: auto; display: block; }
        .photo-card .photo-label { padding: 8px 12px; font-size: 11px; font-weight: 600; color: var(--gray); background: #FAFAFA; text-align: center; }
        .photo-card.empty-photo { display: flex; align-items: center; justify-content: center; height: 220px; background: #FAFAFA; color: #ccc; flex-direction: column; gap: 8px; }
        .photo-card.empty-photo svg { width: 40px; height: 40px; }

        .photo-pair { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 576px) {
            .photo-pair { grid-template-columns: 1fr; }
        }

        .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: var(--gray); text-decoration: none; margin-bottom: 16px; font-weight: 500; }
        .back-link:hover { color: var(--primary); }

        .badge-transaksi { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge-transaksi.lunas { background: #D1FAE5; color: #059669; }
        .badge-transaksi.proses { background: #FEF3C7; color: #D97706; }
        .badge-transaksi.batal { background: #FEE2E2; color: #DC2626; }
        .badge-transaksi.pending { background: #F3E8FF; color: #9333EA; }
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
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Riwayat Treatment</h3>
                                <p>Informasi lengkap treatment #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('beautycian.riwayat-treatment.index') }}" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    Kembali ke Riwayat
                </a>

                <div class="detail-grid">
                    <div class="detail-section">
                        <div class="ds-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Informasi Pelanggan
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nama</span>
                            <span class="info-value">{{ $booking->pelanggan->nm_pelanggan ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">No HP</span>
                            <span class="info-value">{{ $booking->pelanggan->no_hp ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $booking->pelanggan->email ?? '-' }}</span>
                        </div>
                        @if($booking->pelanggan->catatan_alergi)
                        <div class="info-row">
                            <span class="info-label">Catatan Alergi</span>
                            <span class="info-value" style="color:#DC2626;">{{ $booking->pelanggan->catatan_alergi }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="detail-section">
                        <div class="ds-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Detail Booking
                        </div>
                        <div class="info-row">
                            <span class="info-label">ID Booking</span>
                            <span class="info-value">#BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        @php
                            $durasiMenit = \App\Support\BookingSlot::durasiBooking($booking);
                            $jamSelesaiEstimasi = \Carbon\Carbon::parse($booking->tanggal . ' ' . substr($booking->jam, 0, 5))->addMinutes($durasiMenit)->format('H:i');
                            $adaAktual = in_array($booking->status, ['diproses', 'selesai']) && $booking->jam_mulai_aktual;
                            $mulaiAktual = $adaAktual ? \Carbon\Carbon::parse($booking->jam_mulai_aktual)->format('H:i') : null;
                            $bedaWaktu = $adaAktual && $mulaiAktual !== \Carbon\Carbon::parse($booking->jam)->format('H:i');
                            
                            $selesaiAktual = null;
                            $durasiAktual = null;
                            $statusWaktu = null;
                            if ($adaAktual) {
                                $mulaiCarbon = \Carbon\Carbon::parse($booking->jam_mulai_aktual);
                                if ($booking->status === 'selesai' && $booking->jam_selesai_aktual) {
                                    $selesaiCarbon = \Carbon\Carbon::parse($booking->jam_selesai_aktual);
                                    $selesaiAktual = $selesaiCarbon->format('H:i');
                                    $durasiDetik = $mulaiCarbon->diffInSeconds($selesaiCarbon);
                                    $durasiAktual = gmdate('H:i:s', $durasiDetik);
                                    $statusWaktu = 'Selesai';
                                } else {
                                    $selesaiEstCarbon = $mulaiCarbon->copy()->addMinutes($durasiMenit);
                                    $selesaiAktual = $selesaiEstCarbon->format('H:i');
                                    $statusWaktu = 'Sedang berlangsung';
                                }
                            }
                        @endphp
                        <div class="info-row">
                            <span class="info-label">Jam</span>
                            <span class="info-value font-mono">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} - {{ $jamSelesaiEstimasi }}</span>
                        </div>
                        @if ($adaAktual)
                        <div class="info-row">
                            <span class="info-label text-amber-600">Aktual</span>
                            <span class="info-value text-amber-600 font-bold">
                                {{ $mulaiAktual }} 
                                @if($booking->status === 'selesai')
                                    - {{ $selesaiAktual }}
                                @else
                                    <span class="font-normal text-amber-500"> · {{ $statusWaktu }}</span>
                                @endif
                            </span>
                        </div>
                        @endif
                        @if ($durasiAktual)
                        <div class="info-row">
                            <span class="info-label text-emerald-600">Durasi</span>
                            <span class="info-value text-emerald-600 font-bold font-mono">{{ $durasiAktual }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Layanan</span>
                            <span class="info-value">
                                @if($booking->detail && $booking->detail->isNotEmpty())
                                    @foreach($booking->detail as $dt)
                                        {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }} ({{ ($dt->layanan->durasi ?? 0) }} menit)
                                        @if($dt->layanan) (Rp {{ number_format($dt->layanan->harga, 0, ',', '.') }})@endif
                                        @if(!$loop->last)<br>@endif
                                    @endforeach
                                @else - @endif
                            </span>
                        </div>
                        @if($booking->transaksi)
                        <div class="info-row">
                            <span class="info-label">Pembayaran</span>
                            <span class="info-value">
                                <span class="badge-transaksi {{ $booking->transaksi->status }}">
                                    {{ $booking->transaksi->status }}
                                </span>
                                @if($booking->transaksi->total)
                                    - Rp {{ number_format($booking->transaksi->total, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($booking->catatan)
                        <div class="info-row">
                            <span class="info-label">Catatan Booking</span>
                            <span class="info-value">{{ $booking->catatan }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if($booking->riwayatTreatment)
                <div class="detail-section" style="margin-top:20px;">
                    <div class="ds-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 11 12 14 22 4"/></svg>
                        Dokumentasi Treatment
                    </div>

                    <div class="photo-pair" style="margin-bottom:20px;">
                        <div class="photo-card">
                            @if($booking->riwayatTreatment->sebelum_foto)
                                <img src="{{ asset('storage/' . $booking->riwayatTreatment->sebelum_foto) }}" alt="Sebelum Treatment">
                            @else
                                <div class="empty-photo">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span style="font-size:12px;">Tidak ada foto</span>
                                </div>
                            @endif
                            <div class="photo-label">Sesudah Treatment</div>
                        </div>
                    </div>

                    <div style="display:grid;gap:20px;" class="photo-pair">
                        @if($booking->riwayatTreatment->produk_digunakan)
                        <div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray);margin-bottom:6px;">Produk yang Digunakan</div>
                            <div style="font-size:13px;color:var(--dark);background:#FAFAFA;padding:12px;border-radius:10px;">
                                {{ $booking->riwayatTreatment->produk_digunakan }}
                            </div>
                        </div>
                        @endif

                        @if($booking->riwayatTreatment->catatan)
                        <div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray);margin-bottom:6px;">Catatan Treatment</div>
                            <div style="font-size:13px;color:var(--dark);background:#FAFAFA;padding:12px;border-radius:10px;min-height:40px;">
                                {{ $booking->riwayatTreatment->catatan }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="detail-section" style="margin-top:20px;">
                    <div class="empty-state" style="padding:30px;">
                        <div class="es-illustration" style="width:60px;height:60px;">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 11 12 14 22 4"/></svg>
                        </div>
                        <h4>Belum Ada Dokumentasi</h4>
                        <p>Treatment ini belum memiliki dokumentasi.</p>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
