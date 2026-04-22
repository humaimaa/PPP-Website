{{-- resources/views/components/sidebar.blade.php --}}
@props(['isOpen' => false])

<aside id="sidebar" 
       class="sidebar overflow-x-hidden fixed top-0 left-0 h-full bg-emerald-900 text-white z-40 shadow-xl transition-all duration-300 ease-in-out overflow-y-auto"
       style="width: {{ $isOpen ? '256px' : '72px' }};">
    
    {{-- Logo Area --}}
    <div class="flex items-center justify-between px-3 py-4 border-b border-emerald-700 h-16">
        <div class="flex items-center justify-center w-full overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 shrink-0">
            <span class="logo-text ml-2 text-xl font-bold whitespace-nowrap transition-all duration-300 ease-in-out"
                  style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">
                PPP Admin
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="mt-6 px-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="nav-item group flex items-center px-3 py-3 rounded-md hover:bg-emerald-700 transition-colors mb-1 relative">
            <i class="fas fa-tachometer-alt w-6 h-6 shrink-0"></i>
            <span class="nav-text ml-3 whitespace-nowrap transition-all duration-300 ease-in-out"
                  style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">Dashboard</span>
            @if(!$isOpen)
                <div class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap z-50">
                    Dashboard
                </div>
            @endif
        </a>

       
        <!-- Projects -->
        <div class="relative mb-1">
            <button class="dropdown-btn w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left">
                <div class="flex items-center">
                    <i class="fas fa-project-diagram w-6 h-6 shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">Projects</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200"
                   style="opacity: {{ $isOpen ? '1' : '0' }}; transform: rotate(0deg);"></i>
            </button>
            <div class="dropdown-content ml-9 pl-2 border-l-2 border-emerald-600/50 overflow-hidden transition-all duration-300"
                 style="max-height: 0; {{ !$isOpen ? 'display: none;' : '' }}">
                <a href="{{ route('admin.projects.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Add Project</a>
                <a href="{{ route('admin.projects.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Manage Projects</a>
            </div>
        </div>

        <!-- Tenders -->
        <div class="relative mb-1">
            <button class="dropdown-btn w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left">
                <div class="flex items-center">
                    <i class="fas fa-file-signature w-6 h-6 shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">Tenders</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
            </button>
            <div class="dropdown-content ml-9 pl-2 border-l-2 border-emerald-600/50 overflow-hidden transition-all duration-300"
                 style="max-height: 0; {{ !$isOpen ? 'display: none;' : '' }}">
                <a href="{{ route('admin.tenders.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Add Tender</a>
                <a href="{{ route('admin.tenders.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Manage Tenders</a>
            </div>
        </div>

        <!-- News -->
        <div class="relative mb-1">
            <button class="dropdown-btn w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left">
                <div class="flex items-center">
                    <i class="fas fa-newspaper w-6 h-6 shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">Updates</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
            </button>
            <div class="dropdown-content ml-9 pl-2 border-l-2 border-emerald-600/50 overflow-hidden transition-all duration-300"
                 style="max-height: 0; {{ !$isOpen ? 'display: none;' : '' }}">
                <a href="{{ route('admin.updates.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Add Updates</a>
                <a href="{{ route('admin.updates.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Manage Updates</a>
            </div>
        </div>

        <!-- Documents -->
        <div class="relative mb-1">
            <button class="dropdown-btn w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left">
                <div class="flex items-center">
                    <i class="fas fa-folder-open w-6 h-6 shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; width: {{ $isOpen ? 'auto' : '0' }}; overflow: hidden;">Documents</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
            </button>
            <div class="dropdown-content ml-9 pl-2 border-l-2 border-emerald-600/50 overflow-hidden transition-all duration-300"
                 style="max-height: 0; {{ !$isOpen ? 'display: none;' : '' }}">
                <a href="#" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Add Document</a>
                <a href="#" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1">Manage Documents</a>
            </div>
        </div>
    </nav>
</aside>