<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Membership - BeautyCare</title>
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

    .pay-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .pay-layout {
            grid-template-columns: 1fr;
        }
    }

    .pay-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .pay-card .pc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pay-card .pc-header .pc-icon {
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

    .pay-card .pc-header .pc-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .pay-card .pc-header .pc-subtitle {
        font-size: 12px;
        color: var(--gray);
    }

    .pc-body {
        padding: 20px 24px;
    }

    .tier-banner {
        height: 110px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        margin-bottom: 18px;
    }

    .tier-banner.silver {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .tier-banner.gold {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .tier-banner.platinum {
        background: linear-gradient(135deg, #6366F1, #818CF8);
    }

    .tier-banner .tb-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
    }

    .tier-banner .tb-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 4px 12px;
        border-radius: 100px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .pm-member-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .pm-member-desc {
        font-size: 12px;
        color: var(--gray);
        margin-top: 2px;
        margin-bottom: 14px;
    }

    .pm-benefit {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark);
        padding: 4px 0;
    }

    .pm-benefit i {
        width: 18px;
        font-size: 13px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .pm-divider {
        height: 1px;
        background: var(--border);
        margin: 16px 0;
    }

    .pm-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--gray);
        padding: 6px 0;
    }

    .pm-row .pm-val {
        font-weight: 600;
        color: var(--dark);
    }

    .pm-row .pm-val.primary {
        color: var(--primary);
    }

    .pm-syarat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 100px;
        background: #D1FAE5;
        color: #059669;
    }

    .pm-total {
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
        padding-top: 12px;
        border-top: 1px solid var(--border);
        margin-top: 8px;
    }

    .pm-total .pm-val {
        color: var(--primary);
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

    .alert-saldo-kurang {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 14px;
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        color: #92400E;
        font-size: 12px;
        line-height: 1.55;
    }

    .alert-saldo-kurang i {
        margin-top: 2px;
        color: #D97706;
    }

    .alert-saldo-kurang b {
        color: #92400E;
    }

    .pay-option.pay-option-saldo.selected {
        border-color: #10B981;
        background: #ECFDF5;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
    }

    .pay-option.pay-option-saldo.selected .po-icon {
        background: #D1FAE5;
        color: #059669;
    }

    .pay-option.disabled {
        opacity: 0.65;
        cursor: not-allowed;
        background: #FAFAFA;
    }

    .pay-option.disabled:hover {
        border-color: var(--border);
        background: #FAFAFA;
    }

    .pay-option.highlight-kombinasi {
        border-color: #10B981;
        background: #F0FDF4;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
    }

    .pay-option-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        border: 1.5px dashed #10B981;
        border-radius: 12px;
        color: #059669;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        background: #F0FDF4;
        transition: all 0.2s ease;
    }

    .pay-option-link:hover {
        background: #D1FAE5;
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
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Pembayaran Membership</h3>
                                <p>Pilih metode pembayaran untuk {{ !empty($isRenewal) ? 'memperpanjang' : 'mengaktifkan' }} membership {{ $member->tingkat }} Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.membership') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Membership
                        </a>
                    </div>
                </div>

                @if (session('error'))
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif

                @php
                    $tierIcons = [
                        'Silver' => ['icon' => 'fa-solid fa-medal', 'banner' => 'silver'],
                        'Gold' => ['icon' => 'fa-solid fa-trophy', 'banner' => 'gold'],
                        'Platinum' => ['icon' => 'fa-solid fa-gem', 'banner' => 'platinum'],
                    ];
                    $tier = $tierIcons[$member->tingkat] ?? ['icon' => 'fa-solid fa-medal', 'banner' => 'silver'];
                @endphp

                <form action="{{ route('pelanggan.checkout.store') }}" method="POST" id="formPembayaranMembership">
                    @csrf
                    <input type="hidden" name="metode" id="inpMetode">
                    <input type="hidden" name="provider" id="inpProvider">
                    <input type="hidden" name="bank_id" id="inpBankId">
                    <input type="hidden" name="pakai_saldo" id="pakaiSaldoHidden" value="0">
                    <input type="hidden" name="beli_membership" value="{{ $member->id_member }}">

                    <div class="pay-layout">
                        <div class="pay-card">
                            <div class="pc-header">
                                <div class="pc-icon"><i class="fa-solid fa-gem"></i></div>
                                <div>
                                    <div class="pc-title">Ringkasan Membership</div>
                                    <div class="pc-subtitle">Paket membership {{ $member->tingkat }} {{ !empty($isRenewal) ? 'akan diperpanjang' : 'siap diaktifkan' }}</div>
                                </div>
                            </div>
                            <div class="pc-body">
                                <div class="tier-banner {{ $tier['banner'] }}">
                                    <div class="tb-icon">
                                        <i class="{{ $tier['icon'] }}"></i>
                                    </div>
                                    <span class="tb-badge">{{ $member->tingkat }}</span>
                                </div>

                                <div class="pm-member-name">{{ $member->nm_member }}</div>
                                <div class="pm-member-desc">Membership {{ $member->tingkat }} &bull; Diskon {{ rtrim(rtrim(number_format($member->diskon, 1, '.', ','), '0'), ',') }}% &bull; Masa berlaku {{ $member->masa_berlaku }} hari</div>

                                <div class="pm-benefit">
                                    <i class="fa-regular fa-circle-check"></i> Diskon {{ rtrim(rtrim(number_format($member->diskon, 1, '.', ','), '0'), ',') }}% semua layanan
                                </div>
                                <div class="pm-benefit">
                                    <i class="fa-regular fa-circle-check"></i> Gratis konsultasi sesuai level
                                </div>
                                <div class="pm-benefit">
                                    <i class="fa-regular fa-circle-check"></i> Prioritas booking & event eksklusif
                                </div>

                                <div class="pm-divider"></div>

                                @if(!empty($isRenewal))
                                <div class="pm-row">
                                    <span><i class="fa-regular fa-clock" style="color: var(--primary); width: 16px; margin-right: 4px;"></i> Perpanjang masa aktif tanpa syarat minimum</span>
                                    <span class="pm-syarat"><i class="fa-solid fa-check"></i> Perpanjang</span>
                                </div>
                                @else
                                <div class="pm-row">
                                    <span><i class="fa-solid fa-bag-shopping" style="color: var(--primary); width: 16px; margin-right: 4px;"></i> Min. {{ $member->min_transaksi }}x Pembelian Produk</span>
                                    <span class="pm-syarat"><i class="fa-solid fa-check"></i> Terpenuhi</span>
                                </div>
                                <div class="pm-row">
                                    <span><i class="fa-solid fa-wallet" style="color: var(--primary); width: 16px; margin-right: 4px;"></i> Min. Belanja Rp {{ number_format($member->min_pembelian, 0, ',', '.') }}</span>
                                    <span class="pm-syarat"><i class="fa-solid fa-check"></i> Terpenuhi</span>
                                </div>
                                @endif

                                <div class="pm-divider"></div>

                                <div class="pm-row">
                                    <span>Subtotal</span>
                                    <span class="pm-val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="pm-row" id="rowPakaiSaldo" style="display:none;">
                                    <span>Dibayar Saldo Akun</span>
                                    <span class="pm-val" style="color: #059669;" id="ringkasPakaiSaldo">Rp 0</span>
                                </div>
                                <div class="pm-row" id="rowMetodeKedua" style="display:none;">
                                    <span>Dibayar <span id="metodeKeduaLabel">Metode Kedua</span></span>
                                    <span class="pm-val" id="ringkasMetodeKedua">Rp 0</span>
                                </div>
                                <div class="pm-total pm-row">
                                    <span>Total Bayar</span>
                                    <span class="pm-val" id="ringkasTotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="pay-card">
                            <div class="pc-header">
                                <div class="pc-icon"><i class="fa-solid fa-wallet"></i></div>
                                <div>
                                    <div class="pc-title">Metode Pembayaran</div>
                                    <div class="pc-subtitle">Pilih salah satu metode</div>
                                </div>
                            </div>
                            <div class="pc-body">
                                <div class="alert-saldo-kurang" id="alertSaldoKurang" style="display: none;">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    <div>
                                        Saldo Akun Anda <b>Rp <span id="alertSaldoNom">0</span></b> belum cukup untuk total
                                        <b>Rp <span id="alertSaldoTotal">0</span></b>. Sisa <b>Rp <span id="alertSaldoSisa">0</span></b>
                                        akan dibayar dengan metode kedua di bawah.
                                    </div>
                                </div>

                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-wallet" style="color: #10B981;"></i> Saldo Akun</div>
                                    @if($saldo <= 0)
                                    <label class="pay-option pay-option-saldo disabled" data-metode="Saldo" data-provider="Saldo Akun" aria-disabled="true">
                                        <input type="radio" name="pay_saldo" value="Saldo Akun" disabled>
                                        <div class="po-icon" style="background: #E5E7EB; color: #9CA3AF;"><i class="fa-solid fa-wallet"></i></div>
                                        <div>
                                            <div class="po-label">Saldo Akun (Rp 0)</div>
                                            <div class="po-desc">Saldo kosong — isi dulu untuk bisa bayar memakai saldo</div>
                                        </div>
                                    </label>
                                    <a href="{{ route('pelanggan.saldo.topup') }}" class="pay-option-link"><i class="fa-solid fa-plus"></i> Isi Saldo Akun</a>
                                    @else
                                    <label class="pay-option pay-option-saldo" data-metode="Saldo" data-provider="Saldo Akun">
                                        <input type="radio" name="pay_saldo" value="Saldo Akun">
                                        <div class="po-icon" style="background: #D1FAE5; color: #059669;"><i class="fa-solid fa-wallet"></i></div>
                                        <div>
                                            <div class="po-label">Saldo Akun (Rp {{ number_format($saldo, 0, ',', '.') }})</div>
                                            <div class="po-desc" id="saldoDesc">
                                                @if($saldo >= $subtotal)
                                                Cukup untuk membayar penuh, tanpa metode lain
                                                @else
                                                Saldo tidak cukup penuh, siapkan metode kedua untuk sisa
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                    @endif
                                </div>

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
                                    @foreach($banks as $bank)
                                    <label class="pay-option" data-metode="Transfer" data-provider="{{ $bank->nama_bank }}" data-bank-id="{{ $bank->id }}">
                                        <input type="radio" name="pay" value="{{ $bank->nama_bank }}">
                                        <div class="po-icon">
                                            @if($bank->logo)
                                                <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->nama_bank }}" style="width:24px;height:24px;object-fit:contain;">
                                            @else
                                                <i class="fa-solid fa-building-columns"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="po-label">Bank {{ $bank->nama_bank }}</div>
                                            <div class="po-desc">Virtual Account otomatis, valid 24 jam</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn-buat-pesanan" id="btnBuatPesanan" disabled>
                                    <i class="fa-solid fa-check-circle"></i> Buat Pesanan
                                </button>
                                <div class="co-note">
                                    <i class="fa-regular fa-clock"></i>
                                    Batas bayar QRIS 3 menit, Transfer 15 menit
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
    var saldoTersedia = parseInt('{{ $saldo ?? 0 }}');

    var saldoTerpakai = 0;
    var metodeKedua = null; // 'QRIS' atau 'Transfer' atau nama bank
    var providerKedua = null;
    var bankIdKedua = null;

    function fmtAngka(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungRingkasan() {
        var totalBayar = subtotal;
        var pakaiSaldo = 0;
        var saldoChecked = document.querySelector('.pay-option-saldo input') ? document.querySelector('.pay-option-saldo input').checked : false;

        if (saldoChecked) {
            pakaiSaldo = Math.max(0, Math.min(saldoTersedia, totalBayar));
        }
        saldoTerpakai = pakaiSaldo;
        document.getElementById('pakaiSaldoHidden').value = pakaiSaldo;

        var elPakai = document.getElementById('ringkasPakaiSaldo');
        var rowPakaiSaldo = document.getElementById('rowPakaiSaldo');
        if (saldoChecked && pakaiSaldo > 0) {
            rowPakaiSaldo.style.display = 'flex';
            elPakai.textContent = 'Rp ' + fmtAngka(pakaiSaldo);
        } else {
            rowPakaiSaldo.style.display = 'none';
            if (elPakai) elPakai.textContent = 'Rp 0';
        }

        var sisaBayar = totalBayar - pakaiSaldo;
        var rowMetodeKedua = document.getElementById('rowMetodeKedua');
        var elMetodeKedua = document.getElementById('ringkasMetodeKedua');
        var metodeKeduaLabel = document.getElementById('metodeKeduaLabel');

        if (metodeKedua && sisaBayar > 0) {
            rowMetodeKedua.style.display = 'flex';
            metodeKeduaLabel.textContent = providerKedua || 'Metode Kedua';
            elMetodeKedua.textContent = 'Rp ' + fmtAngka(sisaBayar);
        } else {
            rowMetodeKedua.style.display = 'none';
            if (elMetodeKedua) elMetodeKedua.textContent = 'Rp 0';
        }

        document.getElementById('ringkasTotal').textContent = 'Rp ' + fmtAngka(sisaBayar > 0 ? sisaBayar : totalBayar);

        updateButtonState();
    }

    function updateButtonState() {
        var btn = document.getElementById('btnBuatPesanan');
        var saldoEl = document.querySelector('.pay-option-saldo input');
        var saldoChecked = saldoEl ? saldoEl.checked : false;
        var pakaiSaldo = saldoChecked ? Math.max(0, Math.min(saldoTersedia, subtotal)) : 0;
        var sisaBayar = subtotal - pakaiSaldo;

        var alertEl = document.getElementById('alertSaldoKurang');
        var nonSaldoOpts = document.querySelectorAll('.pay-option:not(.pay-option-saldo)');

        if (saldoChecked && saldoTersedia < subtotal) {
            document.getElementById('alertSaldoNom').textContent = 'Rp ' + fmtAngka(saldoTersedia);
            document.getElementById('alertSaldoTotal').textContent = 'Rp ' + fmtAngka(subtotal);
            document.getElementById('alertSaldoSisa').textContent = 'Rp ' + fmtAngka(sisaBayar);
            alertEl.style.display = 'flex';
            nonSaldoOpts.forEach(function(o) {
                o.classList.add('highlight-kombinasi');
            });
        } else {
            alertEl.style.display = 'none';
            nonSaldoOpts.forEach(function(o) {
                o.classList.remove('highlight-kombinasi');
            });
        }

        var canSubmit = false;
        if (saldoChecked && sisaBayar <= 0) {
            canSubmit = true;
        } else if (saldoChecked && sisaBayar > 0 && metodeKedua) {
            canSubmit = true;
        } else if (!saldoChecked && metodeKedua) {
            canSubmit = true;
        }

        btn.disabled = !canSubmit;
    }

    function clearSelection(group) {
        document.querySelectorAll(group).forEach(function(o) {
            o.classList.remove('selected');
            o.querySelector('input').checked = false;
        });
    }

    document.querySelectorAll('.pay-option-saldo').forEach(function(opt) {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            if (opt.classList.contains('disabled')) return;
            var input = opt.querySelector('input');
            var wasChecked = input.checked;

            if (wasChecked) {
                clearSelection('.pay-option-saldo');
                document.getElementById('inpMetode').value = '';
                document.getElementById('inpProvider').value = '';
                document.getElementById('inpBankId').value = '';
            } else {
                clearSelection('.pay-option-saldo');
                opt.classList.add('selected');
                input.checked = true;
                document.getElementById('inpMetode').value = 'Saldo';
                document.getElementById('inpProvider').value = 'Saldo Akun';
                document.getElementById('inpBankId').value = '';
            }
            hitungRingkasan();
        });
    });

    document.querySelectorAll('.pay-option:not(.pay-option-saldo)').forEach(function(opt) {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            if (opt.classList.contains('disabled')) return;
            var input = opt.querySelector('input');
            var wasChecked = input.checked;

            if (wasChecked) {
                clearSelection('.pay-option:not(.pay-option-saldo)');
                metodeKedua = null;
                providerKedua = null;
                bankIdKedua = null;
                document.getElementById('inpMetode').value = '';
                document.getElementById('inpProvider').value = '';
                document.getElementById('inpBankId').value = '';
            } else {
                clearSelection('.pay-option:not(.pay-option-saldo)');
                opt.classList.add('selected');
                input.checked = true;
                metodeKedua = opt.getAttribute('data-metode');
                providerKedua = opt.getAttribute('data-provider');
                bankIdKedua = opt.getAttribute('data-bank-id') || null;
                document.getElementById('inpMetode').value = metodeKedua;
                document.getElementById('inpProvider').value = providerKedua;
                document.getElementById('inpBankId').value = bankIdKedua || '';
            }

            document.getElementById('alertSaldoKurang').style.display = 'none';
            document.querySelectorAll('.pay-option.highlight-kombinasi').forEach(function(o) {
                o.classList.remove('highlight-kombinasi');
            });

            hitungRingkasan();
        });
    });

    hitungRingkasan();

    document.getElementById('formPembayaranMembership').addEventListener('submit', function(e) {
        var btn = document.getElementById('btnBuatPesanan');
        if (btn && btn.disabled) {
            e.preventDefault();
            alert('Saldo akun tidak cukup. Pilih metode kedua (QRIS/Transfer) untuk sisa pembayaran.');
        } else if (!document.getElementById('inpProvider').value) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
        } else if (document.getElementById('inpMetode').value === 'Transfer' && !document.getElementById('inpBankId').value) {
            e.preventDefault();
            alert('Silakan pilih bank untuk transfer.');
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