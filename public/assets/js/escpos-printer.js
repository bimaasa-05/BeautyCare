/**
 * escpos-printer.js
 * Cetak struk ke printer thermal Bluetooth (ESC/POS) via Web Bluetooth.
 * Pola: docs/resources/cetak.html (RPP02) — dirapikan & dikembangkan.
 * Hanya berfungsi di Chrome/Edge melalui HTTPS atau localhost.
 */
(function () {
    'use strict';

    // UUID umum untuk printer Bluetooth POS / Thermal (seperti RPP02)
    const PRINTER_SERVICES = [
        '000018f0-0000-1000-8000-00805f9b34fb', // Standard Printer Service
        'e7810a71-73ae-499d-8c15-faa9aef0c3f2', // Generic POS
        '49535343-fe7d-4ae5-8fa9-9fafd205e455'  // Generic POS 2
    ];

    // Lebar struk standar (font A, 58mm) = 32 karakter
    const LINE_WIDTH = 32;

    let printCharacteristic = null;
    let bluetoothDevice = null;
    let onStatusCallback = null;

    function setStatus(message, type) {
        if (typeof onStatusCallback === 'function') {
            onStatusCallback(message, type || 'info');
        }
    }

    function isConnected() {
        return printCharacteristic !== null;
    }

    function onDisconnected() {
        printCharacteristic = null;
        bluetoothDevice = null;
        setStatus('Koneksi printer terputus.', 'error');
    }

    async function connect() {
        if (!navigator.bluetooth) {
            setStatus('Web Bluetooth tidak didukung di browser ini. Gunakan Chrome/Edge.', 'error');
            return false;
        }

        try {
            setStatus('Mencari perangkat Bluetooth...');
            bluetoothDevice = await navigator.bluetooth.requestDevice({
                acceptAllDevices: true,
                optionalServices: PRINTER_SERVICES
            });

            setStatus('Menghubungkan ke ' + (bluetoothDevice.name || 'printer') + '...');
            bluetoothDevice.addEventListener('gattserverdisconnected', onDisconnected);

            const server = await bluetoothDevice.gatt.connect();

            let serviceFound = false;
            for (const uuid of PRINTER_SERVICES) {
                try {
                    const service = await server.getPrimaryService(uuid);
                    const characteristics = await service.getCharacteristics();
                    for (const char of characteristics) {
                        if (char.properties.write || char.properties.writeWithoutResponse) {
                            printCharacteristic = char;
                            serviceFound = true;
                            break;
                        }
                    }
                } catch (e) {
                    // lanjut ke UUID berikutnya
                }
                if (serviceFound) break;
            }

            if (!printCharacteristic) {
                throw new Error('Karakteristik tulis tidak ditemukan pada perangkat ini.');
            }

            setStatus('Terhubung ke: ' + (bluetoothDevice.name || 'Printer Bluetooth'), 'success');
            return true;
        } catch (error) {
            console.error(error);
            setStatus('Gagal terhubung: ' + error.message, 'error');
            return false;
        }
    }

    async function disconnect() {
        if (bluetoothDevice && bluetoothDevice.gatt.connected) {
            try { bluetoothDevice.gatt.disconnect(); } catch (e) { /* abaikan */ }
        }
        printCharacteristic = null;
        bluetoothDevice = null;
        setStatus('Printer diputus.', 'info');
    }

    /**
     * Ubah teks struk menjadi byte ESC/POS.
     * Markup per baris (opsional):
     *   [C]  rata tengah      [R]  rata kanan
     *   [B]  teks tebal       [CB] tengah + tebal   [RB] kanan + tebal
     * Semua baris dicetak tebal (ESC E 1) agar teks lebih jelas/hitam di kertas thermal.
     */
    function generateEscPos(text) {
        const encoder = new TextEncoder();
        const data = [];

        // 1. Inisialisasi printer (ESC @) + aktifkan bold untuk semua baris
        data.push(0x1B, 0x40);
        data.push(0x1B, 0x45, 1);

        const lines = String(text || '').split('\n');
        let currentAlign = -1;

        for (let raw of lines) {
            let align = 0;

            const m = raw.match(/^\[([CLRB]+)\]\s?(.*)$/);
            if (m) {
                if (m[1].indexOf('C') !== -1) align = 1;
                else if (m[1].indexOf('R') !== -1) align = 2;
                raw = m[2];
            }

            // Perataan
            if (align === 2) {
                raw = raw.padStart(LINE_WIDTH);
            } else if (align === 1) {
                const pad = Math.max(0, Math.floor((LINE_WIDTH - raw.length) / 2));
                raw = ' '.repeat(pad) + raw;
            }

            // Alignment (ESC a n)
            if (align !== currentAlign) {
                data.push(0x1B, 0x61, align);
                currentAlign = align;
            }

            const enc = encoder.encode(raw + '\n');
            for (let i = 0; i < enc.length; i++) data.push(enc[i]);
        }

        // Jeda kertas agar mudah dirobek
        data.push(0x0A, 0x0A, 0x0A, 0x0A);

        // Potong kertas (GS V 66 = partial cut)
        data.push(0x1D, 0x56, 0x42);

        return new Uint8Array(data);
    }

    async function printText(text) {
        if (!printCharacteristic) {
            setStatus('Printer belum terhubung! Klik "Hubungkan Printer" dulu.', 'error');
            return false;
        }

        try {
            setStatus('Sedang mencetak...');

            const escPosData = generateEscPos(text);

            // Bluetooth BLE: tulis per-chunk kecil dengan jeda agar buffer printer tidak penuh
            const CHUNK_SIZE = 20;
            for (let i = 0; i < escPosData.length; i += CHUNK_SIZE) {
                const chunk = escPosData.slice(i, i + CHUNK_SIZE);
                await printCharacteristic.writeValue(chunk);
                await new Promise(resolve => setTimeout(resolve, 10));
            }

            setStatus('Struk berhasil dicetak!', 'success');
            return true;
        } catch (error) {
            console.error(error);
            setStatus('Gagal mencetak: ' + error.message, 'error');
            return false;
        }
    }

    // API global
    window.EscPosPrinter = {
        connect: connect,
        disconnect: disconnect,
        printText: printText,
        generateEscPos: generateEscPos,
        isConnected: isConnected,
        set onStatus(cb) { onStatusCallback = cb; }
    };
})();
