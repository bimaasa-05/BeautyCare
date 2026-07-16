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
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-8">

                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full min-h-[580px] justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Semua User</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total {{ $users->count() }} pengguna</p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <i
                                        class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                    <input type="text" id="searchUser" placeholder="Cari user..."
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400">
                                </div>
                                <div class="relative filter-user">
                                    <button onclick="toggleFilterUser()"
                                        class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                        <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                    </button>
                                    <div id="filterUserPanel"
                                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-50">
                                        <p class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">Role</p>
                                        <div class="space-y-2 mb-3">
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="" checked
                                                    onchange="applyFilterUser()">
                                                Semua
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="admin"
                                                    onchange="applyFilterUser()">
                                                Admin
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="kasir"
                                                    onchange="applyFilterUser()">
                                                Kasir
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="beautycian"
                                                    onchange="applyFilterUser()">
                                                Beautycian
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_role" value="pelanggan"
                                                    onchange="applyFilterUser()">
                                                Pelanggan
                                            </label>
                                        </div>
                                        <p class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">Status</p>
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="" checked
                                                    onchange="applyFilterUser()">
                                                Semua
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="aktif"
                                                    onchange="applyFilterUser()">
                                                Aktif
                                            </label>
                                            <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                                <input type="radio" name="filter_status" value="non_aktif"
                                                    onchange="applyFilterUser()">
                                                Non Aktif
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
                            <table class="w-full text-left border-collapse">
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

        document.addEventListener('click', function(e) {
            const panel = document.getElementById('filterUserPanel');
            if (panel && !panel.classList.contains('hidden')) {
                const btn = document.querySelector('.filter-user');
                if (btn && !btn.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            }
        });

        let searchTimer;
        document.getElementById('searchUser').addEventListener('input', function() {
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
