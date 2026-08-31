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
            font-size: 15px;
            font-weight: 700;
            line-height: 1.65;
            color: #000;
            background: #fff;
            white-space: pre;
            width: 360px;
            max-width: 100%;
            margin: 0 auto;
            border: 1px dashed #e2e8f0;
            border-radius: 12px;
            padding: 18px 14px;
            box-shadow: 0 4px 16px -6px rgba(0,0,0,0.08);
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    @php
        // ===== Data toko (dari tabel pengaturan, fallback ke contoh) =====
        $pg = \Illuminate\Support\Facades\DB::table('pengaturan')->first();
        $namaToko = ($pg->nama_salon ?? '') ?: 'BeautyCare Official';
        $telpToko = ($pg->telepon ?? '') ?: '0101010001';
        $alamatRaw = trim((string) ($pg->alamat ?? ''));
        $alamatLines = $alamatRaw === '' ? [] : preg_split('/\r\n|\r|\n/', $alamatRaw, -1, PREG_SPLIT_NO_EMPTY);
        $alamat1 = $alamatLines[0] ?? 'Jl. Bandung dan Indramayu';
        $alamat2 = $alamatLines[1] ?? 'Sahabatan, Kota';

        // ===== Konstanta =====
        $sep   = str_repeat('-', 32);
        $garis = str_repeat('=', 32);
        $fmt   = fn ($v) => number_format((float) $v, 0, ',', '.');

        // Waktu pembuatan transaksi (jam dari created_at; fallback jam nyata bila 00:00)
        $wkt = $transaksi->created_at ?? $transaksi->tanggal;
        if (!$wkt || \Carbon\Carbon::parse($wkt)->format('H:i') === '00:00') {
            $wkt = now();
        }
        $wktLabel = \Carbon\Carbon::parse($wkt)->format('d/m/Y H:i');

        // ===== Builder baris: $d = untuk printer (marker), $p = untuk preview (padding) =====
        $d = [];
        $p = [];

        $add = function ($teks = '', $a = 'left', $b = false) use (&$d, &$p) {
            $mark = ($a === 'center' ? 'C' : ($a === 'right' ? 'R' : '')) . ($b ? 'B' : '');
            $d[] = $mark ? '[' . $mark . ']' . $teks : $teks;
            if ($a === 'center') {
                $pad = max(0, floor((32 - mb_strlen($teks)) / 2));
                $teks = str_repeat(' ', $pad) . $teks;
            } elseif ($a === 'right') {
                $teks = str_pad($teks, 32, ' ', STR_PAD_LEFT);
            }
            $p[] = $teks;
        };

        $row2 = function ($label, $value) use (&$d, &$p) {
            $line = str_pad(mb_substr((string) $label, 0, 14), 14) . str_pad(mb_substr((string) $value, 0, 18), 18, ' ', STR_PAD_LEFT);
            $d[] = $line;
            $p[] = $line;
        };

        // ===== Header toko =====
        $add(strtoupper($namaToko), 'center');
        $add('Salon & Beauty Treatment', 'center');
        $add($alamat1, 'center');
        $add($alamat2, 'center');
        $add('Telp. ' . $telpToko, 'center');
        $add($sep, 'center');

        // ===== Info transaksi =====
        $row2('No. Transaksi', $transaksi->no_invoice);
        $row2('Tanggal', $wktLabel);
        $row2('Kasir', $transaksi->kasir?->nama ?? $transaksi->user?->nama ?? '-');
        $row2('Pelanggan', $transaksi->pelanggan->nm_pelanggan ?? 'Umum');
        $add($sep, 'center');

        // ===== Daftar item =====
        foreach (($transaksi->detail ?? []) as $item) {
            $row2($item->nm_item ?? '-', 'Rp ' . $fmt($item->harga ?? 0));
            if ((int) ($item->qty ?? 1) > 1) {
                $add('    x ' . (int) $item->qty . '  ' . str_pad('Rp ' . $fmt($item->subtotal ?? 0), 20, ' ', STR_PAD_LEFT), 'left');
            }
        }
        $add($sep, 'center');

        // ===== Ringkasan =====
        $row2('Subtotal', 'Rp ' . $fmt($transaksi->subtotal));
        if ((float) $transaksi->diskon > 0) {
            $row2('Diskon', '- Rp ' . $fmt($transaksi->diskon));
        }
        if ((float) $transaksi->pajak > 0) {
            $row2('Pajak', 'Rp ' . $fmt($transaksi->pajak));
        }
        $row2('TOTAL', 'Rp ' . $fmt($transaksi->total));
        $row2('Dibayar', 'Rp ' . $fmt($transaksi->dibayar));
        $row2('Kembali', 'Rp ' . $fmt($transaksi->kembali));
        $add($sep, 'center');

        // ===== Metode & status =====
        $row2('Metode', $transaksi->metode_byr);
        if ($transaksi->no_referensi) {
            $row2('No. Referensi', $transaksi->no_referensi);
        }
        $row2('Status', $transaksi->status);

        // ===== Footer =====
        $add($garis, 'center');
        $add('TERIMA KASIH', 'center');
        $add('Semoga puas dengan layanan kami', 'center');
        $add('Dicetak ' . now()->format('d/m/Y H:i'), 'center');

        $strukTeks = implode("\n", $d);
        $strukPreview = implode("\n", $p);
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
        const STRUK_PREVIEW = @json($strukPreview);

        const btnConnect = document.getElementById('btnConnect');
        const btnPrint = document.getElementById('btnPrint');
        const statusBox = document.getElementById('statusBox');
        const statusText = document.getElementById('statusText');

        // Tampilkan pratinjau identik dengan hasil cetak
        document.getElementById('strukPreview').textContent = STRUK_PREVIEW;

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