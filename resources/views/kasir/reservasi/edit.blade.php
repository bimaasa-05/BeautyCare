<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Reservasi - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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
    </style>
    <style>

        

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

        .float-icon {
            position: absolute;
            pointer-events: none;
            opacity: 0.1;
            font-size: 80px;
        }

        .form-input-custom {
            border: 1.5px solid #ECECEC;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13px;
            width: 100%;
            transition: all 0.3s ease;
            font-family: var(--font-primary);
        }

        .form-input-custom:focus {
            border-color: #FF4F87;
            box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.12);
            outline: none;
        }

        .form-input-custom::placeholder {
            color: #aaa;
        }

        select.form-input-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        .btn-remove-row {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding-right: 40px !important;
        }

        .custom-select-trigger i {
            transition: transform 0.2s;
            margin-left: auto;
            font-size: 10px;
            color: #999;
        }

        .custom-select-trigger.open i {
            transform: rotate(180deg);
        }

        .custom-select-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 50;
            max-height: 180px;
            overflow-y: auto;
            background: white;
            border: 1.5px solid #ECECEC;
            border-radius: 12px;
            margin-top: 4px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .custom-select-option {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 13px;
            font-family: var(--font-primary);
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.15s;
        }

        .custom-select-option:last-child {
            border-bottom: none;
        }

        .custom-select-option:hover {
            background: #FFF0F5;
        }

        .custom-select-option.selected {
            background: #FFE4EC;
            color: #FF4F87;
            font-weight: 500;
        }

        .custom-select-option-disabled {
            opacity: .55;
            cursor: not-allowed;
            background: #fafafa;
        }

        .custom-select-option-disabled:hover {
            background: #fafafa;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">📅</div>

                    <div class="flex flex-wrap justify-between items-center gap-2 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-pen-to-square text-pink-500 mr-2"></i>Edit Reservasi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-pen-to-square text-pink-300 mr-1"></i>Ubah detail reservasi
                            </p>
                        </div>
                        <a href="{{ route('kasir.reservasi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('kasir.reservasi.update', $reservasi->id_booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="mb-3 px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-[12px] font-semibold rounded-xl">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-user text-pink-400 mr-1"></i>Pelanggan <span
                                        class="text-red-500">*</span>
                                </label>
                                @php
                                    $optsPelanggan = $pelanggan->map(fn($p) => [
                                        'value' => $p->id_pelanggan,
                                        'label' => $p->nm_pelanggan . ($p->id_member ? ' (' . ($p->membership->tingkat ?? '') . ' - Diskon ' . ($p->membership->diskon ?? 0) . '%)' : '')
                                    ])->sortBy('label')->values();
                                @endphp
                                <div x-data="searchableSelect()" x-init='init($el.querySelector("select"), @json($optsPelanggan), @json(old("id_pelanggan", $reservasi->id_pelanggan)))' class="relative">
                                    <select name="id_pelanggan" id="id_pelanggan" class="hidden @error('id_pelanggan') border-red-400 @enderror" onchange="onPelangganChange(this)">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggan as $p)
                                            <option value="{{ $p->id_pelanggan }}"
                                                data-member="{{ $p->id_member ?? '' }}"
                                                data-tingkat="{{ $p->membership->tingkat ?? '' }}"
                                                data-diskon="{{ $p->membership->diskon ?? 0 }}"
                                                {{ old('id_pelanggan', $reservasi->id_pelanggan) == $p->id_pelanggan ? 'selected' : '' }}>
                                                {{ $p->nm_pelanggan }} @if ($p->id_member)
                                                    ({{ $p->membership->tingkat ?? '' }} - Diskon
                                                    {{ $p->membership->diskon ?? 0 }}%)
                                                @endif
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
                                    <i class="fa-solid fa-user text-pink-400 mr-1"></i>Karyawan <span
                                        class="text-red-500">*</span>
                                </label>
                                <div class="custom-select-wrapper">
                                    <select name="id_karyawan" id="id_karyawan"
                                        class="form-input-custom @error('id_karyawan') border-red-400 @enderror">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($karyawan as $k)
                                            @php($infoLayani = $sedangMelayaniDetail[$k->id] ?? null)
                                            @php($sedangLayani = $infoLayani && $reservasi->id_karyawan != $k->id)
                                            <option value="{{ $k->id }}"
                                                {{ old('id_karyawan', $reservasi->id_karyawan) == $k->id ? 'selected' : '' }}
                                                {{ $sedangLayani ? 'disabled' : '' }} data-info="{{ $infoLayani && $sedangLayani ? 'Sedang melayani ' . $infoLayani['pelanggan'] . ' pukul ' . \App\Support\BookingSlot::formatJamIndo($infoLayani['jam']) : '' }}">
                                                {{ $k->nama }}{{ $sedangLayani ? ' — Sedang Melayani' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('id_karyawan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-calendar text-pink-400 mr-1"></i>Tanggal <span
                                        class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-input-custom @error('tanggal') border-red-400 @enderror"
                                    value="{{ old('tanggal', $reservasi->tanggal) }}">
                                @error('tanggal')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-clock text-pink-400 mr-1"></i>Jam <span
                                        class="text-red-500">*</span>
                                </label>
                                <select name="jam" id="jamSlot"
                                    class="form-input-custom @error('jam') border-red-400 @enderror">
                                    <option value="">-- Pilih Jam --</option>
                                    @foreach($slotJam as $jam)
                                    <option value="{{ $jam }}" {{ old('jam', \App\Support\BookingSlot::normalJam($reservasi->jam)) == $jam ? 'selected' : '' }}>{{ \App\Support\BookingSlot::formatJamIndo($jam) }}</option>
                                    @endforeach
                                </select>
                                @error('jam')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-[11px] text-gray-400 mt-1"><i class="fa-solid fa-circle-info"></i> Slot terbooking terapis (termasuk durasi layanan) otomatis dinonaktifkan</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-flag text-pink-400 mr-1"></i>Status <span
                                        class="text-red-500">*</span>
                                </label>
                                <select name="status"
                                    class="form-input-custom @error('status') border-red-400 @enderror">
                                    <option value="menunggu"
                                        {{ old('status', $reservasi->status) == 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="dikonfirmasi"
                                        {{ old('status', $reservasi->status) == 'dikonfirmasi' ? 'selected' : '' }}>
                                        Dikonfirmasi</option>
                                    <option value="diproses"
                                        {{ old('status', $reservasi->status) == 'diproses' ? 'selected' : '' }}>
                                        Diproses</option>
                                    <option value="selesai"
                                        {{ old('status', $reservasi->status) == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="dibatalkan"
                                        {{ old('status', $reservasi->status) == 'dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-list text-pink-500 mr-2"></i>Layanan
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih layanan yang akan direservasi</p>

                            <div id="layanan-rows">
                                @forelse ($reservasi->detail as $i => $d)
                                    <div
                                        class="layanan-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end mb-3 p-3 bg-pink-50/30 rounded-xl">
                                        <div class="md:col-span-4">
                                            <label class="text-[11px] font-medium text-gray-500 mb-1 block">Layanan
                                                <span class="text-red-500">*</span></label>
                                            <div class="custom-select-wrapper">
                                                <select name="id_layanan[]" class="form-input-custom layanan-select"
                                                    required>
                                                    <option value="">-- Pilih Layanan --</option>
                                                    @foreach ($layanan as $l)
<option value="{{ $l->id_layanan }}"
                                                             data-harga="{{ (int)$l->harga }}"
                                                             {{ $d->id_layanan == $l->id_layanan ? 'selected' : '' }}>
                                                             {{ $l->nm_layanan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-[11px] font-medium text-gray-500 mb-1 block">Harga</label>
                                            <input type="text" name="harga[]"
                                                class="form-input-custom harga-input" placeholder="Rp 0"
                                                value="Rp {{ number_format($d->harga, 0, ',', '.') }}" readonly>
                                        </div>
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-[11px] font-medium text-gray-500 mb-1 block">Diskon</label>
                                            <input type="text" name="diskon[]"
                                                class="form-input-custom diskon-input" placeholder="Rp 0"
                                                value="Rp {{ number_format($d->diskon ?? 0, 0, ',', '.') }}"
                                                oninput="hitungSubtotal(this)" onblur="formatDiskon(this)">
                                        </div>
                                        <div class="md:col-span-2 flex items-center gap-2">
                                            <div class="flex-1">
                                                <label
                                                    class="text-[11px] font-medium text-gray-500 mb-1 block">Subtotal</label>
                                                <input type="text"
                                                    class="form-input-custom subtotal-text bg-gray-50/50 text-gray-700 font-semibold"
                                                    value="Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}"
                                                    readonly>
                                            </div>
                                            <button type="button"
                                                class="btn-remove-row bg-red-100 text-red-500 hover:bg-red-200 mt-5"
                                                onclick="hapusRow(this)" title="Hapus">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="layanan-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end mb-3 p-3 bg-pink-50/30 rounded-xl">
                                        <div class="md:col-span-4">
                                            <label class="text-[11px] font-medium text-gray-500 mb-1 block">Layanan
                                                <span class="text-red-500">*</span></label>
                                            <div class="custom-select-wrapper">
                                                <select name="id_layanan[]" class="form-input-custom layanan-select"
                                                    required>
                                                    <option value="">-- Pilih Layanan --</option>
                                                    @foreach ($layanan as $l)
<option value="{{ $l->id_layanan }}"
                                                             data-harga="{{ (int)$l->harga }}">{{ $l->nm_layanan }}
                                                         </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-[11px] font-medium text-gray-500 mb-1 block">Harga</label>
                                            <input type="text" name="harga[]"
                                                class="form-input-custom harga-input" placeholder="Rp 0"
                                                readonly>
                                        </div>
                                        <div class="md:col-span-3">
                                            <label
                                                class="text-[11px] font-medium text-gray-500 mb-1 block">Diskon</label>
                                            <input type="text" name="diskon[]"
                                                class="form-input-custom diskon-input" placeholder="Rp 0"
                                                value="Rp 0" oninput="hitungSubtotal(this)"
                                                onblur="formatDiskon(this)">
                                        </div>
                                        <div class="md:col-span-2 flex items-center gap-2">
                                            <div class="flex-1">
                                                <label
                                                    class="text-[11px] font-medium text-gray-500 mb-1 block">Subtotal</label>
                                                <input type="text"
                                                    class="form-input-custom subtotal-text bg-gray-50/50 text-gray-700 font-semibold"
                                                    readonly>
                                            </div>
                                            <button type="button"
                                                class="btn-remove-row bg-red-100 text-red-500 hover:bg-red-200 mt-5"
                                                onclick="hapusRow(this)" title="Hapus">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <button type="button" onclick="tambahRow()"
                                class="flex items-center gap-2 text-pink-500 text-[12px] font-semibold hover:text-pink-600 transition-colors mt-2">
                                <i class="fa-solid fa-plus-circle"></i> Tambah Layanan
                            </button>

                            <div id="member-info" class="mt-3 hidden">
                                <div
                                    class="flex items-center gap-2 text-[12px] px-4 py-2 rounded-lg bg-purple-50 text-purple-700 border border-purple-100">
                                    <i class="fa-solid fa-crown"></i>
                                    <span id="member-info-text"></span>
                                </div>
                            </div>

                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex flex-wrap justify-between items-center gap-2">
                                    <span class="text-[13px] font-semibold text-gray-600">Grand Total</span>
                                    <span id="grand-total" class="text-[18px] font-bold text-pink-500">Rp
                                        {{ number_format($reservasi->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0)), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label">
                                <i class="fa-solid fa-note-sticky text-pink-400 mr-1"></i>Catatan
                            </label>
                            <textarea name="catatan" rows="3" class="form-input-custom @error('catatan') border-red-400 @enderror"
                                placeholder="Catatan tambahan (opsional)">{{ old('catatan', $reservasi->catatan) }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-regular fa-circle-check"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function onPelangganChange(select) {
            const opt = select.options[select.selectedIndex];
            const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
            const tingkat = opt ? opt.dataset.tingkat : '';
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

            document.querySelectorAll('.layanan-row').forEach(function(row) {
                const harga = parseFloat(row.querySelector('.harga-input').value.replace(/[^0-9]/g, '')) || 0;
                const diskon = harga * diskonPct / 100;
                var diskonBersih = Math.round(diskon);
                row.querySelector('.diskon-input').value = 'Rp ' + diskonBersih.toLocaleString('id-ID');
                hitungSubtotal(row.querySelector('.diskon-input'));
            });
        }

        function tambahRow() {
            const container = document.getElementById('layanan-rows');
            const firstRow = container.querySelector('.layanan-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(function(input) {
                if (input.classList.contains('diskon-input')) {
                    input.value = 'Rp 0';
                } else {
                    input.value = '';
                }
            });

            const newSelect = newRow.querySelector('select.layanan-select');
            if (newSelect) {
                newSelect.selectedIndex = 0;
                const wrapper = newSelect.closest('.custom-select-wrapper');
                if (wrapper) bindCustomSelect(wrapper);
            }

            container.appendChild(newRow);
        }

        function hapusRow(btn) {
            const rows = document.querySelectorAll('.layanan-row');
            if (rows.length <= 1) return;
            btn.closest('.layanan-row').remove();
            hitungGrandTotal();
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('layanan-select')) {
                const row = e.target.closest('.layanan-row');
                const selected = e.target.options[e.target.selectedIndex];
                const harga = selected.getAttribute('data-harga') || 0;
                row.querySelector('.harga-input').value = 'Rp ' + parseInt(harga).toLocaleString('id-ID');

                const pelangganSelect = document.getElementById('id_pelanggan');
                const opt = pelangganSelect.options[pelangganSelect.selectedIndex];
                const diskonPct = opt ? parseFloat(opt.dataset.diskon) || 0 : 0;
                const diskon = parseFloat(harga) * diskonPct / 100;
                var diskonBersih = Math.round(diskon);
                row.querySelector('.diskon-input').value = 'Rp ' + diskonBersih.toLocaleString('id-ID');

                hitungSubtotal(row.querySelector('.diskon-input'));
            }
        });

        function hitungSubtotal(el) {
            const row = el.closest('.layanan-row');
            const harga = parseFloat(row.querySelector('.harga-input').value.replace(/[^0-9]/g, '')) || 0;
            const diskon = parseFloat(row.querySelector('.diskon-input').value.replace(/[^0-9]/g, '')) || 0;
            const subtotal = Math.max(0, harga - diskon);
            row.querySelector('.subtotal-text').value = 'Rp ' + subtotal.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            hitungGrandTotal();
        }

        function hitungGrandTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-text').forEach(function(el) {
                const val = el.value.replace(/[^0-9]/g, '');
                total += parseFloat(val) || 0;
            });
            document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function initCustomSelects() {
            document.querySelectorAll('.custom-select-wrapper').forEach(function(wrapper) {
                bindCustomSelect(wrapper);
            });
            document.addEventListener('click', function() {
                closeCustomDropdowns();
            });
        }

        function bindCustomSelect(wrapper) {
            var oldTrigger = wrapper.querySelector('.custom-select-trigger');
            var oldDropdown = wrapper.querySelector('.custom-select-dropdown');
            if (oldTrigger) oldTrigger.remove();
            if (oldDropdown) oldDropdown.remove();

            var select = wrapper.querySelector('select');
            if (!select) return;

            select.style.display = 'none';

            var trigger = document.createElement('div');
            trigger.className = 'custom-select-trigger form-input-custom';

            var triggerText = document.createElement('span');
            var idx = select.selectedIndex;
            triggerText.textContent = idx >= 0 ? select.options[idx].text : '-- Pilih --';

            var arrow = document.createElement('i');
            arrow.className = 'fa-solid fa-chevron-down';

            trigger.appendChild(triggerText);
            trigger.appendChild(arrow);

            var dropdown = document.createElement('div');
            dropdown.className = 'custom-select-dropdown';

            for (var i = 0; i < select.options.length; i++) {
                (function(idx) {
                    var opt = select.options[idx];
                    var optDiv = document.createElement('div');
                    optDiv.className = 'custom-select-option';
                    if (opt.selected) optDiv.classList.add('selected');
                    if (opt.disabled) optDiv.classList.add('custom-select-option-disabled');
                    optDiv.textContent = opt.text;

                    for (var j = 0; j < opt.attributes.length; j++) {
                        var attr = opt.attributes[j];
                        if (attr.name.indexOf('data-') === 0) {
                            optDiv.setAttribute(attr.name, attr.value);
                        }
                    }

                    optDiv.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (opt.disabled) return;
                        select.selectedIndex = idx;
                        triggerText.textContent = select.options[idx].text;
                        dropdown.querySelectorAll('.custom-select-option').forEach(function(o) {
                            o.classList.remove('selected');
                        });
                        this.classList.add('selected');
                        select.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                        closeCustomDropdowns();
                    });
                    dropdown.appendChild(optDiv);
                })(i);
            }

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                var isOpen = dropdown.style.display === 'block';
                closeCustomDropdowns();
                if (!isOpen) {
                    dropdown.style.display = 'block';
                    trigger.classList.add('open');
                }
            });

            wrapper.insertBefore(trigger, select);
            wrapper.appendChild(dropdown);
        }

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

        function formatDiskon(el) {
            var val = el.value.replace(/[^0-9]/g, '');
            el.value = val ? 'Rp ' + parseInt(val).toLocaleString('id-ID') : 'Rp 0';
            hitungSubtotal(el);
        }

        function closeCustomDropdowns() {
            document.querySelectorAll('.custom-select-dropdown').forEach(function(d) {
                d.style.display = 'none';
            });
            document.querySelectorAll('.custom-select-trigger').forEach(function(t) {
                t.classList.remove('open');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initCustomSelects();
            const pelangganSelect = document.getElementById('id_pelanggan');
            if (pelangganSelect && pelangganSelect.value) {
                onPelangganChange(pelangganSelect);
            }

            let slotDataCache = { slots: @json($slotJam), booked: @json($bookedJamByKaryawan) };

            function applyJamAvailability() {
                const jamSelect = document.getElementById('jamSlot');
                if (!jamSelect) return;
                const karyawanId = document.getElementById('id_karyawan').value;
                const booked = (slotDataCache.booked[karyawanId] || []);
                for (let i = 0; i < jamSelect.options.length; i++) {
                    const opt = jamSelect.options[i];
                    if (!opt.value) continue;
                    const penuh = booked.indexOf(opt.value) !== -1;
                    opt.disabled = penuh || !karyawanId;
                    opt.textContent = opt.value.replace(':', '.') + (penuh ? ' — Sudah Dibooking' : '');
                }
                if (jamSelect.value && jamSelect.options[jamSelect.selectedIndex].disabled) {
                    jamSelect.value = '';
                }
            }

            const tanggalInput = document.getElementById('tanggal');
            const karyawanSelect = document.getElementById('id_karyawan');

            async function refreshSlotData() {
                if (!tanggalInput || !tanggalInput.value) return;
                try {
                    const res = await fetch('/kasir/reservasi/slot-data?tanggal=' + tanggalInput.value);
                    if (res.ok) {
                        slotDataCache = await res.json();
                        applyJamAvailability();
                    }
                } catch (e) {}
            }

            if (tanggalInput) {
                tanggalInput.addEventListener('change', refreshSlotData);
            }
if (karyawanSelect) {
                karyawanSelect.addEventListener('change', applyJamAvailability);
            }
            applyJamAvailability();

            // Normalize harga[] & diskon[] before submit (strip dots from Indonesian format)
            document.querySelector('form').addEventListener('submit', function() {
                document.querySelectorAll('input[name="harga[]"]').forEach(function(el) {
                    el.value = el.value.replace(/[^0-9]/g, '');
                });
                document.querySelectorAll('input[name="diskon[]"]').forEach(function(el) {
                    el.value = el.value.replace(/[^0-9]/g, '');
                });
            });
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
