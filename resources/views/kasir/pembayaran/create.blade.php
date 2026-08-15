<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Proses Pembayaran - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">
    <style>
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
    </style>
    <style>

        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: var(--font-primary); }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .badge { border-radius: 999px; font-size: 11px; font-weight: 600; padding: 4px 12px; display: inline-flex; align-items: center; gap: 4px; }
        .bank-card-hero { border-radius: 18px; padding: 24px 22px; color: #fff; box-shadow: 0 10px 24px rgba(0,0,0,0.18); position: relative; overflow: hidden; }
        .bank-card-hero::after { content: ''; position: absolute; right: -40px; top: -40px; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.08); }
        .bank-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .bank-card-name { font-size: 17px; font-weight: 800; letter-spacing: 2px; }
        .bank-card-chip { width: 36px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 13px; }
        .bank-card-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.75; font-weight: 600; }
        .bank-card-va { font-size: 20px; font-weight: 800; letter-spacing: 1.5px; font-family: 'Courier New', monospace; margin-top: 4px; word-break: break-all; }
        .bank-card-owner { margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(255,255,255,0.35); display: flex; flex-direction: column; gap: 3px; }
        .bank-card-owner span { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.75; font-weight: 600; }
        .bank-card-owner b { font-size: 13px; font-weight: 700; letter-spacing: 0.5px; word-break: break-all; }
        .bank-card-copy { margin-top: 16px; width: 100%; padding: 10px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.35); background: rgba(255,255,255,0.12); color: #fff; font-size: 12px; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background 0.2s; }
        .bank-card-copy:hover { background: rgba(255,255,255,0.22); }
        .bank-card-copy.copied { background: #10B981; border-color: #10B981; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">💳</div>

                    <div class="flex flex-wrap justify-between items-center gap-2 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-credit-card text-pink-500 mr-2"></i>Proses Pembayaran
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-pen-to-square text-pink-300 mr-1"></i>Konfirmasi pembayaran reservasi
                            </p>
                        </div>
                        <a href="{{ route('kasir.pembayaran.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    @php
                        $totalBayar = $booking->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0));
                        $sisaBayar = $sisa ?? $totalBayar;
                        $dpPaid = $dpPaid ?? 0;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div class="p-4 bg-gradient-to-br from-pink-50 to-white rounded-xl border border-pink-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-circle-info text-pink-400 mr-1"></i>Informasi Booking
                            </h4>
                            <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400 w-28">ID Booking</td>
                                    <td data-label="" class="py-1.5 font-semibold text-gray-700">#{{ $booking->id_booking }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Pelanggan</td>
                                    <td data-label="" class="py-1.5 font-semibold text-gray-700">{{ $booking->pelanggan->nm_pelanggan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">No. HP</td>
                                    <td data-label="" class="py-1.5 text-gray-700">{{ $booking->pelanggan->no_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Tanggal</td>
                                    <td data-label="" class="py-1.5 text-gray-700">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Jam</td>
                                    <td data-label="" class="py-1.5 text-gray-700">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td data-label="" class="py-1.5 text-gray-400">Karyawan</td>
                                    <td data-label="" class="py-1.5 text-gray-700">{{ $booking->karyawan->nama ?? '-' }}</td>
                                </tr>
                            </table></div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-solid fa-list text-emerald-400 mr-1"></i>Layanan
                            </h4>
                            <div class="overflow-x-auto"><table class="w-full text-[13px] table-card-mobile">
                                <thead>
                                    <tr class="border-b border-emerald-100">
                                        <th class="text-left py-2 text-[11px] font-semibold text-gray-400">Layanan</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400">Harga</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400">Diskon</th>
                                        <th class="text-right py-2 text-[11px] font-semibold text-gray-400">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->detail as $d)
                                    <tr class="border-b border-emerald-50">
                                        <td data-label="Layanan" class="py-2 font-medium text-gray-700">{{ $d->layanan->nm_layanan ?? '-' }}</td>
                                        <td data-label="Harga" class="py-2 text-right text-gray-700">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                        <td data-label="Diskon" class="py-2 text-right text-red-500">Rp {{ number_format($d->diskon ?? 0, 0, ',', '.') }}</td>
                                        <td data-label="Subtotal" class="py-2 text-right font-semibold text-emerald-600">Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="py-3 text-right text-[13px] font-bold text-gray-600">Total</td>
                                        <td class="py-3 text-right text-[16px] font-bold text-pink-500">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table></div>
                        </div>
                    </div>

                    @if($dpPaid > 0)
                    <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 text-[12px] font-medium rounded-xl flex items-start gap-2">
                        <i class="fa-solid fa-circle-info mt-0.5"></i>
                        <div>
                            DP sebesar <b>Rp {{ number_format($dpPaid, 0, ',', '.') }}</b> sudah dibayar online.
                            Sisa tagihan yang dibayar di kasir ini: <b>Rp {{ number_format($sisaBayar, 0, ',', '.') }}</b>.
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('kasir.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_booking" value="{{ $booking->id_booking }}">
                        <input type="hidden" name="total" id="total" value="{{ $sisaBayar }}">

                        <!-- Header eror banner (hidden dulu, muncul kalau error) -->
    @if($errors->any())
        <div class="mb-3 px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-[12px] font-semibold rounded-xl">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-credit-card text-pink-500 mr-2"></i>Metode Pembayaran
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih metode pembayaran</p>

                            @php
                                $bankColors = [
                                    'BRI' => 'linear-gradient(135deg,#00529C,#003A6E)',
                                    'BCA' => 'linear-gradient(135deg,#CC0000,#990000)',
                                    'Mandiri' => 'linear-gradient(135deg,#003D79,#00264D)',
                                    'BNI' => 'linear-gradient(135deg,#FF6600,#CC5200)',
                                    'BSI' => 'linear-gradient(135deg,#005747,#003A2E)',
                                ];
                                $ewalletColors = [
                                    'GoPay' => 'linear-gradient(135deg,#00AED6,#007B99)',
                                    'DANA' => 'linear-gradient(135deg,#0B95D6,#0865A8)',
                                    'ShopeePay' => 'linear-gradient(135deg,#EE4D2D,#C2331A)',
                                    'OVO' => 'linear-gradient(135deg,#4C2B82,#3A1F66)',
                                    'QRIS' => 'linear-gradient(135deg,#10B981,#047857)',
                                ];
                            @endphp
                            <div x-data="paymentBox()" x-init="init()" class="space-y-4">
                                <input type="hidden" name="metode_byr" :value="metode">
                                <input type="hidden" name="bank_id" :value="bankId">
                                <input type="hidden" name="ewallet_type" :value="ewalletType">
                                <input type="hidden" name="dibayar" :value="dibayar">
                                <input type="hidden" name="kembali" :value="kembali">

                                <!-- Accordion: Tunai -->
                                <div class="border border-slate-200 rounded-3xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                                    <div @click="cat = cat === 'cash' ? '' : 'cash'"
                                        class="bg-slate-50/50 px-6 py-4 flex items-center justify-between cursor-pointer select-none border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">💵</span>
                                            <div>
                                                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Tunai</h3>
                                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Pembayaran langsung dengan uang tunai</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                                <i class="fa-regular fa-circle-check"></i> Lunas
                                            </span>
                                            <i class="fa-solid text-slate-400 transition-transform duration-300" :class="cat === 'cash' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                        </div>
                                    </div>

                                    <div x-show="cat === 'cash'" x-transition class="p-6 space-y-4 bg-white border-t border-slate-50">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fa-solid fa-money-bill-1 text-pink-400 mr-1"></i>Jumlah Dibayar <span class="text-red-500">*</span>
                                                </label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                                    <input type="number" id="dibayar_tunai" x-model.number="dibayar"
                                                        class="form-input-custom !pl-8 @error('dibayar') border-red-400 @enderror"
                                                        placeholder="0" min="0">
                                                </div>
                                                @error('dibayar')
                                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fa-solid fa-coins text-pink-400 mr-1"></i>Kembali
                                                </label>
                                                <input type="number" id="kembali_tunai" :value="kembali"
                                                    class="form-input-custom bg-green-50/50 font-bold text-green-700"
                                                    placeholder="0" min="0" readonly>
                                                @error('kembali')
                                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="rounded-2xl bg-emerald-50/50 border border-emerald-100/50 p-4">
                                            <div class="flex items-center gap-2 text-[12px] text-emerald-700">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span>Status otomatis <b>Lunas</b> — saldo &amp; cashback langsung diproses.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion: Bank Transfer -->
                                <div class="border border-slate-200 rounded-3xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                                    <div @click="cat = cat === 'bank' ? '' : 'bank'"
                                        class="bg-slate-50/50 px-6 py-4 flex items-center justify-between cursor-pointer select-none border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">🏦</span>
                                            <div>
                                                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Bank Transfer (Virtual Account)</h3>
                                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Transfer melalui rekening bank BRI, BCA, Mandiri, BNI, atau BSI</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                                                <i class="fa-regular fa-clock"></i> Pending
                                            </span>
                                            <i class="fa-solid text-slate-400 transition-transform duration-300" :class="cat === 'bank' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                        </div>
                                    </div>

                                    <div x-show="cat === 'bank'" x-transition class="p-6 space-y-4 bg-white border-t border-slate-50">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach ($banks as $bank)
                                            <div class="flex flex-col">
                                                <div @click="selectBank({{ $bank->id }})"
                                                    :class="bankId === {{ $bank->id }} ? 'border-pink-500 bg-pink-50/5 ring-2 ring-pink-500/20 z-10' : 'border-slate-200 bg-white z-10'"
                                                    class="relative border-2 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-slate-300 transition-all select-none">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[10px] font-black shrink-0 shadow-inner">{{ $bank->nama_bank }}</span>
                                                        <div>
                                                            <h4 class="text-xs font-extrabold text-slate-800">Bank {{ $bank->nama_bank }}</h4>
                                                            <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Verifikasi manual via bukti transfer</p>
                                                        </div>
                                                    </div>
                                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0" :class="bankId === {{ $bank->id }} ? 'border-pink-500 bg-pink-500 text-white' : 'border-slate-300'">
                                                        <i class="fa-solid fa-check text-[10px]" x-show="bankId === {{ $bank->id }}"></i>
                                                    </div>
                                                </div>

                                                <div x-show="bankId === {{ $bank->id }}" x-transition class="mt-3 space-y-2">
                                                    <div class="bank-card-hero" style="background:{{ $bankColors[$bank->nama_bank] ?? 'linear-gradient(135deg,#64748B,#475569)' }};">
                                                        <div class="bank-card-head">
                                                            <span class="bank-card-name">BANK {{ $bank->nama_bank }}</span>
                                                            <span class="bank-card-chip"><i class="fa-solid fa-building-columns"></i></span>
                                                        </div>
                                                        <div class="bank-card-label">No Rekening</div>
                                                        <div class="bank-card-va">{{ $bank->no_rekening ?? '-' }}</div>
                                                        <div class="bank-card-owner">
                                                            <span>Atas Nama</span>
                                                            <b>{{ $bank->atas_nama }}</b>
                                                        </div>
                                                        <button type="button" class="bank-card-copy" data-label="Salin Nomor Rekening" onclick="salinKode(this)">
                                                            <i class="fa-regular fa-copy"></i> Salin Nomor Rekening
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Accordion: E-Wallet -->
                                <div class="border border-slate-200 rounded-3xl overflow-hidden bg-white shadow-sm transition-all duration-300">
                                    <div @click="cat = cat === 'ewallet' ? '' : 'ewallet'"
                                        class="bg-slate-50/50 px-6 py-4 flex items-center justify-between cursor-pointer select-none border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg">📱</span>
                                            <div>
                                                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Dompet Digital (E-Wallet)</h3>
                                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Transfer mudah melalui GoPay, DANA, atau ShopeePay</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-teal-100 text-teal-700">
                                                <i class="fa-regular fa-circle-check"></i> Lunas
                                            </span>
                                            <i class="fa-solid text-slate-400 transition-transform duration-300" :class="cat === 'ewallet' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                        </div>
                                    </div>

                                    <div x-show="cat === 'ewallet'" x-transition class="p-6 space-y-4 bg-white border-t border-slate-50">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach ($ewallets as $ew)
                                            <div class="flex flex-col">
                                                <div @click="selectEwallet('{{ $ew->nama_bank }}')"
                                                    :class="ewalletType === '{{ $ew->nama_bank }}' ? 'border-teal-500 bg-teal-50/5 ring-2 ring-teal-500/20 z-10' : 'border-slate-200 bg-white z-10'"
                                                    class="relative border-2 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-slate-300 transition-all select-none">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[10px] font-black shrink-0 shadow-inner">{{ $ew->nama_bank }}</span>
                                                        <div>
                                                            <h4 class="text-xs font-extrabold text-slate-800">{{ $ew->nama_bank }}</h4>
                                                            <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Kirim ke akun {{ $ew->nama_bank }} merchant</p>
                                                        </div>
                                                    </div>
                                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0" :class="ewalletType === '{{ $ew->nama_bank }}' ? 'border-teal-500 bg-teal-500 text-white' : 'border-slate-300'">
                                                        <i class="fa-solid fa-check text-[10px]" x-show="ewalletType === '{{ $ew->nama_bank }}'"></i>
                                                    </div>
                                                </div>

                                                <div x-show="ewalletType === '{{ $ew->nama_bank }}'" x-transition class="mt-3 space-y-2">
                                                    <div class="bank-card-hero" style="background:{{ $ewalletColors[$ew->nama_bank] ?? 'linear-gradient(135deg,#0D9488,#0F766E)' }};">
                                                        <div class="bank-card-head">
                                                            <span class="bank-card-name">{{ strtoupper($ew->nama_bank) }}</span>
                                                            <span class="bank-card-chip"><i class="fa-solid fa-wallet"></i></span>
                                                        </div>
                                                        <div class="bank-card-label">No Rekening</div>
                                                        <div class="bank-card-va">{{ $ew->nomor_telepon ?? '-' }}</div>
                                                        <div class="bank-card-owner">
                                                            <span>Atas Nama</span>
                                                            <b>{{ $ew->atas_nama }}</b>
                                                        </div>
                                                        <button type="button" class="bank-card-copy" data-label="Salin Nomor" onclick="salinKode(this)">
                                                            <i class="fa-regular fa-copy"></i> Salin Nomor
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Field tambahan per metode -->
                                <div x-show="metode === 'Transfer'" x-transition class="rounded-2xl bg-amber-50/50 border border-amber-100/50 p-4 space-y-3">
                                    <div class="mb-2">
                                        <label class="form-label">
                                            <i class="fa-solid fa-flag text-pink-400 mr-1"></i>Status <span class="text-red-500">*</span>
                                        </label>
                                        <select name="status" class="form-input-custom">
                                            <option value="Proses" {{ old('status', 'Proses') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        <p class="text-[11px] text-gray-400 mt-1">Dibayar otomatis: <b>Rp {{ number_format($sisaBayar, 0, ',', '.') }}</b> — tanpa kembalian</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-solid fa-hashtag text-pink-400 mr-1"></i>No. Referensi
                                            </label>
                                            <input type="text" name="no_referensi" id="no_referensi"
                                                class="form-input-custom @error('no_referensi') border-red-400 @enderror"
                                                placeholder="Otomatis" value="{{ old('no_referensi') }}" readonly>
                                            @error('no_referensi')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-solid fa-image text-pink-400 mr-1"></i>Upload Bukti Pembayaran
                                            </label>
                                            <input type="file" name="bukti_bayar"
                                                class="form-input-custom @error('bukti_bayar') border-red-400 @enderror"
                                                accept="image/*"
                                                :disabled="metode !== 'Transfer'">
                                            @error('bukti_bayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="metode === 'E-Wallet'" x-transition class="rounded-2xl bg-teal-50/50 border border-teal-100/50 p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-solid fa-money-bill-1 text-pink-400 mr-1"></i>Jumlah Dibayar <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                                <input type="number" id="dibayar_ewallet" x-model.number="dibayar"
                                                    class="form-input-custom !pl-8 @error('dibayar') border-red-400 @enderror"
                                                    placeholder="0" min="0">
                                            </div>
                                            @error('dibayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-solid fa-coins text-pink-400 mr-1"></i>Kembali
                                            </label>
                                            <input type="number" id="kembali_ewallet" :value="kembali"
                                                class="form-input-custom bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" min="0" readonly>
                                            @error('kembali')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-solid fa-image text-pink-400 mr-1"></i>Upload Bukti Bayar
                                            </label>
                                            <input type="file" name="bukti_bayar"
                                                class="form-input-custom @error('bukti_bayar') border-red-400 @enderror"
                                                accept="image/*"
                                                :disabled="metode !== 'E-Wallet'">
                                            @error('bukti_bayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-[11px] text-gray-400 mt-1">Screenshot bukti pembayaran E-Wallet</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group mt-4">
                            <label class="form-label">
                                <i class="fa-solid fa-note-sticky text-pink-400 mr-1"></i>Catatan
                            </label>
                            <textarea name="catatan" rows="3" class="form-input-custom @error('catatan') border-red-400 @enderror"
                                placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" id="btn-simpan-transaksi"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-regular fa-circle-check"></i> Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ========== Payment Method (Alpine) ==========
        function salinKode(btn) {
            const card = btn.closest('.bank-card-hero');
            const kode = (card.querySelector('.bank-card-va').textContent || '').trim();
            if (!kode) return;
            navigator.clipboard.writeText(kode).then(function() {
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin!';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = '<i class="fa-regular fa-copy"></i> ' + (btn.getAttribute('data-label') || 'Salin');
                }, 2000);
            });
        }

        function paymentBox() {
            const totalBayar = @json((float) $sisaBayar);
            return {
                cat: 'bank',
                bankId: @json((int) old('bank_id', $banks->first()?->id ?? 0)),
                ewalletType: @json(old('ewallet_type', '')),
                totalBayar: totalBayar,
                dibayar: totalBayar,
                kembali: 0,
                selectTunai() { this.cat = 'cash'; this.bankId = 0; this.ewalletType = ''; this.dibayar = this.totalBayar; },
                selectBank(id) { this.cat = 'bank'; this.bankId = id; this.ewalletType = ''; this.dibayar = this.totalBayar; },
                selectEwallet(name) { this.cat = 'ewallet'; this.ewalletType = name; this.bankId = 0; this.dibayar = this.totalBayar; },
                get metode() {
                    if (this.cat === 'cash') return 'Tunai';
                    return this.ewalletType ? 'E-Wallet' : 'Transfer';
                },
                init() {
                    const oldDibayar = @json(old('dibayar', null));
                    if (oldDibayar !== null && oldDibayar !== '') this.dibayar = parseFloat(oldDibayar) || this.totalBayar;
                    if (@json(old('metode_byr')) === 'Tunai') this.cat = 'cash';
                    if (this.ewalletType) this.cat = 'ewallet';
                    this.$watch('dibayar', v => this.kembali = Math.max(0, v - this.totalBayar));
                    this.kembali = Math.max(0, this.dibayar - this.totalBayar);
                }
            };
        }

        function generateNoReferensi() {
            const now = new Date();
            const y = now.getFullYear();
            const m = String(now.getMonth() + 1).padStart(2, '0');
            const d = String(now.getDate()).padStart(2, '0');
            const rand = String(Math.floor(Math.random() * 9000) + 1000);
            return 'REF-' + y + m + d + '-' + rand;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('no_referensi').value = generateNoReferensi();
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
