<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jalankan Sub-Seeder Master Berurutan (Penting untuk menjaga integritas foreign key)
        $this->call([
            RoleSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            MatakuliahSeeder::class,
            JadwalSeeder::class,
        ]);

        // 2. Tambah Akun Admin Utama Langsung di Sini
        $adminRole = Role::where('name','admin')->first();
        $adminUser = User::create([
            'name' => 'Admin SIAKAD',
            'email' => 'admin@siakad.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole($adminRole);
    }
}