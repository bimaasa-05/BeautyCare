<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Transaksi - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
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
        .form-input-custom[readonly] { background-color: #f9f9f9; cursor: not-allowed; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
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
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">🧾</div>

                    <div class="flex flex-wrap justify-between items-center gap-2 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-plus-circle text-pink-500 mr-2"></i>Tambah Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-pen-to-square text-pink-300 mr-1"></i>Isi detail transaksi baru
                            </p>
                        </div>
                        <a href="{{ route('kasir.transaksi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('kasir.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION 1: Pelanggan & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-user text-pink-400 mr-1"></i>Pelanggan <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $optsPelanggan = $pelanggan->map(fn($p) => [
                                        'value' => $p->id_pelanggan,
                                        'label' => $p->nm_pelanggan . ($p->id_member ? ' (' . ($p->membership->tingkat ?? '') . ' - Diskon ' . ($p->membership->diskon ?? 0) . '%)' : '')
                                    ])->sortBy('label')->values();
                                @endphp
                                <div x-data="searchableSelect()" x-init='init($el.querySelector("select"), @json($optsPelanggan), @json(old("id_pelanggan", "")))' class="relative">
                                    <select name="id_pelanggan" id="id_pelanggan" class="hidden @error('id_pelanggan') border-red-400 @enderror" onchange="onPelangganChange(this)">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggan as $p)
                                            <option value="{{ $p->id_pelanggan }}"
                                                data-member="{{ $p->id_member ?? '' }}"
                                                data-tingkat="{{ $p->membership->tingkat ?? '' }}"
                                                data-diskon="{{ $p->membership->diskon ?? 0 }}"
                                                {{ old('id_pelanggan') == $p->id_pelanggan ? 'selected' : '' }}>
                                                {{ $p->nm_pelanggan }} @if($p->id_member)({{ $p->membership->tingkat ?? '' }} - Diskon {{ $p->membership->diskon ?? 0 }}%) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="relative">
                                        <input type="text" x-model="query" @focus="open = true" @click="open = true" @input="onQueryInput()"
                                            @keydown.escape="open = false" @keydown.down.prevent="moveHighlight(1)" @keydown.up.prevent="moveHighlight(-1)"
                                            @keydown.enter.prevent="selectHighlighted()" @blur="setTimeout(() => open = false, 150)"
                                            class="form-input-custom pr-9 @error('id_pelanggan') border-red-400 @enderror"
                                            placeholder="Pilih Pelanggan" autocomplete="off">
                                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                                    </div>
                                    <div x-show="open" x-transition
                                        class="absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                                        <ul class="max-h-48 overflow-y-auto py-1">
                                            <template x-for="(opt, i) in filtered" :key="opt.value">
                                                <li @click="select(opt.value, opt.label)" @mouseenter="highlight = i"
                                                    class="px-3 py-2 text-[12px] cursor-pointer hover:bg-pink-50 hover:text-pink-600 transition-colors"
                                                    :class="i === highlight ? 'bg-pink-50 text-pink-600 font-semibold' : 'text-gray-700'"
                                                    x-text="opt.label"></li>
                                            </template>
                                            <li x-show="filtered.length === 0" class="px-3 py-2 text-[11px] text-gray-400">Tidak ada hasil</li>
                                        </ul>
                                    </div>
                                </div>
                                @error('id_pelanggan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-calendar text-pink-400 mr-1"></i>Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal"
                                    class="form-input-custom @error('tanggal') border-red-400 @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                                @error('tanggal')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 2: Daftar Item -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-cart-shopping text-pink-500 mr-2"></i>Daftar Item
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih layanan atau produk yang dibeli pelanggan</p>

                            <div id="item-container"></div>

                            <button type="button" onclick="addItemRow()"
                                class="flex items-center gap-2 text-pink-500 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-50 transition-colors border border-dashed border-pink-200 mt-3">
                                <i class="fa-solid fa-plus"></i> Tambah Item
                            </button>

                            <!-- Info Membership -->
                            <div id="member-info" class="mt-3 hidden">
                                <div class="flex items-center gap-2 text-[12px] px-4 py-2 rounded-lg bg-purple-50 text-purple-700 border border-purple-100">
                                    <i class="fa-solid fa-crown"></i>
                                    <span id="member-info-text"></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Metode Pembayaran -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-credit-card text-pink-500 mr-2"></i>Metode Pembayaran
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Silakan pilih salah satu opsi pembayaran di bawah ini</p>

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
                                <input type="hidden" name="bank_id" :value="metode === 'Transfer' ? bankId : ''">
                                <input type="hidden" name="ewallet_type" :value="metode === 'E-Wallet' ? ewalletType : ''">

                                @if($errors->any())
                                    <div class="mb-3 px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-[12px] font-semibold rounded-xl">
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

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
                                        <div class="rounded-2xl bg-emerald-50/50 border border-emerald-100/50 p-4">
                                            <div class="flex items-center gap-2 text-[12px] text-emerald-700">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span>Status otomatis <b>Lunas</b> — isi jumlah dibayar &amp; kembalian di bagian <b>Ringkasan</b>.</span>
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
                                        <i class="fa-solid text-slate-400 transition-transform duration-300" :class="cat === 'bank' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
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
                                        <i class="fa-solid text-slate-400 transition-transform duration-300" :class="cat === 'ewallet' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
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
                                        <select name="status" class="form-input-custom" :disabled="metode !== 'Transfer'">
                                            <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
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
                                                accept="image/*">
                                            @error('bukti_bayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="metode === 'E-Wallet'" x-transition class="rounded-2xl bg-teal-50/50 border border-teal-100/50 p-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-image text-pink-400 mr-1"></i>Upload Bukti Bayar
                                        </label>
                                        <input type="file" name="bukti_bayar"
                                            class="form-input-custom @error('bukti_bayar') border-red-400 @enderror"
                                            accept="image/*">
                                        @error('bukti_bayar')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-[11px] text-gray-400 mt-1">Screenshot bukti pembayaran E-Wallet</p>
                                    </div>
                                </div>

                                @error('bank_id')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                                @error('ewallet_type')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 4: Ringkasan -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-calculator text-pink-500 mr-2"></i>Ringkasan
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Total pembayaran dan perhitungan diskon</p>

                            <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-100">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Total -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-coins text-pink-400 mr-1"></i>Total <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="total_display" id="total_display"
                                                class="form-input-custom !pl-8 bg-pink-50/50 font-bold @error('total') border-red-400 @enderror"
                                                placeholder="0" readonly>
                                            <input type="hidden" name="total" id="total" value="0">
                                        </div>
                                        @error('total')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Diskon Membership -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-money-bill-wave text-pink-400 mr-1"></i>Diskon Membership
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="diskon_display" id="diskon_display"
                                                class="form-input-custom !pl-8"
                                                placeholder="0" readonly>
                                            <input type="hidden" name="diskon" id="diskon" value="0">
                                        </div>
                                    </div>

                                    <!-- Pajak -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-percent text-pink-400 mr-1"></i>Pajak
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="pajak_display" id="pajak_display"
                                                class="form-input-custom !pl-8 @error('pajak') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('pajak', 0) }}" oninput="onPajakChange(this)">
                                            <input type="hidden" name="pajak" id="pajak" value="{{ old('pajak', 0) }}">
                                        </div>
                                        @error('pajak')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Dibayar -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-money-bill-1 text-pink-400 mr-1"></i>Dibayar <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="dibayar_display" id="dibayar_display"
                                                class="form-input-custom !pl-8 @error('dibayar') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('dibayar', 0) }}" oninput="onDibayarChange(this)">
                                            <input type="hidden" name="dibayar" id="dibayar" value="{{ old('dibayar', 0) }}">
                                        </div>
                                        @error('dibayar')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Kembali -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-solid fa-coins text-pink-400 mr-1"></i>Kembali
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="kembali_display" id="kembali_display"
                                                class="form-input-custom !pl-8 bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" readonly>
                                            <input type="hidden" name="kembali" id="kembali" value="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- Subtotal info (hidden, just for calculation) -->
                                <input type="hidden" name="subtotal" id="subtotal" value="0">
                            </div>
                        </div>

                        <!-- SECTION 5: Catatan & Submit -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-note-sticky text-pink-400 mr-1"></i>Catatan
                                    </label>
                                    <textarea name="catatan" rows="3" class="form-input-custom @error('catatan') border-red-400 @enderror"
                                        placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mt-4">
                                <button type="submit" id="btn-simpan-transaksi"
                                    class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                    <i class="fa-regular fa-circle-check"></i> Bayar & Simpan
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        const layananData = @json($layanan);
        const produkData = @json($produk);
        let itemRowIndex = 0;

        // ========== Format Rupiah ==========
        function formatRp(value) {
            return new Intl.NumberFormat('id-ID').format(Math.round(value));
        }

        function parseRp(str) {
            return parseFloat(str.replace(/[^0-9,-]/g, '').replace(',', '.')) || 0;
        }

        // ========== Pelanggan & Membership ==========
        function onPelangganChange(select) {
            const opt = select.options[select.selectedIndex];
            const tingkat = opt ? opt.dataset.tingkat : '';
            const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
            const member = opt ? opt.dataset.member : '';

            const infoEl = document.getElementById('member-info');
            const infoText = document.getElementById('member-info-text');

            if (member && tingkat) {
                infoEl.classList.remove('hidden');
                infoText.textContent = 'Member ' + tingkat + ' — Diskon ' + diskonPct + '%';
            } else {
                infoEl.classList.add('hidden');
                infoText.textContent = '';
            }

            recalculateSubtotal();
        }

        // ========== Item Functions ==========
        function getItemTemplate(index) {
            return `
            <div class="item-row flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 sm:gap-3 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-100" data-index="${index}">
                <input type="hidden" name="items[${index}][jenis]" class="item-jenis-hidden" value="Layanan">
                <input type="hidden" name="items[${index}][id_item]" class="item-id-hidden" value="">
                <input type="hidden" name="items[${index}][nm_item]" class="item-nama-hidden" value="">
                <input type="hidden" name="items[${index}][qty]" class="item-qty-hidden" value="1">
                <input type="hidden" name="items[${index}][harga]" class="item-harga-hidden" value="0">
                <input type="hidden" name="items[${index}][subtotal]" class="item-subtotal-hidden" value="0">
                <input type="hidden" name="items[${index}][jam]" class="item-jam-hidden" value="">
                <input type="hidden" name="items[${index}][id_karyawan]" class="item-karyawan-hidden" value="">

                <select class="form-input-custom item-jenis-select w-full sm:!w-[120px] !py-2 !text-[12px] sm:flex-shrink-0"
                    onchange="onJenisChange(this)">
                    <option value="Layanan">Layanan</option>
                    <option value="Produk">Produk</option>
                </select>
                <select class="form-input-custom item-select w-full sm:!flex-1 sm:!min-w-[200px] !py-2 !text-[12px]"
                    onchange="onItemChange(this)">
                    <option value="">-- Pilih --</option>
                </select>
                <span class="item-harga-display text-[12px] text-gray-600 font-medium w-full sm:w-24 text-right sm:flex-shrink-0">Rp 0</span>
                <input type="number" value="1" min="1"
                    class="form-input-custom item-qty w-full sm:!w-16 !py-2 !text-[12px] text-center sm:flex-shrink-0"
                    oninput="onQtyChange(this)">
                <span class="item-subtotal-display text-[13px] text-pink-600 font-bold w-full sm:w-32 text-right sm:flex-shrink-0">Rp 0</span>
                
                <!-- Layanan fields: Jam & Karyawan (hidden for Produk) -->
                <div class="item-layanan-fields gap-2 flex-wrap" style="width: 100%; display: flex;">
                    <input type="time" class="form-input-custom item-jam-input w-full sm:!w-32 !py-2 !text-[12px]"
                        onchange="onLayananFieldChange(this)" placeholder="Jam">
                    <select class="form-input-custom item-karyawan-select w-full sm:!w-48 !py-2 !text-[12px]"
                        onchange="onLayananFieldChange(this)">
                        <option value="">-- Karyawan --</option>
                        @foreach($karyawan as $k)
                        <option value="{{ $k->user->id }}">{{ $k->user->nama ?? $k->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" onclick="removeItemRow(this)"
                    class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors sm:flex-shrink-0">
                    <i class="fa-regular fa-trash-can text-xs"></i>
                </button>
            </div>`;
        }

        function loadItemOptions(jenis) {
            const data = jenis === 'Layanan' ? layananData : produkData;
            const idField = jenis === 'Layanan' ? 'id_layanan' : 'id_produk';
            const nmField = jenis === 'Layanan' ? 'nm_layanan' : 'nm_produk';
            const priceField = jenis === 'Layanan' ? 'harga' : 'harga_jual';
            return data.map(item => {
                if (jenis === 'Produk') {
                    const stok = item.stok || 0;
                    return `<option value="${item[idField]}" data-nama="${item[nmField]}" data-harga="${item[priceField] || 0}" data-stok="${stok}">${item[nmField]} | Rp ${Number(item[priceField] || 0).toLocaleString('id-ID')} | Stok: ${stok}</option>`;
                }
                return `<option value="${item[idField]}" data-nama="${item[nmField]}" data-harga="${item[priceField] || 0}">${item[nmField]} (± ${item.durasi || 0} menit) — Rp ${Number(item[priceField] || 0).toLocaleString('id-ID')}</option>`;
            }).join('');
        }

        function addItemRow() {
            const container = document.getElementById('item-container');
            const idx = itemRowIndex++;
            container.insertAdjacentHTML('beforeend', getItemTemplate(idx));
            const row = container.lastElementChild;
            const jenisSelect = row.querySelector('.item-jenis-select');
            const itemSelect = row.querySelector('.item-select');
            itemSelect.innerHTML = '<option value="">-- Pilih --</option>' + loadItemOptions(jenisSelect.value);
            recalculateSubtotal();
        }

        function removeItemRow(btn) {
            const row = btn.closest('.item-row');
            row.remove();
            recalculateSubtotal();
        }

function onJenisChange(select) {
            const row = select.closest('.item-row');
            const itemSelect = row.querySelector('.item-select');
            const jenis = select.value;
            row.querySelector('.item-jenis-hidden').value = jenis;
            itemSelect.innerHTML = '<option value="">-- Pilih --</option>' + loadItemOptions(jenis);
            row.querySelector('.item-id-hidden').value = '';
            row.querySelector('.item-nama-hidden').value = '';
            row.querySelector('.item-harga-hidden').value = 0;
            row.querySelector('.item-harga-display').textContent = 'Rp 0';
            row.querySelector('.item-subtotal-hidden').value = 0;
            row.querySelector('.item-subtotal-display').textContent = 'Rp 0';

            // Show/hide layanan fields
            const layananFields = row.querySelector('.item-layanan-fields');
            const jamInput = row.querySelector('.item-jam-input');
            const karyawanSelect = row.querySelector('.item-karyawan-select');
            if (jenis === 'Layanan') {
                layananFields.style.display = 'flex';
                // Set default jam to now
                if (!jamInput.value) {
                    const now = new Date();
                    jamInput.value = now.toTimeString().slice(0,5);
                }
                row.querySelector('.item-jam-hidden').value = jamInput.value || '';
                row.querySelector('.item-karyawan-hidden').value = karyawanSelect.value || '';
            } else {
                layananFields.style.display = 'none';
                jamInput.value = '';
                karyawanSelect.value = '';
                row.querySelector('.item-jam-hidden').value = '';
                row.querySelector('.item-karyawan-hidden').value = '';
            }

            recalculateSubtotal();
        }

        function onItemChange(select) {
            const row = select.closest('.item-row');
            const option = select.options[select.selectedIndex];
            const jenis = row.querySelector('.item-jenis-select').value;
            if (option && option.value) {
                const harga = parseFloat(option.dataset.harga) || 0;
                row.querySelector('.item-id-hidden').value = option.value;
                row.querySelector('.item-nama-hidden').value = option.dataset.nama;
                row.querySelector('.item-harga-hidden').value = harga;
                row.querySelector('.item-harga-display').textContent = 'Rp ' + formatRp(harga);
                if (jenis === 'Produk') {
                    const stok = parseInt(option.dataset.stok) || 0;
                    row.dataset.stok = stok;
                } else {
                    delete row.dataset.stok;
                }
            } else {
                row.querySelector('.item-id-hidden').value = '';
                row.querySelector('.item-nama-hidden').value = '';
                row.querySelector('.item-harga-hidden').value = 0;
                row.querySelector('.item-harga-display').textContent = 'Rp 0';
                delete row.dataset.stok;
            }
            onQtyChange(row.querySelector('.item-qty'));
        }

        function onQtyChange(input) {
            const row = input.closest('.item-row');
            const qty = parseInt(input.value) || 1;
            if (qty < 1) { input.value = 1; }
            const stok = parseInt(row.dataset.stok);
            if (stok && qty > stok) {
                alert('Stok tidak mencukupi! Stok tersedia: ' + stok);
                input.value = stok;
            }
            const harga = parseFloat(row.querySelector('.item-harga-hidden').value) || 0;
            const subtotal = parseInt(input.value) * harga;
            row.querySelector('.item-qty-hidden').value = parseInt(input.value);
            row.querySelector('.item-subtotal-hidden').value = subtotal;
            row.querySelector('.item-subtotal-display').textContent = 'Rp ' + formatRp(subtotal);
            recalculateSubtotal();
        }

        function onLayananFieldChange(input) {
            const row = input.closest('.item-row');
            const jamInput = row.querySelector('.item-jam-input');
            const karyawanSelect = row.querySelector('.item-karyawan-select');
            row.querySelector('.item-jam-hidden').value = jamInput.value || '';
            row.querySelector('.item-karyawan-hidden').value = karyawanSelect.value || '';
        }

        function recalculateSubtotal() {
            let totalItem = 0;
            document.querySelectorAll('.item-subtotal-hidden').forEach(el => {
                totalItem += parseFloat(el.value) || 0;
            });
            document.getElementById('subtotal').value = totalItem;

            // Calculate membership discount
            const pelangganSelect = document.getElementById('id_pelanggan');
            const opt = pelangganSelect.options[pelangganSelect.selectedIndex];
            const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
            const diskonRp = totalItem * (diskonPct / 100);

            document.getElementById('diskon').value = diskonRp;
            document.getElementById('diskon_display').value = formatRp(diskonRp) + (diskonPct > 0 ? ' (' + diskonPct + '%)' : '');

            hitungTotal();
        }

        // ========== Perhitungan Total ==========
        function hitungTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const diskon = parseFloat(document.getElementById('diskon').value) || 0;
            const pajak = parseFloat(document.getElementById('pajak').value) || 0;
            const total = Math.max(0, subtotal - diskon + pajak);

            document.getElementById('total').value = total;
            document.getElementById('total_display').value = formatRp(total);

            hitungKembali();
        }

        function hitungKembali() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const dibayar = parseFloat(document.getElementById('dibayar').value) || 0;
            const kembali = Math.max(0, dibayar - total);

            document.getElementById('kembali').value = kembali;
            document.getElementById('kembali_display').value = formatRp(kembali);
        }

        // ========== Ringkasan Input Handlers ==========
        function onPajakChange(input) {
            const val = parseRp(input.value);
            document.getElementById('pajak').value = val;
            input.value = val > 0 ? formatRp(val) : '0';
            hitungTotal();
        }

        function onDibayarChange(input) {
            const val = parseRp(input.value);
            document.getElementById('dibayar').value = val;
            input.value = val > 0 ? formatRp(val) : '0';
            hitungKembali();
        }

        // ========== Searchable Select (Alpine) ==========
        function searchableSelect() {
            return {
                open: false,
                query: '',
                options: [],
                value: '',
                selectedText: '',
                highlight: -1,
                init(selectEl, options, initial) {
                    this.options = options;
                    if (initial && String(initial) !== '') {
                        this.value = String(initial);
                        const found = options.find(o => String(o.value) === String(initial));
                        if (found) {
                            this.query = found.label;
                            this.selectedText = found.label;
                        }
                    }
                    this.$watch('value', v => {
                        if (String(selectEl.value) !== String(v)) {
                            selectEl.value = v;
                            selectEl.dispatchEvent(new Event('change'));
                        }
                    });
                },
                get filtered() {
                    const q = this.query.toLowerCase();
                    return this.options.filter(o => !o.disabled && o.label.toLowerCase().includes(q));
                },
                onQueryInput() {
                    if (this.query !== this.selectedText && this.value !== '') this.value = '';
                },
                moveHighlight(dir) {
                    const n = this.filtered.length;
                    if (!n) return;
                    this.highlight = (this.highlight + dir + n) % n;
                },
                select(val, label) {
                    this.value = String(val);
                    this.query = label;
                    this.selectedText = label;
                    this.open = false;
                    this.highlight = -1;
                },
                selectHighlighted() {
                    const list = this.filtered;
                    if (!list.length) return;
                    const idx = this.highlight >= 0 && this.highlight < list.length ? this.highlight : 0;
                    this.select(list[idx].value, list[idx].label);
                }
            };
        }

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
            return {
                cat: 'bank',
                bankId: @json((int) old('bank_id', $banks->first()?->id ?? 0)),
                ewalletType: @json(old('ewallet_type', '')),
                selectTunai() { this.cat = 'cash'; this.bankId = 0; this.ewalletType = ''; },
                selectBank(id) { this.cat = 'bank'; this.bankId = id; this.ewalletType = ''; },
                selectEwallet(name) { this.cat = 'ewallet'; this.ewalletType = name; this.bankId = 0; },
                get metode() {
                    if (this.cat === 'cash') return 'Tunai';
                    return this.ewalletType ? 'E-Wallet' : 'Transfer';
                },
                init() {
                    if (@json(old('metode_byr')) === 'Tunai') this.cat = 'cash';
                    if (this.ewalletType) this.cat = 'ewallet';
                }
            };
        }

        // ========== Auto-fill No Referensi ==========
        function generateNoReferensi() {
            const now = new Date();
            const y = now.getFullYear();
            const m = String(now.getMonth() + 1).padStart(2, '0');
            const d = String(now.getDate()).padStart(2, '0');
            const rand = String(Math.floor(Math.random() * 9000) + 1000);
            return 'REF-' + y + m + d + '-' + rand;
        }

        // ========== Init ==========
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('no_referensi').value = generateNoReferensi();

            // Initialize format Rp for existing values
            const pajakDisplay = document.getElementById('pajak_display');
            if (pajakDisplay && parseFloat(pajakDisplay.value) > 0) {
                pajakDisplay.value = formatRp(parseFloat(pajakDisplay.value));
            } else {
                pajakDisplay.value = '0';
            }
            const dibayarDisplay = document.getElementById('dibayar_display');
            if (dibayarDisplay && parseFloat(dibayarDisplay.value) > 0) {
                dibayarDisplay.value = formatRp(parseFloat(dibayarDisplay.value));
            } else {
                dibayarDisplay.value = '0';
            }

            // Initialize if old pelanggan selected
            const pelangganSelect = document.getElementById('id_pelanggan');
            if (pelangganSelect.value) {
                onPelangganChange(pelangganSelect);
            }
        });

        // Ensure form has valid numeric data before submit
        document.querySelector('form').addEventListener('submit', function() {
            // Convert display values to clean numbers for hidden inputs
            document.getElementById('pajak').value = parseRp(document.getElementById('pajak_display').value);
            document.getElementById('dibayar').value = parseRp(document.getElementById('dibayar_display').value);
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>