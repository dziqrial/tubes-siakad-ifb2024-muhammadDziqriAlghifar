@extends('layouts.admin_theme')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-white">Dashboard Admin</h1>
        <p class="text-sm text-gray-400 mt-1">Selamat datang kembali! Berikut ringkasan data master SIAKAD saat ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Total Dosen</p>
                <p class="text-3xl font-black text-white font-mono mt-1">{{ $countDosen }}</p>
            </div>
            <div class="p-3 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-xl text-xl">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Mahasiswa</p>
                <p class="text-3xl font-black text-white font-mono mt-1">{{ $countMahasiswa }}</p>
            </div>
            <div class="p-3 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl text-xl">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Mata Kuliah</p>
                <p class="text-3xl font-black text-white font-mono mt-1">{{ $countMatkul }}</p>
            </div>
            <div class="p-3 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-xl text-xl">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Jadwal Kuliah</p>
                <p class="text-3xl font-black text-white font-mono mt-1">{{ $countJadwal }}</p>
            </div>
            <div class="p-3 bg-rose-500/10 text-rose-400 border border-rose-500/20 rounded-xl text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-gray-800 to-gray-850 border border-gray-700 rounded-xl p-6 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="p-4 bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 rounded-xl text-2xl">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Pemantauan Pengisian KRS</h3>
                <p class="text-sm text-gray-400 mt-0.5">Saat ini sebanyak <span class="text-emerald-400 font-bold font-mono">{{ $totalKrsPenuh }}</span> mahasiswa terdeteksi telah berhasil melakukan pengisian dan penguncian formulir rencana studi.</p>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('admin.jadwal.index') }}" class="w-full text-center bg-gray-700 hover:bg-gray-650 border border-gray-600 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition">Kelola Jadwal</a>
        </div>
    </div>
@endsection