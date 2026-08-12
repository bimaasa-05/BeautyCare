@extends('layouts.app')

@section('title', 'Pusat Bantuan - BeautyCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <style>
        .help-page {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            padding: 0 0 60px;
            font-family: 'Poppins', sans-serif;
        }

        .help-hero {
            padding: 72px 0 40px;
            text-align: center;
        }

        .help-hero .help-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 16px;
        }

        .help-hero h1 {
            font-size: 34px;
            font-weight: 700;
            color: #1F2937;
            margin: 0 0 12px;
        }

        .help-hero p {
            font-size: 15px;
            color: #6B7280;
            margin: 0 auto 28px;
            max-width: 480px;
        }

        .help-search {
            position: relative;
            max-width: 560px;
            margin: 0 auto;
        }

        .help-search svg {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            pointer-events: none;
        }

        .help-search input {
            width: 100%;
            padding: 16px 20px 16px 48px;
            border: 2px solid transparent;
            border-radius: 16px;
            background: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #1F2937;
            box-shadow: 0 8px 32px rgba(255, 79, 135, 0.15);
            outline: none;
            transition: border-color 0.3s;
        }

        .help-search input:focus {
            border-color: #FF4F87;
        }

        .help-container {
            max-width: 860px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .help-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin: 28px auto 36px;
            max-width: 700px;
        }

        .help-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 999px;
            background: #fff;
            border: 2px solid #FFE5EF;
            font-size: 13px;
            font-weight: 500;
            color: #6B7280;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'Poppins', sans-serif;
        }

        .help-chip:hover {
            border-color: #FF4F87;
            color: #FF4F87;
        }

        .help-chip.active {
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 16px rgba(255, 79, 135, 0.3);
        }

        .help-faq-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px 40px;
            box-shadow: 0 8px 32px rgba(255, 79, 135, 0.1);
        }

        .help-faq-card .faq-item {
            border: 1px solid #FEE2EC;
            border-radius: 14px;
            margin-bottom: 12px;
            background: #FFFCFD;
            overflow: hidden;
        }

        .help-faq-card .faq-item.active {
            border-color: #FF4F87;
        }

        .help-faq-card .faq-answer-inner {
            color: #4B5563;
            font-size: 13.5px;
            line-height: 1.8;
        }

        .help-faq-card .faq-question {
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            padding: 16px 20px;
        }

        .help-empty {
            text-align: center;
            padding: 40px 20px;
            color: #6B7280;
            font-size: 14px;
        }

        .help-contact-cta {
            text-align: center;
            margin: 40px auto 0;
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(255, 79, 135, 0.1);
        }

        .help-contact-cta h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            margin: 0 0 8px;
        }

        .help-contact-cta p {
            font-size: 13.5px;
            color: #6B7280;
            margin: 0 0 20px;
        }

        @media screen and (max-width: 768px) {
            .help-hero {
                padding: 48px 20px 32px;
            }

            .help-hero h1 {
                font-size: 26px;
            }

            .help-faq-card {
                padding: 20px 16px;
            }
        }
    </style>
@endpush

@section('content')
    @include('layouts.navbar')

    @php
        $kategori = $kategori ?? [];
        $faq = $faq ?? [];
    @endphp

    <div class="help-page">
        <div class="help-hero">
            <span class="help-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                Pusat Bantuan
            </span>
            <h1>Apa yang bisa kami bantu?</h1>
            <p>Temukan jawaban atas pertanyaan seputar penggunaan aplikasi BeautyCare.</p>

            <div class="help-search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" id="helpSearch" placeholder="Cari bantuan, misal: cara booking treatment..."
                    autocomplete="off">
            </div>
        </div>

        <div class="help-container">
            @if (count($kategori) > 0)
                <div class="help-categories" id="helpCategories">
                    <button type="button" class="help-chip active" data-kategori="*">Semua</button>
                    @foreach ($kategori as $cat)
                        <button type="button" class="help-chip" data-kategori="{{ $cat['nama'] }}">{{ $cat['nama'] }}</button>
                    @endforeach
                </div>
            @endif

            <div class="help-faq-card">
                @forelse ($faq as $item)
                    <div class="faq-item {{ $loop->first ? 'active' : '' }}" data-kategori="{{ $item['kategori'] ?? 'Umum' }}">
                        <button class="faq-question">
                            {{ $item['pertanyaan'] ?? 'Pertanyaan' }}
                            <span class="faq-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </span>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-inner">
                                {{ $item['jawaban'] ?? '' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="help-empty">
                        <p>Belum ada pertanyaan yang tersedia di Pusat Bantuan.</p>
                    </div>
                @endforelse

                <div class="help-empty" id="helpNoResult" style="display:none;">
                    <p>Tidak ditemukan hasil untuk pencarian Anda. Coba kata kunci lain.</p>
                </div>
            </div>

            <div class="help-contact-cta">
                <h3>Masih butuh bantuan?</h3>
                <p>Tim kami siap membantu Anda. Hubungi kami melalui halaman kontak.</p>
                <a href="{{ url('/#kontak') }}" class="btn btn-primary">Hubungi Kami</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('helpSearch');
            const chips = document.querySelectorAll('#helpCategories .help-chip');
            const items = document.querySelectorAll('.help-faq-card .faq-item');
            const noResult = document.getElementById('helpNoResult');
            let activeKategori = '*';

            const applyFilter = () => {
                const query = (searchInput.value || '').trim().toLowerCase();
                let visible = 0;

                items.forEach(item => {
                    const kat = item.dataset.kategori || 'Umum';
                    const text = item.querySelector('.faq-question').textContent.toLowerCase();
                    const matchKat = activeKategori === '*' || kat === activeKategori;
                    const matchSearch = !query || text.includes(query);
                    const show = matchKat && matchSearch;

                    item.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                noResult.style.display = visible === 0 ? '' : 'none';
            };

            chips.forEach(chip => {
                chip.addEventListener('click', () => {
                    chips.forEach(c => c.classList.remove('active'));
                    chip.classList.add('active');
                    activeKategori = chip.dataset.kategori;
                    applyFilter();
                });
            });

            searchInput.addEventListener('input', applyFilter);
        });
    </script>
@endpush