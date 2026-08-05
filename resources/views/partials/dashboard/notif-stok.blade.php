@forelse($notifStok as $p)
@php
    $stok = (int) $p->stok;
    if ($stok <= 0) {
        $iconClass = 'danger';
        $barClass = 'danger';
        $barW = 0;
    } elseif ($stok <= 10) {
        $iconClass = 'danger';
        $barClass = 'danger';
        $barW = max(5, ($stok / 50) * 100);
    } elseif ($stok <= 20) {
        $iconClass = 'warning';
        $barClass = 'warning';
        $barW = ($stok / 50) * 100;
    } else {
        $iconClass = 'success';
        $barClass = 'success';
        $barW = min(100, ($stok / 50) * 100);
    }
@endphp
<div class="stock-item">
    <div class="stock-icon {{ $iconClass }}">
        @if ($stok <= 0)
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10" />
            <line x1="15" y1="9" x2="9" y2="15" />
            <line x1="9" y1="9" x2="15" y2="15" />
        </svg>
        @elseif ($stok <= 20)
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
            <line x1="12" y1="9" x2="12" y2="13" />
            <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
        @else
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
        @endif
    </div>
    <div class="stock-info">
        <h4>{{ $p->nm_produk }}</h4>
        <p>{{ $p->kategori->nm_produk ?? 'Tanpa Kategori' }} -
            @if ($stok <= 0)
            <span style="color:var(--danger);font-weight:600;">Stok Habis - Wajib Restok!</span>
            @else
            Sisa {{ $stok }}
            @endif
        </p>
    </div>
    <div class="stock-bar">
        <div class="fill {{ $barClass }}" style="width:{{ $barW }}%"></div>
    </div>
    <span class="stock-qty">{{ $stok }}</span>
</div>
@empty
<div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">Semua stok dalam kondisi baik</div>
@endforelse
