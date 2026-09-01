<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rating Layanan - BeautyCare</title>
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

    /* ─── Page Header Premium ─── */
    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }

    .page-header-premium::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-premium .ph-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-premium .ph-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        flex-shrink: 0;
    }

    .page-header-premium .ph-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .page-header-premium .ph-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .btn-history {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        border: 1.5px solid var(--primary);
        background: var(--white);
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-history:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    /* ─── Alert ─── */
    .rating-alert {
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid transparent;
    }

    .rating-alert.success {
        background: #ECFDF5;
        border-color: #A7F3D0;
        color: #047857;
    }

    .rating-alert.error {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #B91C1C;
    }

    /* ─── Info Booking ─── */
    .lr-booking-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .lr-booking-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .lr-booking-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .lr-booking-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .lr-booking-meta {
        font-size: 12px;
        color: var(--gray);
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .lr-booking-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .lr-booking-meta i {
        color: var(--primary);
    }

    .status-badge.selesai {
        background: #D1FAE5;
        color: #059669;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge .sb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ─── Card Layanan ─── */
    .lr-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
    }

    .lr-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 20px;
    }

    .lr-card-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }

    .lr-card-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary);
    }

    .lr-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .lr-section-title i {
        color: #F59E0B;
    }

    .lr-ulasan-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        align-items: start;
    }

    .lr-ulasan-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-height: 560px;
        overflow-y: auto;
        padding-right: 6px;
    }

    /* ─── Form Rating ─── */
    .lr-rating-form {
        margin-top: 22px;
    }

    .lr-form-box {
        background: #FFF9FB;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
    }

    .lr-form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .lr-stars {
        display: flex;
        gap: 6px;
        margin-bottom: 16px;
    }

    .lr-stars button {
        background: none;
        border: none;
        font-size: 28px;
        color: #E5E7EB;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        transition: color .15s ease, transform .15s ease;
    }

    .lr-stars button:hover,
    .lr-stars button.active {
        color: #F59E0B;
        transform: scale(1.1);
    }

    .lr-form-box textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-family: inherit;
        resize: vertical;
        min-height: 90px;
        transition: border-color .15s ease;
    }

    .lr-form-box textarea:focus {
        outline: none;
        border-color: var(--primary);
    }

    .lr-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: #FFF;
        border: none;
        border-radius: 12px;
        padding: 11px 22px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 14px;
        transition: all .2s ease;
    }

    .lr-submit:hover {
        background: var(--secondary);
        transform: translateY(-2px);
    }

    .lr-note {
        font-size: 13px;
        color: var(--gray);
        line-height: 1.6;
    }

    .lr-note i {
        color: var(--primary);
    }

    @media (max-width: 900px) {
        .lr-ulasan-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header-premium {
            padding: 22px 20px;
        }

        .page-header-premium .ph-text h3 {
            font-size: 17px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            font-size: 18px;
        }
    }

    /* ─── Modal Premium (Hapus Rating) ─── */
    .modal-premium {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: none;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    }

    .modal-premium.show {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-premium .modal-box {
        background: var(--white);
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 400px;
        margin: 0 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        animation: scaleIn 0.3s ease;
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-premium .modal-box .modal-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #FEE2E2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .modal-premium .modal-box .modal-icon-wrap i {
        font-size: 28px;
        color: #DC2626;
    }

    .modal-premium .modal-box h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        text-align: center;
        margin-bottom: 8px;
    }

    .modal-premium .modal-box p {
        font-size: 13px;
        color: var(--gray);
        text-align: center;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .modal-premium .modal-box .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-premium .modal-box .modal-actions .btn-cancel {
        flex: 1;
        padding: 11px 20px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--gray);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-premium .modal-box .modal-actions .btn-cancel:hover {
        background: var(--background);
        border-color: #ddd;
    }

    .modal-premium .modal-box .modal-actions .btn-danger {
        flex: 1;
        padding: 11px 20px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #DC2626, #EF4444);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }

    .modal-premium .modal-box .modal-actions .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35);
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                @if (session('success'))
                <div class="rating-alert success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="rating-alert error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Rating Layanan</h3>
                                <p>Bagikan pengalaman treatment Anda setelah booking selesai</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.booking') }}" class="btn-history">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Booking
                        </a>
                    </div>
                </div>

                <div class="lr-booking-card">
                    <div class="lr-booking-left">
                        <div class="lr-booking-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="lr-booking-title">
                                #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}
                                · {{ $booking->detail->count() }} layanan
                            </div>
                            <div class="lr-booking-meta">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</span>
                                <span><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</span>
                                @if ($booking->karyawan)
                                <span><i class="fa-solid fa-user-nurse"></i> {{ $booking->karyawan->nama }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="status-badge selesai"><span class="sb-dot"></span> Selesai</span>
                </div>

                @forelse($detailLayanan as $detail)
                @php $layanan = $detail->layanan; $idLayanan = $layanan->id_layanan; @endphp
                <div class="lr-card">
                    <div class="lr-card-head">
                        <div class="lr-card-name">
                            <i class="fa-solid fa-wand-magic-sparkles" style="color:var(--primary);margin-right:6px;"></i>
                            {{ $layanan->nm_layanan }}
                        </div>
                        <div class="lr-card-price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="lr-section-title">
                        <i class="fa-solid fa-star"></i> Rating &amp; Ulasan
                    </div>

                    <div class="lr-ulasan-grid">
                        @include('partials.rating-summary', ['ringkasan' => $ringkasans[$idLayanan]])
                        <div class="lr-ulasan-list">
                            @include('partials.rating-reviews', ['ulasans' => $ulasans[$idLayanan], 'empty' => 'Belum ada ulasan untuk layanan ini.'])
                        </div>
                    </div>

                    <div class="lr-rating-form">
                        @if ($ratingSaya[$idLayanan])
                        <div class="lr-form-box">
                            <div class="lr-section-title" style="margin-bottom:12px;">
                                <i class="fa-solid fa-pen"></i> Rating Anda
                            </div>
                            <div style="color:#F59E0B;font-size:18px;letter-spacing:1px;margin-bottom:10px;">
                                {{ str_repeat('★', $ratingSaya[$idLayanan]->bintang) }}{{ str_repeat('☆', 5 - $ratingSaya[$idLayanan]->bintang) }}
                            </div>
                            <p class="lr-note" style="margin-bottom:14px;">
                                {{ $ratingSaya[$idLayanan]->komentar ? '"' . $ratingSaya[$idLayanan]->komentar . '"' : 'Tanpa komentar.' }}
                            </p>
                            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                                <button type="button" class="rate-edit-btn" onclick="tampilFormEditLayanan({{ $idLayanan }})">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Rating
                                </button>
                                <button type="button" class="rate-del-btn" data-form="hapus-rating-form-{{ $idLayanan }}" data-nama="{{ $layanan->nm_layanan }}" onclick="confirmHapusRating(this)">
                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                </button>
                            </div>
                            <form id="form-edit-layanan-{{ $idLayanan }}" action="{{ route('rating.store') }}" method="POST" class="rate-edit-form" style="display:none;">
                                @csrf
                                <input type="hidden" name="tipe" value="layanan">
                                <input type="hidden" name="id_target" value="{{ $idLayanan }}">

                                <label class="lr-form-label">Pilih bintang Anda</label>
                                <div class="lr-stars" id="starEditInput{{ $idLayanan }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" data-nilai="{{ $i }}" class="{{ $i <= $ratingSaya[$idLayanan]->bintang ? 'active' : '' }}" onclick="pilihBintangLayanan(this, {{ $idLayanan }})">★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="bintang" id="bintangValueEdit{{ $idLayanan }}" value="{{ $ratingSaya[$idLayanan]->bintang }}">

                                <label class="lr-form-label">Komentar (opsional)</label>
                                <textarea name="komentar" maxlength="500" placeholder="Ceritakan pengalaman Anda dengan treatment ini...">{{ $ratingSaya[$idLayanan]->komentar }}</textarea>

                                <button type="submit" class="lr-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                            </form>
                            <form id="hapus-rating-form-{{ $idLayanan }}" action="{{ route('rating.destroy', $ratingSaya[$idLayanan]->id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @elseif ($bisaRating[$idLayanan])
                        <div class="lr-form-box">
                            <div class="lr-section-title" style="margin-bottom:12px;">
                                <i class="fa-solid fa-pen"></i> Beri Rating Anda
                            </div>
                            <form action="{{ route('rating.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe" value="layanan">
                                <input type="hidden" name="id_target" value="{{ $idLayanan }}">

                                <label class="lr-form-label">Pilih bintang Anda</label>
                                <div class="lr-stars" id="starInput{{ $idLayanan }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" data-nilai="{{ $i }}" onclick="pilihBintangLayanan(this, {{ $idLayanan }})">★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="bintang" id="bintangValue{{ $idLayanan }}" value="5">

                                <label class="lr-form-label">Komentar (opsional)</label>
                                <textarea name="komentar" maxlength="500" placeholder="Ceritakan pengalaman Anda dengan treatment ini..."></textarea>

                                <button type="submit" class="lr-submit"><i class="fa-solid fa-paper-plane"></i> Kirim Rating</button>
                            </form>
                        </div>
                        @else
                        <p class="lr-note">
                            <i class="fa-solid fa-circle-info"></i>
                            Anda baru dapat memberi rating setelah menyelesaikan treatment ini.
                        </p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="lr-card" style="text-align:center;padding:48px 24px;color:var(--gray);">
                    <p style="margin-bottom:8px;"><i class="fa-solid fa-star" style="font-size:30px;color:#F59E0B;"></i></p>
                    Tidak ada layanan pada booking ini.
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- ═══ Modal Hapus Rating Premium ═══ -->
    <div id="hapusRatingModal" class="modal-premium">
        <div class="modal-box">
            <div class="modal-icon-wrap">
                <i class="fa-solid fa-star"></i>
            </div>
            <h3>Hapus Rating</h3>
            <p id="modalHapusRatingBody">Apakah Anda yakin ingin menghapus rating ini?<br>Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-actions">
                <button type="button" onclick="closeHapusRatingModal()" class="btn-cancel">Tidak Jadi</button>
                <button type="button" onclick="hapusRatingConfirm()" class="btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
    function pilihBintangLayanan(btn, idLayanan) {
        var nilai = parseInt(btn.getAttribute('data-nilai'));
        var input = document.getElementById('bintangValue' + idLayanan) || document.getElementById('bintangValueEdit' + idLayanan);
        if (input) input.value = nilai;
        var container = document.getElementById('starInput' + idLayanan) || document.getElementById('starEditInput' + idLayanan);
        if (!container) return;
        var buttons = container.querySelectorAll('button');
        buttons.forEach(function(b) {
            b.classList.toggle('active', parseInt(b.getAttribute('data-nilai')) <= nilai);
        });
    }

    function tampilFormEditLayanan(idLayanan) {
        var f = document.getElementById('form-edit-layanan-' + idLayanan);
        if (f) f.style.display = (f.style.display === 'none' || !f.style.display) ? 'block' : 'none';
    }

    // ═══ Modal Hapus Rating Premium ═══
    var deleteRatingFormId = null;

    function confirmHapusRating(btn) {
        deleteRatingFormId = btn.getAttribute('data-form');
        var nama = (btn.getAttribute('data-nama') || 'rating ini').replace(/[<>&"']/g, function(c) {
            return { '<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;', "'": '&#39;' }[c];
        });
        document.getElementById('modalHapusRatingBody').innerHTML =
            'Apakah Anda yakin ingin menghapus rating untuk <strong>' + nama + '</strong>?<br>Tindakan ini tidak dapat dibatalkan.';
        document.getElementById('hapusRatingModal').classList.add('show');
    }

    function closeHapusRatingModal() {
        document.getElementById('hapusRatingModal').classList.remove('show');
        deleteRatingFormId = null;
    }

    function hapusRatingConfirm() {
        if (deleteRatingFormId) document.getElementById(deleteRatingFormId).submit();
    }

    document.getElementById('hapusRatingModal').addEventListener('click', function(e) {
        if (e.target === this) closeHapusRatingModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeHapusRatingModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.lr-stars').forEach(function(container) {
            var hasActive = container.querySelector('button.active');
            if (hasActive) return;
            var buttons = container.querySelectorAll('button');
            buttons.forEach(function(b, idx) {
                if (idx === buttons.length - 1) b.classList.add('active');
            });
        });
    });
    </script>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>