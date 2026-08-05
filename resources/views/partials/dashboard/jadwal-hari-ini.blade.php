@forelse($jadwalHariIni as $j)
<div class="flex flex-wrap sm:flex-nowrap items-center gap-x-2 gap-y-1 text-sm">
    <span style="color:var(--primary);font-weight:600;">{{ substr($j->jam, 0, 5) }}</span>
    <span style="color:var(--gray);">-</span>
    <span class="flex-1 min-w-0">{{ $j->pelanggan->nm_pelanggan ?? 'N/A' }} - {{ $j->detail->first()->layanan->nm_layanan ?? 'Booking' }}</span>
    @php
        $badge = match($j->status) {
            'Confirmed', 'Dikonfirmasi' => 'badge-success',
            'Pending', 'Menunggu' => 'badge-warning',
            'Completed', 'Selesai' => 'badge-info',
            'Dibatalkan' => 'badge-danger',
            default => 'badge-secondary'
        };
    @endphp
    <span class="badge {{ $badge }}">{{ $j->status }}</span>
</div>
@empty
<div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">Tidak ada jadwal untuk hari ini</div>
@endforelse
