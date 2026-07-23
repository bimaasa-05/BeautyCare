<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Baru - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
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

    /* ─── Header Back ─── */
    .header-back {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .header-back .btn-back {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--white);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        font-size: 15px;
        transition: all 0.2s ease;
        text-decoration: none;
        flex-shrink: 0;
    }

    .header-back .btn-back:hover {
        background: var(--hover);
        color: var(--primary);
        transform: translateX(-2px);
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .header-back .hb-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .header-back .hb-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    /* ─── Steps Indicator ─── */
    .steps-indicator {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 28px;
        padding: 4px;
        background: #FAFAFA;
        border-radius: 14px;
        border: 1px solid var(--border);
    }

    .steps-indicator .step-item {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 11px;
        font-size: 12px;
        font-weight: 500;
        color: var(--gray);
        transition: all 0.3s ease;
    }

    .steps-indicator .step-item .step-num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--border);
        color: #aaa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .steps-indicator .step-item.active {
        background: var(--white);
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .steps-indicator .step-item.active .step-num {
        background: var(--primary);
        color: #fff;
    }

    .steps-indicator .step-item.completed .step-num {
        background: #22C55E;
        color: #fff;
    }

    /* ─── Form Card Premium ─── */
    .form-card-premium {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .form-card-premium .fcp-body {
        padding: 32px;
    }

    .form-card-premium .fcp-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-card-premium .fcp-section-title .fcp-st-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .form-card-premium .fcp-section-sub {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 20px;
        margin-left: 36px;
    }

    .form-card-premium .fcp-divider {
        height: 1px;
        background: var(--border);
        margin: 24px 0;
    }

    /* ─── Form Row Grid ─── */
    .fcp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .fcp-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ─── Form Group Premium ─── */
    .fg-premium {
        margin-bottom: 0;
    }

    .fg-premium .fg-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .fg-premium .fg-label .fg-label-icon {
        color: var(--primary);
        font-size: 13px;
        width: 16px;
        text-align: center;
    }

    .fg-premium .fg-label .fg-required {
        color: #EF4444;
        font-size: 12px;
    }

    .fg-premium .fg-input {
        width: 100%;
        padding: 11px 16px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: var(--dark);
        transition: all 0.2s ease;
        outline: none;
        appearance: none;
    }

    .fg-premium .fg-input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1);
    }

    .fg-premium .fg-input::placeholder {
        color: #bbb;
    }

    .fg-premium .fg-input:read-only {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .fg-premium select.fg-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
    }

    .fg-premium textarea.fg-input {
        min-height: 100px;
        resize: vertical;
    }

    /* ─── Summary Card Premium ─── */
    .summary-card-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 16px;
        padding: 24px;
        margin-top: 24px;
        border: 1px solid rgba(255, 79, 135, 0.1);
        position: relative;
        overflow: hidden;
    }

    .summary-card-premium::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .summary-card-premium .sc-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }

    .summary-card-premium .sc-title i {
        color: var(--primary);
    }

    .summary-card-premium .sc-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 13px;
        color: var(--gray);
        position: relative;
        z-index: 1;
    }

    .summary-card-premium .sc-row:not(:last-child) {
        border-bottom: 1px dashed rgba(255, 79, 135, 0.15);
    }

    .summary-card-premium .sc-row .sc-label {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-card-premium .sc-row .sc-label .sc-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary);
        opacity: 0.4;
    }

    .summary-card-premium .sc-row .sc-value {
        font-weight: 600;
        color: var(--dark);
    }

    .summary-card-premium .sc-row.sc-total {
        padding-top: 14px;
        padding-bottom: 0;
        border-bottom: none !important;
    }

    .summary-card-premium .sc-row.sc-total .sc-label {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .summary-card-premium .sc-row.sc-total .sc-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary);
    }

    /* ─── Actions Footer ─── */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }

    .form-actions .btn-submit {
        flex: 1;
        padding: 13px 28px;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-family: 'Inter', sans-serif;
    }

    .form-actions .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(255, 79, 135, 0.4);
    }

    .form-actions .btn-submit:active {
        transform: translateY(0);
    }

    .form-actions .btn-cancel-form {
        padding: 13px 28px;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--gray);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }

    .form-actions .btn-cancel-form:hover {
        background: var(--background);
        border-color: #ddd;
    }

    /* ─── Error Alert ─── */
    .alert-error-premium {
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        font-weight: 500;
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
        border: 1px solid #FECACA;
        color: #991B1B;
        animation: slideDown 0.4s ease;
    }

    .alert-error-premium .ae-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #FECACA;
        color: #DC2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
        .form-card-premium .fcp-body { padding: 20px; }
        .steps-indicator .step-item span { display: none; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <!-- ═══ Header Back ═══ -->
                <div class="header-back">
                    <a href="{{ route('pelanggan.booking') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="hb-text">
                        <h3>Booking Treatment Baru</h3>
                        <p>Pilih layanan, terapis, dan jadwal treatment impian Anda</p>
                    </div>
                </div>

                <!-- ═══ Steps Indicator ═══ -->
                <div class="steps-indicator">
                    <div class="step-item active">
                        <span class="step-num">1</span>
                        <span>Pilih Layanan</span>
                    </div>
                    <div class="step-item active">
                        <span class="step-num">2</span>
                        <span>Atur Jadwal</span>
                    </div>
                    <div class="step-item active">
                        <span class="step-num">3</span>
                        <span>Konfirmasi</span>
                    </div>
                </div>

                <!-- ═══ Error Alert ═══ -->
                @if($errors->any())
                <div class="alert-error-premium">
                    <div class="ae-icon">
                        <i class="fa-regular fa-circle-exclamation"></i>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- ═══ Form Card Premium ═══ -->
                <form action="{{ route('pelanggan.booking.store') }}" method="POST" id="bookingForm">
                    @csrf

                    <div class="form-card-premium">
                        <div class="fcp-body">
                            <!-- Section 1: Layanan & Terapis -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-regular fa-spa"></i></span>
                                Layanan & Terapis
                            </div>
                            <div class="fcp-section-sub">Pilih treatment dan beauty therapist favorit Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-spa fg-label-icon"></i>
                                        Layanan Treatment <span class="fg-required">*</span>
                                    </label>
                                    <select name="id_layanan" id="id_layanan" class="fg-input" required onchange="updateHarga()">
                                        <option value="">— Pilih Layanan —</option>
                                        @foreach($layanans as $layanan)
                                        <option value="{{ $layanan->id_layanan }}" data-harga="{{ $layanan->harga }}">
                                            {{ $layanan->nm_layanan }} — Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-user fg-label-icon"></i>
                                        Pilih Terapis <span class="fg-required">*</span>
                                    </label>
                                    <select name="id_karyawan" class="fg-input" required>
                                        <option value="">— Pilih Terapis —</option>
                                        @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }} — {{ $karyawan->jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <!-- Section 2: Jadwal -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-regular fa-calendar"></i></span>
                                Jadwal Treatment
                            </div>
                            <div class="fcp-section-sub">Tentukan tanggal dan jam kedatangan Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-calendar-check fg-label-icon"></i>
                                        Tanggal <span class="fg-required">*</span>
                                    </label>
                                    <input type="date" name="tanggal" class="fg-input" required min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-clock fg-label-icon"></i>
                                        Jam <span class="fg-required">*</span>
                                    </label>
                                    <input type="time" name="jam" class="fg-input" required>
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <!-- Section 3: Harga & Catatan -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-regular fa-receipt"></i></span>
                                Harga & Catatan
                            </div>
                            <div class="fcp-section-sub">Informasi harga dan pesan tambahan untuk terapis</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-tag fg-label-icon"></i>
                                        Harga
                                    </label>
                                    <input type="text" id="harga_display" class="fg-input" readonly placeholder="Pilih layanan terlebih dahulu" style="background:#F5F5F5;">
                                    <input type="hidden" name="harga" id="harga">
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-circle-down fg-label-icon"></i>
                                        Diskon
                                    </label>
                                    <input type="number" name="diskon" id="diskon" class="fg-input" value="0" min="0" oninput="updateSubtotal()" placeholder="0">
                                </div>
                            </div>

                            <div class="fg-premium" style="margin-top:20px;">
                                <label class="fg-label">
                                    <i class="fa-regular fa-note-sticky fg-label-icon"></i>
                                    Catatan
                                </label>
                                <textarea name="catatan" class="fg-input" rows="3" placeholder="Tambahkan catatan khusus untuk terapis... (misal: alergi, area yang ingin difokuskan)"></textarea>
                            </div>

                            <!-- ═══ Summary Card ═══ -->
                            <div class="summary-card-premium">
                                <div class="sc-title">
                                    <i class="fa-regular fa-receipt"></i>
                                    Ringkasan Booking
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Layanan
                                    </span>
                                    <span class="sc-value" id="summary_layanan" style="font-weight:500;color:var(--gray);">—</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Harga
                                    </span>
                                    <span class="sc-value" id="summary_harga">Rp 0</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Diskon
                                    </span>
                                    <span class="sc-value" id="summary_diskon">Rp 0</span>
                                </div>
                                <div class="sc-row sc-total">
                                    <span class="sc-label">Total Bayar</span>
                                    <span class="sc-value" id="summary_total">Rp 0</span>
                                </div>
                            </div>

                            <!-- ═══ Actions ═══ -->
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-check"></i> Konfirmasi Booking
                                </button>
                                <a href="{{ route('pelanggan.booking') }}" class="btn-cancel-form">
                                    <i class="fa-solid fa-xmark"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateHarga() {
        const select = document.getElementById('id_layanan');
        const selected = select.options[select.selectedIndex];
        const harga = selected ? selected.getAttribute('data-harga') : 0;

        const display = document.getElementById('harga_display');
        display.value = harga ? formatRupiah(parseInt(harga)) : '';
        display.style.color = harga ? 'var(--dark)' : '#bbb';
        document.getElementById('harga').value = harga || 0;

        const namaLayanan = selected && selected.value ? selected.text.split(' — ')[0] : '—';
        document.getElementById('summary_layanan').textContent = namaLayanan;
        document.getElementById('summary_harga').textContent = formatRupiah(parseInt(harga || 0));

        updateSubtotal();
    }

    function updateSubtotal() {
        const harga = parseInt(document.getElementById('harga').value || 0);
        const diskon = parseInt(document.getElementById('diskon').value || 0);
        const total = Math.max(0, harga - diskon);

        document.getElementById('summary_diskon').textContent = formatRupiah(diskon);
        document.getElementById('summary_total').textContent = formatRupiah(total);
    }

    // Set default time
    document.addEventListener('DOMContentLoaded', function() {
        const jamInput = document.querySelector('input[name="jam"]');
        if (jamInput && !jamInput.value) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            jamInput.value = hours + ':' + minutes;
        }
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
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
