<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Transaksi - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: 'Inter', sans-serif; }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .payment-section { display: none; }
        .payment-section.active { display: block; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">✏️</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-pen-to-square text-pink-500 mr-2"></i>Edit Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-pen-to-square text-pink-300 mr-1"></i>Edit transaksi {{ $transaksi->no_invoice }}
                            </p>
                        </div>
                        <a href="{{ route('kasir.transaksi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('kasir.transaksi.update', $transaksi->id_transaksi) }}" method="POST" enctype="multipart/form-data" onsubmit="stopPaymentTimer()">
                        @csrf
                        @method('PUT')

                        <!-- SECTION 1: Pelanggan & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-user text-pink-400 mr-1"></i>Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_pelanggan" id="id_pelanggan" class="form-input-custom @error('id_pelanggan') border-red-400 @enderror" onchange="onPelangganChange(this)">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->id_pelanggan }}"
                                            data-member="{{ $p->id_member ?? '' }}"
                                            data-tingkat="{{ $p->membership->tingkat ?? '' }}"
                                            data-diskon="{{ $p->membership->diskon ?? 0 }}"
                                            {{ old('id_pelanggan', $transaksi->id_pelanggan) == $p->id_pelanggan ? 'selected' : '' }}>
                                            {{ $p->nm_pelanggan }} @if($p->id_member)({{ $p->membership->tingkat ?? '' }} - Diskon {{ $p->membership->diskon ?? 0 }}%) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-calendar text-pink-400 mr-1"></i>Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal"
                                    class="form-input-custom @error('tanggal') border-red-400 @enderror"
                                    value="{{ old('tanggal', $transaksi->tanggal) }}">
                                @error('tanggal')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION 2: Daftar Item -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-regular fa-cart-shopping text-pink-500 mr-2"></i>Daftar Item
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih layanan atau produk yang dibeli pelanggan</p>

                            <div id="item-container">
                                @foreach ($transaksi->detail ?? [] as $dt)
                                <div class="item-row flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-100" data-index="{{ $loop->index }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][jenis]" class="item-jenis-hidden" value="{{ $dt->jenis }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][id_item]" class="item-id-hidden" value="{{ $dt->id_item }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][nm_item]" class="item-nama-hidden" value="{{ $dt->nm_item }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][qty]" class="item-qty-hidden" value="{{ $dt->qty }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][harga]" class="item-harga-hidden" value="{{ $dt->harga }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][subtotal]" class="item-subtotal-hidden" value="{{ $dt->subtotal }}">

                                    <select class="form-input-custom item-jenis-select !w-[120px] !py-2 !text-[12px] flex-shrink-0"
                                        onchange="onJenisChange(this)">
                                        <option value="Layanan" {{ $dt->jenis == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                                        <option value="Produk" {{ $dt->jenis == 'Produk' ? 'selected' : '' }}>Produk</option>
                                    </select>
                                    <select class="form-input-custom item-select !w-full !py-2 !text-[12px]"
                                        onchange="onItemChange(this)">
                                        <option value="">-- Pilih --</option>
                                    </select>
                                    <span class="item-harga-display text-[12px] text-gray-600 font-medium w-24 text-right flex-shrink-0">Rp {{ number_format($dt->harga, 0, ',', '.') }}</span>
                                    <input type="number" value="{{ $dt->qty }}" min="1"
                                        class="form-input-custom item-qty !w-16 !py-2 !text-[12px] text-center flex-shrink-0"
                                        oninput="onQtyChange(this)">
                                    <span class="item-subtotal-display text-[13px] text-pink-600 font-bold w-32 text-right flex-shrink-0">Rp {{ number_format($dt->subtotal, 0, ',', '.') }}</span>
                                    <button type="button" onclick="removeItemRow(this)"
                                        class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>

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
                                <i class="fa-regular fa-credit-card text-pink-500 mr-2"></i>Metode Pembayaran
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih metode pembayaran yang tersedia</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Tunai" class="hidden peer"
                                        {{ old('metode_byr', $transaksi->metode_byr) == 'Tunai' ? 'checked' : '' }}
                                        onchange="togglePaymentMethod('Tunai')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">💵</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Tunai</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Transfer" class="hidden peer"
                                        {{ old('metode_byr', $transaksi->metode_byr) == 'Transfer' ? 'checked' : '' }}
                                        onchange="togglePaymentMethod('Transfer')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">🏦</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Transfer</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Debit" class="hidden peer"
                                        {{ old('metode_byr', $transaksi->metode_byr) == 'Debit' ? 'checked' : '' }}
                                        onchange="togglePaymentMethod('Debit')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">💳</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Debit</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="E-Wallet" class="hidden peer"
                                        {{ old('metode_byr', $transaksi->metode_byr) == 'E-Wallet' ? 'checked' : '' }}
                                        onchange="togglePaymentMethod('E-Wallet')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1"><i class="fa-solid fa-wallet"></i></div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">E-Wallet</div>
                                    </div>
                                </label>
                            </div>

                            @error('metode_byr')
                                <p class="text-red-500 text-[11px] mt-1 mb-3">{{ $message }}</p>
                            @enderror

                            <!-- Payment: Tunai -->
                            <div id="payment-section-tunai" class="payment-section">
                                <div class="bg-green-50/50 rounded-2xl p-5 border border-green-100/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-[13px] font-bold text-green-700">Pembayaran Tunai</h5>
                                            <p class="text-[11px] text-green-500">Pembayaran akan langsung selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment: Transfer & Debit -->
                            <div id="payment-section-bank" class="payment-section">
                                <div class="bg-amber-50/50 rounded-2xl p-5 border border-amber-100/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-500 flex items-center justify-center">
                                            <i class="fa-solid fa-clock text-xs"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-[13px] font-bold text-amber-700">Transfer / Debit</h5>
                                            <p class="text-[11px] text-amber-500">Lampirkan bukti pembayaran untuk verifikasi</p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="fa-regular fa-flag text-pink-400 mr-1"></i>Status <span class="text-red-500">*</span>
                                        </label>
                                        <select name="status" class="form-input-custom">
                                            <option value="Lunas" {{ old('status', $transaksi->status) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Proses" {{ old('status', $transaksi->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Batal" {{ old('status', $transaksi->status) == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-building-columns text-pink-400 mr-1"></i>Bank Asal
                                            </label>
                                            <select name="bank_asal" id="bank_asal"
                                                class="form-input-custom @error('bank_asal') border-red-400 @enderror">
                                                <option value="">-- Pilih Bank Asal --</option>
                                                <option value="BRI" {{ old('bank_asal', $transaksi->bank_asal) == 'BRI' ? 'selected' : '' }}>BRI</option>
                                                <option value="BCA" {{ old('bank_asal', $transaksi->bank_asal) == 'BCA' ? 'selected' : '' }}>BCA</option>
                                                <option value="Mandiri" {{ old('bank_asal', $transaksi->bank_asal) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                <option value="BNI" {{ old('bank_asal', $transaksi->bank_asal) == 'BNI' ? 'selected' : '' }}>BNI</option>
                                                <option value="BSI" {{ old('bank_asal', $transaksi->bank_asal) == 'BSI' ? 'selected' : '' }}>BSI</option>
                                                <option value="Lainnya" {{ old('bank_asal', $transaksi->bank_asal) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @error('bank_asal')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-arrow-right text-pink-400 mr-1"></i>Dari Rekening
                                            </label>
                                            <input type="text" name="dari_rekening"
                                                class="form-input-custom @error('dari_rekening') border-red-400 @enderror"
                                                placeholder="No. rekening pengirim" value="{{ old('dari_rekening', $transaksi->dari_rekening) }}">
                                            @error('dari_rekening')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-building-columns text-pink-400 mr-1"></i>Bank Tujuan <span class="text-red-500">*</span>
                                            </label>
                                            <select name="bank_tujuan" id="bank_tujuan"
                                                class="form-input-custom @error('bank_tujuan') border-red-400 @enderror"
                                                onchange="onBankTujuanChange(this)">
                                                <option value="">-- Pilih Bank Tujuan --</option>
                                                @foreach ($bankTujuan as $bank => $rek)
                                                    <option value="{{ $bank }}" data-rekening="{{ $rek }}"
                                                        {{ old('bank_tujuan', $transaksi->bank_tujuan) == $bank ? 'selected' : '' }}>
                                                        {{ $bank }}
                                                    </option>
                                                @endforeach
                                                <option value="Lainnya" data-rekening="">Lainnya</option>
                                            </select>
                                            @error('bank_tujuan')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-arrow-left text-pink-400 mr-1"></i>Ke Rekening <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="ke_rekening" id="ke_rekening"
                                                class="form-input-custom @error('ke_rekening') border-red-400 @enderror"
                                                placeholder="No. rekening tujuan" value="{{ old('ke_rekening', $transaksi->ke_rekening) }}" readonly>
                                            @error('ke_rekening')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-user text-pink-400 mr-1"></i>Atas Nama
                                            </label>
                                            <input type="text" name="atas_nama"
                                                class="form-input-custom @error('atas_nama') border-red-400 @enderror"
                                                placeholder="Nama pemilik rekening" value="{{ old('atas_nama', $transaksi->atas_nama) }}">
                                            @error('atas_nama')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-hashtag text-pink-400 mr-1"></i>No. Referensi
                                            </label>
                                            <input type="text" name="no_referensi" id="no_referensi"
                                                class="form-input-custom @error('no_referensi') border-red-400 @enderror"
                                                placeholder="Otomatis" value="{{ old('no_referensi', $transaksi->no_referensi) }}" readonly>
                                            @error('no_referensi')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-image text-pink-400 mr-1"></i>Upload Bukti Pembayaran
                                            </label>
                                            @if($transaksi->bukti_bayar)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="bukti"
                                                        class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                                                </div>
                                            @endif
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
                            </div>

                            <!-- Payment: E-Wallet -->
                            <div id="payment-section-ewallet" class="payment-section">
                                <div class="bg-gradient-to-br from-teal-50/80 to-emerald-50/80 rounded-2xl p-5 border border-teal-100/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-500 flex items-center justify-center">
                                            <i class="fa-solid fa-wallet text-xs"></i>
                                        </div>
                                        <div>
                                            <h5 class="text-[13px] font-bold text-teal-700">E-Wallet</h5>
                                            <p class="text-[11px] text-teal-500">Pembayaran akan langsung selesai</p>
                                        </div>

                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-wallet text-pink-400 mr-1"></i>Pilih E-Wallet <span class="text-red-500">*</span>
                                            </label>
                                            <select name="ewallet_type" id="ewallet_type"
                                                class="form-input-custom @error('ewallet_type') border-red-400 @enderror">
                                                <option value="">-- Pilih E-Wallet --</option>
                                                <option value="Dana" {{ old('ewallet_type', $transaksi->bank_asal) == 'Dana' ? 'selected' : '' }}>Dana</option>
                                                <option value="GoPay" {{ old('ewallet_type', $transaksi->bank_asal) == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                                <option value="OVO" {{ old('ewallet_type', $transaksi->bank_asal) == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                <option value="ShopeePay" {{ old('ewallet_type', $transaksi->bank_asal) == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                            </select>
                                            @error('ewallet_type')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-user text-pink-400 mr-1"></i>Atas Nama
                                            </label>
                                            <input type="text" name="atas_nama"
                                                class="form-input-custom @error('atas_nama') border-red-400 @enderror"
                                                placeholder="Nama pengirim" value="{{ old('atas_nama', $transaksi->atas_nama) }}">
                                            @error('atas_nama')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-image text-pink-400 mr-1"></i>Upload Bukti Bayar
                                            </label>
                                            @if($transaksi->bukti_bayar)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="bukti"
                                                        class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                                                </div>
                                            @endif
                                            <input type="file" name="bukti_bayar"
                                                class="form-input-custom @error('bukti_bayar') border-red-400 @enderror"
                                                accept="image/*">
                                            @error('bukti_bayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-[11px] text-gray-400 mt-1">Screenshot bukti pembayaran E-Wallet</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: Ringkasan -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-regular fa-calculator text-pink-500 mr-2"></i>Ringkasan
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Total pembayaran dan perhitungan diskon</p>

                            <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-100">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-regular fa-coins text-pink-400 mr-1"></i>Total <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="total_display" id="total_display"
                                                class="form-input-custom !pl-8 bg-pink-50/50 font-bold @error('total') border-red-400 @enderror"
                                                placeholder="0" value="{{ number_format($transaksi->total, 0, ',', '.') }}" readonly>
                                            <input type="hidden" name="total" id="total" value="{{ $transaksi->total }}">
                                        </div>
                                        @error('total')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-regular fa-money-bill-wave text-pink-400 mr-1"></i>Diskon Membership
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="diskon_display" id="diskon_display"
                                                class="form-input-custom !pl-8"
                                                placeholder="0" value="{{ number_format($transaksi->diskon, 0, ',', '.') }}" readonly>
                                            <input type="hidden" name="diskon" id="diskon" value="{{ $transaksi->diskon }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-regular fa-percent text-pink-400 mr-1"></i>Pajak
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="pajak_display" id="pajak_display"
                                                class="form-input-custom !pl-8 @error('pajak') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('pajak', $transaksi->pajak) }}" oninput="onPajakChange(this)">
                                            <input type="hidden" name="pajak" id="pajak" value="{{ old('pajak', $transaksi->pajak) }}">
                                        </div>
                                        @error('pajak')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-regular fa-money-bill-1 text-pink-400 mr-1"></i>Dibayar <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="dibayar_display" id="dibayar_display"
                                                class="form-input-custom !pl-8 @error('dibayar') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('dibayar', $transaksi->dibayar) }}" oninput="onDibayarChange(this)">
                                            <input type="hidden" name="dibayar" id="dibayar" value="{{ old('dibayar', $transaksi->dibayar) }}">
                                        </div>
                                        @error('dibayar')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fa-regular fa-coins text-pink-400 mr-1"></i>Kembali
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] font-semibold text-gray-500">Rp</span>
                                            <input type="text" name="kembali_display" id="kembali_display"
                                                class="form-input-custom !pl-8 bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" value="{{ number_format($transaksi->kembali, 0, ',', '.') }}" readonly>
                                            <input type="hidden" name="kembali" id="kembali" value="{{ $transaksi->kembali }}">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="subtotal" id="subtotal" value="{{ $transaksi->subtotal }}">
                            </div>
                        </div>

                        <!-- SECTION 5: Catatan & Submit -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-regular fa-note-sticky text-pink-400 mr-1"></i>Catatan
                                    </label>
                                    <textarea name="catatan" rows="3" class="form-input-custom @error('catatan') border-red-400 @enderror"
                                        placeholder="Catatan tambahan (opsional)">{{ old('catatan', $transaksi->catatan) }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mt-4">
                                <button type="submit" id="btn-simpan-transaksi"
                                    class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                    <i class="fa-regular fa-pen-to-square"></i> Perbarui Transaksi
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
        const bankTujuanData = @json($bankTujuan);
        let itemRowIndex = {{ count($transaksi->detail ?? []) }};

        function formatRp(value) {
            return new Intl.NumberFormat('id-ID').format(Math.round(value));
        }

        function parseRp(str) {
            return parseFloat(str.replace(/[^0-9,-]/g, '').replace(',', '.')) || 0;
        }

        function onPelangganChange(select) {
            const opt = select.options[select.selectedIndex];
            const tingkat = opt ? opt.dataset.tingkat : '';
            const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
            const member = opt ? opt.dataset.member : '';

            const infoEl = document.getElementById('member-info');
            const infoText = document.getElementById('member-info-text');

            if (member && tingkat) {
                infoEl.classList.remove('hidden');
                infoText.textContent = 'Member ' + tingkat + ' \u2014 Diskon ' + diskonPct + '%';
            } else {
                infoEl.classList.add('hidden');
                infoText.textContent = '';
            }

            recalculateSubtotal();
        }

        function getItemTemplate(index) {
            return `
            <div class="item-row flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-100" data-index="${index}">
                <input type="hidden" name="items[${index}][jenis]" class="item-jenis-hidden" value="Layanan">
                <input type="hidden" name="items[${index}][id_item]" class="item-id-hidden" value="">
                <input type="hidden" name="items[${index}][nm_item]" class="item-nama-hidden" value="">
                <input type="hidden" name="items[${index}][qty]" class="item-qty-hidden" value="1">
                <input type="hidden" name="items[${index}][harga]" class="item-harga-hidden" value="0">
                <input type="hidden" name="items[${index}][subtotal]" class="item-subtotal-hidden" value="0">

                <select class="form-input-custom item-jenis-select !w-[120px] !py-2 !text-[12px] flex-shrink-0"
                    onchange="onJenisChange(this)">
                    <option value="Layanan">Layanan</option>
                    <option value="Produk">Produk</option>
                </select>
                <select class="form-input-custom item-select !w-full !py-2 !text-[12px]"
                    onchange="onItemChange(this)">
                    <option value="">-- Pilih --</option>
                </select>
                <span class="item-harga-display text-[12px] text-gray-600 font-medium w-24 text-right flex-shrink-0">Rp 0</span>
                <input type="number" value="1" min="1"
                    class="form-input-custom item-qty !w-16 !py-2 !text-[12px] text-center flex-shrink-0"
                    oninput="onQtyChange(this)">
                <span class="item-subtotal-display text-[13px] text-pink-600 font-bold w-32 text-right flex-shrink-0">Rp 0</span>
                <button type="button" onclick="removeItemRow(this)"
                    class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0">
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
                return `<option value="${item[idField]}" data-nama="${item[nmField]}" data-harga="${item[priceField] || 0}">${item[nmField]} \u2014 Rp ${Number(item[priceField] || 0).toLocaleString('id-ID')}</option>`;
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

        function recalculateSubtotal() {
            let totalItem = 0;
            document.querySelectorAll('.item-subtotal-hidden').forEach(el => {
                totalItem += parseFloat(el.value) || 0;
            });
            document.getElementById('subtotal').value = totalItem;

            const pelangganSelect = document.getElementById('id_pelanggan');
            const opt = pelangganSelect.options[pelangganSelect.selectedIndex];
            const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
            const diskonRp = totalItem * (diskonPct / 100);

            document.getElementById('diskon').value = diskonRp;
            document.getElementById('diskon_display').value = formatRp(diskonRp) + (diskonPct > 0 ? ' (' + diskonPct + '%)' : '');

            hitungTotal();
        }

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

        function onBankTujuanChange(select) {
            const opt = select.options[select.selectedIndex];
            const rekening = opt ? opt.dataset.rekening : '';
            document.getElementById('ke_rekening').value = rekening || '';
        }

        let paymentTimer = null;
        let timerSeconds = 60;

        function startPaymentTimer(displayId) {
            stopPaymentTimer();
            timerSeconds = 60;
            const el = document.getElementById(displayId);
            if (!el) return;
            el.classList.remove('hidden');
            updateTimerDisplay(el);

            paymentTimer = setInterval(function() {
                timerSeconds--;
                updateTimerDisplay(el);
                if (timerSeconds <= 0) {
                    clearInterval(paymentTimer);
                    paymentTimer = null;
                    showToast('Waktu pembayaran habis! Silakan ulangi.', 'warning');
                    timerSeconds = 60;
                    updateTimerDisplay(el);
                    startPaymentTimer(displayId);
                }
            }, 1000);
        }

        function updateTimerDisplay(el) {
            const menit = Math.floor(timerSeconds / 60);
            const detik = timerSeconds % 60;
            el.textContent = '\u23f1\ufe0f ' + String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');
            el.style.color = timerSeconds <= 10 ? '#EF4444' : '#666666';
        }

        function stopPaymentTimer() {
            if (paymentTimer) {
                clearInterval(paymentTimer);
                paymentTimer = null;
            }
            document.querySelectorAll('[id^="timer-"]').forEach(function(el) {
                el.classList.add('hidden');
                el.textContent = '\u23f1\ufe0f 01:00';
                el.style.color = '#666666';
            });
        }

        function togglePaymentMethod(method) {
            stopPaymentTimer();
            document.querySelectorAll('.payment-section').forEach(el => el.classList.remove('active'));
            const btn = document.getElementById('btn-simpan-transaksi');

            if (method === 'Tunai') {
                document.getElementById('payment-section-tunai').classList.add('active');
                if (btn) btn.innerHTML = '<i class="fa-regular fa-pen-to-square"></i> Perbarui Transaksi';
            } else if (method === 'E-Wallet') {
                document.getElementById('payment-section-ewallet').classList.add('active');
                if (btn) btn.innerHTML = '<i class="fa-regular fa-pen-to-square"></i> Perbarui Transaksi';
            } else {
                document.getElementById('payment-section-bank').classList.add('active');
                if (btn) btn.innerHTML = '<i class="fa-regular fa-pen-to-square"></i> Perbarui Transaksi';
            }
        }

        function initExistingRows() {
            document.querySelectorAll('.item-row').forEach(function(row) {
                const jenisSelect = row.querySelector('.item-jenis-select');
                const itemSelect = row.querySelector('.item-select');
                const idItem = row.querySelector('.item-id-hidden').value;
                itemSelect.innerHTML = '<option value="">-- Pilih --</option>' + loadItemOptions(jenisSelect.value);
                if (idItem) {
                    Array.from(itemSelect.options).forEach(function(opt) {
                        if (opt.value === idItem) {
                            opt.selected = true;
                            onItemChange(itemSelect);
                        }
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selected = document.querySelector('input[name="metode_byr"]:checked');
            if (selected) togglePaymentMethod(selected.value);
            initExistingRows();

            const pelangganSelect = document.getElementById('id_pelanggan');
            if (pelangganSelect.value) {
                onPelangganChange(pelangganSelect);
            }

            const noRef = document.getElementById('no_referensi');
            if (noRef && !noRef.value) {
                const now = new Date();
                const y = now.getFullYear();
                const m = String(now.getMonth() + 1).padStart(2, '0');
                const d = String(now.getDate()).padStart(2, '0');
                const rand = String(Math.floor(Math.random() * 9000) + 1000);
                noRef.value = 'REF-' + y + m + d + '-' + rand;
            }
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
