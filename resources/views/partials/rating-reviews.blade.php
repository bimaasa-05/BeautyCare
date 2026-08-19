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
                <div class="rs-review-name-row">
                    <span class="rs-review-name">{{ $ulasan->nama_pemberi }}</span>
                    @if ($ulasan->tingkat_member)
                        <span class="tier-badge {{ strtolower($ulasan->tingkat_member) }}">
                            @if ($ulasan->tingkat_member === 'Silver')
                                <i class="fa-solid fa-crown"></i>
                            @elseif ($ulasan->tingkat_member === 'Gold')
                                <i class="fa-solid fa-trophy"></i>
                            @elseif ($ulasan->tingkat_member === 'Platinum')
                                <i class="fa-solid fa-gem"></i>
                            @endif
                            {{ $ulasan->tingkat_member }}
                        </span>
                    @endif
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