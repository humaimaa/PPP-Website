@extends('layouts.admin')

@section('title', 'Role Details - PPP Department KPK')
@section('header-title', 'Role Details')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">{{ $role->name }}</h1>
        </div>
        <div class="flex gap-3">
            @can('roles.edit')
                @if(!($role->name === 'Super Admin' && !auth()->user()->hasRole('Super Admin')))
                <a href="{{ route('admin.roles.edit', $role) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Role
                </a>
                @endif
            @endcan
        </div>
    </div>

    {{-- Role Info Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                Role Information
            </h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Role Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Guard Name</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $role->guard_name }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-gray-700">{{ $role->description ?: 'No description provided.' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-gray-700">{{ $role->created_at->format('F d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-gray-700">{{ $role->updated_at->format('F d, Y h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $role->users->count() }} user(s) assigned
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Assigned Users --}}
    @if($role->users->count() > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-emerald-600"></i>
                Users with this Role
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($role->users as $user)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold mr-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Permissions --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-key mr-2 text-emerald-600"></i>
                Permissions ({{ $role->permissions->count() }})
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($groupedPermissions as $moduleKey => $group)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-3">
                            <i class="fas fa-folder mr-2 text-emerald-600"></i>
                            {{ $group['label'] }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($group['permissions'] as $permission)
                                @php
                                    $action = explode('.', $permission->name)[1] ?? '';
                                    $actionColors = [
                                        'view' => 'bg-blue-100 text-blue-800',
                                        'create' => 'bg-green-100 text-green-800',
                                        'edit' => 'bg-yellow-100 text-yellow-800',
                                        'delete' => 'bg-red-100 text-red-800',
                                        'manage' => 'bg-purple-100 text-purple-800',
                                    ];
                                    $bgClass = $actionColors[$action] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $bgClass }}">
                                    {{ ucfirst($action) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection