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
                'kode_bank' => '01433333333333',
                'no_rekening' => '0140123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BRI',
                'kode_bank' => '00233',
                'no_rekening' => '0020123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Mandiri',
                'kode_bank' => '008213131',
                'no_rekening' => '0080123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BNI',
                'kode_bank' => '00123131319',
                'no_rekening' => '0090123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BSI',
                'kode_bank' => '451231311',
                'no_rekening' => '4510123456789',
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],

            // ========== E-WALLET (tanpa kode_bank / no_rekening) ==========
            [
                'nama_bank' => 'Dana',
                'kode_bank' => 001,
                'no_rekening' => 11000542,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'GoPay',
                'kode_bank' => 1231313,
                'no_rekening' => 11000542,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'ShopeePay',
                'kode_bank' => 00023,
                'no_rekening' => 0010002020,
                'atas_nama' => 'BeautyCare Overpower',
                'tipe' => 'ewallet',
                'nomor_telepon' => '081234567890',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'OVO',
                'kode_bank' => 1231313,
                'no_rekening' => 2020101010,
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