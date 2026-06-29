<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $dataMatkul = [
            ['kode_matakuliah' => 'IF53413', 'nama_matakuliah' => 'Pemrograman Web II', 'sks' => 3],
            ['kode_matakuliah' => 'IF53414', 'nama_matakuliah' => 'Jaringan Komputer', 'sks' => 3],
            ['kode_matakuliah' => 'IF53415', 'nama_matakuliah' => 'Basis Data Lanjut', 'sks' => 3],
            ['kode_matakuliah' => 'IF53416', 'nama_matakuliah' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
            ['kode_matakuliah' => 'IF53417', 'nama_matakuliah' => 'Sistem Operasi', 'sks' => 3],
            ['kode_matakuliah' => 'IF53418', 'nama_matakuliah' => 'Kecerdasan Buatan', 'sks' => 3],
            ['kode_matakuliah' => 'IF53419', 'nama_matakuliah' => 'Grafika Komputer', 'sks' => 3],
            ['kode_matakuliah' => 'IF53420', 'nama_matakuliah' => 'Interaksi Manusia & Komputer', 'sks' => 3],
        ];

        foreach ($dataMatkul as $mk) {
            Matakuliah::create($mk);
        }
    }
}