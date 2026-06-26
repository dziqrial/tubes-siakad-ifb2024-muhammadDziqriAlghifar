<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); 
        $listDosen = Dosen::pluck('nidn')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $npm = '5520124' . str_pad($i, 3, '0', STR_PAD_LEFT); 
            
            Mahasiswa::create([
                'npm' => $npm,
                'nama' => $faker->name,
                'nidn' => $faker->randomElement($listDosen), // Pilih dosen wali secara acak
            ]);
        }
    }
}
