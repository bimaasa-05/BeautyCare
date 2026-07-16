@forelse ($users as $user)
<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-800">{{ $user->nama }}</td>
    <td class="py-3.5 px-4 text-gray-500">{{ $user->email }}</td>
    <td class="py-3.5 px-4">
        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded-full text-[11px] font-semibold">{{ Str::limit($user->password, 15) }}</span>
    </td>
    <td class="py-3.5 px-4">
        @if ($user->foto)
            <img src="{{ asset('storage/' . $user->foto) }}" alt="foto"
                class="w-8 h-8 rounded-full object-cover">
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-gray-500">{{ $user->no_hp ?? '-' }}
    </td>
    <td class="py-3.5 px-4">
        @php
            $roleColors = ['admin' => 'bg-purple-50 text-purple-600 border-purple-100', 'kasir' => 'bg-blue-50 text-blue-600 border-blue-100', 'beautycian' => 'bg-pink-50 text-pink-600 border-pink-100', 'pelanggan' => 'bg-teal-50 text-teal-600 border-teal-100'];
            $roleClass = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-600 border-gray-100';
        @endphp
        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
    </td>
    <td class="py-3.5 px-4">
        @if ($user->status === 'aktif')
            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 rounded-full text-[11px] font-semibold">Aktif</span>
        @else
            <span class="px-2.5 py-0.5 bg-red-50 text-red-600 rounded-full text-[11px] font-semibold">Non Aktif</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.user.edit', $user->id) }}"
                class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                    class="fa-regular fa-pen-to-square text-xs"></i>
            </a>
            <form action="{{ route('admin.user.destroy', $user->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus user ini?')"
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
    <td colspan="9" class="py-8 text-center text-gray-400 text-[13px]">Belum ada data user</td>
</tr>
@endforelse
