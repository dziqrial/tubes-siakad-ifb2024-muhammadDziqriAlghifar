<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-graduation-cap text-2xl text-indigo-400"></i>
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white">
                        <i class="fa-solid fa-gauge-high mr-1.5 text-xs"></i> {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')" class="text-gray-300 hover:text-white">
                            <i class="fa-solid fa-chalkboard-user mr-1.5 text-xs text-indigo-400"></i> Kelola Dosen
                        </x-nav-link>

                        <x-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.mahasiswa.*')" class="text-gray-300 hover:text-white">
                            <i class="fa-solid fa-user-graduate mr-1.5 text-xs text-emerald-400"></i> Kelola Mahasiswa
                        </x-nav-link>

                        <x-nav-link :href="route('admin.matakuliah.index')" :active="request()->routeIs('admin.matakuliah.*')" class="text-gray-300 hover:text-white">
                            <i class="fa-solid fa-book-bookmark mr-1.5 text-xs text-amber-400"></i> Mata Kuliah
                        </x-nav-link>

                        <x-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')" class="text-gray-300 hover:text-white">
                            <i class="fa-solid fa-calendar-days mr-1.5 text-xs text-rose-400"></i> Jadwal Kuliah
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-user text-base text-gray-400"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 bg-gray-700 border border-gray-600 text-gray-300 rounded font-bold uppercase tracking-wider">
                                    {{ Auth::user()->hasRole('admin') ? 'Admin' : 'Mahasiswa' }}
                                </span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-850 border-t border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')" class="text-gray-300">
                    Kelola Dosen
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.mahasiswa.*')" class="text-gray-300">
                    Kelola Mahasiswa
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.matakuliah.index')" :active="request()->routeIs('admin.matakuliah.*')" class="text-gray-300">
                    Mata Kuliah
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')" class="text-gray-300">
                    Jadwal Kuliah
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-400">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>