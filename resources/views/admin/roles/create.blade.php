@extends('layouts.admin')

@section('title', 'Add Role - PPP Unit KPK')
@section('header-title', 'Add New Role')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Roles
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-shield mr-2 text-emerald-600"></i>
                    Add New Role
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new role and assign permissions</p>
            </div>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6">
            @csrf
            
            {{-- Role Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Content Moderator, Tender Reviewer"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Unique name for the role (e.g., Content Manager, Tender Reviewer)</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Brief description of this role's purpose and responsibilities..."
                    >{{ old('description') }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Optional description to explain the role's purpose</p>
            </div>

            {{-- Permissions Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Assign Permissions <span class="text-red-500">*</span>
                    </label>
                    @if(isset($groupedPermissions) && !empty($groupedPermissions))
                        <div class="flex gap-3">
                            <button type="button" id="selectAll"
                                class="text-xs text-emerald-600 hover:text-emerald-800 font-medium transition">
                                <i class="fas fa-check-double mr-1"></i>Select All
                            </button>
                            <span class="text-gray-300">|</span>
                            <button type="button" id="clearAll"
                                class="text-xs text-gray-500 hover:text-gray-700 font-medium transition">
                                <i class="fas fa-times mr-1"></i>Clear All
                            </button>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    @if(isset($groupedPermissions) && !empty($groupedPermissions))
                        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                            @foreach($groupedPermissions as $moduleKey => $group)
                                @if(count($group['permissions']) > 0)
                                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                                        {{-- Module Header with Select All --}}
                                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                                            <h4 class="font-medium text-gray-800">
                                                <i class="fas fa-folder mr-2 text-emerald-600"></i>
                                                {{ $group['label'] }}
                                            </h4>
                                            <button type="button" 
                                                    onclick="toggleModulePermissions('{{ $moduleKey }}')"
                                                    class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                                <i class="fas fa-check-square mr-1"></i>Select All
                                            </button>
                                        </div>
                                        
                                        {{-- Permissions Grid --}}
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                            @foreach($group['permissions'] as $permission)
                                                @php
                                                    $action = explode('.', $permission->name)[1] ?? '';
                                                    $actionLabels = [
                                                        'view' => 'View',
                                                        'create' => 'Create',
                                                        'edit' => 'Edit',
                                                        'delete' => 'Delete',
                                                        'toggle_status' => 'Toggle Status',
                                                        'set_thumbnail' => 'Set Thumbnail',
                                                    ];
                                                    $actionColors = [
                                                        'view' => 'text-blue-600',
                                                        'create' => 'text-green-600',
                                                        'edit' => 'text-yellow-600',
                                                        'delete' => 'text-red-600',
                                                        'toggle_status' => 'text-purple-600',
                                                        'set_thumbnail' => 'text-pink-600',
                                                    ];
                                                    $label = $actionLabels[$action] ?? ucfirst($action);
                                                    $colorClass = $actionColors[$action] ?? 'text-gray-600';
                                                    $icon = 'circle';
                                                    if ($action === 'view') $icon = 'eye';
                                                    elseif ($action === 'create') $icon = 'plus';
                                                    elseif ($action === 'edit') $icon = 'edit';
                                                    elseif ($action === 'delete') $icon = 'trash';
                                                    elseif ($action === 'toggle_status') $icon = 'toggle-on';
                                                    elseif ($action === 'set_thumbnail') $icon = 'image';
                                                @endphp
                                                <label class="flex items-center p-2 hover:bg-gray-50 rounded transition cursor-pointer">
                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           class="module-{{ $moduleKey }} rounded border-gray-300 focus:ring-emerald-500 text-emerald-600"
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="ml-2 text-sm {{ $colorClass }}">
                                                        <i class="fas fa-{{ $icon }} mr-1 text-xs"></i>
                                                        {{ $label }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-lock text-4xl mb-2"></i>
                            <p>No permissions available. Please run the permission seeder first.</p>
                        </div>
                    @endif
                </div>
                <p class="mt-2 text-xs text-gray-500">Select the permissions that this role should have</p>
                @error('permissions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Roles & Permissions</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Roles define what users can do within the system. Assigning permissions to a role gives 
                            all users with that role access to specific features and actions.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.roles.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Create Role
                </button>
            </div>
{{-- Debug info - remove after fixing --}}
@if(config('app.debug'))
<div class="mt-4 p-3 bg-gray-100 rounded">
    <p class="text-xs text-gray-600">
        <strong>Debug:</strong> 
        Total permissions in form: {{ isset($groupedPermissions) ? collect($groupedPermissions)->sum(fn($g) => count($g['permissions'])) : 0 }}
    </p>
</div>
@endif

        </form>


    </div>
</div>

@push('scripts')
<script>
    function toggleModulePermissions(moduleKey) {
        const checkboxes = document.querySelectorAll('.module-' + moduleKey);
        if (checkboxes.length > 0) {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }
    }
    
    function selectAllModules() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = true);
    }
    
    function deselectAllModules() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = false);
    }
    
    // Add event listeners when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('selectAll');
        const clearAllBtn = document.getElementById('clearAll');
        
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', selectAllModules);
        }
        
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', deselectAllModules);
        }
    });
</script>
@endpush
@endsection