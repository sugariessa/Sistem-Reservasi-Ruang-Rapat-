<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Ruang Rapat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-red': '#7f1d1d',
                        'cream': {
                            50: '#fefdf8',
                            100: '#fdf8e8',
                            200: '#faf0d0',
                            300: '#f6e7b8'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-cream-50 to-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-dark-red text-2xl mr-2"></i>
                        <span class="font-bold text-xl text-gray-900">RoomReserve</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-dark-red px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-dark-red text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-800 transition duration-200">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                        Kelola Reservasi 
                        <span class="text-dark-red">Ruang Rapat</span> 
                        dengan Mudah
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistem reservasi ruang rapat yang efisien dan user-friendly. Pesan ruangan, kelola jadwal, dan pantau ketersediaan dalam satu platform terintegrasi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-dark-red text-white rounded-lg text-lg font-semibold hover:bg-red-800 transition duration-200 shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>
                            Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-dark-red text-dark-red rounded-lg text-lg font-semibold hover:bg-dark-red hover:text-white transition duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition duration-300">
                        <div class="bg-gradient-to-r from-dark-red to-red-600 rounded-lg p-6 text-white mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg">Ruang Meeting A</h3>
                                    <p class="text-red-100">Lantai 2, Gedung Utama</p>
                                </div>
                                <i class="fas fa-door-open text-3xl opacity-80"></i>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Kapasitas</span>
                                <span class="font-semibold">20 orang</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Status</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Nikmati kemudahan mengelola reservasi ruang rapat dengan fitur-fitur canggih yang kami sediakan
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-check text-dark-red text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Reservasi Mudah</h3>
                    <p class="text-gray-600">Pesan ruangan dengan beberapa klik. Interface yang intuitif dan proses yang cepat.</p>
                </div>
                
                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Real-time Status</h3>
                    <p class="text-gray-600">Pantau ketersediaan ruangan secara real-time dan hindari konflik jadwal.</p>
                </div>
                
                <div class="text-center p-8 rounded-xl hover:shadow-lg transition duration-300">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Multi User</h3>
                    <p class="text-gray-600">Kelola akses untuk admin dan user dengan sistem role yang terorganisir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-dark-red to-red-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Memulai Reservasi Ruangan?
            </h2>
            <p class="text-xl text-red-100 mb-8">
                Bergabunglah dengan sistem reservasi ruang rapat yang efisien dan terpercaya
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-dark-red rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-200 shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white rounded-lg text-lg font-semibold hover:bg-white hover:text-dark-red transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sudah Punya Akun?
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-building text-dark-red text-2xl mr-2"></i>
                    <span class="font-bold text-xl">RoomReserve</span>
                </div>
                <p class="text-gray-400 mb-6">
                    Sistem Reservasi Ruang Rapat yang Efisien dan Terpercaya
                </p>
                <div class="border-t border-gray-800 pt-6">
                    <p class="text-gray-500 text-sm">
                        © 2025 RoomReserve. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>