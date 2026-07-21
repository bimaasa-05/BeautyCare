<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - BeautyCare</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #BE185D; margin-bottom: 5px; font-size: 20px; }
        .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 20px; }
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
    </style>
</head>
<body>
    <h1>Laporan BeautyCare</h1>
    <div class="subtitle">Ringkasan Pendapatan, Reservasi &amp; Pelanggan</div>
    <div class="periode">Periode: {{ date('d M Y', strtotime($startDate)) }} – {{ date('d M Y', strtotime($endDate)) }}</div>

    <div class="ringkasan">
        <table>
            <tr><td>Total Pendapatan</td><td>{{ $fmt($totalPendapatan) }}</td></tr>
            <tr><td>Total Reservasi</td><td>{{ number_format($totalReservasi, 0, ',', '.') }}</td></tr>
            <tr><td>Pelanggan Baru</td><td>{{ number_format($pelangganBaru, 0, ',', '.') }}</td></tr>
            <tr><td>Pertumbuhan Pendapatan</td><td>{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%</td></tr>
            <tr><td>Pertumbuhan Reservasi</td><td>{{ $reservasiGrowth >= 0 ? '+' : '' }}{{ $reservasiGrowth }}%</td></tr>
            <tr><td>Pertumbuhan Pelanggan</td><td>{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%</td></tr>
        </table>
    </div>

    <div class="section-title">Tren Pendapatan</div>
    <table>
        <thead>
            <tr><th>Periode</th><th>Pendapatan</th></tr>
        </thead>
        <tbody>
            @foreach ($chartLabels as $i => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $fmt($chartRevenue[$i] ?? 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Tren Reservasi</div>
    <table>
        <thead>
            <tr><th>Periode</th><th>Jumlah Reservasi</th></tr>
        </thead>
        <tbody>
            @foreach ($chartLabels as $i => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ number_format($chartBookings[$i] ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ date('d M Y H:i') }} &mdash; BeautyCare &copy; {{ date('Y') }}</div>
</body>
</html>
