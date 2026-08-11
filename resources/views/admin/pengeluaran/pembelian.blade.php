<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembelian Stok - BeautyCare</title>
    @include('partials.head-meta')
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
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-icon { position: absolute; pointer-events: none; opacity: 0.1; font-size: 80px; }
        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        .form-input-custom[readonly] { background-color: #f9f9f9; cursor: not-allowed; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .form-label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 6px; display: block; }

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
    </style>
</head>

<body>
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Pembelian Stok</h3>
                            <p>Catat pembelian stok produk dari supplier. Stok otomatis bertambah.</p>
                        </div>
                    </div>
                </div>
            </div>
                @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2 text-sm text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-emerald-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-icon" style="top:-15px;right:-10px;">📦</div>

                    <div class="flex flex-wrap items-start sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-arrow-trend-down text-amber-500 mr-2"></i>Tambah Pembelian Stok
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-solid fa-circle-info text-pink-300 mr-1"></i>Pilih supplier lalu tambahkan produk yang dibeli
                            </p>
                        </div>
                        <a href="{{ route('admin.pengeluaran.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.pengeluaran.pembelian-store') }}" method="POST">
                        @csrf

                        <!-- SECTION 1: Supplier & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-truck text-amber-400 mr-1"></i>Supplier <span class="text-red-500">*</span>
                                </label>
                                <select name="id_supplier" id="id_supplier" class="form-input-custom @error('id_supplier') border-red-400 @enderror" onchange="onSupplierChange(this)">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach ($supplier as $s)
                                        <option value="{{ $s->id_supplier }}" {{ old('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                            {{ $s->nm_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_supplier')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-calendar text-amber-400 mr-1"></i>Tanggal <span class="text-red-500">*</span>
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
                                <i class="fa-solid fa-cart-shopping text-amber-500 mr-2"></i>Daftar Produk
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Harga beli otomatis mengikuti harga dari supplier. Stok produk akan bertambah setelah disimpan.</p>

                            <div id="item-container"></div>

                            <button type="button" onclick="addItemRow()"
                                class="flex items-center gap-2 text-amber-500 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-amber-50 transition-colors border border-dashed border-amber-200 mt-3">
                                <i class="fa-solid fa-plus"></i> Tambah Produk
                            </button>

                            @error('items')
                                <p class="text-red-500 text-[11px] mt-2">{{ $message }}</p>
                            @enderror
                            @error('items.*.qty')
                                <p class="text-red-500 text-[11px] mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SECTION 3: Metode Pembayaran -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-solid fa-credit-card text-amber-500 mr-2"></i>Metode Pembayaran
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih metode pembayaran ke supplier</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                                @foreach (['Tunai' => '💵', 'Transfer' => '🏦', 'Debit' => '💳', 'E-Wallet' => '📱'] as $metode => $icon)
                                <label class="cursor-pointer">
                                    <input type="radio" name="metode_byr" value="{{ $metode }}" class="hidden peer"
                                        {{ old('metode_byr') == $metode ? 'checked' : '' }}>
                                    <div class="p-4 rounded-xl border-2 border-gray-100 peer-checked:border-amber-400 peer-checked:bg-amber-50/50 hover:border-amber-200 transition-all text-center">
                                        <div class="text-2xl mb-1">{{ $icon }}</div>
                                        <div class="text-[12px] font-semibold text-gray-600 peer-checked:text-amber-500">{{ $metode }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('metode_byr')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-note-sticky text-amber-400 mr-1"></i>Catatan
                                </label>
                                <textarea name="catatan" rows="2" class="form-input-custom" placeholder="Catatan pembelian (opsional)">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <!-- SECTION 4: Ringkasan & Simpan -->
                        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Pembelian</p>
                                    <p class="text-[22px] font-bold text-gray-800">
                                        Rp <span id="total-display">0</span>
                                    </p>
                                </div>
                                <div class="bg-amber-50 border border-amber-100 text-amber-700 text-[11px] font-semibold px-3 py-2 rounded-xl hidden sm:block">
                                    <i class="fa-solid fa-boxes-stacked mr-1"></i>Stok produk otomatis bertambah
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.pengeluaran.index') }}"
                                    class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-5 py-2.5 rounded-full hover:bg-gray-50 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" id="btn-simpan"
                                    class="flex items-center gap-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:shadow-md transition-all shadow-sm">
                                    <i class="fa-regular fa-circle-check"></i> Simpan Pembelian Stok
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="subtotal" id="subtotal" value="0">
                        <input type="hidden" name="total" id="total" value="0">

                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        const supplierData = @json($supplierData);
        let itemRowIndex = 0;

        function formatRp(value) {
            return new Intl.NumberFormat('id-ID').format(Math.round(value));
        }

        function getProdukSupplier() {
            const select = document.getElementById('id_supplier');
            const id = select ? select.value : '';
            return supplierData[id] || null;
        }

        function onSupplierChange(select) {
            document.querySelectorAll('#item-container .item-row').forEach(el => el.remove());
            itemRowIndex = 0;
            recalculateTotal();
        }

        function getItemTemplate(index) {
            const produk = getProdukSupplier();
            const options = produk
                ? produk.produk.map(p =>
                    `<option value="${p.id}" data-nama="${p.nm}" data-harga="${p.harga_beli}">${p.nm} — Rp ${formatRp(p.harga_beli)}</option>`
                ).join('')
                : '';
            return `
            <div class="item-row flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 mb-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                <select name="items[${index}][id_produk]" class="form-input-custom item-select !w-full !py-2 !text-[12px] flex-1"
                    onchange="onItemChange(this)">
                    <option value="">${produk ? '-- Pilih Produk --' : 'Pilih supplier terlebih dahulu'}</option>
                    ${options}
                </select>
                <span class="item-harga-display text-[12px] text-gray-600 font-medium w-28 text-right flex-shrink-0">Rp 0</span>
                <input type="number" value="1" min="1" name="items[${index}][qty]"
                    class="form-input-custom item-qty !w-20 !py-2 !text-[12px] text-center flex-shrink-0"
                    oninput="onQtyChange(this)">
                <span class="item-subtotal-display text-[13px] font-bold w-32 text-right flex-shrink-0 text-amber-600">Rp 0</span>
                <button type="button" onclick="removeItemRow(this)"
                    class="w-7 h-7 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0">
                    <i class="fa-regular fa-trash-can text-xs"></i>
                </button>
            </div>`;
        }

        function addItemRow() {
            const supplier = getProdukSupplier();
            if (!supplier) {
                showToast ? showToast('Pilih supplier terlebih dahulu', 'warning') : alert('Pilih supplier terlebih dahulu');
                return;
            }
            const container = document.getElementById('item-container');
            const idx = itemRowIndex++;
            container.insertAdjacentHTML('beforeend', getItemTemplate(idx));
            recalculateTotal();
        }

        function removeItemRow(btn) {
            btn.closest('.item-row').remove();
            recalculateTotal();
        }

        function onItemChange(select) {
            const row = select.closest('.item-row');
            const option = select.options[select.selectedIndex];
            if (option && option.value) {
                const harga = parseFloat(option.dataset.harga) || 0;
                row.querySelector('.item-harga-display').textContent = 'Rp ' + formatRp(harga);
            } else {
                row.querySelector('.item-harga-display').textContent = 'Rp 0';
            }
            onQtyChange(row.querySelector('.item-qty'));
        }

        function onQtyChange(input) {
            const row = input.closest('.item-row');
            const qty = parseInt(input.value) || 0;
            const option = row.querySelector('.item-select').options[row.querySelector('.item-select').selectedIndex];
            const harga = option && option.value ? (parseFloat(option.dataset.harga) || 0) : 0;
            const subtotal = qty * harga;
            row.querySelector('.item-subtotal-display').textContent = 'Rp ' + formatRp(subtotal);
            recalculateTotal();
        }

        function recalculateTotal() {
            let total = 0;
            document.querySelectorAll('#item-container .item-row').forEach(row => {
                const select = row.querySelector('.item-select');
                const option = select.options[select.selectedIndex];
                if (option && option.value) {
                    const harga = parseFloat(option.dataset.harga) || 0;
                    const qty = parseInt(row.querySelector('.item-qty').value) || 0;
                    total += harga * qty;
                }
            });
            document.getElementById('subtotal').value = total;
            document.getElementById('total').value = total;
            document.getElementById('total-display').textContent = formatRp(total);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const supplierSelect = document.getElementById('id_supplier');
            if (supplierSelect && supplierSelect.value) {
                addItemRow();
            }
        });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>