<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'whatsapp' => '+628123456789', // Masukkan nomor WA tanpa 0 di awal
            'password' => Hash::make('admin123'), // Ganti dengan password sesuai kebutuhan
            'role' => 'admin', // Set role sebagai admin
            'name' => 'Administrator', // Default value agar tidak kosong
            'email' => 'admin@gmail.com', // Kosongkan kolom email sesuai instruksi
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
