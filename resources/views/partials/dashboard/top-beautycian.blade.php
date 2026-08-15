@forelse($items as $row)
<tr>
    <td data-label="No">{{ $row->rank }}</td>
    <td data-label="Beautycian">
        <div class="td-flex">
            <img src="{{ $row->foto_url }}" alt="{{ $row->nama }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid var(--border);">
            <span style="font-weight:600;color:var(--dark);">{{ $row->nama }}</span>
        </div>
    </td>
    <td data-label="Pelanggan">
        <div class="td-flex">{{ $row->total_pelanggan }}</div>
    </td>
    <td data-label="Selesai">{{ $row->total_selesai }}</td>
</tr>
@empty
<tr>
    <td data-label="No" colspan="4" style="text-align:center;color:var(--gray);">Belum ada data treatment beautycian</td>
</tr>
@endforelse