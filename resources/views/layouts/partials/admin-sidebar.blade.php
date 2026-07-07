{{-- resources/views/layouts/partials/admin-sidebar.blade.php --}}
@props(['isOpen' => false])

<aside id="sidebar"
       class="fixed top-0 left-0 h-full bg-emerald-900 text-white z-40 shadow-xl overflow-y-auto overflow-x-visible transition-all duration-300 ease-in-out
              [scrollbar-width:thin] [scrollbar-color:#34d399_#064e3b]"
       style="width: {{ $isOpen ? '256px' : '72px' }};">

    {{-- Logo Area --}}
    <div class="sticky top-0 bg-emerald-900 z-10 border-b border-emerald-700 w-full">
        <div class="flex items-center px-3 h-16">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 shrink-0">
            <span class="logo-text ml-2 text-xl font-bold whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                  style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">
                PPP Admin
            </span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="px-2 pb-20 pt-2 relative">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item group flex items-center px-3 py-3 rounded-md hover:bg-emerald-700 transition-colors mb-1 relative {{ request()->routeIs('dashboard') ? 'bg-emerald-700/60' : '' }}">
            <i class="fas fa-tachometer-alt w-6 text-center shrink-0"></i>
            <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                  style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Dashboard</span>
            {{-- Tooltip --}}
            <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Dashboard</span>
        </a>

        {{-- Projects --}}
        @can('projects.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-project-diagram w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Projects</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Projects</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('projects.create')
                <a href="{{ route('admin.projects.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('projects.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Project</a>
                @endcan
                <a href="{{ route('admin.projects.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('projects.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Projects</a>
            </div>
        </div>
        @endcan

        {{-- Tenders --}}
        @can('tenders.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-file-signature w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Tenders</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Tenders</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('tenders.create')
                <a href="{{ route('admin.tenders.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.tenders.create') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Tender</a>
                @endcan
                <a href="{{ route('admin.tenders.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('tenders.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Tenders</a>
            </div>
        </div>
        @endcan

        {{-- News/Updates --}}
        @can('news.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-newspaper w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Updates</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Updates</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('news.create')
                <a href="{{ route('admin.updates.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.updates.create') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Update</a>
                @endcan
                <a href="{{ route('admin.updates.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.updates.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Updates</a>
            </div>
        </div>
        @endcan

        {{-- Downloads --}}
        @can('downloads.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-folder-open w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Downloads</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Downloads</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('downloads.create')
                <a href="{{ route('admin.downloads.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.downloads.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Download</a>
                @endcan
                <a href="{{ route('admin.downloads.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.downloads.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Downloads</a>
            </div>
        </div>
        @endcan

        {{-- Events --}}
        @can('events.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-images w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Events</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Events</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('events.create')
                <a href="{{ route('admin.events.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.events.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Events</a>
                @endcan
                <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.events.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Events</a>
            </div>
        </div>
        @endcan

        {{-- Sectors --}}
        @can('sectors.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-chart-pie w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Sectors</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Sectors</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('sectors.create')
                <a href="{{ route('admin.sectors.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.sectors.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Sector</a>
                @endcan
                <a href="{{ route('admin.sectors.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.sectors.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Sectors</a>
            </div>
        </div>
        @endcan

        {{-- Acronyms --}}
        @can('acronyms.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-font w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Acronyms</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Acronyms</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('acronyms.create')
                <a href="{{ route('admin.acronyms.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.acronyms.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Acronym</a>
                @endcan
                <a href="{{ route('admin.acronyms.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.acronyms.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Acronyms</a>
            </div>
        </div>
        @endcan

        {{-- Team --}}
        @can('team.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-users w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Team</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Team</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('team.create')
                <a href="{{ route('admin.team.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.team.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Team Member</a>
                @endcan
                <a href="{{ route('admin.team.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.team.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Team</a>
            </div>
        </div>
        @endcan

        {{-- Hierarchy --}}
        @can('hierarchy.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-sitemap w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Hierarchy</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Hierarchy</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('hierarchy.create')
                <a href="{{ route('admin.hierarchy.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.hierarchy.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Hierarchy</a>
                @endcan
                <a href="{{ route('admin.hierarchy.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.hierarchy.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Hierarchy</a>
            </div>
        </div>
        @endcan

        {{-- Leadership Messages --}}
        @can('leadership.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-quote-right w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Leadership</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Leadership</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('leadership.create')
                <a href="{{ route('admin.leadership.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.leadership.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Message</a>
                @endcan
                <a href="{{ route('admin.leadership.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.leadership.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Messages</a>
            </div>
        </div>
        @endcan

        {{-- Access Control Section --}}
        @canany(['users.view', 'roles.view'])
        <div class="my-3 border-t border-emerald-700/60"></div>

        <div class="px-3 mb-2 overflow-hidden transition-all duration-300"
             style="opacity: {{ $isOpen ? '1' : '0' }}; max-height: {{ $isOpen ? '30px' : '0' }};">
            <span class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Access Control</span>
        </div>

        {{-- Users --}}
        @can('users.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-users-cog w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Users</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Users</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('users.create')
                <a href="{{ route('admin.users.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.users.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add User</a>
                @endcan
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.users.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Users</a>
            </div>
        </div>
        @endcan

        {{-- Roles --}}
        @can('roles.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-user-shield w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Roles</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                {{-- Tooltip --}}
                <span class="tooltip-text {{ $isOpen ? 'hidden' : '' }}">Roles</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('roles.create')
                <a href="{{ route('admin.roles.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.roles.add') ? 'bg-emerald-700/60 font-medium' : '' }}">Add Role</a>
                @endcan
                <a href="{{ route('admin.roles.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.roles.index') ? 'bg-emerald-700/60 font-medium' : '' }}">Manage Roles</a>
            </div>
        </div>
        @endcan

        @endcanany
    </nav>
</aside>