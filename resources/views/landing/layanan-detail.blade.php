@extends('layouts.app')

@section('title', $layanan->nm_layanan . ' - BeautyCare')

@section('meta_description', 'Detail layanan ' . $layanan->nm_layanan . ' beserta rating dan ulasan pelanggan BeautyCare.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <style>
        .ld-hero {
            padding: 140px 0 0;
            background: linear-gradient(180deg, #FFF0F5 0%, var(--white) 100%);
        }

        .ld-hero-inner {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 48px;
            align-items: center;
        }

        .ld-hero-img {
            border-radius: var(--radius-lg);
            overflow: hidden;
            height: 380px;
            box-shadow: var(--shadow-md);
        }

        .ld-hero-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ld-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 16px;
        }

        .ld-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .ld-category {
            display: inline-block;
            background: rgba(255, 79, 135, .1);
            color: var(--primary);
            font-size: 12px;
            font-weight: var(--fw-semibold);
            padding: 6px 14px;
            border-radius: var(--radius-full);
            margin-bottom: 14px;
        }

        .ld-hero-title {
            font-size: 36px;
            font-weight: var(--fw-bold);
            color: var(--dark);
            margin-bottom: 12px;
            line-height: 1.25;
        }

        .ld-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 18px;
            font-size: 14px;
            color: var(--gray);
        }

        .ld-hero-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .ld-hero-meta i {
            color: var(--primary);
        }

        .ld-hero-price {
            font-size: 28px;
            font-weight: var(--fw-bold);
            color: var(--primary);
            margin-bottom: 20px;
        }

        .ld-summary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 14px 22px;
            box-shadow: var(--shadow-sm);
        }

        .ld-summary .ld-stars {
            color: #F59E0B;
            font-size: 18px;
            letter-spacing: 2px;
        }

        .ld-summary .ld-score {
            font-size: 26px;
            font-weight: var(--fw-bold);
            color: var(--dark);
        }

        .ld-summary .ld-count {
            font-size: 13px;
            color: var(--gray);
        }

        .ld-section {
            padding: 56px 0;
        }

        .ld-section-title {
            font-size: 22px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ld-section-title i {
            color: var(--primary);
        }

        .ld-rating-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 32px;
            align-items: start;
        }

        .ld-score-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .ld-score-box .ld-score {
            font-size: 52px;
            font-weight: var(--fw-bold);
            color: var(--dark);
            line-height: 1;
        }

        .ld-score-box .ld-stars {
            color: #F59E0B;
            font-size: 20px;
            letter-spacing: 3px;
            margin: 10px 0 6px;
        }

        .ld-score-box .ld-count {
            font-size: 13px;
            color: var(--gray);
        }

        .ld-dist-item {
            display: grid;
            grid-template-columns: 48px 1fr 40px;
            gap: 12px;
            align-items: center;
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 10px;
        }

        .ld-dist-bar {
            height: 10px;
            background: var(--border);
            border-radius: var(--radius-full);
            overflow: hidden;
        }

        .ld-dist-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: var(--radius-full);
        }

        .ld-ulasan-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 8px;
        }

        .ld-ulasan-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
        }

        .ld-ulasan-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .ld-ulasan-avatar {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-full);
            object-fit: cover;
            background: #f3f4f6;
        }

        .ld-ulasan-name {
            font-size: 14px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
        }

        .ld-ulasan-date {
            font-size: 12px;
            color: var(--gray);
        }

        .ld-badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(16, 185, 129, .1);
            color: #059669;
            font-size: 11px;
            font-weight: var(--fw-semibold);
            padding: 3px 10px;
            border-radius: var(--radius-full);
            margin-left: 8px;
        }

        .ld-ulasan-stars {
            color: #F59E0B;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .ld-ulasan-text {
            font-size: 14px;
            color: var(--gray);
            line-height: 1.7;
        }

        .ld-empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
            background: var(--white);
            border: 1px dashed var(--border);
            border-radius: var(--radius-lg);
            font-size: 14px;
        }

        .ld-form {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 26px;
            box-shadow: var(--shadow-sm);
        }

        .ld-form label {
            font-size: 13px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
            display: block;
            margin-bottom: 8px;
        }

        .ld-star-input {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
        }

        .ld-star-input button {
            background: none;
            border: none;
            font-size: 30px;
            color: #E5E7EB;
            cursor: pointer;
            transition: color .15s ease, transform .15s ease;
            padding: 0;
            line-height: 1;
        }

        .ld-star-input button:hover,
        .ld-star-input button.active {
            color: #F59E0B;
            transform: scale(1.1);
        }

        .ld-form textarea {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
            transition: border-color .15s ease;
        }

        .ld-form textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .ld-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            padding: 12px 24px;
            font-size: 14px;
            font-weight: var(--fw-semibold);
            cursor: pointer;
            transition: var(--transition-base);
            margin-top: 14px;
        }

        .ld-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .ld-btn-outline {
            background: var(--white);
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .ld-btn-outline:hover {
            background: rgba(255, 79, 135, .08);
        }

        .ld-note {
            font-size: 13px;
            color: var(--gray);
            background: #FFF7F9;
            border: 1px dashed var(--primary);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            line-height: 1.6;
        }

        .ld-other-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .ld-other-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition-base);
            text-decoration: none;
            display: block;
        }

        .ld-other-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .ld-other-img {
            height: 140px;
            overflow: hidden;
        }

        .ld-other-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-slow);
        }

        .ld-other-card:hover .ld-other-img img {
            transform: scale(1.08);
        }

        .ld-other-body {
            padding: 16px 18px;
        }

        .ld-other-name {
            font-size: 14px;
            font-weight: var(--fw-semibold);
            color: var(--dark);
            margin-bottom: 6px;
        }

        .ld-other-price {
            font-size: 13px;
            color: var(--primary);
            font-weight: var(--fw-semibold);
        }

        .ld-other-rating {
            font-size: 12px;
            color: var(--gray);
            margin-top: 4px;
        }

        .ld-other-rating i {
            color: #F59E0B;
            margin-right: 3px;
        }

        @media (max-width: 992px) {
            .ld-hero-inner {
                grid-template-columns: 1fr;
            }

            .ld-rating-grid {
                grid-template-columns: 1fr;
            }

            .ld-other-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .ld-hero-title {
                font-size: 26px;
            }

            .ld-other-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    @include('layouts.navbar')

    <!-- Hero Detail Layanan -->
    <section class="ld-hero">
        <div class="container">
            <div class="ld-hero-inner">
                <div>
                    <div class="ld-breadcrumb">
                        <a href="{{ route('home') }}">Beranda</a>
                        <span>›</span>
                        <a href="{{ route('home') }}#layanan">Layanan</a>
                        <span>›</span>
                        <span>{{ $layanan->nm_layanan }}</span>
                    </div>

                    <span class="ld-category">{{ $layanan->kategori->nm_layanan ?? 'Layanan' }}</span>
                    <h1 class="ld-hero-title">{{ $layanan->nm_layanan }}</h1>

                    <div class="ld-hero-meta">
                        <span><i class="fa-solid fa-clock"></i> {{ $layanan->durasi }} menit</span>
                        <span><i class="fa-solid fa-tag"></i> {{ $layanan->kategori->nm_layanan ?? 'Kategori' }}</span>
                        <span><i class="fa-solid fa-circle-check"></i> Tersedia</span>
                    </div>

                    <div class="ld-hero-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>

                    <div class="ld-summary">
                        <span class="ld-stars">{{ str_repeat('★', (int) round($ringkasan['rata'])) }}{{ str_repeat('☆', 5 - (int) round($ringkasan['rata'])) }}</span>
                        <span class="ld-score">{{ number_format($ringkasan['rata'], 1, ',', '.') }}</span>
                        <span class="ld-count">{{ $ringkasan['jumlah'] }} ulasan</span>
                    </div>
                </div>

                <div class="ld-hero-img">
                    @if ($layanan->foto)
                        <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nm_layanan }}" loading="lazy">
                    @else
                        <img src="https://images.unsplash.com/photo-1560066984-138dad74c875?w=800&q=80"
                            alt="{{ $layanan->nm_layanan }}" loading="lazy">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Rating & Ulasan -->
    <section class="ld-section" id="ulasan">
        <div class="container">
            <h2 class="ld-section-title"><i class="fa-solid fa-star"></i> Rating &amp; Ulasan Pelanggan</h2>

            <div class="ld-rating-grid">
                <div class="ld-score-box">
                    <div class="ld-score">{{ number_format($ringkasan['rata'], 1, ',', '.') }}</div>
                    <div class="ld-stars">{{ str_repeat('★', (int) round($ringkasan['rata'])) }}{{ str_repeat('☆', 5 - (int) round($ringkasan['rata'])) }}</div>
                    <div class="ld-count">Berdasarkan {{ $ringkasan['jumlah'] }} ulasan</div>

                    @if ($ringkasan['jumlah'] > 0)
                        <div style="margin-top:18px;text-align:left;">
                            @foreach ($ringkasan['distribusi'] as $bintang => $total)
                                @php
                                    $persen = $ringkasan['jumlah'] > 0 ? round($total / $ringkasan['jumlah'] * 100) : 0;
                                @endphp
                                <div class="ld-dist-item">
                                    <span>{{ $bintang }} ★</span>
                                    <div class="ld-dist-bar"><div class="ld-dist-fill" style="width:{{ $persen }}%"></div></div>
                                    <span>{{ $total }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    @if ($ringkasan['jumlah'] > 0)
                        <div class="ld-ulasan-list">
                            @forelse($ulasans as $ulasan)
                                <div class="ld-ulasan-card">
                                    <div class="ld-ulasan-head">
                                        <img class="ld-ulasan-avatar" src="{{ $ulasan->foto_pemberi }}"
                                            alt="{{ $ulasan->nama_pemberi }}" loading="lazy">
                                        <div>
                                            <div>
                                                <span class="ld-ulasan-name">{{ $ulasan->nama_pemberi }}</span>
                                                <span class="ld-badge-verified"><i class="fa-solid fa-circle-check"></i> Pelanggan Terverifikasi</span>
                                            </div>
                                            <div class="ld-ulasan-date">
                                                {{ \Carbon\Carbon::parse($ulasan->created_at)->isoFormat('D MMM YYYY') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ld-ulasan-stars">{{ str_repeat('★', $ulasan->bintang) }}{{ str_repeat('☆', 5 - $ulasan->bintang) }}</div>
                                    @if ($ulasan->komentar)
                                        <p class="ld-ulasan-text">"{{ $ulasan->komentar }}"</p>
                                    @endif
                                </div>
                            @empty
                                <div class="ld-empty">Belum ada ulasan untuk layanan ini.</div>
                            @endforelse
                        </div>
                    @else
                        <div class="ld-empty">
                            <p style="margin-bottom:8px;"><i class="fa-solid fa-star" style="font-size:28px;color:#F59E0B;"></i></p>
                            Belum ada ulasan untuk layanan ini. Jadilah yang pertama memberi rating!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Form Rating -->
    <section class="ld-section" id="beri-rating" style="padding-top:0;">
        <div class="container">
            <h2 class="ld-section-title"><i class="fa-solid fa-pen"></i> Beri Rating Anda</h2>

            @guest
                <div class="ld-note">
                    <i class="fa-solid fa-circle-info"></i> Anda harus
                    <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600;">masuk</a> sebagai
                    pelanggan dan telah menyelesaikan treatment ini untuk memberi rating.
                </div>
            @elseif (auth()->user()->role !== 'pelanggan')
                <div class="ld-note">
                    <i class="fa-solid fa-circle-info"></i> Hanya akun pelanggan yang dapat memberi rating.
                </div>
            @elseif (!$bisaRating)
                <div class="ld-note">
                    <i class="fa-solid fa-circle-info"></i> Anda baru dapat memberi rating setelah menyelesaikan
                    treatment <strong>{{ $layanan->nm_layanan }}</strong>.
                </div>
            @elseif ($ratingSaya)
                <div class="ld-form">
                    <label>Rating Anda saat ini</label>
                    <div class="ld-star-input" data-readonly="1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="{{ $i <= $ratingSaya->bintang ? 'active' : '' }}" disabled>★</button>
                        @endfor
                    </div>
                    <p class="ld-ulasan-text" style="margin-bottom:12px;">
                        {{ $ratingSaya->komentar ? '"' . $ratingSaya->komentar . '"' : 'Tanpa komentar.' }}
                    </p>
                    <p class="ld-note" style="margin-bottom:14px;">
                        <i class="fa-solid fa-circle-info"></i> Anda sudah memberi rating untuk layanan ini.
                        Perbarui rating Anda melalui formulir di bawah, atau
                        <a href="#" onclick="event.preventDefault(); if(confirm('Hapus rating Anda?')) document.getElementById('hapus-rating-form').submit();"
                            style="color:#DC2626;font-weight:600;text-decoration:underline;">hapus rating</a>.
                    </p>
                    <form id="hapus-rating-form" action="{{ route('rating.destroy', $ratingSaya->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @else
                <div class="ld-form">
                    <form action="{{ route('rating.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipe" value="layanan">
                        <input type="hidden" name="id_target" value="{{ $layanan->id_layanan }}">

                        <label>Pilih bintang Anda</label>
                        <div class="ld-star-input" id="ldStarInput">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-nilai="{{ $i }}" onclick="pilihBintang(this)">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="bintang" id="ldBintangValue" value="5">

                        <label>Komentar (opsional)</label>
                        <textarea name="komentar" maxlength="500"
                            placeholder="Ceritakan pengalaman Anda dengan treatment ini..."></textarea>

                        <button type="submit" class="ld-btn"><i class="fa-solid fa-paper-plane"></i> Kirim Rating</button>
                    </form>
                </div>
            @endguest
        </div>
    </section>

    <!-- Layanan Lainnya -->
    @if ($layananLain->isNotEmpty())
        <section class="ld-section" style="padding-top:0;">
            <div class="container">
                <h2 class="ld-section-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Layanan Lainnya</h2>
                <div class="ld-other-grid">
                    @foreach ($layananLain as $lain)
                        <a href="{{ route('layanan.detail', $lain->id_layanan) }}" class="ld-other-card">
                            <div class="ld-other-img">
                                @if ($lain->foto)
                                    <img src="{{ asset('storage/' . $lain->foto) }}" alt="{{ $lain->nm_layanan }}" loading="lazy">
                                @else
                                    <img src="https://images.unsplash.com/photo-1560066984-138dad74c875?w=400&q=80"
                                        alt="{{ $lain->nm_layanan }}" loading="lazy">
                                @endif
                            </div>
                            <div class="ld-other-body">
                                <div class="ld-other-name">{{ $lain->nm_layanan }}</div>
                                <div class="ld-other-price">Rp {{ number_format($lain->harga, 0, ',', '.') }}</div>
                                @php $ringkasanLain = \App\Models\Rating::ringkasan('layanan', $lain->id_layanan); @endphp
                                <div class="ld-other-rating">
                                    <i class="fa-solid fa-star"></i> {{ number_format($ringkasanLain['rata'], 1, ',', '.') }}
                                    ({{ $ringkasanLain['jumlah'] }})
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @push('scripts')
    <script>
        function pilihBintang(btn) {
            var nilai = parseInt(btn.dataset.nilai);
            document.getElementById('ldBintangValue').value = nilai;
            var buttons = document.querySelectorAll('#ldStarInput button');
            buttons.forEach(function(b) {
                b.classList.toggle('active', parseInt(b.dataset.nilai) <= nilai);
            });
        }
    </script>
    @endpush
@endsection