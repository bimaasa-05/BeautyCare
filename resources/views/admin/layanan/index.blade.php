<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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

            <main class="flex-1 flex flex-col overflow-hidden relative">
                <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                            <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6">
                        <div class="space-y-4">

                            <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2 flex-wrap" id="kategoriFilters">
                                <button data-kategori=""
                                    class="filter-kategori-btn px-3 py-2 rounded-xl text-xs font-bold transition-all bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm">Semua</button>
                                @foreach ($kategoriLayanan as $k)
                                <button data-kategori="{{ $k->id_kategori_layanan }}"
                                    class="filter-kategori-btn px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">{{ $k->nm_layanan }}</button>
                                @endforeach
                            </div>
                                <div class="flex items-center gap-3 flex-wrap gap-2">
                                    <div class="relative">
                                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                        <input type="text" id="searchLayanan" placeholder="Cari layanan..."
                                            class="bg-white border border-gray-200 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[200px] lg:w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400 shadow-sm">
                                    </div>
                                    <div class="relative filter-layanan">
                                        <button onclick="toggleFilterLayanan()"
                                            class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                            <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                        </button>
                                        <div id="filterLayananPanel"
                                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-50">
                                            <p class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">Status</p>
                                            <div class="space-y-2">
                                                <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                    <input type="radio" name="filter_status" value="" checked
                                                        onchange="applyFilterLayanan()">
                                                    Semua
                                                </label>
                                                <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                    <input type="radio" name="filter_status" value="Tersedia"
                                                        onchange="applyFilterLayanan()">
                                                    Tersedia
                                                </label>
                                                <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                    <input type="radio" name="filter_status" value="Tidak Tersedia"
                                                        onchange="applyFilterLayanan()">
                                                    Tidak Tersedia
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.layanan.create') }}"
                                        class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg> Tambah Layanan
                                    </a>
                                </div>
                            </div>

                            <div id="layananGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @include('admin.layanan.partials.grid')
                            </div>
                        </div>
                    </main>
                </div>
            </main>
        </main>
    </div>

    <script>
        function updateStatus(el, id) {
            const val = el.value;
            fetch('/admin/layanan/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: val })
            })
            .then(res => {
                if (!res.ok) throw new Error();
                const parent = el.parentElement;
                const arrow = parent.querySelector('svg');
                el.className = val === 'Tersedia'
                    ? 'text-[11px] font-semibold pl-3 pr-7 py-1.5 rounded-xl appearance-none cursor-pointer shadow-sm bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all'
                    : 'text-[11px] font-semibold pl-3 pr-7 py-1.5 rounded-xl appearance-none cursor-pointer shadow-sm bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all';
                if (arrow) {
                    arrow.className = 'w-3 h-3 ' + (val === 'Tersedia' ? 'text-emerald-500' : 'text-rose-500');
                }
            })
            .catch(() => location.reload());
        }

        function getFilterParamsLayanan() {
            const params = new URLSearchParams();
            const q = document.getElementById('searchLayanan').value.trim();
            if (q) params.set('search', q);
            const aktifKategori = document.querySelector('#kategoriFilters .filter-kategori-btn.active');
            if (aktifKategori) {
                const kid = aktifKategori.dataset.kategori;
                if (kid) params.set('filter_kategori', kid);
            }
            const status = document.querySelector('.filter-layanan input[name="filter_status"]:checked');
            if (status && status.value) params.set('filter_status', status.value);
            return params.toString();
        }

        function fetchLayanan() {
            fetch('{{ route('admin.layanan.index') }}?' + getFilterParamsLayanan(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('layananGrid').innerHTML = html;
            })
            .catch(() => location.reload());
        }

        document.querySelectorAll('#kategoriFilters .filter-kategori-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('#kategoriFilters .filter-kategori-btn').forEach(b => {
                    b.className = 'filter-kategori-btn px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]';
                    b.classList.remove('active');
                });
                if (this.dataset.kategori === '') {
                    this.className = 'filter-kategori-btn px-3 py-2 rounded-xl text-xs font-bold transition-all bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm';
                } else {
                    this.className = 'filter-kategori-btn px-3 py-2 rounded-xl text-xs font-bold transition-all bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm';
                }
                this.classList.add('active');
                fetchLayanan();
            });
        });

        function toggleFilterLayanan() {
            document.getElementById('filterLayananPanel').classList.toggle('hidden');
        }

        function applyFilterLayanan() {
            document.getElementById('filterLayananPanel').classList.add('hidden');
            fetchLayanan();
        }

        document.addEventListener('click', function(e) {
            const panel = document.getElementById('filterLayananPanel');
            if (panel && !panel.classList.contains('hidden')) {
                const btn = document.querySelector('.filter-layanan');
                if (btn && !btn.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            }
        });

        let searchTimer;
        document.getElementById('searchLayanan').addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchLayanan, 400);
        });

        // Set current date
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>