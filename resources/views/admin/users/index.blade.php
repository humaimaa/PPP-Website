@extends('layouts.admin')

@section('title', 'Users Management - PPP Department KPK')
@section('header-title', 'Users Management')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Header Actions --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">All Users</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage system users and their roles</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            {{-- Bulk Delete Button --}}
            <button type="button" id="bulkDeleteBtn" 
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                    style="display: none;">
                <i class="fas fa-trash-alt"></i>
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            
            {{-- Add User Button --}}
            @can('users.create')
            <a href="{{ route('admin.users.add') }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New User
            </a>
            @endcan
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Users Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-users mr-2 text-emerald-600"></i>
                        All Users
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $users->total() }}</span> users
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name or email..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">
                                <input type="checkbox" 
                                       id="selectAllCheckbox" 
                                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition {{ !$user->is_active ? 'bg-gray-50' : '' }}" data-user-id="{{ $user->id }}">
                                <td class="px-6 py-4">
                                    @if($user->id !== auth()->id())
                                        <input type="checkbox" 
                                               name="user_ids[]" 
                                               value="{{ $user->id }}"
                                               class="user-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    @else
                                        <span class="text-gray-300 text-xs cursor-not-allowed" title="Cannot delete yourself">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Serial Number --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                
                                {{-- User Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full {{ $user->is_active ? 'bg-emerald-100' : 'bg-gray-200' }} flex items-center justify-center {{ $user->is_active ? 'text-emerald-700' : 'text-gray-500' }} font-bold mr-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium {{ $user->is_active ? 'text-gray-800' : 'text-gray-500' }}">
                                                {{ $user->name }}
                                            </span>
                                            @if($user->id === auth()->id())
                                                <span class="text-xs text-blue-600 block">(You)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Email --}}
                                <td class="px-6 py-4 text-sm {{ $user->is_active ? 'text-gray-600' : 'text-gray-400' }}">
                                    {{ $user->email }}
                                    @if(!$user->email_verified_at)
                                        <span class="text-yellow-600 text-xs block">
                                            <i class="fas fa-exclamation-circle"></i> Not verified
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Roles --}}
                                <td class="px-6 py-4">
                                    @if($user->roles->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                    {{ $role->name == 'Super Admin' ? 'bg-purple-100 text-purple-800' : 
                                                       ($role->name == 'Admin' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}
                                                    {{ !$user->is_active ? 'opacity-50' : '' }}">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">No roles assigned</span>
                                    @endif
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Created Date --}}
                                <td class="px-6 py-4 text-sm {{ $user->is_active ? 'text-gray-500' : 'text-gray-400' }}">
                                    <div class="flex flex-col">
                                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                                        <span class="text-xs">{{ $user->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                
                                {{-- Actions --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        {{-- Edit Button --}}
                                        @can('users.edit')
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 transition p-2 rounded hover:bg-blue-50"
                                           title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        {{-- Toggle Status Button --}}
                                        @can('users.edit')
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" 
                                                      method="POST" 
                                                      class="inline-block">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" 
                                                            class="{{ $user->is_active ? 'text-yellow-500 hover:text-yellow-700 hover:bg-yellow-50' : 'text-green-500 hover:text-green-700 hover:bg-green-50' }} transition p-2 rounded"
                                                            title="{{ $user->is_active ? 'Deactivate User' : 'Activate User' }}">
                                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }}"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-300 p-2 cursor-not-allowed" title="Cannot change your own status">
                                                    <i class="fas fa-ban"></i>
                                                </span>
                                            @endif
                                        @endcan

                                        {{-- Delete Button --}}
                                        @can('users.delete')
                                            @if($user->id !== auth()->id())
                                                <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" 
                                                        class="text-red-500 hover:text-red-700 transition p-2 rounded hover:bg-red-50"
                                                        title="Delete User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <span class="text-gray-300 p-2 cursor-not-allowed" title="Cannot delete yourself">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-sm">No users found.</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.users.index') }}" class="text-emerald-600 hover:underline text-sm mt-2 inline-block">
                                            Clear search
                                        </a>
                                    @else
                                        @can('users.create')
                                        <a href="{{ route('admin.users.create') }}" class="text-emerald-600 hover:underline text-sm mt-2 inline-block">
                                            Create your first user
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
        
        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete User</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete user "<span id="deleteUserName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelDeleteBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        
        // Update selected count and show/hide bulk delete button
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const count = checkedBoxes.length;
            selectedCountSpan.textContent = count;
            
            if (count > 0) {
                bulkDeleteBtn.style.display = 'inline-flex';
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }
        
        // Select/Deselect all checkboxes
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedCount();
            });
        }
        
        // Individual checkbox change
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                
                // Update select all checkbox state
                if (selectAllCheckbox) {
                    const allChecked = userCheckboxes.length === document.querySelectorAll('.user-checkbox:checked').length;
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
        
        // Bulk delete button click
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function(e) {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                const count = checkedBoxes.length;
                
                if (count === 0) {
                    alert('Please select at least one user to delete.');
                    return;
                }
                
                // Check if current user is selected
                let hasCurrentUser = false;
                checkedBoxes.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const youBadge = row.querySelector('.text-blue-600');
                    if (youBadge && youBadge.innerText === '(You)') {
                        hasCurrentUser = true;
                    }
                });
                
                let confirmMessage = `Are you sure you want to delete ${count} user${count > 1 ? 's' : ''}? This action cannot be undone.`;
                if (hasCurrentUser) {
                    confirmMessage = '⚠️ Warning: You have selected your own account. You cannot delete yourself.\n\n' + confirmMessage;
                    alert(confirmMessage);
                    return;
                }
                
                if (confirm(confirmMessage)) {
                    bulkDeleteForm.submit();
                }
            });
        }
        
        // Initialize count on page load
        updateSelectedCount();
    });
    
    // Delete confirmation function
    function confirmDelete(userId, userName) {
        const modal = document.getElementById('deleteModal');
        const deleteUserNameSpan = document.getElementById('deleteUserName');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteUserNameSpan.textContent = userName;
        deleteForm.action = `/admin/users/${userId}`;
        
        modal.classList.remove('hidden');
        
        // Close modal on cancel
        document.getElementById('cancelDeleteBtn').onclick = function() {
            modal.classList.add('hidden');
        };
        
        // Close modal when clicking outside
        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        };
    }
</script>
@endpush
@endsection