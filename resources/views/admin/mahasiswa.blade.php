@extends('layouts.admin_theme')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-950/80 border border-emerald-500 text-emerald-200 rounded-xl text-sm"><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Data Mahasiswa</h1>
        </div>
        <a href="#form-entry" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-700 bg-gray-850"><h3 class="font-semibold text-gray-200"><i class="fa-solid fa-users mr-2 text-indigo-400"></i>Master Mahasiswa</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-750 text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="px-4 py-3">NPM</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">Dosen Wali</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 bg-gray-800">
                        @forelse($dataMahasiswa as $m)
                            <tr class="hover:bg-gray-750/40 transition">
                                <td class="px-4 py-4 font-mono text-indigo-400 font-bold text-sm">{{ $m->npm }}</td>
                                <td class="px-4 py-4 font-semibold text-white text-sm">{{ $m->nama }}</td>
                                <td class="px-4 py-4 text-xs text-gray-400">
                                    <div class="text-gray-300 font-medium">{{ $m->dosenWali->nama ?? 'Tidak Ada' }}</div>
                                    <div class="font-mono mt-0.5 text-gray-500">NIDN: {{ $m->nidn }}</div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <form action="{{ route('admin.mahasiswa.delete', $m->npm) }}" method="POST" onsubmit="return confirm('Hapus record mahasiswa ini? Log kartu KRS bersangkutan juga akan hilang total.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-400 p-1.5 transition"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data mahasiswa terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="form-entry" class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5 h-fit space-y-4">
            <h3 class="font-bold text-gray-200 border-b border-gray-700 pb-3 flex items-center"><i class="fa-solid fa-user-plus mr-2 text-indigo-400"></i>Penerimaan Mahasiswa Baru</h3>
            <form action="{{ route('admin.mahasiswa.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">NPM (Wajib 10 Digit)</label>
                    <input type="text" name="npm" maxlength="10" required placeholder="Contoh: 2455201001" class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap Mahasiswa</label>
                    <input type="text" name="nama" required placeholder="Contoh: Muhammad Dziqri Alghifar" class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Plotting Dosen Wali</label>
                    <select name="nidn" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Hubungkan Dosen Wali --</option>
                        @foreach($dataDosen as $d)
                            <option value="{{ $d->nidn }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm py-3 rounded-xl transition shadow-lg"><i class="fa-solid fa-user-check mr-1.5"></i> Aktivasi Akun Mahasiswa</button>
            </form>
        </div>
    </div>
@endsection