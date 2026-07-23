<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Reservasi - BeautyCare</title>
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
        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: 'Inter', sans-serif; }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .btn-remove-row { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; }
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

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-pen-to-square text-pink-500 mr-2"></i>Edit Reservasi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-pen-to-square text-pink-300 mr-1"></i>Ubah detail reservasi
                            </p>
                        </div>
                        <a href="{{ route('admin.reservasi.index') }}"
                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.reservasi.update', $reservasi->id_booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-user text-pink-400 mr-1"></i>Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_pelanggan" class="form-input-custom @error('id_pelanggan') border-red-400 @enderror">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggan as $p)
                                        <option value="{{ $p->id_pelanggan }}" {{ old('id_pelanggan', $reservasi->id_pelanggan) == $p->id_pelanggan ? 'selected' : '' }}>
                                            {{ $p->nm_pelanggan }} ({{ $p->no_hp ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pelanggan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-user text-pink-400 mr-1"></i>Karyawan <span class="text-red-500">*</span>
                                </label>
                                <select name="id_karyawan" class="form-input-custom @error('id_karyawan') border-red-400 @enderror">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach ($karyawan as $k)
                                        <option value="{{ $k->id }}" {{ old('id_karyawan', $reservasi->id_karyawan) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_karyawan')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-calendar text-pink-400 mr-1"></i>Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal"
                                    class="form-input-custom @error('tanggal') border-red-400 @enderror"
                                    value="{{ old('tanggal', $reservasi->tanggal) }}">
                                @error('tanggal')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-clock text-pink-400 mr-1"></i>Jam <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam"
                                    class="form-input-custom @error('jam') border-red-400 @enderror"
                                    value="{{ old('jam', $reservasi->jam) }}">
                                @error('jam')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-regular fa-flag text-pink-400 mr-1"></i>Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" class="form-input-custom @error('status') border-red-400 @enderror">
                                    <option value="menunggu" {{ old('status', $reservasi->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="dikonfirmasi" {{ old('status', $reservasi->status) == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="diproses" {{ old('status', $reservasi->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ old('status', $reservasi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status', $reservasi->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-[14px] font-bold text-gray-700 mb-1">
                                <i class="fa-regular fa-list text-pink-500 mr-2"></i>Layanan
                            </h4>
                            <p class="text-[12px] text-gray-400 mb-4">Pilih layanan yang akan direservasi</p>

                            <div id="layanan-rows">
                                @forelse ($reservasi->detail as $i => $d)
                                <div class="layanan-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end mb-3 p-3 bg-pink-50/30 rounded-xl">
                                    <div class="md:col-span-4">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Layanan <span class="text-red-500">*</span></label>
                                        <select name="id_layanan[]" class="form-input-custom layanan-select" required>
                                            <option value="">-- Pilih Layanan --</option>
                                            @foreach ($layanan as $l)
                                                <option value="{{ $l->id_layanan }}" data-harga="{{ $l->harga }}" {{ $d->id_layanan == $l->id_layanan ? 'selected' : '' }}>{{ $l->nm_layanan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Harga</label>
                                        <input type="number" name="harga[]" class="form-input-custom harga-input" placeholder="0" min="0" value="{{ $d->harga }}" readonly>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Diskon</label>
                                        <input type="number" name="diskon[]" class="form-input-custom diskon-input" placeholder="0" min="0" value="{{ $d->diskon ?? 0 }}" oninput="hitungSubtotal(this)">
                                    </div>
                                    <div class="md:col-span-2 flex items-center gap-2">
                                        <div class="flex-1">
                                            <label class="text-[11px] font-medium text-gray-500 mb-1 block">Subtotal</label>
                                            <input type="text" class="form-input-custom subtotal-text bg-gray-50/50 text-gray-700 font-semibold" value="Rp {{ number_format(($d->harga ?? 0) - ($d->diskon ?? 0), 0, ',', '.') }}" readonly>
                                        </div>
                                        <button type="button" class="btn-remove-row bg-red-100 text-red-500 hover:bg-red-200 mt-5" onclick="hapusRow(this)" title="Hapus">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                @empty
                                <div class="layanan-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end mb-3 p-3 bg-pink-50/30 rounded-xl">
                                    <div class="md:col-span-4">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Layanan <span class="text-red-500">*</span></label>
                                        <select name="id_layanan[]" class="form-input-custom layanan-select" required>
                                            <option value="">-- Pilih Layanan --</option>
                                            @foreach ($layanan as $l)
                                                <option value="{{ $l->id_layanan }}" data-harga="{{ $l->harga }}">{{ $l->nm_layanan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Harga</label>
                                        <input type="number" name="harga[]" class="form-input-custom harga-input" placeholder="0" min="0" readonly>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="text-[11px] font-medium text-gray-500 mb-1 block">Diskon</label>
                                        <input type="number" name="diskon[]" class="form-input-custom diskon-input" placeholder="0" min="0" value="0" oninput="hitungSubtotal(this)">
                                    </div>
                                    <div class="md:col-span-2 flex items-center gap-2">
                                        <div class="flex-1">
                                            <label class="text-[11px] font-medium text-gray-500 mb-1 block">Subtotal</label>
                                            <input type="text" class="form-input-custom subtotal-text bg-gray-50/50 text-gray-700 font-semibold" readonly>
                                        </div>
                                        <button type="button" class="btn-remove-row bg-red-100 text-red-500 hover:bg-red-200 mt-5" onclick="hapusRow(this)" title="Hapus">
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

                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex justify-between items-center">
                                    <span class="text-[13px] font-semibold text-gray-600">Grand Total</span>
                                    <span id="grand-total" class="text-[18px] font-bold text-pink-500">Rp {{ number_format($reservasi->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0)), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label">
                                <i class="fa-regular fa-note-sticky text-pink-400 mr-1"></i>Catatan
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
                            <a href="{{ route('admin.reservasi.index') }}"
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
        function tambahRow() {
            const container = document.getElementById('layanan-rows');
            const firstRow = container.querySelector('.layanan-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(function(input) {
                input.value = '';
            });
            newRow.querySelector('select').selectedIndex = 0;

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
                row.querySelector('.harga-input').value = harga;
                hitungSubtotal(row.querySelector('.diskon-input'));
            }
        });

        function hitungSubtotal(el) {
            const row = el.closest('.layanan-row');
            const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
            const diskon = parseFloat(row.querySelector('.diskon-input').value) || 0;
            const subtotal = Math.max(0, harga - diskon);
            row.querySelector('.subtotal-text').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            hitungGrandTotal();
        }

        function hitungGrandTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-text').forEach(function(el) {
                const val = el.value.replace(/[^0-9]/g, '');
                total += parseInt(val) || 0;
            });
            document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
