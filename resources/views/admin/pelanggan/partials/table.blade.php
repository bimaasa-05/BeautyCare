@forelse ($pelanggan as $p)
<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->nm_pelanggan }}
    </td>
    <td class="py-3.5 px-4 text-gray-500 font-medium">{{ $p->no_hp ?? '-' }}
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->email }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->alamat }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500">
        {{ $p->id_member ?? '-' }}
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $p->catatan_alergi }}
    </td>
    <td class="py-3.5 px-4">
        @if ($p->foto)
            <img src="{{ asset('storage/' . $p->foto) }}" alt="foto"
                class="w-8 h-8 rounded-full object-cover">
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.pelanggan.edit', $p->id_pelanggan) }}"
                class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                    class="fa-regular fa-pen-to-square text-xs"></i>
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
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="py-8 text-center text-gray-400 text-[13px]">Belum ada data pelanggan</td>
</tr>
@endforelse
