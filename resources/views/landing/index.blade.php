@extends('layouts.app')

@section('title', 'BeautyCare - Kelola Bisnis Kecantikan dengan Lebih Mudah')

@section('meta_description',
    'BeautyCare adalah aplikasi manajemen bisnis kecantikan untuk Salon, Spa, Nail Art,
    Barbershop, Eyelash, dan Skincare. Kelola bisnis Anda dengan lebih mudah.')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    @endpush

@section('content')
    @include('layouts.navbar')

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-content">
                <span class="badge badge-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                    Platform Manajemen #1 di Indonesia
                </span>
                <h1>Kelola Bisnis Kecantikan Anda dengan <span>Lebih Mudah</span></h1>
                <p>BeautyCare membantu Anda mengelola salon, spa, nail art, barbershop, dan skincare dalam satu platform
                    terintegrasi. Hemat waktu, tingkatkan pendapatan.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Mulai Sekarang</a>
                </div>
            </div>

            <div class="hero-image">
                <div class="mockup">
                    <img src="https://i.pinimg.com/736x/f1/0f/85/f10f857f68a5771a4a9b98b940cd0795.jpg"
                        alt="BeautyCare Dashboard Preview" loading="lazy">
                </div>
                <div class="floating-card">
                    <div class="fc-icon success">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div class="fc-text">
                        <h4>5000+</h4>
                        <p>Customer Terdaftar</p>
                    </div>
                </div>
                <div class="floating-card">
                    <div class="fc-icon primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                    </div>
                    <div class="fc-text">
                        <h4>250+</h4>
                        <p>Salon Bermitra</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="tentang">
        <div class="container">
            <div class="about-grid animate-on-scroll">
                <div class="about-image">
                    <img src="https://i.pinimg.com/736x/23/a1/f0/23a1f0b480558311265d20da4249a621.jpg"
                        alt="Tentang BeautyCare" loading="lazy">
                    <div class="experience-badge">
                        <h3>5+</h3>
                        <p>Tahun Pengalaman</p>
                    </div>
                </div>
                <div class="about-content">
                    <h2>Tentang <span>BeautyCare</span></h2>
                    <p>BeautyCare adalah platform manajemen bisnis kecantikan yang dirancang khusus untuk membantu para
                        pelaku bisnis di industri kecantikan mengelola operasional sehari-hari dengan lebih efisien dan
                        profesional.</p>
                    <ul class="about-list">
                        <li>
                            <span class="check-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            Platform all-in-one untuk bisnis kecantikan
                        </li>
                        <li>
                            <span class="check-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            Didukung oleh tim developer profesional
                        </li>
                        <li>
                            <span class="check-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            Update fitur rutin setiap bulan
                        </li>
                        <li>
                            <span class="check-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            Support 24 jam untuk seluruh pelanggan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features" id="fitur">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Fitur <span>Unggulan</span></h2>
                <p>BeautyCare hadir dengan berbagai fitur lengkap untuk mengelola seluruh aspek bisnis kecantikan Anda.</p>
            </div>
            <div class="features-grid stagger-container">
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                        </svg>
                    </div>
                    <h3>Dashboard</h3>
                    <p>Pantau seluruh aktivitas bisnis dalam satu tampilan dashboard yang interaktif.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>
                    <h3>Booking</h3>
                    <p>Sistem booking online yang memudahkan pelanggan membuat janji temu.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <polyline points="17 11 19 13 23 9" />
                        </svg>
                    </div>
                    <h3>Customer</h3>
                    <p>Kelola data pelanggan dengan lengkap termasuk riwayat kunjungan.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                    </div>
                    <h3>POS</h3>
                    <p>Sistem kasir cepat dengan dukungan berbagai metode pembayaran.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                    </div>
                    <h3>Inventory</h3>
                    <p>Manajemen stok produk dengan notifikasi otomatis saat stok menipis.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <h3>Membership</h3>
                    <p>Program loyalitas pelanggan dengan sistem poin dan reward menarik.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                    </div>
                    <h3>Promo</h3>
                    <p>Buat dan kelola promo, diskon, dan voucher untuk menarik pelanggan.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10" />
                            <line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" />
                        </svg>
                    </div>
                    <h3>Laporan</h3>
                    <p>Laporan keuangan dan operasional lengkap dengan grafik interaktif.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </div>
                    <h3>Analytics</h3>
                    <p>Analisis data bisnis secara real-time untuk pengambilan keputusan tepat.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                            <line x1="8" y1="21" x2="16" y2="21" />
                            <line x1="12" y1="17" x2="12" y2="21" />
                        </svg>
                    </div>
                    <h3>Employee</h3>
                    <p>Kelola jadwal, komisi, dan performa karyawan dengan mudah.</p>
                </div>
                <div class="feature-card stagger-item">
                    <div class="fc-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                    </div>
                    <h3>Notification</h3>
                    <p>Notifikasi otomatis untuk jadwal booking, stok, dan promo terbaru.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="section keunggulan" id="keunggulan">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Mengapa <span>BeautyCare?</span></h2>
                <p>Kelebihan yang membuat BeautyCare menjadi pilihan utama para pebisnis kecantikan.</p>
            </div>
            <div class="keunggulan-grid animate-on-scroll">
                <div class="keunggulan-image">
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&q=80"
                        alt="BeautyCare Keunggulan" loading="lazy">
                </div>
                <div class="keunggulan-list">
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <div>
                            <h4>Booking Online</h4>
                            <p>Pelanggan bisa booking 24/7</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </div>
                        <div>
                            <h4>Sistem POS</h4>
                            <p>Kasir cepat & terintegrasi</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            </svg>
                        </div>
                        <div>
                            <h4>Manajemen Inventory</h4>
                            <p>Stok selalu terkontrol</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                            </svg>
                        </div>
                        <div>
                            <h4>Customer History</h4>
                            <p>Riwayat pelanggan lengkap</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                        <div>
                            <h4>Treatment History</h4>
                            <p>Riwayat perawatan pasien</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div>
                            <h4>Sistem Membership</h4>
                            <p>Program loyalitas pelanggan</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </div>
                        <div>
                            <h4>Promo & Diskon</h4>
                            <p>Buat promo menarik</p>
                        </div>
                    </div>
                    <div class="keunggulan-item">
                        <div class="ku-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                        </div>
                        <div>
                            <h4>Analytics</h4>
                            <p>Data real-time akurat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja Section -->
    <section class="section how-it-works" id="cara-kerja">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Cara <span>Kerja</span></h2>
                <p>Mulai gunakan BeautyCare dalam 4 langkah mudah.</p>
            </div>
            <div class="how-steps animate-on-scroll">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Daftar Akun</h3>
                    <p>Buat akun BeautyCare Anda dengan mengisi data diri dan bisnis.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Atur Bisnis</h3>
                    <p>Konfigurasi layanan, karyawan, harga, dan jam operasional.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Mulai Operasional</h3>
                    <p>Terima booking, layani pelanggan, dan kelola transaksi dengan mudah.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Analisis & Kembangkan</h3>
                    <p>Pantau laporan dan analytics untuk mengembangkan bisnis Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    <section class="section layanan" id="layanan">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Layanan <span>Kami</span></h2>
                <p>BeautyCare melayani berbagai jenis bisnis di industri kecantikan.</p>
            </div>
            <div class="layanan-grid animate-on-scroll">
                @forelse($kategoriLayanan as $kategori)
                <div class="layanan-card">
                    @php
                        $layananWithFoto = $kategori->layanan->where('foto', '!=', '')->whereNotNull('foto')->values();
                        $defaultImg = 'https://images.unsplash.com/photo-1560066984-138dad74c875?w=400&q=80';
                    @endphp
                    
                    @if($layananWithFoto->count() > 0)
                        <div class="layanan-image-slider" data-interval="3000">
                            @foreach($layananWithFoto as $index => $layanan)
                            <img src="{{ asset('storage/' . $layanan->foto) }}" 
                                alt="{{ $layanan->nm_layanan }}"
                                class="slider-img {{ $index === 0 ? 'active' : '' }}"
                                loading="lazy">
                            @endforeach
                            @if($layananWithFoto->count() > 1)
                            <div class="slider-dots">
                                @foreach($layananWithFoto as $index => $layanan)
                                <span class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @else
                        <img src="{{ $defaultImg }}" alt="{{ $kategori->nm_layanan }}" loading="lazy">
                    @endif
                    
                    <div class="overlay">
                        <h3>{{ $kategori->nm_layanan }}</h3>
                        <p>{{ $kategori->deskripsi ?? 'Manajemen ' . $kategori->nm_layanan . ' lengkap dan terintegrasi' }}</p>
                        @if ($kategori->layanan->isNotEmpty())
                            <div class="overlay-links">
                                @foreach ($kategori->layanan->take(3) as $subLayanan)
                                    <a href="{{ route('layanan.detail', $subLayanan->id_layanan) }}" class="overlay-link">
                                        {{ $subLayanan->nm_layanan }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Belum ada kategori layanan yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section class="section testimoni" id="testimoni">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Apa Kata <span>Mereka</span></h2>
                <p>Dengarkan pengalaman nyata para pelanggan yang telah menggunakan layanan BeautyCare.</p>
            </div>

            @if ($ringkasanRating['jumlah'] > 0)
                <div class="testimoni-score animate-on-scroll">
                    <span class="ts-stars">{{ str_repeat('★', (int) round($ringkasanRating['rata'])) }}{{ str_repeat('☆', 5 - (int) round($ringkasanRating['rata'])) }}</span>
                    <span class="ts-num">{{ number_format($ringkasanRating['rata'], 1, ',', '.') }}/5</span>
                    <span class="ts-total">Berdasarkan {{ $ringkasanRating['jumlah'] }} ulasan</span>
                </div>

                <div class="testimoni-slider animate-on-scroll">
                    <div class="testimoni-track">
                        @foreach ($ulasanTerbaru as $ulasan)
                        <div class="testimoni-card">
                            <div class="stars">{{ str_repeat('★', $ulasan->bintang) }}{{ str_repeat('☆', 5 - $ulasan->bintang) }}</div>
                            @if ($ulasan->komentar)
                                <p class="comment">"{{ $ulasan->komentar }}"</p>
                            @else
                                <p class="comment" style="font-style:italic;color:#9CA3AF;">Memberi rating {{ $ulasan->bintang }} bintang tanpa komentar.</p>
                            @endif
                            <div class="author">
                                <img src="{{ $ulasan->foto_pemberi }}" alt="{{ $ulasan->nama_pemberi }}" loading="lazy">
                                <div>
                                    <h4>{{ $ulasan->nama_pemberi }} <span class="badge-verified"><i class="fa-solid fa-circle-check"></i> Terverifikasi</span></h4>
                                    <p>{{ $ulasan->tipe_label }} — {{ $ulasan->nama_objek }} · {{ \Carbon\Carbon::parse($ulasan->created_at)->isoFormat('D MMM YYYY') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="testimoni-more animate-on-scroll">
                    <a href="{{ route('rating.index') }}" class="btn btn-primary">Lihat Semua Ulasan</a>
                </div>
            @else
                <div class="testimoni-empty animate-on-scroll">
                    <p><i class="fa-solid fa-star" style="font-size:30px;color:#F59E0B;"></i></p>
                    <p>Belum ada ulasan. Jadilah pelanggan pertama yang memberikan rating!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Membership Section -->
    <section class="section pricing" id="membership">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Membership <span>BeautyCare</span></h2>
                <p>Pilih level membership sesuai kebutuhan Anda dan nikmati berbagai keuntungan eksklusif.</p>
            </div>
            <div class="pricing-grid animate-on-scroll">
                @php
                    $ctaUrl = route('register');
                    $ctaLabel = 'Daftar & Bergabung';
                    if (auth()->check()) {
                        $role = auth()->user()->role;
                        if ($role === 'pelanggan') {
                            $ctaUrl = route('pelanggan.membership');
                            $ctaLabel = 'Lihat';
                        } elseif ($role === 'admin') {
                            $ctaUrl = route('admin.dashboard');
                            $ctaLabel = 'Dashboard';
                        } elseif ($role === 'kasir') {
                            $ctaUrl = route('kasir.dashboard');
                            $ctaLabel = 'Dashboard';
                        } else {
                            $ctaUrl = route('beautycian.dashboard');
                            $ctaLabel = 'Dashboard';
                        }
                    }
                @endphp
                @forelse($tingkatMembership as $member)
                @php
                    $benefitItems = [
                        ['on' => true, 'text' => 'Diskon ' . (float) $member->diskon . '% semua layanan & produk'],
                        ['on' => (int) $member->jml_konsultasi > 0, 'text' => 'Gratis konsultasi ' . (int) $member->jml_konsultasi . 'x/bulan'],
                        ['on' => (bool) $member->prioritas_booking, 'text' => 'Prioritas booking treatment'],
                        ['on' => (bool) $member->undangan_event, 'text' => 'Undangan event eksklusif'],
                        ['on' => (int) $member->masa_berlaku > 0, 'text' => 'Masa aktif ' . (int) $member->masa_berlaku . ' hari'],
                    ];
                @endphp
                <div class="pricing-card">
                    <div class="plan-name">{{ $member->tingkat }}</div>
                    <div class="plan-desc">{{ $member->deskripsi ?: ($member->nm_member ?: 'Membership BeautyCare') }}</div>
                    <div class="price">{{ (float) $member->diskon }}%<span> diskon</span></div>
                    <div class="price-period">
                        @if((float) $member->harga > 0)
                        Biaya bergabung Rp {{ number_format((float) $member->harga, 0, ',', '.') }}
                        @else
                        Untuk semua layanan & produk
                        @endif
                    </div>
                    <ul class="plan-features">
                        @foreach($benefitItems as $benefit)
                        <li>
                            @if($benefit['on'])
                            <span class="check">✓</span>
                            @else
                            <span class="x">✗</span>
                            @endif
                            {{ $benefit['text'] }}
                        </li>
                        @endforeach
                    </ul>
                    <div class="ms-syarat">
                        <div>
                            <span>Min. Transaksi Produk</span>
                            <strong>{{ (int) $member->min_transaksi }}x</strong>
                        </div>
                        <div>
                            <span>Min. Total Belanja</span>
                            <strong>Rp {{ number_format((float) $member->min_pembelian, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    @if((float) $member->harga > 0)
                    <div class="ms-harga">Biaya bergabung: <strong>Rp {{ number_format((float) $member->harga, 0, ',', '.') }}</strong></div>
                    @endif
                    <a href="{{ $ctaUrl }}" class="btn btn-outline w-full">{{ $ctaLabel }}</a>
                </div>
                @empty
                <div class="pricing-card" style="grid-column:1/-1;">
                    <div class="plan-name">Membership</div>
                    <div class="plan-desc">Informasi level membership akan segera hadir.</div>
                    <p style="text-align:center;color:var(--gray);margin-bottom:24px;">Daftar sekarang untuk menjadi bagian dari BeautyCare dan mulai menikmati berbagai keuntungan.</p>
                    <a href="{{ $ctaUrl }}" class="btn btn-primary w-full">{{ $ctaLabel }}</a>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq" id="faq">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Frequently Asked <span>Questions</span></h2>
                <p>Pertanyaan yang sering diajukan tentang BeautyCare.</p>
            </div>
            <div class="faq-list animate-on-scroll">
                <div class="faq-item active">
                    <button class="faq-question">
                        Apa itu BeautyCare?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            BeautyCare adalah platform manajemen bisnis kecantikan all-in-one yang membantu Anda mengelola
                            salon, spa, nail art, barbershop, skincare, dan eyelash dalam satu sistem terintegrasi.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Bagaimana cara mendaftar di BeautyCare?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Pendaftaran mudah sekali. Buat akun Anda sebagai pelanggan melalui tombol "Daftar", lalu
                            lengkapi data diri. Setelah akun Anda aktif, Anda sudah bisa booking treatment, belanja
                            produk, dan mengikuti promo. Akun untuk kasir, beautycian, dan admin dibuat khusus oleh
                            Admin BeautyCare.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Apakah bisa digunakan di HP?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            BeautyCare dapat diakses melalui browser di perangkat apa pun (desktop, tablet, maupun
                            smartphone). Tampilan kami sudah responsive di semua ukuran layar.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Bagaimana dengan keamanan data?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Keamanan adalah prioritas utama kami. Semua data dienkripsi menggunakan SSL/TLS, disimpan di
                            server aman, dan kami melakukan backup data secara rutin.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Bagaimana cara mendapatkan membership?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Membership dapat diperoleh dengan memenuhi syarat minimal transaksi produk dan total
                            belanja, atau langsung bergabung melalui halaman Membership setelah login. Setiap level
                            membership memberikan diskon dan keuntungan yang semakin besar.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact" id="kontak">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Hubungi <span>Kami</span></h2>
                <p>Punya pertanyaan? Jangan ragu untuk menghubungi tim BeautyCare.</p>
            </div>
            <div class="contact-grid animate-on-scroll">
                <div class="contact-map">
                    <div class="map-placeholder">
                        <div class="map-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <h3 style="font-size:18px;margin-bottom:8px;">{{ optional($pengaturan)->nama_salon ?: 'Kantor Pusat BeautyCare' }}</h3>
                        <p style="font-size:14px;color:var(--gray);text-align:center;max-width:300px;">
                            {!! nl2br(e(optional($pengaturan)->alamat ?: 'Jl. Sudirman No. 123, Jakarta Pusat<br>Indonesia 10220')) !!}
                        </p>
                        @if(!empty(optional($pengaturan)->telepon) || !empty(optional($pengaturan)->email))
                        <p style="font-size:14px;color:var(--gray);text-align:center;max-width:300px;margin-top:10px;">
                            @if(!empty(optional($pengaturan)->telepon))
                            <a href="tel:{{ optional($pengaturan)->telepon }}" style="color:var(--primary);">{{ optional($pengaturan)->telepon }}</a>
                            @endif
                            @if(!empty(optional($pengaturan)->telepon) && !empty(optional($pengaturan)->email))<br>@endif
                            @if(!empty(optional($pengaturan)->email))
                            <a href="mailto:{{ optional($pengaturan)->email }}" style="color:var(--primary);">{{ optional($pengaturan)->email }}</a>
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Kirim Pesan</h3>

                    @if(session('success'))
                    <div class="alert" style="background:#E8F8EE;color:#166534;border:1px solid #A7F3D0;padding:12px 16px;border-radius:var(--radius-md);font-size:14px;margin-bottom:20px;">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                    <div class="alert" style="background:#FDE8E8;color:#991B1B;border:1px solid #FECACA;padding:12px 16px;border-radius:var(--radius-md);font-size:14px;margin-bottom:20px;">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('landing.contact') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="contact-name">Nama</label>
                                <input type="text" id="contact-name" name="nama" class="form-input"
                                    placeholder="Nama lengkap" value="{{ old('nama') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-email">Email</label>
                                <input type="email" id="contact-email" name="email" class="form-input"
                                    placeholder="email@example.com" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-phone">Nomor HP</label>
                            <input type="tel" id="contact-phone" name="no_hp" class="form-input"
                                placeholder="+62 812 3456 7890" value="{{ old('no_hp') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-message">Pesan</label>
                            <textarea id="contact-message" name="pesan" class="form-input"
                                placeholder="Tulis pesan Anda..." required>{{ old('pesan') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.layanan-image-slider');
        
        sliders.forEach(slider => {
            const images = slider.querySelectorAll('.slider-img');
            const dots = slider.querySelectorAll('.slider-dots .dot');
            const interval = parseInt(slider.dataset.interval) || 3000;
            
            if (images.length <= 1) return;
            
            let currentIndex = 0;
            let autoSlideInterval;
            
            function showImage(index) {
                images.forEach((img, i) => {
                    img.classList.toggle('active', i === index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
                currentIndex = index;
            }
            
            function nextImage() {
                const nextIndex = (currentIndex + 1) % images.length;
                showImage(nextIndex);
            }
            
            function startAutoSlide() {
                autoSlideInterval = setInterval(nextImage, interval);
            }
            
            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }
            
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    stopAutoSlide();
                    showImage(index);
                    startAutoSlide();
                });
            });
            
            slider.addEventListener('mouseenter', stopAutoSlide);
            slider.addEventListener('mouseleave', startAutoSlide);
            
            startAutoSlide();
        });
    });
    </script>
    @endpush
@endsection
