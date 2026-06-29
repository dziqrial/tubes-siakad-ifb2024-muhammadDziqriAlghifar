<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD UTAS - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center antialiased selection:bg-indigo-500 selection:text-white">

    <div class="w-full max-w-md p-6 sm:p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600/10 mb-3 border border-indigo-500/20 shadow-lg shadow-indigo-500/5">
                <i class="fa-solid fa-graduation-cap text-3xl text-indigo-500"></i>
            </div>
            <h1 class="text-3xl font-extrabold tracking-wider text-white">SIAKAD UTAS</h1>
            <p class="text-sm text-gray-400 mt-1">Sistem Informasi Akademik Sederhana</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-6 sm:p-8 backdrop-blur-sm">
            
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-emerald-500 bg-emerald-500/10 border border-emerald-500/20 px-4 py-2 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-350">Alamat Email</label>
                    <div class="mt-1.5 relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-500 text-sm"></i>
                        </div>
                        <input id="email" class="block w-full pl-10 pr-4 py-2.5 bg-gray-950 text-white placeholder-gray-500 border border-gray-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg text-sm transition" 
                               type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@siakad.com / student.com" />
                    </div>
                    @if($errors->get('email'))
                        <p class="mt-2 text-rose-500 text-xs flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="mt-5">
                    <label for="password" class="block text-sm font-medium text-gray-350">Kata Sandi (Password)</label>
                    <div class="mt-1.5 relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-500 text-sm"></i>
                        </div>
                        <input id="password" class="block w-full pl-10 pr-4 py-2.5 bg-gray-950 text-white placeholder-gray-500 border border-gray-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg text-sm transition"
                               type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    </div>
                    @if($errors->get('password'))
                        <p class="mt-2 text-rose-500 text-xs flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="mt-5 flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded bg-gray-950 border-gray-800 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-gray-900" name="remember">
                        <span class="ms-2 text-xs text-gray-400 select-none hover:text-gray-300 transition">Ingat akun saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-gray-400 hover:text-indigo-400 transition" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-lg font-semibold text-sm tracking-wide transition shadow-lg shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        <i class="fa-solid fa-right-to-bracket mr-2 text-xs"></i> MASUK SEKARANG
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-gray-600 mt-8 font-mono tracking-wider">SIAKAD UTAS v1.0 • Project Tugas Besar Web II</p>
    </div>

</body>
</html>