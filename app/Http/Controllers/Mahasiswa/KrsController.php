<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KrsController extends Controller
{
    // 1. Menampilkan Halaman Pengisian KRS
    public function index()
    {
        // Ambil semua jadwal beserta relasi dosen dan matakuliah
        $jadwalTersedia = Jadwal::with(['dosen', 'matakuliah'])->get();
        
        // Ambil data mahasiswa (dummy default sesuai konfigurasi awal)
        $mhs = Mahasiswa::first();
        $npm = $mhs ? $mhs->npm : '2455201001';
        
        // Ambil daftar KRS milik mahasiswa tersebut yang sudah tersimpan di database
        $krsDiambil = Krs::with(['matakuliah'])->where('npm', $npm)->get();

        return view('mahasiswa.krs', compact('jadwalTersedia', 'krsDiambil', 'npm'));
    }

    // 2. Proses Ambil Massal (Bulk Insert) Tanpa JavaScript
    public function store(Request $request)
    {
        // Validasi input form wajib membawa array checklist
        $request->validate([
            'npm' => 'required|string|exists:mahasiswa,npm',
            'matakuliah_pilihan' => 'required|array|min:1',
        ], [
            'matakuliah_pilihan.required' => 'Pilih minimal satu mata kuliah dengan mencentang kotak sebelum melakukan Apply!',
        ]);

        $npm = $request->npm;
        $pilihan = $request->matakuliah_pilihan; // Berisi array kode_matakuliah yang dicentang

        // --- VALIDASI 1: CEK DUPLIKASI NAMA MATKUL DI DALAM FORM YANG DICENTANG ---
        $matkulDicentang = Matakuliah::whereIn('kode_matakuliah', $pilihan)->pluck('nama_matakuliah')->toArray();
        if (count($matkulDicentang) !== count(array_unique($matkulDicentang))) {
            return redirect()->back()->with('error', 'Gagal menyimpan! Kamu memilih mata kuliah yang sama di kelas berbeda sekaligus.');
        }

        // --- VALIDASI 2: HITUNG TOTAL SKS DI DATABASE SAAT INI ---
        $currentKrs = Krs::with(['matakuliah'])->where('npm', $npm)->get();
        $currentSks = $currentKrs->sum(function($item) {
            return $item->matakuliah->sks;
        });

        // --- VALIDASI 3: HITUNG BEBAN SKS BARU YANG AKAN DITAMBAHKAN ---
        $sksBaru = Matakuliah::whereIn('kode_matakuliah', $pilihan)->sum('sks');

        // Batas maksimal SKS kumulatif adalah 24 SKS
        if (($currentSks + $sksBaru) > 24) {
            return redirect()->back()->with('error', 'Gagal memproses! Akumulasi pilihan membuat total beban KRS kamu melebihi batas maksimal 24 SKS.');
        }

        // --- PROSES BULK INSERT ---
        $suksesCount = 0;
        $skipCount = 0;

        foreach ($pilihan as $kode_mk) {
            $matkulTarget = Matakuliah::where('kode_matakuliah', $kode_mk)->first();

            // Proteksi backend: Cek apakah nama mata kuliah ini sudah pernah diambil sebelumnya di database
            $sudahAmbilMatkulIni = Krs::where('npm', $npm)->whereHas('matakuliah', function($query) use ($matkulTarget) {
                $query->where('nama_matakuliah', $matkulTarget->nama_matakuliah);
            })->exists();

            if (!$sudahAmbilMatkulIni) {
                Krs::create([
                    'npm' => $npm,
                    'kode_matakuliah' => $kode_mk
                ]);
                $suksesCount++;
            } else {
                $skipCount++;
            }
        }

        // Susun pesan notifikasi feedback
        $pesan = "$suksesCount Mata kuliah berhasil didaftarkan ke KRS.";
        if ($skipCount > 0) {
            $pesan .= " ($skipCount matakuliah diabaikan karena sudah pernah kamu ambil).";
        }

        return redirect()->back()->with('success', $pesan);
    }

    // 3. Fungsi Reset/Kosongkan Total KRS (Digunakan dari halaman dashboard utama)
    public function resetKrs(Request $request)
    {
        $request->validate(['npm' => 'required|string|exists:mahasiswa,npm']);

        Krs::where('npm', $request->npm)->delete();

        return redirect()->route('dashboard')->with('success', 'KRS berhasil dikosongkan! Silakan lakukan pengisian ulang.');
    }

    public function exportPdf()
    {
        // 1. Ambil data mahasiswa (dummy default project)
        $mhs = Mahasiswa::first();
        $npm = $mhs ? $mhs->npm : '2455201001';
        $namaMhs = $mhs ? $mhs->nama : 'Hamima Talia Rahimah';

        // 2. Tarik daftar KRS milik mahasiswa yang sudah SAH/FIX tersimpan di database
        $krsDiambil = Krs::with(['matakuliah'])->where('npm', $npm)->get();
        
        // 3. Hitung total kumulatif SKS
        $totalSks = $krsDiambil->sum(function($k) {
            return $k->matakuliah->sks;
        });

        // 4. Siapkan data paket yang akan dikirim ke layout kertas PDF
        $data = [
            'nama' => $namaMhs,
            'npm' => $npm,
            'krsDiambil' => $krsDiambil,
            'totalSks' => $totalSks,
            'tanggal' => date('d-m-Y')
        ];

        // 5. Load view khusus cetakan kertas, set ukuran kertas A4 potrait
        $pdf = Pdf::loadView('mahasiswa.krs_pdf', $data)->setPaper('a4', 'portrait');
        
        // 6. Alirkan file ke browser untuk otomatis download
        return $pdf->stream('KRS_' . $npm . '_' . str_replace(' ', '_', $namaMhs) . '.pdf');
    }
}