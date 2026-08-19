{{--
    Daftar ulasan terpadu (kartu ulasan: avatar, nama, bintang, komentar).
    @param \Illuminate\Support\Collection $ulasans
    @param string|null $empty Pesan saat tidak ada ulasan (opsional)
--}}
@forelse($ulasans as $ulasan)
    <div class="rs-review-card">
        <div class="rs-review-head">
            <img class="rs-review-avatar" src="{{ $ulasan->foto_pemberi }}" alt="{{ $ulasan->nama_pemberi }}" loading="lazy">
            <div>
                <span class="rs-review-name">{{ $ulasan->nama_pemberi }}</span>
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