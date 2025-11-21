<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        
        /* Navbar styling */
        .navbar-fixed { height: 80px; }
        .content-with-navbar { margin-top: 80px; }
        
        /* Page header styling */
        .page-header {
            background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
        }
        
        @media (max-width: 768px) {
            .navbar-fixed { height: 72px; }
            .content-with-navbar { margin-top: 72px; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.navbar.user_navbar')
    
    <div class="page-header content-with-navbar py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center text-white">
                <h1 class="text-3xl md:text-4xl font-bold mb-3">@yield('page-title', 'Dashboard')</h1>
                <p class="text-lg opacity-90 max-w-2xl mx-auto">@yield('page-subtitle', 'Kelola reservasi ruangan dengan mudah dan efisien')</p>
            </div>
        </div>
    </div>
    
    <main class="bg-gray-50 min-h-screen px-6 py-8">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                </script>
            @endif
            
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                </script>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-6 w-11/12 md:w-96 shadow-2xl rounded-xl bg-white">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Konfirmasi Logout</h3>
                <p class="text-gray-600 mb-8">Apakah Anda yakin ingin keluar dari sistem?</p>
                
                <div class="flex justify-center space-x-3">
                    <button onclick="closeModal('logoutModal')" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
                        Batal
                    </button>
                    <button onclick="document.getElementById('logoutForm').submit()" class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                        Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    
    <script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    </script>
</body>
</html>