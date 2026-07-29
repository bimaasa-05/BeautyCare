@forelse ($users as $user)
<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-800" data-label="Nama Lengkap">{{ $user->nama }}</td>
    <td class="py-3.5 px-4 text-gray-500" data-label="Email">{{ $user->email }}</td>
    <td class="py-3.5 px-4" data-label="Password">
        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded-full text-[11px] font-semibold">{{ Str::limit($user->password, 15) }}</span>
    </td>
    <td class="py-3.5 px-4" data-label="Foto">
        @if ($user->foto)
            <img src="{{ asset('storage/' . $user->foto) }}" alt="foto"
                class="w-8 h-8 rounded-full object-cover">
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 text-gray-500" data-label="Nomor Hp">{{ $user->no_hp ?? '-' }}
    </td>
    <td class="py-3.5 px-4" data-label="Role">
        @php
            $roleColors = ['admin' => 'bg-purple-50 text-purple-600 border-purple-100', 'kasir' => 'bg-blue-50 text-blue-600 border-blue-100', 'beautycian' => 'bg-pink-50 text-pink-600 border-pink-100', 'pelanggan' => 'bg-teal-50 text-teal-600 border-teal-100'];
            $roleClass = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-600 border-gray-100';
        @endphp
        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
    </td>
    <td class="py-3.5 px-4" data-label="Status">
        <div class="flex flex-col gap-1">
            <form action="{{ route('admin.user.update-status', $user->id) }}" method="POST" class="inline-flex items-center gap-1">
                @csrf
                <select name="status" onchange="this.form.submit()"
                    class="text-[11px] font-semibold px-2 py-1 rounded-full border-0 cursor-pointer appearance-none
                    @if ($user->status === 'aktif') bg-emerald-50 text-emerald-600
                    @elseif ($user->status === 'suspend') bg-amber-50 text-amber-600
                    @else bg-red-50 text-red-600 @endif">
                    <option value="aktif" {{ $user->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspend" {{ $user->status === 'suspend' ? 'selected' : '' }}>Suspend</option>
                    <option value="non_aktif" {{ $user->status === 'non_aktif' ? 'selected' : '' }}>Non Aktif</option>
                </select>
            </form>
            @if ($user->status === 'suspend' && $user->suspend_until)
                <span class="text-[10px] text-amber-500">s/d {{ \Carbon\Carbon::parse($user->suspend_until)->format('d/m/Y H:i') }}</span>
            @endif
        </div>
    </td>
    <td class="py-3.5 px-4 text-center" data-label="Aksi">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('admin.user.edit', $user->id) }}"
                class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                    class="fa-solid fa-pen-to-square text-xs"></i>
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
