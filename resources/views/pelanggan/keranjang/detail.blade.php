<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Keranjang - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
    }

    .sidebar-toggle svg {
        width: 24px;
        height: 24px;
        color: var(--dark);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 90;
    }

    .sidebar-overlay.active {
        display: block;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }

    .page-header-premium::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .page-header-premium .ph-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-premium .ph-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        flex-shrink: 0;
    }

    .page-header-premium .ph-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .page-header-premium .ph-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .btn-history {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        border: 1.5px solid var(--primary);
        background: var(--white);
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-history:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .detail-card {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .detail-card {
            grid-template-columns: 1fr;
        }
    }

    .dc-media {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        background: var(--white);
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dc-media .dc-img {
        width: 100%;
        height: 100%;
        min-height: 380px;
        object-fit: cover;
        display: block;
    }

    .dc-media .dc-img-placeholder {
        width: 100%;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        color: rgba(255, 255, 255, 0.6);
    }

    .dc-media .dc-img-placeholder.skincare { background: linear-gradient(135deg, #F472B6, #F9A8D4); }
    .dc-media .dc-img-placeholder.haircare { background: linear-gradient(135deg, #34D399, #6EE7B7); }
    .dc-media .dc-img-placeholder.bodycare { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
    .dc-media .dc-img-placeholder.makeup { background: linear-gradient(135deg, #A78BFA, #C4B5FD); }
    .dc-media .dc-img-placeholder.nailcare { background: linear-gradient(135deg, #F43F5E, #FB7185); }
    .dc-media .dc-img-placeholder.lainnya { background: linear-gradient(135deg, #94A3B8, #CBD5E1); }

    .dc-media .dc-category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 6px 16px;
        border-radius: 100px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .dc-info {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        padding: 28px;
    }

    .dc-info .dc-nama {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .dc-info .dc-kategori {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 16px;
    }

    .dc-qty-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .dc-qty-row .dc-qty-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .dc-qty-row .qty-control {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    .dc-qty-row .qty-control button {
        width: 38px;
        height: 38px;
        border: none;
        background: #FAFAFA;
        color: var(--dark);
        font-size: 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }

    .dc-qty-row .qty-control button:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .dc-qty-row .qty-control button:disabled,
    .dc-qty-row .qty-control button:disabled:hover {
        opacity: 0.45;
        cursor: not-allowed;
        background: #FAFAFA;
        color: var(--gray);
    }

    .dc-qty-row .qty-control .qty-val {
        min-width: 48px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        border-left: 1.5px solid var(--border);
        border-right: 1.5px solid var(--border);
    }

    .dc-stok-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 100px;
        background: #FFF5F8;
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
    }

    .dc-stok-badge .sb-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .dc-stok-badge.tersedia {
        background: #D1FAE5;
        color: #059669;
    }

    .dc-stok-badge.habis {
        background: #FEE2E2;
        color: #DC2626;
    }

    .dc-price-wrap {
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        border: 1px solid rgba(255, 79, 135, 0.1);
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    .dc-price-wrap .dc-price-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .dc-price-wrap .dc-price {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
    }

    .dc-price-wrap .dc-price span {
        font-size: 13px;
        font-weight: 500;
        color: var(--gray);
    }

    .dc-subtotal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 20px;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .dc-subtotal .dcs-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .dc-subtotal .dcs-label i {
        color: var(--primary);
    }

    .dc-subtotal .dcs-nominal {
        font-size: 24px;
        font-weight: 800;
        color: var(--dark);
    }

    .dc-btn-beli {
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        border: none;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .dc-btn-beli:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    .dc-btn-beli.disabled {
        opacity: 0.55;
        cursor: not-allowed;
        pointer-events: none;
        transform: none !important;
        box-shadow: none !important;
    }

    .dc-warning {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #DC2626;
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 12px;
    }

    .dc-divider {
        height: 1px;
        background: var(--border);
        margin: 22px 0;
    }

    .dc-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dc-section-title i {
        color: var(--primary);
        font-size: 16px;
    }

    .dc-deskripsi p {
        font-size: 13px;
        line-height: 1.8;
        color: var(--gray);
        margin: 0 0 14px;
    }

    .dc-info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 9px 0;
        border-bottom: 1px solid #F5F5F5;
        font-size: 13px;
    }

    .dc-info-row:last-child {
        border-bottom: none;
    }

    .dc-info-row .dir-label {
        color: var(--gray);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .dc-info-row .dir-label i {
        color: var(--primary);
        font-size: 13px;
        width: 16px;
        text-align: center;
    }

    .dc-info-row .dir-value {
        color: var(--dark);
        font-weight: 600;
        text-align: right;
    }

    @media (max-width: 768px) {
        .page-header-premium { padding: 22px 20px; }
        .dc-info { padding: 20px; }
        .dc-media .dc-img, .dc-media .dc-img-placeholder { min-height: 260px; }
    }

    @media (max-width: 480px) {
        .dc-nama { font-size: 18px; }
        .dc-price { font-size: 22px; }
        .dc-price-wrap { padding: 14px 16px; }
        .dc-subtotal { flex-wrap: wrap; padding: 12px 14px; }
        .dc-subtotal .dcs-nominal { font-size: 19px; }
        .dc-qty-row { gap: 10px; }
        .dc-media { min-height: 220px; }
        .dc-media .dc-img, .dc-media .dc-img-placeholder { min-height: 220px; }
        .dc-media .dc-img-placeholder { font-size: 48px; }
        .page-header-premium .ph-text h3 { font-size: 17px; }
        .page-header-premium .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; font-size: 18px; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Keranjang</h3>
                                <p>Informasi lengkap produk di keranjang Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.keranjang') }}" class="btn-history">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

                @php
                    $iconMap = [
                        'Skincare' => 'fa-spa',
                        'Hair Care' => 'fa-scissors',
                        'Body Care' => 'fa-hand-sparkles',
                        'Nail Care' => 'fa-hand',
                        'Makeup' => 'fa-palette',
                    ];
                    $kategori = $item->kategori;
                    $icon = $iconMap[$kategori] ?? 'fa-cube';
                    $classKategori = str_replace(' ', '', strtolower($kategori));
                    $kategoriCss = ['skincare', 'haircare', 'bodycare', 'nailcare', 'makeup'];
                    $class = in_array($classKategori, $kategoriCss) ? $classKategori : 'lainnya';
                    $stokTersedia = $produk && $produk->stok > 0;
                    $satuan = $produk->satuan ?? 'pcs';
                @endphp

                <div class="detail-card">
                    <div class="dc-media">
                        @if ($produk && $produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $item->nm_produk }}" class="dc-img">
                        @else
                            <div class="dc-img-placeholder {{ $class }}">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                        @endif
                        <span class="dc-category-badge">{{ $kategori }}</span>
                    </div>

                    <div class="dc-info">
                        <div class="dc-nama">{{ $item->nm_produk }}</div>
                        <div class="dc-kategori">{{ $kategori }}</div>

                        <div class="dc-qty-row">
                            <span class="dc-qty-label">Jumlah</span>
                            <div class="qty-control">
                                <button id="qtyMinusBtn" onclick="qtyMinus()" {{ $stokTersedia ? '' : 'disabled' }}><i class="fa-solid fa-minus"></i></button>
                                <span class="qty-val" id="qtyVal">{{ $item->qty }}</span>
                                <button id="qtyPlusBtn" onclick="qtyPlus()" {{ $stokTersedia && (int) $item->qty < (int) ($produk->stok ?? 0) ? '' : 'disabled' }}><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <span class="dc-stok-badge {{ $stokTersedia ? 'tersedia' : 'habis' }}">
                                <span class="sb-dot"></span>
                                {{ $stokTersedia ? 'Stok: ' . $produk->stok . ' ' . $satuan : 'Stok Habis' }}
                            </span>
                        </div>

                        <div class="dc-price-wrap">
                            <div class="dc-price-label">Harga Satuan</div>
                            <div class="dc-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</div>
                        </div>

                        <div class="dc-subtotal">
                            <span class="dcs-label"><i class="fa-solid fa-receipt"></i> Subtotal (<span id="subtotalQty">{{ $item->qty }}</span> item)</span>
                            <span class="dcs-nominal" id="subtotalNominal">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('pelanggan.checkout') }}" class="dc-btn-beli {{ $stokTersedia ? '' : 'disabled' }}">
                            <i class="fa-solid fa-credit-card"></i> Beli
                        </a>

                        @if (!$stokTersedia)
                        <div class="dc-warning">
                            <i class="fa-solid fa-triangle-exclamation"></i> Produk sedang habis, silakan cek kembali nanti.
                        </div>
                        @endif

                        <div class="dc-divider"></div>

                        <div class="dc-section-title">
                            <i class="fa-solid fa-file-lines"></i> Deskripsi Produk
                        </div>
                        <div class="dc-deskripsi">
                            @if ($produk && $produk->deskripsi)
                                <p>{!! nl2br(e($produk->deskripsi)) !!}</p>
                            @elseif ($produk)
                                <p>{{ $produk->nm_produk }} adalah produk kecantikan kategori <strong>{{ $kategori }}</strong> berkualitas dari BeautyCare. Dibanderol dengan harga <strong>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</strong> per {{ $satuan }}, produk ini telah terpercaya dan banyak dipilih pelanggan untuk kebutuhan perawatan kecantikan Anda sehari-hari.</p>
                                <p>Dapatkan hasil terbaik dengan pemakaian rutin. Jangan lewatkan kesempatan untuk memiliki produk andalan BeautyCare ini.</p>
                            @else
                                <p>Deskripsi produk tidak tersedia saat ini.</p>
                            @endif
                        </div>

                        <div class="dc-divider"></div>

                        <div class="dc-section-title">
                            <i class="fa-solid fa-circle-info"></i> Informasi Produk
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-tag"></i> Kategori</span>
                            <span class="dir-value">{{ $kategori }}</span>
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-cube"></i> Nama Produk</span>
                            <span class="dir-value">{{ $item->nm_produk }}</span>
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-boxes-stacked"></i> Jumlah</span>
                            <span class="dir-value" id="infoQty">{{ $item->qty }} {{ $satuan }}</span>
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-money-bill-wave"></i> Harga Satuan</span>
                            <span class="dir-value">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-receipt"></i> Subtotal</span>
                            <span class="dir-value" id="infoSubtotal">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if ($produk)
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-boxes-stacked"></i> Stok</span>
                            <span class="dir-value">{{ $produk->stok }} {{ $satuan }}</span>
                        </div>
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-solid fa-circle-check"></i> Status</span>
                            <span class="dir-value">{{ $produk->status }}</span>
                        </div>
                        @endif
                        <div class="dc-info-row">
                            <span class="dir-label"><i class="fa-regular fa-calendar"></i> Ditambahkan</span>
                            <span class="dir-value">{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>

    <script>
    var troliQty = {{ (int) $item->qty }};
    var troliHargaSatuan = {{ (int) $item->harga_satuan }};
    var troliStok = {{ (int) ($produk->stok ?? 0) }};
    var troliTersedia = {{ $stokTersedia ? 'true' : 'false' }};
    var troliItemId = {{ (int) $item->id }};
    var troliSyncBusy = false;

    function troliFormatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function troliUpdateSubtotal() {
        var subtotal = troliHargaSatuan * troliQty;
        document.getElementById('subtotalQty').textContent = troliQty;
        document.getElementById('subtotalNominal').textContent = troliFormatRupiah(subtotal);
        document.getElementById('infoQty').textContent = troliQty + ' {{ $satuan }}';
        document.getElementById('infoSubtotal').textContent = troliFormatRupiah(subtotal);
        document.getElementById('qtyVal').textContent = troliQty;

        var minus = document.getElementById('qtyMinusBtn');
        if (minus) minus.disabled = !troliTersedia || troliQty <= 1;
        var plus = document.getElementById('qtyPlusBtn');
        if (plus) plus.disabled = !troliTersedia || troliQty >= troliStok;
    }

    function troliSyncQty() {
        if (troliSyncBusy) return;
        troliSyncBusy = true;
        fetch('{{ route('pelanggan.keranjang.update', $item->id) }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ qty: troliQty })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            troliSyncBusy = false;
            if (!data.success) {
                if (data.qty && data.qty > 0) {
                    troliQty = data.qty;
                    troliUpdateSubtotal();
                }
            }
        })
        .catch(function() { troliSyncBusy = false; });
    }

    function qtyPlus() {
        if (!troliTersedia || troliQty >= troliStok) return;
        troliQty += 1;
        troliUpdateSubtotal();
        troliSyncQty();
    }

    function qtyMinus() {
        if (troliQty <= 1) return;
        troliQty -= 1;
        troliUpdateSubtotal();
        troliSyncQty();
    }

    troliUpdateSubtotal();
    </script>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
