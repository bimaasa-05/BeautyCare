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

    .custom-select-dropdown.open-up {
        top: auto;
        bottom: calc(100% + 4px);
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

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
        .form-card-premium .fcp-body { padding: 20px; }
        .steps-indicator .step-item span { display: none; }
        .header-back { flex-wrap: wrap; gap: 12px; }
        .header-back .hb-text h3 { font-size: 17px; }
        .form-card-premium .fcp-section-sub { margin-left: 0; }
        .form-actions { flex-wrap: wrap; }
        .form-actions .btn-cancel-form { flex: 1; min-width: 140px; }
    }

    @media (max-width: 576px) {
        .form-card-premium .fcp-body { padding: 16px; }
        .steps-indicator .step-item { padding: 8px 10px; }
        .steps-indicator .step-num { width: 20px; height: 20px; font-size: 10px; }
    }

    /* ─── Calendar Popup ─── */
    .date-field-wrap {
        position: relative;
    }

    .date-calendar-popup {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        width: 100%;
        min-width: 280px;
        max-width: 340px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #FFD6E6;
        box-shadow: 0 12px 40px rgba(255, 79, 135, 0.15);
        z-index: 120;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
        transform-origin: top center;
        animation: curtainUnroll 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
    }

    .date-calendar-popup.open {
        display: block;
    }

    .date-calendar-popup.open-up {
        top: auto;
        bottom: calc(100% + 6px);
        transform-origin: bottom center;
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
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            min-width: 0;
            width: calc(100vw - 40px);
            max-width: 340px;
            max-height: calc(100vh - 16px);
            overflow-y: auto;
            top: auto;
            bottom: auto;
            animation: curtainUnrollMobile 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
    }

    @keyframes curtainUnrollMobile {
        0%   { transform: translateX(-50%) scaleY(0); opacity: 0.2; }
        55%  { transform: translateX(-50%) scaleY(1.03); opacity: 1; }
        100% { transform: translateX(-50%) scaleY(1); opacity: 1; }
    }

    .dcp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .dcp-header h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .dcp-header .dcp-nav {
        display: flex;
        gap: 4px;
    }

    .dcp-header .dcp-nav button {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 8px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .dcp-header .dcp-nav button:hover {
        background: #FFD9E7;
    }

    .dcp-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 4px;
    }

    .dcp-weekdays span {
        text-align: center;
        font-size: 10px;
        font-weight: 700;
        color: #9CA3AF;
        padding: 4px 0;
        text-transform: uppercase;
    }

    .dcp-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .dcp-days .dcp-day {
        aspect-ratio: 1;
        position: relative;
        border: none;
        border-radius: 9px;
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        color: var(--gray);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        padding: 0;
        line-height: 1;
    }

    .dcp-days .dcp-day:hover {
        background: var(--hover);
    }

    .dcp-days .dcp-day .dcp-count {
        font-size: 8px;
        font-weight: 700;
        color: var(--primary);
        margin-top: 2px;
        line-height: 1;
    }

    .dcp-days .dcp-day.today {
        background: var(--hover);
        color: var(--dark);
        box-shadow: inset 0 0 0 1.5px rgba(255, 79, 135, 0.45);
    }

    .dcp-days .dcp-day.today:hover {
        background: #FFD9E7;
    }

    .dcp-days .dcp-day.has-count {
        background: #FFE3EE;
        color: var(--dark);
    }

    .dcp-days .dcp-day.has-count:hover {
        background: #FFD9E7;
    }

    .dcp-days .dcp-day.selected {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 3px 10px rgba(255, 79, 135, 0.35);
    }

    .dcp-days .dcp-day.selected:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
    }

    .dcp-days .dcp-day.selected .dcp-count {
        color: #FFD6E6;
    }

    /* Tanggal lampau: tampilan pudar */
    .dcp-days .dcp-day.past {
        color: #B9C0CE;
        opacity: 0.55;
        cursor: pointer;
    }

    .dcp-days .dcp-day.past:hover {
        background: #EEF0F5;
    }

    .dcp-days .dcp-day.past.has-count {
        background: #F5F6FA;
        color: #B9C0CE;
    }

    .dcp-days .dcp-day.past.has-count:hover {
        background: #EDEFF4;
    }

    .dcp-days .dcp-day.past .dcp-count {
        color: #B9C0CE;
    }

    /* Feedback klik pada tanggal lampau (hanya tampilan, tidak bisa dipilih) */
    .dcp-days .dcp-day.past-click {
        background: #FFE3EE;
        color: var(--primary);
        opacity: 1;
        box-shadow: inset 0 0 0 1.5px rgba(255, 79, 135, 0.4);
    }

    .dcp-days .dcp-day.past-click .dcp-count {
        color: var(--primary);
    }

    .dcp-summary {
        display: none;
        margin-top: 14px;
        padding: 12px 16px;
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 100%);
        border: 1px solid rgba(255, 79, 135, 0.1);
        border-radius: 12px;
        text-align: center;
    }

    .dcp-summary.visible {
        display: block;
    }

    .dcp-summary .dcp-summary-date {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        margin-bottom: 2px;
    }

    .dcp-summary .dcp-summary-total {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
    }

    .dcp-summary .dcp-summary-meta {
        font-size: 10px;
        color: #9CA3AF;
    }

    .dcp-footer {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }

    .dcp-today {
        flex: 1;
        padding: 10px;
        border: 1.5px solid var(--primary);
        border-radius: 12px;
        background: #fff;
        color: var(--primary);
        font-size: 13px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .dcp-today:hover {
        background: var(--hover);
    }

    .dcp-oke {
        display: none;
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(255, 79, 135, 0.3);
    }

    .dcp-oke:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255, 79, 135, 0.4);
    }

    /* ─── Selected Services Table ─── */
    .selected-table-scroll {
        display: block;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-x: contain;
        border: 1px solid var(--border);
        border-radius: 12px;
        scrollbar-width: thin;
        scrollbar-color: #FFB6CE #FFF1F6;
    }

    .selected-table-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .selected-table-scroll::-webkit-scrollbar-track {
        background: #FFF1F6;
        border-radius: 8px;
    }

    .selected-table-scroll::-webkit-scrollbar-thumb {
        background: #FFB6CE;
        border-radius: 8px;
    }

    .selected-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #FF7BA5;
    }

    .selected-table-scroll .services-table {
        display: table;
        width: max-content;
        min-width: 100%;
        border-collapse: collapse;
    }

    .selected-table-scroll th,
    .selected-table-scroll td {
        white-space: nowrap;
    }

    #selectedServicesBody td {
        white-space: nowrap;
    }

    /* ─── Fix: biarkan flex item menyusut supaya scroll tabel berfungsi ─── */
    .main-content {
        min-width: 0;
    }

    .dashboard-content {
        min-width: 0;
    }

    /* ─── Swipe Hint (mobile/tablet) ─── */
    .selected-swipe-hint {
        display: none;
        margin-top: 8px;
        font-size: 11px;
        color: var(--gray);
        text-align: right;
    }

    .selected-swipe-hint i {
        color: var(--primary);
        margin-right: 4px;
    }

    @media (max-width: 768px) {
        .selected-swipe-hint {
            display: block;
        }
    }

    /* ─── Bubble Click Effect ─── */
    .bubble-effect {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.5) 0%, rgba(255, 79, 135, 0.18) 55%, transparent 75%);
        border: 1.5px solid rgba(255, 79, 135, 0.35);
        transform: translate(-50%, -50%) scale(0);
        pointer-events: none;
        animation: bubblePop 0.7s ease-out forwards;
        z-index: 130;
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
                        <i class="fa-solid fa-circle-exclamation"></i>
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
                                <span class="fcp-st-icon"><i class="fa-solid fa-spa"></i></span>
                                Layanan & Terapis
                            </div>
                            <div class="fcp-section-sub">Pilih treatment dan beauty therapist favorit Anda</div>

                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-user fg-label-icon"></i>
                                        Pilih Terapis <span class="fg-required">*</span>
                                    </label>
                                    <select name="id_karyawan" id="id_karyawan" required style="display:none">
                                        <option value="">— Pilih Terapis —</option>
                                        @foreach($karyawans as $karyawan)
                                        @php $sibuk = in_array($karyawan->user->id, $karyawanSibukIds ?? []); @endphp
                                        <option value="{{ $karyawan->user->id }}" {{ $sibuk ? 'disabled' : '' }}>
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
                                    @if($karyawans->isNotEmpty() && count($karyawanSibukIds ?? []) >= $karyawans->count())
                                    <div style="margin-top:8px;padding:10px 14px;border-radius:10px;background:#FEF2F2;border:1px solid #FECACA;font-size:12px;color:#B91C1C;display:flex;align-items:center;gap:8px;">
                                        <i class="fa-solid fa-circle-info"></i> Semua terapis sedang melayani pelanggan lain. Silakan tunggu hingga ada terapis yang tersedia.
                                    </div>
                                    @endif
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-solid fa-spa fg-label-icon"></i>
                                        Tambah Layanan <span class="fg-required">*</span>
                                    </label>
                                    <div style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;min-width:0;">
                                        <div style="flex:1 1 200px;min-width:0;">
                                            <select id="id_layanan_picker" style="display:none">
                                                <option value="">— Pilih Layanan —</option>
                                                @foreach($layanans as $layanan)
                                                <option value="{{ $layanan->id_layanan }}" data-harga="{{ $layanan->harga }}">
                                                    {{ $layanan->nm_layanan }} (± {{ $layanan->durasi }} menit) — Rp {{ number_format($layanan->harga, 0, ',', '.') }}
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
                                        <button type="button" id="btnTambahLayanan" class="fg-premium" style="padding:11px 18px;border-radius:12px;border:1.5px solid var(--primary);background:var(--primary);color:#fff;font-size:13px;font-weight:600;cursor:pointer;font-family:'Poppins',sans-serif;display:flex;align-items:center;gap:6px;white-space:nowrap;flex-shrink:0;margin-top:0;">
                                            <i class="fa-solid fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div style="margin-top:8px;">
                                        <span style="font-size:11px;color:var(--gray);"><i class="fa-solid fa-circle-info"></i> Pilih layanan lalu klik <strong>Tambah</strong> untuk menambahkan ke daftar</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Daftar Layanan Terpilih -->
                            <div id="selectedServicesWrap" style="margin-top:16px;display:none;">
                                <div class="selected-table-scroll" style="overflow-x:auto;-webkit-overflow-scrolling:touch;max-width:100%;width:100%;">
                                <table class="services-table" style="width:max-content;min-width:100%;border-collapse:collapse;">
                                    <thead>
                                        <tr style="background:#FFF7FA;">
                                            <th style="text-align:left;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">No</th>
                                            <th style="text-align:left;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">Layanan</th>
                                            <th style="text-align:right;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">Harga</th>
                                            <th style="text-align:right;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">Diskon</th>
                                            <th style="text-align:right;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">Subtotal</th>
                                            <th style="text-align:center;padding:10px 14px;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;border-bottom:1px solid var(--border);">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectedServicesBody"></tbody>
                                </table>
                                </div>
                                <div class="selected-swipe-hint" id="selectedSwipeHint">
                                    <i class="fa-solid fa-arrows-left-right"></i> Geser ke kanan-kiri untuk melihat semua kolom
                                </div>
                            </div>
                            <div id="noServicesMsg" style="margin-top:12px;padding:20px;text-align:center;background:#FAFAFA;border-radius:12px;border:1px dashed var(--border);">
                                <i class="fa-solid fa-spa" style="font-size:24px;color:#ddd;display:block;margin-bottom:8px;"></i>
                                <span style="font-size:13px;color:var(--gray);">Belum ada layanan dipilih. Pilih layanan di atas lalu klik <strong>Tambah</strong>.</span>
                            </div>

                            <div id="layananHiddenInputs"></div>

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
                                    <div class="date-field-wrap">
                                        <input type="date" name="tanggal" id="tanggalInput" class="fg-input" required min="{{ date('Y-m-d') }}">
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
                                    <div style="margin-top:6px;">
                                        <span style="font-size:10px;color:#9CA3AF;"><i class="fa-regular fa-calendar"></i> Klik ikon tanggal untuk melihat kalender riwayat treatment Anda</span>
                                    </div>
                                </div>

                                <div class="fg-premium">
                                    <label class="fg-label">
                                        <i class="fa-regular fa-clock fg-label-icon"></i>
                                        Jam <span class="fg-required">*</span>
                                    </label>
                                    <select name="jam" id="jamSlot" class="fg-input" required>
                                        <option value="">— Pilih Jam —</option>
                                        @foreach($slotJam as $jam)
                                        <option value="{{ $jam }}">{{ \App\Support\BookingSlot::formatJamIndo($jam) }}</option>
                                        @endforeach
                                    </select>
                                    <div style="margin-top:6px;font-size:11px;color:var(--gray);">
                                        <i class="fa-solid fa-circle-info"></i> Slot yang sudah dibooking terapis (termasuk durasi layanan) otomatis dinonaktifkan
                                    </div>
                                </div>
                            </div>

                            @if($claimedPromos->isNotEmpty())
                            <div class="fcp-divider"></div>
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-tag"></i></span>
                                Promo
                            </div>
                            <div class="fcp-section-sub">Gunakan promo yang sudah Anda klaim</div>
                            <div class="fcp-grid">
                                <div class="fg-premium">
                                    <select name="id_promo" id="id_promo" style="display:none">
                                        <option value="">— Tanpa Promo —</option>
                                        @foreach($claimedPromos as $cp)
                                        <option value="{{ $cp->id_promo }}" data-jenis="{{ $cp->promo->jenis_promo }}" data-nilai="{{ $cp->promo->nilai }}" data-layanan="{{ $cp->promo->promoLayanan->pluck('id_layanan')->implode(',') }}" data-label="{{ $cp->promo->nm_promo }} ({{ $cp->promo->jenis_promo == 'Diskon' ? $cp->promo->nilai.'%' : 'Rp '.number_format($cp->promo->nilai,0,',','.') }})">
                                            {{ $cp->promo->nm_promo }} ({{ $cp->promo->jenis_promo == 'Diskon' ? $cp->promo->nilai.'%' : 'Rp '.number_format($cp->promo->nilai,0,',','.') }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="custom-select-wrap" id="customPromoWrap">
                                        <div class="custom-select-trigger" id="customPromoTrigger">
                                            <span class="cst-placeholder">— Tanpa Promo —</span>
                                            <span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                                        </div>
                                        <div class="custom-select-dropdown" id="customPromoDropdown"></div>
                                    </div>
                                </div>
                            </div>
                            @endif

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
                                    <i class="fa-solid fa-receipt"></i>
                                    Ringkasan Booking
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Jumlah Layanan
                                    </span>
                                    <span class="sc-value" id="summary_jumlah" style="font-weight:500;color:var(--gray);">0</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Total Harga
                                    </span>
                                    <span class="sc-value" id="summary_harga">Rp 0</span>
                                </div>
                                <div class="sc-row">
                                    <span class="sc-label">
                                        <span class="sc-dot"></span>
                                        Total Diskon
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
    var diskonPersen = {{ $diskonMember }};
    var selectedServices = [];

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungDiskon(harga, idLayanan) {
        const promoSelect = document.getElementById('id_promo');
        if (promoSelect && promoSelect.value) {
            const selected = promoSelect.options[promoSelect.selectedIndex];
            const jenis = selected.getAttribute('data-jenis');
            const nilai = parseFloat(selected.getAttribute('data-nilai'));
            const layananList = (selected.getAttribute('data-layanan') || '')
                .split(',').map(Number).filter(function (n) { return n; });
            if (layananList.length && layananList.indexOf(parseInt(idLayanan)) === -1) {
                return 0;
            }
            if (jenis === 'Diskon') {
                return Math.round(harga * nilai / 100);
            }
            return Math.round(Math.min(nilai, harga));
        }
        return Math.round(harga * diskonPersen / 100);
    }

    function tambahLayanan() {
        const select = document.getElementById('id_layanan_picker');
        if (!select.value) {
            alert('Silakan pilih layanan terlebih dahulu.');
            return;
        }
        const opt = select.options[select.selectedIndex];
        const id = parseInt(select.value);
        const nama = opt.text.split(' — ')[0];
        const harga = parseInt(opt.getAttribute('data-harga'));

        if (selectedServices.some(s => s.id_layanan === id)) {
            alert('Layanan "' + nama + '" sudah ditambahkan.');
            return;
        }

        selectedServices.push({ id_layanan: id, nama: nama, harga: harga });
        renderSelectedServices();
        updateSummary();
        resetLayananPicker();
    }

    function hapusLayanan(index) {
        selectedServices.splice(index, 1);
        renderSelectedServices();
        updateSummary();
    }

    function renderSelectedServices() {
        const tbody = document.getElementById('selectedServicesBody');
        const wrap = document.getElementById('selectedServicesWrap');
        const noMsg = document.getElementById('noServicesMsg');
        const hiddenContainer = document.getElementById('layananHiddenInputs');

        tbody.innerHTML = '';
        hiddenContainer.innerHTML = '';

        if (selectedServices.length === 0) {
            wrap.style.display = 'none';
            noMsg.style.display = 'block';
            return;
        }

        wrap.style.display = 'block';
        noMsg.style.display = 'none';
        void wrap.offsetHeight;

        const hint = document.getElementById('selectedSwipeHint');
        if (hint) hint.style.display = (window.innerWidth <= 768) ? 'block' : 'none';

        selectedServices.forEach(function(svc, i) {
            const diskon = hitungDiskon(svc.harga, svc.id_layanan);
            const subtotal = svc.harga - diskon;

            var row = document.createElement('tr');
            row.style.borderBottom = '1px solid var(--border)';
            row.innerHTML =
                '<td style="padding:10px 14px;font-size:13px;color:var(--gray);">' + (i + 1) + '</td>' +
                '<td style="padding:10px 14px;font-size:13px;font-weight:600;color:var(--dark);">' + svc.nama + '</td>' +
                '<td style="padding:10px 14px;font-size:13px;text-align:right;color:var(--dark);">' + formatRupiah(svc.harga) + '</td>' +
                '<td style="padding:10px 14px;font-size:13px;text-align:right;color:#DC2626;">- ' + formatRupiah(diskon) + '</td>' +
                '<td style="padding:10px 14px;font-size:13px;text-align:right;font-weight:600;color:var(--dark);">' + formatRupiah(subtotal) + '</td>' +
                '<td style="padding:10px 14px;text-align:center;"><button type="button" onclick="hapusLayanan(' + i + ')" style="background:none;border:none;color:#EF4444;cursor:pointer;font-size:15px;padding:4px;" title="Hapus"><i class="fa-regular fa-trash-can"></i></button></td>';
            tbody.appendChild(row);

            // Hidden inputs
            var inpId = document.createElement('input');
            inpId.type = 'hidden';
            inpId.name = 'id_layanan[]';
            inpId.value = svc.id_layanan;
            hiddenContainer.appendChild(inpId);

            var inpHarga = document.createElement('input');
            inpHarga.type = 'hidden';
            inpHarga.name = 'harga[]';
            inpHarga.value = svc.harga;
            hiddenContainer.appendChild(inpHarga);

            var inpDiskon = document.createElement('input');
            inpDiskon.type = 'hidden';
            inpDiskon.name = 'diskon[]';
            inpDiskon.value = diskon;
            hiddenContainer.appendChild(inpDiskon);
        });
    }

    function updateSummary() {
        var totalHarga = 0;
        var totalDiskon = 0;

        selectedServices.forEach(function(svc) {
            var diskon = hitungDiskon(svc.harga, svc.id_layanan);
            totalHarga += svc.harga;
            totalDiskon += diskon;
        });

        var totalBayar = Math.max(0, totalHarga - totalDiskon);

        document.getElementById('summary_jumlah').textContent = selectedServices.length + ' layanan';
        document.getElementById('summary_harga').textContent = formatRupiah(totalHarga);
        document.getElementById('summary_diskon').textContent = formatRupiah(totalDiskon);
        document.getElementById('summary_total').textContent = formatRupiah(totalBayar);
    }

    function resetLayananPicker() {
        const select = document.getElementById('id_layanan_picker');
        select.value = '';
        const trigger = document.getElementById('customLayananTrigger');
        var ph = trigger.querySelector('.cst-placeholder');
        if (ph) {
            trigger.innerHTML = '<span class="cst-placeholder">— Pilih Layanan —</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
        }
    }

    // ─── Custom Select Dropdown ───
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
                const isDisabled = opt.disabled;
                const cls = isDisabled ? ' csd-disabled' : '';
                const attr = isDisabled ? ' data-disabled="1"' : '';
                const stl = isDisabled ? ' style="opacity:.6;cursor:not-allowed;"' : '';
                if (!opt.value) {
                    html += '<div class="csd-item' + cls + '" data-value="" data-harga="0"' + attr + stl + '><span>' + opt.text + '</span></div>';
                } else if (isDisabled) {
                    const info = opt.getAttribute('data-info') || '';
                    html += '<div class="csd-item' + cls + '" data-value="' + opt.value + '" data-harga="0"' + attr + stl + ' title="' + info + '">';
                    html += '<span>' + opt.text.replace(' — Sedang Melayani', '') + '</span>';
                    html += '<span class="csd-price" style="color:#DC2626;font-weight:600;">● Sedang Melayani</span>';
                    html += '</div>';
                } else {
                    const parts = opt.text.split(' — ');
                    const name = parts[0] || opt.text;
                    const price = parts[1] || '';
                    const harga = opt.getAttribute('data-harga') || '0';
                    const status = showStatus && parts[2] ? parts[2].trim() : '';
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
            closeDropdown();
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function openDropdown() {
            buildList();
            updateTrigger();
            dropdown.classList.add('open');
            trigger.classList.add('open');
            const rect = dropdown.getBoundingClientRect();
            const flip = rect.bottom > window.innerHeight - 8 && rect.top > window.innerHeight / 2;
            dropdown.classList.toggle('open-up', flip);
        }

        function closeDropdown() {
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
        }

        function toggleDropdown(e) {
            e.stopPropagation();
            if (dropdown.classList.contains('open')) {
                closeDropdown();
            } else {
                openDropdown();
            }
        }

        trigger.addEventListener('click', toggleDropdown);

        dropdown.addEventListener('click', function(e) {
            const item = e.target.closest('.csd-item');
            if (item) selectItem(item);
        });

        document.addEventListener('click', function(e) {
            if (!wrap.contains(e.target)) {
                closeDropdown();
            }
        });

        buildList();
        updateTrigger();
    }

    // Set default & init custom select
    const bookedJamByKaryawan = @json($bookedJamByKaryawan);
    const jamSelect = document.getElementById('jamSlot');

    // ─── Calendar Popup (riwayat treatment pelanggan) ───
    const bookingsPerDay = @json($bookingsPerDay);
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const dcpNow = new Date();
    let dcpMonth = dcpNow.getMonth();
    let dcpYear = dcpNow.getFullYear();
    let dcpSelected = null;
    let pastClicked = null;

    const tanggalInput = document.getElementById('tanggalInput');
    const dcpPopup = document.getElementById('dateCalendarPopup');
    const dcpDays = document.getElementById('dcpDays');
    const dcpSummary = document.getElementById('dcpSummary');
    const dcpOke = document.getElementById('dcpOke');
    const dcpToday = document.getElementById('dcpToday');

    function getDataForDate(year, month, day) {
        const key = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
        return bookingsPerDay[key] || { selesai: 0, dibatalkan: 0 };
    }

    function getCountForDate(year, month, day) {
        const data = getDataForDate(year, month, day);
        return (data.selesai || 0) + (data.dibatalkan || 0);
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
                const total = (data.selesai || 0) + (data.dibatalkan || 0);
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
    }

    function showCalendarSummary(day, count, data, isPast) {
        dcpSummary.classList.add('visible');
        document.getElementById('dcpSummaryDate').textContent = day + ' ' + monthNames[dcpMonth] + ' ' + dcpYear;
        document.getElementById('dcpSummaryTotal').textContent = count + ' Treatment';
        const meta = document.getElementById('dcpSummaryMeta');
        if (count > 0) {
            const parts = [];
            if (data.selesai) parts.push(data.selesai + ' Selesai');
            if (data.dibatalkan) parts.push(data.dibatalkan + ' Dibatalkan');
            meta.textContent = parts.join(' · ');
        } else {
            meta.textContent = 'Belum ada treatment pada tanggal ini';
        }
        if (isPast) {
            meta.textContent += ' · tanggal lampau (hanya info)';
        }
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
            if (spaceBelow < popupH + 12 && rect.top > popupH + 12) {
                dcpPopup.style.top = Math.max(8, rect.top - popupH - 6) + 'px';
                dcpPopup.classList.add('open-up');
            } else {
                dcpPopup.style.top = Math.min(rect.bottom + 6, window.innerHeight - popupH - 8) + 'px';
                dcpPopup.classList.remove('open-up');
            }
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

    window.addEventListener('scroll', function() {
        if (dcpPopup.classList.contains('open')) {
            closeCalendarPopup();
        }
    }, { passive: true });

    function updateJamSlots() {
        if (!jamSelect) return;
        const karyawanId = document.getElementById('id_karyawan').value;
        const booked = bookedJamByKaryawan[karyawanId] || [];
        for (let i = 0; i < jamSelect.options.length; i++) {
            const opt = jamSelect.options[i];
            if (!opt.value) continue;
            const penuh = booked.indexOf(opt.value) !== -1;
            opt.disabled = penuh || !karyawanId;
            opt.textContent = opt.value.replace(':', '.') + (penuh ? ' — Sudah Dibooking' : '');
        }
        if (jamSelect.value && jamSelect.options[jamSelect.selectedIndex].disabled) {
            jamSelect.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCustomSelect('id_layanan_picker', 'customLayananWrap', 'customLayananTrigger', 'customLayananDropdown');
        initCustomSelect('id_karyawan', 'customTerapisWrap', 'customTerapisTrigger', 'customTerapisDropdown', function() {
            updateJamSlots();
        }, true);
        updateJamSlots();

        // Tambah Layanan button
        document.getElementById('btnTambahLayanan').addEventListener('click', tambahLayanan);

        window.addEventListener('resize', function() {
            const wrap = document.getElementById('selectedServicesWrap');
            const hint = document.getElementById('selectedSwipeHint');
            if (hint && wrap && wrap.style.display === 'block') {
                hint.style.display = (window.innerWidth <= 768) ? 'block' : 'none';
            }
        });

        const promoSelect = document.getElementById('id_promo');
        if (promoSelect) {
            initCustomSelect('id_promo', 'customPromoWrap', 'customPromoTrigger', 'customPromoDropdown', function() {
                renderSelectedServices();
                updateSummary();
            });
        }

        // Form submit validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            if (selectedServices.length === 0) {
                e.preventDefault();
                alert('Silakan tambah minimal 1 layanan.');
            }
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
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
