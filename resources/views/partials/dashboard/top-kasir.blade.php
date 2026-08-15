@forelse($items as $row)
<tr>
    <td data-label="No">{{ $row->rank }}</td>
    <td data-label="Kasir">
        <div class="td-flex">
            <img src="{{ $row->foto_url }}" alt="{{ $row->nama }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid var(--border);">
            <span style="font-weight:600;color:var(--dark);">{{ $row->nama }}</span>
        </div>
    </td>
    <td data-label="Transaksi">
        <div class="td-flex">{{ $row->total_transaksi }}</div>
    </td>
    <td data-label="Nominal">{{ $fmt($row->total_nominal) }}</td>
</tr>
@empty
<tr>
    <td data-label="No" colspan="4" style="text-align:center;color:var(--gray);">Belum ada data transaksi kasir</td>
</tr>
@endforelse