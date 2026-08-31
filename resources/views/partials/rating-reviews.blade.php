{{--
    Daftar ulasan terpadu (kartu ulasan: avatar, nama, Terverifikasi, bintang, komentar).
    @param \Illuminate\Support\Collection $ulasans
    @param string|null $empty Pesan saat tidak ada ulasan (opsional)
--}}
@forelse($ulasans as $ulasan)
    <div class="rs-review-card">
        <div class="rs-review-head">
            <img class="rs-review-avatar" src="{{ $ulasan->foto_pemberi }}" alt="{{ $ulasan->nama_pemberi }}" loading="lazy">
            <div>
                <div>
                    <span class="rs-review-name">{{ $ulasan->nama_pemberi }}</span>
                    <span class="rs-review-verified">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Pelanggan Terverifikasi
                    </span>
                </div>
                <div class="rs-review-date">{{ \Carbon\Carbon::parse($ulasan->created_at)->isoFormat('D MMM YYYY') }}</div>
            </div>
        </div>
        <div class="rs-review-stars">{{ str_repeat('★', $ulasan->bintang) }}{{ str_repeat('☆', 5 - $ulasan->bintang) }}</div>
        @if ($ulasan->komentar)
            <p class="rs-review-text">"{{ $ulasan->komentar }}"</p>
        @endif
    </div>
@empty
    <div class="rs-review-empty">{{ $empty ?? 'Belum ada ulasan.' }}</div>
@endforelse