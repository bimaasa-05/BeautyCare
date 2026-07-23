@forelse ($beautician as $b)
<div class="bg-white rounded-3xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-pink-50/50">
    <div class="flex justify-between items-start mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-[#f472b6]">
                @if ($b->user?->foto)
                    <img src="{{ asset('storage/' . $b->user->foto) }}" alt="foto"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($b->user?->nama ?? '??', 0, 2)) }}</div>
                @endif
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px]">
                    {{ $b->user?->nama ?? 'User tidak ditemukan' }}</h3>
                <p class="text-[12px] text-gray-400 mt-0.5">{{ $b->user?->role ?? '-' }}</p>
            </div>
        </div>
        @if ($b->status == 'Tersedia')
            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-500 font-semibold text-[11px] rounded-lg border border-emerald-100">Tersedia</span>
        @elseif ($b->status == 'Sibuk')
            <span class="px-2.5 py-1 bg-orange-50 text-orange-500 font-semibold text-[11px] rounded-lg border border-orange-100">Sibuk</span>
        @else
            <span class="px-2.5 py-1 bg-gray-100 text-gray-500 font-semibold text-[11px] rounded-lg border border-gray-200">Libur</span>
        @endif
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->jabatan }}</span>
            <span class="text-[10px] text-gray-400 font-medium">Karyawan/Kerjaan</span>
        </div>
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->tgl_lahir }}</span>
            <span class="text-[10px] text-gray-400 font-medium">Tanggal Lahir</span>
        </div>
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">Rp. {{ number_format($b->gaji, 0, ',', '.') }}-,</span>
            <span class="text-[10px] text-gray-400 font-medium">Gaji</span>
        </div>
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->alamat }}</span>
            <span class="text-[10px] text-gray-400 font-medium">Alamat</span>
        </div>
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->tgl_masuk }}</span>
            <span class="text-[10px] text-gray-400 font-medium">Tanggal Masuk</span>
        </div>
        <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
            <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->komisi }}%</span>
            <span class="text-[10px] text-gray-400 font-medium">Komisi</span>
        </div>
    </div>

    <div class="flex items-center text-[12px] text-gray-400 font-medium mb-5">
        <i class="fa-regular fa-clock mr-2 text-gray-300"></i> -
    </div>

    <div class="flex gap-2.5">
        <a href="{{ route('admin.reservasi.index', ['id_karyawan' => $b->id_user]) }}"
            class="flex-1 bg-[#fdf2f8] text-[#de3b7c] font-bold text-[13px] py-2.5 rounded-2xl hover:bg-pink-100 transition-colors text-center inline-flex items-center justify-center">Jadwal</a>
        <a href="{{ route('admin.beautician.edit', $b->id_karyawan) }}"
            class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-100 hover:bg-amber-100 rounded-2xl transition-colors"><i
                class="fa-regular fa-pen-to-square text-[13px]"></i></a>
        <form action="{{ route('admin.beautician.destroy', $b->id_karyawan) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus beautician ini?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-10 h-10 flex items-center justify-center text-red-500 bg-red-50 border border-red-100 hover:bg-red-100 rounded-2xl transition-colors"><i
                    class="fa-regular fa-trash-can text-[13px]"></i></button>
        </form>
    </div>
</div>
@empty
<div class="col-span-3 flex items-center justify-center py-16">
    <div class="text-center">
        <i class="fa-regular fa-face-frown text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-400 text-[13px] font-medium">Belum ada data beautician</p>
    </div>
</div>
@endforelse
