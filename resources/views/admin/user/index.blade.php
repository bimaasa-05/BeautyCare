<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Data User</h3>
                                <p>Selamat datang di Panel Manajemen User. Di sini, Anda memegang kendali penuh atas
                                    komunitas pengguna kita! Anda bisa dengan mudah mengundang anggota baru, mengedit
                                    informasi profil, atau mengubah izin akses mereka hanya dengan beberapa klik. Jaga
                                    agar data pengguna tetap rapi dan sistem kita selalu aman.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full min-h-[580px] justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Semua User</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $users->count() }} pengguna</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="text" id="searchUser" placeholder="Cari user..."
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[200px] lg:w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400">
                                </div>
                                <div class="relative filter-user">
                                    <button onclick="toggleFilterUser()"
                                        class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                        <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                    </button>
                                    <div id="filterUserPanel"
                                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-50">
                                        <p
                                            class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                            Role</p>
                                        <div class="space-y-2 mb-3">
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="" checked
                                                    onchange="applyFilterUser()">
                                                Semua
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="admin"
                                                    onchange="applyFilterUser()">
                                                Admin
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="kasir"
                                                    onchange="applyFilterUser()">
                                                Kasir
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="beautycian"
                                                    onchange="applyFilterUser()">
                                                Beautycian
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="pelanggan"
                                                    onchange="applyFilterUser()">
                                                Pelanggan
                                            </label>
                                        </div>
                                        <p
                                            class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">
                                            Status</p>
                                        <div class="space-y-2">
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="" checked
                                                    onchange="applyFilterUser()">
                                                Semua
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="aktif"
                                                    onchange="applyFilterUser()">
                                                Aktif
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="non_aktif"
                                                    onchange="applyFilterUser()">
                                                Non Aktif
                                            </label>
                                            <label
                                                class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="suspend"
                                                    onchange="applyFilterUser()">
                                                Suspend
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.user.create') }}"
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
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Password</th>
                                        <th class="py-3 px-4">Foto</th>
                                        <th class="py-3 px-4">Nomor Hp</th>
                                        <th class="py-3 px-4">Role</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody" class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @include('admin.user.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function getFilterParamsUser() {
            const params = new URLSearchParams();
            const q = document.getElementById('searchUser').value.trim();
            if (q) params.set('search', q);
            const role = document.querySelector('.filter-user input[name="filter_role"]:checked');
            if (role && role.value) params.set('filter_role', role.value);
            const status = document.querySelector('.filter-user input[name="filter_status"]:checked');
            if (status && status.value) params.set('filter_status', status.value);
            return params.toString();
        }

        function fetchUser() {
            fetch('{{ route('admin.user.index') }}?' + getFilterParamsUser(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('userTableBody').innerHTML = html;
                })
                .catch(() => location.reload());
        }

        function toggleFilterUser() {
            document.getElementById('filterUserPanel').classList.toggle('hidden');
        }

        function applyFilterUser() {
            document.getElementById('filterUserPanel').classList.add('hidden');
            fetchUser();
        }

        document.addEventListener('click', function (e) {
            const panel = document.getElementById('filterUserPanel');
            if (panel && !panel.classList.contains('hidden')) {
                const btn = document.querySelector('.filter-user');
                if (btn && !btn.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            }
        });

        let searchTimer;
        document.getElementById('searchUser').addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchUser, 400);
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