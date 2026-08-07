<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catat Refund - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <span class="nav-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                        <path d="M3 3v5h5"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Catat Refund Stok</h3>
                                <p>Catat barang yang rusak atau tidak sesuai harapan untuk dikembalikan ke supplier.
                                    Setiap catatan otomatis mengurangi stok produk dan tersimpan di riwayat mutasi stok.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Form Refund</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Pilih produk dan supplier tujuan refund</p>
                        </div>
                        <a href="{{ route('admin.stok.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div
                            class="mb-4 bg-red-50 border border-red-200 text-red-600 text-xs font-medium px-4 py-3 rounded-xl flex flex-col gap-1">
                            @foreach ($errors->all() as $err)
                                <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $err }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('admin.stok.refund-store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Supplier <span
                                        class="text-red-400">*</span></label>
                                <select name="id_supplier" id="id_supplier"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('id_supplier') border-red-300 @enderror"
                                    required>
                                    <option value="" disabled {{ old('id_supplier') ? '' : 'selected' }}>Pilih supplier</option>
                                    @foreach ($supplier as $s)
                                        <option value="{{ $s->id_supplier }}" data-produks='@json($s->produk->map(fn($p) => ['id' => $p->id_produk, 'harga' => $p->pivot->harga_beli])->all())'
                                            {{ old('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                            {{ $s->nm_supplier }}@if ($s->produk->isNotEmpty())
                                                - {{ $s->produk->pluck('nm_produk')->take(2)->implode(', ') }}@if ($s->produk->count() > 2) dll.@endif
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_supplier')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Produk <span
                                        class="text-red-400">*</span></label>
                                <input type="hidden" name="id_produk" id="id_produk_hidden" value="{{ old('id_produk') }}">
                                <select name="id_produk_display" id="id_produk" disabled
                                    class="w-full bg-gray-100 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 transition-all text-gray-500 @error('id_produk') border-red-300 @enderror"
                                    required>
                                    <option value="" disabled selected>Pilih supplier terlebih dahulu</option>
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id_produk }}" data-stok="{{ $p->stok }}" data-nm="{{ $p->nm_produk }}">
                                            {{ $p->nm_produk }} (stok: {{ $p->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-gray-400 mt-1" id="produkInfo">Pilih supplier terlebih dahulu untuk
                                    melihat produk yang disuplai.</p>
                                @error('id_produk')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Harga Beli <span
                                        class="text-[10px] font-normal text-gray-400">(otomatis dari supplier)</span></label>
                                <input type="text" id="hargaBeli" readonly
                                    class="w-full bg-gray-100 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none text-gray-500"
                                    placeholder="Pilih produk terlebih dahulu">
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Jumlah <span
                                        class="text-red-400">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="1"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('jumlah') border-red-300 @enderror"
                                    placeholder="Masukkan jumlah barang di-refund">
                                <p class="text-[11px] text-gray-400 mt-1" id="totalHarga"></p>
                                @error('jumlah')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('tanggal') border-red-300 @enderror">
                                @error('tanggal')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Keterangan</label>
                                <textarea name="keterangan" rows="2"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('keterangan') border-red-300 @enderror"
                                    placeholder="Contoh: Barang rusak saat pengiriman, kemasan penyok, kadaluarsa">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                            <a href="{{ route('admin.stok.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[13px] font-medium px-6 py-2.5 rounded-full hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        const supplierSelect = document.getElementById('id_supplier');
        const produkSelect = document.getElementById('id_produk');
        const produkHidden = document.getElementById('id_produk_hidden');
        const produkInfo = document.getElementById('produkInfo');
        const hargaBeli = document.getElementById('hargaBeli');
        const jumlahInput = document.getElementById('jumlah');
        const totalHarga = document.getElementById('totalHarga');
        const semuaProduk = Array.from(produkSelect.options).filter(function (o) { return o.value; });

        function formatRupiah(n) {
            return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
        }

        function getProdukList() {
            const option = supplierSelect.options[supplierSelect.selectedIndex];
            if (!option) return [];
            try {
                return JSON.parse(option.getAttribute('data-produks') || '[]');
            } catch (e) {
                return [];
            }
        }

        function getHarga(id) {
            const item = getProdukList().find(function (x) { return Number(x.id) === Number(id); });
            return item ? Number(item.harga) : 0;
        }

        function renderProduk() {
            const list = getProdukList();
            if (!list.length) {
                produkSelect.innerHTML = '<option value="" disabled selected>Supplier ini belum punya produk</option>';
                produkSelect.disabled = true;
                produkHidden.value = '';
                produkInfo.textContent = 'Supplier belum memiliki produk yang disuplai.';
                hargaBeli.value = '';
                hitungTotal();
                return;
            }

            produkSelect.innerHTML = '';
            const kosong = document.createElement('option');
            kosong.value = '';
            kosong.disabled = true;
            kosong.selected = true;
            kosong.textContent = 'Pilih produk';
            produkSelect.appendChild(kosong);

            semuaProduk.forEach(function (o) {
                if (list.some(function (x) { return Number(x.id) === Number(o.value); })) {
                    produkSelect.appendChild(o);
                }
            });
            produkSelect.disabled = false;
            produkInfo.textContent = 'Pilih produk yang disuplai oleh supplier ini.';
        }

        function hitungTotal() {
            const harga = parseInt(hargaBeli.value.replace(/\D/g, '')) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;
            totalHarga.textContent = harga && jumlah ? 'Total: ' + formatRupiah(harga * jumlah) : '';
        }

        supplierSelect.addEventListener('change', function () {
            renderProduk();
        });

        produkSelect.addEventListener('change', function () {
            produkHidden.value = produkSelect.value;
            const option = produkSelect.options[produkSelect.selectedIndex];
            if (option) {
                produkInfo.textContent = option.getAttribute('data-nm') + ' - stok saat ini: ' + option.getAttribute('data-stok');
                hargaBeli.value = formatRupiah(getHarga(produkSelect.value));
            } else {
                hargaBeli.value = '';
            }
            hitungTotal();
        });

        jumlahInput.addEventListener('input', hitungTotal);

        window.addEventListener('DOMContentLoaded', function () {
            renderProduk();
            if (supplierSelect.value && produkHidden.value) {
                produkSelect.value = produkHidden.value;
                const option = produkSelect.options[produkSelect.selectedIndex];
                if (option) {
                    produkInfo.textContent = option.getAttribute('data-nm') + ' - stok saat ini: ' + option.getAttribute('data-stok');
                    hargaBeli.value = formatRupiah(getHarga(produkSelect.value));
                }
            }
            hitungTotal();
        });
    </script>
    <script>
        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
