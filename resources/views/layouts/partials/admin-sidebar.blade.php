{{-- resources/views/layouts/partials/admin-sidebar.blade.php --}}
@props(['isOpen' => false])

<aside id="sidebar"
       class="fixed top-0 left-0 h-full bg-emerald-900 text-white z-40 shadow-xl overflow-y-auto overflow-x-hidden transition-all duration-300 ease-in-out
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
    <nav class="px-2 pb-20 pt-2">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item group flex items-center px-3 py-3 rounded-md hover:bg-emerald-700 transition-colors mb-1 relative">
            <i class="fas fa-tachometer-alt w-6 text-center shrink-0"></i>
            <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                  style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Dashboard</span>
            {{-- Tooltip (only shown when sidebar is closed) --}}
            <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                         opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                         {{ $isOpen ? 'hidden' : '' }}">Dashboard</span>
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Projects</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('projects.create')
                <a href="{{ route('admin.projects.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Project</a>
                @endcan
                <a href="{{ route('admin.projects.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Projects</a>
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Tenders</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('tenders.create')
                <a href="{{ route('admin.tenders.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Tender</a>
                @endcan
                <a href="{{ route('admin.tenders.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Tenders</a>
            </div>
        </div>
        @endcan

        {{-- Updates --}}
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Updates</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('news.create')
                <a href="{{ route('admin.updates.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Updates</a>
                @endcan
                <a href="{{ route('admin.updates.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Updates</a>
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Downloads</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('downloads.create')
                <a href="{{ route('admin.downloads.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Downloads</a>
                @endcan
                <a href="{{ route('admin.downloads.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Downloads</a>
            </div>
        </div>
        @endcan

        {{-- Gallery & Events --}}
        @canany(['gallery.view', 'events.view'])
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-images w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Gallery</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Gallery </span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('gallery.create')
                <a href="{{ route('admin.gallery.add') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Gallery</a>
                @endcan
                @can('gallery.view')
                <a href="{{ route('admin.gallery.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Gallery</a>
                @endcan
                
            </div>
        </div>
        @endcanany

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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Sectors</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('sectors.create')
                <a href="{{ route('admin.sectors.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Sector</a>
                @endcan
                <a href="{{ route('admin.sectors.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Sectors</a>
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Team</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('team.create')
                <a href="{{ route('admin.team.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Team Member</a>
                @endcan
                <a href="{{ route('admin.team.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Team</a>
            </div>
        </div>
        @endcan

        {{-- Designations --}}
        @can('designations.view')
        <div class="mb-1" data-dropdown>
            <button type="button"
                    class="dropdown-btn group w-full flex items-center justify-between px-3 py-3 rounded-md hover:bg-emerald-700/80 transition-colors text-left relative">
                <div class="flex items-center">
                    <i class="fas fa-tag w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                          style="opacity: {{ $isOpen ? '1' : '0' }}; max-width: {{ $isOpen ? '200px' : '0' }};">Designations</span>
                </div>
                <i class="dropdown-icon fas fa-chevron-down text-xs transition-transform duration-200 shrink-0"
                   style="opacity: {{ $isOpen ? '1' : '0' }};"></i>
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Designations</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('designations.create')
                <a href="{{ route('admin.designations.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Designation</a>
                @endcan
                <a href="{{ route('admin.designations.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Designations</a>
            </div>
        </div>
        @endcan

        {{-- Leadership --}}
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Leadership</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('leadership.create')
                <a href="{{ route('admin.leadership-messages.create') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Add Message</a>
                @endcan
                <a href="{{ route('admin.leadership-messages.index') }}" class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm">Manage Messages</a>
            </div>
        </div>
        @endcan

        {{-- Access Control --}}
        @if(auth()->user()->can('users.view') || auth()->user()->can('roles.view') || auth()->user()->can('users.create') || auth()->user()->can('roles.create'))

        <div class="my-3 border-t border-emerald-700/60"></div>

        <div class="px-3 mb-2 overflow-hidden transition-all duration-300"
             style="opacity: {{ $isOpen ? '1' : '0' }}; max-height: {{ $isOpen ? '30px' : '0' }};">
            <span class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Access Control</span>
        </div>

        {{-- Users --}}
        @canany(['users.view', 'users.create'])
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Users</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('users.create')
                <a href="{{ route('admin.users.add') }}"
                   class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.users.add') ? 'bg-emerald-700/60 font-medium' : '' }}">
                    Add User
                </a>
                @endcan
                @can('users.view')
                <a href="{{ route('admin.users.index') }}"
                   class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.users.index') ? 'bg-emerald-700/60 font-medium' : '' }}">
                    Manage Users
                </a>
                @endcan

                
            </div>
        </div>
        @endcanany

        {{-- Roles --}}
        @canany(['roles.view', 'roles.create'])
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
                <span class="pointer-events-none absolute left-full ml-3 px-2 py-1 bg-gray-900 text-white text-xs rounded
                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50
                             {{ $isOpen ? 'hidden' : '' }}">Roles</span>
            </button>
            <div class="dropdown-content hidden ml-9 pl-2 border-l-2 border-emerald-600/50">
                @can('roles.create')
                <a href="{{ route('admin.roles.add') }}"
                   class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.roles.create') ? 'bg-emerald-700/60 font-medium' : '' }}">
                    Add Role
                </a>
                @endcan
                @can('roles.view')
                <a href="{{ route('admin.roles.index') }}"
                   class="block px-3 py-2 rounded hover:bg-emerald-700/50 my-1 text-sm {{ request()->routeIs('admin.roles.index') ? 'bg-emerald-700/60 font-medium' : '' }}">
                    Manage Roles
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        @endif
    </nav>
</aside>