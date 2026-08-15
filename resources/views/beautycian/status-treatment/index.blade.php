<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Status Treatment - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <style>
        .kanban-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 1200px) { .kanban-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .kanban-grid { grid-template-columns: 1fr; } }

        .kanban-column { background: #F8F9FC; border-radius: 16px; padding: 16px; min-height: 400px; }
        .kanban-column .kc-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid var(--border); }
        .kanban-column .kc-header .kc-title { display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 700; color: var(--dark); }
        .kanban-column .kc-header .kc-count { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; }

        .kanban-column.column-waiting .kc-header { border-bottom-color: #3B82F6; }
        .kanban-column.column-waiting .kc-count { background: #3B82F6; }
        .kanban-column.column-progress .kc-header { border-bottom-color: #F59E0B; }
        .kanban-column.column-progress .kc-count { background: #F59E0B; }
        .kanban-column.column-done .kc-header { border-bottom-color: #10B981; }
        .kanban-column.column-done .kc-count { background: #10B981; }

        .kanban-card { background: #fff; border-radius: 12px; padding: 14px; margin-bottom: 12px; border: 1px solid var(--border); transition: all 0.2s ease; }
        .kanban-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); transform: translateY(-2px); }
        .kanban-card .kc-card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .kanban-card .kc-card-header .kc-header-right { margin-left: auto; display: flex; align-items: center; gap: 8px; }
        .kanban-card .kc-card-header .kc-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
        .kanban-card .kc-card-header .kc-name { font-size: 14px; font-weight: 600; color: var(--dark); }
        .kanban-card .kc-card-body { padding-left: 46px; }
        .kanban-card .kc-card-body .kc-service { font-size: 12px; color: var(--gray); margin-bottom: 4px; }
        .kanban-card .kc-card-body .kc-time { font-size: 11px; color: var(--gray); display: flex; align-items: center; gap: 4px; }
        .kanban-card .kc-card-body .kc-time svg { width: 12px; height: 12px; }
        .kanban-card .kc-card-footer { padding-left: 46px; margin-top: 10px; display: flex; gap: 8px; flex-wrap: wrap; }

        .kanban-card .doc-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 600; }
        .kanban-card .doc-badge.has-doc { background: #D1FAE5; color: #059669; }
        .kanban-card .doc-badge.no-doc { background: #FEF3C7; color: #D97706; }
        .kanban-card .late-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 600; background: #FEE2E2; color: #DC2626; }
        .kanban-card .timer-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; font-variant-numeric: tabular-nums; background: #FEF3C7; color: #D97706; border: 1px solid #FCD34D; }
        .kanban-card .timer-badge .tick { color: #B45309; }
        .kanban-card .done-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 600; background: #D1FAE5; color: #059669; }

        .btn-kanban { padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease; font-family: 'Poppins', sans-serif; display: inline-flex; align-items: center; gap: 5px; }
        .btn-kanban:hover { transform: scale(1.03); }
        .btn-primary-kanban { background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; box-shadow: 0 4px 12px rgba(255,79,135,0.2); }
        .btn-primary-kanban:hover { box-shadow: 0 6px 20px rgba(255,79,135,0.3); }
        .btn-success-kanban { background: #10B981; color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,0.2); }
        .btn-success-kanban:hover { box-shadow: 0 6px 20px rgba(16,185,129,0.3); }
        .btn-outline-kanban { background: transparent; color: var(--gray); border: 1.5px solid var(--border); }
        .btn-outline-kanban:hover { border-color: var(--primary); color: var(--primary); background: var(--hover); }
        .btn-info-kanban { background: #6366F1; color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.2); }

        .empty-kanban { text-align: center; padding: 40px 20px; color: var(--gray); }
        .empty-kanban svg { width: 48px; height: 48px; color: #ddd; margin-bottom: 12px; }
        .empty-kanban h4 { font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 4px; }
        .empty-kanban p { font-size: 11px; }

        .modal-premium { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
        .modal-premium.active { display: flex; }
        .modal-premium .modal-content { background: #fff; border-radius: 20px; padding: 28px; max-width: 520px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
        .modal-premium .modal-content .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .modal-premium .modal-content .modal-header h3 { font-size: 16px; font-weight: 700; color: var(--dark); }
        .modal-premium .modal-content .modal-header .modal-close { width: 32px; height: 32px; border-radius: 10px; border: none; background: var(--hover); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--gray); transition: all 0.2s; }
        .modal-premium .modal-content .modal-header .modal-close:hover { background: #FEE2E2; color: #DC2626; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 6px; }
        .form-group input[type="text"], .form-group textarea, .form-group input[type="file"] { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; font-family: 'Poppins', sans-serif; transition: all 0.2s; outline: none; box-sizing: border-box; }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,79,135,0.1); }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .form-group input[type="file"] { padding: 8px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

        .photo-preview { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
        .photo-preview img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 2px solid var(--border); }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Status Treatment</h3>
                                <p>Pantau dan kelola treatment secara real-time</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="kanban-grid">
                    <div class="kanban-column column-waiting">
                        <div class="kc-header">
                            <div class="kc-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                Akan Dimulai
                            </div>
                            <span class="kc-count">{{ $totalAkanDimulai }}</span>
                        </div>

                        @forelse($akanDimulai as $item)
                        <div class="kanban-card">
                            <div class="kc-card-header">
                                <div class="kc-avatar"><img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block;"></div>
                                <div>
                                    <div class="kc-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : '#' . $item->id_pelanggan }}</div>
                                </div>
                                @if($item->terlambatMenit > 0)
                                <div class="kc-header-right">
                                    <span class="late-badge">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        Terlambat {{ $item->terlambatMenit }} menit
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div class="kc-card-body">
                                <div class="kc-service">
                                    @if($item->detail && $item->detail->isNotEmpty())
                                        @foreach($item->detail as $dt)
                                            {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else - @endif
                                </div>
                                <div class="kc-time">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}
                                </div>
                            </div>
                            <div class="kc-card-footer">
                                <form action="{{ route('beautycian.jadwal-treatment.update') }}" method="POST" data-confirm-title="Mulai Treatment" data-confirm-body="Mulai treatment ini? Pastikan pelanggan sudah siap." data-confirm-icon="fa-play" data-confirm-type="brand" data-confirm-yes="Ya, Mulai">
                                    @csrf
                                    <input type="hidden" name="id_booking" value="{{ $item->id_booking }}">
                                    <button type="submit" class="btn-kanban btn-primary-kanban">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                        Mulai
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="empty-kanban">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <h4>Tidak Ada</h4>
                            <p>Belum ada treatment yang akan dimulai.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="kanban-column column-progress">
                        <div class="kc-header">
                            <div class="kc-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Sedang Berjalan
                            </div>
                            <span class="kc-count">{{ $totalDiproses }}</span>
                        </div>

                        @forelse($sedangBerjalan as $item)
                        <div class="kanban-card">
                            <div class="kc-card-header">
                                <div class="kc-avatar"><img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block;"></div>
                                <div>
                                    <div class="kc-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : '#' . $item->id_pelanggan }}</div>
                                </div>
                                <div class="kc-header-right">
                                    <span class="timer-badge" data-mulai="{{ $item->jam_mulai_aktual ? \Carbon\Carbon::parse($item->jam_mulai_aktual)->format('Y-m-d H:i:s') : \Carbon\Carbon::parse($item->tanggal . ' ' . $item->jam)->format('Y-m-d H:i:s') }}">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Mulai {{ $item->mulaiAktualTxt }} · Berjalan <span class="tick">00:00:00</span>
                                        @if($item->bedaWaktu)
                                            <span style="margin-left:6px;color:#f59e0b;">· Est. Selesai: {{ $item->estimasiSelesaiTxt }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="kc-card-body">
                                <div class="kc-service">
                                    @if($item->detail && $item->detail->isNotEmpty())
                                        @foreach($item->detail as $dt)
                                            {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else - @endif
                                </div>
                                
                                <!-- Waktu Detail seperti Admin -->
                                <div style="margin-top:8px;padding-top:8px;border-top:1px solid var(--border);">
                                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                                        <span class="text-gray-400">Dijadwalkan</span>
                                        <span class="font-semibold text-gray-700">{{ $item->jamTerjadwalTxt }} - {{ $item->jamSelesaiEstimasiTxt }}</span>
                                    </div>
                                    @if($item->bedaWaktu)
                                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                                        <span class="text-amber-500">Aktual</span>
                                        <span class="font-bold text-amber-600">{{ $item->mulaiAktualTxt }} · Sedang berlangsung</span>
                                    </div>
                                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#f59e0b;">
                                        <span>Est. Selesai</span>
                                        <span class="font-bold">{{ $item->estimasiSelesaiTxt }}</span>
                                    </div>
                                    @else
                                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#8b5cf6;">
                                        <span>Est. Selesai</span>
                                        <span class="font-bold">{{ $item->estimasiSelesaiTxt }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($item->riwayatTreatment)
                                    <div style="margin-top:6px;">
                                        <span class="doc-badge has-doc">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            Ada Dokumentasi
                                        </span>
                                    </div>
                                @else
                                    <div style="margin-top:6px;">
                                        <span class="doc-badge no-doc">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            Belum Ada Dokumentasi
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="kc-card-footer">
                                @if(!$item->riwayatTreatment)
                                <button type="button" class="btn-kanban btn-info-kanban" onclick="openDokumentasiModal({{ $item->id_booking }})">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 11 12 14 22 4"/></svg>
                                    Isi Dokumentasi
                                </button>
                                @else
                                <form action="{{ route('beautycian.status-treatment.complete') }}" method="POST" data-confirm-title="Selesaikan Treatment" data-confirm-body="Selesaikan treatment ini? Pastikan dokumentasi sudah lengkap." data-confirm-icon="fa-circle-check" data-confirm-type="success" data-confirm-yes="Ya, Selesaikan">
                                    @csrf
                                    <input type="hidden" name="id_booking" value="{{ $item->id_booking }}">
                                    <button type="submit" class="btn-kanban btn-success-kanban">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Selesai
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-kanban">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <h4>Tidak Ada</h4>
                            <p>Tidak ada treatment yang sedang berjalan.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="kanban-column column-done">
                        <div class="kc-header">
                            <div class="kc-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Selesai Hari Ini
                            </div>
                            <span class="kc-count">{{ $totalSelesai }}</span>
                        </div>

                        @forelse($selesaiHariIni as $item)
                        <div class="kanban-card">
                            <div class="kc-card-header">
                                <div class="kc-avatar"><img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block;"></div>
                                <div>
                                    <div class="kc-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : '#' . $item->id_pelanggan }}</div>
                                </div>
                                @if($item->jam_selesai_aktual && $item->jam_mulai_aktual)
                                <div class="kc-header-right">
                                    <span class="done-badge">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        Selesai {{ $item->selesaiAktualTxt }}
                                        @if(isset($item->durasiAktualTxt))
                                        · {{ $item->durasiAktualTxt }}
                                        @endif
                                    </span>
                                </div>
                                @elseif($item->jam_selesai_aktual)
                                <div class="kc-header-right">
                                    <span class="done-badge">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        Selesai pukul {{ \Carbon\Carbon::parse($item->jam_selesai_aktual)->format('H:i') }}
                                    </span>
                                </div>
                                @endif
                            </div>
                            <div class="kc-card-body">
                                <div class="kc-service">
                                    @if($item->detail && $item->detail->isNotEmpty())
                                        @foreach($item->detail as $dt)
                                            {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else - @endif
                                </div>
                                
                                <!-- Waktu Detail seperti Admin -->
                                <div style="margin-top:8px;padding-top:8px;border-top:1px solid var(--border);">
                                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                                        <span class="text-gray-400">Dijadwalkan</span>
                                        <span class="font-semibold text-gray-700">{{ $item->jamTerjadwalTxt }} - {{ $item->jamSelesaiEstimasiTxt }}</span>
                                    </div>
                                    @if(isset($item->mulaiAktualTxt) && isset($item->bedaWaktu) && $item->bedaWaktu)
                                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                                        <span class="text-amber-500">Aktual</span>
                                        <span class="font-bold text-amber-600">{{ $item->mulaiAktualTxt }} - {{ $item->selesaiAktualTxt }}</span>
                                    </div>
                                    @elseif(isset($item->mulaiAktualTxt))
                                    <div style="display:flex;justify-content:space-between;font-size:11px;margin-bottom:4px;">
                                        <span class="text-gray-400">Aktual</span>
                                        <span class="font-semibold text-gray-700">{{ $item->mulaiAktualTxt }} - {{ $item->selesaiAktualTxt }}</span>
                                    </div>
                                    @endif
                                    @if(isset($item->durasiAktualTxt))
                                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#10b981;">
                                        <span>Durasi</span>
                                        <span class="font-bold font-mono">{{ $item->durasiAktualTxt }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($item->riwayatTreatment)
                                    <div style="margin-top:6px;">
                                        <span class="doc-badge has-doc">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                            Terdokumentasi
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="kc-card-footer">
                                <a href="{{ route('beautycian.riwayat-treatment.show', $item->id_booking) }}" class="btn-kanban btn-outline-kanban">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Detail
                                </a>
                                @if(!$item->riwayatTreatment)
                                <button type="button" class="btn-kanban btn-info-kanban" onclick="openDokumentasiModal({{ $item->id_booking }})">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 11 12 14 22 4"/></svg>
                                    Dokumen
                                </button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-kanban">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <h4>Tidak Ada</h4>
                            <p>Belum ada treatment yang selesai hari ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Dokumentasi -->
    <div class="modal-premium" id="modalDokumentasi">
        <div class="modal-content">
            <form action="{{ route('beautycian.riwayat-treatment.dokumentasi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_booking" id="dok_id_booking">

                <div class="modal-header">
                    <h3>Dokumentasi Treatment</h3>
                    <button type="button" class="modal-close" onclick="closeDokumentasiModal()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Foto Sebelum Treatment</label>
                        <input type="file" name="sebelum_foto" accept="image/*" onchange="previewFoto(this, 'previewBefore')">
                        <div class="photo-preview" id="previewBefore"></div>
                    </div>
                    <div class="form-group">
                        <label>Foto Sesudah Treatment</label>
                        <input type="file" name="sesudah_foto" accept="image/*" onchange="previewFoto(this, 'previewAfter')">
                        <div class="photo-preview" id="previewAfter"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Produk yang Digunakan</label>
                    <input type="text" name="produk_digunakan" placeholder="Contoh: Serum Vitamin C, Moisturizer, Sunscreen" maxlength="1000">
                </div>

                <div class="form-group">
                    <label>Catatan Treatment</label>
                    <textarea name="catatan" placeholder="Hasil treatment, kondisi kulit, rekomendasi, dll..." maxlength="2000"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" class="btn-kanban btn-outline-kanban" onclick="closeDokumentasiModal()" style="padding:10px 20px;">Batal</button>
                    <button type="submit" class="btn-kanban btn-primary-kanban" style="padding:10px 20px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Dokumentasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDokumentasiModal(id) {
            document.getElementById('dok_id_booking').value = id;
            document.getElementById('modalDokumentasi').classList.add('active');
        }

        function closeDokumentasiModal() {
            document.getElementById('modalDokumentasi').classList.remove('active');
        }

        document.getElementById('modalDokumentasi').addEventListener('click', function(e) {
            if (e.target === this) closeDokumentasiModal();
        });

        function previewFoto(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Stopwatch live untuk treatment yang sedang berjalan
        document.querySelectorAll('.timer-badge').forEach(function(badge) {
            const mulai = new Date(badge.getAttribute('data-mulai').replace(' ', 'T')).getTime();
            const tickEl = badge.querySelector('.tick');
            if (!tickEl || isNaN(mulai)) return;
            function update() {
                let s = Math.max(0, Math.floor((Date.now() - mulai) / 1000));
                const hh = String(Math.floor(s / 3600)).padStart(2, '0');
                const mm = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
                const ss = String(s % 60).padStart(2, '0');
                tickEl.textContent = hh + ':' + mm + ':' + ss;
            }
            update();
            setInterval(update, 1000);
        });
    </script>

    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
