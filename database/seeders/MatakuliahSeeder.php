<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $matkul = [
            ['kode_matakuliah' => 'IF53413', 'nama_matakuliah' => 'Pemrograman Web II', 'sks' => 3],
            ['kode_matakuliah' => 'IF53414', 'nama_matakuliah' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
            ['kode_matakuliah' => 'IF53415', 'nama_matakuliah' => 'Jaringan Komputer', 'sks' => 3],
            ['kode_matakuliah' => 'IF53416', 'nama_matakuliah' => 'Basis Data Lanjut', 'sks' => 4],
            ['kode_matakuliah' => 'IF53417', 'nama_matakuliah' => 'Kecerdasan Buatan', 'sks' => 2],
        ];

        foreach ($matkul as $m) {
            Matakuliah::create($m);
        }
    }
}
