<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Top Up Saldo - BeautyCare</title>
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
    .page-header-premium .ph-content { display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; gap: 16px; flex-wrap: wrap; }
    .page-header-premium .ph-left { display: flex; align-items: center; gap: 16px; }
    .page-header-premium .ph-icon-wrap {
        width: 52px; height: 52px; border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px;
        box-shadow: 0 8px 20px rgba(255,79,135,0.25);
    }
    .page-header-premium .ph-text h3 { font-size: 20px; font-weight: 700; color: var(--dark); margin: 0; }
    .page-header-premium .ph-text p { font-size: 13px; color: var(--gray); margin: 4px 0 0; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 100px;
        border: 1.5px solid var(--primary); background: var(--white); color: var(--primary);
        font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif; text-decoration: none;
        box-shadow: 0 4px 12px rgba(255,79,135,0.15);
    }
    .btn-back:hover { background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; transform: translateY(-1px); }

    .topup-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .topup-layout { grid-template-columns: 1fr; } }

    .topup-card { background: #fff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden; }
    .topup-card .tc-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
    .topup-card .tc-icon { width: 38px; height: 38px; border-radius: 12px; background: var(--hover); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .topup-card .tc-title { font-size: 15px; font-weight: 700; color: var(--dark); }
    .topup-card .tc-subtitle { font-size: 12px; color: var(--gray); }
    .topup-card .tc-body { padding: 24px; }

    .saldo-mini {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border: 1px solid #A7F3D0; border-radius: 16px; padding: 16px 20px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px;
    }
    .saldo-mini .sm-label { font-size: 11px; font-weight: 600; color: #047857; text-transform: uppercase; letter-spacing: .6px; }
    .saldo-mini .sm-nominal { font-size: 20px; font-weight: 800; color: #065F46; font-variant-numeric: tabular-nums; }

    .nominal-label { font-size: 12px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 12px; }
    .nominal-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    @media (max-width: 480px) { .nominal-grid { grid-template-columns: repeat(2, 1fr); } }
    .nominal-chip {
        position: relative; cursor: pointer;
        padding: 14px 10px; border-radius: 14px; text-align: center;
        border: 1.5px solid var(--border); background: #FAFAFA; font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease; font-variant-numeric: tabular-nums;
    }
    .nominal-chip .nc-nominal { font-size: 14px; font-weight: 800; color: var(--dark); }
    .nominal-chip input { display: none; }
    .nominal-chip.active { border-color: var(--primary); background: #FFF5F8; box-shadow: 0 4px 14px rgba(255,79,135,0.15); }
    .nominal-chip.active .nc-nominal { color: var(--primary); }

    .nominal-custom { margin-top: 12px; position: relative; }
    .nominal-custom input {
        width: 100%; padding: 12px 16px 12px 42px; border-radius: 14px;
        border: 1.5px solid var(--border); background: #FAFAFA; font-size: 14px;
        font-family: 'Poppins', sans-serif; color: var(--dark); outline: none; font-variant-numeric: tabular-nums;
        transition: all 0.2s ease;
    }
    .nominal-custom input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(255,79,135,0.1); }
    .nominal-custom .nc-prefix { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 13px; font-weight: 600; color: var(--gray); }
    .nominal-note { font-size: 11px; color: var(--gray); margin-top: 10px; }

    .pay-group { margin-bottom: 20px; }
    .pay-group .pg-title { font-size: 12px; font-weight: 700; color: var(--dark); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; }
    .pay-group .pg-title i { color: var(--primary); margin-right: 6px; }
    .pay-option {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 16px; border-radius: 14px; cursor: pointer;
        border: 1.5px solid var(--border); background: #FAFAFA; margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .pay-option input { accent-color: var(--primary); width: 16px; height: 16px; margin: 0; flex-shrink: 0; }
    .pay-option:hover { border-color: var(--primary); background: #FFF9FB; }
    .pay-option.active { border-color: var(--primary); background: #FFF5F8; box-shadow: 0 4px 14px rgba(255,79,135,0.12); }
    .po-icon { width: 34px; height: 34px; border-radius: 10px; background: #fff; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 15px; color: var(--primary); flex-shrink: 0; }
    .po-icon img { width: 20px; height: 20px; object-fit: contain; }
    .po-label { font-size: 13px; font-weight: 600; color: var(--dark); }
    .po-desc { font-size: 11px; color: var(--gray); }

    .ringkasan {
        background: #FFF9FB; border: 1px solid #FFE5EF; border-radius: 16px; padding: 16px 20px; margin-top: 4px;
    }
    .ringkasan .rk-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--gray); padding: 5px 0; }
    .ringkasan .rk-row.rk-total { border-top: 1px solid #FFE5EF; margin-top: 8px; padding-top: 12px; }
    .ringkasan .rk-row.rk-total .rk-label { font-weight: 700; color: var(--dark); font-size: 14px; }
    .ringkasan .rk-row .rk-value { font-weight: 700; color: var(--dark); font-variant-numeric: tabular-nums; }
    .ringkasan .rk-row.rk-total .rk-value { font-size: 20px; font-weight: 800; color: var(--primary); }

    .btn-topup {
        width: 100%; margin-top: 20px;
        padding: 14px; border-radius: 14px; border: none;
        background: linear-gradient(135deg, #10B981, #34D399); color: #fff;
        font-size: 14px; font-weight: 700; font-family: 'Poppins', sans-serif; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        box-shadow: 0 6px 20px rgba(16,185,129,0.3); transition: all 0.2s ease;
    }
    .btn-topup:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
    .btn-topup:disabled { opacity: 0.5; cursor: not-allowed; }

    .co-note { margin-top: 12px; font-size: 11.5px; color: var(--gray); display: flex; align-items: center; gap: 6px; }
    .co-note i { color: var(--primary); }

    .alert-box { padding: 12px 16px; border-radius: 12px; font-size: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .alert-box.alert-error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
    .alert-box.alert-success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }

    @media (max-width: 768px) {
        .page-header-premium { padding: 22px 20px; }
        .topup-card .tc-body { padding: 18px; }
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
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Top Up Saldo</h3>
                                <p>Isi saldo akun Anda dengan metode pembayaran pilihan</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.saldo.index') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Saldo
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('pelanggan.saldo.topup.store') }}" method="POST" id="topupForm">
                    @csrf
                    <input type="hidden" name="metode" id="inpMetode">
                    <input type="hidden" name="provider" id="inpProvider">
                    <input type="hidden" name="bank_id" id="inpBankId">

                    <div class="topup-layout">
                        <div class="topup-card">
                            <div class="tc-header">
                                <div class="tc-icon"><i class="fa-solid fa-coins"></i></div>
                                <div>
                                    <div class="tc-title">Pilih Nominal</div>
                                    <div class="tc-subtitle">Minimal Rp 10.000, maksimal Rp 2.000.000</div>
                                </div>
                            </div>
                            <div class="tc-body">
                                <div class="saldo-mini">
                                    <div>
                                        <div class="sm-label">Saldo Saat Ini</div>
                                        <div class="sm-nominal">Rp {{ number_format($pelanggan->saldo, 0, ',', '.') }}</div>
                                    </div>
                                    <i class="fa-solid fa-wallet" style="font-size:24px;color:#10B981;"></i>
                                </div>

                                <div class="nominal-label">Pilih nominal top up</div>
                                <div class="nominal-grid" id="nominalGrid">
                                    @foreach ([10000, 25000, 50000, 100000, 250000, 500000, 1000000, 2000000] as $n)
                                    <label class="nominal-chip" data-nominal="{{ $n }}">
                                        <input type="radio" name="chnominal" value="{{ $n }}">
                                        <span class="nc-nominal">Rp {{ number_format($n, 0, ',', '.') }}</span>
                                    </label>
                                    @endforeach
                                </div>

                                <div class="nominal-custom">
                                    <span class="nc-prefix">Rp</span>
                                    <input type="number" name="nominal" id="inpNominal" min="10000" max="2000000" step="1000"
                                        placeholder="Nominal lainnya (contoh: 75000)" oninput="hitungRingkasan()">
                                </div>
                                <div class="nominal-note">
                                    <i class="fa-solid fa-circle-info"></i>
                                    Nominal Anda akan dikonfirmasi kasir setelah pembayaran tervalidasi.
                                </div>
                            </div>
                        </div>

                        <div class="topup-card">
                            <div class="tc-header">
                                <div class="tc-icon"><i class="fa-solid fa-wallet"></i></div>
                                <div>
                                    <div class="tc-title">Metode Pembayaran</div>
                                    <div class="tc-subtitle">Pilih salah satu metode</div>
                                </div>
                            </div>
                            <div class="tc-body">
                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-qrcode"></i> QRIS</div>
                                    <label class="pay-option" data-metode="QRIS" data-provider="QRIS">
                                        <input type="radio" name="pay" value="QRIS">
                                        <div class="po-icon"><i class="fa-solid fa-qrcode"></i></div>
                                        <div>
                                            <div class="po-label">QRIS (Semua Aplikasi)</div>
                                            <div class="po-desc">Scan sekali untuk semua e-wallet & m-banking</div>
                                        </div>
                                    </label>
                                </div>

                                <div class="pay-group">
                                    <div class="pg-title"><i class="fa-solid fa-building-columns"></i> Transfer Bank (Virtual Account)</div>
                                    @foreach($banks as $bank)
                                    <label class="pay-option" data-metode="Transfer" data-provider="{{ $bank->nama_bank }}" data-bank-id="{{ $bank->id }}">
                                        <input type="radio" name="pay" value="{{ $bank->nama_bank }}">
                                        <div class="po-icon">
                                            @if($bank->logo)
                                            <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->nama_bank }}">
                                            @else
                                            <i class="fa-solid fa-building-columns"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="po-label">Bank {{ $bank->nama_bank }}</div>
                                            <div class="po-desc">Virtual Account otomatis, valid 15 menit</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>

                                <div class="ringkasan">
                                    <div class="rk-row">
                                        <span class="rk-label">Nominal Top Up</span>
                                        <span class="rk-value" id="ringkasNominal">Rp 0</span>
                                    </div>
                                    <div class="rk-row rk-total">
                                        <span class="rk-label">Total Bayar</span>
                                        <span class="rk-value" id="ringkasTotal">Rp 0</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn-topup" id="btnTopup" disabled>
                                    <i class="fa-solid fa-circle-check"></i> Top Up Sekarang
                                </button>

                                <div class="co-note">
                                    <i class="fa-regular fa-clock"></i>
                                    Batas bayar QRIS 3 menit, Transfer 15 menit
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function formatAngka(n) {
            return Number(n).toLocaleString('id-ID');
        }

        function hitungRingkasan() {
            var nominal = parseInt(document.getElementById('inpNominal').value || '0', 10);
            var chips = document.querySelectorAll('.nominal-chip.active');
            if (chips.length > 0) {
                nominal = parseInt(chips[0].getAttribute('data-nominal'), 10);
            }

            var label = document.getElementById('ringkasNominal');
            var total = document.getElementById('ringkasTotal');
            var btn = document.getElementById('btnTopup');
            var pay = document.querySelector('.pay-option.active');

            label.textContent = nominal > 0 ? 'Rp ' + formatAngka(nominal) : 'Rp 0';
            total.textContent = nominal > 0 ? 'Rp ' + formatAngka(nominal) : 'Rp 0';

            btn.disabled = !(nominal >= 10000 && nominal <= 2000000 && pay);
        }

        document.querySelectorAll('.nominal-chip').forEach(function(chip) {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.nominal-chip').forEach(function(c) {
                    c.classList.remove('active');
                });
                chip.classList.add('active');
                document.getElementById('inpNominal').value = chip.getAttribute('data-nominal');
                hitungRingkasan();
            });
        });

        document.getElementById('inpNominal').addEventListener('input', function() {
            document.querySelectorAll('.nominal-chip').forEach(function(c) {
                c.classList.remove('active');
            });
            hitungRingkasan();
        });

        document.querySelectorAll('.pay-option').forEach(function(opt) {
            opt.addEventListener('click', function() {
                document.querySelectorAll('.pay-option').forEach(function(o) {
                    o.classList.remove('active');
                });
                opt.classList.add('active');
                opt.querySelector('input').checked = true;
                document.getElementById('inpMetode').value = opt.getAttribute('data-metode');
                document.getElementById('inpProvider').value = opt.getAttribute('data-provider');
                document.getElementById('inpBankId').value = opt.getAttribute('data-bank-id') || '';
                hitungRingkasan();
            });
        });

        document.getElementById('topupForm').addEventListener('submit', function(e) {
            var nominal = parseInt(document.getElementById('inpNominal').value || '0', 10);
            var metode = document.getElementById('inpMetode').value;
            var bankId = document.getElementById('inpBankId').value;

            if (nominal < 10000 || nominal > 2000000) {
                e.preventDefault();
                alert('Nominal top up harus antara Rp 10.000 sampai Rp 2.000.000.');
                return;
            }
            if (!metode || (metode === 'Transfer' && !bankId)) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran terlebih dahulu.');
                return;
            }
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>