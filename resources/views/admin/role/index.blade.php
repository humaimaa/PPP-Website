@extends('layouts.admin')

@section('title', 'Roles Management - PPP Department KPK')
@section('header-title', 'Roles Management')

@section('content')
<div class="p-6">
    
    {{-- Header Actions --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">All Roles</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage system roles and their permissions</p>
        </div>
        @can('roles.create')
        <a href="{{ route('admin.roles.create') }}" 
           class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Add New Role
        </a>
        @endcan
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-700 text-emerald-700 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Roles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mr-3">
                                <i class="fas fa-user-shield text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $role->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $role->users_count }} user(s) assigned</p>
                            </div>
                        </div>
                        
                        {{-- Core Role Badge --}}
                        @if(in_array($role->name, ['Super Admin', 'Admin', 'Content Manager', 'Editor', 'Viewer']))
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Core</span>
                        @endif
                    </div>
                    
                    @if($role->description)
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($role->description, 80) }}</p>
                    @endif
                    
                    {{-- Permissions Preview --}}
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">
                            <i class="fas fa-key mr-1"></i>
                            {{ $role->permissions->count() }} permissions
                        </p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($role->permissions->take(3) as $permission)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                    {{ Str::limit($permission->name, 20) }}
                                </span>
                            @endforeach
                            @if($role->permissions->count() > 3)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                    +{{ $role->permissions->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            Created {{ $role->created_at->format('M d, Y') }}
                        </span>
                        <div class="flex gap-2">
                            @can('roles.view')
                            <a href="{{ route('admin.roles.show', $role) }}" 
                               class="text-gray-500 hover:text-emerald-700 transition p-1.5 rounded hover:bg-gray-100"
                               title="View">
                                <i class="fas fa-eye w-4 h-4"></i>
                            </a>
                            @endcan
                            
                            @can('roles.edit')
                                @if(!($role->name === 'Super Admin' && !auth()->user()->hasRole('Super Admin')))
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   class="text-blue-500 hover:text-blue-700 transition p-1.5 rounded hover:bg-blue-50"
                                   title="Edit">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                @endif
                            @endcan
                            
                            @can('roles.delete')
                                @if(!in_array($role->name, ['Super Admin', 'Admin', 'Content Manager', 'Editor', 'Viewer']))
                                    <form action="{{ route('admin.roles.destroy', $role) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 transition p-1.5 rounded hover:bg-red-50"
                                                title="Delete">
                                            <i class="fas fa-trash w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-500">
                <i class="fas fa-user-shield text-5xl text-gray-300 mb-4"></i>
                <p class="text-lg font-medium mb-2">No roles found</p>
                <p class="text-sm mb-4">Create your first role to manage permissions</p>
                @can('roles.create')
                <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center text-emerald-700 hover:underline">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Role
                </a>
                @endcan
            </div>
        @endforelse
    </div>
    
    {{-- Pagination --}}
    @if($roles->hasPages())
        <div class="mt-6">
            {{ $roles->links() }}
        </div>
    @endif
</div>
@endsection