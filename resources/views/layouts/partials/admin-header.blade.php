{{-- resources/views/components/header.blade.php --}}
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
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">A</div>
                <span class="text-gray-700 font-medium hidden sm:inline-block">Admin User</span>
                <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-200"></i>
            </button>
            <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-gray-100">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-user-circle mr-2"></i> My Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-cog mr-2"></i> Settings</a>
                <hr class="my-1">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
        </div>
    </div>
</header>

{{-- Hidden Logout Form --}}
<form id="logoutForm" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
    @csrf
</form>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden transition-opacity duration-300"></div>