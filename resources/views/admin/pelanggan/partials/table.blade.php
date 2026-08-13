@forelse ($pelanggan as $p)
<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3.5 px-4 font-medium text-gray-500">{{ $loop->iteration }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Nama Lengkap">{{ $p->nm_pelanggan ?? $p->nama }}
    </td>
    <td class="py-3.5 px-4 text-gray-500 font-medium" data-label="Sumber">
        @if ($p->sumber === 'Online')
            <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full text-[11px] font-semibold">Online</span>
        @else
            <span class="text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full text-[11px] font-semibold whitespace-nowrap">Walk-in</span>
        @endif
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Saldo Akun">
        <span class="text-emerald-600 font-semibold">Rp {{ number_format($p->saldo ?? 0, 0, ',', '.') }}</span>
    </td>
    <td class="py-3.5 px-4 text-gray-500 font-medium" data-label="Nomor Hp">{{ $p->no_hp ?? '-' }}
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Email">{{ $p->email }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Alamat">{{ $p->alamat ?? '-' }}</td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Member">
        @php
            $memberInfo = $p->id_member ? ($memberships[$p->id_member] ?? null) : null;
        @endphp
        @if ($memberInfo)
            <div class="flex flex-col gap-0.5">
                <span class="font-semibold text-gray-700">{{ $memberInfo->nm_member }}</span>
                @if ($memberInfo->masa_berlaku > 0 && $p->tgl_mulai_member)
                    @php
                        $tglAkhir = $memberInfo->tanggalBerakhir($p->tgl_mulai_member);
                        $sisa = $memberInfo->sisaHari($p->tgl_mulai_member);
                        $expired = $memberInfo->sudahKadaluarsa($p->tgl_mulai_member);
                    @endphp
                    <span class="text-[10px] {{ $expired ? 'text-red-500' : 'text-emerald-500' }}">
                        @if ($expired)
                            Expired
                        @else
                            Sisa {{ $sisa }} hari
                        @endif
                        &middot; s.d. {{ $tglAkhir->format('d/m/Y') }}
                    </span>
                @endif
            </div>
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>
    <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Catatan Alergi">{{ $p->catatan_alergi ?? '-' }}
    </td>
    <td class="py-3.5 px-4" data-label="Foto">
        <img src="{{ $p->foto_url }}" alt="foto"
            class="w-8 h-8 rounded-full object-cover">
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
                data-confirm-title="Hapus Pelanggan" data-confirm-body="Apakah Anda yakin ingin menghapus pelanggan ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus"
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
    <td colspan="10" class="py-8 text-center text-gray-400 text-[13px]">Belum ada data pelanggan</td>
</tr>
@endforelse
