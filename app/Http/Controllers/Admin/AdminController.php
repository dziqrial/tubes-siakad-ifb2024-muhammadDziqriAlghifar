<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Jadwal;
use App\Models\Krs;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ====== DASHBOARD STATISTICS ======
    public function dashboard()
    {
        $countDosen = Dosen::count();
        $countMahasiswa = Mahasiswa::count();
        $countMatkul = Matakuliah::count();
        $countJadwal = Jadwal::count();
        
        // Bonus fitur: Statistik Mahasiswa yang sudah isi KRS
        $totalKrsPenuh = Krs::distinct('npm')->count();

        return view('admin.dashboard', compact('countDosen', 'countMahasiswa', 'countMatkul', 'countJadwal', 'totalKrsPenuh'));
    }

    // ====== 1. MANAGEMENT DOSEN ======
    public function dosenIndex()
    {
        $dataDosen = Dosen::orderBy('nidn', 'asc')->get();
        return view('admin.dosen', compact('dataDosen'));
    }

    public function dosenStore(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|size:10|unique:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        Dosen::create($request->all());
        return redirect()->back()->with('success', 'Data Dosen berhasil ditambahkan!');
    }

    public function dosenUpdate(Request $request, $nidn)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $dosen = Dosen::where('nidn', $nidn)->firstOrFail();
        $dosen->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Data Dosen berhasil diperbarui!');
    }

    public function dosenDelete($nidn)
    {
        Dosen::where('nidn', $nidn)->delete();
        return redirect()->back()->with('success', 'Data Dosen berhasil dihapus!');
    }

    // ====== 2. MANAGEMENT MAHASISWA ======
    public function mahasiswaIndex()
    {
        $dataMahasiswa = Mahasiswa::with('dosenWali')->get();
        $dataDosen = Dosen::all(); // Untuk dropdown pilih dosen wali
        return view('admin.mahasiswa', compact('dataMahasiswa', 'dataDosen'));
    }

    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'npm' => 'required|string|size:10|unique:mahasiswa,npm',
            'nidn' => 'required|string|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->back()->with('success', 'Data Mahasiswa berhasil ditambahkan!');
    }

    public function mahasiswaUpdate(Request $request, $npm)
    {
        $request->validate([
            'nidn' => 'required|string|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        $mhs = Mahasiswa::where('npm', $npm)->firstOrFail();
        $mhs->update($request->all());

        return redirect()->back()->with('success', 'Data Mahasiswa berhasil diperbarui!');
    }

    public function mahasiswaDelete($npm)
    {
        Mahasiswa::where('npm', $npm)->delete();
        return redirect()->back()->with('success', 'Data Mahasiswa berhasil dihapus!');
    }

    // ====== 3. MANAGEMENT MATA KULIAH ======
    public function matakuliahIndex()
    {
        $dataMatkul = Matakuliah::all();
        return view('admin.matakuliah', compact('dataMatkul'));
    }

    public function matakuliahStore(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:8|unique:matakuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:50',
            'sks' => 'required|numeric|min:1|max:6',
        ]);

        Matakuliah::create($request->all());
        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    public function matakuliahUpdate(Request $request, $kode)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:50',
            'sks' => 'required|numeric|min:1|max:6',
        ]);

        $matkul = Matakuliah::where('kode_matakuliah', $kode)->firstOrFail();
        $matkul->update($request->all());

        return redirect()->back()->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function matakuliahDelete($kode)
    {
        Matakuliah::where('kode_matakuliah', $kode)->delete();
        return redirect()->back()->with('success', 'Mata Kuliah berhasil dihapus!');
    }

    // ====== 4. MANAGEMENT JADWAL PERKULIAHAN ======
    public function jadwalIndex()
    {
        // Ambil jadwal beserta relasi dosen dan matakuliah (Sesuai ERD)
        $dataJadwal = Jadwal::with(['dosen', 'matakuliah'])->get();
        $dataDosen = Dosen::all();
        $dataMatkul = Matakuliah::all();

        return view('admin.jadwal', compact('dataJadwal', 'dataDosen', 'dataMatkul'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
            'nidn' => 'required|string|exists:dosen,nidn',
            'kelas' => 'required|string|size:1',
            'hari' => 'required|string|max:10',
            'jam' => 'required',
        ]);

        Jadwal::create($request->all());
        return redirect()->back()->with('success', 'Jadwal perkuliahan berhasil diterbitkan!');
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
            'nidn' => 'required|string|exists:dosen,nidn',
            'kelas' => 'required|string|size:1',
            'hari' => 'required|string|max:10',
            'jam' => 'required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->back()->with('success', 'Jadwal perkuliahan berhasil diperbarui!');
    }

    public function jadwalDelete($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal perkuliahan berhasil dihapus!');
    }
}