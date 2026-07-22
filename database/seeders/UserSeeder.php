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
            'password' => '123',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Kasir',
            'email' => 'k@gmail.com',
            'no_hp' => '081234567892',
            'password' => '123',
            'role' => 'kasir',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Beautycian',
            'email' => 'b@gmail.com',
            'no_hp' => '081234567893',
            'password' => '123',
            'role' => 'beautycian',
            'status' => 'aktif',
        ]);

        User::create([
            'nama' => 'Pelanggan',
            'email' => 'p@gmail.com',
            'no_hp' => '081234567894',
            'password' => '123',
            'role' => 'pelanggan',
            'status' => 'aktif',
        ]);
    }
}
