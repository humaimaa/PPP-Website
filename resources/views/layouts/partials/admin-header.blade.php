<header id="mainHeader" 
        class="fixed top-0 right-0 bg-white shadow-md z-30 transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center gap-3">
            {{-- Single Toggle Button for all screen sizes --}}
            <button id="sidebarToggle" 
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition duration-300 cursor-pointer focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        {{-- User Profile Dropdown --}}
        <div class="relative">
            <button id="userMenuButton" class="flex items-center space-x-3 focus:outline-none cursor-pointer">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </div>
                <span class="text-gray-700 font-medium hidden sm:inline-block">{{ Auth::user()->name ?? 'Admin User' }}</span>
                <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-200"></i>
            </button>
            <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                </div>
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user-circle mr-3 text-emerald-600"></i> My Profile
                </a>
                <hr class="my-1">
                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden transition-opacity duration-300"></div>