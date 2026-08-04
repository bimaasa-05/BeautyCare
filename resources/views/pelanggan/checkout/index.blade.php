<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - BeautyCare</title>
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

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
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

    .btn-back {
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
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }

    .checkout-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .checkout-card .cc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .checkout-card .cc-header .cc-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .checkout-card .cc-header .cc-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .checkout-card .cc-header .cc-subtitle {
        font-size: 12px;
        color: var(--gray);
    }

    .cc-body {
        padding: 20px 24px;
    }

    .co-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed #F0F0F0;
    }

    .co-item:last-child {
        border-bottom: none;
    }

    .co-item .coi-info .coi-nama {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .co-item .coi-info .coi-meta {
        font-size: 11px;
        color: var(--gray);
        margin-top: 2px;
    }

    .co-item .coi-harga {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
    }

    .co-divider {
        height: 1px;
        background: var(--border);
        margin: 16px 0;
    }

    .co-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--gray);
        padding: 6px 0;
    }

    .co-row.co-row-total {
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
        padding-top: 12px;
        border-top: 1px solid var(--border);
        margin-top: 8px;
    }

    .co-row.co-row-total .co-val {
        color: var(--primary);
    }

    .co-row .co-val {
        font-weight: 600;
        color: var(--dark);
    }

    .co-member-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #F5F5F4;
        border: 1px solid var(--border);
        margin-bottom: 14px;
    }

    .co-member-card.co-member-aktif {
        background: #ECFDF5;
        border-color: #A7F3D0;
    }

    .co-member-card .cmc-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, #B45309, #F59E0B);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .co-member-card .cmc-title {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .co-member-card .cmc-badge {
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        background: #D1FAE5;
        color: #059669;
    }

    .co-member-card .cmc-badge.cmc-badge-wait {
        background: #FEF3C7;
        color: #B45309;
    }

    .co-member-card .cmc-desc {
        font-size: 11px;
        color: var(--gray);
        margin-top: 2px;
    }

    .co-select {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        font-size: 12px;
        font-family: 'Poppins', sans-serif;
        background: #FAFAFA;
        outline: none;
        margin-top: 8px;
    }

    .pay-group {
        margin-bottom: 18px;
    }

    .pay-group .pg-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .pay-group .pg-title i {
        color: var(--primary);
        font-size: 13px;
    }

    .pay-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .pay-option:hover {
        border-color: #FFB3C7;
        background: #FFF9FB;
    }

    .pay-option.selected {
        border-color: var(--primary);
        background: #FFF5F8;
        box-shadow: 0 2px 8px rgba(255, 79, 135, 0.12);
    }

    .pay-option input {
        accent-color: var(--primary);
        width: 15px;
        height: 15px;
    }

    .pay-option .po-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #F5F5F7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--dark);
        flex-shrink: 0;
    }

    .pay-option.selected .po-icon {
        background: var(--hover);
        color: var(--primary);
    }

    .pay-option .po-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--dark);
        flex: 1;
    }

    .pay-option .po-desc {
        font-size: 11px;
        color: var(--gray);
    }

    .btn-buat-pesanan {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-buat-pesanan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(255, 79, 135, 0.4);
    }

    .btn-buat-pesanan:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .co-note {
        font-size: 11px;
        color: var(--gray);
        text-align: center;
        margin-top: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .alert-box {
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-box.alert-error {
        background: #FEF2F2;
        color: #B91C1C;
        border: 1px solid #FECACA;
    }

    .alert-box.alert-success {
        background: #ECFDF5;
        color: #047857;
        border: 1px solid #A7F3D0;
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
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Checkout</h3>
                                <p>Periksa pesanan Anda lalu pilih metode pembayaran</p>
                            </div>
                        </div>
                        <a href="{{ $isMembership ? route('pelanggan.membership') : route('pelanggan.keranjang') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> {{ $isMembership ? 'Kembali ke Membership' : 'Kembali ke Keranjang' }}
                        </a>
                    </div>
                </div>

                @if (session('error'))
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('pelanggan.checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="metode" id="inpMetode">
                    <input type="hidden" name="provider" id="inpProvider">
                    @if(request('beli'))
                    <input type="hidden" name="beli" value="{{ request('beli') }}">
                    <input type="hidden" name="qty" value="{{ request('qty', 1) }}">
                    @endif
                    @if(request('beli_membership'))
                    <input type="hidden" name="beli_membership" value="{{ request('beli_membership') }}">
                    @endif

                    <div class="checkout-layout">
                        <div class="checkout-card">
                            <div class="cc-header">
                                <div class="cc-icon"><i class="fa-solid fa-receipt"></i></div>
                                <div>
                                    <div class="cc-title">Ringkasan Pesanan</div>
                                    <div class="cc-subtitle">{{ count($items) }} {{ $isMembership ? 'paket membership siap diproses' : 'produk siap diproses' }}</div>
                                </div>
                            </div>
                            <div class="cc-body">
                                @foreach($items as $item)
                                <div class="co-item">
                                    <div class="coi-info">
                                        <div class="coi-nama">{{ $item['nm_produk'] }}</div>
                                        <div class="coi-meta">
                                            @if($isMembership)
                                            {{ $item['kategori'] }} {{ $membership->tingkat }} &bull; Masa berlaku {{ $membership->masa_berlaku }} hari &bull; Sekali bayar
                                            @else
                                            {{ $item['kategori'] }} &bull; {{ $item['qty'] }} x Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }} &bull; Stok: {{ $item['stok'] }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="coi-harga">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                </div>
                                @endforeach

                                <div class="co-divider"></div>

                                @if($memberInfo['level'])
                                <div class="co-member-card {{ $memberInfo['aktif'] ? 'co-member-aktif' : '' }}">
                                    <div class="cmc-icon"><i class="fa-solid fa-gem"></i></div>
                                    <div>
                                        <div class="cmc-title">
                                            Level Anda: {{ $memberInfo['level'] }}
                                            @if($memberInfo['aktif'])
                                            <span class="cmc-badge">Diskon {{ rtrim(rtrim(number_format($memberInfo['diskon_pct'], 1, '.', ','), '0'), ',') }}% Aktif</span>
                                            @else
                                            <span class="cmc-badge cmc-badge-wait">Butuh {{ $memberInfo['sisa'] }} pembelian lagi</span>
                                            @endif
                                        </div>
                                        <div class="cmc-desc">
                                            @if($memberInfo['aktif'])
                                            Diskon member {{ $memberInfo['level'] }} {{ rtrim(rtrim(number_format($memberInfo['diskon_pct'], 1, '.', ','), '0'), ',') }}% otomatis berlaku di total Anda (atau promo bila lebih besar).
                                            @else
                                            Selesaikan {{ $memberInfo['sisa'] }} pembelian lagi untuk mengaktifkan diskon member {{ $memberInfo['level'] }} {{ rtrim(rtrim(number_format($memberInfo['diskon_pct'], 1, '.', ','), '0'), ',') }}%.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(isset($claimedPromos) && $claimedPromos->isNotEmpty())
                                <div class="co-row">
                                    <div>Promo Saya</div>
                                    <div style="width: 60%;">
                                        <select class="co-select" name="id_promo" id="coPromo" onchange="hitungRingkasan()">
                                            <option value="">— Tanpa Promo —</option>
                                            @foreach($claimedPromos as $cp)
                                            <option value="{{ $cp->id_promo }}" data-jenis="{{ $cp->promo->jenis_promo }}" data-nilai="{{ $cp->promo->nilai }}">
                                                {{ $cp->promo->nm_promo }} ({{ $cp->promo->jenis_promo == 'Diskon' ? $cp->promo->nilai.'%' : 'Rp '.number_format($cp->promo->nilai,0,',','.') }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="co-row">
                                    <div>Diskon <span id="ringkasDiskonLabel" style="font-size:11px;color:var(--primary);"></span></div>
                                    <div class="co-val" id="ringkasDiskon">Rp {{ number_format($memberInfo['aktif'] ? $memberInfo['diskon'] : 0, 0, ',', '.') }}</div>
                                </div>

                                <div class="co-row">
                                    <div>Subtotal</div>
                                    <div class="co-val" id="ringkasSubtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                </div>
                                <div class="co-row co-row-total">
                                    <div>Total Bayar</div>
                                    <div class="co-val" id="ringkasTotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-card">
                            <div class="cc-header">
                                <div class="cc-icon"><i class="fa-solid fa-wallet"></i></div>
                                <div>
                                    <div class="cc-title">Metode Pembayaran</div>
                                    <div class="cc-subtitle">Pilih salah satu metode</div>
                                </div>
                            </div>
                            <div class="cc-body">
                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-qrcode"></i> QRIS</div>
                                    <label class="pay-option" data-metode="QRIS" data-provider="QRIS">
                                        <input type="radio" name="pay" value="QRIS">
                                        <div class="po-icon"><i class="fa-solid fa-qrcode"></i></div>
                                        <div>
                                            <div class="po-label">QRIS (Semua Aplikasi)</div>
                                            <div class="po-desc">Scan sekali untuk semua e-wallet & m-banking</div>
                                        </div>
                                    </label>
                                </div>

                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-building-columns"></i> Transfer Bank (Virtual Account)</div>
                                    @foreach($bankTujuan as $bank => $noRek)
                                    <label class="pay-option" data-metode="Transfer" data-provider="{{ $bank }}">
                                        <input type="radio" name="pay" value="{{ $bank }}">
                                        <div class="po-icon"><i class="fa-solid fa-building-columns"></i></div>
                                        <div>
                                            <div class="po-label">Bank {{ $bank }}</div>
                                            <div class="po-desc">Virtual Account otomatis, valid 24 jam</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-mobile-screen"></i> E-Wallet</div>
                                    @foreach(['Dana' => 'fa-solid fa-qrcode', 'GoPay' => 'fa-solid fa-qrcode', 'OVO' => 'fa-solid fa-qrcode', 'ShopeePay' => 'fa-solid fa-qrcode'] as $ewallet => $icon)
                                    <label class="pay-option" data-metode="E-Wallet" data-provider="{{ $ewallet }}">
                                        <input type="radio" name="pay" value="{{ $ewallet }}">
                                        <div class="po-icon"><i class="{{ $icon }}"></i></div>
                                        <div>
                                            <div class="po-label">{{ $ewallet }}</div>
                                            <div class="po-desc">Bayar cepat lewat aplikasi {{ $ewallet }}</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn-buat-pesanan" id="btnBuatPesanan" disabled>
                                    <i class="fa-solid fa-check-circle"></i> Buat Pesanan
                                </button>
                                <div class="co-note">
                                    <i class="fa-regular fa-clock"></i>
                                    Batas bayar QRIS & E-Wallet 10 menit, Transfer 24 jam
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    var subtotal = parseInt('{{ $subtotal }}');
    var memberDiskon = parseInt('{{ $memberInfo['aktif'] ? $memberInfo['diskon'] : 0 }}');
    var memberLabel = '{{ $memberInfo['aktif'] ? "Member " . $memberInfo['level'] . " " . rtrim(rtrim(number_format($memberInfo['diskon_pct'], 1, '.', ','), '0'), ',') . "%" : '' }}';
    var totalGlobal = subtotal - memberDiskon;

    document.querySelectorAll('.pay-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
            document.querySelectorAll('.pay-option').forEach(function(o) {
                o.classList.remove('selected');
                o.querySelector('input').checked = false;
            });
            opt.classList.add('selected');
            opt.querySelector('input').checked = true;
            document.getElementById('inpMetode').value = opt.getAttribute('data-metode');
            document.getElementById('inpProvider').value = opt.getAttribute('data-provider');
            document.getElementById('btnBuatPesanan').disabled = false;
        });
    });

    function hitungRingkasan() {
        var select = document.getElementById('coPromo');
        var promoDiskon = 0;
        var promoLabel = '';
        if (select && select.value) {
            var selected = select.options[select.selectedIndex];
            var jenis = selected.getAttribute('data-jenis');
            var nilai = parseFloat(selected.getAttribute('data-nilai'));
            if (jenis === 'Diskon') {
                promoDiskon = Math.round(subtotal * nilai / 100);
            } else {
                promoDiskon = Math.round(Math.min(nilai, subtotal));
            }
            promoLabel = 'Promo';
        }
        var diskon = 0;
        var label = '';
        if (promoDiskon > 0 && promoDiskon >= memberDiskon) {
            diskon = promoDiskon;
            label = promoLabel;
        } else if (memberDiskon > 0) {
            diskon = memberDiskon;
            label = memberLabel;
        }
        document.getElementById('ringkasDiskon').textContent = 'Rp ' + diskon.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        document.getElementById('ringkasDiskonLabel').textContent = label ? '(' + label + ')' : '';
        totalGlobal = subtotal - diskon;
        document.getElementById('ringkasTotal').textContent = 'Rp ' + totalGlobal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    if (memberDiskon > 0) {
        document.getElementById('ringkasDiskonLabel').textContent = '(' + memberLabel + ')';
        document.getElementById('ringkasTotal').textContent = 'Rp ' + totalGlobal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        if (!document.getElementById('inpProvider').value) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
        }
    });

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
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
