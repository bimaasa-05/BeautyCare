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
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nilai</label>
                                <input type="number" name="nilai" value="{{ old('nilai', $promo->nilai) }}" step="0.01" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nilai') border-red-300 @enderror"
                                    placeholder="Masukkan nilai promo">
                                @error('nilai')
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
