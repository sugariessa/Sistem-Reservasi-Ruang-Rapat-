<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Reservasi Ruang Rapat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-dark-red { background-color: #7f1d1d; }
        .bg-cream-50 { background-color: #fefdf8; }
        .bg-cream-100 { background-color: #f9f6f0; }
        .bg-cream-200 { background-color: #f5f2e8; }
        .border-cream-200 { border-color: #f5f2e8; }
        .text-dark-red { color: #7f1d1d; }
        .border-dark-red { border-color: #7f1d1d; }
        .hover-dark-red:hover { background-color: #991b1b; }
    </style>
</head>
<body class="bg-cream-100 min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-md">
        <div class="bg-cream-50 rounded-lg shadow-2xl overflow-hidden border border-cream-200">
            <div class="bg-dark-red px-6 py-8 text-center">
                <i class="fas fa-user-plus text-white text-4xl mb-4"></i>
                <h1 class="text-white text-2xl font-bold">Daftar Akun Baru</h1>
                <p class="text-red-100 text-sm mt-2">Buat akun untuk reservasi ruang rapat</p>
            </div>
            
            <div class="px-6 py-8">
                <div class="mb-4">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-gray-600 hover:text-dark-red transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
                
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Registrasi Gagal',
                            html: '@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach',
                            confirmButtonColor: '#7f1d1d'
                        });
                    </script>
                @endif
                
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Registrasi Berhasil!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#7f1d1d'
                        });
                    </script>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-user text-gray-400 mr-2"></i>Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"
                               placeholder="Masukkan email Anda">
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"
                               placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>Konfirmasi Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"
                               placeholder="Ulangi password Anda">
                    </div>

                    <button type="submit" 
                            class="w-full bg-dark-red text-white py-3 px-4 rounded-lg font-medium hover-dark-red transition duration-200 transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-dark-red hover:underline font-medium">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>