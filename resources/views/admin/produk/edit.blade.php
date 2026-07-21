<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Produk - BeautyCare</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

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
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Edit Produk</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Ubah data produk</p>
                        </div>
                        <a href="{{ route('admin.produk.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nama Produk <span class="text-red-400">*</span></label>
                                <input type="text" name="nm_produk" value="{{ old('nm_produk', $produk->nm_produk) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nm_produk') border-red-300 @enderror"
                                    placeholder="Masukkan nama produk">
                                @error('nm_produk')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-400">*</span></label>
                                <select name="id_kategori_produk"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('id_kategori_produk') border-red-300 @enderror" required>
                                    <option value="" disabled>Pilih kategori</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id_kategori_produk }}" {{ old('id_kategori_produk', $produk->id_kategori_produk) == $k->id_kategori_produk ? 'selected' : '' }}>
                                            {{ $k->nm_produk }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori_produk')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Supplier <span class="text-red-400">*</span></label>
                                <select name="id_supplier"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('id_supplier') border-red-300 @enderror" required>
                                    <option value="" disabled>Pilih supplier</option>
                                    @foreach ($supplier as $s)
                                        <option value="{{ $s->id_supplier }}" {{ old('id_supplier', $produk->id_supplier) == $s->id_supplier ? 'selected' : '' }}>
                                            {{ $s->nm_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_supplier')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Satuan <span class="text-red-400">*</span></label>
                                <input type="text" name="satuan" value="{{ old('satuan', $produk->satuan) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('satuan') border-red-300 @enderror"
                                    placeholder="Contoh: Kg, Pcs, Botol">
                                @error('satuan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Harga Beli <span class="text-red-400">*</span></label>
                                <input type="number" step="0.01" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('harga_beli') border-red-300 @enderror"
                                    placeholder="Masukkan harga beli">
                                @error('harga_beli')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Harga Jual <span class="text-red-400">*</span></label>
                                <input type="number" step="0.01" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('harga_jual') border-red-300 @enderror"
                                    placeholder="Masukkan harga jual">
                                @error('harga_jual')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Stok <span class="text-red-400">*</span></label>
                                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('stok') border-red-300 @enderror"
                                    placeholder="Masukkan stok">
                                @error('stok')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Foto</label>
                                <input type="file" name="foto" accept="image/*"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('foto') border-red-300 @enderror">
                                @if ($produk->foto)
                                    <p class="text-[11px] text-gray-400 mt-1">Foto saat ini: {{ $produk->foto }}</p>
                                @endif
                                @error('foto')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Status <span class="text-red-400">*</span></label>
                                <select name="status"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('status') border-red-300 @enderror">
                                    <option value="" disabled>Pilih status</option>
                                    <option value="Tersedia" {{ old('status', $produk->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Habis" {{ old('status', $produk->status) == 'Habis' ? 'selected' : '' }}>Habis</option>
                                    <option value="Belum Restok" {{ old('status', $produk->status) == 'Belum Restok' ? 'selected' : '' }}>Belum Restok</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Update
                            </button>
                            <a href="{{ route('admin.produk.index') }}"
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
