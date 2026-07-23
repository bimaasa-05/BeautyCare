<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggan - BeautyCare</title>
    @include('partials.head-meta')
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #BE185D; margin-bottom: 5px; font-size: 20px; }
        .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 5px; }
        .periode { text-align: center; font-size: 11px; color: #888; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #EC4899; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 6px 10px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #fdf2f8; }
        .ringkasan { margin-bottom: 30px; }
        .ringkasan table { width: auto; margin: 0 auto; }
        .ringkasan td { padding: 8px 20px; border: 1px solid #ddd; }
        .ringkasan td:first-child { font-weight: bold; background: #fce7f3; }
        .section-title { font-size: 14px; font-weight: bold; color: #BE185D; margin: 25px 0 10px; border-bottom: 2px solid #EC4899; padding-bottom: 5px; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>Laporan Pelanggan</h1>
    <div class="subtitle">{{ $userName }}</div>
    <div class="periode">Periode: {{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</div>

    <div class="ringkasan">
        <table>
            <tr><td>Total Pelanggan</td><td>{{ number_format($totalPelanggan, 0, ',', '.') }}</td></tr>
            <tr><td>Pelanggan Baru</td><td>{{ number_format($pelangganBaru, 0, ',', '.') }}</td></tr>
            <tr><td>Pelanggan Member</td><td>{{ number_format($pelangganMember, 0, ',', '.') }}</td></tr>
            <tr><td>Transaksi Pelanggan</td><td>{{ number_format($transaksiPelanggan, 0, ',', '.') }}</td></tr>
        </table>
    </div>

    <div class="section-title">Daftar Pelanggan</div>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Email</th>
                <th>Member</th>
                <th>Transaksi</th>
                <th>Total Belanja</th>
                <th>Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggan as $p)
                <tr>
                    <td>{{ $p->nm_pelanggan }}</td>
                    <td>{{ $p->no_hp ?? '-' }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->membership->nm_member ?? '-' }}</td>
                    <td>{{ $p->total_transaksi ?? 0 }}</td>
                    <td>{{ $fmt($p->total_belanja ?? 0) }}</td>
                    <td>{{ $p->tgl_terakhir ? \Carbon\Carbon::parse($p->tgl_terakhir)->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:20px;color:#999;">Tidak ada pelanggan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>
