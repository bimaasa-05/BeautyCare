<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporkan Masalah - BeautyCare</title>
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

    .header-back { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
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

    .bukti-drop {
        border: 1.5px dashed #D8B4C8; border-radius: 14px; padding: 24px; text-align: center;
        cursor: pointer; transition: all .2s; background: #FFFBFD;
    }
    .bukti-drop:hover { border-color: var(--primary); background: #FFF0F5; }
    .bukti-drop .bd-icon { font-size: 24px; color: var(--primary); margin-bottom: 8px; }
    .bukti-drop .bd-title { font-size: 13px; font-weight: 600; color: var(--dark); }
    .bukti-drop .bd-desc { font-size: 11px; color: var(--gray); margin-top: 3px; }
    .bukti-previews { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
    .bukti-preview-item { position: relative; width: 88px; height: 88px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); background: #f8f8f8; }
    .bukti-preview-item img, .bukti-preview-item video { width: 100%; height: 100%; object-fit: cover; display: block; }
    .bukti-preview-item .bp-remove {
        position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; border-radius: 50%;
        background: rgba(0,0,0,0.6); color: #fff; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 10px;
    }
    .bukti-preview-item .bp-video-icon {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.25); color: #fff; font-size: 22px;
    }

    .form-actions { display: flex; align-items: center; gap: 12px; margin-top: 28px; }
    .form-actions .btn-submit {
        padding: 13px 32px; border-radius: 14px; border: none;
        background: linear-gradient(135deg, var(--primary), #FF6B9C); color: #fff;
        font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif;
        box-shadow: 0 6px 16px rgba(255,79,135,0.3);
    }
    .form-actions .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(255,79,135,0.4); }

    .alert-error-premium, .alert-success-premium {
        border-radius: 16px; padding: 16px 20px; margin-bottom: 24px;
        display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 500;
        animation: slideDown .4s ease;
    }
    .alert-error-premium { background: linear-gradient(135deg, #FEF2F2, #FEE2E2); border: 1px solid #FECACA; color: #991B1B; }
    .alert-success-premium { background: linear-gradient(135deg, #F0FDF4, #DCFCE7); border: 1px solid #BBF7D0; color: #166534; }
    .alert-error-premium .ae-icon, .alert-success-premium .ae-icon {
        width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
    }
    .alert-error-premium .ae-icon { background: #FECACA; color: #DC2626; }
    .alert-success-premium .ae-icon { background: #BBF7D0; color: #16A34A; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }

    .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
    .badge-baru { background: #FEF3C7; color: #D97706; }
    .badge-diproses { background: #DBEAFE; color: #2563EB; }
    .badge-selesai { background: #E8F8EE; color: #22C55E; }

    .laporan-item {
        background: #fff; border: 1px solid var(--border); border-radius: 18px;
        padding: 20px 24px; margin-bottom: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .laporan-item .li-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .laporan-item .li-kategori { font-size: 13px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
    .laporan-item .li-kategori i { color: var(--primary); font-size: 12px; }
    .laporan-item .li-deskripsi { font-size: 12.5px; color: #4B5563; margin-top: 8px; line-height: 1.7; white-space: pre-line; }
    .laporan-item .li-waktu { font-size: 11px; color: var(--gray); margin-top: 8px; }
    .laporan-item .li-catatan {
        margin-top: 12px; background: #F8FAFC; border-left: 3px solid var(--primary);
        border-radius: 10px; padding: 12px 16px; font-size: 12px; color: #475569;
    }
    .laporan-item .li-catatan .lc-label { font-weight: 700; color: var(--dark); font-size: 11px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 4px; }
    .li-bukti { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
    .li-bukti .lb-item { position: relative; width: 92px; height: 92px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); }
    .li-bukti .lb-item img, .li-bukti .lb-item video { width: 100%; height: 100%; object-fit: cover; display: block; }
    .li-bukti .lb-item .lb-video-icon {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.3); color: #fff; font-size: 24px;
    }
    .section-riwayat { margin-top: 32px; }
    .section-riwayat .sr-title { font-size: 15px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
    .section-riwayat .sr-title i { color: var(--primary); }
    .empty-state { text-align: center; padding: 32px; }
    .empty-state .es-icon { width: 56px; height: 56px; margin: 0 auto 12px; border-radius: 16px; background: #FDF2F8; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .empty-state p { font-size: 13px; color: var(--gray); }

    @media (max-width: 768px) {
        .fcp-body { padding: 20px; }
        .header-back { flex-wrap: wrap; gap: 12px; }
        .header-back .hb-text h3 { font-size: 17px; }
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
                    <div class="hb-text">
                        <h3>Laporkan Masalah</h3>
                        <p>Temukan kendala? Sampaikan kepada tim BeautyCare beserta buktinya</p>
                    </div>
                </div>

                @if(session('message'))
                <div class="alert-success-premium">
                    <div class="ae-icon"><i class="fa-solid fa-check"></i></div>
                    <span>{{ session('message') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert-error-premium">
                    <div class="ae-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert-error-premium">
                    <div class="ae-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form action="{{ route($routeName . '.store') }}" method="POST" enctype="multipart/form-data" id="laporanForm">
                    @csrf

                    <div class="form-card-premium">
                        <div class="fcp-body">
                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-triangle-exclamation"></i></span>
                                Detail Masalah
                            </div>
                            <div class="fcp-section-sub">Jelaskan masalah yang Anda alami sejelas mungkin</div>

                            <div class="fg-premium">
                                <label class="fg-label">
                                    <i class="fa-solid fa-tags fg-label-icon"></i>
                                    Kategori <span class="fg-required">*</span>
                                </label>
                                <select name="kategori" class="fg-input" required>
                                    <option value="">Pilih kategori masalah...</option>
                                    @foreach(['Aplikasi', 'Pembayaran', 'Booking/Reservasi', 'Stok/Produk', 'Akun', 'Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fg-premium" style="margin-top:16px;">
                                <label class="fg-label">
                                    <i class="fa-regular fa-message fg-label-icon"></i>
                                    Deskripsi Masalah <span class="fg-required">*</span>
                                </label>
                                <textarea name="deskripsi" class="fg-input" rows="6" minlength="10" maxlength="2000" required placeholder="Ceritakan apa yang terjadi, kapan, dan di halaman apa...">{{ old('deskripsi') }}</textarea>
                                <div class="fg-help">
                                    <i class="fa-solid fa-circle-info"></i> Minimal 10 karakter, maksimal 2000 karakter
                                </div>
                            </div>

                            <div class="fcp-divider"></div>

                            <div class="fcp-section-title">
                                <span class="fcp-st-icon"><i class="fa-solid fa-paperclip"></i></span>
                                Bukti Pendukung
                            </div>
                            <div class="fcp-section-sub">Opsional, maksimal 3 file foto atau video (maks 10 MB per file)</div>

                            <div class="bukti-drop" id="buktiDrop" onclick="document.getElementById('buktiInput').click()">
                                <div class="bd-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <div class="bd-title">Klik untuk memilih file</div>
                                <div class="bd-desc">Format: JPG, PNG, GIF, WEBP, MP4, MOV, MKV, WEBM</div>
                            </div>
                            <input type="file" name="bukti[]" id="buktiInput" class="fg-input" multiple accept="image/jpeg,image/png,image/gif,image/webp,video/mp4,video/quicktime,video/x-matroska,video/webm" style="display:none;">
                            <div class="bukti-previews" id="buktiPreviews"></div>
                            <div class="fg-help">
                                <i class="fa-solid fa-circle-info"></i> Screenshot error, foto kendala, atau rekaman singkat akan membantu kami memperbaiki lebih cepat
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="section-riwayat">
                    <div class="sr-title">
                        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Laporan Saya
                        <span class="badge-status badge-baru" style="margin-left:auto;">{{ $laporan->count() }} laporan</span>
                    </div>

                    @forelse($laporan as $item)
                    <div class="laporan-item">
                        <div class="li-top">
                            <div class="li-kategori">
                                <i class="fa-solid fa-tags"></i> {{ $item->kategori }}
                            </div>
                            <span class="badge-status badge-{{ $item->status }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        <div class="li-deskripsi">{{ $item->deskripsi }}</div>

                        @if(!empty($item->bukti))
                        <div class="li-bukti">
                            @foreach($item->bukti as $b)
                            @php $ext = strtolower(pathinfo($b, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['mp4', 'mov', 'mkv', 'webm']))
                            <div class="lb-item">
                                <video src="{{ asset('storage/' . $b) }}" muted></video>
                                <div class="lb-video-icon"><i class="fa-solid fa-play"></i></div>
                            </div>
                            @else
                            <a href="{{ asset('storage/' . $b) }}" target="_blank" title="Lihat bukti">
                                <div class="lb-item">
                                    <img src="{{ asset('storage/' . $b) }}" alt="Bukti laporan">
                                </div>
                            </a>
                            @endif
                            @endforeach
                        </div>
                        @endif

                        @if($item->catatan_admin)
                        <div class="li-catatan">
                            <div class="lc-label"><i class="fa-solid fa-comment-dots mr-1"></i> Tanggapan Admin</div>
                            {{ $item->catatan_admin }}
                        </div>
                        @endif

                        <div class="li-waktu">
                            <i class="fa-regular fa-clock mr-1"></i>
                            Dilaporkan {{ $item->created_at ? $item->created_at->diffForHumans() : '' }}
                        </div>
                    </div>
                    @empty
                    <div class="form-card-premium">
                        <div class="empty-state">
                            <div class="es-icon"><i class="fa-solid fa-flag"></i></div>
                            <p>Belum ada laporan yang Anda kirim</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
    var buktiFiles = [];
    var buktiInput = document.getElementById('buktiInput');
    var buktiPreviews = document.getElementById('buktiPreviews');

    buktiInput.addEventListener('change', function() {
        buktiFiles = Array.from(buktiInput.files).slice(0, 3);
        renderPreviews();
    });

    function renderPreviews() {
        buktiPreviews.innerHTML = '';
        buktiFiles.forEach(function(file, index) {
            var item = document.createElement('div');
            item.className = 'bukti-preview-item';
            var url = URL.createObjectURL(file);
            if (file.type.indexOf('video') === 0) {
                item.innerHTML = '<video src="' + url + '" muted></video>' +
                    '<div class="bp-video-icon"><i class="fa-solid fa-play"></i></div>';
            } else {
                item.innerHTML = '<img src="' + url + '" alt="Preview">';
            }
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'bp-remove';
            btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            btn.onclick = function() {
                buktiFiles.splice(index, 1);
                renderPreviews();
            };
            item.appendChild(btn);
            buktiPreviews.appendChild(item);
        });
        var dt = new DataTransfer();
        buktiFiles.forEach(function(f) { dt.items.add(f); });
        buktiInput.files = dt.files;
    }

    document.getElementById('laporanForm').addEventListener('submit', function(event) {
        var files = buktiInput.files;
        if (files.length > 3) {
            event.preventDefault();
            alert('Maksimal 3 file bukti.');
        }
    });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>