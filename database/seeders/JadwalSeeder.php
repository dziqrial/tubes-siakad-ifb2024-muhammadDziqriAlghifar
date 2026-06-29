<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        Jadwal::create([
            'kode_matakuliah' => 'IF53413',
            'nidn' => '0412038901',
            'kelas' => 'A',
            'hari' => 'Senin',
            'jam' => '08:00',
        ]);
        Jadwal::create([
            'kode_matakuliah' => 'IF53414',
            'nidn' => '0415068202',
            'kelas' => 'B',
            'hari' => 'Selasa',
            'jam' => '10:00',
        ]);
    }
}