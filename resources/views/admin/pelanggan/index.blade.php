<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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

        @media (max-width: 768px) {
            .admin-table thead {
                display: none;
            }

            .admin-table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid #f0f0f0;
            }

            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }

            .admin-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #9ca3af;
                font-size: 11px;
                text-transform: uppercase;
            }

            .admin-table tbody td:first-child {
                padding-left: 0;
            }

            .admin-table tbody td:last-child {
                padding-right: 0;
            }
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
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <span class="nav-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="8.5" cy="7" r="4" />
                                        <polyline points="17 11 19 13 23 9" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Data Pelanggan</h3>
                                <p>Selamat datang di Pusat Data Pelanggan! Di sini, Anda memiliki kendali penuh untuk mengelola informasi pelanggan kita agar tetap up-to-date. Anda dapat dengan mudah memperbarui profil mereka, memantau status akun, atau membantu menyelesaikan kendala data hanya dalam beberapa klik. Mari pastikan setiap informasi tercatat dengan rapi agar kita bisa selalu memberikan pelayanan yang terbaik!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full min-h-[580px] justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Semua Pelanggan</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $pelanggan->count() }} pelanggan
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="text" id="searchPelanggan" placeholder="Cari pelanggan..."
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[200px] lg:w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400">
                                </div>
                                <div class="relative filter-pelanggan">
                                    <button onclick="toggleFilterPelanggan()"
                                        class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                        <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                    </button>
                                    <div id="filterPelangganPanel"
                                        class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-50">
                                        <p
                                            class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                            Urutkan</p>
                                        <div class="space-y-2 mb-3">
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_sort" value="desc" checked
                                                    onchange="applyFilterPelanggan()">
                                                Terbaru
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_sort" value="asc"
                                                    onchange="applyFilterPelanggan()">
                                                Terlama
                                            </label>
                                        </div>
                                        <p
                                            class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                            Sumber</p>
                                        <div class="space-y-2 mb-3">
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_sumber" value="" checked
                                                    onchange="applyFilterPelanggan()">
                                                Semua
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_sumber" value="online"
                                                    onchange="applyFilterPelanggan()">
                                                Online
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_sumber" value="walkin"
                                                    onchange="applyFilterPelanggan()">
                                                Walk-in
                                            </label>
                                        </div>
                                        <p
                                            class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                            Member</p>
                                        <div class="space-y-2">
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_member" value="" checked
                                                    onchange="applyFilterPelanggan()">
                                                Semua
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_member" value="yes"
                                                    onchange="applyFilterPelanggan()">
                                                Punya Member
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_member" value="no"
                                                    onchange="applyFilterPelanggan()">
                                                Tanpa Member
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.pelanggan.create') }}"
                                    class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                    <i class="fa-solid fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-4 w-10">#</th>
                                        <th class="py-3 px-4">Nama Lengkap</th>
                                        <th class="py-3 px-4">Sumber</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4">Nomor Hp</th>
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Alamat</th>
                                        <th class="py-3 px-4">Member</th>
                                        <th class="py-3 px-4">Catatan Alergi</th>
                                        <th class="py-3 px-4">Foto</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="pelangganTableBody"
                                    class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @include('admin.pelanggan.partials.table')
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function getFilterParamsPelanggan() {
            const params = new URLSearchParams();
            const q = document.getElementById('searchPelanggan').value.trim();
            if (q) params.set('search', q);
            const sort = document.querySelector('.filter-pelanggan input[name="filter_sort"]:checked');
            if (sort) params.set('filter_sort', sort.value);
            const member = document.querySelector('.filter-pelanggan input[name="filter_member"]:checked');
            if (member && member.value) params.set('filter_member', member.value);
            const sumber = document.querySelector('.filter-pelanggan input[name="filter_sumber"]:checked');
            if (sumber && sumber.value) params.set('filter_sumber', sumber.value);
            return params.toString();
        }

        function fetchPelanggan() {
            fetch('{{ route('admin.pelanggan.index') }}?' + getFilterParamsPelanggan(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('pelangganTableBody').innerHTML = html;
                })
                .catch(() => location.reload());
        }

        function toggleFilterPelanggan() {
            document.getElementById('filterPelangganPanel').classList.toggle('hidden');
        }

        function applyFilterPelanggan() {
            document.getElementById('filterPelangganPanel').classList.add('hidden');
            fetchPelanggan();
        }

        document.addEventListener('click', function (e) {
            const panel = document.getElementById('filterPelangganPanel');
            if (panel && !panel.classList.contains('hidden')) {
                const btn = document.querySelector('.filter-pelanggan');
                if (btn && !btn.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            }
        });

        let searchTimer;
        document.getElementById('searchPelanggan').addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchPelanggan, 400);
        });

        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>