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
    </style>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-decoration { position: absolute; pointer-events: none; opacity: 0.1; font-size: 60px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .status-red { background: #FDE8E8; color: #EF4444; }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -6px rgba(0,0,0,0.08); }

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

        .form-input-custom { border: 1.5px solid #ECECEC; border-radius: 12px; padding: 10px 14px; font-size: 13px; width: 100%; transition: all 0.3s ease; font-family: 'Poppins', sans-serif; }
        .form-input-custom:focus { border-color: #FF4F87; box-shadow: 0 0 0 3px rgba(255,79,135,0.12); outline: none; }
        .form-input-custom::placeholder { color: #aaa; }
        select.form-input-custom { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
        .form-label { font-size: 12px; font-weight: 600; color: #555; margin-bottom: 6px; display: block; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; background: #fafafa; }
        .data-table td { padding: 12px 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; }
        .data-table tbody tr:hover { background: #fafafa; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
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
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Pengeluaran</h3>
                            <p>Kelola semua data pengeluaran</p>
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

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden mb-5">
                    <div class="float-decoration" style="top:-10px;right:-10px;">💸</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">📊</div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
                        <div class="stat-card bg-gradient-to-br from-red-50 to-rose-50 rounded-xl p-4 border border-red-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pengeluaran Bulan Ini</p>
                                    <p class="text-[26px] font-bold text-red-600 mt-1">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fa-solid fa-calendar-days text-red-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Pengeluaran</p>
                                    <p class="text-[26px] font-bold text-amber-600 mt-1">Rp {{ number_format($totalSemua, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-trend-down text-amber-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-4 border border-pink-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Catatan</p>
                                    <p class="text-[26px] font-bold text-pink-600 mt-1">{{ $pengeluaran->total() }} catatan</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-solid fa-receipt text-pink-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-start sm:items-center justify-between gap-3 mb-5">
                        <form action="{{ route('admin.pengeluaran.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 flex-1">
                            <input type="month" name="bulan" value="{{ $bulan }}" class="form-input-custom sm:!w-44">
                            <select name="kategori" class="form-input-custom sm:!w-52">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $k)
                                <option value="{{ $k }}" {{ $kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-pink-500 text-white text-[12px] font-semibold hover:bg-pink-600 transition-colors">
                                <i class="fa-solid fa-filter mr-1"></i>Filter
                            </button>
                        </form>
                        <div class="flex gap-2 flex-wrap">
                            <a href="{{ route('admin.pengeluaran.pembelian-create') }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 text-white text-[12px] font-semibold hover:bg-amber-600 transition-colors">
                                <i class="fa-solid fa-truck"></i> Pembelian Stok
                            </a>
                            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 text-white text-[12px] font-semibold hover:bg-red-600 transition-colors">
                                <i class="fa-solid fa-plus"></i> Tambah Pengeluaran
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="w-[120px]">Tanggal</th>
                                    <th class="w-[150px]">Kategori</th>
                                    <th>Keterangan</th>
                                    <th class="w-[160px]">Dicatat Oleh</th>
                                    <th class="w-[140px] text-right">Nominal</th>
                                    <th class="w-[100px] text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengeluaran as $p)
                                <tr>
                                    <td class="text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}</td>
                                    <td>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-[11px] font-semibold">
                                            <i class="fa-solid fa-tag text-[10px]"></i>{{ $p->kategori }}
                                        </span>
                                    </td>
                                    <td class="text-gray-600 max-w-[300px] truncate" title="{{ $p->keterangan }}">{{ $p->keterangan ?: '-' }}</td>
                                    <td class="text-gray-600">{{ $p->user ? $p->user->nama : '-' }}</td>
                                    <td class="text-right font-bold text-red-600">- Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <button onclick="editPengeluaran({{ $p->id_pengeluaran }}, '{{ $p->tanggal }}', '{{ addslashes($p->kategori) }}', {{ $p->nominal }}, '{{ addslashes($p->keterangan ?? '') }}')"
                                                class="w-8 h-8 inline-flex items-center justify-center text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Edit">
                                                <i class="fa-regular fa-pen-to-square text-xs"></i>
                                            </button>
                                            <form action="{{ route('admin.pengeluaran.destroy', $p->id_pengeluaran) }}" method="POST"
                                                onsubmit="return confirm('Hapus pengeluaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 inline-flex items-center justify-center text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-14 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center">
                                                <i class="fa-solid fa-receipt text-3xl text-red-200"></i>
                                            </div>
                                            <p class="text-gray-400 font-medium text-[14px]">Belum ada data pengeluaran</p>
                                            <p class="text-gray-300 text-[12px] -mt-2">Mulai catat pengeluaran dengan klik tombol di atas</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($pengeluaran->hasPages())
                    <div class="mt-4 px-4 pagination-custom">
                        {{ $pengeluaran->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
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
            <form action="{{ route('admin.pengeluaran.store') }}" method="POST">
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

    <!-- Modal Edit -->
    <div id="modalEdit" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('modalEdit').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-[15px] font-bold text-gray-800">
                    <i class="fa-solid fa-pen-to-square text-blue-500 mr-2"></i>Edit Pengeluaran
                </h4>
                <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="" method="POST" id="formEdit">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-input-custom" required>
                    </div>
                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" id="edit_kategori" class="form-input-custom" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Perawatan Alat">Perawatan Alat</option>
                            <option value="Bahan & Stok">Bahan & Stok</option>
                            <option value="Listrik & Air">Listrik & Air</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" id="edit_nominal" min="1" class="form-input-custom" required>
                    </div>
                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" rows="2" class="form-input-custom"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-500 text-white text-[13px] font-semibold hover:bg-blue-600 transition-colors">
                        <i class="fa-solid fa-check mr-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editPengeluaran(id, tanggal, kategori, nominal, keterangan) {
            document.getElementById('formEdit').action = "{{ url('admin/pengeluaran') }}/" + id;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_nominal').value = nominal;
            document.getElementById('edit_keterangan').value = keterangan;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>