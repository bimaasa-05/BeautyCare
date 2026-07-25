<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Promo - BeautyCare</title>

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

    .promo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .promo-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .promo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .promo-card .promo-banner {
        height: 140px;
        position: relative;
        overflow: hidden;
    }

    .promo-card .promo-banner .promo-bg {
        position: absolute;
        inset: 0;
    }

    .promo-card .promo-banner .promo-bg.diskon {
        background: linear-gradient(135deg, #FF4F87, #FF7BA6);
    }

    .promo-card .promo-banner .promo-bg.bogo {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .promo-card .promo-banner .promo-bg.paket {
        background: linear-gradient(135deg, #22C55E, #4ADE80);
    }

    .promo-card .promo-banner .promo-bg.poin {
        background: linear-gradient(135deg, #3B82F6, #60A5FA);
    }

    .promo-card .promo-banner .promo-bg.spesial {
        background: linear-gradient(135deg, #8B5CF6, #A78BFA);
    }

    .promo-card .promo-banner .promo-deco {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .promo-card .promo-banner .promo-deco:nth-child(2) {
        width: 200px; height: 200px;
        top: -80px; right: -40px;
    }

    .promo-card .promo-banner .promo-deco:nth-child(3) {
        width: 100px; height: 100px;
        bottom: -30px; left: 20%;
        background: rgba(255, 255, 255, 0.05);
    }

    .promo-card .promo-banner .promo-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 5px 14px;
        border-radius: 100px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .promo-card .promo-banner .promo-icon-big {
        position: absolute;
        bottom: 16px;
        left: 20px;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
    }

    .promo-card .promo-body {
        padding: 20px;
    }

    .promo-card .promo-body .promo-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .promo-card .promo-body .promo-desc {
        font-size: 13px;
        color: var(--gray);
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .promo-card .promo-body .promo-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .promo-card .promo-body .promo-meta .pm-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--gray);
    }

    .promo-card .promo-body .promo-meta .pm-item i {
        font-size: 13px;
        color: var(--primary);
    }

    .promo-card .promo-body .promo-divider {
        height: 1px;
        background: var(--border);
        margin: 14px 0;
    }

    .promo-card .promo-body .promo-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .promo-card .promo-body .promo-footer .promo-code {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 8px;
        background: var(--hover);
        color: var(--primary);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        font-family: monospace;
    }

    .promo-card .promo-body .promo-footer .promo-code i {
        font-size: 11px;
        color: var(--gray);
    }

    .promo-btn-claim {
        padding: 8px 20px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .promo-btn-claim:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .promo-btn-claim.claimed {
        background: #D1FAE5;
        color: #059669;
        box-shadow: none;
        cursor: default;
    }

    .promo-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .promo-section-title i {
        color: var(--primary);
    }

    .promo-empty {
        text-align: center;
        padding: 60px 20px;
    }

    .promo-empty .pe-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: var(--primary);
        opacity: 0.6;
    }

    .promo-empty h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .promo-empty p {
        font-size: 13px;
        color: var(--gray);
    }

    .promo-banner-cta {
        background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF9CB8 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255, 79, 135, 0.25);
    }

    .promo-banner-cta .cta-deco {
        position: absolute;
        pointer-events: none;
    }

    .promo-banner-cta .cta-deco:nth-child(1) {
        width: 250px; height: 250px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        top: -100px; right: -50px;
    }

    .promo-banner-cta .cta-deco:nth-child(2) {
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -40px; left: 30%;
    }

    .promo-banner-cta .cta-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .promo-banner-cta .cta-content .cta-text h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .promo-banner-cta .cta-content .cta-text p {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 4px 0 0;
    }

    @media (max-width: 768px) {
        .promo-grid {
            grid-template-columns: 1fr;
        }

        .page-header-premium .ph-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
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
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Promo & Diskon</h3>
                                <p>Jangan lewatkan promo dan penawaran spesial dari BeautyCare</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="promo-banner-cta">
                    <div class="cta-deco"></div>
                    <div class="cta-deco"></div>
                    <div class="cta-content">
                        <div class="cta-text">
                            <h3><i class="fa-solid fa-bolt" style="margin-right:8px;"></i>Promo Spesial Bulan Ini!</h3>
                            <p>Dapatkan berbagai diskon dan penawaran menarik. Cek sekarang sebelum kehabisan!</p>
                        </div>
                        <span style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.15);color:#fff;font-size:13px;font-weight:600;white-space:nowrap;">
                            <i class="fa-regular fa-clock"></i> Berakhir 31 Jul 2026
                        </span>
                    </div>
                </div>

                <div class="promo-section-title">
                    <i class="fa-solid fa-fire"></i> Promo Aktif
                </div>

                <div class="promo-grid">
                    @forelse($promos as $promo)
                    @php
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
                        $opacity = $promo->status == 'Tersedia' ? '' : 'opacity:0.6;';
                    @endphp
                    <div class="promo-card" style="{{ $opacity }}">
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
                            <div class="promo-desc">{{ $promo->jenis_promo }} - Nilai {{ $promo->nilai }}{{ $promo->jenis_promo == 'Diskon' ? '%' : '' }}</div>
                            <div class="promo-meta">
                                <span class="pm-item"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($promo->mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($promo->selesai)->format('d M Y') }}</span>
                                <span class="pm-item"><i class="fa-regular fa-user"></i> Semua Pelanggan</span>
                            </div>
                            <div class="promo-divider"></div>
                            <div class="promo-footer">
                                <span class="promo-code"><i class="fa-regular fa-ticket"></i> {{ strtoupper(str_replace(' ', '', substr($promo->nm_promo, 0, 8))) }}</span>
                                @if($promo->status == 'Tersedia')
                                <button class="promo-btn-claim">Klaim Now</button>
                                @else
                                <button class="promo-btn-claim claimed"><i class="fa-regular fa-circle-check"></i> {{ $promo->status }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="promo-empty" style="grid-column:1/-1;">
                        <div class="pe-icon">
                            <i class="fa-regular fa-calendar-xmark"></i>
                        </div>
                        <h4>Belum Ada Promo</h4>
                        <p>Belum ada promo yang tersedia saat ini.</p>
                    </div>
                    @endforelse
                </div>

                <div style="margin-top:32px;">
                    <div class="promo-section-title">
                        <i class="fa-regular fa-clock"></i> Promo Sebelumnya
                    </div>

                    <div class="promo-empty">
                        <div class="pe-icon">
                            <i class="fa-regular fa-calendar-xmark"></i>
                        </div>
                        <h4>Belum Ada Riwayat Promo</h4>
                        <p>Promo yang sudah berakhir akan tampil di sini.</p>
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
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
