<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data dosen untuk dipasangkan sebagai dosen wali silang
        $nidnDosen = ['0412038901', '0415068202', '0422098503', '0408117904', '0430019105'];
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();

        $mahasiswas = [
            ['npm' => '2455201001', 'nama' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@student.com'],
            ['npm' => '2455201002', 'nama' => 'Bella Citra', 'email' => 'bella.citra@student.com'],
            ['npm' => '2455201003', 'nama' => 'Candra Wijaya', 'email' => 'candra.wijaya@student.com'],
            ['npm' => '2455201004', 'nama' => 'Dina Lestari', 'email' => 'dina.lestari@student.com'],
            ['npm' => '2455201005', 'nama' => 'Eka Pratama', 'email' => 'eka.pratama@student.com'],
        ];

        foreach ($mahasiswas as $index => $m) {
            $userMhs = User::create([
                'name' => $m['nama'],
                'email' => $m['email'],
                'password' => Hash::make('password'),
            ]);
            $userMhs->assignRole($mahasiswaRole);

            Mahasiswa::create([
                'npm' => $m['npm'],
                'nama' => $m['nama'],
                'nidn' => $nidnDosen[$index], // Plotting dosen wali secara urut
            ]);
        }
    }
}