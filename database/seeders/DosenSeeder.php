<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = [
            ['nidn' => '0412038901', 'nama' => 'Ir. Ahmad Subarjo, M.T.'],
            ['nidn' => '0415088502', 'nama' => 'Siti Aminah, S.Kom., M.Kom.'],
            ['nidn' => '0422119003', 'nama' => 'Budi Raharjo, Ph.D.'],
            ['nidn' => '0405028204', 'nama' => 'Diana Lestari, M.C.S.'],
            ['nidn' => '0419067805', 'nama' => 'Eko Prasetyo, M.Eng.'],
        ];

        foreach ($dosen as $d) {
            Dosen::create($d);
        }
    }
}
