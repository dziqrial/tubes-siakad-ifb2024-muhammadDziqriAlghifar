<aside class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col justify-between hidden md:flex">
    <div>
        <div class="h-16 flex items-center justify-center bg-gray-850 border-b border-gray-700 px-6">
            <span class="text-xl font-bold tracking-wider text-indigo-450"><i class="fa-solid fa-graduation-cap mr-2"></i>SIAKAD UTAS</span>
        </div>
        
        <nav class="mt-6 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                <i class="fa-solid fa-gauge mr-3 w-5 text-center"></i> Dashboard
            </a>

            @role('admin')
                <div class="pt-4 pb-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Admin</p>
                </div>
                
                <a href="{{ route('admin.dosen.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dosen.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fa-solid fa-chalkboard-user mr-3 w-5 text-center text-indigo-400"></i> Kelola Dosen
                </a>

                <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fa-solid fa-user-graduate mr-3 w-5 text-center text-emerald-400"></i> Kelola Mahasiswa
                </a>

                <a href="{{ route('admin.matakuliah.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.matakuliah.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fa-solid fa-book-bookmark mr-3 w-5 text-center text-amber-400"></i> Mata Kuliah
                </a>

                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.jadwal.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days mr-3 w-5 text-center text-rose-400"></i> Kelola Jadwal
                </a>
            @endrole

            @role('mahasiswa')
                <div class="pt-4 pb-1">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Mahasiswa</p>
                </div>
                <a href="{{ route('mahasiswa.krs.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('mahasiswa.krs.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fa-solid fa-file-signature mr-3 w-5 text-center"></i> Pengisian KRS
                </a>
            @endrole
        </nav>
    </div>

    <div class="p-4 border-t border-gray-700 bg-gray-850">
        <div class="flex items-center justify-between">
            <div class="truncate mr-2">
                <p class="text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 uppercase tracking-tight font-mono">Role: {{ Auth::user()->roles->first()->name ?? 'None' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-400 p-2 rounded-lg hover:bg-gray-700 transition" title="Logout">
                    <i class="fa-solid fa-power-off text-base"></i>
                </button>
            </form>
        </div>
    </div>
</aside>