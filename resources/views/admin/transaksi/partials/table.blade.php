@forelse ($transaksi as $t)
<tr class="table-row-hover">
    <td data-label="#" class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
    <td data-label="Invoice" class="py-3.5 px-4">
        <span class="font-mono font-semibold text-gray-700 text-[12px]">{{ $t->no_invoice }}</span>
    </td>
    <td data-label="Jenis" class="py-3.5 px-4">
        @if ($t->jenis_transaksi === 'Pembelian')
            <span class="badge-status" style="background:#FEF3C7;color:#F59E0B;">
                <i class="fa-solid fa-arrow-trend-down"></i> Transaksi Keluar
            </span>
        @else
            <span class="badge-status" style="background:#E8F8EE;color:#22C55E;">
                <i class="fa-solid fa-arrow-trend-up"></i> Penjualan
            </span>
        @endif
    </td>
    <td data-label="Mitra" class="py-3.5 px-4">
        @if ($t->jenis_transaksi === 'Pembelian')
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-amber-200 text-amber-700 flex items-center justify-center font-bold text-[10px]">
                    {{ $t->supplier ? strtoupper(substr($t->supplier->nm_supplier, 0, 2)) : '??' }}
                </div>
                <span class="font-medium text-gray-700">{{ $t->supplier->nm_supplier ?? '-' }}</span>
            </div>
        @else
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                    {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                </div>
                <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
            </div>
        @endif
    </td>
    <td data-label="Tanggal" class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
    <td data-label="Total" class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
    <td data-label="Metode" class="py-3.5 px-4">
        @php
            $metodeIcon = match($t->metode_byr) {
                'Tunai' => 'fa-solid fa-money-bill-wave text-emerald-500',
                'Transfer' => 'fa-solid fa-building-columns text-purple-500',
                'Debit' => 'fa-solid fa-credit-card text-amber-500',
                'E-Wallet' => 'fa-solid fa-wallet text-pink-500',
                default => 'fa-regular fa-circle text-gray-400',
            };
        @endphp
        <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-gray-600">
            <i class="{{ $metodeIcon }}"></i> {{ $t->metode_byr }}
        </span>
    </td>
    <td data-label="Admin" class="py-3.5 px-4">
        @php
            $petugas = $t->kasir ?? $t->user;
            $roleBadge = match($petugas->role ?? '') {
                'admin' => 'bg-purple-50 text-purple-600',
                'kasir' => 'bg-amber-50 text-amber-600',
                default => 'bg-gray-50 text-gray-500',
            };
            $roleIcon = match($petugas->role ?? '') {
                'admin' => 'fa-solid fa-shield-halved',
                'kasir' => 'fa-solid fa-user-tie',
                default => 'fa-solid fa-user',
            };
        @endphp
        <div class="flex items-center gap-1.5">
            <span class="text-gray-500 text-[12px]">{{ $petugas->nama ?? '-' }}</span>
            @if ($petugas && in_array($petugas->role, ['admin', 'kasir']))
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-semibold {{ $roleBadge }}">
                    <i class="{{ $roleIcon }}"></i> {{ ucfirst($t->user->role) }}
                </span>
            @endif
        </div>
    </td>
    <td data-label="Status" class="py-3.5 px-4">
        @php
            $mapStatus = [
                'Lunas' => ['class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check', 'label' => 'Lunas'],
                'Pending' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => 'Pending'],
                'Menunggu Pembayaran' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => 'Menunggu Pembayaran'],
                'Sedang Diproses' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-hourglass-half', 'label' => 'Sedang Diproses'],
                'Batal' => ['class' => 'status-batal', 'icon' => 'fa-regular fa-circle-xmark', 'label' => 'Batal'],
                'Gagal' => ['class' => 'status-batal', 'icon' => 'fa-solid fa-xmark', 'label' => 'Gagal'],
                'Dibatalkan' => ['class' => 'status-batal', 'icon' => 'fa-solid fa-ban', 'label' => 'Dibatalkan'],
                'Kadaluarsa' => ['class' => 'status-batal', 'icon' => 'fa-regular fa-hourglass-end', 'label' => 'Kadaluarsa'],
            ];
            $s = $mapStatus[$t->status] ?? ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => $t->status];
        @endphp
        <span class="badge-status {{ $s['class'] }}"><i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}</span>
    </td>
    <td data-label="Aksi" class="py-3.5 px-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" class="py-14 text-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                <i class="fa-solid fa-receipt text-3xl text-pink-200"></i>
            </div>
            <p class="text-gray-400 font-medium text-[14px]">Belum ada data transaksi</p>
        </div>
    </td>
</tr>
@endforelse
