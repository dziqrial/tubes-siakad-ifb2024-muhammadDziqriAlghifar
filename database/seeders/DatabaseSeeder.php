<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder{
    public function run(): void
    {
        $this->call([
            DosenSeeder::class,
            MatakuliahSeeder::class,
            MahasiswaSeeder::class,
            JadwalSeeder::class,
        ]);

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleMahasiswa = Role::create(['name' => 'mahasiswa']);

        $adminUser = User::create([
            'name' => 'Administrator SIAKAD',
            'email' => 'admin@siakad.com',
            'password' => bcrypt('password123'),
        ]);
        $adminUser->assignRole($roleAdmin);

        $mahasiswaData = Mahasiswa::first();

        if ($mahasiswaData) {
            $mahasiswaUser = User::create([
                'name' => $mahasiswaData->nama,
                'email' => 'mahasiswa@siakad.com',
                'password' => bcrypt('password123'),
            ]);
            $mahasiswaUser->assignRole($roleMahasiswa);
        }
    }
}