<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Membership - BeautyCare</title>
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
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Edit Membership</h3>
                            <p>Ubah paket membership yang sudah ada.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                            <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Edit Paket Membership</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Ubah paket membership</p>
                        </div>
                        <a href="{{ route('admin.membership.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form id="membershipForm" action="{{ route('admin.membership.update', $membership->id_member) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Nama Paket</label>
                                <input type="text" name="nm_member" value="{{ old('nm_member', $membership->nm_member) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('nm_member') border-red-300 @enderror"
                                    placeholder="Masukkan nama paket">
                                @error('nm_member')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @php
                                $defaultTiers = ['Silver', 'Gold', 'Platinum'];
                                $allTiers = collect($defaultTiers)->merge($semuaTingkat ?? collect())->unique()->values();
                                $currentTingkat = old('tingkat', $membership->tingkat);
                            @endphp
                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Tingkat</label>
                                <select name="tingkat" id="tingkatSelect"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all @error('tingkat') border-red-300 @enderror">
                                    <option value="">-- Pilih Tingkat --</option>
                                    @foreach ($allTiers as $tier)
                                        <option value="{{ $tier }}" {{ $currentTingkat == $tier ? 'selected' : '' }}>{{ $tier }}</option>
                                    @endforeach
                                    <option value="__tambah_baru__" {{ !$allTiers->contains($currentTingkat) && $currentTingkat ? 'selected' : '' }}>+ Tambah Baru...</option>
                                </select>
                                <div id="tierBaruWrapper" class="mt-2 {{ !$allTiers->contains($currentTingkat) && $currentTingkat ? '' : 'hidden' }}">
                                    <input type="text" name="tingkat_baru" id="tingkatBaru" value="{{ !$allTiers->contains($currentTingkat) ? $currentTingkat : '' }}"
                                        class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400"
                                        placeholder="Masukkan tier baru">
                                </div>
                                @error('tingkat')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Diskon (%)</label>
                                <input type="number" name="diskon" value="{{ old('diskon', $membership->diskon) }}" step="0.01" min="0" max="100"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('diskon') border-red-300 @enderror"
                                    placeholder="Masukkan diskon">
                                @error('diskon')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Min. Transaksi</label>
                                <input type="number" name="min_transaksi" value="{{ old('min_transaksi', $membership->min_transaksi) }}" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('min_transaksi') border-red-300 @enderror"
                                    placeholder="Minimal jumlah transaksi">
                                @error('min_transaksi')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Min. Pembelian (Rp)</label>
                                <input type="number" name="min_pembelian" value="{{ old('min_pembelian', $membership->min_pembelian) }}" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('min_pembelian') border-red-300 @enderror"
                                    placeholder="Minimal total pembelian">
                                @error('min_pembelian')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Harga Upgrade (Rp)</label>
                                <input type="number" name="harga" value="{{ old('harga', $membership->harga) }}" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('harga') border-red-300 @enderror"
                                    placeholder="Biaya upgrade membership">
                                @error('harga')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Masa Berlaku (hari)</label>
                                <input type="number" name="masa_berlaku" value="{{ old('masa_berlaku', $membership->masa_berlaku) }}" min="0"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('masa_berlaku') border-red-300 @enderror"
                                    placeholder="Masukkan masa berlaku dalam hari">
                                @error('masa_berlaku')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-[13px] font-semibold text-gray-700 block mb-1.5">Deskripsi</label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl px-4 py-2.5 focus:outline-none focus:border-pink-300 focus:bg-white transition-all placeholder-gray-400 @error('deskripsi') border-red-300 @enderror"
                                    placeholder="Deskripsi paket membership">{{ old('deskripsi', $membership->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-[12px] text-gray-500 flex items-center gap-2">
                                    <i class="fa-solid fa-info-circle text-pink-400"></i>
                                    Status saat ini: <strong>{{ $membership->status === 'aktif' ? 'Aktif' : ($membership->status === 'suspend' ? 'Suspend' : 'Non Aktif') }}</strong>.
                                    Status akan otomatis berubah saat masa berlaku diperbarui (&gt; 0 = Aktif, 0 = Non Aktif).
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 pt-5 border-t border-gray-100">
                            <button type="submit"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[13px] font-semibold px-6 py-2.5 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Update
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
        document.getElementById('tingkatSelect').addEventListener('change', function() {
            const wrapper = document.getElementById('tierBaruWrapper');
            const input = document.getElementById('tingkatBaru');
            if (this.value === '__tambah_baru__') {
                wrapper.classList.remove('hidden');
                input.focus();
            } else {
                wrapper.classList.add('hidden');
                input.value = '';
            }
        });
        document.getElementById('membershipForm').addEventListener('submit', function(e) {
            const select = document.getElementById('tingkatSelect');
            const inputBaru = document.getElementById('tingkatBaru');
            if (select.value === '__tambah_baru__') {
                select.name = '';
                inputBaru.name = 'tingkat';
            }
        });

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
