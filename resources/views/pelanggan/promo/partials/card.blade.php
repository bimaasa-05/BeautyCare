@php
    $isClaimed = in_array($promo->id_promo, $claimedIds ?? []);
    $isUsed = in_array($promo->id_promo, $usedIds ?? []);
    $bgClass = match($promo->jenis_promo) {
        'Diskon' => 'diskon',
        'Buy 1 Get 1' => 'bogo',
        'Paket' => 'paket',
        'Cashback' => 'poin',
        default => 'spesial',
    };
    $icons = [
        'Diskon' => 'fa-solid fa-percent',
        'Buy 1 Get 1' => 'fa-solid fa-gift',
        'Paket' => 'fa-solid fa-cube',
        'Cashback' => 'fa-solid fa-coins',
    ];
    $icon = $icons[$promo->jenis_promo] ?? 'fa-solid fa-tag';
    $badgeText = $promo->jenis_promo == 'Diskon' ? $promo->nilai . '% OFF' : $promo->jenis_promo;
    $opacity = (!$canClaim || $promo->status != 'Tersedia') ? 'opacity:0.6;' : '';
    $labelLain = $promo->jenis_promo == 'Cashback' ? 'Cashback' : 'Nilai';
    $itemLabels = $promo->itemLabels();
    $itemText = implode(', ', array_merge($itemLabels['layanan'], $itemLabels['produk']));
    $itemLabel = $itemText ? 'Berlaku: ' . $itemText : 'Berlaku untuk semua produk & layanan';
@endphp
<div class="promo-card" data-id="{{ $promo->id_promo }}" style="{{ $opacity }}">
    <div class="promo-banner">
        <div class="promo-bg {{ $bgClass }}"></div>
        <div class="promo-deco"></div>
        <div class="promo-deco"></div>
        <span class="promo-badge">{{ $badgeText }}</span>
        <div class="promo-icon-big">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    <div class="promo-body">
        <div class="promo-title">{{ $promo->nm_promo }}</div>
        <div class="promo-desc">{{ $promo->deskripsi ?: ($promo->jenis_promo . ' - ' . $labelLain . ' ' . $promo->nilai . ($promo->jenis_promo == 'Diskon' ? '%' : '')) }}</div>
        <div class="promo-meta">
            <span class="pm-item"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($promo->mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($promo->selesai)->format('d M Y') }}</span>
            <span class="pm-item"><i class="fa-regular fa-user"></i> {{ $promo->targetLabel() }}</span>
            <span class="pm-item"><i class="fa-solid fa-tag"></i> {{ $itemLabel }}</span>
        </div>
        <div class="promo-divider"></div>
        <div class="promo-footer">
            <span class="promo-code"><i class="fa-solid fa-ticket"></i> {{ $promo->kode_promo ?: 'PROMO' }}</span>
            @if($canClaim && $promo->status == 'Tersedia')
            <button class="promo-btn-claim @if($isClaimed) claimed @endif @if($isUsed) disabled @endif" data-id="{{ $promo->id_promo }}" @if($isClaimed || $isUsed) disabled="disabled" @endif>
                @if($isClaimed)<i class="fa-regular fa-circle-check"></i> @endif{{ $isClaimed ? 'Claimed' : 'Klaim Now' }}
            </button>
            @else
            <button class="promo-btn-claim claimed"><i class="fa-regular fa-calendar-xmark"></i> Berakhir</button>
            @endif
        </div>
    </div>
</div>
