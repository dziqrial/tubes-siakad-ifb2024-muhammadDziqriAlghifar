@extends('layouts.admin_theme')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-900/50 border border-emerald-500 text-emerald-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Dashboard Akademik</h1>
            <p class="text-sm text-gray-400 mt-1">Berikut adalah Kartu Rencana Studi (KRS) resmi kamu yang telah aktif.</p>
        </div>
        
        @if($krsDiambil->count() > 0)
            <form action="{{ route('mahasiswa.krs.reset') }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus seluruh KRS saat ini dan mengisi ulang dari awal?')">
                @csrf
                <input type="hidden" name="npm" value="{{ $npm }}">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-4 py-2.5 rounded-lg shadow transition flex items-center">
                    <i class="fa-solid fa-arrow-rotate-left mr-2"></i> Kosongkan & Isi Ulang KRS
                </button>
            </form>
        @endif
    </div>
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
    <div class="flex items-center gap-4">
        <div class="p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl text-2xl">
            <i class="fa-solid fa-file-pdf"></i>
        </div>
        <div>
            <h4 class="text-base font-bold text-white">Unduh Lembar KRS Resmi</h4>
            <p class="text-xs text-gray-400 mt-0.5">Cetak Kartu Rencana Studi format PDF resmi untuk keperluan arsip perwalian dosen.</p>
        </div>
    </div>
    
    <a href="{{ route('mahasiswa.krs.pdf') }}" class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-500 hover:to-amber-500 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-lg transition duration-150 flex items-center justify-center gap-2 border border-red-500/20">
        <i class="fa-solid fa-download"></i> Cetak KRS (PDF)
    </a>
</div>
    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="p-5 border-b border-gray-700 bg-gray-850 flex items-center justify-between">
            <h3 class="font-semibold text-gray-200">
                <i class="fa-solid fa-graduation-cap mr-2 text-indigo-400"></i>KRS Terbaca di Sistem
            </h3>
            <span class="bg-indigo-950 text-indigo-400 border border-indigo-800 px-3 py-1 rounded-full text-xs font-mono font-bold">
                Total: {{ $krsDiambil->sum(function($k) { return $k->matakuliah->sks; }) }} / 24 SKS
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs uppercase bg-gray-750 text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="px-6 py-4">Kode Matkul</th>
                        <th class="px-6 py-4">Nama Mata Kuliah</th>
                        <th class="px-6 py-4 text-center">SKS</th>
                        <th class="px-6 py-4">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 bg-gray-800">
                    @forelse($krsDiambil as $k)
                        <tr class="hover:bg-gray-750 transition duration-150">
                            <td class="px-6 py-4 font-mono text-indigo-400 font-bold">{{ $k->kode_matakuliah }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $k->matakuliah->nama_matakuliah }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono">{{ $k->matakuliah->sks }} SKS</td>
                            <td class="px-6 py-4">
                                <span class="bg-emerald-950 text-emerald-400 border border-emerald-800 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Terkunci di KRS
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-regular fa-folder-open text-3xl text-gray-600"></i>
                                    <p>Kamu belum mengambil mata kuliah apapun untuk semester ini.</p>
                                    <a href="{{ route('mahasiswa.krs.index') }}" class="text-xs text-indigo-400 hover:underline mt-1">
                                        Silakan menuju halaman Pengisian KRS &rarr;
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection