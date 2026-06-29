@extends('layouts.admin_theme')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-950/80 border border-emerald-500 text-emerald-200 rounded-xl text-sm"><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Mata Kuliah</h1>
        </div>
        <a href="#form-entry" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-plus"></i> Tambah Mata Kuliah
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-700 bg-gray-850"><h3 class="font-semibold text-gray-200"><i class="fa-solid fa-book mr-2 text-indigo-400"></i>Katalog Kurikulum</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-750 text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="px-6 py-3">Kode MK</th>
                            <th class="px-6 py-3">Nama Mata Kuliah</th>
                            <th class="px-6 py-3 text-center">Bobot Beban</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 bg-gray-800">
                        @forelse($dataMatkul as $m)
                            <tr class="hover:bg-gray-750/40 transition">
                                <td class="px-6 py-4 font-mono text-indigo-400 font-bold text-sm">{{ $m->kode_matakuliah }}</td>
                                <td class="px-6 py-4 font-semibold text-white text-sm">{{ $m->nama_matakuliah }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-emerald-950 text-emerald-400 border border-emerald-800 px-2.5 py-0.5 rounded-md font-mono text-xs font-bold">
                                        {{ $m->sks }} SKS
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.matakuliah.delete', $m->kode_matakuliah) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini? Seluruh jadwal dan isian KRS mahasiswa terkait otomatis ikut terhapus cascading.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-400 p-1.5 transition"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Kurikulum prodi masih kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="form-entry" class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5 h-fit space-y-4">
            <h3 class="font-bold text-gray-200 border-b border-gray-700 pb-3 flex items-center"><i class="fa-solid fa-bookmark mr-2 text-indigo-400"></i>Input Mata Kuliah Baru</h3>
            <form action="{{ route('admin.matakuliah.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kode MK (Maksimal 8 Karakter)</label>
                    <input type="text" name="kode_matakuliah" maxlength="8" required placeholder="Contoh: IF45123" class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none font-mono uppercase">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Nama Mata Kuliah</label>
                    <input type="text" name="nama_matakuliah" required placeholder="Contoh: Pemrograman Web II" class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Bobot SKS Ambilan</label>
                    <select name="sks" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 outline-none font-mono">
                        <option value="1">1 SKS</option>
                        <option value="2">2 SKS</option>
                        <option value="3" selected>3 SKS</option>
                        <option value="4">4 SKS</option>
                        <option value="6">6 SKS</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm py-3 rounded-xl transition shadow-lg"><i class="fa-solid fa-save mr-1.5"></i> Daftarkan Mata Kuliah</button>
            </form>
        </div>
    </div>
@endsection