@forelse($items as $row)
<tr>
    <td data-label="No">{{ $loop->iteration }}</td>
    <td data-label="Nama Pelanggan">
        <div class="td-flex">{{ $row->nm_pelanggan }}</div>
    </td>
    <td data-label="Produk">
        <div class="td-flex">{{ $row->favorit }}</div>
    </td>
    <td data-label="Nominal">{{ $fmt($row->nominal) }}</td>
</tr>
@empty
<tr>
    <td data-label="No" colspan="4" style="text-align:center;color:var(--gray);">Belum ada data transaksi produk</td>
</tr>
@endforelse
