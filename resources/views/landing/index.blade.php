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
                    <img src="{{ asset('https://i.pinimg.com/736x/f1/0f/85/f10f857f68a5771a4a9b98b940cd0795.jpg') }}"
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
                <div class="layanan-card">
                    <img src="https://i.pinimg.com/736x/d6/2f/0a/d62f0a5b0d1be1e563e6a13fc41510f2.jpg" alt="Salon"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Salon</h3>
                        <p>Manajemen salon rambut dan perawatan</p>
                    </div>
                </div>
                <div class="layanan-card">
                    <img src="https://i.pinimg.com/736x/b2/1f/3f/b21f3f8ea63da900459d87fe1774464d.jpg" alt="Spa"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Spa & Wellness</h3>
                        <p>Kelola jadwal terapi dan perawatan spa</p>
                    </div>
                </div>
                <div class="layanan-card">
                    <img src="https://i.pinimg.com/736x/a9/bc/b0/a9bcb04808b7e2a674a0e9ac0a30ba17.jpg" alt="Nail Art"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Nail Art</h3>
                        <p>Manajemen jadwal dan layanan nail art</p>
                    </div>
                </div>
                <div class="layanan-card">
                    <img src="https://i.pinimg.com/736x/68/3d/f9/683df902ca9975a01d1b2b1d8b3d3a29.jpg" alt="Barbershop"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Barbershop</h3>
                        <p>Sistem booking untuk pria modern</p>
                    </div>
                </div>
                <div class="layanan-card">
                    <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=400&q=80" alt="Skincare"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Skincare Clinic</h3>
                        <p>Manajemen klinik perawatan kulit</p>
                    </div>
                </div>
                <div class="layanan-card">
                    <img src="https://i.pinimg.com/1200x/e2/0d/f8/e20df8c96990f03442d60af45a2ffc9a.jpg" alt="Eyelash"
                        loading="lazy">
                    <div class="overlay">
                        <h3>Eyelash & Brow</h3>
                        <p>Kelola layanan eyelash dan alis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section class="statistik">
        <div class="container">
            <div class="stats-grid animate-on-scroll">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <polyline points="17 11 19 13 23 9" />
                        </svg>
                    </div>
                    <h3>5000+</h3>
                    <p>Customer</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </div>
                    <h3>250+</h3>
                    <p>Salon</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h3>98%</h3>
                    <p>Customer Satisfaction</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <h3>24</h3>
                    <p>Jam Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section class="section testimoni" id="testimoni">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Apa Kata <span>Mereka</span></h2>
                <p>Dengarkan pengalaman para pelaku bisnis kecantikan yang telah menggunakan BeautyCare.</p>
            </div>
            <div class="testimoni-slider animate-on-scroll">
                <div class="testimoni-track">
                    <div class="testimoni-card">
                        <div class="stars">★★★★★</div>
                        <p class="comment">"BeautyCare benar-benar mengubah cara saya mengelola salon. Booking online, POS,
                            dan laporan keuangan jadi sangat mudah. Recommended!"</p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=96&q=80"
                                alt="Sarah" loading="lazy">
                            <div>
                                <h4>Sarah Wijaya</h4>
                                <p>Pemilik Sarah Beauty Salon</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimoni-card">
                        <div class="stars">★★★★★</div>
                        <p class="comment">"Fitur membership dan promo sangat membantu meningkatkan loyalitas pelanggan.
                            Pendapatan naik 40% sejak pakai BeautyCare!"</p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=96&q=80"
                                alt="Rudi" loading="lazy">
                            <div>
                                <h4>Rudi Hartono</h4>
                                <p>Owner Rudi Barbershop</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimoni-card">
                        <div class="stars">★★★★★</div>
                        <p class="comment">"Dashboard analytics-nya sangat lengkap. Saya bisa memantau semua cabang dalam
                            satu layar. Luar biasa!"</p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=96&q=80"
                                alt="Dian" loading="lazy">
                            <div>
                                <h4>Dian Permata</h4>
                                <p>CEO Dian Beauty Group</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimoni-card">
                        <div class="stars">★★★★★</div>
                        <p class="comment">"Support tim BeautyCare sangat responsif. Setiap ada kendala langsung dibantu.
                            Pelayanan prima!"</p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=96&q=80"
                                alt="Andi" loading="lazy">
                            <div>
                                <h4>Andi Pratama</h4>
                                <p>Manager Andi Nail Art</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimoni-card">
                        <div class="stars">★★★★★</div>
                        <p class="comment">"Aplikasi sangat intuitif dan mudah digunakan. Tim kami tidak butuh waktu lama
                            untuk beradaptasi. Recommended banget!"</p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=96&q=80"
                                alt="Maya" loading="lazy">
                            <div>
                                <h4>Maya Anggraini</h4>
                                <p>Owner Glowing Skincare Clinic</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="section pricing" id="pricing">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Harga <span>Terjangkau</span></h2>
                <p>Pilih paket yang sesuai dengan kebutuhan bisnis kecantikan Anda.</p>
            </div>
            <div class="pricing-grid animate-on-scroll">
                <div class="pricing-card">
                    <div class="plan-name">Basic</div>
                    <div class="plan-desc">Cocok untuk pemula</div>
                    <div class="price">Rp. 149.000<span>/bln</span></div>
                    <div class="price-period">Ditagih bulanan</div>
                    <ul class="plan-features">
                        <li><span class="check">✓</span> Dashboard sederhana</li>
                        <li><span class="check">✓</span> Manajemen customer</li>
                        <li><span class="check">✓</span> Booking manual</li>
                        <li><span class="check">✓</span> POS dasar</li>
                        <li><span class="check">✓</span> 1 pengguna</li>
                        <li><span class="x">✗</span> Laporan keuangan</li>
                        <li><span class="x">✗</span> Membership</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline w-full">Pilih Paket</a>
                </div>

                <div class="pricing-card featured">
                    <span class="popular-badge">Paling Populer</span>
                    <div class="plan-name">Professional</div>
                    <div class="plan-desc">Untuk bisnis berkembang</div>
                    <div class="price">Rp. 349.000<span>/bln</span></div>
                    <div class="price-period">Ditagih bulanan</div>
                    <ul class="plan-features">
                        <li><span class="check">✓</span> Dashboard lengkap</li>
                        <li><span class="check">✓</span> Manajemen customer + history</li>
                        <li><span class="check">✓</span> Booking online</li>
                        <li><span class="check">✓</span> POS lengkap</li>
                        <li><span class="check">✓</span> 5 pengguna</li>
                        <li><span class="check">✓</span> Laporan keuangan</li>
                        <li><span class="check">✓</span> Membership</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary w-full">Pilih Paket</a>
                </div>

                <div class="pricing-card">
                    <div class="plan-name">Enterprise</div>
                    <div class="plan-desc">Untuk bisnis besar</div>
                    <div class="price">Rp. 749.000<span>/bln</span></div>
                    <div class="price-period">Ditagih bulanan</div>
                    <ul class="plan-features">
                        <li><span class="check">✓</span> Semua fitur Professional</li>
                        <li><span class="check">✓</span> Unlimited pengguna</li>
                        <li><span class="check">✓</span> Multi cabang</li>
                        <li><span class="check">✓</span> API akses</li>
                        <li><span class="check">✓</span> Analytics lanjutan</li>
                        <li><span class="check">✓</span> Dedicated support</li>
                        <li><span class="check">✓</span> Kustomisasi fitur</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline w-full">Pilih Paket</a>
                </div>
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
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
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
                        Apakah ada masa trial gratis?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Ya, BeautyCare menawarkan masa trial gratis selama 14 hari tanpa komitmen. Anda bisa mencoba
                            semua fitur premium selama masa trial.
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        Apakah bisa digunakan di HP?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
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
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
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
                        Apakah bisa kustom fitur?
                        <span class="faq-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Untuk paket Enterprise, kami menyediakan layanan kustomisasi fitur sesuai kebutuhan spesifik
                            bisnis Anda. Silakan hubungi tim kami untuk diskusi lebih lanjut.
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
                        <h3 style="font-size:18px;margin-bottom:8px;">Kantor Pusat BeautyCare</h3>
                        <p style="font-size:14px;color:var(--gray);text-align:center;max-width:300px;">
                            Jl. Sudirman No. 123, Jakarta Pusat<br>
                            Indonesia 10220
                        </p>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Kirim Pesan</h3>
                    <form>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="contact-name">Nama</label>
                                <input type="text" id="contact-name" class="form-input" placeholder="Nama lengkap"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-email">Email</label>
                                <input type="email" id="contact-email" class="form-input"
                                    placeholder="email@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-phone">Nomor HP</label>
                            <input type="tel" id="contact-phone" class="form-input" placeholder="+62 812 3456 7890">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contact-message">Pesan</label>
                            <textarea id="contact-message" class="form-input" placeholder="Tulis pesan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
