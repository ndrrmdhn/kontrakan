<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'photo' => null,
                'address' => 'Jl. Admin Utama No. 1',
                'gender' => 'L',
                'date_of_birth' => '1990-01-01',
                'kartu_identitas' => null,
                'role' => 'admin',
                'status' => 'aktif',
            ],
            [
                'name' => 'Regular User',
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('user123'),
                'phone' => '081298765432',
                'photo' => null,
                'address' => 'Jl. User Biasa No. 2',
                'gender' => 'P',
                'date_of_birth' => '1995-05-15',
                'kartu_identitas' => null,
                'role' => 'user',
                'status' => 'aktif',
            ],
        ]);
    }
}
