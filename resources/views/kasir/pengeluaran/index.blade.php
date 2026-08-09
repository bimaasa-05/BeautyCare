<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengeluaran - BeautyCare</title>
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

        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-700 border border-green-200 text-[13px] font-medium">
                    <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden mb-5">
                    <div class="mb-5">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-arrow-down text-red-500 mr-2"></i>Transaksi Pengeluaran
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">Catat pengeluaran operasional kasir</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
                        <div class="rounded-xl p-4 bg-gradient-to-br from-red-50 to-rose-50 border border-red-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pengeluaran Bulan Ini</p>
                            <p class="text-[22px] font-bold text-red-600 mt-1">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl p-4 bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Pengeluaran</p>
                            <p class="text-[22px] font-bold text-amber-600 mt-1">Rp {{ number_format($totalSemua, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-xl p-4 bg-gradient-to-br from-pink-50 to-rose-50 border border-pink-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                            <p class="text-[22px] font-bold text-pink-600 mt-1">{{ $pengeluaran->total() }} catatan</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center gap-3 mb-5">
                        <form action="{{ route('kasir.pengeluaran.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                            <input type="month" name="bulan" value="{{ $bulan }}" class="form-input-custom md:!w-44">
                            <select name="kategori" class="form-input-custom md:!w-52">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $k)
                                <option value="{{ $k }}" {{ $kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-pink-500 text-white text-[12px] font-semibold hover:bg-pink-600 transition-colors">
                                <i class="fa-solid fa-filter mr-1"></i>Filter
                            </button>
                        </form>
                        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                            class="px-4 py-2 rounded-xl bg-red-500 text-white text-[12px] font-semibold hover:bg-red-600 transition-colors">
                            <i class="fa-solid fa-plus mr-1"></i>Tambah Pengeluaran
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-[13px]">
                            <thead>
                                <tr class="border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-400">
                                    <th class="text-left py-3 px-3 font-semibold">Tanggal</th>
                                    <th class="text-left py-3 px-3 font-semibold">Kategori</th>
                                    <th class="text-left py-3 px-3 font-semibold">Keterangan</th>
                                    <th class="text-right py-3 px-3 font-semibold">Nominal</th>
                                    <th class="text-center py-3 px-3 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengeluaran as $p)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/60 transition-colors">
                                    <td class="py-3 px-3 text-gray-600">{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}</td>
                                    <td class="py-3 px-3">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-[11px] font-semibold">
                                            <i class="fa-solid fa-tag text-[10px]"></i>{{ $p->kategori }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-gray-600 max-w-[240px] truncate">{{ $p->keterangan ?: '-' }}</td>
                                    <td class="py-3 px-3 text-right font-bold text-red-600">- Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <form action="{{ route('kasir.pengeluaran.destroy', $p->id_pengeluaran) }}" method="POST"
                                            onsubmit="return confirm('Hapus pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 inline-flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <i class="fa-regular fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-400 text-[13px]">
                                        <i class="fa-regular fa-folder-open text-3xl block mb-2"></i>
                                        Belum ada data pengeluaran
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pagination-custom">
                        {{ $pengeluaran->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('modalTambah').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-[15px] font-bold text-gray-800">
                    <i class="fa-solid fa-arrow-down text-red-500 mr-2"></i>Tambah Pengeluaran
                </h4>
                <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('kasir.pengeluaran.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-input-custom" required>
                        @error('tanggal')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" class="form-input-custom" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional" {{ old('kategori') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                            <option value="Perawatan Alat" {{ old('kategori') == 'Perawatan Alat' ? 'selected' : '' }}>Perawatan Alat</option>
                            <option value="Bahan & Stok" {{ old('kategori') == 'Bahan & Stok' ? 'selected' : '' }}>Bahan & Stok</option>
                            <option value="Listrik & Air" {{ old('kategori') == 'Listrik & Air' ? 'selected' : '' }}>Listrik & Air</option>
                            <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" min="1" value="{{ old('nominal') }}" placeholder="Masukkan nominal" class="form-input-custom" required>
                        @error('nominal')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan pengeluaran (opsional)" class="form-input-custom">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-red-500 text-white text-[13px] font-semibold hover:bg-red-600 transition-colors">
                        <i class="fa-solid fa-check mr-1"></i>Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
