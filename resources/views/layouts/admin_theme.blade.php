<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD - Tugas Besar Web II</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-y-auto">
            
            @include('layouts.partials.topbar')

            <main class="p-6">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>