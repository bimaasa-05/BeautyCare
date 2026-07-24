<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Proses Pembayaran - BeautyCare</title>
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
        .badge { border-radius: 999px; font-size: 11px; font-weight: 600; padding: 4px 12px; display: inline-flex; align-items: center; gap: 4px; }
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

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-credit-card text-pink-500 mr-2"></i>Proses Pembayaran
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-pen-to-square text-pink-300 mr-1"></i>Konfirmasi pembayaran reservasi
                            </p>
                        </div>
                        <a href="{{ route('kasir.pembayaran.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    @php
                        $totalBayar = $booking->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0));
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div class="p-4 bg-gradient-to-br from-pink-50 to-white rounded-xl border border-pink-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-circle-info text-pink-400 mr-1"></i>Informasi Booking
                            </h4>
                            <table class="w-full text-[13px]">
                                <tr>
                                    <td class="py-1.5 text-gray-400 w-28">ID Booking</td>
                                    <td class="py-1.5 font-semibold text-gray-700">#{{ $booking->id_booking }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Pelanggan</td>
                                    <td class="py-1.5 font-semibold text-gray-700">{{ $booking->pelanggan->nm_pelanggan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">No. HP</td>
                                    <td class="py-1.5 text-gray-700">{{ $booking->pelanggan->no_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Tanggal</td>
                                    <td class="py-1.5 text-gray-700">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Jam</td>
                                    <td class="py-1.5 text-gray-700">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 text-gray-400">Karyawan</td>
                                    <td class="py-1.5 text-gray-700">{{ $booking->karyawan->nama ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-emerald-50 to-white rounded-xl border border-emerald-100">
                            <h4 class="text-[12px] font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                <i class="fa-regular fa-list text-emerald-400 mr-1"></i>Layanan
                            </h4>
                            <table class="w-full text-[13px]">
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
                                        <td class="py-2 font-medium text-gray-700">{{ $d->layanan->nm_layanan ?? '-' }}</td>
                                        <td class="py-2 text-right text-gray-700">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                        <td class="py-2 text-right text-red-500">Rp {{ number_format($d->diskon ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 text-right font-semibold text-emerald-600">Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="py-3 text-right text-[13px] font-bold text-gray-600">Total</td>
                                        <td class="py-3 text-right text-[16px] font-bold text-pink-500">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <form action="{{ route('kasir.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_booking" value="{{ $booking->id_booking }}">
                        <input type="hidden" name="total" id="total" value="{{ $totalBayar }}">

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-regular fa-credit-card text-pink-500 mr-2"></i>Metode Pembayaran
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih metode pembayaran</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Tunai" class="hidden peer" {{ old('metode_byr') == 'Tunai' ? 'checked' : '' }} onchange="togglePaymentMethod('Tunai')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">💵</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Tunai</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Transfer" class="hidden peer" {{ old('metode_byr') == 'Transfer' ? 'checked' : '' }} onchange="togglePaymentMethod('Transfer')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">🏦</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Transfer</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="Debit" class="hidden peer" {{ old('metode_byr') == 'Debit' ? 'checked' : '' }} onchange="togglePaymentMethod('Debit')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1">💳</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">Debit</div>
                                    </div>
                                </label>
                                <label class="payment-option cursor-pointer">
                                    <input type="radio" name="metode_byr" value="E-Wallet" class="hidden peer" {{ old('metode_byr') == 'E-Wallet' ? 'checked' : '' }} onchange="togglePaymentMethod('E-Wallet')">
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-pink-400 peer-checked:bg-pink-50/50 hover:border-pink-200 transition-all text-center">
                                        <div class="text-2xl mb-1"><i class="fa-solid fa-wallet"></i></div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-pink-500">E-Wallet</div>
                                    </div>
                                </label>
                            </div>

                            @error('metode_byr')
                                <p class="text-red-500 text-[11px] mt-1 mb-3">{{ $message }}</p>
                            @enderror

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
                                        <span class="ml-auto inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-medium bg-green-100 text-green-700">
                                            <i class="fa-regular fa-circle-check"></i> Status: Lunas
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-money-bill-1 text-pink-400 mr-1"></i>Jumlah Dibayar <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="dibayar" id="dibayar"
                                                class="form-input-custom @error('dibayar') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('dibayar', $totalBayar) }}" min="0" oninput="hitungKembali()">
                                            @error('dibayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-coins text-pink-400 mr-1"></i>Kembali
                                            </label>
                                            <input type="number" name="kembali" id="kembali"
                                                class="form-input-custom @error('kembali') border-red-400 @enderror bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" value="0" min="0" readonly>
                                            @error('kembali')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-medium bg-teal-100 text-teal-700">
                                            <i class="fa-regular fa-circle-check"></i> Status: Lunas
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-wallet text-pink-400 mr-1"></i>Pilih E-Wallet <span class="text-red-500">*</span>
                                            </label>
                                            <select name="ewallet_type" id="ewallet_type" class="form-input-custom @error('ewallet_type') border-red-400 @enderror">
                                                <option value="">-- Pilih E-Wallet --</option>
                                                <option value="Dana" {{ old('ewallet_type') == 'Dana' ? 'selected' : '' }}>Dana</option>
                                                <option value="GoPay" {{ old('ewallet_type') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                                <option value="OVO" {{ old('ewallet_type') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                <option value="ShopeePay" {{ old('ewallet_type') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                            </select>
                                            @error('ewallet_type')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-money-bill-1 text-pink-400 mr-1"></i>Jumlah Dibayar <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="dibayar" id="dibayar_ewallet"
                                                class="form-input-custom @error('dibayar') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('dibayar', $totalBayar) }}" min="0" oninput="hitungKembaliEwallet()">
                                            @error('dibayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-coins text-pink-400 mr-1"></i>Kembali
                                            </label>
                                            <input type="number" name="kembali" id="kembali_ewallet"
                                                class="form-input-custom @error('kembali') border-red-400 @enderror bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" value="0" min="0" readonly>
                                            @error('kembali')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-user text-pink-400 mr-1"></i>Atas Nama
                                            </label>
                                            <input type="text" name="atas_nama"
                                                class="form-input-custom @error('atas_nama') border-red-400 @enderror"
                                                placeholder="Nama pengirim" value="{{ old('atas_nama') }}">
                                            @error('atas_nama')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-image text-pink-400 mr-1"></i>Upload Bukti Bayar
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
                                </div>
                            </div>

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
                                        <span class="ml-auto inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-medium bg-amber-100 text-amber-700">
                                            <i class="fa-regular fa-clock"></i> Status: Pending
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-money-bill-1 text-pink-400 mr-1"></i>Jumlah Dibayar <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="dibayar" id="dibayar4"
                                                class="form-input-custom @error('dibayar') border-red-400 @enderror"
                                                placeholder="0" value="{{ old('dibayar', $totalBayar) }}" min="0" oninput="hitungKembali4()">
                                            @error('dibayar')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-coins text-pink-400 mr-1"></i>Kembali
                                            </label>
                                            <input type="number" name="kembali" id="kembali4"
                                                class="form-input-custom @error('kembali') border-red-400 @enderror bg-green-50/50 font-bold text-green-700"
                                                placeholder="0" value="0" min="0" readonly>
                                            @error('kembali')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-building-columns text-pink-400 mr-1"></i>Bank Asal
                                            </label>
                                            <select name="bank_asal" id="bank_asal"
                                                class="form-input-custom @error('bank_asal') border-red-400 @enderror">
                                                <option value="">-- Pilih Bank Asal --</option>
                                                <option value="BRI" {{ old('bank_asal') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                                <option value="BCA" {{ old('bank_asal') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                                <option value="Mandiri" {{ old('bank_asal') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                <option value="BNI" {{ old('bank_asal') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                                <option value="BSI" {{ old('bank_asal') == 'BSI' ? 'selected' : '' }}>BSI</option>
                                                <option value="Lainnya" {{ old('bank_asal') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                                placeholder="No. rekening pengirim" value="{{ old('dari_rekening') }}">
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
                                                        {{ old('bank_tujuan') == $bank ? 'selected' : '' }}>
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
                                                placeholder="No. rekening tujuan" value="{{ old('ke_rekening') }}" readonly>
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
                                                placeholder="Nama pemilik rekening" value="{{ old('atas_nama') }}">
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
                                                placeholder="Otomatis" value="{{ old('no_referensi') }}" readonly>
                                            @error('no_referensi')
                                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fa-regular fa-image text-pink-400 mr-1"></i>Upload Bukti Pembayaran
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
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label">
                                <i class="fa-regular fa-note-sticky text-pink-400 mr-1"></i>Catatan
                            </label>
                            <textarea name="catatan" rows="3" class="form-input-custom @error('catatan') border-red-400 @enderror"
                                placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                            <button type="submit"
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
        function hitungKembali() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const dibayar = parseFloat(document.getElementById('dibayar').value) || 0;
            const kembali = Math.max(0, dibayar - total);
            document.getElementById('kembali').value = kembali;
        }

        function hitungKembaliEwallet() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const dibayar = parseFloat(document.getElementById('dibayar_ewallet').value) || 0;
            const kembali = Math.max(0, dibayar - total);
            document.getElementById('kembali_ewallet').value = kembali;
            document.getElementById('kembali').value = kembali;
        }

        function hitungKembali4() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const dibayar = parseFloat(document.getElementById('dibayar4').value) || 0;
            const kembali = Math.max(0, dibayar - total);
            document.getElementById('kembali4').value = kembali;
            document.getElementById('kembali').value = kembali;
        }

        function togglePaymentMethod(method) {
            document.querySelectorAll('.payment-section').forEach(el => el.classList.remove('active'));
            if (method === 'Tunai') {
                document.getElementById('payment-section-tunai').classList.add('active');
            } else if (method === 'E-Wallet') {
                document.getElementById('payment-section-ewallet').classList.add('active');
            } else {
                document.getElementById('payment-section-bank').classList.add('active');
            }
        }

        function onBankTujuanChange(select) {
            const opt = select.options[select.selectedIndex];
            const rekening = opt ? opt.dataset.rekening : '';
            document.getElementById('ke_rekening').value = rekening || '';
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
            const selected = document.querySelector('input[name="metode_byr"]:checked');
            if (selected) togglePaymentMethod(selected.value);

            document.getElementById('no_referensi').value = generateNoReferensi();
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
