@extends('layouts.admin')

@section('title', 'Users Management - PPP Department KPK')
@section('header-title', 'Users Management')

@section('content')
<div class="p-6">
    
    {{-- Header Actions --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">All Users</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage system users and their roles</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            
            
            {{-- Add User Button --}}
            @can('users.create')
            <a href="{{ route('admin.users.add') }}" 
               class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New User
            </a>
            @endcan
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-700 text-emerald-700 p-4 rounded-r-lg">
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

    {{-- Bulk Actions Bar --}}
    <div id="bulkActionsBar" class="hidden mb-4 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    <span id="selectedCount">0</span> user(s) selected
                </span>
                <div class="flex gap-2">
                    @can('users.edit')
                    <button onclick="bulkActivate()" 
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Activate
                    </button>
                    <button onclick="bulkDeactivate()" 
                            class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition flex items-center">
                        <i class="fas fa-ban mr-2"></i>
                        Deactivate
                    </button>
                    @endcan
                    @can('users.delete')
                    <button onclick="bulkDelete()" 
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                    @endcan
                </div>
            </div>
            <button onclick="clearSelection()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        
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
                        <tr class="hover:bg-gray-50 transition {{ !$user->is_active ? 'bg-gray-50' : '' }}">
                          
                            
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
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($role->name === 'Super Admin') 
                                                    bg-purple-100 text-purple-800
                                                @elseif($role->name === 'Admin')
                                                    bg-blue-100 text-blue-800
                                                @elseif($role->name === 'Content Manager')
                                                    bg-green-100 text-green-800
                                                @elseif($role->name === 'Editor')
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($role->name === 'Viewer')
                                                    bg-gray-100 text-gray-800
                                                @elseif($role->name === 'Tender Manager')
                                                    bg-indigo-100 text-indigo-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif
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
                                {{ $user->created_at->format('M d, Y') }}
                                <span class="text-xs block">{{ $user->created_at->format('h:i A') }}</span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    

                                    {{-- Edit Button --}}
                                    @can('users.edit')
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="text-blue-500 hover:text-blue-700 transition p-2 rounded hover:bg-blue-50"
                                       title="Edit">
                                        <i class="fas fa-edit w-4 h-4"></i>
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
                                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }} w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-300 p-2 cursor-not-allowed" title="Cannot change your own status">
                                                <i class="fas fa-ban w-4 h-4"></i>
                                            </span>
                                        @endif
                                    @endcan

                                    {{-- Delete Button --}}
                                    @can('users.delete')
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  class="inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 transition p-2 rounded hover:bg-red-50"
                                                        title="Delete">
                                                    <i class="fas fa-trash w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-300 p-2 cursor-not-allowed" title="Cannot delete yourself">
                                                <i class="fas fa-trash w-4 h-4"></i>
                                            </span>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                <p class="text-sm">No users found.</p>
                                @can('users.create')
                                <a href="{{ route('admin.users.create') }}" class="text-emerald-700 hover:underline text-sm mt-2 inline-block">
                                    Create your first user
                                </a>
                                @endcan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Select all functionality
    function toggleSelectAll(source) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        updateBulkActionsBar();
    }
    
    // Update bulk actions bar visibility
    function updateBulkActionsBar() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const bulkBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        
        if (checkedBoxes.length > 0) {
            bulkBar.classList.remove('hidden');
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkBar.classList.add('hidden');
        }
    }
    
    // Clear selection
    function clearSelection() {
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateBulkActionsBar();
    }
    
    // Get selected IDs
    function getSelectedIds() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        return Array.from(checkboxes).map(cb => cb.value);
    }
    
    // Bulk delete
    function bulkDelete() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        
        if (confirm('Are you sure you want to delete ' + ids.length + ' user(s)? This action cannot be undone.')) {
            document.getElementById('bulkDeleteIds').value = JSON.stringify(ids);
            document.getElementById('bulkDeleteForm').submit();
        }
    }
    
    // Bulk activate
    function bulkActivate() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        
        document.getElementById('bulkActivateIds').value = JSON.stringify(ids);
        document.getElementById('bulkActivateForm').submit();
    }
    
    // Bulk deactivate
    function bulkDeactivate() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        
        if (confirm('Are you sure you want to deactivate ' + ids.length + ' user(s)?')) {
            document.getElementById('bulkDeactivateIds').value = JSON.stringify(ids);
            document.getElementById('bulkDeactivateForm').submit();
        }
    }
    
    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(cb => cb.addEventListener('change', updateBulkActionsBar));
        
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                toggleSelectAll(this);
            });
        }
    });
</script>
@endpush