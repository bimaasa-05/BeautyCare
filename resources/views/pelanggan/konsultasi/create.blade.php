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
                                    <input type="date" name="tanggal" class="fg-input" required min="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}">
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
