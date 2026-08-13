@extends('layouts.app')

@section('title', 'Pusat Bantuan - BeautyCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <style>
        .help-page {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            padding: 80px 20px 60px;
            font-family: 'Poppins', sans-serif;
        }

        .help-hero {
            padding: 40px 0 32px;
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
            margin: 24px auto 32px;
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
                <p>Tim kami siap membantu Anda. Hubungi kami untuk bantuan lebih lanjut.</p>
                @php
                    $noWa = preg_replace('/\D+/', '', $pengaturan->telepon ?? '');
                    if (strlen($noWa) >= 10) {
                        if (str_starts_with($noWa, '0')) {
                            $noWa = '62' . substr($noWa, 1);
                        }
                        $ctaUrl = 'https://wa.me/' . $noWa . '?text=' . rawurlencode('Halo BeautyCare, saya ingin bertanya seputar layanan Anda.');
                        $ctaLabel = 'Chat WhatsApp';
                    } else {
                        $ctaUrl = url('/#kontak');
                        $ctaLabel = 'Hubungi Kami';
                    }
                @endphp
                <a href="{{ $ctaUrl }}" target="_blank" rel="noopener" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    {{ $ctaLabel }}
                </a>
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