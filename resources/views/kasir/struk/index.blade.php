<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk {{ $transaksi->no_invoice }} - BeautyCare</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .status-box { transition: all 0.2s ease; }
        pre.struk-preview {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
            background: #fff;
            white-space: pre;
            width: 58mm;
            max-width: 100%;
            margin: 0 auto;
            border: 1px dashed #e2e8f0;
            border-radius: 10px;
            padding: 12px 8px;
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    @php
        $sep   = '--------------------------------';
        $garis = '================================';

        $fmt = function ($v) {
            return number_format((float) $v, 0, ',', '.');
        };

        // Baris dua kolom: label kiri, nilai kanan (lebar total 32)
        $row = function ($label, $value, $bold = false) use ($fmt) {
            $left  = mb_substr((string) $label, 0, 8);
            $right = mb_substr((string) $value, 0, 24);
            return ($bold ? '[RB]' : '') . str_pad($left, 8) . str_pad($right, 24, ' ', STR_PAD_LEFT);
        };

        $line = [];

        // Header
        $line[] = '[CB]BEAUTYCARE';
        $line[] = '[C]Salon & Beauty Treatment';
        $line[] = '[C]Jl. Contoh No. 123, Kota';
        $line[] = '[C]Telp: 0812-3456-7890';
        $line[] = '[C]' . $sep;

        // Info
        $line[] = $row('No', $transaksi->no_invoice);
        $line[] = $row('Tgl', \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i'));
        if ($transaksi->user) {
            $line[] = $row('Kasir', $transaksi->user->nama);
        }
        $line[] = $row('Pel', $transaksi->pelanggan->nm_pelanggan ?? 'Umum');
        $line[] = '[C]' . $sep;

        // Item
        foreach (($transaksi->detail ?? []) as $item) {
            $nm = mb_substr((string) ($item->nm_item ?? '-'), 0, 20);
            $line[] = str_pad($nm, 20) . str_pad('Rp ' . $fmt($item->harga ?? 0), 12, ' ', STR_PAD_LEFT);
            if ((int) ($item->qty ?? 1) > 1) {
                $line[] = '  x ' . (int) $item->qty . str_pad('Rp ' . $fmt($item->subtotal ?? 0), 24, ' ', STR_PAD_LEFT);
            }
        }
        $line[] = '[C]' . $sep;

        // Ringkasan
        $line[] = $row('Subtotal', 'Rp ' . $fmt($transaksi->subtotal));
        if ((float) $transaksi->diskon > 0) {
            $line[] = $row('Diskon', '- Rp ' . $fmt($transaksi->diskon));
        }
        if ((float) $transaksi->pajak > 0) {
            $line[] = $row('Pajak', 'Rp ' . $fmt($transaksi->pajak));
        }
        $line[] = $row('TOTAL', 'Rp ' . $fmt($transaksi->total), true);
        $line[] = $row('Dibayar', 'Rp ' . $fmt($transaksi->dibayar));
        $line[] = $row('Kembali', 'Rp ' . $fmt($transaksi->kembali));
        $line[] = '[C]' . $sep;

        // Pembayaran
        $line[] = $row('Metode', $transaksi->metode_byr);
        if ($transaksi->no_referensi) {
            $line[] = $row('Ref', $transaksi->no_referensi);
        }
        $line[] = $row('Status', $transaksi->status);

        // Footer
        $line[] = '[C]' . $garis;
        $line[] = '[CB]TERIMA KASIH';
        $line[] = '[C]Semoga puas dengan layanan kami';
        $line[] = '[C]' . mb_substr('Dicetak ' . now()->format('d/m/Y H:i') . ' | ' . ($transaksi->user->nama ?? 'kasir'), 0, 32);

        $strukTeks = implode("\n", $line);
    @endphp

    <div class="max-w-xl mx-auto p-6">

        <div class="no-print bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">
                        <i class="fa-solid fa-receipt text-pink-500 mr-2"></i>Cetak Struk
                    </h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $transaksi->no_invoice }}</p>
                </div>
                <a href="javascript:window.close()" class="text-xs text-gray-500 hover:text-gray-700">
                    <i class="fa-solid fa-xmark mr-1"></i>Tutup
                </a>
            </div>

            <!-- Status Bar -->
            <div id="statusBox" class="status-box mb-4 p-3 rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200 flex items-center text-sm">
                <i class="fas fa-info-circle mr-2 text-lg"></i>
                <span id="statusText">Printer belum terhubung.</span>
            </div>

            <!-- Kontrol -->
            <div class="space-y-3">
                <button id="btnConnect"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center">
                    <i class="fab fa-bluetooth mr-2"></i> Hubungkan Printer
                </button>

                <button id="btnPrint" disabled
                    class="w-full bg-gray-400 cursor-not-allowed text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 flex items-center justify-center">
                    <i class="fas fa-print mr-2"></i> Cetak Struk
                </button>
            </div>

            <p class="mt-3 text-[11px] text-gray-400 text-center">
                * Berfungsi di Google Chrome/Edge via HTTPS atau localhost. Pastikan Bluetooth printer menyala.
            </p>
        </div>

        <!-- Pratinjau Struk -->
        <div class="no-print text-center mb-2">
            <span class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold">Pratinjau Struk (58mm)</span>
        </div>
        <pre id="strukPreview" class="struk-preview"></pre>
    </div>

    <script src="{{ asset('assets/js/escpos-printer.js') }}"></script>
    <script>
        const STRUK_TEXT = @json($strukTeks);

        const btnConnect = document.getElementById('btnConnect');
        const btnPrint = document.getElementById('btnPrint');
        const statusBox = document.getElementById('statusBox');
        const statusText = document.getElementById('statusText');

        // Tampilkan pratinjau
        document.getElementById('strukPreview').textContent = STRUK_TEXT;

        function updateStatus(message, type) {
            statusText.innerText = message;
            statusBox.className = 'status-box mb-4 p-3 rounded-lg flex items-center text-sm border';

            const icon = type === 'error'
                ? '<i class="fas fa-exclamation-circle mr-2 text-lg"></i>'
                : type === 'success'
                    ? '<i class="fas fa-check-circle mr-2 text-lg"></i>'
                    : '<i class="fas fa-info-circle mr-2 text-lg"></i>';

            const colors = {
                error: ['bg-red-50', 'text-red-700', 'border-red-200'],
                success: ['bg-green-50', 'text-green-700', 'border-green-200'],
                info: ['bg-yellow-50', 'text-yellow-700', 'border-yellow-200']
            };
            const cls = colors[type] || colors.info;
            statusBox.classList.add(...cls);
            statusBox.innerHTML = icon + ' <span id="statusText">' + message + '</span>';
        }

        EscPosPrinter.onStatus = function (message, type) {
            updateStatus(message, type);
            btnPrint.disabled = !EscPosPrinter.isConnected();
            if (EscPosPrinter.isConnected()) {
                btnConnect.classList.replace('bg-blue-600', 'bg-green-600');
                btnConnect.classList.replace('hover:bg-blue-700', 'hover:bg-green-700');
                btnConnect.innerHTML = '<i class="fas fa-check mr-2"></i> Terhubung';
                btnPrint.classList.replace('bg-gray-400', 'bg-indigo-600');
                btnPrint.classList.replace('cursor-not-allowed', 'hover:bg-indigo-700');
            } else {
                btnConnect.classList.replace('bg-green-600', 'bg-blue-600');
                btnConnect.classList.replace('hover:bg-green-700', 'hover:bg-blue-700');
                btnConnect.innerHTML = '<i class="fab fa-bluetooth mr-2"></i> Hubungkan Printer';
                btnPrint.classList.replace('bg-indigo-600', 'bg-gray-400');
                btnPrint.classList.replace('hover:bg-indigo-700', 'cursor-not-allowed');
            }
        };

        btnConnect.addEventListener('click', async function () {
            if (EscPosPrinter.isConnected()) {
                EscPosPrinter.disconnect();
            } else {
                await EscPosPrinter.connect();
            }
        });

        btnPrint.addEventListener('click', async function () {
            await EscPosPrinter.printText(STRUK_TEXT);
        });
    </script>
</body>
</html>
