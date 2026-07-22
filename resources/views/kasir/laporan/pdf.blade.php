<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kasir - BeautyCare</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #BE185D; margin-bottom: 5px; font-size: 20px; }
        .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 5px; }
        .periode { text-align: center; font-size: 11px; color: #888; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #EC4899; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 6px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        tr:nth-child(even) { background: #fdf2f8; }
        .ringkasan { margin-bottom: 30px; }
        .ringkasan table { width: auto; margin: 0 auto; }
        .ringkasan td { padding: 8px 20px; border: 1px solid #ddd; }
        .ringkasan td:first-child { font-weight: bold; background: #fce7f3; }
        .section-title { font-size: 14px; font-weight: bold; color: #BE185D; margin: 25px 0 10px; border-bottom: 2px solid #EC4899; padding-bottom: 5px; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
        .status-lunas { color: #22C55E; font-weight: bold; }
        .status-pending { color: #F59E0B; font-weight: bold; }
        .status-batal { color: #EF4444; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Pendapatan Kasir</h1>
    <div class="subtitle">{{ $userName }}</div>
    <div class="periode">Periode: {{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</div>

    <div class="ringkasan">
        <table>
            <tr><td>Total Pendapatan</td><td>{{ $fmt($totalPendapatan) }}</td></tr>
            <tr><td>Total Transaksi</td><td>{{ number_format($totalTransaksi, 0, ',', '.') }}</td></tr>
            <tr><td>Rata-rata per Transaksi</td><td>{{ $fmt($rataTransaksi) }}</td></tr>
        </table>
    </div>

    <div class="section-title">Daftar Transaksi</div>
    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $t)
                <tr>
                    <td>{{ $t->no_invoice }}</td>
                    <td>{{ $t->pelanggan->nm_pelanggan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>{{ $t->metode_byr }}</td>
                    <td class="status-{{ strtolower($t->status) }}">{{ $t->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:20px;color:#999;">Tidak ada transaksi pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>
