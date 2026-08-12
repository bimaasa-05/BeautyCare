@extends('layouts.app')

@section('title', 'Kebijakan Privasi - BeautyCare')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <style>
        .legal-page {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            padding: 80px 0 60px;
            font-family: 'Poppins', sans-serif;
        }

        .legal-page .legal-container {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            padding: 48px 56px;
            box-shadow: 0 8px 32px rgba(255, 79, 135, 0.12);
        }

        .legal-page .legal-header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 2px solid #FFE5EF;
        }

        .legal-page .legal-header .legal-badge {
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

        .legal-page .legal-header h1 {
            font-size: 30px;
            font-weight: 700;
            color: #1F2937;
            margin: 0 0 8px;
        }

        .legal-page .legal-header p {
            font-size: 14px;
            color: #6B7280;
            margin: 0;
        }

        .legal-page .legal-content {
            font-size: 14.5px;
            line-height: 1.9;
            color: #374151;
            white-space: pre-line;
        }

        .legal-page .legal-content p {
            margin: 0 0 16px;
        }

        .legal-page .legal-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 32px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
            transition: opacity 0.3s;
        }

        .legal-page .legal-back:hover {
            opacity: 0.85;
        }

        @media screen and (max-width: 768px) {
            .legal-page {
                padding: 40px 16px;
            }

            .legal-page .legal-container {
                padding: 32px 24px;
            }

            .legal-page .legal-header h1 {
                font-size: 24px;
            }
        }
    </style>
@endpush

@section('content')
    @include('layouts.navbar')

    <div class="legal-page">
        <div class="legal-container">
            <div class="legal-header">
                <span class="legal-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Dokumen Legal
                </span>
                <h1>Kebijakan Privasi</h1>
                <p>Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>
            </div>

            <div class="legal-content">
                @if ($pengaturan && $pengaturan->kebijakan_privasi)
                    {{ $pengaturan->kebijakan_privasi }}
                @else
                    <p>Konten Kebijakan Privasi belum tersedia. Silakan hubungi BeautyCare untuk informasi lebih
                        lanjut.</p>
                @endif
            </div>

            <a href="{{ url('/') }}" class="legal-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection