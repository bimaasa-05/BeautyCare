<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesanan Online - BeautyCare</title>
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
    </style>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .stat-card-enhanced { padding: 20px; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); }
        .card-gradient-pink { background: linear-gradient(135deg, #FFF5F8, #FFFFFF); border-color: #FFE0E8; }
        .card-gradient-amber { background: linear-gradient(135deg, #FFFBEB, #FFFFFF); border-color: #FDE68A; }
        .card-gradient-blue { background: linear-gradient(135deg, #EFF6FF, #FFFFFF); border-color: #BFDBFE; }

        .badge-status { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge-menunggu { background: #FEF3C7; color: #B45309; }
        .badge-diproses { background: #DBEAFE; color: #1D4ED8; }
        .badge-lunas { background: #D1FAE5; color: #059669; }
        .badge-gagal { background: #FEE2E2; color: #B91C1C; }
        .badge-kadaluarsa { background: #F3F4F6; color: #6B7280; }

        .btn-aksi { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 10px; font-size: 11.5px; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; transition: all 0.2s ease; border: none; text-decoration: none; }
        .btn-aksi:hover { transform: translateY(-1px); }
        .btn-konfirmasi { background: #10B981; color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,0.25); }
        .btn-tolak { background: #fff; color: #DC2626; border: 1.5px solid #FECACA; }
        .btn-detail { background: #F0F4FF; color: #3B5BDB; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    @if (session('message'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-xmark"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6 flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-globe text-pink-500 mr-2"></i>Pesanan Online
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Verifikasi pembayaran pesanan produk dari pelanggan</p>
                        </div>
                        <a href="{{ route('kasir.pembayaran.index') }}"
                            class="inline-flex items-center gap-2 text-[12px] font-semibold text-pink-500 bg-pink-50 hover:bg-pink-100 border border-pink-100 rounded-full px-4 py-2 transition-all">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pembayaran
                        </a>
                    </div>

                    @if($demoMode)
                    <div class="mb-4 p-4 bg-purple-50 border border-purple-200 text-purple-700 text-[13px] rounded-xl flex items-center gap-2">
                        <i class="fa-regular fa-circle-check"></i>
                        <span><b>Mode demo aktif.</b> Gunakan tombol <b>Konfirmasi</b> untuk memverifikasi pembayaran masuk dari pelanggan.</span>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
                        <div class="stat-card-enhanced card-gradient-pink">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu Pembayaran</p>
                                    <p class="text-[24px] font-bold text-gray-800 mt-1">{{ $pesanan->where('status', 'Menunggu Pembayaran')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-blue">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu Verifikasi</p>
                                    <p class="text-[24px] font-bold text-blue-600 mt-1">{{ $pesanan->where('status', 'Sedang Diproses')->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-shield-halved text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-pink">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Pesanan Aktif</p>
                                    <p class="text-[24px] font-bold text-gray-800 mt-1">{{ $pesanan->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-solid fa-cart-shopping text-pink-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto"><table class="w-full text-left border-collapse table-card-mobile">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">No. Invoice</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Metode</th>
                                    <th class="py-3 px-4 text-right">Total</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($pesanan as $index => $p)
                                <tr class="hover:bg-pink-50/40 transition-all">
                                    <td class="py-3 px-4 text-gray-400" data-label="#">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4" data-label="No. Invoice">
                                        <span class="inline-flex items-center gap-1.5 bg-pink-50 text-pink-500 text-[11.5px] font-semibold rounded-lg px-2.5 py-1">
                                            <i class="fa-solid fa-receipt text-[10px]"></i>{{ $p->no_invoice }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4" data-label="Pelanggan">
                                        <div class="font-semibold text-gray-800">{{ $p->user->nama ?? '-' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $p->user->no_hp ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-[12px]" data-label="Tanggal">{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}</td>
                                    <td class="py-3 px-4" data-label="Metode">
                                        @if(($p->pembayaran->metode ?? null) === 'Saldo')
                                        <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 text-[11.5px] font-semibold rounded-lg px-2.5 py-1">
                                            <i class="fa-solid fa-wallet text-[10px]"></i> Saldo Akun
                                        </div>
                                        <div class="text-[11px] text-gray-400 flex items-center gap-1.5 mt-1">
                                            Pakai saldo: Rp {{ number_format($p->saldo_terpakai, 0, ',', '.') }}
                                        </div>
                                        @else
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-wallet text-gray-300 text-[11px]"></i>
                                            {{ $p->pembayaran->provider ?? $p->metode_byr }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 flex items-center gap-1.5">
                                            {{ $p->pembayaran->kode_pembayaran ?? '-' }}
                                            @if($p->bukti_bayar)
                                            <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 font-semibold hover:underline" title="Lihat bukti bayar">
                                                <i class="fa-solid fa-paperclip text-[10px]"></i> Bukti
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right font-bold text-gray-800" data-label="Total">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center" data-label="Status">
                                        @php
                                        $badgeMap = [
                                            'Menunggu Pembayaran' => 'badge-menunggu',
                                            'Sedang Diproses' => 'badge-diproses',
                                        ];
                                        @endphp
                                        <span class="badge-status {{ $badgeMap[$p->status] ?? 'badge-menunggu' }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4" data-label="">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kasir.pembayaran.show', $p->id_transaksi) }}" class="btn-aksi btn-detail">
                                                <i class="fa-solid fa-eye text-[11px]"></i> Detail
                                            </a>
                                            @php $isBooking = (bool) $p->id_booking; @endphp
                                            <form action="{{ route('kasir.pembayaran.verifikasi', $p->id_transaksi) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="aksi" value="konfirmasi">
                                                @if($demoMode)
                                                <button type="submit" class="btn-aksi btn-konfirmasi" data-confirm-title="Konfirmasi Lunas" data-confirm-body="Konfirmasi pembayaran pesanan {{ $p->no_invoice }} sudah diterima dan lunas? Stok akan dikurangi." data-confirm-icon="fa-circle-check" data-confirm-type="success" data-confirm-yes="Ya, Konfirmasi">
                                                    <i class="fa-solid fa-circle-check text-[11px]"></i> Konfirmasi
                                                </button>
                                                @else
                                                <button type="submit" class="btn-aksi btn-konfirmasi" data-confirm-title="{{ $isBooking ? 'Konfirmasi Pembayaran' : 'Konfirmasi Lunas' }}" data-confirm-body="{{ $isBooking ? 'Konfirmasi pembayaran booking '.$p->no_invoice.' sudah diterima?' : 'Konfirmasi pesanan '.$p->no_invoice.' sudah lunas? Stok akan dikurangi.' }}" data-confirm-icon="fa-circle-check" data-confirm-type="success" data-confirm-yes="Ya, Konfirmasi">
                                                    <i class="fa-solid fa-check text-[11px]"></i> {{ $isBooking ? 'Konfirmasi Pembayaran' : 'Konfirmasi Lunas' }}
                                                </button>
                                                @endif
                                            </form>
                                            <form action="{{ route('kasir.pembayaran.verifikasi', $p->id_transaksi) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="aksi" value="tolak">
                                                <button type="submit" class="btn-aksi btn-tolak" data-confirm-title="Tolak Pembayaran" data-confirm-body="Tolak pembayaran {{ $isBooking ? 'booking ' : 'pesanan ' }}{{ $p->no_invoice }}? Saldo akun (jika dipakai) akan dikembalikan." data-confirm-icon="fa-circle-xmark" data-confirm-type="danger" data-confirm-yes="Ya, Tolak">
                                                    <i class="fa-solid fa-xmark text-[11px]"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="py-16 text-center">
                                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-pink-50 to-pink-100 rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-globe text-pink-300 text-3xl"></i>
                                        </div>
                                        <p class="font-semibold text-gray-700 text-[14px]">Tidak Ada Pesanan Online</p>
                                        <p class="text-[12px] text-gray-400 mt-1">Pesanan dari pelanggan akan muncul di sini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table></div>
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
    @include('partials.confirm-modal')
</body>

</html>
