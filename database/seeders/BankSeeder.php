<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            // Transfer Banks (kode standar Indonesia)
            [
                'nama_bank' => 'BCA',
                'kode_bank' => '014',
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BRI',
                'kode_bank' => '002',
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'Mandiri',
                'kode_bank' => '008',
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BNI',
                'kode_bank' => '009',
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            [
                'nama_bank' => 'BSI',
                'kode_bank' => '451',
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'transfer',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
            // E-Wallet
            [
                'nama_bank' => 'Dana',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'ewallet',
                'nomor_telepon' => '+628xx-xxxx-xxxx',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'GoPay',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'ewallet',
                'nomor_telepon' => '+628xx-xxxx-xxxx',
                'is_active' => true,
            ],
            [
                'nama_bank' => 'ShopeePay',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'ewallet',
                'nomor_telepon' => '+628xx-xxxx-xxxx',
                'is_active' => true,
            ],
            // QRIS
            [
                'nama_bank' => 'QRIS',
                'kode_bank' => null,
                'no_rekening' => null,
                'atas_nama' => 'BeautyCare Official',
                'logo' => null,
                'tipe' => 'qris',
                'nomor_telepon' => null,
                'is_active' => true,
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }

        $this->command->info('Bank seeder executed: ' . count($banks) . ' records inserted.');
    }
}