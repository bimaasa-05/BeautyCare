@forelse($items as $lt)
<tr>
    <td data-label="Layanan">
        <div class="td-flex">{{ $lt->nm_item }}</div>
    </td>
    <td data-label="Terjual">{{ $lt->total_qty }}</td>
    <td data-label="Pendapatan">{{ $fmt($lt->total_subtotal) }}</td>
</tr>
@empty
<tr>
    <td data-label="Layanan" colspan="3" style="text-align:center;color:var(--gray);">Belum ada data transaksi</td>
</tr>
@endforelse
