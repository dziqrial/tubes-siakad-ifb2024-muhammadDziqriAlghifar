<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dataDosen = [
            ['nidn' => '0412038901', 'nama' => 'Dr. Agus Teja, M.T.'],
            ['nidn' => '0415068202', 'nama' => 'Rina Wijaya, M.Kom.'],
            ['nidn' => '0422098503', 'nama' => 'Budi Setiawan, M.Sc.'],
            ['nidn' => '0408117904', 'nama' => 'Siti Aminah, M.T.'],
            ['nidn' => '0430019105', 'nama' => 'Dedi Kurniawan, M.Kom.'],
        ];

        foreach ($dataDosen as $d) {
            Dosen::create($d);
        }
    }
}