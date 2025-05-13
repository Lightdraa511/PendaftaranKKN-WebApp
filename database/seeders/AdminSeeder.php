<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin default
        Admin::create([
            'nama' => 'Administrator',
            'email' => 'admin@kknm.ac.id',
            'password' => 'admin123',
        ]);

        // Buat admin tambahan jika diperlukan
        Admin::create([
            'nama' => 'Petugas KKNM',
            'email' => 'petugas@kknm.ac.id',
            'password' => 'petugas123',
        ]);
    }
}
