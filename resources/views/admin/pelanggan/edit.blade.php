<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Pelanggan - BeautyCare</title>
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
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Edit Pelanggan</h3>
                            <p>Ubah data pelanggan yang sudah ada.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Edit Pelanggan</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Ubah data pelanggan</p>
                        </div>
                        <a href="{{ route('admin.pelanggan.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @php $isWalkin = is_null($pelanggan->id_user); @endphp

                        <div class="mb-5">
                            <label class="text-[13px] font-semibold text-gray-700 block mb-2">Tipe Pelanggan</label>
                            @if ($isWalkin)
                                <div class="flex items-center gap-4">
                                    <span class="text-amber-500 bg-amber-50 px-3 py-1 rounded-full text-[12px] font-semibold whitespace-nowrap">Walk-in</span>
                                    <label class="flex items-center gap-2 text-[13px] text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="konversi_online" value="1" onchange="toggleKonversi()">
                                        Konversi ke Online (Buat Akun)
                                    </label>
                                </div>
                                <div id="konversiFields" class="hidden mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Password</label>
                                        <div class="relative">
                                            <input type="password" name="password"
                                                class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('password') border-red-300 @enderror"
                                                placeholder="Masukkan password">
                                            <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm cursor-pointer hover:text-pink-400 transition-colors z-[1]"
                                                onclick="togglePassword(this)"></i>
                                        </div>
                                        @error('password')
                                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Konfirmasi Password</label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation"
                                                class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl pl-4 pr-10 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400"
                                                placeholder="Ulangi password">
                                            <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm cursor-pointer hover:text-pink-400 transition-colors z-[1]"
                                                onclick="togglePassword(this)"></i>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-blue-500 bg-blue-50 px-3 py-1 rounded-full text-[12px] font-semibold">Online</span>
                                <input type="hidden" name="tipe" value="online">
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nama Lengkap</label>
                                <input type="text" name="nm_pelanggan" value="{{ old('nm_pelanggan', $pelanggan->nm_pelanggan) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nm_pelanggan') border-red-300 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('nm_pelanggan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email', $pelanggan->email) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('email') border-red-300 @enderror"
                                    placeholder="Masukkan alamat email">
                                @error('email')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">No HP</label>
                                <input type="number" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('no_hp') border-red-300 @enderror"
                                    placeholder="Masukkan nomor HP">
                                @error('no_hp')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat', $pelanggan->alamat) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('alamat') border-red-300 @enderror"
                                    placeholder="Masukkan alamat">
                                @error('alamat')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="memberField" @if($isWalkin) class="opacity-40 pointer-events-none" @endif>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Membership</label>
                                <select name="id_member" {{ $isWalkin ? 'disabled' : '' }}
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('id_member') border-red-300 @enderror">
                                    <option value="">-- Tanpa Membership --</option>
                                    @foreach ($memberships ?? [] as $m)
                                        <option value="{{ $m->id_member }}" {{ old('id_member', $pelanggan->id_member) == $m->id_member ? 'selected' : '' }}>
                                            {{ $m->nm_member }} ({{ $m->tingkat }} - Diskon {{ $m->diskon }}% - {{ $m->masa_berlaku }} hari)
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_member')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                                @if($isWalkin)
                                    <p class="text-[11px] text-amber-500 mt-1">* Walk-in tidak bisa memiliki membership</p>
                                @endif
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Foto</label>
                                <input type="file" name="foto"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2 focus:outline-none focus:border-pink-300 focus:bg-white transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-pink-50 file:text-[#de3b7c] hover:file:bg-pink-100 @error('foto') border-red-300 @enderror">
                                @error('foto')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                                @if ($pelanggan->foto)
                                    <p class="text-[11px] text-gray-400 mt-1">Foto saat ini: {{ $pelanggan->foto }}</p>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Catatan Alergi</label>
                                <textarea name="catatan_alergi" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('catatan_alergi') border-red-300 @enderror"
                                    placeholder="Masukkan catatan alergi">{{ old('catatan_alergi', $pelanggan->catatan_alergi) }}</textarea>
                                @error('catatan_alergi')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Update
                            </button>
                            <a href="{{ route('admin.pelanggan.index') }}"
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
        function togglePassword(icon) {
            const input = icon.parentElement.querySelector('input');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        }
        function toggleKonversi() {
            const checked = document.querySelector('input[name="konversi_online"]')?.checked;
            document.getElementById('konversiFields')?.classList.toggle('hidden', !checked);
        }

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
