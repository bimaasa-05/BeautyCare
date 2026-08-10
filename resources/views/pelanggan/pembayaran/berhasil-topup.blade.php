<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Top Up Berhasil - BeautyCare</title>
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

    .sukses-main {
        max-width: 560px;
        margin: 40px auto;
        text-align: center;
    }

    .sukses-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: 0 4px 24px -8px rgba(0, 0, 0, 0.1);
        padding: 48px 40px;
    }

    .sukses-check {
        width: 96px;
        height: 96px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10B981, #34D399);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 42px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.35);
        animation: pop 0.5s ease;
    }

    @keyframes pop {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        70% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .sukses-card h3 {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
        margin: 0;
    }

    .sukses-card p {
        font-size: 13px;
        color: var(--gray);
        margin: 8px 0 0;
        line-height: 1.6;
    }

    .sukses-card .sk-nominal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        border-radius: 100px;
        background: #ECFDF5;
        color: #047857;
        font-size: 18px;
        font-weight: 800;
        margin-top: 16px;
        font-variant-numeric: tabular-nums;
    }

    .sukses-card .sk-invoice {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 100px;
        background: #F3F4F6;
        color: #6B7280;
        font-size: 12.5px;
        font-weight: 600;
        margin-top: 12px;
    }

    .sukses-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 28px;
        flex-wrap: wrap;
    }

    .btn-lanjut {
        padding: 13px 28px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-lanjut:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
    }

    .btn-kembali-belanja {
        padding: 13px 28px;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        background: #fff;
        color: var(--dark);
        font-size: 13px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-kembali-belanja:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .redirect-info {
        font-size: 12px;
        color: var(--gray);
        margin-top: 20px;
    }

    .redirect-info b {
        color: var(--primary);
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="sukses-main">
                    <div class="sukses-card">
                        <div class="sukses-check">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h3>Top Up Saldo Berhasil!</h3>
                        <p>Saldo Anda telah bertambah dan siap digunakan untuk<br>transaksi di BeautyCare.</p>
                        <div class="sk-nominal">
                            <i class="fa-solid fa-coins"></i> +Rp {{ number_format((float) $transaksi->total, 0, ',', '.') }}
                        </div>
                        <div class="sk-invoice">
                            <i class="fa-solid fa-receipt"></i> {{ $transaksi->no_invoice }}
                        </div>
                        <div class="sukses-actions">
                            <a href="{{ route('pelanggan.saldo.index') }}" class="btn-lanjut">
                                <i class="fa-solid fa-wallet"></i> Lihat Saldo Saya
                            </a>
                            <a href="{{ route('pelanggan.produk') }}" class="btn-kembali-belanja">
                                <i class="fa-solid fa-store"></i> Belanja Lagi
                            </a>
                        </div>
                        <div class="redirect-info">
                            Mengalihkan ke halaman saldo dalam <b id="hitungan">5</b> detik...
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    var detik = 5;
    var el = document.getElementById('hitungan');
    var timer = setInterval(function() {
        detik--;
        if (el) el.textContent = detik;
        if (detik <= 0) {
            clearInterval(timer);
            window.location.href = '{{ route("pelanggan.saldo.index") }}';
        }
    }, 1000);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>