<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi Beautician - BeautyCare</title>
    @include('partials.head-meta')
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #8B5CF6; margin-bottom: 5px; font-size: 20px; }
        .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 5px; }
        .periode { text-align: center; font-size: 11px; color: #888; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #8B5CF6; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 6px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        tr:nth-child(even) { background: #F5F3FF; }
        .ringkasan { margin-bottom: 30px; }
        .ringkasan table { width: auto; margin: 0 auto; }
        .ringkasan td { padding: 8px 20px; border: 1px solid #ddd; }
        .ringkasan td:first-child { font-weight: bold; background: #EDE9FE; }
        .section-title { font-size: 14px; font-weight: bold; color: #8B5CF6; margin: 25px 0 10px; border-bottom: 2px solid #8B5CF6; padding-bottom: 5px; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
        .status-selesai { color: #22C55E; font-weight: bold; }
        .status-dikonfirmasi { color: #3B82F6; font-weight: bold; }
        .status-diproses { color: #F59E0B; font-weight: bold; }
        .status-dibatalkan { color: #EF4444; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Reservasi Beautician</h1>
    <div class="subtitle">{{ $userName }}</div>
    <div class="periode">Periode: {{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</div>

    <div class="ringkasan">
        <table>
            <tr><td>Total Reservasi</td><td>{{ number_format($totalReservasi, 0, ',', '.') }}</td></tr>
            <tr><td>Selesai</td><td>{{ number_format($selesai, 0, ',', '.') }}</td></tr>
            <tr><td>Total Pendapatan</td><td>{{ $fmt($totalPendapatan) }}</td></tr>
            <tr><td>Rata-rata per Transaksi</td><td>{{ $fmt($rataTransaksi) }}</td></tr>
        </table>
    </div>

    <div class="section-title">Daftar Reservasi</div>
    <table>
        <thead>
            <tr>
                <th>ID Booking</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $r)
                <tr>
                    <td>#{{ $r->id_booking }}</td>
                    <td>{{ $r->pelanggan->nm_pelanggan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->jam)->format('H:i') }}</td>
                    <td>{{ $r->detail->pluck('layanan.nm_layanan')->implode(', ') }}</td>
                    <td class="status-{{ strtolower($r->status) }}">{{ ucfirst($r->status) }}</td>
                    <td>Rp {{ number_format($r->detail->sum('subtotal'), 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:20px;color:#999;">Tidak ada reservasi pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>