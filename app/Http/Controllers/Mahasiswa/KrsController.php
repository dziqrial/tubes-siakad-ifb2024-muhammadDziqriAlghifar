<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    // Menampilkan halaman KRS Mahasiswa
    public function index()
    {
        return response()->json([
            'status' => 'Sukses tembus Middleware Mahasiswa!',
            'pesan' => 'Kamu berada di endpoint KRS. Di sini nanti list mata kuliah pilihan akan muncul.'
        ]);
    }

    //Logika Mahasiswa Mengambil Mata Kuliah (Simpan ke tabel KRS)
    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required|string|exists:mahasiswa,npm',
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
        ]);

        //Cek apakah mahasiswa sudah mengambil matakuliah ini sebelumnya
        $terdaftar = Krs::where('npm', $request->npm)
                        ->where('kode_matakuliah', $request->kode_matakuliah)
                        ->exists();

        if ($terdaftar) {
            return "Gagal! Kamu sudah mengambil mata kuliah ini.";
        }

        Krs::create($request->all());

        return "Mata kuliah berhasil ditambahkan ke KRS kamu!";
    }
}