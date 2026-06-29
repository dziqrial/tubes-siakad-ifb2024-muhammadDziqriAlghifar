@extends('layouts.admin_theme')

@section('content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-900/50 border border-emerald-500 text-emerald-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-900/50 border border-red-500 text-red-200 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div id="js-alert-error" class="hidden mb-4 p-4 bg-red-900/50 border border-red-500 text-red-200 rounded-lg text-sm"></div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-white">Kartu Rencana Studi (KRS)</h1>
        <p class="text-sm text-gray-400 mt-1">Pilih kelas kuliah, kelola daftar pilihan di keranjang sebelah kanan, lalu klik tombol **Apply** untuk memproses.</p>
    </div>

    <form action="{{ route('mahasiswa.krs.simpan') }}" method="POST" id="form-krs">
        @csrf
        <input type="hidden" name="npm" value="{{ $npm }}">
        
        <div id="hidden-inputs-container"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2">
                <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-5 border-b border-gray-700 bg-gray-850">
                        <h3 class="font-semibold text-gray-200">
                            <i class="fa-solid fa-list-check mr-2 text-indigo-400"></i>Daftar Jadwal Kuliah Tersedia
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs uppercase bg-gray-750 text-gray-400 border-b border-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-center">Kelas</th>
                                    <th class="px-4 py-3">Mata Kuliah</th>
                                    <th class="px-4 py-3">Dosen</th>
                                    <th class="px-4 py-3">Waktu</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700 bg-gray-800">
                                @php
                                    $namaMatkulFixDb = $krsDiambil->pluck('matakuliah.nama_matakuliah')->toArray();
                                @endphp

                                @forelse($jadwalTersedia as $index => $j)
                                    @php
                                        $sudahAdaDiDb = in_array($j->matakuliah->nama_matakuliah, $namaMatkulFixDb);
                                    @endphp

                                    <tr class="hover:bg-gray-750 transition duration-150 {{ $sudahAdaDiDb ? 'opacity-40 bg-gray-900/30' : '' }}" id="row-{{ $index }}">
                                        <td class="px-4 py-3 text-center">
                                            <span class="bg-emerald-900/30 text-emerald-400 border border-emerald-800/60 px-2 py-0.5 rounded text-xs font-bold">
                                                {{ $j->kelas }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-white">{{ $j->matakuliah->nama_matakuliah }}</div>
                                            <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $j->kode_matakuliah }} • {{ $j->matakuliah->sks }} SKS</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $j->dosen->nama }}</td>
                                        <td class="px-4 py-3 text-xs">
                                            <div>{{ $j->hari }}</div>
                                            <div class="text-indigo-300 font-mono">{{ date('H:i', strtotime($j->jam)) }} WIB</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($sudahAdaDiDb)
                                                <span class="text-xs text-emerald-400 font-medium font-mono"><i class="fa-solid fa-lock"></i> Aktif</span>
                                            @else
                                                <button type="button" 
                                                        onclick="tambahKeKeranjang('{{ $index }}', '{{ $j->kode_matakuliah }}', '{{ $j->matakuliah->nama_matakuliah }}', {{ $j->matakuliah->sks }}, '{{ $j->kelas }}')" 
                                                        id="btn-aksi-{{ $index }}" 
                                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-4 py-1.5 rounded-lg font-medium transition shadow-sm w-20 mx-auto block text-center">
                                                    + Pilih
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada jadwal kuliah aktif.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-5 flex flex-col justify-between min-h-[380px]">
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-200 border-b border-gray-700 pb-3 flex items-center">
                            <i class="fa-solid fa-basket-shopping mr-2 text-emerald-400"></i>Keranjang Pilihan KRS
                        </h3>
                        
                        <div id="keranjang-container" class="space-y-3 max-h-64 overflow-y-auto pr-1">
                            @foreach($krsDiambil as $k)
                                <div class="bg-gray-850 p-3 rounded-lg border border-emerald-950 flex justify-between items-center opacity-75">
                                    <div>
                                        <p class="text-sm font-medium text-white truncate w-40">{{ $k->matakuliah->nama_matakuliah }}</p>
                                        <p class="text-xs text-gray-400 font-mono">{{ $k->kode_matakuliah }} • {{ $k->matakuliah->sks }} SKS</p>
                                    </div>
                                    <span class="text-xs font-mono bg-emerald-950 text-emerald-400 border border-emerald-800 px-2 py-0.5 rounded-full">DB</span>
                                </div>
                            @endforeach

                            @if($krsDiambil->count() == 0)
                                <p class="text-sm text-gray-500 text-center py-4 id-placeholder" id="placeholder-text">Belum ada mata kuliah yang dipilih.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-850 p-4 rounded-xl border border-gray-700 flex items-center justify-between mt-6">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Total Beban SKS</p>
                            <p class="text-2xl font-black text-emerald-400 font-mono mt-1">
                                <span id="total-sks-display">{{ $krsDiambil->sum(function($k){ return $k->matakuliah->sks; }) }}</span> <span class="text-sm font-normal text-gray-400">/ 24</span>
                            </p>
                        </div>
                        
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm px-5 py-3 rounded-xl shadow-lg transition duration-150 flex items-center gap-1.5 border border-emerald-500/30">
                            <i class="fa-solid fa-circle-check text-base"></i> Apply
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <script>
        // Data SKS awal dari database
        let totalSksFixDb = {{ $krsDiambil->sum(function($k){ return $k->matakuliah->sks; }) }};
        let totalSksCurrent = totalSksFixDb;
        
        // Array global untuk mencatat apa saja yang ada di keranjang sementara saat ini
        let keranjangList = [];

        function tambahKeKeranjang(index, kodeMk, namaMk, sks, kelas) {
            const errorAlert = document.getElementById('js-alert-error');
            errorAlert.classList.add('hidden');

            // 1. Validasi Batas Maksimal 24 SKS
            if ((totalSksCurrent + sks) > 24) {
                errorAlert.innerText = `Gagal memilih! Penambahan [${namaMk}] seberat ${sks} SKS akan membuat total beban melampaui batas maksimal 24 SKS.`;
                errorAlert.classList.remove('hidden');
                return;
            }

            // 2. Tambah data ke array list keranjang
            keranjangList.push({ index, kodeMk, namaMk, sks, kelas });
            totalSksCurrent += sks;

            // 3. Ubah Tombol di Tabel Kiri jadi status Terpilih (disabled visual)
            const btnAksi = document.getElementById(`btn-aksi-${index}`);
            btnAksi.innerHTML = '<i class="fa-solid fa-check mr-1"></i> Terpilih';
            btnAksi.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            btnAksi.classList.add('bg-gray-600', 'cursor-not-allowed');
            btnAksi.disabled = true;

            // 4. Kunci otomatis tombol kelas lain yang nama matakuliah-nya sama
            lockSameMatakuliah(namaMk, index);

            // Render ulang isi tampilan keranjang kanan
            renderKeranjang();
        }

        function hapusDariKeranjang(kodeMk) {
            // Cari data di array
            const itemIndex = keranjangList.findIndex(item => item.kodeMk === kodeMk);
            if (itemIndex > -1) {
                const item = keranjangList[itemIndex];
                
                // Kurangi beban SKS saat ini
                totalSksCurrent -= item.sks;

                // Kembalikan tombol pilih di tabel kiri ke posisi semula
                const btnAksi = document.getElementById(`btn-aksi-${item.index}`);
                btnAksi.innerHTML = '+ Pilih';
                btnAksi.classList.remove('bg-gray-600', 'cursor-not-allowed');
                btnAksi.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                btnAksi.disabled = false;

                // Buka gembok kelas saingannya yang sempat terkunci
                unlockSameMatakuliah(item.namaMk, item.index);

                // Hapus data dari array list
                keranjangList.splice(itemIndex, 1);

                // Render ulang isi tampilan keranjang kanan
                renderKeranjang();
            }
        }

        function lockSameMatakuliah(namaMk, currentIndex) {
            // Cari seluruh button aksi pilih di halaman
            const semuaTombol = document.querySelectorAll('[id^="btn-aksi-"]');
            semuaTombol.forEach(btn => {
                const idx = btn.id.replace('btn-aksi-', '');
                // Jika tombol itu bukan tombol yang sedang diklik, tapi nama matkulnya sama
                if (idx !== currentIndex && btn.getAttribute('onclick')?.includes(`'${namaMk}'`)) {
                    btn.innerHTML = 'Terkunci';
                    btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    btn.classList.add('bg-gray-800', 'text-gray-500', 'opacity-30', 'cursor-not-allowed');
                    btn.disabled = true;
                }
            });
        }

        function unlockSameMatakuliah(namaMk, currentIndex) {
            const semuaTombol = document.querySelectorAll('[id^="btn-aksi-"]');
            semuaTombol.forEach(btn => {
                const idx = btn.id.replace('btn-aksi-', '');
                if (idx !== currentIndex && btn.getAttribute('onclick')?.includes(`'${namaMk}'`)) {
                    // Cek dulu apakah baris ini memang dikunci karena matkul saingannya, bukan karena matkul ini emang dari DB
                    if (btn.innerHTML === 'Terkunci') {
                        btn.innerHTML = '+ Pilih';
                        btn.classList.remove('bg-gray-800', 'text-gray-500', 'opacity-30', 'cursor-not-allowed');
                        btn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                        btn.disabled = false;
                    }
                }
            });
        }

        function renderKeranjang() {
            const container = document.getElementById('keranjang-container');
            const placeholder = document.getElementById('placeholder-text');
            const displaySks = document.getElementById('total-sks-display');
            const hiddenContainer = document.getElementById('hidden-inputs-container');

            // Update Angka Total SKS Utama
            displaySks.innerText = totalSksCurrent;

            // Hapus element-element draft dinamis sebelumnya (sisakan data bawaan DB)
            const itemDinamis = container.querySelectorAll('.js-draft-item');
            itemDinamis.forEach(el => el.remove());

            // Kosongkan container input tersembunyi form
            hiddenContainer.innerHTML = '';

            if (keranjangList.length > 0) {
                if (placeholder) placeholder.classList.add('hidden');

                keranjangList.forEach(item => {
                    // 1. Tambah Card Visual di Keranjang Sebelah Kanan dengan Tombol Sampah Merah
                    const card = document.createElement('div');
                    card.className = 'js-draft-item bg-gray-750 p-3 rounded-lg border border-gray-700 flex justify-between items-center transition animate-fadeIn';
                    card.innerHTML = `
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="bg-indigo-950 text-indigo-400 px-1.5 py-0.2 rounded text-[10px] font-bold font-mono">${item.kelas}</span>
                                <p class="text-sm font-medium text-white truncate w-36">${item.namaMk}</p>
                            </div>
                            <p class="text-xs text-gray-400 font-mono mt-0.5">${item.kodeMk} • ${item.sks} SKS</p>
                        </div>
                        <button type="button" onclick="hapusDariKeranjang('${item.kodeMk}')" class="text-gray-500 hover:text-red-400 p-1.5 transition" title="Hapus dari pilihan">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    `;
                    container.appendChild(card);

                    // 2. Suntik Input ke dalam HTML DOM Form agar datanya ikut terkirim saat disubmit
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'matakuliah_pilihan[]';
                    hiddenInput.value = item.kodeMk;
                    hiddenContainer.appendChild(hiddenInput);
                });
            } else {
                if (placeholder) placeholder.classList.remove('hidden');
            }
        }

        // Validasi tombol apply kalau keranjang masih kosong melompong
        document.getElementById('form-krs').addEventListener('submit', function(e) {
            if (keranjangList.length === 0) {
                e.preventDefault();
                const errorAlert = document.getElementById('js-alert-error');
                errorAlert.innerText = 'Keranjang pilihan kamu kosong, bre! Pilih minimal 1 mata kuliah dulu sebelum menekan Apply.';
                errorAlert.classList.remove('hidden');
            }
        });
    </script>
@endsection