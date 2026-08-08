<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Booking - BeautyCare</title>
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
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-back .hb-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    /* ─── Status Header Badge ─── */
    .status-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .status-header-badge .shb-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .status-header-badge.menunggu { background: #FEF3C7; color: #D97706; }
    .status-header-badge.menunggu .shb-dot { background: #D97706; }
    .status-header-badge.dikonfirmasi { background: #DBEAFE; color: #2563EB; }
    .status-header-badge.dikonfirmasi .shb-dot { background: #2563EB; }
    .status-header-badge.diproses { background: #F3E8FF; color: #9333EA; }
    .status-header-badge.diproses .shb-dot { background: #9333EA; }
    .status-header-badge.selesai { background: #D1FAE5; color: #059669; }
    .status-header-badge.selesai .shb-dot { background: #059669; }
    .status-header-badge.dibatalkan { background: #FEE2E2; color: #DC2626; }
    .status-header-badge.dibatalkan .shb-dot { background: #DC2626; }

    /* ─── Info Banner ─── */
    .info-banner {
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(255, 79, 135, 0.1);
    }

    .info-banner .ib-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 79, 135, 0.15);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-banner .ib-text {
        font-size: 13px;
        color: var(--gray);
        line-height: 1.5;
    }

    .info-banner .ib-text strong {
        color: var(--dark);
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
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
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

    @media (max-width: 768px) {
        .form-card-premium .fcp-body { padding: 20px; }
        .header-back .hb-text h3 { font-size: 16px; flex-wrap: wrap; }
        .header-back { flex-wrap: wrap; gap: 12px; }
        .form-card-premium .fcp-section-sub { margin-left: 0; }
        .form-actions { flex-wrap: wrap; }
        .form-actions .btn-cancel-form { flex: 1; min-width: 140px; }
    }

    @media (max-width: 576px) {
        .form-card-premium .fcp-body { padding: 16px; }
    }

    .custom-select-wrap {
        position: relative;
    }

    .custom-select-trigger {
        width: 100%;
        padding: 11px 16px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        color: var(--dark);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        transition: all 0.2s ease;
        user-select: none;
        box-sizing: border-box;
    }

    .custom-select-trigger:hover {
        border-color: #d0d0d0;
    }

    .custom-select-trigger.open {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1);
    }

    .custom-select-trigger .cst-placeholder {
        color: #bbb;
    }

    .custom-select-trigger .cst-text {
        color: var(--dark);
    }

    .custom-select-trigger .cst-arrow {
        font-size: 11px;
        color: #999;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    .custom-select-trigger.open .cst-arrow {
        transform: rotate(180deg);
    }

    .custom-select-dropdown {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        z-index: 100;
        display: none;
        overflow: hidden;
        max-height: 180px;
        overflow-y: auto;
    }

    .custom-select-dropdown.open {
        display: block;
    }

    .custom-select-dropdown .csd-item {
        padding: 10px 16px;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.15s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        color: var(--dark);
    }

    .custom-select-dropdown .csd-item:hover {
        background: var(--hover);
    }

    .custom-select-dropdown .csd-item.selected {
        background: var(--hover);
        color: var(--primary);
        font-weight: 600;
    }

    .custom-select-dropdown .csd-item .csd-price {
        color: var(--gray);
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    .custom-select-dropdown .csd-item.selected .csd-price {
        color: var(--primary);
    }

    .custom-select-dropdown .csd-item.cs-item-disabled {
        opacity: 0.55;
        cursor: not-allowed;
        background: #FAFAFA;
        pointer-events: none;
    }

    .custom-select-dropdown .csd-item.cs-item-disabled:hover {
        background: #FAFAFA;
    }

    .custom-select-dropdown .csd-item .csd-status {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 100px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .custom-select-dropdown .csd-item .csd-status.cs-status-busy {
        background: #FEE2E2;
        color: #DC2626;
        border: 1px solid #FECACA;
    }

    .custom-select-dropdown .csd-item .csd-status.cs-status-free {
        background: #D1FAE5;
        color: #059669;
        border: 1px solid #A7F3D0;
    }

    .custom-select-dropdown::-webkit-scrollbar {
        width: 5px;
    }

    .custom-select-dropdown::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-select-dropdown::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
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
                        <h3>
                            Edit Booking #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}
                            @php
                                $statusBadge = [
                                    'menunggu' => 'menunggu',
                                    'dikonfirmasi' => 'dikonfirmasi',
                                    'diproses' => 'diproses',
                                    'selesai' => 'selesai',
                                    'dibatalkan' => 'dibatalkan',
                                ][$booking->status] ?? 'menunggu';
                            @endphp
                            <span class="status-header-badge {{ $statusBadge }}">
                                <span class="shb-dot"></span>
                                {{ ucfirst($booking->status) }}
                            </span>
                        </h3>
                        <p>Ubah detail booking treatment Anda sesuai kebutuhan</p>
                    </div>
                </div>

                <!-- ═══ Info Banner ═══ -->
                <div class="info-banner">
                    <div class="ib-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div class="ib-text">
                        <strong>Informasi:</strong> Anda hanya dapat mengubah terapis, jadwal, dan catatan booking. Untuk perubahan layanan, silakan hubungi kami.
                    </div>
                </div>

                <!-- ═══ Error Alert ═══ -->
                @if($errors->any())
                <div class="alert-error-premium">
                    <div class="ae-icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- ═══ Form Card Premium ═══ -->
                <form action="{{ route('pelanggan.booking.update', $booking->id_booking) }}" method="POST" id="bookingForm">
                    @csrf
                    @method('PUT')

                    <div class="form-card-premium">
                        <div class="fcp-body">
                            <!-- Section 1: Layanan & Terapis -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-spa"></i></span>
                                Layanan & Terapis
                            </div>
                            <div class="fcp-section-sub">Pilih treatment dan beauty therapist favorit Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-solid fa-spa fg-label-icon"></i>
                                        Layanan Treatment <span class="fg-required">*</span>
                                    </label>
                                    <select name="id_layanan" id="id_layanan" required style="display:none">
                                        <option value="">— Pilih Layanan —</option>
                                        @foreach($layanans as $layanan)
                                        <option value="{{ $layanan->id_layanan }}"
                                            data-harga="{{ $layanan->harga }}"
                                            {{ $detail && $detail->id_layanan == $layanan->id_layanan ? 'selected' : '' }}>
                                            {{ $layanan->nm_layanan }} — Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="custom-select-wrap" id="customLayananWrap">
                                        <div class="custom-select-trigger" id="customLayananTrigger">
                                            <span class="cst-placeholder">— Pilih Layanan —</span>
                                            <span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                                        </div>
                                        <div class="custom-select-dropdown" id="customLayananDropdown"></div>
                                    </div>
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-user fg-label-icon"></i>
                                        Pilih Terapis <span class="fg-required">*</span>
                                    </label>
                                    <select name="id_karyawan" id="id_karyawan" required style="display:none">
                                        <option value="">— Pilih Terapis —</option>
                                        @foreach($karyawans as $karyawan)
                                        @php
                                            $sibuk = in_array($karyawan->user->id, $karyawanSibukIds ?? []);
                                            $terpilih = $booking->id_karyawan == $karyawan->user->id;
                                        @endphp
                                        <option value="{{ $karyawan->user->id }}" {{ $terpilih ? 'selected' : '' }} {{ ($sibuk && !$terpilih) ? 'disabled' : '' }}>
                                            {{ $karyawan->user->nama }} — {{ $karyawan->jabatan }} — {{ $sibuk ? 'Sedang Melayani' : 'Tersedia' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="custom-select-wrap" id="customTerapisWrap">
                                        <div class="custom-select-trigger" id="customTerapisTrigger">
                                            <span class="cst-placeholder">— Pilih Terapis —</span>
                                            <span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                                        </div>
                                        <div class="custom-select-dropdown" id="customTerapisDropdown"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <!-- Section 2: Jadwal -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-regular fa-calendar"></i></span>
                                Jadwal Treatment
                            </div>
                            <div class="fcp-section-sub">Sesuaikan tanggal dan jam kedatangan Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-calendar-check fg-label-icon"></i>
                                        Tanggal <span class="fg-required">*</span>
                                    </label>
                                    <input type="date" name="tanggal" class="fg-input" required value="{{ $booking->tanggal }}">
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-clock fg-label-icon"></i>
                                        Jam <span class="fg-required">*</span>
                                    </label>
                                    <input type="time" name="jam" class="fg-input" required value="{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}">
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <!-- Section 3: Harga & Catatan -->
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-receipt"></i></span>
                                Harga & Catatan
                            </div>
                            <div class="fcp-section-sub">Informasi harga dan pesan tambahan untuk terapis</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-solid fa-tag fg-label-icon"></i>
                                        Harga
                                    </label>
                                    <input type="text" id="harga_display" class="fg-input" readonly
                                        value="{{ $detail ? 'Rp '.number_format($detail->harga, 0, ',', '.') : '' }}"
                                        placeholder="Pilih layanan terlebih dahulu"
                                        style="background:#F5F5F5;">
                                    <input type="hidden" name="harga" id="harga" value="{{ $detail ? $detail->harga : 0 }}">
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-circle-down fg-label-icon"></i>
                                        Diskon Member <span id="diskonLabel">({{ $diskonMember }}%)</span>
                                    </label>
                                    <input type="number" name="diskon" id="diskon" class="fg-input" value="{{ $detail ? $detail->diskon : 0 }}" min="0" readonly style="background:#F5F5F5;cursor:not-allowed;">
                                </div>
                            </div>

                            <div class="fg-premium" style="margin-top:20px;">
                                <label class="fg-label">
                                    <i class="fa-regular fa-note-sticky fg-label-icon"></i>
                                    Catatan
                                </label>
                                <textarea name="catatan" class="fg-input" rows="3" placeholder="Tambahkan catatan khusus untuk terapis...">{{ $booking->catatan }}</textarea>
                            </div>

                            <!-- ═══ Summary Card ═══ -->
                            <div class="summary-card-premium">
                                <div class="sc-title">
                                    <i class="fa-solid fa-receipt"></i>
                                    Ringkasan Booking
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Layanan
                                    </span>
                                    <span class="sc-value" id="summary_layanan" style="font-weight:500;color:var(--gray);">{{ $detail && $detail->layanan ? $detail->layanan->nm_layanan : '—' }}</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Harga
                                    </span>
                                    <span class="sc-value" id="summary_harga">{{ $detail ? 'Rp '.number_format($detail->harga, 0, ',', '.') : 'Rp 0' }}</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Diskon
                                    </span>
                                    <span class="sc-value" id="summary_diskon">{{ $detail ? 'Rp '.number_format($detail->diskon, 0, ',', '.') : 'Rp 0' }}</span>
                                </div>
                                <div class="sc-row sc-total">
                                    <span class="sc-label">Total Bayar</span>
                                    <span class="sc-value" id="summary_total">{{ $detail ? 'Rp '.number_format($detail->subtotal, 0, ',', '.') : 'Rp 0' }}</span>
                                </div>
                            </div>

                            <!-- ═══ Actions ═══ -->
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-check"></i> Simpan Perubahan
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
    var diskonPersen = {{ $diskonMember }};

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungDiskon(harga) {
        return Math.round(harga * diskonPersen / 100);
    }

    function updateHarga() {
        const select = document.getElementById('id_layanan');
        const selected = select.options[select.selectedIndex];
        const harga = selected ? parseInt(selected.getAttribute('data-harga')) : 0;

        const display = document.getElementById('harga_display');
        display.value = harga ? formatRupiah(harga) : '';
        display.style.color = harga ? 'var(--dark)' : '#bbb';
        document.getElementById('harga').value = harga || 0;

        const diskon = hitungDiskon(harga);
        document.getElementById('diskon').value = diskon;

        const namaLayanan = selected && selected.value ? selected.text.split(' — ')[0] : '—';
        document.getElementById('summary_layanan').textContent = namaLayanan;
        document.getElementById('summary_harga').textContent = formatRupiah(harga);

        updateSubtotal();
    }

    function updateSubtotal() {
        const harga = parseInt(document.getElementById('harga').value || 0);
        const diskon = parseInt(document.getElementById('diskon').value || 0);
        const total = Math.max(0, harga - diskon);

        document.getElementById('summary_diskon').textContent = formatRupiah(diskon);
        document.getElementById('summary_total').textContent = formatRupiah(total);
    }

    function initCustomSelect(selectId, wrapId, triggerId, dropdownId, onChange, showStatus) {
        const select = document.getElementById(selectId);
        const wrap = document.getElementById(wrapId);
        const trigger = document.getElementById(triggerId);
        const dropdown = document.getElementById(dropdownId);
        const placeholder = trigger.querySelector('.cst-placeholder');
        if (!select || !wrap || !trigger || !dropdown) return;

        function buildList() {
            let html = '';
            for (let i = 0; i < select.options.length; i++) {
                const opt = select.options[i];
                if (!opt.value) {
                    html += '<div class="csd-item" data-value="" data-harga="0"><span>' + opt.text + '</span></div>';
                } else {
                    const parts = opt.text.split(' — ');
                    const name = parts[0] || opt.text;
                    const price = parts[1] || '';
                    const harga = opt.getAttribute('data-harga') || '0';
                    const status = showStatus && parts[2] ? parts[2].trim() : '';
                    const isDisabled = !!opt.disabled;
                    html += '<div class="csd-item' + (isDisabled ? ' cs-item-disabled' : '') + '" data-value="' + opt.value + '" data-harga="' + harga + '"' + (isDisabled ? ' data-disabled="1"' : '') + '>';
                    html += '<span>' + name + '</span>';
                    if (status) {
                        html += '<span class="csd-status ' + (status === 'Sedang Melayani' ? 'cs-status-busy' : 'cs-status-free') + '">' + status + '</span>';
                    } else if (price) {
                        html += '<span class="csd-price">' + price + '</span>';
                    }
                    html += '</div>';
                }
            }
            dropdown.innerHTML = html;
        }

        function updateTrigger() {
            const idx = select.selectedIndex;
            if (idx > 0 && select.options[idx]) {
                const opt = select.options[idx];
                const parts = opt.text.split(' — ');
                trigger.innerHTML = '<span class="cst-text">' + (parts[0] || opt.text) + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
            } else {
                const txt = placeholder ? placeholder.textContent : '— Pilih —';
                trigger.innerHTML = '<span class="cst-placeholder">' + txt + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
            }
            if (onChange) onChange();

            const items = dropdown.querySelectorAll('.csd-item');
            items.forEach(function(item) {
                item.classList.toggle('selected', item.getAttribute('data-value') === select.value);
            });
        }

        function selectItem(el) {
            if (el.getAttribute('data-disabled')) return;
            const val = el.getAttribute('data-value');
            const harga = el.getAttribute('data-harga');
            select.value = val;
            if (select.getAttribute('data-harga')) {
                select.setAttribute('data-harga', harga);
            }
            updateTrigger();
        }

        buildList();
        updateTrigger();

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const open = dropdown.classList.contains('open');
            document.querySelectorAll('.custom-select-dropdown.open').forEach(function(d) {
                if (d.id !== dropdownId) d.classList.remove('open');
            });
            document.querySelectorAll('.custom-select-trigger.open').forEach(function(t) {
                if (t.id !== triggerId) t.classList.remove('open');
            });
            dropdown.classList.toggle('open');
            trigger.classList.toggle('open');
        });

        dropdown.addEventListener('click', function(e) {
            const item = e.target.closest('.csd-item');
            if (!item) return;
            selectItem(item);
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
        });

        document.addEventListener('click', function() {
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCustomSelect('id_layanan', 'customLayananWrap', 'customLayananTrigger', 'customLayananDropdown', updateHarga);
        initCustomSelect('id_karyawan', 'customTerapisWrap', 'customTerapisTrigger', 'customTerapisDropdown', null, true);
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
