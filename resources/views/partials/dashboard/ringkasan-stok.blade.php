@forelse($ringkasanStok as $s)
@php
    $maxStok = max(50, $s->stok);
    $pct = round(($s->stok / $maxStok) * 100);
    if ($s->stok <= 0) { $color = 'danger'; $pct = 0; }
    elseif ($s->stok <= 10) { $color = 'info'; }
    elseif ($s->stok <= 20) { $color = 'warning'; }
    else { $color = 'success'; }
@endphp
<div class="stock-item">
    <div class="stock-icon {{ $color }}">
        @if ($s->foto)
        <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nm_produk }}"
            style="width:34px;height:34px;border-radius:10px;object-fit:cover;">
        @else
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
        </svg>
        @endif
    </div>
    <div class="stock-info">
        <h4>{{ $s->nm_produk }}</h4>
        <p>{{ $s->kategori->nm_produk ?? 'Tanpa Kategori' }}</p>
    </div>
    <div class="stock-bar">
        <div class="fill {{ $color }}" style="width:{{ $pct }}%"></div>
    </div>
    <span class="stock-qty">{{ $s->stok }}</span>
</div>
@empty
<div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;grid-column:1/-1;">Tidak ada produk</div>
@endforelse
