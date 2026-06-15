@extends('layouts.admin')

@section('title', 'Roles - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Roles</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage admin roles</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button - Only show if user has delete permission --}}
            @can('roles.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            {{-- Add Role Button --}}
            @can('roles.create')
                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add Role
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-shield-alt mr-2 text-emerald-600"></i>
                        All Roles
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $roles->total() }}</span> roles
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.roles.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search roles by name..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.roles.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('roles.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">Role Name</th>
                            <th class="px-6 py-3 text-left">Permissions</th>
                            <th class="px-6 py-3 text-left">Users</th>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('roles.view') || auth()->user()->can('roles.edit') || auth()->user()->can('roles.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($roles as $role)
                        <tr class="hover:bg-gray-50 transition" data-role-id="{{ $role->id }}">
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('roles.delete')
                                <td class="px-6 py-4">
                                    @if(!in_array($role->name, ['Super Admin', 'Admin']))
                                        <input type="checkbox" 
                                               name="role_ids[]" 
                                               value="{{ $role->id }}"
                                               class="role-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    @else
                                        <span class="text-gray-300 text-xs cursor-not-allowed" title="System role cannot be deleted">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @endif
                                </td>
                            @endcan
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-gray-800 text-white text-xs font-medium px-2.5 py-1 rounded-md">
                                    {{ $role->name }}
                                </span>
                                @if(in_array($role->name, ['Super Admin', 'Admin']))
                                    <span class="ml-2 text-xs text-gray-400">(System)</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1 max-w-md">
                                    @php
                                        $displayPermissions = $role->permissions->take(3);
                                        $remainingCount = $role->permissions->count() - 3;
                                    @endphp
                                    
                                    @forelse($displayPermissions as $perm)
                                        @php
                                            $action = explode('.', $perm->name)[1] ?? '';
                                            $actionLabels = [
                                                'view' => 'View',
                                                'create' => 'Create',
                                                'edit' => 'Edit',
                                                'delete' => 'Delete',
                                                'toggle_status' => 'Toggle Status',
                                                'extend' => 'Extend',
                                                'set_thumbnail' => 'Set Thumbnail',
                                            ];
                                            $actionColors = [
                                                'view' => 'text-blue-600 bg-blue-50',
                                                'create' => 'text-green-600 bg-green-50',
                                                'edit' => 'text-yellow-600 bg-yellow-50',
                                                'delete' => 'text-red-600 bg-red-50',
                                                'toggle_status' => 'text-purple-600 bg-purple-50',
                                                'extend' => 'text-orange-600 bg-orange-50',
                                                'set_thumbnail' => 'text-pink-600 bg-pink-50',
                                            ];
                                            $label = $actionLabels[$action] ?? ucfirst($action);
                                            $colorClass = $actionColors[$action] ?? 'text-gray-600 bg-gray-50';
                                            
                                            $module = explode('.', $perm->name)[0] ?? '';
                                            $moduleLabels = [
                                                'projects' => 'Proj',
                                                'tenders' => 'Tend',
                                                'news' => 'News',
                                                'gallery' => 'Gal',
                                                'sectors' => 'Sec',
                                                'designations' => 'Desig',
                                                'users' => 'Users',
                                                'downloads' => 'Dl',
                                                'team' => 'Team',
                                                'leadership' => 'Lead',
                                                'roles' => 'Roles',
                                            ];
                                            $moduleShort = $moduleLabels[$module] ?? ucfirst(substr($module, 0, 3));
                                        @endphp
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $colorClass }}" title="{{ $perm->name }}">
                                            {{ $moduleShort }}: {{ $label }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs">No permissions</span>
                                    @endforelse
                                    
                                    @if($remainingCount > 0)
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full cursor-help" title="{{ $role->permissions->slice(3)->pluck('name')->implode(', ') }}">
                                            +{{ $remainingCount }} more
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="text-gray-600 font-medium">{{ $role->users_count }}</span>
                                <span class="text-gray-400 text-xs ml-1">{{ Str::plural('user', $role->users_count) }}</span>
                            </td>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('roles.view') || auth()->user()->can('roles.edit') || auth()->user()->can('roles.delete'))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View Button --}}
                                        @can('roles.view')
                                            <a href="{{ route('admin.roles.show', $role) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                               title="View Role Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Edit Button --}}
                                        @can('roles.edit')
                                            <a href="{{ route('admin.roles.edit', $role) }}" 
                                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                               title="Edit Role">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Delete Button --}}
                                        @can('roles.delete')
                                            @if(!in_array($role->name, ['Super Admin', 'Admin']))
                                                <button type="button" 
                                                        onclick="confirmDelete({{ $role->id }}, '{{ addslashes($role->name) }}')" 
                                                        class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors delete-role-btn"
                                                        title="Delete Role">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <span class="text-gray-400 p-2 cursor-not-allowed" title="System role cannot be deleted">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                @php
                                    $colspan = 4; // Base columns (Role Name, Permissions, Users)
                                    if(auth()->user()->can('roles.delete')) $colspan++; // Add checkbox column
                                    if(auth()->user()->can('roles.view') || auth()->user()->can('roles.edit') || auth()->user()->can('roles.delete')) $colspan++; // Add actions column
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-shield-alt text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No roles found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.roles.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear search
                                        </a>
                                    @else
                                        @can('roles.create')
                                            <a href="{{ route('admin.roles.create') }}" class="text-emerald-600 hover:underline text-sm">
                                                Create your first role →
                                            </a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    @if($roles->hasPages())
        <div class="mt-4">
            {{ $roles->appends(request()->query())->links() }}
        </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Role</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete role "<span id="deleteRoleName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">Users with this role will lose its permissions.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button type="button" id="cancelDeleteBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bulk Delete Confirmation Modal - Only show if user has delete permission --}}
@can('roles.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Roles</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> role(s)?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelBulkDeleteBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button id="confirmBulkDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endcan

@push('scripts')
<script>
    // Make confirmDelete available globally
    window.confirmDelete = function(roleId, roleName) {
        // Prevent any default behavior
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteRoleNameSpan = document.getElementById('deleteRoleName');
        
        if (!deleteModal || !deleteForm) {
            console.error('Modal or form not found');
            return false;
        }
        
        // Set the role name in the modal
        if (deleteRoleNameSpan) {
            deleteRoleNameSpan.textContent = roleName;
        }
        
        // Set the form action URL
        deleteForm.action = `/admin/roles/${roleId}`;
        
        // Show the modal
        deleteModal.classList.remove('hidden');
        
        // Prevent body scrolling when modal is open
        document.body.style.overflow = 'hidden';
        
        return false;
    };
    
    function closeModal() {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        
        if (deleteModal) {
            deleteModal.classList.add('hidden');
            // Restore body scrolling
            document.body.style.overflow = '';
            // Clear form action
            if (deleteForm) {
                deleteForm.action = '';
            }
        }
    }
    
    function closeBulkDeleteModal() {
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        if (bulkDeleteModal) {
            bulkDeleteModal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modal close functionality
        const deleteModal = document.getElementById('deleteModal');
        const cancelBtn = document.getElementById('cancelDeleteBtn');
        
        // Close modal on cancel button click
        if (cancelBtn) {
            cancelBtn.onclick = function(e) {
                e.preventDefault();
                closeModal();
            };
        }
        
        // Close modal when clicking outside
        if (deleteModal) {
            deleteModal.onclick = function(e) {
                if (e.target === deleteModal) {
                    closeModal();
                }
            };
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && deleteModal && !deleteModal.classList.contains('hidden')) {
                closeModal();
            }
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            if (e.key === 'Escape' && bulkDeleteModal && !bulkDeleteModal.classList.contains('hidden')) {
                closeBulkDeleteModal();
            }
        });
        
        // Initialize bulk delete functionality only if user has delete permission
        @can('roles.delete')
            initializeBulkDelete();
        @endcan
    });
    
    @can('roles.delete')
    function initializeBulkDelete() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const roleCheckboxes = document.querySelectorAll('.role-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
        const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
        const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
        
        // Update selected count and show/hide bulk delete button
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.role-checkbox:checked');
            const count = checkedBoxes.length;
            if (selectedCountSpan) {
                selectedCountSpan.textContent = count;
            }
            
            if (bulkDeleteBtn) {
                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }
        }
        
        // Select/Deselect all checkboxes
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                roleCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedCount();
            });
        }
        
        // Individual checkbox change
        roleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                
                // Update select all checkbox state
                if (selectAllCheckbox) {
                    const allChecked = roleCheckboxes.length === document.querySelectorAll('.role-checkbox:checked').length;
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
        
        // Bulk delete button click
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkedBoxes = document.querySelectorAll('.role-checkbox:checked');
                const count = checkedBoxes.length;
                
                if (count === 0) {
                    alert('Please select at least one role to delete.');
                    return;
                }
                
                // Check if any system roles are selected
                let hasSystemRole = false;
                checkedBoxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const roleSpan = row.querySelector('td:nth-child(2) span:first-child');
                    const roleName = roleSpan ? roleSpan.innerText : '';
                    if (roleName === 'Super Admin' || roleName === 'Admin') {
                        hasSystemRole = true;
                    }
                });
                
                if (hasSystemRole) {
                    alert('⚠️ System roles (Super Admin/Admin) cannot be deleted and have been excluded.');
                    // Filter out system roles from selection
                    checkedBoxes.forEach(checkbox => {
                        const row = checkbox.closest('tr');
                        const roleSpan = row.querySelector('td:nth-child(2) span:first-child');
                        const roleName = roleSpan ? roleSpan.innerText : '';
                        if (roleName === 'Super Admin' || roleName === 'Admin') {
                            checkbox.checked = false;
                        }
                    });
                    updateSelectedCount();
                    
                    const remainingCount = document.querySelectorAll('.role-checkbox:checked').length;
                    if (remainingCount === 0) {
                        alert('No deletable roles selected. System roles cannot be deleted.');
                        return;
                    }
                }
                
                const finalCount = document.querySelectorAll('.role-checkbox:checked').length;
                bulkDeleteCountSpan.textContent = finalCount;
                bulkDeleteModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }
        
        // Confirm bulk delete
        if (confirmBulkDeleteBtn) {
            confirmBulkDeleteBtn.addEventListener('click', function() {
                bulkDeleteModal.classList.add('hidden');
                document.body.style.overflow = '';
                bulkDeleteForm.submit();
            });
        }
        
        // Cancel bulk delete
        if (cancelBulkDeleteBtn) {
            cancelBulkDeleteBtn.addEventListener('click', function() {
                bulkDeleteModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === bulkDeleteModal) {
                bulkDeleteModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
        
        // Initialize count on page load
        updateSelectedCount();
    }
    @endcan
</script>
@endpush
@endsection