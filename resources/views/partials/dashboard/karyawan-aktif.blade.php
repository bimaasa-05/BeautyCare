@forelse($karyawanAktif as $k)
<div class="employee-card">
    @if ($k->user->foto ?? null)
    <img src="{{ asset('storage/' . $k->user->foto) }}"
        alt="{{ $k->user->nama ?? 'Karyawan' }}"
        style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
    @else
    <img src="https://ui-avatars.com/api/?name={{ urlencode($k->user->nama ?? 'Karyawan') }}&background=FFE5EF&color=FF4F87&size=36"
        alt="{{ $k->user->nama ?? 'Karyawan' }}">
    @endif
    <div class="ec-info">
        <h4>{{ $k->user->nama ?? 'Karyawan' }}</h4>
        <p>{{ $k->jabatan }}</p>
    </div>
    <span class="ec-status online"></span>
</div>
@empty
<div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;grid-column:1/-1;">Tidak ada karyawan aktif</div>
@endforelse
