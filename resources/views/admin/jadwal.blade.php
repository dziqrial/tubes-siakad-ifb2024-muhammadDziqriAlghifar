@extends('layouts.admin_theme')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-950/80 border border-emerald-500 text-emerald-200 rounded-xl text-sm shadow-md">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">Kelola Jadwal Kuliah</h1>
        </div>
        
        <a href="#form-tambah" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-4 py-2.5 rounded-xl transition shadow-md flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-plus"></i> Tambah Jadwal Baru
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <div class="xl:col-span-2 bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b border-gray-700 bg-gray-850">
                <h3 class="font-semibold text-gray-200"><i class="fa-solid fa-calendar-days mr-2 text-indigo-400"></i>Master Jadwal Kuliah</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs uppercase bg-gray-750 text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-center">Kelas</th>
                            <th class="px-4 py-3">Mata Kuliah</th>
                            <th class="px-4 py-3">Dosen Pengajar</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 bg-gray-800">
                        @forelse($dataJadwal as $j)
                            <tr class="hover:bg-gray-750/50 transition">
                                <td class="px-4 py-4 text-center">
                                    <span class="bg-indigo-900/40 text-indigo-400 border border-indigo-800 px-2.5 py-1 rounded-md text-xs font-black">
                                        {{ $j->kelas }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-white">{{ $j->matakuliah->nama_matakuliah }}</div>
                                    <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $j->kode_matakuliah }} • {{ $j->matakuliah->sks }} SKS</div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-300">
                                    <div>{{ $j->dosen->nama }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">NIDN: {{ $j->nidn }}</div>
                                </td>
                                <td class="px-4 py-4 text-xs">
                                    <div class="text-white font-medium">{{ $j->hari }}</div>
                                    <div class="text-emerald-400 font-mono mt-0.5">{{ date('H:i', strtotime($j->jam)) }} WIB</div>
                                    
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.jadwal.delete', $j->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini, bre?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-400 p-1.5 transition" title="Hapus Jadwal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada jadwal kuliah yang diterbitkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="form-tambah" class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5 h-fit space-y-4">
            <h3 class="font-bold text-gray-200 border-b border-gray-700 pb-3 flex items-center">
                <i class="fa-solid fa-square-plus mr-2 text-indigo-400"></i>Penerbitan Jadwal Baru
            </h3>

            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Mata Kuliah Relasi</label>
                    <select name="kode_matakuliah" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($dataMatkul as $m)
                            <option value="{{ $m->kode_matakuliah }}">{{ $m->kode_matakuliah }} - {{ $m->nama_matakuliah }} ({{ $m->sks }} SKS)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Dosen Pengajar</label>
                    <select name="nidn" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">-- Pilih Dosen Pengajar --</option>
                        @foreach($dataDosen as $d)
                            <option value="{{ $d->nidn }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kelas</label>
                        <select name="kelas" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Hari</label>
                        <select name="hari" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Jam Mulai Perkuliahan</label>
                    <input type="time" name="jam" required class="w-full bg-gray-750 border border-gray-600 rounded-xl px-3 py-2.5 text-sm text-black focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm py-3 rounded-xl transition shadow-lg mt-2">
                    <i class="fa-solid fa-paper-plane mr-1.5"></i> Publish Jadwal Kuliah
                </button>
            </form>
        </div>

    </div>
@endsection