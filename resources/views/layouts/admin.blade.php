<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
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
        .hover-dark-red:hover { background-color: #991b1b; }
        .sidebar-active { background-color: #991b1b; }
    </style>
</head>
<body class="bg-cream-100">
    <div class="flex h-screen">
        @include('layouts.navbar.admin_navbar')
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-cream-50 shadow-sm border-b border-cream-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <div class="w-8 h-8 bg-dark-red rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
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
            </main>
        </div>
    </div>
    
    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-lg bg-cream-50">
            <div class="mt-3 text-center">
                <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Logout</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
                
                <div class="flex justify-center space-x-3">
                    <button onclick="closeModal('logoutModal')" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-200">
                        Batal
                    </button>
                    <button onclick="document.getElementById('logoutForm').submit()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    
    // Konfirmasi hapus dengan SweetAlert
    function confirmDelete(url, itemName = 'item ini') {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus ${itemName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    // Konfirmasi aksi umum
    function confirmAction(url, title, text, method = 'POST') {
        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7f1d1d',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                if (method !== 'POST') {
                    form.innerHTML = `
                        @csrf
                        @method('${method}')
                    `;
                } else {
                    form.innerHTML = '@csrf';
                }
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
</body>
</html>