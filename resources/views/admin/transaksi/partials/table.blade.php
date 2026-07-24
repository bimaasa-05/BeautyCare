@forelse ($transaksi as $t)
<tr class="table-row-hover">
    <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4">
        <span class="font-mono font-semibold text-gray-700 text-[12px]">{{ $t->no_invoice }}</span>
    </td>
    <td class="py-3.5 px-4">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
            </div>
            <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
        </div>
    </td>
    <td class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
    <td class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
    <td class="py-3.5 px-4">
        @php
            $metodeIcon = match($t->metode_byr) {
                'Tunai' => 'fa-solid fa-money-bill-wave text-emerald-500',
                'Transfer' => 'fa-solid fa-building-columns text-purple-500',
                'Debit' => 'fa-regular fa-credit-card text-amber-500',
                'E-Wallet' => 'fa-solid fa-wallet text-pink-500',
                default => 'fa-regular fa-circle text-gray-400',
            };
        @endphp
        <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-gray-600">
            <i class="{{ $metodeIcon }}"></i> {{ $t->metode_byr }}
        </span>
    </td>
    <td class="py-3.5 px-4">
        @php
            $roleBadge = match($t->user->role ?? '') {
                'admin' => 'bg-purple-50 text-purple-600',
                'kasir' => 'bg-amber-50 text-amber-600',
                default => 'bg-gray-50 text-gray-500',
            };
            $roleIcon = match($t->user->role ?? '') {
                'admin' => 'fa-solid fa-shield-halved',
                'kasir' => 'fa-solid fa-user-tie',
                default => 'fa-regular fa-user',
            };
        @endphp
        <div class="flex items-center gap-1.5">
            <span class="text-gray-500 text-[12px]">{{ $t->user->nama ?? '-' }}</span>
            @if ($t->user && in_array($t->user->role, ['admin', 'kasir']))
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-semibold {{ $roleBadge }}">
                    <i class="{{ $roleIcon }}"></i> {{ ucfirst($t->user->role) }}
                </span>
            @endif
        </div>
    </td>
    <td class="py-3.5 px-4">
        @if ($t->status == 'Lunas')
            <span class="badge-status status-selesai"><i class="fa-regular fa-circle-check"></i> Lunas</span>
        @elseif ($t->status == 'Pending')
            <span class="badge-status status-proses"><i class="fa-regular fa-clock"></i> Pending</span>
        @else
            <span class="badge-status status-batal"><i class="fa-regular fa-circle-xmark"></i> Batal</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
            <a href="{{ route('admin.transaksi.edit', $t->id_transaksi) }}"
                class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"
                title="Edit"><i class="fa-regular fa-pen-to-square text-xs"></i></a>
            <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}"
                method="POST" class="inline"
                onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $t->no_invoice }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors flex items-center justify-center"
                    title="Hapus"><i class="fa-regular fa-trash-can text-xs"></i></button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="py-14 text-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                <i class="fa-solid fa-receipt text-3xl text-pink-200"></i>
            </div>
            <p class="text-gray-400 font-medium text-[14px]">Belum ada data transaksi</p>
        </div>
    </td>
</tr>
@endforelse