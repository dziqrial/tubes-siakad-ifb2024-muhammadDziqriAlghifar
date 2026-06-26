<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexJadwal()
    {
        $jadwal = Jadwal::with(['dosen', 'matakuliah'])->get();
        return response()->json([
            'status' => 'Sukses tembus Middleware Admin!',
            'pesan' => 'Berikut data Jadwal Perkuliahan hasil Seeder:',
            'data' => $jadwal
        ]);
    }

    // Logika Menyimpan Jadwal Baru
    public function storeJadwal(Request $request)
    {
        // Validasi Backend murni
        $request->validate([
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
            'nidn' => 'required|string|exists:dosen,nidn',
            'kelas' => 'required|string|max:1',
            'hari' => 'required|string',
            'jam' => 'required',
        ]);

        Jadwal::create($request->all());

        return "Berhasil menambahkan jadwal baru ke database!";
    }
}