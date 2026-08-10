@forelse($bookingTerbaru as $b)
<div class="booking-item">
    <img src="{{ $b->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($b->pelanggan->nm_pelanggan ?? 'Customer') . '&background=FFE5EF&color=FF4F87&size=40' }}"
        alt="{{ $b->pelanggan->nm_pelanggan ?? 'Customer' }}"
        style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
    <div class="booking-info">
        <h4>{{ $b->pelanggan->nm_pelanggan ?? 'N/A' }}</h4>
        <p>{{ $b->detail->first()->layanan->nm_layanan ?? 'Booking' }}</p>
    </div>
    <span class="booking-time">{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m') }} {{ substr($b->jam, 0, 5) }}</span>
</div>
@empty
<div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">Belum ada booking</div>
@endforelse
