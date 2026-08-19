<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konsultasi - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">

    <style>
    .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
    .sidebar-overlay.active { display: block; }
    @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
    @media (max-width: 768px) {
        .filter-bar { justify-content: flex-start !important; align-items: stretch !important; }
        .filter-bar .relative { flex: 1 1 100%; }
        .filter-bar input, .filter-bar select { width: 100% !important; }
    }

    
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
    .badge-menunggu { background: #FEF3C7; color: #D97706; }
    .badge-dikonfirmasi { background: #DBEAFE; color: #2563EB; }
    .badge-selesai { background: #E8F8EE; color: #22C55E; }
    .badge-ditolak { background: #FDE8E8; color: #EF4444; }

    .modal-premium { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 100; align-items: center; justify-content: center; padding: 20px; }
    .modal-premium.show { display: flex; }
    .modal-premium .modal-box { background: #fff; border-radius: 20px; padding: 28px; width: 100%; max-width: 440px; position: relative; animation: modalIn .25s ease; }
    @keyframes modalIn { from { opacity: 0; transform: translateY(16px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .modal-premium .modal-icon-wrap { width: 52px; height: 52px; border-radius: 16px; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .modal-premium h3 { text-align: center; font-size: 16px; font-weight: 700; color: #1F2937; margin: 0 0 8px; }
    .modal-premium p { text-align: center; font-size: 12px; color: #6B7280; margin: 0 0 20px; }
    .modal-premium .modal-actions { display: flex; gap: 10px; justify-content: center; }
    .modal-premium .btn-cancel { padding: 10px 22px; border-radius: 100px; border: 1.5px solid #E5E7EB; background: #fff; color: #6B7280; font-size: 12px; font-weight: 600; cursor: pointer; }
    .modal-premium .btn-danger { padding: 10px 22px; border-radius: 100px; border: none; background: #EF4444; color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; }
    .modal-premium .btn-primary { padding: 10px 22px; border-radius: 100px; border: none; background: linear-gradient(135deg, #EC4899, #F472B6); color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(236,72,153,.3); }
    .modal-premium select, .modal-premium textarea {
        width: 100%; padding: 10px 14px; border: 1.5px solid #E5E7EB; border-radius: 12px;
        font-size: 12px; outline: none; background: #FAFAFA; margin-bottom: 12px; font-family: var(--font-primary);
    }
    .modal-premium select:focus, .modal-premium textarea:focus { border-color: #EC4899; background: #fff; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                @if(session('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-[12px] rounded-xl px-4 py-3 mb-4 flex items-center gap-2">
                    <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-600 text-[12px] rounded-xl px-4 py-3 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-comments text-pink-500 mr-2"></i>Permintaan Konsultasi
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            Konfirmasi dan tugaskan konsultasi member ke beautician
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-amber">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu</p>
                                    <p class="text-[24px] font-bold text-amber-600 mt-1">{{ $konsultasi->where('status','menunggu')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-blue">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Dikonfirmasi</p>
                                    <p class="text-[24px] font-bold text-blue-600 mt-1">{{ $konsultasi->where('status','dikonfirmasi')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-user-check text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $konsultasi->where('status','selesai')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-red">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Ditolak</p>
                                    <p class="text-[24px] font-bold text-red-600 mt-1">{{ $konsultasi->where('status','ditolak')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fa-solid fa-ban text-red-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="" class="flex flex-wrap items-center justify-end gap-2 mb-4 filter-bar">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari konsultasi..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ Request()->keyword }}">
                        </div>
                        <select name="status" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-4 pr-8 py-2 focus:outline-none focus:border-pink-300 transition-all">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ $filterStatus === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dikonfirmasi" {{ $filterStatus === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="selesai" {{ $filterStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $filterStatus === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-enhanced table-card-mobile">
                            <thead>
                                <tr class="text-[11px] uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                    <th class="px-3 py-3 font-semibold">Pelanggan</th>
                                    <th class="px-3 py-3 font-semibold">Jadwal</th>
                                    <th class="px-3 py-3 font-semibold">Topik</th>
                                    <th class="px-3 py-3 font-semibold">Mode</th>
                                    <th class="px-3 py-3 font-semibold">Terapis</th>
                                    <th class="px-3 py-3 font-semibold">Status</th>
                                    <th class="px-3 py-3 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($konsultasi as $item)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3" data-label="Pelanggan">
                                        <div class="flex items-center gap-2">
                                            <img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="{{ $item->pelanggan->nm_pelanggan ?? '-' }}">
                                            <div>
                                                <div class="text-[12px] font-semibold text-gray-700">{{ $item->pelanggan->nm_pelanggan ?? '-' }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $item->pelanggan->no_hp ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3" data-label="Jadwal">
                                        <div class="text-[12px] text-gray-600 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</div>
                                        <div class="text-[10px] text-gray-400">{{ str_replace(':', '.', substr($item->jam, 0, 5)) }}</div>
                                    </td>
                                    <td class="px-3 py-3" data-label="Topik">
                                        <div class="text-[12px] font-semibold text-gray-700 max-w-[200px] truncate">{{ $item->topik }}</div>
                                        @if($item->pesan)
                                        <div class="text-[10px] text-gray-400 max-w-[200px] truncate">{{ $item->pesan }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3" data-label="Mode">
                                        <span class="badge-status {{ $item->mode === 'online' ? 'bg-purple-50 text-purple-600' : 'bg-sky-50 text-sky-600' }}">
                                            <i class="fa-solid {{ $item->mode === 'online' ? 'fa-globe' : 'fa-store' }}"></i>
                                            {{ ucfirst($item->mode) }}
                                        </span>
                                        @if($item->mode === 'online' && $item->media)
                                        <div class="text-[10px] text-gray-400 mt-1">{{ $item->media === 'whatsapp_chat' ? 'WhatsApp Chat' : 'WhatsApp Video Call' }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3" data-label="Terapis">
                                        @if($item->karyawan)
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-user text-gray-300 text-[10px]"></i>
                                            <span class="text-[12px] text-gray-600">{{ $item->karyawan->nama }}</span>
                                        </div>
                                        @else
                                        <span class="text-[11px] text-amber-500 italic">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3" data-label="Status">
                                        <span class="badge-status badge-{{ $item->status }}">
                                            <i class="fa-solid {{ $item->status === 'menunggu' ? 'fa-clock' : ($item->status === 'dikonfirmasi' ? 'fa-check' : ($item->status === 'selesai' ? 'fa-circle-check' : 'fa-ban')) }} text-[9px]"></i>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center" data-label="">
                                        @if($item->status === 'menunggu')
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button onclick="bukaKonfirmasi({{ $item->id_konsultasi }}, '{{ addslashes($item->topik) }}')"
                                                class="px-3 py-1.5 rounded-full bg-blue-500 hover:bg-blue-600 text-white text-[11px] font-semibold transition-colors">
                                                <i class="fa-solid fa-check mr-1"></i> Konfirmasi
                                            </button>
                                            <button onclick="bukaTolak({{ $item->id_konsultasi }}, '{{ addslashes($item->topik) }}')"
                                                class="px-3 py-1.5 rounded-full bg-red-50 hover:bg-red-100 text-red-500 text-[11px] font-semibold transition-colors">
                                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                            </button>
                                        </div>
                                        @else
                                        <span class="text-[11px] text-gray-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <div class="w-16 h-16 mx-auto rounded-2xl bg-pink-50 flex items-center justify-center text-[24px] text-pink-300 mb-3">
                                            <i class="fa-regular fa-comments"></i>
                                        </div>
                                        <p class="text-[13px] font-semibold text-gray-500">Belum ada permintaan konsultasi</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Permintaan dari member akan muncul di sini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ Modal Konfirmasi ═══ -->
    <div id="konfirmasiModal" class="modal-premium">
        <div class="modal-box">
            <form id="konfirmasiForm" method="POST">
                @csrf
                <div class="modal-icon-wrap bg-blue-100 text-blue-500">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <h3 id="konfirmasiTitle">Konfirmasi Konsultasi</h3>
                <p id="konfirmasiBody">Pilih beautician yang akan menangani konsultasi ini.</p>
                <select name="id_karyawan" id="konfirmasiKaryawan" required>
                    <option value="">— Pilih Beautycian —</option>
                    @foreach($karyawan as $b)
                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                    @endforeach
                </select>
                <div class="modal-actions">
                    <button type="button" onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-check mr-1"></i> Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ═══ Modal Tolak ═══ -->
    <div id="tolakModal" class="modal-premium">
        <div class="modal-box">
            <form id="tolakForm" method="POST">
                @csrf
                <div class="modal-icon-wrap bg-red-100 text-red-500">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <h3 id="tolakTitle">Tolak Konsultasi</h3>
                <p id="tolakBody">Berikan alasan penolakan agar pelanggan bisa memahami.</p>
                <textarea name="alasan" rows="3" placeholder="Alasan penolakan (opsional)"></textarea>
                <div class="modal-actions">
                    <button type="button" onclick="tutupTolak()" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-danger"><i class="fa-solid fa-xmark mr-1"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const baseUrl = '{{ url('/kasir/konsultasi') }}';

    function bukaKonfirmasi(id, topik) {
        document.getElementById('konfirmasiForm').action = baseUrl + '/' + id + '/konfirmasi';
        document.getElementById('konfirmasiTitle').textContent = 'Konfirmasi Konsultasi';
        document.getElementById('konfirmasiBody').innerHTML = 'Pilih beautician untuk menangani konsultasi "<strong>' + topik + '</strong>".';
        document.getElementById('konfirmasiModal').classList.add('show');
    }
    function tutupKonfirmasi() {
        document.getElementById('konfirmasiModal').classList.remove('show');
    }
    function bukaTolak(id, topik) {
        document.getElementById('tolakForm').action = baseUrl + '/' + id + '/tolak';
        document.getElementById('tolakTitle').textContent = 'Tolak Konsultasi';
        document.getElementById('tolakBody').innerHTML = 'Tolak konsultasi "<strong>' + topik + '</strong>"?;'
        document.getElementById('tolakModal').classList.add('show');
    }
    function tutupTolak() {
        document.getElementById('tolakModal').classList.remove('show');
    }
    document.getElementById('konfirmasiModal').addEventListener('click', function(e) { if (e.target === this) tutupKonfirmasi(); });
    document.getElementById('tolakModal').addEventListener('click', function(e) { if (e.target === this) tutupTolak(); });
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { tutupKonfirmasi(); tutupTolak(); } });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
