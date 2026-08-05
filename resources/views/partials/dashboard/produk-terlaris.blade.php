@forelse($items as $pt)
<tr>
    <td data-label="Produk">
        <div class="td-flex">{{ $pt->nm_item }}</div>
    </td>
    <td data-label="Terjual">{{ $pt->total_qty }}</td>
    <td data-label="Pendapatan">{{ $fmt($pt->total_subtotal) }}</td>
</tr>
@empty
<tr>
    <td data-label="Produk" colspan="3" style="text-align:center;color:var(--gray);">Belum ada data transaksi</td>
</tr>
@endforelse
