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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
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
            background: var(--background);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        /* ============ PAGE HEADER PREMIUM ============ */
        .page-header-premium {
            background:
                radial-gradient(ellipse 480px 220px at 88% -30%, rgba(255, 79, 135, 0.22), transparent 60%),
                radial-gradient(ellipse 380px 200px at -5% 115%, rgba(190, 24, 93, 0.12), transparent 60%),
                linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 45%, #FFD6E6 100%);
            border-radius: 24px;
            padding: 30px 34px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 79, 135, 0.12);
            box-shadow: 0 10px 40px -12px rgba(255, 79, 135, 0.25);
        }

        .page-header-premium::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -50px;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            border: 32px solid rgba(255, 255, 255, 0.35);
            pointer-events: none;
        }

        .page-header-premium::after {
            content: '';
            position: absolute;
            bottom: -55px;
            left: 24%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium .ph-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header-premium .ph-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            box-shadow: 0 8px 24px rgba(255, 79, 135, 0.38), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
            position: relative;
        }

        .page-header-premium .ph-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 22px;
            border: 1px dashed rgba(255, 79, 135, 0.35);
            pointer-events: none;
        }

        .page-header-premium .ph-text h3 {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            margin: 0;
            letter-spacing: -0.3px;
        }

        .page-header-premium .ph-text p {
            font-size: 13px;
            color: #8b6b78;
            margin: 3px 0 0;
        }

        .ph-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #b4899b;
            margin-bottom: 6px;
        }

        .ph-breadcrumb i {
            font-size: 10px;
            color: #d9a8ba;
        }

        .ph-breadcrumb span:last-child {
            color: #db2777;
            font-weight: 600;
        }

        .ph-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 79, 135, 0.18);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            color: #db2777;
            box-shadow: 0 4px 14px rgba(255, 79, 135, 0.12);
        }

        .ph-badge .dot-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            position: relative;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        /* ============ QUICK NAV ============ */
        .quick-nav-wrap {
            position: sticky;
            top: calc(var(--navbar-height) + 10px);
            z-index: 40;
            margin-bottom: 22px;
        }

        .quick-nav {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 8px;
            background: #fff;
            border: 1px solid #FCE7F3;
            border-radius: 18px;
            box-shadow: 0 6px 24px -8px rgba(236, 72, 153, 0.14);
            scrollbar-width: none;
        }

        .quick-nav::-webkit-scrollbar {
            display: none;
        }

        .quick-nav a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            color: #a05f78;
            white-space: nowrap;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .quick-nav a i {
            font-size: 12px;
            color: #f097b4;
            transition: color 0.25s;
        }

        .quick-nav a:hover {
            background: #FFF0F5;
            color: #db2777;
        }

        .quick-nav a.active {
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            box-shadow: 0 6px 16px rgba(255, 79, 135, 0.32);
        }

        .quick-nav a.active i {
            color: #fff;
        }

        /* ============ SETTINGS GRID ============ */
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
            max-width: none;
        }

        @media (min-width: 1024px) {
            .settings-grid {
                grid-template-columns: 1fr 1fr;
            }

            .settings-card--wide {
                grid-column: 1 / -1;
            }
        }

        .settings-card {
            background: #fff;
            border: 1px solid #FDE1EC;
            border-radius: 22px;
            padding: 26px 28px;
            box-shadow: 0 2px 18px rgba(236, 72, 153, 0.07);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;
            animation: cardIn 0.5s ease both;
            scroll-margin-top: calc(var(--navbar-height) + 70px);
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .settings-card:hover {
            box-shadow: 0 14px 40px -10px rgba(236, 72, 153, 0.18);
            transform: translateY(-3px);
            border-color: #F9C4D9;
        }

        .settings-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #FF4F87, #FF7BA6, #FFC2D6);
            opacity: 0.85;
        }

        .settings-card::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .settings-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .card-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(255, 79, 135, 0.28);
        }

        .card-icon svg {
            width: 20px;
            height: 20px;
        }

        .icon-pink {
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            box-shadow: 0 6px 16px rgba(255, 79, 135, 0.3);
        }

        .icon-violet {
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);
        }

        .icon-amber {
            background: linear-gradient(135deg, #F59E0B, #FBBF24);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        }

        .icon-teal {
            background: linear-gradient(135deg, #14B8A6, #2DD4BF);
            box-shadow: 0 6px 16px rgba(20, 184, 166, 0.3);
        }

        .icon-blue {
            background: linear-gradient(135deg, #3B82F6, #60A5FA);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
        }

        .icon-emerald {
            background: linear-gradient(135deg, #10B981, #34D399);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }

        .icon-rose {
            background: linear-gradient(135deg, #F43F5E, #FB7185);
            box-shadow: 0 6px 16px rgba(244, 63, 94, 0.3);
        }

        .icon-indigo {
            background: linear-gradient(135deg, #6366F1, #818CF8);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
        }

        .settings-card-title {
            font-size: 15.5px;
            font-weight: 700;
            color: #1F2937;
            margin: 0;
        }

        .settings-sub {
            font-size: 12px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        /* ============ TOGGLE ROWS ============ */
        .settings-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 13px 14px;
            border-radius: 14px;
            transition: background 0.2s;
            position: relative;
            z-index: 1;
        }

        .settings-toggle-row:hover {
            background: #FFF9FC;
        }

        .settings-toggle-row + .settings-toggle-row {
            border-top: 1px solid #FDF2F7;
        }

        .settings-toggle-text {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-toggle-text .tgl-mini-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #FFF0F5;
            color: #db2777;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .settings-toggle-text p:first-child {
            font-size: 13.5px;
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
            width: 48px;
            height: 26px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            background: #E5E7EB;
            transition: background 0.3s, box-shadow 0.3s;
            flex-shrink: 0;
            outline: none;
        }

        .toggle-btn:hover {
            box-shadow: 0 0 0 4px rgba(229, 231, 235, 0.4);
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #EC4899, #BE185D);
            box-shadow: 0 3px 10px rgba(236, 72, 153, 0.4);
        }

        .toggle-btn.active:hover {
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.15);
        }

        .toggle-btn .toggle-circle {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
            transition: left 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-btn.active .toggle-circle {
            left: 25px;
        }

        .toggle-btn .toggle-circle svg {
            width: 11px;
            height: 11px;
            color: transparent;
            transition: color 0.2s;
        }

        .toggle-btn.active .toggle-circle svg {
            color: #EC4899;
        }

        /* ============ FIELDS ============ */
        .salon-field-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field-span-2 {
            grid-column: span 2;
        }

        @media (max-width: 639px) {
            .salon-field-grid>div {
                grid-column: 1 / -1;
            }
        }

        @media (min-width: 640px) {
            .salon-field-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (min-width: 1024px) {
            .salon-field-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .settings-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10.5px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            margin-bottom: 7px;
            letter-spacing: 0.5px;
        }

        .settings-label i {
            font-size: 10px;
            color: #f0a1bd;
        }

        .settings-input {
            width: 100%;
            padding: 11px 14px;
            background: #FFF9FC;
            border: 1.5px solid #FDE1EC;
            border-radius: 13px;
            font-size: 13px;
            color: #374151;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .settings-input::placeholder {
            color: #d3b3c0;
        }

        .settings-input:hover {
            border-color: #F9C4D9;
        }

        .settings-input:focus {
            border-color: #FF4F87;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.12);
        }

        textarea.settings-input {
            resize: vertical;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        /* ============ BUTTONS ============ */
        .btn-save-pink {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 26px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            border: none;
            border-radius: 13px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(255, 79, 135, 0.3);
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .btn-save-pink::after {
            content: '';
            position: absolute;
            top: 0;
            left: -80%;
            width: 50%;
            height: 100%;
            background: linear-gradient(105deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.5s;
        }

        .btn-save-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(255, 79, 135, 0.42);
        }

        .btn-save-pink:hover::after {
            left: 130%;
        }

        .btn-save-pink:active {
            transform: translateY(0);
        }

        .btn-save-pink svg {
            width: 15px;
            height: 15px;
        }

        .settings-card-footer {
            margin-top: auto;
            padding-top: 20px;
            display: flex;
            justify-content: flex-end;
            border-top: 1px dashed #FBE3EE;
            position: relative;
            z-index: 1;
        }

        .btn-add-soft {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 9px 18px;
            background: #FFF0F5;
            border: 1.5px dashed #F9A8C9;
            color: #DB2777;
            font-weight: 700;
            border-radius: 13px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.2s;
            font-family: 'Poppins', sans-serif;
            position: relative;
            z-index: 1;
        }

        .btn-add-soft:hover {
            background: #FFE3EC;
            border-color: #F472B6;
            transform: translateY(-1px);
        }

        .btn-add-soft i {
            font-size: 11px;
        }

        /* ============ DYNAMIC ROWS (kategori / faq / sosmed) ============ */
        .dynamic-rows {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .dynamic-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: #FFF9FC;
            border: 1.5px solid #FDE1EC;
            border-radius: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .dynamic-row:hover {
            border-color: #F9C4D9;
            box-shadow: 0 4px 14px -6px rgba(236, 72, 153, 0.2);
        }

        .dynamic-row .drag-icon {
            color: #f0a1bd;
            font-size: 14px;
            cursor: grab;
            flex-shrink: 0;
        }

        .dynamic-row input,
        .dynamic-row select,
        .dynamic-row textarea {
            flex: 1;
            min-width: 0;
        }

        .remove-row-btn {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 11px;
            background: #FEF2F2;
            color: #EF4444;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: background 0.2s, color 0.2s, transform 0.2s;
        }

        .remove-row-btn:hover {
            background: #FDE8E8;
            color: #DC2626;
            transform: scale(1.06);
        }

        .faq-row {
            background: #FFF9FC;
            border: 1.5px solid #FDE1EC;
            border-radius: 16px;
            padding: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
            position: relative;
            z-index: 1;
        }

        .faq-row:hover {
            border-color: #F9C4D9;
            box-shadow: 0 4px 14px -6px rgba(236, 72, 153, 0.2);
        }

        .faq-row .faq-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-size: 10.5px;
            font-weight: 700;
            color: #f0a1bd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .faq-row .faq-head i {
            font-size: 11px;
        }

        .faq-grid-2 {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            margin-bottom: 12px;
        }

        @media (max-width: 480px) {
            .faq-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .sosmed-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
            transition: background 0.3s;
        }

        .sosmed-platform-select {
            width: 170px;
            flex-shrink: 0;
        }

        @media (max-width: 560px) {
            .sosmed-platform-select {
                width: 100%;
            }

            .dynamic-row {
                flex-wrap: wrap;
            }

            .dynamic-row input,
            .dynamic-row select {
                flex: 1 1 100%;
            }
        }

        /* ============ FLASH ALERT ============ */
        .alert-premium {
            border-radius: 16px;
            padding: 15px 20px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 500;
            animation: slideDown 0.4s ease;
            position: relative;
            z-index: 1;
        }

        .alert-premium.success {
            background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-premium .alert-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .alert-premium.success .alert-icon {
            background: #A7F3D0;
            color: #059669;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-hint {
            font-size: 11px;
            color: #d3b3c0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                @if (session('success'))
                    <div class="alert-premium success">
                        <div class="alert-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path
                                        d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42">
                                    </path>
                                </svg>
                            </div>
                            <div class="ph-text">
                                <div class="ph-breadcrumb">
                                    <span>Dashboard</span>
                                    <i class="fas fa-chevron-right"></i>
                                    <span>Pengaturan</span>
                                </div>
                                <h3>Pengaturan Aplikasi</h3>
                                <p>Konfigurasi pengaturan aplikasi BeautyCare sesuai kebutuhan.</p>
                            </div>
                        </div>
                        <div class="ph-badge">
                            <span class="dot-pulse"></span>
                            Semua sistem aktif
                        </div>
                    </div>
                </div>

                <div class="quick-nav-wrap">
                    <nav class="quick-nav" id="quickNav">
                        <a href="#section-notifikasi" data-target="section-notifikasi"><i class="fas fa-bell"></i> Notifikasi</a>
                        <a href="#section-operasional" data-target="section-operasional"><i class="fas fa-chart-bar"></i> Operasional</a>
                        <a href="#section-salon" data-target="section-salon"><i class="fas fa-store"></i> Info Salon</a>
                        <a href="#section-syarat" data-target="section-syarat"><i class="fas fa-file-contract"></i> Syarat &amp; Ketentuan</a>
                        <a href="#section-kebijakan" data-target="section-kebijakan"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a>
                        <a href="#section-kategori" data-target="section-kategori"><i class="fas fa-tags"></i> Kategori</a>
                        <a href="#section-faq" data-target="section-faq"><i class="fas fa-question-circle"></i> FAQ</a>
                        <a href="#section-sosmed" data-target="section-sosmed"><i class="fas fa-share-alt"></i> Sosial Media</a>
                    </nav>
                </div>

                <div class="settings-grid">

                    <!-- Card: Notifikasi -->
                    <form id="formNotifikasi" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card" data-section="section-notifikasi">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">Notifikasi</h3>
                                <p class="settings-sub">Pilih kanal notifikasi yang aktif</p>
                            </div>
                        </div>
                        <div>
                            <div class="settings-toggle-row">
                                <div class="settings-toggle-text">
                                    <div class="tgl-mini-icon"><i class="fas fa-mobile-alt"></i></div>
                                    <div>
                                        <p>Push Notification</p>
                                        <p>Notifikasi booking &amp; transaksi</p>
                                    </div>
                                </div>
                                <input type="hidden" name="push_notification"
                                    value="{{ $pengaturan->push_notification ? '1' : '0' }}">
                                <button type="button"
                                    class="toggle-btn {{ $pengaturan->push_notification ? 'active' : '' }}"
                                    data-active="{{ $pengaturan->push_notification ? 'true' : 'false' }}">
                                    <div class="toggle-circle">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="settings-toggle-row">
                                <div class="settings-toggle-text">
                                    <div class="tgl-mini-icon"><i class="fas fa-envelope"></i></div>
                                    <div>
                                        <p>Email Laporan</p>
                                        <p>Laporan harian via email</p>
                                    </div>
                                </div>
                                <input type="hidden" name="email_laporan"
                                    value="{{ $pengaturan->email_laporan ? '1' : '0' }}">
                                <button type="button"
                                    class="toggle-btn {{ $pengaturan->email_laporan ? 'active' : '' }}"
                                    data-active="{{ $pengaturan->email_laporan ? 'true' : 'false' }}">
                                    <div class="toggle-circle">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Notifikasi
                            </button>
                        </div>
                    </form>

                    <!-- Card: Operasional -->
                    <form id="formOperasional" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card" data-section="section-operasional">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-violet">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="21" x2="4" y2="14" />
                                    <line x1="4" y1="10" x2="4" y2="3" />
                                    <line x1="12" y1="21" x2="12" y2="12" />
                                    <line x1="12" y1="8" x2="12" y2="3" />
                                    <line x1="20" y1="21" x2="20" y2="16" />
                                    <line x1="20" y1="12" x2="20" y2="3" />
                                    <line x1="1" y1="14" x2="7" y2="14" />
                                    <line x1="9" y1="8" x2="15" y2="8" />
                                    <line x1="17" y1="16" x2="23" y2="16" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">Operasional</h3>
                                <p class="settings-sub">Atur alur operasional aplikasi</p>
                            </div>
                        </div>
                        <div class="settings-toggle-row" style="padding-top:0;">
                            <div class="settings-toggle-text">
                                <div class="tgl-mini-icon"><i class="fas fa-check-double"></i></div>
                                <div>
                                    <p>Konfirmasi Otomatis</p>
                                    <p>Booking auto-confirm jika tersedia</p>
                                </div>
                            </div>
                            <input type="hidden" name="konfirmasi_otomatis"
                                value="{{ $pengaturan->konfirmasi_otomatis ? '1' : '0' }}">
                            <button type="button"
                                class="toggle-btn {{ $pengaturan->konfirmasi_otomatis ? 'active' : '' }}"
                                data-active="{{ $pengaturan->konfirmasi_otomatis ? 'true' : 'false' }}">
                                <div class="toggle-circle">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Operasional
                            </button>
                        </div>
                    </form>

                    <!-- Card: Informasi Salon -->
                    <form id="formSalon" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card settings-card--wide" data-section="section-salon">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-amber">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="2" width="16" height="20" rx="2" />
                                    <path d="M9 22v-4h6v4" />
                                    <path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">Informasi Salon</h3>
                                <p class="settings-sub">Data salon yang tampil di aplikasi</p>
                            </div>
                        </div>
                        <div class="salon-field-grid">
                            <div>
                                <label class="settings-label" for="nama_salon"><i class="fas fa-store"></i> Nama Salon</label>
                                <input type="text" id="nama_salon" name="nama_salon"
                                    value="{{ $pengaturan->nama_salon }}" class="settings-input"
                                    placeholder="Nama salon Anda">
                            </div>
                            <div>
                                <label class="settings-label" for="telepon"><i class="fas fa-phone-alt"></i> Telepon</label>
                                <input type="text" id="telepon" name="telepon"
                                    value="{{ $pengaturan->telepon }}" class="settings-input"
                                    placeholder="021-1234-5678">
                            </div>
                            <div class="field-span-2">
                                <label class="settings-label" for="email"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ $pengaturan->email }}" class="settings-input"
                                    placeholder="email@salon.com">
                            </div>
                            <div class="field-full">
                                <label class="settings-label" for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                <input type="text" id="alamat" name="alamat"
                                    value="{{ $pengaturan->alamat }}" class="settings-input"
                                    placeholder="Alamat lengkap salon">
                            </div>
                            <div class="field-span-2">
                                <label class="settings-label" for="jam_buka"><i class="fas fa-clock"></i> Jam Buka</label>
                                <input type="time" id="jam_buka" name="jam_buka"
                                    value="{{ $pengaturan->jam_buka ? substr($pengaturan->jam_buka, 0, 5) : '08:00' }}"
                                    class="settings-input">
                            </div>
                            <div class="field-span-2">
                                <label class="settings-label" for="jam_tutup"><i class="fas fa-clock"></i> Jam Tutup</label>
                                <input type="time" id="jam_tutup" name="jam_tutup"
                                    value="{{ $pengaturan->jam_tutup ? substr($pengaturan->jam_tutup, 0, 5) : '20:00' }}"
                                    class="settings-input">
                            </div>
                        </div>
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Informasi Salon
                            </button>
                        </div>
                    </form>

                    <!-- Card: Syarat & Ketentuan -->
                    <form id="formSyarat" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card" data-section="section-syarat">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-teal">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                </svg>
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Syarat &amp; Ketentuan
                            </button>
                        </div>
                    </form>

                    <!-- Card: Kebijakan Privasi -->
                    <form id="formKebijakan" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card" data-section="section-kebijakan">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Kebijakan Privasi
                            </button>
                        </div>
                    </form>

                    <!-- Card: Kategori Pusat Bantuan -->
                    <form id="formKategori" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card settings-card--wide" data-section="section-kategori">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-emerald">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                    <line x1="7" y1="7" x2="7.01" y2="7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">Kategori Pusat Bantuan</h3>
                                <p class="settings-sub">Kelompokkan pertanyaan di halaman Pusat Bantuan</p>
                            </div>
                        </div>
                        <div id="kategori-rows" class="dynamic-rows"></div>
                        <p class="empty-hint" id="kategori-empty">Belum ada kategori, tambahkan melalui tombol di bawah.</p>
                        <button type="button" id="btn-tambah-kategori" class="btn-add-soft"><i class="fas fa-plus"></i>
                            Tambah Kategori</button>
                        <input type="hidden" name="pusat_bantuan_kategori" id="pusat_bantuan_kategori" value="">
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Kategori
                            </button>
                        </div>
                    </form>

                    <!-- Card: FAQ Pusat Bantuan -->
                    <form id="formFaq" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card settings-card--wide" data-section="section-faq">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-rose">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">FAQ Pusat Bantuan</h3>
                                <p class="settings-sub">Pertanyaan &amp; jawaban di halaman Pusat Bantuan</p>
                            </div>
                        </div>
                        <div id="faq-rows" class="dynamic-rows"></div>
                        <p class="empty-hint" id="faq-empty">Belum ada FAQ, tambahkan melalui tombol di bawah.</p>
                        <button type="button" id="btn-tambah-faq" class="btn-add-soft"><i class="fas fa-plus"></i>
                            Tambah FAQ</button>
                        <input type="hidden" name="pusat_bantuan_faq" id="pusat_bantuan_faq" value="">
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan FAQ
                            </button>
                        </div>
                    </form>

                    <!-- Card: Sosial Media -->
                    <form id="formSosmed" method="POST" action="{{ route('admin.pengaturan.update') }}"
                        class="settings-card settings-card--wide" data-section="section-sosmed">
                        @csrf
                        <div class="settings-card-header">
                            <div class="card-icon icon-indigo">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="settings-card-title">Sosial Media</h3>
                                <p class="settings-sub">Link sosial media yang tampil di footer website</p>
                            </div>
                        </div>
                        <div id="sosmed-rows" class="dynamic-rows"></div>
                        <p class="empty-hint" id="sosmed-empty">Belum ada sosial media, tambahkan melalui tombol di bawah.</p>
                        <button type="button" id="btn-tambah-sosmed" class="btn-add-soft"><i class="fas fa-plus"></i>
                            Tambah Sosial Media</button>
                        <input type="hidden" name="sosmed" id="sosmed" value="">
                        <div class="settings-card-footer">
                            <button type="submit" class="btn-save-pink">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Sosial Media
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
        function esc(s) {
            return String(s || '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[c]));
        }

        document.addEventListener('DOMContentLoaded', () => {
            const kategoriState = @json(json_decode($pengaturan->pusat_bantuan_kategori ?? '[]', true) ?: []);
            const faqState = @json(json_decode($pengaturan->pusat_bantuan_faq ?? '[]', true) ?: []);

            const kategoriRows = document.getElementById('kategori-rows');
            const faqRows = document.getElementById('faq-rows');
            const kategoriEmpty = document.getElementById('kategori-empty');
            const faqEmpty = document.getElementById('faq-empty');

            const kategoriNames = () =>
                Array.from(kategoriRows.querySelectorAll('.kategori-input')).map(i => i.value.trim()).filter(Boolean);

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
                kategoriEmpty.style.display = kategoriState.length ? 'none' : 'block';
                kategoriState.forEach((k, i) => {
                    const row = document.createElement('div');
                    row.className = 'dynamic-row';
                    row.innerHTML = `
                        <span class="drag-icon"><i class="fas fa-grip-vertical"></i></span>
                        <input type="text" class="kategori-input settings-input" placeholder="Nama kategori" value="${esc(k.nama)}">
                        <button type="button" class="remove-kategori remove-row-btn" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
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
                faqEmpty.style.display = faqState.length ? 'none' : 'block';
                faqState.forEach((f, i) => {
                    const row = document.createElement('div');
                    row.className = 'faq-row';
                    row.innerHTML = `
                        <div class="faq-grid-2">
                            <div>
                                <div class="faq-head"><i class="fas fa-tag"></i> Kategori</div>
                                <select class="faq-kategori settings-input">
                                    ${buildFaqSelect(f.kategori || '')}
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-faq remove-row-btn" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="faq-head"><i class="fas fa-question-circle"></i> Pertanyaan</div>
                            <input type="text" class="faq-pertanyaan settings-input" placeholder="Tulis pertanyaan..." value="${esc(f.pertanyaan)}">
                        </div>
                        <div>
                            <div class="faq-head"><i class="fas fa-comment-dots"></i> Jawaban</div>
                            <textarea rows="3" class="faq-jawaban settings-input leading-relaxed" placeholder="Tulis jawaban...">${esc(f.jawaban)}</textarea>
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
                    const idx = Array.from(kategoriRows.children).indexOf(e.target.closest('.dynamic-row'));
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sosmedState = @json(json_decode($pengaturan->sosmed ?? '[]', true) ?: []);

            const sosmedRows = document.getElementById('sosmed-rows');
            const sosmedEmpty = document.getElementById('sosmed-empty');

            const sosmedPlatforms = [
                { value: 'instagram', label: 'Instagram', icon: 'fa-instagram', prefix: 'fab', color: '#E1306C' },
                { value: 'facebook', label: 'Facebook', icon: 'fa-facebook-f', prefix: 'fab', color: '#1877F2' },
                { value: 'twitter', label: 'Twitter / X', icon: 'fa-twitter', prefix: 'fab', color: '#111111' },
                { value: 'youtube', label: 'YouTube', icon: 'fa-youtube', prefix: 'fab', color: '#FF0000' },
                { value: 'tiktok', label: 'TikTok', icon: 'fa-tiktok', prefix: 'fab', color: '#010101' },
                { value: 'whatsapp', label: 'WhatsApp', icon: 'fa-whatsapp', prefix: 'fab', color: '#25D366' },
                { value: 'telegram', label: 'Telegram', icon: 'fa-telegram', prefix: 'fab', color: '#229ED9' },
                { value: 'line', label: 'LINE', icon: 'fa-comment', prefix: 'fas', color: '#06C755' },
            ];

            const renderSosmed = () => {
                sosmedRows.innerHTML = '';
                sosmedEmpty.style.display = sosmedState.length ? 'none' : 'block';
                sosmedState.forEach((s, i) => {
                    const row = document.createElement('div');
                    row.className = 'dynamic-row';
                    const opts = sosmedPlatforms.map(p => {
                        const selected = (s.platform || '') === p.value ? 'selected' : '';
                        return `<option value="${p.value}" ${selected}>${p.label}</option>`;
                    }).join('');
                    const pl = sosmedPlatforms.find(p => p.value === (s.platform || 'instagram')) || sosmedPlatforms[0];
                    row.innerHTML = `
                        <span class="sosmed-badge" style="background:${pl.color}">
                            <i class="${pl.prefix} ${pl.icon}"></i>
                        </span>
                        <select class="sosmed-platform sosmed-platform-select settings-input">${opts}</select>
                        <input type="url" class="sosmed-url settings-input" placeholder="https://..." value="${esc(s.url || '')}">
                        <button type="button" class="remove-sosmed remove-row-btn" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                    row.querySelector('.remove-sosmed').addEventListener('click', () => {
                        sosmedState.splice(i, 1);
                        renderSosmed();
                    });
                    row.querySelector('.sosmed-platform').addEventListener('change', (e) => {
                        s.platform = e.target.value;
                        const plat = sosmedPlatforms.find(p => p.value === e.target.value);
                        const badge = row.querySelector('.sosmed-badge');
                        const icon = row.querySelector('.sosmed-badge i');
                        if (plat && badge && icon) {
                            badge.style.background = plat.color;
                            icon.className = plat.prefix + ' ' + plat.icon;
                        }
                    });
                    row.querySelector('.sosmed-url').addEventListener('input', (e) => {
                        s.url = e.target.value;
                    });
                    sosmedRows.appendChild(row);
                });
            };

            document.getElementById('btn-tambah-sosmed').addEventListener('click', () => {
                sosmedState.push({ platform: 'instagram', url: '' });
                renderSosmed();
            });

            document.getElementById('formSosmed').addEventListener('submit', () => {
                const sosmed = [];
                sosmedRows.querySelectorAll('.dynamic-row').forEach(r => {
                    const platform = r.querySelector('.sosmed-platform').value;
                    const url = r.querySelector('.sosmed-url').value.trim();
                    if (url) sosmed.push({ platform, url });
                });
                document.getElementById('sosmed').value = JSON.stringify(sosmed);
            });

            renderSosmed();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = Array.from(document.querySelectorAll('#quickNav a'));
            const sections = Array.from(document.querySelectorAll('[data-section]'));

            const setActive = (id) => {
                navLinks.forEach(a => a.classList.toggle('active', a.dataset.target === id));
            };

            const wrapper = document.querySelector('.main-content .flex-1.overflow-y-auto');

            let ticking = false;
            let clickLock = false;
            const updateSpy = () => {
                ticking = false;
                const navH = document.querySelector('.navbar-top')?.offsetHeight || 70;
                const quickH = document.querySelector('.quick-nav')?.offsetHeight || 0;
                const offset = navH + quickH + 24;
                let current = sections[0];
                sections.forEach(s => {
                    if (s.getBoundingClientRect().top - offset <= 0) {
                        current = s;
                    }
                });
                setActive(current.dataset.section);
            };

            const onScroll = () => {
                if (clickLock) return;
                if (!ticking) {
                    ticking = true;
                    requestAnimationFrame(updateSpy);
                }
            };

            window.addEventListener('scroll', onScroll, { passive: true });
            document.addEventListener('scroll', onScroll, { capture: true, passive: true });
            if (wrapper) wrapper.addEventListener('scroll', onScroll, { passive: true });

            navLinks.forEach(a => {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector('[data-section="' + a.dataset.target + '"]');
                    if (target) {
                        setActive(a.dataset.target);
                        clickLock = true;
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        setTimeout(() => {
                            clickLock = false;
                            updateSpy();
                        }, 700);
                    }
                });
            });

            updateSpy();

            document.querySelectorAll('.settings-card form, form.settings-card').forEach(form => {
                form.addEventListener('submit', () => {
                    const btn = form.querySelector('.btn-save-pink');
                    if (btn) {
                        btn.disabled = true;
                        btn.style.opacity = '0.7';
                        btn.innerHTML = '<span class="spinner"></span> Menyimpan...';
                    }
                });
            });
        });
    </script>
    <style>
        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spinBtn 0.7s linear infinite;
        }

        @keyframes spinBtn {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>