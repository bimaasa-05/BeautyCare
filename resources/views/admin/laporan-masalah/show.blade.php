<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Laporan Masalah - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

    .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
    .badge-baru { background: #FEF3C7; color: #D97706; }
    .badge-diproses { background: #DBEAFE; color: #2563EB; }
    .badge-selesai { background: #E8F8EE; color: #22C55E; }
    .badge-role { background: #F3E8FF; color: #9333EA; }

    .header-back { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
    .header-back .btn-back {
        width: 44px; height: 44px; border-radius: 14px; border: 1.5px solid var(--border);
        background: #fff; color: var(--dark); display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: all .2s;
    }
    .header-back .btn-back:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
    .header-back .hb-text h3 { font-size: 18px; font-weight: 700; color: var(--dark); margin: 0; }
    .header-back .hb-text p { font-size: 12px; color: var(--gray); margin: 3px 0 0; }

    .detail-card { background: #fff; border: 1px solid var(--border); border-radius: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); overflow: hidden; }
    .dc-body { padding: 28px 32px; }
    .dc-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
    .dc-top .dt-title { font-size: 15px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 10px; }
    .dc-top .dt-title i { color: var(--primary); }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .info-item { background: #F8FAFC; border-radius: 14px; padding: 14px 18px; }
    .info-item .ii-label { font-size: 10.5px; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 6px; }
    .info-item .ii-value { font-size: 13px; font-weight: 600; color: var(--dark); display: flex; align-items: center; gap: 8px; }

    .dc-deskripsi { margin-top: 20px; background: #FFFBFD; border: 1px solid #FCE7F0; border-radius: 14px; padding: 18px 20px; }
    .dc-deskripsi .dd-label { font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 8px; }
    .dc-deskripsi p { font-size: 13px; color: #4B5563; line-height: 1.8; white-space: pre-line; margin: 0; }

    .dc-catatan {
        margin-top: 16px; background: #F0FDF4; border-left: 3px solid #22C55E; border-radius: 12px;
        padding: 14px 18px;
    }
    .dc-catatan .cc-label { font-size: 11px; font-weight: 700; color: #15803D; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 6px; }
    .dc-catatan p { font-size: 12.5px; color: #475569; line-height: 1.7; margin: 0; white-space: pre-line; }

    .bukti-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px; margin-top: 16px; }
    .bukti-item { border-radius: 14px; overflow: hidden; border: 1px solid var(--border); background: #f8f8f8; position: relative; }
    .bukti-item img, .bukti-item video { width: 100%; height: 150px; object-fit: cover; display: block; }
    .bukti-item .bi-video-icon {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.3); color: #fff; font-size: 32px; pointer-events: none;
    }
    .bukti-item .bi-name { font-size: 10.5px; color: var(--gray); padding: 8px 12px; text-align: center; }

    .form-status { margin-top: 24px; border-top: 1px solid var(--border); padding-top: 24px; }
    .fs-grid { display: grid; grid-template-columns: 240px 1fr; gap: 16px; align-items: start; }
    .fg-label { font-size: 12px; font-weight: 600; color: var(--dark); margin-bottom: 8px; display: flex; align-items: center; gap: 7px; }
    .fg-label-icon { color: var(--primary); font-size: 12px; }
    .fg-input {
        width: 100%; padding: 12px 14px; border: 1.5px solid var(--border); border-radius: 12px;
        font-size: 13px; outline: none; background: #FAFAFA; transition: all .2s;
        font-family: 'Poppins', sans-serif; color: var(--dark);
    }
    .fg-input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255,79,135,0.08); }
    select.fg-input { cursor: pointer; }
    .fs-actions { margin-top: 16px; text-align: right; }
    .btn-simpan {
        padding: 13px 32px; border-radius: 14px; border: none;
        background: linear-gradient(135deg, var(--primary), #FF6B9C); color: #fff;
        font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif;
        box-shadow: 0 6px 16px rgba(255,79,135,0.3);
    }
    .btn-simpan:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,79,135,0.4); }

    .alert-success-premium {
        border-radius: 16px; padding: 16px 20px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 500;
        background: linear-gradient(135deg, #F0FDF4, #DCFCE7); border: 1px solid #BBF7D0; color: #166534;
        animation: slideDown .4s ease;
    }
    .alert-success-premium .ae-icon {
        width: 36px; height: 36px; border-radius: 50%; background: #BBF7D0; color: #16A34A;
        display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) {
        .dc-body { padding: 20px; }
        .info-grid { grid-template-columns: 1fr; }
        .fs-grid { grid-template-columns: 1fr; }
        .header-back { flex-wrap: wrap; gap: 12px; }
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
                    <a href="{{ route('admin.laporan-masalah.index') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="hb-text">
                        <h3>Detail Laporan #{{ $laporan->id_laporan }}</h3>
                        <p>Tinjau dan tindak lanjuti laporan masalah dari pengguna</p>
                    </div>
                </div>

                @if(session('message'))
                <div class="alert-success-premium">
                    <div class="ae-icon"><i class="fa-solid fa-check"></i></div>
                    <span>{{ session('message') }}</span>
                </div>
                @endif

                <div class="detail-card">
                    <div class="dc-body">
                        <div class="dc-top">
                            <div class="dt-title">
                                <span class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                                {{ $laporan->kategori }}
                            </div>
                            <span class="badge-status badge-{{ $laporan->status }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="ii-label">Pelapor</div>
                                <div class="ii-value">
                                    <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-[12px] font-bold">
                                        {{ substr($laporan->user->nama ?? '?', 0, 1) }}
                                    </div>
                                    {{ $laporan->user->nama ?? '-' }}
                                    <span class="badge-status badge-role">{{ ucfirst($laporan->role) }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="ii-label">Waktu Dilaporkan</div>
                                <div class="ii-value">
                                    <i class="fa-regular fa-clock text-pink-400"></i>
                                    {{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}
                                    <span class="text-[10px] text-gray-400 font-normal">{{ $laporan->created_at ? $laporan->created_at->diffForHumans() : '' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="dc-deskripsi">
                            <div class="dd-label"><i class="fa-solid fa-align-left mr-1"></i> Deskripsi Masalah</div>
                            <p>{{ $laporan->deskripsi }}</p>
                        </div>

                        @if($laporan->catatan_admin)
                        <div class="dc-catatan">
                            <div class="cc-label"><i class="fa-solid fa-comment-dots mr-1"></i> Tanggapan Admin Saat Ini</div>
                            <p>{{ $laporan->catatan_admin }}</p>
                        </div>
                        @endif

                        @if(!empty($laporan->bukti))
                        <div style="margin-top:20px;">
                            <div class="ii-label" style="font-size:11px; font-weight:700; color:var(--gray); text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px;">
                                <i class="fa-solid fa-paperclip mr-1" style="color:var(--primary);"></i> Bukti Terlampir ({{ count($laporan->bukti) }})
                            </div>
                            <div class="bukti-grid">
                                @foreach($laporan->bukti as $b)
                                @php $ext = strtolower(pathinfo($b, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($ext, ['mp4', 'mov', 'mkv', 'webm']))
                                <div class="bukti-item">
                                    <video src="{{ asset('storage/' . $b) }}" controls></video>
                                    <div class="bi-video-icon"><i class="fa-solid fa-play"></i></div>
                                    <div class="bi-name">{{ basename($b) }}</div>
                                </div>
                                @else
                                <a href="{{ asset('storage/' . $b) }}" target="_blank" class="bukti-item" style="text-decoration:none;">
                                    <img src="{{ asset('storage/' . $b) }}" alt="Bukti">
                                    <div class="bi-name">{{ basename($b) }}</div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('admin.laporan-masalah.update-status', $laporan->id_laporan) }}" method="POST" class="form-status">
                            @csrf
                            <div class="fs-grid">
                                <div>
                                    <label class="fg-label">
                                        <i class="fa-solid fa-arrows-rotate fg-label-icon"></i>
                                        Ubah Status <span style="color:#EF4444;">*</span>
                                    </label>
                                    <select name="status" class="fg-input" required>
                                        <option value="baru" {{ $laporan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="diproses" {{ $laporan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="fg-label">
                                        <i class="fa-regular fa-comment-dots fg-label-icon"></i>
                                        Catatan / Tanggapan untuk Pelapor
                                    </label>
                                    <textarea name="catatan_admin" class="fg-input" rows="3" maxlength="2000" placeholder="cth: Sudah diperbaiki di versi terbaru, silakan coba kembali...">{{ $laporan->catatan_admin }}</textarea>
                                </div>
                            </div>
                            <div class="fs-actions">
                                <button type="submit" class="btn-simpan">
                                    <i class="fa-solid fa-paper-plane"></i> Simpan & Beri Tahu Pelapor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>