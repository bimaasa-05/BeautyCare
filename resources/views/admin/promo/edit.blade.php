<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Promo - BeautyCare</title>
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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="20" y1="4" x2="4" y2="20"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Edit Promo</h3>
                            <p>Ubah promo yang sudah ada.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Edit Promo</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Ubah data promo</p>
                        </div>
                        <a href="{{ route('admin.promo.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.promo.update', $promo->id_promo) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nama Promo</label>
                                <input type="text" name="nm_promo" value="{{ old('nm_promo', $promo->nm_promo) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nm_promo') border-red-300 @enderror"
                                    placeholder="Masukkan nama promo">
                                @error('nm_promo')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Kode Promo</label>
                                <input type="text" value="{{ old('kode_promo', $promo->kode_promo) }}" disabled
                                    class="w-full bg-gray-100 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 text-gray-400 cursor-not-allowed">
                                <input type="hidden" name="kode_promo" value="{{ old('kode_promo', $promo->kode_promo) }}">
                                <p class="text-[11px] text-gray-400 mt-1">Kode promo dihasilkan otomatis oleh sistem dan tidak dapat diubah.</p>
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Jenis Promo</label>
                                <select name="jenis_promo"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('jenis_promo') border-red-300 @enderror">
                                    <option value="" disabled>Pilih jenis promo</option>
                                    <option value="Diskon" {{ old('jenis_promo', $promo->jenis_promo) == 'Diskon' ? 'selected' : '' }}>Diskon</option>
                                    <option value="Cashback" {{ old('jenis_promo', $promo->jenis_promo) == 'Cashback' ? 'selected' : '' }}>Cashback</option>
                                    <option value="Paket" {{ old('jenis_promo', $promo->jenis_promo) == 'Paket' ? 'selected' : '' }}>Paket</option>
                                    <option value="Buy 1 Get 1" {{ old('jenis_promo', $promo->jenis_promo) == 'Buy 1 Get 1' ? 'selected' : '' }}>Buy 1 Get 1</option>
                                    <option value="Lainnya" {{ old('jenis_promo', $promo->jenis_promo) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_promo')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nilai <span id="nilaiHint" class="text-gray-400 font-normal"></span></label>
                                <input type="number" name="nilai" value="{{ old('nilai', $promo->nilai) }}" step="0.01" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nilai') border-red-300 @enderror"
                                    placeholder="Masukkan nilai promo">
                                @error('nilai')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Deskripsi / Syarat Promo</label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('deskripsi') border-red-300 @enderror"
                                    placeholder="Contoh: Diskon 20% untuk semua perawatan wajah, berlaku s/d akhir bulan">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Mulai</label>
                                    <input type="date" name="mulai" value="{{ old('mulai', $promo->mulai) }}"
                                        class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('mulai') border-red-300 @enderror">
                                    @error('mulai')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Selesai</label>
                                    <input type="date" name="selesai" value="{{ old('selesai', $promo->selesai) }}"
                                        class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('selesai') border-red-300 @enderror">
                                    @error('selesai')
                                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Status</label>
                                <select name="status"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('status') border-red-300 @enderror">
                                    <option value="" disabled>Pilih status</option>
                                    <option value="Tersedia" {{ old('status', $promo->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Belum_tersedia" {{ old('status', $promo->status) == 'Belum_tersedia' ? 'selected' : '' }}>Belum Tersedia</option>
                                    <option value="Berakhir" {{ old('status', $promo->status) == 'Berakhir' ? 'selected' : '' }}>Berakhir</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="border-t border-gray-100 pt-5">
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Berlaku Untuk Pelanggan</label>
                                <p class="text-[11px] text-gray-400">Promo ini berlaku untuk semua pelanggan.</p>
                                <input type="hidden" name="target" value="semua">
                            </div>

                            <div class="border-t border-gray-100 pt-5">
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Berlaku Untuk Item</label>
                                <p class="text-[11px] text-gray-400 mb-3">Kosongkan semua jika promo berlaku untuk semua produk & layanan.</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[12px] font-semibold text-gray-500 mb-2"><i class="fa-solid fa-spa text-pink-400 mr-1"></i> Layanan</p>
                                        <div class="max-h-52 overflow-y-auto border border-gray-200 rounded-xl p-3 space-y-1.5 bg-gray-50">
                                            @forelse($layanans as $layanan)
                                                <label class="flex items-center gap-2 text-[12px] text-gray-600 cursor-pointer hover:bg-white px-2 py-1 rounded-lg transition-colors">
                                                    <input type="checkbox" name="id_layanan[]" value="{{ $layanan->id_layanan }}"
                                                        class="accent-pink-500"
                                                        {{ in_array($layanan->id_layanan, old('id_layanan', $promo->promoLayanan->pluck('id_layanan')->all()) ?? []) ? 'checked' : '' }}>
                                                    {{ $layanan->nm_layanan }}
                                                </label>
                                            @empty
                                                <p class="text-[12px] text-gray-400 text-center py-2">Belum ada layanan</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[12px] font-semibold text-gray-500 mb-2"><i class="fa-solid fa-box text-pink-400 mr-1"></i> Produk</p>
                                        <div class="max-h-52 overflow-y-auto border border-gray-200 rounded-xl p-3 space-y-1.5 bg-gray-50">
                                            @forelse($produks as $produk)
                                                <label class="flex items-center gap-2 text-[12px] text-gray-600 cursor-pointer hover:bg-white px-2 py-1 rounded-lg transition-colors">
                                                    <input type="checkbox" name="id_produk[]" value="{{ $produk->id_produk }}"
                                                        class="accent-pink-500"
                                                        {{ in_array($produk->id_produk, old('id_produk', $promo->promoProduk->pluck('id_produk')->all()) ?? []) ? 'checked' : '' }}>
                                                    {{ $produk->nm_produk }}
                                                </label>
                                            @empty
                                                <p class="text-[12px] text-gray-400 text-center py-2">Belum ada produk</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Update
                            </button>
                            <a href="{{ route('admin.promo.index') }}"
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
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

        const hints = {
            'Diskon': '(persen)',
            'Cashback': '(Rp)',
            'Paket': '(Rp)',
            'Buy 1 Get 1': '(Rp)',
            'Lainnya': '(Rp)',
        };

        function updateNilaiHint() {
            const el = document.getElementById('nilaiHint');
            if (!el) return;
            const sel = document.querySelector('select[name="jenis_promo"]');
            el.textContent = sel && sel.value ? (hints[sel.value] || '(Rp)') : '';
        }

        const jenisSel = document.querySelector('select[name="jenis_promo"]');
        if (jenisSel) jenisSel.addEventListener('change', updateNilaiHint);
        updateNilaiHint();
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
