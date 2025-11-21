<div class="bg-dark-red w-64 min-h-screen flex flex-col">
    <div class="p-6 border-b border-red-800">
        <h1 class="text-white text-xl font-bold flex items-center">
            <i class="fas fa-cog mr-3"></i>Admin Panel
        </h1>
    </div>
    
    <nav class="flex-1 px-4 py-6">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-800 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-800 transition duration-200 {{ request()->routeIs('admin.users') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-users mr-3"></i>Data Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rooms') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-800 transition duration-200 {{ request()->routeIs('admin.rooms') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-door-open mr-3"></i>Data Ruangan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reservations') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-800 transition duration-200 {{ request()->routeIs('admin.reservations') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-calendar-check mr-3"></i>Reservasi
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="p-4 border-t border-red-800">
        <button onclick="openModal('logoutModal')" class="w-full flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-800 transition duration-200">
            <i class="fas fa-sign-out-alt mr-3"></i>Logout
        </button>
        
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
            @csrf
        </form>
    </div>
</div>