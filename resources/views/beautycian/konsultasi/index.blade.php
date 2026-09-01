<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konsultasi Pelanggan - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">

    <style>
    .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
    .sidebar-overlay.active { display: block; }
    @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px; padding: 28px 32px; margin-bottom: 24px;
        position: relative; overflow: hidden; border: 1px solid rgba(255,79,135,0.08);
    }
    .page-header-premium .ph-content { display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
    .page-header-premium .ph-left { display: flex; align-items: center; gap: 16px; }
    .page-header-premium .ph-icon-wrap {
        width: 52px; height: 52px; border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex; align-items: center; justify-content: center;
        color: #fff; box-shadow: 0 8px 20px rgba(255,79,135,0.25);
    }
    .page-header-premium .ph-text h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin: 0; }
    .page-header-premium .ph-text p { font-size: 13px; color: var(--gray); margin: 4px 0 0; }

    .filter-bar { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .filter-pill {
        display: inline-flex; align-items: center; gap: 6px; background: #fff; border: 1.5px solid var(--border);
        border-radius: 100px; padding: 8px 16px; font-size: 12px; color: var(--gray); text-decoration: none;
        font-family: 'Poppins', sans-serif; transition: all .2s ease; cursor: pointer;
    }
    .filter-pill:hover { border-color: var(--primary); color: var(--primary); }
    .filter-pill.active { background: var(--primary); border-color: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(255,79,135,0.25); }
    .filter-bar select {
        background: #fff; border: 1.5px solid var(--border); border-radius: 100px;
        padding: 8px 16px; font-size: 12px; color: var(--dark); outline: none; cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }
    .filter-bar select:focus { border-color: var(--primary); }

    .konsultasi-card {
        background: #fff; border: 1px solid var(--border); border-radius: 16px;
        padding: 18px 20px; margin-bottom: 14px; transition: all .2s ease;
    }
    .konsultasi-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); transform: translateY(-2px); }
    .kc-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 10px; flex-wrap: wrap; }
    .kc-customer { display: flex; align-items: center; gap: 10px; }
    .kc-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0;
    }
    .kc-name { font-size: 14px; font-weight: 600; color: var(--dark); }
    .kc-phone { font-size: 11px; color: var(--gray); display: flex; align-items: center; gap: 4px; margin-top: 2px; }
    .status-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 5px 12px; border-radius: 100px; }
    .status-badge.dikonfirmasi { background: #DBEAFE; color: #1D4ED8; }
    .status-badge.selesai { background: #D1FAE5; color: #047857; }
    .status-badge.ditolak { background: #FEE2E2; color: #B91C1C; }
    .sb-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .kc-body { display: grid; grid-template-columns: auto 1fr; gap: 18px; }
    .kc-meta { font-size: 12px; color: var(--gray); display: flex; flex-direction: column; gap: 6px; min-width: 130px; }
    .kc-meta div { display: flex; align-items: center; gap: 7px; }
    .kc-meta i { width: 14px; text-align: center; color: var(--primary); }
    .kc-topic { font-size: 13px; color: var(--dark); }
    .kc-topic .tk { font-weight: 600; font-size: 13px; margin-bottom: 4px; }
    .kc-topic .tp { font-size: 12px; color: var(--gray); line-height: 1.6; }

    .kc-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px; justify-content: flex-end; }
    .btn-konsul { padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: all .2s; font-family: 'Poppins', sans-serif; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-konsul:hover { transform: translateY(-1px); }
    .btn-wa { background: #25D366; color: #fff; box-shadow: 0 4px 12px rgba(37,211,102,.3); }
    .btn-wa:hover { background: #1EBE5C; color: #fff; }
    .btn-wa-web { background: #fff; color: #25D366; border: 1.5px solid #25D366; }
    .btn-wa-web:hover { background: #F0FFF4; color: #1EBE5C; }
    .btn-selesai { background: #10B981; color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,.25); }
    .btn-selesai:hover { color: #fff; }
    .btn-outline-konsul { background: transparent; color: var(--gray); border: 1.5px solid var(--border); }
    .btn-outline-konsul:hover { border-color: var(--primary); color: var(--primary); }

    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state .es-illustration {
        width: 72px; height: 72px; margin: 0 auto 14px; border-radius: 22px;
        background: linear-gradient(135deg, #FEE7EF, #FFD6E6);
        display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 28px;
    }
    .empty-state h4 { font-size: 15px; font-weight: 700; color: var(--dark); margin: 0 0 6px; }
    .empty-state p { font-size: 12px; color: var(--gray); margin: 0; }

    .modal-premium { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
    .modal-premium.active { display: flex; }
    .modal-premium .modal-content { background: #fff; border-radius: 20px; padding: 28px; max-width: 400px; width: 90%; text-align: center; }
    .modal-premium .modal-content .modal-icon-wrap { width: 52px; height: 52px; border-radius: 16px; margin: 0 auto 14px; background: #D1FAE5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .modal-premium .modal-content h3 { font-size: 16px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
    .modal-premium .modal-content p { font-size: 12px; color: var(--gray); margin-bottom: 20px; }
    .modal-premium .modal-actions { display: flex; gap: 10px; justify-content: center; }
    .modal-premium .btn-cancel { padding: 10px 22px; border-radius: 100px; border: 1.5px solid var(--border); background: #fff; color: var(--gray); font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
    .modal-premium .btn-confirm { padding: 10px 22px; border-radius: 100px; border: none; background: #10B981; color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
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
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Konsultasi Pelanggan</h3>
                                <p>Tangani konsultasi member yang ditugaskan kepada Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('message'))
                <div class="alert-premium success" style="display:flex;align-items:center;gap:10px;background:#D1FAE5;color:#047857;border:1px solid #A7F3D0;border-radius:14px;padding:14px 18px;font-size:13px;margin-bottom:16px;">
                    <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert-premium error" style="display:flex;align-items:center;gap:10px;background:#FEE2E2;color:#B91C1C;border:1px solid #FECACA;border-radius:14px;padding:14px 18px;font-size:13px;margin-bottom:16px;">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                <div class="filter-bar">
                    <form method="GET" action="" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                        <a href="?status=" class="filter-pill {{ $filterStatus === '' ? 'active' : '' }}">
                            <i class="fa-solid fa-layer-group"></i> Semua
                        </a>
                        <a href="?status=menunggu" class="filter-pill {{ $filterStatus === 'menunggu' ? 'active' : '' }}">
                            <i class="fa-regular fa-clock"></i> Menunggu
                        </a>
                        <a href="?status=dikonfirmasi" class="filter-pill {{ $filterStatus === 'dikonfirmasi' ? 'active' : '' }}">
                            <i class="fa-solid fa-check"></i> Dikonfirmasi
                        </a>
                        <a href="?status=selesai" class="filter-pill {{ $filterStatus === 'selesai' ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-check"></i> Selesai
                        </a>
                        <a href="?status=ditolak" class="filter-pill {{ $filterStatus === 'ditolak' ? 'active' : '' }}">
                            <i class="fa-solid fa-ban"></i> Ditolak
                        </a>
                    </form>
                </div>

                @forelse($konsultasi as $item)
                <div class="konsultasi-card">
                    <div class="kc-top">
                        <div class="kc-customer">
                            <div class="kc-avatar">
                                <img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                            </div>
                            <div>
                                <div class="kc-name">{{ $item->pelanggan->nm_pelanggan ?? '#' . $item->id_pelanggan }}</div>
                                <div class="kc-phone">
                                    <i class="fa-solid fa-phone"></i> {{ $item->pelanggan->no_hp ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <span class="status-badge {{ $item->status }}">
                            <span class="sb-dot"></span> {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="kc-body">
                        <div class="kc-meta">
                            <div><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</div>
                            <div><i class="fa-regular fa-clock"></i> {{ str_replace(':', '.', substr($item->jam, 0, 5)) }}</div>
                            <div><i class="fa-solid {{ $item->mode === 'online' ? 'fa-globe' : 'fa-store' }}"></i> {{ ucfirst($item->mode) }}</div>
                            @if($item->mode === 'online' && $item->media)
                            <div><i class="fa-brands fa-whatsapp"></i> {{ $item->media === 'whatsapp_chat' ? 'Chat' : 'Video Call' }}</div>
                            @endif
                        </div>
                        <div class="kc-topic">
                            <div class="tk">{{ $item->topik }}</div>
                            <div class="tp">{{ $item->pesan ?: 'Tanpa keterangan tambahan.' }}</div>
                        </div>
                    </div>
                    <div class="kc-actions">
                        @if($item->pelanggan && $item->pelanggan->no_hp)
                        @php
                            $waRawPhone = preg_replace('/[^0-9]/', '', $item->pelanggan->no_hp);
                            $waPhone = str_starts_with($waRawPhone, '0') ? '62' . substr($waRawPhone, 1) : $waRawPhone;
                            $waRawText = 'Halo ' . ($item->pelanggan->nm_pelanggan ?? '') . ', saya dari BeautyCare. Konsultasi Anda "' . $item->topik . '" siap saya tangani.';
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text={{ rawurlencode($waRawText) }}"
                            class="btn-konsul btn-wa"
                            target="_blank" rel="noopener"
                            title="Hubungi via WhatsApp (support 08 & +62)"
                            onclick="event.preventDefault(); openWhatsAppApp('{{ $waPhone }}', {{ \Illuminate\Support\Js::from($waRawText) }});">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                        @endif
                        @if($item->status === 'dikonfirmasi')
                        <button onclick="bukaSelesai({{ $item->id_konsultasi }})" class="btn-konsul btn-selesai">
                            <i class="fa-solid fa-check"></i> Tandai Selesai
                        </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="es-illustration">
                        <i class="fa-regular fa-comments"></i>
                    </div>
                    <h4>Belum Ada Konsultasi</h4>
                    <p>Tidak ada konsultasi untuk Anda saat ini.</p>
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- ═══ Modal Selesai ═══ -->
    <div id="selesaiModal" class="modal-premium">
        <div class="modal-content">
            <form id="selesaiForm" method="POST">
                @csrf
                <div class="modal-icon-wrap">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3>Tandai Selesai</h3>
                <p>Pastikan konsultasi sudah benar-benar selesai sebelum menandainya.</p>
                <div class="modal-actions">
                    <button type="button" onclick="tutupSelesai()" class="btn-cancel"><i class="fa-solid fa-xmark mr-1"></i>Batal</button>
                    <button type="submit" class="btn-confirm"><i class="fa-solid fa-check mr-1"></i> Ya, Selesai</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const baseUrl = '{{ url('/beautycian/konsultasi') }}';

    function bukaSelesai(id) {
        document.getElementById('selesaiForm').action = baseUrl + '/' + id + '/selesai';
        document.getElementById('selesaiModal').classList.add('active');
    }
    function tutupSelesai() {
        document.getElementById('selesaiModal').classList.remove('active');
    }
    document.getElementById('selesaiModal').addEventListener('click', function(e) {
        if (e.target === this) tutupSelesai();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupSelesai();
    });

    // Buka WhatsApp universal: wa.me di tab baru + coba wa:// via iframe (tanpa ganti halaman → tidak blank hitam)
    // Support 08 & +62 sudah dinormalisasi di PHP ke 62...
    function openWhatsAppApp(phone, rawText) {
        var text = encodeURIComponent(rawText);
        var waMe = 'https://wa.me/' + phone + '?text=' + text;
        var waApp = 'whatsapp://send?phone=' + phone + '&text=' + text;
        var win = window.open(waMe, '_blank', 'noopener');
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = waApp;
        document.body.appendChild(iframe);
        setTimeout(function(){ if (iframe.parentNode) iframe.parentNode.removeChild(iframe); }, 1500);
        if (!win) window.location.href = waMe;
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
