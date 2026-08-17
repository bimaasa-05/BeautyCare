<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            // ========== TRANSFER BANK ==========
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

            // ========== E-WALLET ==========
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
                [
                    'nama_bank' => $data['nama_bank'],
                    'tipe' => $data['tipe'],
                ],
                $data
            );

            if ($bank->wasRecentlyCreated) {
                $inserted++;
            } else {
                $bank->update($data);
                $updated++;
            }
        }

        $this->command->info(
            "Bank seeder: {$inserted} inserted, {$updated} updated. Total records: "
            . Bank::count()
        );
    }
}
