<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Membership - BeautyCare</title>
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
                            <h3 class="text-[16px] font-bold text-gray-800">Tambah Membership</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Buat data membership baru</p>
                        </div>
                        <a href="{{ route('admin.membership.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.membership.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nama Member</label>
                                <select name="nm_member"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('nm_member') border-red-300 @enderror">
                                    <option value="" disabled selected>Pilih member</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->nama }}" {{ old('nm_member') == $p->nama ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                @error('nm_member')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Tingkat</label>
                                <select name="tingkat"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('tingkat') border-red-300 @enderror">
                                    <option value="" disabled selected>Pilih tingkat</option>
                                    <option value="Silver" {{ old('tingkat') == 'Silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="Gold" {{ old('tingkat') == 'Gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="Platinum" {{ old('tingkat') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                </select>
                                @error('tingkat')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Diskon (%)</label>
                                <input type="number" name="diskon" value="{{ old('diskon', 0) }}" step="0.01" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('diskon') border-red-300 @enderror"
                                    placeholder="Masukkan diskon">
                                @error('diskon')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Masa Berlaku (hari)</label>
                                <input type="number" name="masa_berlaku" value="{{ old('masa_berlaku') }}" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('masa_berlaku') border-red-300 @enderror"
                                    placeholder="Masukkan masa berlaku dalam hari">
                                @error('masa_berlaku')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Status</label>
                                <select name="status"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('status') border-red-300 @enderror">
                                    <option value="" disabled selected>Pilih status</option>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non_aktif" {{ old('status') == 'non_aktif' ? 'selected' : '' }}>Non Aktif</option>
                                    <option value="suspend" {{ old('status') == 'suspend' ? 'selected' : '' }}>Suspend</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                            <a href="{{ route('admin.membership.index') }}"
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