@forelse ($pelanggan as $p)
<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Nama Lengkap">{{ $p->nm_pelanggan ?? $p->nama }}
    </td>
    <td class="py-3.5 px-4 text-gray-500 font-medium" data-label="Sumber">
        @if ($p->sumber === 'Online')
            <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full text-[11px] font-semibold">Online</span>
        @else
            <span class="text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full text-[11px] font-semibold">Walk-in</span>
        @endif
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Status">
        @if ($p->user_id)
            <div class="flex flex-col gap-1">
                <form action="{{ route('admin.pelanggan.toggle-status', $p->user_id) }}" method="POST" class="inline">
                    @csrf
                    @php
                        $statusColor = match($p->status ?? 'suspend') {
                            'aktif' => 'bg-green-50 text-green-600 hover:bg-green-100',
                            'non_aktif' => 'bg-red-50 text-red-500 hover:bg-red-100',
                            default => 'bg-amber-50 text-amber-600 hover:bg-amber-100',
                        };
                    @endphp
                    <button type="submit"
                        class="text-[11px] font-semibold px-2.5 py-1 rounded-full transition-colors cursor-pointer {{ $statusColor }}">
                        {{ $p->status ?? 'suspend' }}
                    </button>
                </form>
                @if (($p->status ?? 'suspend') === 'suspend' && $p->suspend_until)
                    <span class="text-[10px] text-amber-500">s/d {{ \Carbon\Carbon::parse($p->suspend_until)->format('d/m/Y H:i') }}</span>
                @endif
            </div>
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-gray-500 font-medium" data-label="Nomor Hp">{{ $p->no_hp ?? '-' }}
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Email">{{ $p->email }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Alamat">{{ $p->alamat ?? '-' }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Member ID">
        {{ $p->id_member ?? '-' }}
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Catatan Alergi">{{ $p->catatan_alergi ?? '-' }}
    </td>
    <td class="py-3.5 px-4" data-label="Foto">
        @if ($p->foto)
            <img src="{{ asset('storage/' . $p->foto) }}" alt="foto"
                class="w-8 h-8 rounded-full object-cover">
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-center" data-label="Aksi">
        <div class="flex items-center justify-center gap-2">
            @if ($p->sumber === 'Walk-in')
            <a href="{{ route('admin.pelanggan.edit', $p->id_pelanggan) }}"
                class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                    class="fa-solid fa-pen-to-square text-xs"></i>
            </a>
            <form
                action="{{ route('admin.pelanggan.destroy', $p->id_pelanggan) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')"
                class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors"><i
                        class="fa-regular fa-trash-can text-xs"></i>
                </button>
            </form>
            @else
            <span class="text-gray-400 text-[11px]">Akun Online</span>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="11" class="py-8 text-center text-gray-400 text-[13px]">Belum ada data pelanggan</td>
</tr>
@endforelse
