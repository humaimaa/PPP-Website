@extends('layouts.admin')

@section('title', 'Edit Role - PPP Department KPK')
@section('header-title', 'Edit Role')

@section('content')
<div class="max-w-5xl mx-auto">
    
    {{-- Messages --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
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

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-user-shield mr-2 text-emerald-600"></i>
                Edit Role: {{ $role->name }}
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update role information and permissions</p>
        </div>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
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
                        value="{{ old('name', $role->name) }}"
                        required
                        {{ $role->name === 'Super Admin' ? 'readonly' : '' }}
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 {{ $role->name === 'Super Admin' ? 'bg-gray-100' : '' }} @error('name') border-red-500 @enderror"
                    >
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description (Optional)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="2"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >{{ old('description', $role->description) }}</textarea>
                </div>
            </div>

            {{-- Permissions Section --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Permissions <span class="text-red-500">*</span>
                </label>
                
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    {{-- Quick Actions --}}
                    <div class="flex gap-3 mb-4 pb-4 border-b border-gray-200">
                        <button type="button" onclick="selectAllModules()" class="text-sm text-emerald-700 hover:text-emerald-800">
                            <i class="fas fa-check-double mr-1"></i>Select All
                        </button>
                        <button type="button" onclick="deselectAllModules()" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times mr-1"></i>Clear All
                        </button>
                    </div>

                    {{-- Grouped Permissions --}}
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        @foreach($groupedPermissions as $moduleKey => $group)
                            <div class="bg-white rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-800">
                                        <i class="fas fa-folder mr-2 text-emerald-600"></i>
                                        {{ $group['label'] }}
                                    </h4>
                                    <button type="button" 
                                            onclick="toggleModulePermissions('{{ $moduleKey }}')"
                                            class="text-xs text-emerald-600 hover:text-emerald-700">
                                        Select All
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach($group['permissions'] as $permission)
                                        @php
                                            $action = explode('.', $permission->name)[1] ?? '';
                                            $actionColors = [
                                                'view' => 'text-blue-600',
                                                'create' => 'text-green-600',
                                                'edit' => 'text-yellow-600',
                                                'delete' => 'text-red-600',
                                                'manage' => 'text-purple-600',
                                            ];
                                            $colorClass = $actionColors[$action] ?? 'text-gray-600';
                                        @endphp
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded transition cursor-pointer">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}"
                                                   class="module-{{ $moduleKey }} rounded border-gray-300 {{ str_replace('text', 'focus:ring', $colorClass) }} text-emerald-600"
                                                   {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm {{ $colorClass }}">
                                                {{ ucfirst($action) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('permissions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role Info --}}
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Role Information</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-700">{{ $role->created_at->format('F d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="text-gray-700">{{ $role->updated_at->format('F d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Users Assigned:</span>
                        <span class="text-gray-700">{{ $role->users()->count() }} user(s)</span>
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
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleModulePermissions(moduleKey) {
        const checkboxes = document.querySelectorAll('.module-' + moduleKey);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    }
    
    function selectAllModules() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = true);
    }
    
    function deselectAllModules() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = false);
    }
</script>
@endpush