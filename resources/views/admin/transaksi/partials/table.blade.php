@forelse ($transaksi as $t)
<tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors transaksi-row">
    <td class="px-4 py-3.5 text-[10px] font-mono text-gray-400 no-invoice">{{ $t->no_invoice }}</td>
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 text-xs rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '?' }}
            </div>
            <span class="text-xs font-bold text-gray-700 nm_pelanggan">{{ $t->pelanggan->nm_pelanggan ?? 'N/A' }}</span>
        </div>
    </td>
    <td class="px-4 py-3.5 text-xs text-gray-500 max-w-[120px] truncate">
        {{ $t->detail->pluck('nm_item')->implode(', ') ?: '-' }}
    </td>
    <td class="px-4 py-3.5 text-xs font-bold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
    <td class="px-4 py-3.5 text-xs text-gray-500">{{ $t->metode_byr }}</td>
    <td class="px-4 py-3.5 text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
    <td class="px-4 py-3.5">
        @php
        $statusClass = $t->status === 'Lunas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100';
        @endphp
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
            {{ $t->status }}
        </span>
    </td>
    <td class="px-4 py-3.5">
        <div class="flex items-center gap-1.5">
            <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                class="w-6 h-6 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100" title="Detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye">
                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </a>
            <a href="{{ route('admin.transaksi.edit', $t->id_transaksi) }}"
                class="w-6 h-6 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                    <path d="m15 5 4 4"></path>
                </svg>
            </a>
            <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}"
                method="POST" class="inline"
                onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $t->no_invoice }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-6 h-6 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr class="border-t border-pink-50">
    <td colspan="8" class="px-4 py-10 text-center text-gray-400 text-xs">Belum ada transaksi</td>
</tr>
@endforelse
