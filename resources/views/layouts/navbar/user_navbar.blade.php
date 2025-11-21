<nav class="bg-white shadow-lg fixed w-full top-0 z-40 navbar-fixed border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <div class="bg-red-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-gray-900 text-lg font-bold">Reservasi Ruang Rapat</h1>
                    <p class="text-gray-500 text-xs">Sistem Manajemen Ruangan</p>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('user.dashboard') }}" 
                   class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                    <i class="fas fa-home mr-2 text-sm"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('user.rooms') }}" 
                   class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.rooms') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                    <i class="fas fa-door-open mr-2 text-sm"></i>
                    <span class="font-medium">Ruangan</span>
                </a>
                <a href="{{ route('user.reservations') }}" 
                   class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.reservations*') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                    <i class="fas fa-calendar-check mr-2 text-sm"></i>
                    <span class="font-medium">Reservasi</span>
                </a>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                
                <div class="hidden md:flex items-center space-x-3">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    <div class="w-px h-6 bg-gray-300"></div>
                </div>
                
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center text-gray-700 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition duration-200">
                        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-2 hidden md:block"></i>
                    </button>
                    
                    <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 hidden">
                        <div class="py-2">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <button onclick="openModal('logoutModal')" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition duration-200 flex items-center">
                                <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                                <span>Logout</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 shadow-lg hidden">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('user.dashboard') }}" 
               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                <i class="fas fa-home mr-3 text-sm"></i>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('user.rooms') }}" 
               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.rooms') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                <i class="fas fa-door-open mr-3 text-sm"></i>
                <span class="font-medium">Ruangan</span>
            </a>
            <a href="{{ route('user.reservations') }}" 
               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-200 {{ request()->routeIs('user.reservations*') ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                <i class="fas fa-calendar-check mr-3 text-sm"></i>
                <span class="font-medium">Reservasi</span>
            </a>
            <div class="border-t border-gray-200 pt-3 mt-3">
                <div class="px-3 py-2">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <button onclick="openModal('logoutModal')" class="flex items-center w-full px-3 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition duration-200">
                    <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    document.getElementById('userDropdown').classList.toggle('hidden');
}

function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}

// Close dropdown and mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const mobileMenu = document.getElementById('mobileMenu');
    const button = event.target.closest('button');
    
    if (!button || (!button.onclick || (button.onclick.toString().indexOf('toggleDropdown') === -1 && button.onclick.toString().indexOf('toggleMobileMenu') === -1))) {
        dropdown.classList.add('hidden');
        mobileMenu.classList.add('hidden');
    }
});
</script>