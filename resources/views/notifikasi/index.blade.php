<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi - BeautyCare</title>
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

        @media (max-width: 768px) {
            .admin-table thead { display: none; }
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
            .admin-table tbody td:first-child { padding-left: 0; }
            .admin-table tbody td:last-child { padding-right: 0; }
        }

        .notif-item-unread {
            background: #FFF5F8;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6">
                <div class="space-y-4">

                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                        <div class="p-5 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="font-bold text-gray-800">Semua Notifikasi</h3>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full admin-table">
                                <thead>
                                    <tr class="bg-[#FFF7FA]">
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">#</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Aktor</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Notifikasi</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Tipe</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notif as $n)
                                    <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors {{ !$n->status ? 'notif-item-unread' : '' }}">
                                        <td class="px-5 py-4 text-sm text-gray-600">{{ $loop->iteration + ($notif->currentPage() - 1) * $notif->perPage() }}</td>
                                        <td class="px-5 py-4" data-label="Aktor">
                                            <div class="flex items-center gap-2.5">
                                                @if ($n->aktor && $n->aktor->foto)
                                                    <img src="{{ asset('storage/' . $n->aktor->foto) }}"
                                                        class="w-8 h-8 rounded-full object-cover">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ $n->aktor ? strtoupper(substr($n->aktor->nama, 0, 1)) : '?' }}
                                                    </div>
                                                @endif
                                                <span class="text-sm font-semibold text-gray-800">{{ $n->aktor?->nama ?? 'Sistem' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4" data-label="Notifikasi">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $n->judul }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $n->isi }}</p>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4" data-label="Tipe">
                                            @php
                                                $typeBadge = match($n->type) {
                                                    'Booking' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    'Promo' => 'bg-purple-50 text-purple-600 border-purple-100',
                                                    'Stok' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'Transaksi' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    default => 'bg-gray-50 text-gray-500 border-gray-100'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $typeBadge }}">
                                                {{ $n->type }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4" data-label="Status">
                                            @if ($n->status)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-gray-50 text-gray-500 border-gray-100">
                                                    <i class="fa-regular fa-circle-check mr-1"></i> Dibaca
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-pink-50 text-pink-600 border-pink-100">
                                                    <i class="fa-regular fa-circle mr-1"></i> Baru
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500" data-label="Waktu">
                                            {{ $n->created_at ? $n->created_at->diffForHumans() : '-' }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                                            <i class="fa-regular fa-bell-slash text-4xl block mb-3"></i>
                                            Belum ada notifikasi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($notif->hasPages())
                        <div class="p-5 border-t border-pink-50">
                            {{ $notif->links() }}
                        </div>
                        @endif
                    </div>

                </div>
            </main>
        </main>
    </div>

    <script>
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
