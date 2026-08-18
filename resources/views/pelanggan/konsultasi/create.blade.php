<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konsultasi Baru - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
    .sidebar-overlay.active { display: block; }
    @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .header-back {
        display: flex; align-items: center; gap: 16px; margin-bottom: 24px;
    }
    .header-back .btn-back {
        width: 44px; height: 44px; border-radius: 14px; border: 1.5px solid var(--border);
        background: #fff; color: var(--dark); display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: all .2s;
    }
    .header-back .btn-back:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
    .header-back .hb-text h3 { font-size: 18px; font-weight: 700; color: var(--dark); margin: 0; }
    .header-back .hb-text p { font-size: 12px; color: var(--gray); margin: 3px 0 0; }

    .form-card-premium {
        background: #fff; border: 1px solid var(--border); border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04); overflow: hidden;
    }
    .fcp-body { padding: 28px 32px; }
    .fcp-section-title {
        display: flex; align-items: center; gap: 10px; font-size: 15px; font-weight: 700;
        color: var(--dark); margin-bottom: 4px;
    }
    .fcp-st-icon {
        width: 34px; height: 34px; border-radius: 11px; background: #FEE7EF; color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
    }
    .fcp-section-sub { font-size: 12px; color: var(--gray); margin: 0 0 20px 44px; }
    .fcp-divider { height: 1px; background: var(--border); margin: 28px 0; }
    .fcp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .fg-premium { display: flex; flex-direction: column; }
    .fg-label { font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 8px; display: flex; align-items: center; gap: 7px; }
    .fg-label-icon { color: var(--primary); font-size: 12px; }
    .fg-required { color: #EF4444; }
    .fg-input {
        width: 100%; padding: 12px 14px; border: 1.5px solid var(--border); border-radius: 12px;
        font-size: 13px; outline: none; background: #FAFAFA; transition: all .2s;
        font-family: 'Poppins', sans-serif; color: var(--dark);
    }
    .fg-input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255,79,135,0.08); }
    .fg-input::placeholder { color: #A3AAB8; }
    select.fg-input { cursor: pointer; }
    .fg-help { margin-top: 6px; font-size: 11px; color: var(--gray); }
    .fg-help i { margin-right: 4px; }

    .kuota-pill {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px;
        background: #F0FDF4; border: 1px solid #BBF7D0; color: #15803D;
        font-size: 12px; font-weight: 600; padding: 9px 16px; border-radius: 100px;
    }

    .mode-options { display: flex; gap: 12px; }
    .mode-option {
        flex: 1; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px;
        cursor: pointer; text-align: center; transition: all .2s; background: #FAFAFA;
    }
    .mode-option:hover { border-color: #FFB9CF; }
    .mode-option.selected { border-color: var(--primary); background: #FFF0F5; box-shadow: 0 0 0 3px rgba(255,79,135,0.08); }
    .mode-option .mo-icon { font-size: 22px; margin-bottom: 8px; color: var(--gray); }
    .mode-option.selected .mo-icon { color: var(--primary); }
    .mode-option .mo-title { font-size: 13px; font-weight: 700; color: var(--dark); }
    .mode-option .mo-desc { font-size: 11px; color: var(--gray); margin-top: 3px; }

    .form-actions { display: flex; align-items: center; gap: 12px; margin-top: 28px; }
    .form-actions .btn-submit {
        padding: 13px 32px; border-radius: 14px; border: none;
        background: linear-gradient(135deg, var(--primary), #FF6B9C); color: #fff;
        font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif;
        box-shadow: 0 6px 16px rgba(255,79,135,0.3);
    }
    .form-actions .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,79,135,0.4); }
    .form-actions .btn-cancel-form {
        padding: 13px 28px; border-radius: 14px; border: 1.5px solid var(--border);
        background: var(--white); color: var(--gray); font-size: 14px; font-weight: 600;
        cursor: pointer; transition: all .2s; text-decoration: none;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        font-family: 'Poppins', sans-serif;
    }
    .form-actions .btn-cancel-form:hover { background: var(--background); border-color: #ddd; }

    .alert-error-premium {
        border-radius: 16px; padding: 16px 20px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 500;
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2); border: 1px solid #FECACA; color: #991B1B;
        animation: slideDown .4s ease;
    }
    .alert-error-premium .ae-icon {
        width: 36px; height: 36px; border-radius: 50%; background: #FECACA; color: #DC2626;
        display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }

    /* ─── Calendar Popup (pola booking/create) ─── */
    .date-field-wrap { position: relative; }
    .date-calendar-popup {
        display: none; position: absolute; top: calc(100% + 6px); left: 0;
        width: 100%; min-width: 250px; max-width: 290px; background: #fff;
        border-radius: 14px; border: 1px solid #FFD6E6;
        box-shadow: 0 12px 40px rgba(255, 79, 135, 0.15);
        z-index: 120; padding: 14px; font-family: 'Poppins', sans-serif;
        transform-origin: top center;
        animation: curtainUnroll 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
    }
    .date-calendar-popup.open { display: block; }
    .date-calendar-popup.open-up {
        top: auto; bottom: calc(100% + 6px); transform-origin: bottom center;
        animation-name: curtainUnrollUp;
    }
    @keyframes curtainUnroll {
        0%   { transform: scaleY(0); opacity: 0.2; }
        55%  { transform: scaleY(1.03); opacity: 1; }
        100% { transform: scaleY(1); opacity: 1; }
    }
    @keyframes curtainUnrollUp {
        0%   { transform: scaleY(0); opacity: 0.2; }
        55%  { transform: scaleY(1.03); opacity: 1; }
        100% { transform: scaleY(1); opacity: 1; }
    }
    @media (max-width: 480px) {
        .date-calendar-popup {
            position: fixed; left: 50%; transform: translateX(-50%); min-width: 0;
            width: calc(100vw - 40px); max-width: 300px; max-height: calc(100vh - 16px);
            overflow-y: auto; top: auto; bottom: auto;
            animation: curtainUnrollMobile 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
    }
    @keyframes curtainUnrollMobile {
        0%   { transform: translateX(-50%) scaleY(0); opacity: 0.2; }
        55%  { transform: translateX(-50%) scaleY(1.03); opacity: 1; }
        100% { transform: translateX(-50%) scaleY(1); opacity: 1; }
    }
    .dcp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .dcp-header h4 { font-size: 13px; font-weight: 700; color: var(--dark); margin: 0; }
    .dcp-header .dcp-nav { display: flex; gap: 4px; }
    .dcp-header .dcp-nav button {
        width: 26px; height: 26px; border: none; border-radius: 8px;
        background: var(--hover); color: var(--primary); display: flex; align-items: center;
        justify-content: center; cursor: pointer; font-size: 11px; transition: all 0.2s ease;
    }
    .dcp-header .dcp-nav button:hover { background: #FFD9E7; }
    .dcp-weekdays {
        display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-bottom: 3px;
    }
    .dcp-weekdays span {
        text-align: center; font-size: 9px; font-weight: 700; color: #9CA3AF;
        padding: 3px 0; text-transform: uppercase;
    }
    .dcp-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; }
    .dcp-days .dcp-day {
        aspect-ratio: 1; position: relative; border: none; border-radius: 8px;
        background: transparent; font-size: 11px; font-weight: 600;
        font-family: 'Poppins', sans-serif; color: var(--gray); cursor: pointer;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        transition: all 0.15s ease; padding: 0; line-height: 1;
    }
    .dcp-days .dcp-day:hover { background: var(--hover); }
    .dcp-days .dcp-day .dcp-count {
        font-size: 7px; font-weight: 700; color: var(--primary); margin-top: 1px; line-height: 1;
    }
    .dcp-days .dcp-day.today {
        background: var(--hover); color: var(--dark);
        box-shadow: inset 0 0 0 1.5px rgba(255, 79, 135, 0.45);
    }
    .dcp-days .dcp-day.today:hover { background: #FFD9E7; }
    .dcp-days .dcp-day.has-count { background: #FFE3EE; color: var(--dark); }
    .dcp-days .dcp-day.has-count:hover { background: #FFD9E7; }
    .dcp-days .dcp-day.selected {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff; box-shadow: 0 3px 10px rgba(255, 79, 135, 0.35);
    }
    .dcp-days .dcp-day.selected:hover { background: linear-gradient(135deg, var(--primary), #FF7BA6); }
    .dcp-days .dcp-day.selected .dcp-count { color: #FFD6E6; }
    .dcp-days .dcp-day.past { color: #B9C0CE; opacity: 0.55; cursor: pointer; }
    .dcp-days .dcp-day.past:hover { background: #EEF0F5; }
    .dcp-days .dcp-day.past.has-count { background: #F5F6FA; color: #B9C0CE; }
    .dcp-days .dcp-day.past.has-count:hover { background: #EDEFF4; }
    .dcp-days .dcp-day.past .dcp-count { color: #B9C0CE; }
    .dcp-days .dcp-day.past-click {
        background: #FFE3EE; color: var(--primary); opacity: 1;
        box-shadow: inset 0 0 0 1.5px rgba(255, 79, 135, 0.4);
    }
    .dcp-days .dcp-day.past-click .dcp-count { color: var(--primary); }
    .dcp-summary {
        display: none; margin-top: 12px; padding: 10px 14px;
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 100%);
        border: 1px solid rgba(255, 79, 135, 0.1); border-radius: 12px; text-align: center;
    }
    .dcp-summary.visible { display: block; }
    .dcp-summary .dcp-summary-date {
        font-size: 10px; font-weight: 600; color: var(--gray); margin-bottom: 2px;
    }
    .dcp-summary .dcp-summary-total {
        font-size: 17px; font-weight: 800; color: var(--primary); line-height: 1.2;
    }
    .dcp-summary .dcp-summary-meta { font-size: 9px; color: #9CA3AF; }
    .dcp-footer { display: flex; gap: 8px; margin-top: 10px; }
    .dcp-today {
        flex: 1; padding: 8px; border: 1.5px solid var(--primary); border-radius: 10px;
        background: #fff; color: var(--primary); font-size: 12px; font-weight: 700;
        font-family: 'Poppins', sans-serif; cursor: pointer; transition: all 0.2s ease;
    }
    .dcp-today:hover { background: var(--hover); }
    .dcp-oke {
        display: none; flex: 1; padding: 8px; border: none; border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff;
        font-size: 12px; font-weight: 700; font-family: 'Poppins', sans-serif;
        cursor: pointer; transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(255, 79, 135, 0.3);
    }
    .dcp-oke:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255, 79, 135, 0.4); }

    /* ─── Bubble Click Effect ─── */
    .bubble-effect {
        position: absolute; border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.5) 0%, rgba(255, 79, 135, 0.18) 55%, transparent 75%);
        border: 1.5px solid rgba(255, 79, 135, 0.35);
        transform: translate(-50%, -50%) scale(0); pointer-events: none;
        animation: bubblePop 0.7s ease-out forwards; z-index: 130;
    }
    .bubble-effect.bubble-small {
        border-width: 1px;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.45) 0%, rgba(255, 79, 135, 0.15) 55%, transparent 75%);
    }
    @keyframes bubblePop {
        0%   { transform: translate(-50%, -50%) scale(0); opacity: 0.9; }
        30%  { opacity: 0.85; }
        60%  { transform: translate(-50%, -65%) scale(1.5); opacity: 0.45; }
        100% { transform: translate(-50%, -95%) scale(2.1); opacity: 0; }
    }

    @media (max-width: 768px) {
        .fcp-body { padding: 20px; }
        .fcp-grid { grid-template-columns: 1fr; }
        .header-back { flex-wrap: wrap; gap: 12px; }
        .header-back .hb-text h3 { font-size: 17px; }
        .form-actions { flex-wrap: wrap; }
        .form-actions .btn-cancel-form { flex: 1; min-width: 140px; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="header-back">
                    <a href="{{ route('pelanggan.konsultasi.index') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="hb-text">
                        <h3>Konsultasi Baru</h3>
                        <p>Ajukan konsultasi perawatan kulit & kecantikan dengan beautycian kami</p>
                    </div>
                </div>

                @if($errors->any())
                <div class="alert-error-premium">
                    <div class="ae-icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form action="{{ route('pelanggan.konsultasi.store') }}" method="POST" id="konsultasiForm">
                    @csrf

                    <div class="kuota-pill">
                        <i class="fa-solid fa-layer-group"></i>
                        {{ $memberLabel }} · Sisa kuota: {{ $sisaKuota }} konsultasi bulan ini
                    </div>

                    <div class="form-card-premium">
                        <div class="fcp-body">
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-regular fa-comments"></i></span>
                                Detail Konsultasi
                            </div>
                            <div class="fcp-section-sub">Ceritakan masalah atau pertanyaan Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-calendar-check fg-label-icon"></i>
                                        Tanggal <span class="fg-required">*</span>
                                    </label>
                                    <div class="date-field-wrap">
                                        <input type="date" name="tanggal" id="tanggalInput" class="fg-input" required min="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}">
                                        <div class="date-calendar-popup" id="dateCalendarPopup">
                                            <div class="dcp-header">
                                                <h4 id="dcpMonthYear"></h4>
                                                <div class="dcp-nav">
                                                    <button type="button" id="dcpPrevMonth" title="Bulan sebelumnya">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>
                                                    </button>
                                                    <button type="button" id="dcpNextMonth" title="Bulan berikutnya">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="dcp-weekdays">
                                                <span>M</span><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span>
                                            </div>
                                            <div class="dcp-days" id="dcpDays"></div>
                                            <div class="dcp-summary" id="dcpSummary">
                                                <p class="dcp-summary-date" id="dcpSummaryDate"></p>
                                                <p class="dcp-summary-total" id="dcpSummaryTotal"></p>
                                                <p class="dcp-summary-meta" id="dcpSummaryMeta"></p>
                                            </div>
                                            <div class="dcp-footer">
                                                <button type="button" id="dcpToday" class="dcp-today">Hari Ini</button>
                                                <button type="button" id="dcpOke" class="dcp-oke">Oke</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-clock fg-label-icon"></i>
                                        Jam <span class="fg-required">*</span>
                                    </label>
                                    <input type="time" name="jam" class="fg-input" required value="{{ old('jam') }}">
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-shield-heart"></i></span>
                                Mode & Media
                            </div>
                            <div class="fcp-section-sub">Konsultasi bisa dilakukan secara online via WhatsApp</div>

                            <div class="mode-options" id="modeOptions">
                                <div class="mode-option {{ old('mode', 'online') === 'online' ? 'selected' : '' }}" data-mode="online" onclick="pilihMode('online')">
                                    <div class="mo-icon"><i class="fa-solid fa-globe"></i></div>
                                    <div class="mo-title">Online</div>
                                    <div class="mo-desc">Via WhatsApp, dari rumah</div>
                                </div>
                                <div class="mode-option {{ old('mode') === 'offline' ? 'selected' : '' }}" data-mode="offline" onclick="pilihMode('offline')">
                                    <div class="mo-icon"><i class="fa-solid fa-store"></i></div>
                                    <div class="mo-title">Offline</div>
                                    <div class="mo-desc">Datang langsung ke salon</div>
                                </div>
                            </div>
                            <input type="hidden" name="mode" id="modeInput" value="{{ old('mode', 'online') }}">

                            <div class="fcp-grid" id="mediaWrap" style="margin-top:16px;">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-brands fa-whatsapp fg-label-icon"></i>
                                        Media WhatsApp <span class="fg-required">*</span>
                                    </label>
                                    <select name="media" id="mediaSelect" class="fg-input">
                                        <option value="whatsapp_chat">WhatsApp Chat</option>
                                        <option value="whatsapp_video">WhatsApp Video Call</option>
                                    </select>
                                    <div class="fg-help">
                                        <i class="fa-solid fa-circle-info"></i> Terapis akan menghubungi Anda via media terpilih
                                    </div>
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-pen"></i></span>
                                Topik Konsultasi
                            </div>
                            <div class="fcp-section-sub">Jelaskan secara singkat apa yang ingin Anda konsultasikan</div>

                            <div class="fg-premium">
                                <label class="fg-label">
                                    <i class="fa-solid fa-tag fg-label-icon"></i>
                                    Topik <span class="fg-required">*</span>
                                </label>
                                <input type="text" name="topik" class="fg-input" required maxlength="200" placeholder="cth: Perawatan jerawat, Rekomendasi skincare, Konsultasi sebelum bridal" value="{{ old('topik') }}">
                            </div>

                            <div class="fg-premium" style="margin-top:16px;">
                                <label class="fg-label">
                                    <i class="fa-regular fa-message fg-label-icon"></i>
                                    Detail / Pesan
                                </label>
                                <textarea name="pesan" class="fg-input" rows="5" maxlength="2000" placeholder="Ceritakan keluhan kulit, jenis kulit, atau pertanyaan Anda...">{{ old('pesan') }}</textarea>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('pelanggan.konsultasi.index') }}" class="btn-cancel-form">
                                    <i class="fa-solid fa-xmark"></i> Batal
                                </a>
                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Permintaan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    function pilihMode(mode) {
        document.getElementById('modeInput').value = mode;
        document.querySelectorAll('.mode-option').forEach(function(opt) {
            opt.classList.toggle('selected', opt.getAttribute('data-mode') === mode);
        });
        var mediaWrap = document.getElementById('mediaWrap');
        if (mediaWrap) mediaWrap.style.display = mode === 'online' ? '' : 'none';
        var mediaSelect = document.getElementById('mediaSelect');
        if (mediaSelect) mediaSelect.required = mode === 'online';
    }
    pilihMode(document.getElementById('modeInput').value);

    const bookingsPerDay = {};
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const dcpNow = new Date();
    let dcpMonth = dcpNow.getMonth();
    let dcpYear = dcpNow.getFullYear();
    let dcpSelected = {{ old('tanggal') ? "'" . old('tanggal') . "'" : 'null' }};
    let pastClicked = null;

    const tanggalInput = document.getElementById('tanggalInput');
    const dcpPopup = document.getElementById('dateCalendarPopup');
    const dcpDays = document.getElementById('dcpDays');
    const dcpSummary = document.getElementById('dcpSummary');
    const dcpOke = document.getElementById('dcpOke');
    const dcpToday = document.getElementById('dcpToday');

    function getDataForDate(year, month, day) {
        const key = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
        return bookingsPerDay[key] || { total: 0, aktif: 0, selesai: 0, dibatalkan: 0 };
    }

    function getCountForDate(year, month, day) {
        const data = getDataForDate(year, month, day);
        return data.total || 0;
    }

    function renderCalendarPopup() {
        const firstDay = new Date(dcpYear, dcpMonth, 1).getDay();
        const daysInMonth = new Date(dcpYear, dcpMonth + 1, 0).getDate();
        const today = new Date();
        const todayDate = today.getDate();
        const todayMonth = today.getMonth();
        const todayYear = today.getFullYear();

        document.getElementById('dcpMonthYear').textContent = monthNames[dcpMonth] + ' ' + dcpYear;

        dcpDays.innerHTML = '';

        for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
            const empty = document.createElement('div');
            dcpDays.appendChild(empty);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            const count = getCountForDate(dcpYear, dcpMonth, d);
            const iso = dcpYear + '-' + String(dcpMonth + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
            const isPast = new Date(dcpYear, dcpMonth, d) < new Date(dcpNow.getFullYear(), dcpNow.getMonth(), dcpNow.getDate());
            const isToday = (d === todayDate && dcpMonth === todayMonth && dcpYear === todayYear);
            const isSelected = dcpSelected && dcpSelected === iso;

            btn.className = 'dcp-day';
            btn.textContent = d;

            if (isPast) btn.classList.add('past');
            if (isToday) btn.classList.add('today');
            if (count > 0) btn.classList.add('has-count');
            if (isSelected) btn.classList.add('selected');
            if (isPast && pastClicked === iso) btn.classList.add('past-click');

            if (count > 0) {
                const span = document.createElement('span');
                span.className = 'dcp-count';
                span.textContent = count;
                btn.appendChild(span);
            }

            btn.addEventListener('click', function() {
                const data = getDataForDate(dcpYear, dcpMonth, d);
                const total = data.total || 0;
                spawnBubble(btn, btn.clientWidth / 2, btn.clientHeight / 2, 40, true);
                showCalendarSummary(d, total, data, isPast);
                if (!isPast) {
                    pastClicked = null;
                    dcpSelected = iso;
                    dcpOke.style.display = 'block';
                    renderCalendarPopup();
                } else {
                    if (dcpSelected) {
                        dcpSelected = null;
                        dcpOke.style.display = 'none';
                        dcpDays.querySelectorAll('.dcp-day.selected').forEach(function(el) {
                            el.classList.remove('selected');
                        });
                    }
                    dcpDays.querySelectorAll('.dcp-day.past-click').forEach(function(el) {
                        el.classList.remove('past-click');
                    });
                    pastClicked = iso;
                    btn.classList.add('past-click');
                }
            });

            dcpDays.appendChild(btn);
        }

        if (window.matchMedia('(max-width: 480px)').matches) positionMobilePopup();
    }

    function showCalendarSummary(day, count, data, isPast) {
        dcpSummary.classList.add('visible');
        document.getElementById('dcpSummaryDate').textContent = day + ' ' + monthNames[dcpMonth] + ' ' + dcpYear;
        const totalEl = document.getElementById('dcpSummaryTotal');
        const meta = document.getElementById('dcpSummaryMeta');
        totalEl.textContent = 'Tanggal Tersedia';
        meta.textContent = 'Pilih tanggal untuk jadwal konsultasi Anda';
        if (isPast) {
            meta.textContent += ' · tanggal lampau (hanya info)';
        }
        if (window.matchMedia('(max-width: 480px)').matches) positionMobilePopup();
    }

    function positionMobilePopup() {
        if (!dcpPopup.classList.contains('open')) return;
        const rect = tanggalInput.getBoundingClientRect();
        const popupH = dcpPopup.offsetHeight;
        const vh = window.innerHeight;
        let top;
        if (vh - rect.bottom < popupH + 12 && rect.top > popupH + 12) {
            top = rect.top - popupH - 6;
        } else {
            top = rect.bottom + 6;
        }
        top = Math.max(8, Math.min(top, vh - popupH - 8));
        dcpPopup.style.top = top + 'px';
    }

    function openCalendarPopup() {
        dcpPopup.classList.add('open');
        renderCalendarPopup();
        const rect = tanggalInput.getBoundingClientRect();
        const popupH = dcpPopup.offsetHeight;
        const spaceBelow = window.innerHeight - rect.bottom;
        const isMobile = window.matchMedia('(max-width: 480px)').matches;
        if (isMobile) {
            dcpPopup.style.left = '';
            dcpPopup.classList.remove('open-up');
            positionMobilePopup();
        } else {
            dcpPopup.style.top = '';
            if (spaceBelow < popupH + 12 && rect.top > popupH + 12) {
                dcpPopup.classList.add('open-up');
            } else {
                dcpPopup.classList.remove('open-up');
            }
        }
    }

    function spawnBubble(target, x, y, size, small) {
        const bubble = document.createElement('span');
        bubble.className = 'bubble-effect' + (small ? ' bubble-small' : '');
        bubble.style.left = x + 'px';
        bubble.style.top = y + 'px';
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        target.appendChild(bubble);
        setTimeout(function() { bubble.remove(); }, 750);
    }

    function closeCalendarPopup() {
        dcpPopup.classList.remove('open');
    }

    function toggleCalendarPopup() {
        if (dcpPopup.classList.contains('open')) {
            closeCalendarPopup();
        } else {
            openCalendarPopup();
        }
    }

    if (tanggalInput) {
        tanggalInput.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const wrap = tanggalInput.closest('.date-field-wrap');
            const rect = tanggalInput.getBoundingClientRect();
            const x = e.clientX ? e.clientX - rect.left : rect.width / 2;
            const y = e.clientY ? e.clientY - rect.top : rect.height / 2;
            spawnBubble(wrap, x, y, 52, false);
            toggleCalendarPopup();
        });
        tanggalInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleCalendarPopup();
            }
        });
    }

    document.getElementById('dcpPrevMonth').addEventListener('click', function(e) {
        e.stopPropagation();
        dcpMonth--;
        if (dcpMonth < 0) { dcpMonth = 11; dcpYear--; }
        dcpSelected = null;
        dcpOke.style.display = 'none';
        renderCalendarPopup();
    });

    document.getElementById('dcpNextMonth').addEventListener('click', function(e) {
        e.stopPropagation();
        dcpMonth++;
        if (dcpMonth > 11) { dcpMonth = 0; dcpYear++; }
        dcpSelected = null;
        dcpOke.style.display = 'none';
        renderCalendarPopup();
    });

    dcpOke.addEventListener('click', function(e) {
        e.stopPropagation();
        if (dcpSelected) {
            tanggalInput.value = dcpSelected;
            tanggalInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
        closeCalendarPopup();
    });

    dcpToday.addEventListener('click', function(e) {
        e.stopPropagation();
        const todayIso = dcpNow.getFullYear() + '-' + String(dcpNow.getMonth() + 1).padStart(2, '0') + '-' + String(dcpNow.getDate()).padStart(2, '0');
        dcpSelected = todayIso;
        tanggalInput.value = todayIso;
        tanggalInput.dispatchEvent(new Event('change', { bubbles: true }));
        closeCalendarPopup();
    });

    document.addEventListener('click', function(e) {
        const wrap = tanggalInput ? tanggalInput.closest('.date-field-wrap') : null;
        if (wrap && e.target.isConnected && !wrap.contains(e.target)) {
            closeCalendarPopup();
        }
    });

    if (dcpSelected) dcpOke.style.display = 'block';
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
