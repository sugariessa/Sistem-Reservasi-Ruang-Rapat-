<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reservasi Ruang Rapat')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-dark-red { background-color: #7f1d1d; }
        .bg-cream-50 { background-color: #fefdf8; }
        .bg-cream-100 { background-color: #f9f6f0; }
        .bg-cream-200 { background-color: #f5f2e8; }
        .text-dark-red { color: #7f1d1d; }
        .border-dark-red { border-color: #7f1d1d; }
        .hover-dark-red:hover { background-color: #991b1b; }
    </style>
</head>
<body class="bg-cream-100 min-h-screen">
    <nav class="bg-dark-red shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center">
                    <i class="fas fa-building text-white text-2xl mr-3"></i>
                    <h1 class="text-white text-xl font-bold">Reservasi Ruang Rapat</h1>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-red-200 transition duration-200">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-8">
        @yield('content')
    </main>
</body>
</html>