<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\Matakuliah;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $listDosen = Dosen::pluck('nidn')->toArray();
        $listMatkul = Matakuliah::pluck('kode_matakuliah')->toArray();

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kelas = ['A', 'B', 'C'];

        //loop untuk membuat beberapa jadwal dummy
        for ($i = 0; $i < 6; $i++) {
            Jadwal::create([
                'kode_matakuliah' => $listMatkul[$i % count($listMatkul)],
                'nidn' => $listDosen[$i % count($listDosen)],
                'kelas' => $kelas[$i % count($kelas)],
                'hari' => $hari[$i % count($hari)],
                'jam' => Carbon::createFromTime(rand(8, 14), 0, 0), // Jam acak antara 08:00 sampai 14:00
            ]);
        }
    }
}