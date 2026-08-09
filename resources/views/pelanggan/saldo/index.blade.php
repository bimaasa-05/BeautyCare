<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Saldo Akun - BeautyCare</title>
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
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px;
        box-shadow: 0 8px 20px rgba(255,79,135,0.25);
    }
    .page-header-premium .ph-text h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin: 0; }
    .page-header-premium .ph-text p { font-size: 13px; color: var(--gray); margin: 4px 0 0; }

    .saldo-big-card {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border: 1px solid #A7F3D0; border-radius: 20px;
        padding: 32px; margin-bottom: 24px; text-align: center; position: relative; overflow: hidden;
    }
    .saldo-big-card::before {
        content: ''; position: absolute; top: -80px; right: -80px; width: 240px; height: 240px; border-radius: 50%;
        background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%);
    }
    .saldo-label { font-size: 14px; font-weight: 600; color: #047857; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .saldo-amount { font-size: 48px; font-weight: 800; color: #065F46; margin: 0; font-variant-numeric: tabular-nums; }
    .saldo-desc { font-size: 13px; color: #047857; margin-top: 8px; opacity: 0.8; }

    .saldo-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-mini {
        background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 20px;
        text-align: center;
    }
    .stat-mini .sm-icon { width: 40px; height: 40px; border-radius: 12px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .stat-mini .sm-icon.kredit { background: #ECFDF5; color: #10B981; }
    .stat-mini .sm-icon.debit { background: #FEF2F2; color: #EF4444; }
    .stat-mini .sm-value { font-size: 20px; font-weight: 700; color: var(--dark); margin-bottom: 4px; }
    .stat-mini .sm-label { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: .5px; }

    .mutasi-card {
        background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden;
    }
    .mutasi-header {
        background: #FAFAFC; padding: 16px 24px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
    }
    .mutasi-title { font-size: 15px; font-weight: 700; color: var(--dark); }
    .mutasi-table { width: 100%; border-collapse: collapse; }
    .mutasi-table th {
        background: #FAFAFC; font-size: 11px; text-transform: uppercase; letter-spacing: .5px;
        color: var(--gray); font-weight: 600; padding: 13px 18px; text-align: left; border-bottom: 1px solid var(--border);
    }
    .mutasi-table td { padding: 15px 18px; border-bottom: 1px solid var(--border); font-size: 13px; color: var(--dark); vertical-align: middle; }
    .mutasi-table tr:last-child td { border-bottom: none; }
    .mutasi-table tr:hover { background: #FAFAFC; }

    .mutasi-type { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 100px; }
    .mutasi-type.kredit { background: #ECFDF5; color: #10B981; }
    .mutasi-type.debit { background: #FEF2F2; color: #EF4444; }

    .mutasi-nominal { font-weight: 700; font-size: 14px; font-variant-numeric: tabular-nums; }
    .mutasi-nominal.kredit { color: #10B981; }
    .mutasi-nominal.debit { color: #EF4444; }

    .mutasi-info { color: var(--gray); font-size: 12px; }
    .mutasi-info .mi-label { font-weight: 600; color: var(--dark); display: block; margin-bottom: 2px; }
    .mutasi-info .mi-desc { font-size: 11px; }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state .es-illustration {
        width: 80px; height: 80px; margin: 0 auto 16px; border-radius: 24px;
        background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
        display: flex; align-items: center; justify-content: center; color: #10B981; font-size: 32px;
    }
    .empty-state h4 { font-size: 15px; font-weight: 700; color: var(--dark); margin: 0 0 6px; }
    .empty-state p { font-size: 12px; color: var(--gray); margin: 0; }

    .pagination-custom { display: flex; justify-content: center; gap: 6px; margin-top: 24px; }
    .pagination-custom a, .pagination-custom span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; border-radius: 100px; padding: 0 12px;
        font-size: 13px; font-weight: 600; color: var(--dark); text-decoration: none;
        border: 1px solid var(--border); background: #fff; transition: all .2s;
    }
    .pagination-custom a:hover { border-color: var(--primary); color: var(--primary); }
    .pagination-custom span.active { background: var(--primary); border-color: var(--primary); color: #fff; }
    .pagination-custom span.disabled { opacity: 0.4; cursor: not-allowed; }

    @media (max-width: 768px) {
        .saldo-stats { grid-template-columns: 1fr; }
        .saldo-amount { font-size: 36px; }
        .mutasi-table thead { display: none; }
        .mutasi-table, .mutasi-table tbody, .mutasi-table tr, .mutasi-table td { display: block; width: 100%; }
        .mutasi-table tr { padding: 16px; border-bottom: 1px solid var(--border); }
        .mutasi-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; font-size: 13px; }
        .mutasi-table tbody td::before { content: attr(data-label); font-weight: 600; color: var(--gray); font-size: 11px; text-transform: uppercase; }
        .page-header-premium { padding: 22px 20px; }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Saldo Akun</h3>
                                <p>Kelola saldo dari cashback promo & transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="saldo-big-card">
                    <div class="saldo-label">Saldo Tersedia</div>
                    <div class="saldo-amount">Rp {{ number_format($pelanggan->saldo, 0, ',', '.') }}</div>
                    <div class="saldo-desc">
                        Saldo dari cashback tidak kadaluwarsa &bull; Gunakan untuk pembayaran checkout
                    </div>
                </div>

                <div class="saldo-stats">
                    <div class="stat-mini">
                        <div class="sm-icon kredit"><i class="fa-solid fa-arrow-down"></i></div>
                        <div class="sm-value kredit">+Rp {{ number_format($totalKredit, 0, ',', '.') }}</div>
                        <div class="sm-label">Total Kredit</div>
                    </div>
                    <div class="stat-mini">
                        <div class="sm-icon debit"><i class="fa-solid fa-arrow-up"></i></div>
                        <div class="sm-value debit">-Rp {{ number_format($totalDebit, 0, ',', '.') }}</div>
                        <div class="sm-label">Total Debit</div>
                    </div>
                    <div class="stat-mini">
                        <div class="sm-icon" style="background:#FEE7EF;color:var(--primary);"><i class="fa-solid fa-exchange-alt"></i></div>
                        <div class="sm-value">{{ $totalMutasi }}</div>
                        <div class="sm-label">Total Mutasi</div>
                    </div>
                </div>

                <div class="mutasi-card">
                    <div class="mutasi-header">
                        <div class="mutasi-title">
                            <i class="fa-solid fa-list text-pink-500 mr-2"></i>
                            Riwayat Mutasi Saldo
                        </div>
                    </div>

                    @if($mutasi->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="mutasi-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                    <th>Keterangan</th>
                                    <th>Saldo Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutasi as $m)
                                <tr>
                                    <td data-label="Tanggal">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($m->created_at)->isoFormat('D MMM YYYY HH:mm') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jenis">
                                        <span class="mutasi-type {{ $m->type }}">
                                            <i class="fa-solid {{ $m->type === 'kredit' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                            {{ ucfirst($m->type) }}
                                        </span>
                                    </td>
                                    <td data-label="Nominal">
                                        <span class="mutasi-nominal {{ $m->type }}">
                                            {{ $m->type === 'kredit' ? '+' : '-' }}Rp {{ number_format($m->nominal, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td data-label="Keterangan">
                                        <div class="mutasi-info">
                                            <span class="mi-label">{{ $m->keterangan }}</span>
                                            @if($m->ref_type && $m->ref_id)
                                            <span class="mi-desc">Ref: {{ $m->ref_type }} #{{ $m->ref_id }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="Saldo Akhir">
                                        <span style="font-weight:600;color:var(--dark);font-variant-numeric:tabular-nums;">
                                            Rp {{ number_format($m->saldo_sesudah, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-custom">
                        {{ $mutasi->links()->toHtml() }}
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="es-illustration"><i class="fa-solid fa-wallet"></i></div>
                        <h4>Belum Ada Mutasi</h4>
                        <p>Saldo akan bertambah saat Anda mendapatkan cashback dari promo transaksi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>