<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'a@gmail.com',
            'no_hp' => '081234567891',
            'password' => 'Beautycare01',
            'role' => 'admin',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        User::create([
            'nama' => 'Kasir',
            'email' => 'k@gmail.com',
            'no_hp' => '081234567892',
            'password' => 'Beautycare02',
            'role' => 'kasir',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        User::create([
            'nama' => 'Beautycian',
            'email' => 'b@gmail.com',
            'no_hp' => '081234567893',
            'password' => 'Beautycare03',
            'role' => 'beautycian',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        User::create([
            'nama' => 'Pelanggan',
            'email' => 'p@gmail.com',
            'no_hp' => '081234567894',
            'password' => 'Beautycare04',
            'role' => 'pelanggan',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);
    }
}
