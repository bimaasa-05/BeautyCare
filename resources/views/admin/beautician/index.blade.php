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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <main class="flex-1 flex flex-col overflow-hidden relative">
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
                        <p class="text-[13px] font-medium text-gray-400">{{ $beautician->count() }} beautician terdaftar
                        </p>

                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <i
                                    class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                <input type="text" id="searchBeautician" placeholder="Cari beautician..."
                                    class="bg-white border border-gray-200 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[200px] lg:w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400 shadow-sm">
                            </div>
                            <div class="relative filter-beautician">
                                <button onclick="toggleFilterBeautician()"
                                    class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-sliders text-gray-400"></i> Filter
                                </button>
                                <div id="filterBeauticianPanel"
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 p-4 z-50">
                                    <p class="text-[11px] font-semibold text-gray-500 mb-2 uppercase tracking-wider">Status</p>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                            <input type="radio" name="filter_status" value="" checked
                                                onchange="applyFilterBeautician()">
                                            Semua
                                        </label>
                                        <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                            <input type="radio" name="filter_status" value="1"
                                                onchange="applyFilterBeautician()">
                                            Tersedia
                                        </label>
                                        <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                            <input type="radio" name="filter_status" value="2"
                                                onchange="applyFilterBeautician()">
                                            Sibuk
                                        </label>
                                        <label class="flex items-center gap-2 text-[12px] text-gray-700 cursor-pointer">
                                            <input type="radio" name="filter_status" value="0"
                                                onchange="applyFilterBeautician()">
                                            Libur
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.beautician.create') }}"
                                class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </a>
                        </div>
                    </div>

                    <div id="beauticianGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @include('admin.beautician.partials.grid')
                    </div>

                </div>
            </main>
        </main>
    </div>

    <script>
        function getFilterParamsBeautician() {
            const params = new URLSearchParams();
            const q = document.getElementById('searchBeautician').value.trim();
            if (q) params.set('search', q);
            const status = document.querySelector('input[name="filter_status"]:checked');
            if (status && status.value) params.set('filter_status', status.value);
            return params.toString();
        }

        function fetchBeautician() {
            fetch('{{ route('admin.beautician.index') }}?' + getFilterParamsBeautician(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('beauticianGrid').innerHTML = html;
            })
            .catch(() => location.reload());
        }

        function toggleFilterBeautician() {
            document.getElementById('filterBeauticianPanel').classList.toggle('hidden');
        }

        function applyFilterBeautician() {
            document.getElementById('filterBeauticianPanel').classList.add('hidden');
            fetchBeautician();
        }

        document.addEventListener('click', function(e) {
            const panel = document.getElementById('filterBeauticianPanel');
            if (panel && !panel.classList.contains('hidden')) {
                const btn = document.querySelector('.filter-beautician');
                if (btn && !btn.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            }
        });

        let searchTimer;
        document.getElementById('searchBeautician').addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(fetchBeautician, 400);
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