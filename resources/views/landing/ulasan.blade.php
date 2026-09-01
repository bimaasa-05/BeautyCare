@extends('layouts.app')

@section('title', 'Semua Ulasan - BeautyCare')

@section('meta_description', 'Kumpulan rating dan ulasan pelanggan BeautyCare untuk layanan dan produk.')

@section('hide_footer', '1')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <style>
        .uv-hero {
            padding: 140px 0 40px;
            background: linear-gradient(180deg, #FFF0F5 0%, var(--white) 100%);
            text-align: center;
        }

        .uv-hero h1 {
            font-size: 34px;
            font-weight: var(--fw-bold);
            color: var(--dark);
            margin-bottom: 10px;
        }

        .uv-hero h1 span {
            color: var(--primary);
        }

        .uv-hero p {
            color: var(--gray);
            font-size: 15px;
        }

        .uv-score {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px 28px;
            margin-top: 22px;
            box-shadow: var(--shadow-sm);
        }

        .uv-score .uv-num {
            font-size: 34px;
            font-weight: var(--fw-bold);
            color: var(--dark);
        }

        .uv-score .uv-stars {
            color: #F59E0B;
            font-size: 18px;
            letter-spacing: 2px;
        }

        .uv-score .uv-total {
            font-size: 13px;
            color: var(--gray);
        }

        .uv-section {
            padding: 40px 0 72px;
        }

        .uv-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 24px;
        }

        .uv-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .uv-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .uv-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-base);
        }

        .uv-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .uv-objek {
            display: inline-block;
            font-size: 11px;
            font-weight: var(--fw-semibold);
            padding: 4px 12px;
            border-radius: var(--radius-full);
            margin-bottom: 12px;
        }

        .uv-objek.layanan {
            background: rgba(255, 79, 135, .1);
            color: var(--primary);
        }

        .uv-objek.produk {
            background: rgba(16, 185, 129, .1);
            color: #059669;
        }

        .uv-nama-objek {
            font-size: 14px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
            margin-bottom: 8px;
        }

        .uv-nama-objek a {
            color: inherit;
            text-decoration: none;
        }

        .uv-nama-objek a:hover {
            color: var(--primary);
        }

        .uv-stars {
            color: #F59E0B;
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .uv-text {
            font-size: 13.5px;
            color: var(--gray);
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .uv-author {
            display: flex;
            align-items: center;
            gap: 10px;
            border-top: 1px solid var(--border);
            padding-top: 14px;
        }

        .uv-avatar {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            object-fit: cover;
            background: #f3f4f6;
        }

        .uv-author-name {
            font-size: 13px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
        }

        .uv-author-date {
            font-size: 11px;
            color: var(--gray);
        }

        .uv-badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(16, 185, 129, .1);
            color: #059669;
            font-size: 10px;
            font-weight: var(--fw-semibold);
            padding: 2px 8px;
            border-radius: var(--radius-full);
            margin-left: 6px;
        }

        /* Badge Tingkat Membership - Premium & Mencolok */
        .tier-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            animation: tierBadgeIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .tier-badge::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 100px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .tier-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
        }

        .tier-badge:hover::before {
            opacity: 1;
        }

        .tier-badge:active {
            transform: translateY(0) scale(0.98);
        }

        .tier-badge i {
            font-size: 11px;
            animation: iconFloat 2.5s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-3px) rotate(2deg); }
        }

        @keyframes tierBadgeIn {
            0% { opacity: 0; transform: translateY(6px) scale(0.9); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Silver - Elegant & Cool */
        .tier-badge.silver {
            background: linear-gradient(135deg, #E2E8F0 0%, #F1F5F9 50%, #E2E8F0 100%);
            color: #475569;
            border: 1.5px solid #CBD5E1;
        }

        .tier-badge.silver::before {
            background: linear-gradient(135deg, rgba(148, 163, 184, 0.4), rgba(203, 213, 225, 0.6));
        }

        .tier-badge.silver:hover {
            box-shadow: 0 6px 24px rgba(100, 116, 139, 0.35);
        }

        /* Gold - Warm & Premium */
        .tier-badge.gold {
            background: linear-gradient(135deg, #FDE68A 0%, #FBBF24 50%, #FDE68A 100%);
            color: #92400E;
            border: 1.5px solid #FCD34D;
        }

        .tier-badge.gold::before {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.4), rgba(253, 211, 77, 0.6));
        }

        .tier-badge.gold:hover {
            box-shadow: 0 6px 24px rgba(245, 158, 11, 0.45);
        }

        /* Platinum - Exclusive & Luxury */
        .tier-badge.platinum {
            background: linear-gradient(135deg, #E0E7FF 0%, #A5B4FC 50%, #C7D2FE 100%);
            color: #4338CA;
            border: 1.5px solid #A5B4FC;
        }

        .tier-badge.platinum::before {
            background: linear-gradient(135deg, rgba(165, 180, 252, 0.4), rgba(199, 210, 254, 0.6));
        }

        .tier-badge.platinum:hover {
            box-shadow: 0 6px 24px rgba(99, 102, 241, 0.45);
        }

        .uv-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 56px 20px;
            color: var(--gray);
            background: var(--white);
            border: 1px dashed var(--border);
            border-radius: var(--radius-lg);
            font-size: 14px;
        }

        .uv-summary {
            max-width: 420px;
            margin: 22px auto 0;
        }

        .uv-tools {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .uv-filters {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            border: 1.5px solid var(--border);
            background: var(--white);
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .filter-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--hover);
        }

        .filter-tab.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            color: #fff;
            box-shadow: 0 4px 12px rgba(255, 79, 135, 0.25);
        }

        @media (max-width: 992px) {
            .uv-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .uv-grid {
                grid-template-columns: 1fr;
            }

            .uv-tools {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    @include('layouts.navbar')

    <section class="uv-hero">
        <div class="container">
            <h1>Semua <span>Ulasan</span></h1>
            <p>Pengalaman nyata para pelanggan BeautyCare.</p>
            <div class="uv-summary">
                @include('partials.rating-summary', ['ringkasan' => $ringkasan])
            </div>
        </div>
    </section>

    <section class="uv-section">
        <div class="container">
            <div class="uv-tools">
                <a href="{{ route('home') }}" class="btn-kembali">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
                <div class="uv-filters">
                    <a href="javascript:void(0)" class="filter-tab active" data-tipe="semua" onclick="filterUlasan('semua', this)">
                        <i class="fa-solid fa-th-large"></i> Semua
                    </a>
                    <a href="javascript:void(0)" class="filter-tab" data-tipe="layanan" onclick="filterUlasan('layanan', this)">
                        <i class="fa-solid fa-spa"></i> Layanan
                    </a>
                    <a href="javascript:void(0)" class="filter-tab" data-tipe="produk" onclick="filterUlasan('produk', this)">
                        <i class="fa-solid fa-cube"></i> Produk
                    </a>
                </div>
            </div>

            <div class="uv-grid">
                @forelse($ulasans as $ulasan)
                    <div class="uv-card" data-tipe="{{ $ulasan->tipe }}">
                        <span class="uv-objek {{ $ulasan->tipe }}">{{ $ulasan->tipe_label }}</span>
                        <div class="uv-nama-objek">
                            @if ($ulasan->tipe === 'layanan' && \App\Models\Layanan::find($ulasan->id_target))
                                <a href="{{ route('layanan.detail', $ulasan->id_target) }}">{{ $ulasan->nama_objek }}</a>
                            @else
                                {{ $ulasan->nama_objek }}
                            @endif
                        </div>
                        <div class="uv-stars">{{ str_repeat('★', $ulasan->bintang) }}{{ str_repeat('☆', 5 - $ulasan->bintang) }}</div>
                        @if ($ulasan->komentar)
                            <p class="uv-text">"{{ $ulasan->komentar }}"</p>
                        @else
                            <p class="uv-text" style="font-style:italic;color:#9CA3AF;">Tanpa komentar.</p>
                        @endif
                        <div class="uv-author">
                            <img class="uv-avatar" src="{{ $ulasan->foto_pemberi }}" alt="{{ $ulasan->nama_pemberi }}" loading="lazy">
                            <div>
                                <span class="uv-author-name">{{ $ulasan->nama_pemberi }}</span>
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
                                <div class="uv-author-date">
                                    {{ \Carbon\Carbon::parse($ulasan->created_at)->isoFormat('D MMM YYYY') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="uv-empty">
                        <p style="margin-bottom:10px;"><i class="fa-solid fa-star" style="font-size:32px;color:#F59E0B;"></i></p>
                        Belum ada ulasan. Jadilah pelanggan pertama yang memberi rating!
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

        @push('scripts')
        <script>
        function filterUlasan(tipe, tab) {
            document.querySelectorAll('.filter-tab').forEach(function(t) {
                t.classList.remove('active');
                if (t === tab) t.classList.add('active');
            });
            document.querySelectorAll('.uv-card').forEach(function(card) {
                var cardTipe = card.getAttribute('data-tipe');
                card.style.display = (tipe === 'semua' || cardTipe === tipe) ? '' : 'none';
            });
        }
        </script>
        @endpush