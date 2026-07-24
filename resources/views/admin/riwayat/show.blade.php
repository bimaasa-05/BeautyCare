<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Riwayat - BeautyCare</title>
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
        body { font-family: 'Poppins', sans-serif; }
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
        .detail-card { border-radius: 16px; border: 1px solid #f1f1f1; overflow: hidden; }
        .detail-label { font-size: 11px; font-weight: 600; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .detail-value { font-size: 14px; font-weight: 500; color: #1F2937; }
        .json-view { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; font-family: 'Courier New', monospace; font-size: 12px; line-height: 1.6; white-space: pre-wrap; word-break: break-all; max-height: 400px; overflow-y: auto; }
        .role-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .role-admin { background: #FEE2E2; color: #DC2626; }
        .role-kasir { background: #DBEAFE; color: #2563EB; }
        .role-beautycian { background: #D1FAE5; color: #059669; }
        .role-pelanggan { background: #FEF3C7; color: #D97706; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-4xl mx-auto">
                    <a href="{{ route('admin.riwayat.index') }}" class="inline-flex items-center gap-2 text-pink-500 hover:text-pink-600 text-[13px] font-medium mb-4 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
                    </a>

                    <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)]">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-12 h-12 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-[18px] font-bold text-gray-800">Detail Riwayat Aktivitas</h3>
                                <p class="text-[12px] text-gray-400">#{{ $riwayat->id }} · {{ \Carbon\Carbon::parse($riwayat->created_at)->format('d F Y H:i:s') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="detail-card p-4">
                                <div class="detail-label">User</div>
                                <div class="detail-value flex items-center gap-2 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-xs">
                                        {{ $riwayat->user ? strtoupper(substr($riwayat->user->nama, 0, 2)) : '??' }}
                                    </div>
                                    {{ $riwayat->user->nama ?? 'System' }}
                                </div>
                            </div>

                            <div class="detail-card p-4">
                                <div class="detail-label">Role</div>
                                <div class="mt-1">
                                    @php
                                        $roleClass = match($riwayat->role) {
                                            'admin' => 'role-admin',
                                            'kasir' => 'role-kasir',
                                            'beautycian' => 'role-beautycian',
                                            'pelanggan' => 'role-pelanggan',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">
                                        <i class="fa-solid fa-circle text-[6px]"></i> {{ ucfirst($riwayat->role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-card p-4">
                                <div class="detail-label">Aksi</div>
                                <div class="detail-value mt-1">{{ $riwayat->aksi }}</div>
                            </div>

                            <div class="detail-card p-4">
                                <div class="detail-label">Tipe</div>
                                <div class="detail-value mt-1">{{ $riwayat->tipe ?? '-' }}</div>
                            </div>

                            @if ($riwayat->id_tipe)
                            <div class="detail-card p-4">
                                <div class="detail-label">ID Terkait</div>
                                <div class="detail-value mt-1">{{ $riwayat->tipe }} #{{ $riwayat->id_tipe }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="detail-card p-4 mb-6">
                            <div class="detail-label">Deskripsi</div>
                            <div class="detail-value mt-1 text-gray-600">{{ $riwayat->deskripsi }}</div>
                        </div>

                        @if ($riwayat->data_lama || $riwayat->data_baru)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if ($riwayat->data_lama)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-circle-exclamation text-red-400 text-xs"></i>
                                    <span class="text-[12px] font-bold text-red-500 uppercase tracking-wider">Data Lama</span>
                                </div>
                                <div class="json-view">{{ json_encode(json_decode($riwayat->data_lama), JSON_PRETTY_PRINT) }}</div>
                            </div>
                            @endif

                            @if ($riwayat->data_baru)
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fa-solid fa-circle-check text-emerald-400 text-xs"></i>
                                    <span class="text-[12px] font-bold text-emerald-500 uppercase tracking-wider">Data Baru</span>
                                </div>
                                <div class="json-view">{{ json_encode(json_decode($riwayat->data_baru), JSON_PRETTY_PRINT) }}</div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
