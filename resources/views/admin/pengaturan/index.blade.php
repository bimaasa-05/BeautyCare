<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

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
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

        .settings-card {
            background: #fff;
            border: 1px solid #FDE1EC;
            border-radius: 20px;
            padding: 24px 26px;
            box-shadow: 0 2px 16px rgba(236, 72, 153, 0.07);
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s;
        }

        .settings-card:hover {
            box-shadow: 0 8px 28px rgba(236, 72, 153, 0.14);
            transform: translateY(-2px);
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            max-width: 1160px;
        }

        @media (min-width: 1024px) {
            .settings-grid {
                grid-template-columns: 1fr 1fr;
            }

            .settings-card--wide {
                grid-column: 1 / -1;
            }
        }

        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 5px 14px rgba(255, 79, 135, 0.28);
        }

        .card-icon svg {
            width: 19px;
            height: 19px;
        }

        .settings-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .salon-field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (min-width: 1024px) {
            .salon-field-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .settings-card-title {
            font-size: 15px;
            font-weight: 700;
            color: #1F2937;
            margin: 0;
        }

        .settings-sub {
            font-size: 12px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        .settings-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 0.4px;
        }

        .settings-input {
            width: 100%;
            padding: 10px 12px;
            background: #FFF7FA;
            border: 1px solid #FBCFE8;
            border-radius: 12px;
            font-size: 13px;
            color: #374151;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .settings-input:focus {
            border-color: #FF4F87;
        }

        .btn-save-pink {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save-pink:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 79, 135, 0.35);
        }

        .btn-save-pink svg {
            width: 15px;
            height: 15px;
        }

        .settings-card-footer {
            margin-top: auto;
            padding-top: 18px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-add-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 8px 16px;
            background: #FFF0F5;
            border: 1px dashed #F9A8C9;
            color: #DB2777;
            font-weight: 700;
            border-radius: 12px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-add-soft:hover {
            background: #FFE3EC;
        }

        .settings-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 0;
        }

        .settings-toggle-row + .settings-toggle-row {
            border-top: 1px solid #FDF2F7;
        }

        .settings-toggle-text p:first-child {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin: 0;
        }

        .settings-toggle-text p:last-child {
            font-size: 11px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        .toggle-btn {
            position: relative;
            width: 44px;
            height: 24px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            background: #E5E7EB;
            transition: background 0.3s;
            flex-shrink: 0;
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #EC4899, #BE185D);
        }

        .toggle-btn .toggle-circle {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 16px;
            height: 16px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: left 0.3s;
        }

        .toggle-btn.active .toggle-circle {
            left: 24px;
        }

    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Pengaturan</h3>
                            <p>Konfigurasi pengaturan aplikasi BeautyCare sesuai kebutuhan.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="settings-grid">

                        <!-- Card: Notifikasi -->
                        <form id="formNotifikasi" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" /><path d="M13.73 21a2 2 0 0 1-3.46 0" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Notifikasi</h3>
                                    <p class="settings-sub">Pilih kanal notifikasi yang aktif</p>
                                </div>
                            </div>
                            <div>
                                <div class="settings-toggle-row">
                                    <div class="settings-toggle-text">
                                        <p>Push Notification</p>
                                        <p>Notifikasi booking &amp; transaksi</p>
                                    </div>
                                    <input type="hidden" name="push_notification" value="{{ $pengaturan->push_notification ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn {{ $pengaturan->push_notification ? 'active' : '' }}" data-active="{{ $pengaturan->push_notification ? 'true' : 'false' }}">
                                        <div class="toggle-circle"></div>
                                    </button>
                                </div>
                                <div class="settings-toggle-row">
                                    <div class="settings-toggle-text">
                                        <p>SMS Notifikasi</p>
                                        <p>Kirim SMS ke pelanggan otomatis</p>
                                    </div>
                                    <input type="hidden" name="sms_notifikasi" value="{{ $pengaturan->sms_notifikasi ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn {{ $pengaturan->sms_notifikasi ? 'active' : '' }}" data-active="{{ $pengaturan->sms_notifikasi ? 'true' : 'false' }}">
                                        <div class="toggle-circle"></div>
                                    </button>
                                </div>
                                <div class="settings-toggle-row">
                                    <div class="settings-toggle-text">
                                        <p>Email Laporan</p>
                                        <p>Laporan harian via email</p>
                                    </div>
                                    <input type="hidden" name="email_laporan" value="{{ $pengaturan->email_laporan ? '1' : '0' }}">
                                    <button type="button" class="toggle-btn {{ $pengaturan->email_laporan ? 'active' : '' }}" data-active="{{ $pengaturan->email_laporan ? 'true' : 'false' }}">
                                        <div class="toggle-circle"></div>
                                    </button>
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Notifikasi
                                </button>
                            </div>
                        </form>

                        <!-- Card: Operasional -->
                        <form id="formOperasional" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14" /><line x1="4" y1="10" x2="4" y2="3" /><line x1="12" y1="21" x2="12" y2="12" /><line x1="12" y1="8" x2="12" y2="3" /><line x1="20" y1="21" x2="20" y2="16" /><line x1="20" y1="12" x2="20" y2="3" /><line x1="1" y1="14" x2="7" y2="14" /><line x1="9" y1="8" x2="15" y2="8" /><line x1="17" y1="16" x2="23" y2="16" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Operasional</h3>
                                    <p class="settings-sub">Atur alur operasional aplikasi</p>
                                </div>
                            </div>
                            <div class="settings-toggle-row" style="padding-top:0;">
                                <div class="settings-toggle-text">
                                    <p>Konfirmasi Otomatis</p>
                                    <p>Booking auto-confirm jika tersedia</p>
                                </div>
                                <input type="hidden" name="konfirmasi_otomatis" value="{{ $pengaturan->konfirmasi_otomatis ? '1' : '0' }}">
                                <button type="button" class="toggle-btn {{ $pengaturan->konfirmasi_otomatis ? 'active' : '' }}" data-active="{{ $pengaturan->konfirmasi_otomatis ? 'true' : 'false' }}">
                                    <div class="toggle-circle"></div>
                                </button>
                            </div>
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Operasional
                                </button>
                            </div>
                        </form>

                        <!-- Card: Informasi Salon -->
                        <form id="formSalon" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card settings-card--wide">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" /><path d="M9 22v-4h6v4" /><path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Informasi Salon</h3>
                                    <p class="settings-sub">Data salon yang tampil di aplikasi</p>
                                </div>
                            </div>
                            <div class="salon-field-grid">
                                <div>
                                    <label class="settings-label" for="nama_salon">Nama Salon</label>
                                    <input type="text" id="nama_salon" name="nama_salon" value="{{ $pengaturan->nama_salon }}" class="settings-input">
                                </div>
                                <div>
                                    <label class="settings-label" for="telepon">Telepon</label>
                                    <input type="text" id="telepon" name="telepon" value="{{ $pengaturan->telepon }}" class="settings-input">
                                </div>
                                <div>
                                    <label class="settings-label" for="jam_buka">Jam Buka</label>
                                    <input type="time" id="jam_buka" name="jam_buka" value="{{ $pengaturan->jam_buka ? substr($pengaturan->jam_buka, 0, 5) : '08:00' }}" class="settings-input">
                                </div>
                                <div>
                                    <label class="settings-label" for="jam_tutup">Jam Tutup</label>
                                    <input type="time" id="jam_tutup" name="jam_tutup" value="{{ $pengaturan->jam_tutup ? substr($pengaturan->jam_tutup, 0, 5) : '20:00' }}" class="settings-input">
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Informasi Salon
                                </button>
                            </div>
                        </form>

                        <!-- Card: Syarat & Ketentuan -->
                        <form id="formSyarat" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Syarat &amp; Ketentuan</h3>
                                    <p class="settings-sub">Konten ini ditampilkan di halaman publik Syarat &amp; Ketentuan</p>
                                </div>
                            </div>
                            <textarea name="syarat_ketentuan" rows="10" class="settings-input leading-relaxed"
                                placeholder="Tulis syarat & ketentuan di sini...">{{ $pengaturan->syarat_ketentuan }}</textarea>
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Syarat &amp; Ketentuan
                                </button>
                            </div>
                        </form>

                        <!-- Card: Kebijakan Privasi -->
                        <form id="formKebijakan" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Kebijakan Privasi</h3>
                                    <p class="settings-sub">Konten ini ditampilkan di halaman publik Kebijakan Privasi</p>
                                </div>
                            </div>
                            <textarea name="kebijakan_privasi" rows="10" class="settings-input leading-relaxed"
                                placeholder="Tulis kebijakan privasi di sini...">{{ $pengaturan->kebijakan_privasi }}</textarea>
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Kebijakan Privasi
                                </button>
                            </div>
                        </form>

                        <!-- Card: Kategori Pusat Bantuan -->
                        <form id="formKategori" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" /><line x1="7" y1="7" x2="7.01" y2="7" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">Kategori Pusat Bantuan</h3>
                                    <p class="settings-sub">Kelompokkan pertanyaan di halaman Pusat Bantuan</p>
                                </div>
                            </div>
                            <div id="kategori-rows" class="space-y-2"></div>
                            <button type="button" id="btn-tambah-kategori" class="btn-add-soft">+ Tambah Kategori</button>
                            <input type="hidden" name="pusat_bantuan_kategori" id="pusat_bantuan_kategori" value="">
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan Kategori
                                </button>
                            </div>
                        </form>

                        <!-- Card: FAQ Pusat Bantuan -->
                        <form id="formFaq" method="POST" action="{{ route('admin.pengaturan.update') }}" class="settings-card">
                            @csrf
                            <div class="settings-card-header">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" /><line x1="12" y1="17" x2="12.01" y2="17" /></svg>
                                </div>
                                <div>
                                    <h3 class="settings-card-title">FAQ Pusat Bantuan</h3>
                                    <p class="settings-sub">Pertanyaan &amp; jawaban di halaman Pusat Bantuan</p>
                                </div>
                            </div>
                            <div id="faq-rows"></div>
                            <button type="button" id="btn-tambah-faq" class="btn-add-soft">+ Tambah FAQ</button>
                            <input type="hidden" name="pusat_bantuan_faq" id="pusat_bantuan_faq" value="">
                            <div class="settings-card-footer">
                                <button type="submit" class="btn-save-pink">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" /><polyline points="17 21 17 13 7 13 7 21" /><polyline points="7 3 7 8 15 8" /></svg>
                                    Simpan FAQ
                                </button>
                            </div>
                        </form>

                    </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButtons = document.querySelectorAll('.toggle-btn');

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const isActive = this.getAttribute('data-active') === 'true';
                    const hiddenInput = this.parentElement.querySelector('input[type="hidden"]');

                    if (isActive) {
                        this.setAttribute('data-active', 'false');
                        this.classList.remove('active');
                        if (hiddenInput) hiddenInput.value = '0';
                    } else {
                        this.setAttribute('data-active', 'true');
                        this.classList.add('active');
                        if (hiddenInput) hiddenInput.value = '1';
                    }
                });
            });
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kategoriState = @json(json_decode($pengaturan->pusat_bantuan_kategori ?? '[]', true) ?: []);
            const faqState = @json(json_decode($pengaturan->pusat_bantuan_faq ?? '[]', true) ?: []);

            const kategoriRows = document.getElementById('kategori-rows');
            const faqRows = document.getElementById('faq-rows');

            const inputCls =
                'w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium';
            const labelCls = 'text-[10px] font-bold text-gray-400 mb-1 block uppercase';

            const kategoriNames = () =>
                Array.from(kategoriRows.querySelectorAll('.kategori-input')).map(i => i.value.trim()).filter(Boolean);

            const esc = (s) => String(s || '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[c]));

            const buildFaqSelect = (selected) => {
                const names = kategoriNames();
                let opts = '<option value="" disabled>-- Pilih kategori --</option>';
                names.forEach(n => {
                    opts += `<option value="${esc(n)}" ${selected === n ? 'selected' : ''}>${esc(n)}</option>`;
                });
                return opts;
            };

            const renderKategori = () => {
                kategoriRows.innerHTML = '';
                kategoriState.forEach((k, i) => {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-2';
                    row.innerHTML = `
                        <input type="text" class="kategori-input flex-1 ${inputCls}" placeholder="Nama kategori" value="${esc(k.nama)}">
                        <button type="button" class="remove-kategori px-3 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold hover:bg-red-100 transition-all" title="Hapus">Hapus</button>
                    `;
                    row.querySelector('.remove-kategori').addEventListener('click', () => {
                        kategoriState.splice(i, 1);
                        renderKategori();
                        renderFaq();
                    });
                    kategoriRows.appendChild(row);
                });
            };

            const renderFaq = () => {
                faqRows.innerHTML = '';
                faqState.forEach((f, i) => {
                    const row = document.createElement('div');
                    row.className = 'faq-row border border-pink-100 rounded-xl p-3 mb-3 bg-[#FFFCFD]';
                    row.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_auto] gap-2 mb-2">
                            <div>
                                <label class="${labelCls}">Kategori</label>
                                <select class="faq-kategori w-full px-3 py-2.5 bg-white border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium">
                                    ${buildFaqSelect(f.kategori || '')}
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-faq px-3 py-2.5 rounded-xl bg-red-50 text-red-500 text-xs font-bold hover:bg-red-100 transition-all" title="Hapus">Hapus</button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="${labelCls}">Pertanyaan</label>
                            <input type="text" class="faq-pertanyaan ${inputCls}" placeholder="Tulis pertanyaan..." value="${esc(f.pertanyaan)}">
                        </div>
                        <div>
                            <label class="${labelCls}">Jawaban</label>
                            <textarea rows="3" class="faq-jawaban w-full px-3 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-400 text-gray-700 font-medium leading-relaxed" placeholder="Tulis jawaban...">${esc(f.jawaban)}</textarea>
                        </div>
                    `;
                    row.querySelector('.remove-faq').addEventListener('click', () => {
                        faqState.splice(i, 1);
                        renderFaq();
                    });
                    row.querySelector('.faq-kategori').addEventListener('change', (e) => {
                        f.kategori = e.target.value;
                    });
                    row.querySelector('.faq-pertanyaan').addEventListener('input', (e) => {
                        f.pertanyaan = e.target.value;
                    });
                    row.querySelector('.faq-jawaban').addEventListener('input', (e) => {
                        f.jawaban = e.target.value;
                    });
                    faqRows.appendChild(row);
                });
            };

            kategoriRows.addEventListener('input', (e) => {
                if (e.target.classList.contains('kategori-input')) {
                    const idx = Array.from(kategoriRows.children).indexOf(e.target.closest('.flex'));
                    kategoriState[idx].nama = e.target.value;
                }
            });

            document.getElementById('btn-tambah-kategori').addEventListener('click', () => {
                kategoriState.push({ nama: '' });
                renderKategori();
                renderFaq();
            });

            document.getElementById('btn-tambah-faq').addEventListener('click', () => {
                faqState.push({ kategori: '', pertanyaan: '', jawaban: '' });
                renderFaq();
            });

            document.getElementById('formKategori').addEventListener('submit', () => {
                const kategori = [];
                kategoriRows.querySelectorAll('.kategori-input').forEach(i => {
                    if (i.value.trim()) kategori.push({ nama: i.value.trim() });
                });
                document.getElementById('pusat_bantuan_kategori').value = JSON.stringify(kategori);
            });

            document.getElementById('formFaq').addEventListener('submit', () => {
                const faq = [];
                faqRows.querySelectorAll('.faq-row').forEach(r => {
                    const faqKategori = r.querySelector('.faq-kategori').value;
                    const pertanyaan = r.querySelector('.faq-pertanyaan').value.trim();
                    const jawaban = r.querySelector('.faq-jawaban').value.trim();
                    if (faqKategori && pertanyaan && jawaban) {
                        faq.push({ kategori: faqKategori, pertanyaan, jawaban });
                    }
                });
                document.getElementById('pusat_bantuan_faq').value = JSON.stringify(faq);
            });

            renderKategori();
            renderFaq();
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
