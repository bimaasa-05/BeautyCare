<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            // ========== TRANSFER BANKS (kode_bank = kode baku Indonesia) ==========
            [
                'nama_bank' => 'BCA',
                'kode_bank' => '014',
                'no_rekening' => '0140123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BRI',
                'kode_bank' => '002',
                'no_rekening' => '0020123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Mandiri',
                'kode_bank' => '008',
                'no_rekening' => '0080123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BNI',
                'kode_bank' => '009',
                'no_rekening' => '0090123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BSI',
                'kode_bank' => '451',
                'no_rekening' => '4510123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            // Bank transfer tambahan
            [
                'nama_bank' => 'Permata',
                'kode_bank' => '013',
                'no_rekening' => '0130123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'CIMB Niaga',
                'kode_bank' => '022',
                'no_rekening' => '0220123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'OCBC NISP',
                'kode_bank' => '028',
                'no_rekening' => '0280123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Maybank',
                'kode_bank' => '016',
                'no_rekening' => '0160123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Panin',
                'kode_bank' => '019',
                'no_rekening' => '0190123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Danamon',
                'kode_bank' => '011',
                'no_rekening' => '0110123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BJB',
                'kode_bank' => '110',
                'no_rekening' => '1100123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BTPN',
                'kode_bank' => '213',
                'no_rekening' => '2130123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],

            // ========== E-WALLET (tanpa kode_bank / no_rekening) ==========
            [
                'nama_bank' => 'Dana',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'GoPay',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'ShopeePay',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'OVO',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'LinkAja',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Sakuku',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],

            // ========== QRIS ==========
            [
                'nama_bank' => 'QRIS',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'qris',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
        ];

        $inserted = 0;
        $updated = 0;

        foreach ($banks as $data) {
            $bank = Bank::firstOrCreate(
                ['nama_bank' => $data['nama_bank'], 'tipe' => $data['tipe']],
                $data
            );

            if ($bank->wasRecentlyCreated) {
                $inserted++;
            } else {
                $bank->update($data);
                $updated++;
            }
        }

        $this->command->info("Bank seeder: {$inserted} inserted, {$updated} updated. Total records: " . Bank::count());
    }
}