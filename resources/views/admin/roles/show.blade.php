@extends('layouts.admin')

@section('title', 'Role Details - PPP Unit KPK')
@section('header-title', 'Role Details')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Roles
        </a>
    </div>

    {{-- Role Information Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-user-shield mr-2 text-emerald-600"></i>
                        Role Information
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View role details and assigned permissions</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Role Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Role Name</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center bg-gray-800 text-white text-base font-medium px-3 py-1.5 rounded-md">
                            {{ $role->name }}
                        </span>
                        @if(in_array($role->name, ['Super Admin', 'Admin']))
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                <i class="fas fa-shield-alt mr-1"></i> System Role
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Users Count --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Assigned Users</label>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-emerald-600">{{ $role->users_count }}</span>
                        <span class="ml-2 text-gray-600">{{ Str::plural('user', $role->users_count) }}</span>
                        @if($role->users_count > 0)
                            <a href="{{ route('admin.users.index', ['role' => $role->id]) }}" 
                               class="ml-3 text-xs text-blue-600 hover:text-blue-800">
                                <i class="fas fa-users"></i> View Users
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                @if($role->description)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                    <div class="bg-gray-50 rounded-lg p-3 text-gray-700">
                        <i class="fas fa-quote-left text-gray-400 mr-2"></i>
                        {{ $role->description }}
                    </div>
                </div>
                @endif

                {{-- Created At --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <div class="text-gray-700">
                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                        {{ $role->created_at->format('F d, Y ') }}
                    </div>
                </div>

                {{-- Last Updated --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                    <div class="text-gray-700">
                        <i class="far fa-clock text-gray-400 mr-2"></i>
                        {{ $role->updated_at->format('F d, Y ') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Permissions Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-key mr-2 text-emerald-600"></i>
                        Assigned Permissions
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $role->permissions->count() }}</span> permissions
                    </p>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="expandAllBtn" 
                            class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">
                        <i class="fas fa-expand-alt mr-1"></i> Expand All
                    </button>
                    <span class="text-gray-300">|</span>
                    <button type="button" id="collapseAllBtn" 
                            class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">
                        <i class="fas fa-compress-alt mr-1"></i> Collapse All
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if($role->permissions->count() > 0)
                <div class="space-y-4">
                    @foreach($groupedPermissions as $moduleKey => $group)
                        @if(count($group['permissions']) > 0)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            {{-- Module Header --}}
                            <div class="bg-gradient-to-r from-gray-50 to-white px-4 py-3 border-b border-gray-200 cursor-pointer module-header" data-module="{{ $moduleKey }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 mr-3 transition-transform module-icon-{{ $moduleKey }}"></i>
                                        <i class="fas fa-folder-open text-emerald-600 mr-2"></i>
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $group['label'] }}
                                        </h4>
                                        <span class="ml-2 text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">
                                            {{ count($group['permissions']) }} {{ Str::plural('permission', count($group['permissions'])) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @php
                                            // Convert array to collection to use where method
                                            $permissionsCollection = collect($group['permissions']);
                                            $viewCount = $permissionsCollection->filter(function($perm) {
                                                return str_contains($perm->name, '.view');
                                            })->count();
                                            $createCount = $permissionsCollection->filter(function($perm) {
                                                return str_contains($perm->name, '.create');
                                            })->count();
                                            $editCount = $permissionsCollection->filter(function($perm) {
                                                return str_contains($perm->name, '.edit');
                                            })->count();
                                            $deleteCount = $permissionsCollection->filter(function($perm) {
                                                return str_contains($perm->name, '.delete');
                                            })->count();
                                        @endphp
                                        <span class="text-xs text-gray-400">
                                            @if($viewCount) View: {{ $viewCount }} @endif
                                            @if($createCount) | Create: {{ $createCount }} @endif
                                            @if($editCount) | Edit: {{ $editCount }} @endif
                                            @if($deleteCount) | Delete: {{ $deleteCount }} @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Permissions Grid (Collapsible) --}}
                            <div class="module-content-{{ $moduleKey }} p-4">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($group['permissions'] as $permission)
                                        @php
                                            $action = explode('.', $permission->name)[1] ?? '';
                                            $module = explode('.', $permission->name)[0] ?? '';
                                            $actionLabels = [
                                                'view' => 'View',
                                                'create' => 'Create',
                                                'edit' => 'Edit',
                                                'delete' => 'Delete',
                                                'toggle_status' => 'Toggle Status',
                                                'extend' => 'Extend',
                                                'set_thumbnail' => 'Set Thumbnail',
                                            ];
                                            $actionIcons = [
                                                'view' => 'fa-eye',
                                                'create' => 'fa-plus-circle',
                                                'edit' => 'fa-edit',
                                                'delete' => 'fa-trash-alt',
                                                'toggle_status' => 'fa-toggle-on',
                                                'extend' => 'fa-calendar-plus',
                                                'set_thumbnail' => 'fa-image',
                                            ];
                                            $actionColors = [
                                                'view' => 'text-blue-600 bg-blue-50 border-blue-200',
                                                'create' => 'text-green-600 bg-green-50 border-green-200',
                                                'edit' => 'text-yellow-600 bg-yellow-50 border-yellow-200',
                                                'delete' => 'text-red-600 bg-red-50 border-red-200',
                                                'toggle_status' => 'text-purple-600 bg-purple-50 border-purple-200',
                                                'extend' => 'text-orange-600 bg-orange-50 border-orange-200',
                                                'set_thumbnail' => 'text-pink-600 bg-pink-50 border-pink-200',
                                            ];
                                            $label = $actionLabels[$action] ?? ucfirst($action);
                                            $icon = $actionIcons[$action] ?? 'fa-key';
                                            $colorClass = $actionColors[$action] ?? 'text-gray-600 bg-gray-50 border-gray-200';
                                            $fullName = $permission->name;
                                        @endphp
                                        <div class="flex items-center p-3 rounded-lg border {{ $colorClass }} transition hover:shadow-md">
                                            <i class="fas {{ $icon }} mr-2"></i>
                                            <div>
                                                <div class="text-sm font-medium">
                                                    {{ $label }}
                                                </div>
                                                <div class="text-xs opacity-75">
                                                    {{ $module }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-key text-4xl mb-3 opacity-50"></i>
                    <p class="text-lg">No permissions assigned to this role</p>
                    <p class="text-sm mt-1">Edit the role to assign permissions</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Users with this Role (Optional Section) --}}
    @if($role->users_count > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-users mr-2 text-emerald-600"></i>
                Users with this Role ({{ $role->users_count }})
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($role->users->take(6) as $user)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-emerald-600 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-800">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($role->users_count > 6)
                <div class="text-center mt-4">
                    <a href="{{ route('admin.users.index', ['role' => $role->id]) }}" class="text-sm text-emerald-600 hover:text-emerald-800">
                        View all {{ $role->users_count }} users →
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all modules as expanded
        const modules = @json(array_keys($groupedPermissions));
        
        modules.forEach(moduleKey => {
            const content = document.querySelector('.module-content-' + moduleKey);
            const icon = document.querySelector('.module-icon-' + moduleKey);
            if (content && icon) {
                content.style.display = 'block';
                icon.style.transform = 'rotate(90deg)';
            }
        });
        
        // Toggle individual module
        document.querySelectorAll('.module-header').forEach(header => {
            header.addEventListener('click', function() {
                const moduleKey = this.getAttribute('data-module');
                const content = document.querySelector('.module-content-' + moduleKey);
                const icon = document.querySelector('.module-icon-' + moduleKey);
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.style.transform = 'rotate(90deg)';
                } else {
                    content.style.display = 'none';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
        
        // Expand all button
        document.getElementById('expandAllBtn')?.addEventListener('click', function() {
            modules.forEach(moduleKey => {
                const content = document.querySelector('.module-content-' + moduleKey);
                const icon = document.querySelector('.module-icon-' + moduleKey);
                if (content && icon) {
                    content.style.display = 'block';
                    icon.style.transform = 'rotate(90deg)';
                }
            });
        });
        
        // Collapse all button
        document.getElementById('collapseAllBtn')?.addEventListener('click', function() {
            modules.forEach(moduleKey => {
                const content = document.querySelector('.module-content-' + moduleKey);
                const icon = document.querySelector('.module-icon-' + moduleKey);
                if (content && icon) {
                    content.style.display = 'none';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
    });
</script>
@endpush
@endsection