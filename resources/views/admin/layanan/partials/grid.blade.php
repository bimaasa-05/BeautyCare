@forelse ($layanan as $l)
<div class="bg-white rounded-2xl overflow-hidden border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.06)] hover:shadow-[0_4px_24px_rgba(236,72,153,0.12)] transition-all group">
    <div class="relative overflow-hidden h-40">
        @if ($l->foto)
            <img src="{{ asset('storage/' . $l->foto) }}"
                alt="{{ $l->nm_layanan }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-pink-50 flex items-center justify-center text-pink-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
            </div>
        @endif
        <div class="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
            <a href="{{ route('admin.layanan.edit', $l->id_layanan) }}"
                class="w-7 h-7 bg-white rounded-lg flex items-center justify-center shadow text-amber-500 hover:bg-amber-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>
                </svg>
            </a>
            <form action="{{ route('admin.layanan.destroy', $l->id_layanan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-7 h-7 bg-white rounded-lg flex items-center justify-center shadow text-red-400 hover:bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <div class="p-4">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-bold text-[#EC4899] bg-pink-50 px-2 py-0.5 rounded-full">{{ $kategoriLayanan->firstWhere('id_kategori_layanan', $l->id_kategori)?->nm_layanan ?? 'Kategori #'.$l->id_kategori }}</span>
            <span class="text-[10px] text-gray-400 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg> {{ $l->durasi }} menit
            </span>
        </div>
        <h3 class="font-bold text-gray-800 mb-2">{{ $l->nm_layanan }}</h3>
        <div class="flex items-center justify-between">
            <span class="text-base font-extrabold text-[#EC4899]">Rp {{ number_format($l->harga, 0, ',', '.') }}</span>
            <div class="relative">
                <select onchange="updateStatus(this, {{ $l->id_layanan }})"
                    class="text-[11px] font-semibold pl-3 pr-7 py-1.5 rounded-xl appearance-none cursor-pointer shadow-sm
                    @if ($l->status == 'Tersedia') bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100
                    @else bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 @endif
                    focus:outline-none focus:ring-2 focus:ring-pink-300 transition-all">
                    <option value="Tersedia" {{ $l->status == 'Tersedia' ? 'selected' : '' }} class="text-gray-700 bg-white">Tersedia</option>
                    <option value="Tidak Tersedia" {{ $l->status == 'Tidak Tersedia' ? 'selected' : '' }} class="text-gray-700 bg-white">Tidak Tersedia</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                    <svg class="w-3 h-3 @if ($l->status == 'aktif') text-emerald-500 @else text-rose-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-span-full bg-white p-8 rounded-2xl text-center shadow-sm border border-pink-50">
    <p class="text-gray-500">Belum ada layanan yang ditemukan.</p>
</div>
@endforelse
