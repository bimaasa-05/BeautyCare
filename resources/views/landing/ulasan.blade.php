@extends('layouts.app')

@section('title', 'Semua Ulasan - BeautyCare')

@section('meta_description', 'Kumpulan rating dan ulasan pelanggan BeautyCare untuk layanan dan produk.')

@push('styles')
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

        @media (max-width: 992px) {
            .uv-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .uv-grid {
                grid-template-columns: 1fr;
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
            <div class="uv-score">
                <span class="uv-num">{{ number_format($ringkasan['rata'], 1, ',', '.') }}</span>
                <span class="uv-stars">{{ str_repeat('★', (int) round($ringkasan['rata'])) }}{{ str_repeat('☆', 5 - (int) round($ringkasan['rata'])) }}</span>
                <span class="uv-total">Berdasarkan {{ $ringkasan['jumlah'] }} ulasan</span>
            </div>
        </div>
    </section>

    <section class="uv-section">
        <div class="container">
            <div class="uv-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>›</span>
                <span>Semua Ulasan</span>
            </div>

            <div class="uv-grid">
                @forelse($ulasans as $ulasan)
                    <div class="uv-card">
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
                                <span class="uv-badge-verified"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span>
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