@extends('layouts.admin')

@section('title', 'Manage Hierarchy - PPP Unit KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Hierarchy</h1>
            <p class="text-sm text-gray-500 mt-1">Manage leadership and staff hierarchy/titles</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button - Only show if user has delete permission --}}
            @can('hierarchy.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            {{-- Add Hierarchy Button --}}
            @can('hierarchy.create')
                <a href="{{ route('admin.hierarchy.add') }}" 
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add New Hierarchy
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

    @if(session('warning'))
        <div class="mb-4 flex items-center gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('warning') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-tags mr-2 text-emerald-600"></i>
                        All Hierarchy Entries
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $hierarchies->total() }}</span> entries
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.hierarchy.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search hierarchy..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.hierarchy.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.hierarchy.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('hierarchy.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Hierarchy Title</th>
                            <th class="px-6 py-3 text-left">Order</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Created At</th>
                            <th class="px-6 py-3 text-left">Last Updated</th>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('hierarchy.edit') || auth()->user()->can('hierarchy.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($hierarchies as $index => $hierarchyItem) {{-- Changed variable name to $hierarchyItem --}}
                        <tr class="hover:bg-gray-50 transition" data-hierarchy-id="{{ $hierarchyItem->id }}">
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('hierarchy.delete')
                                <td class="px-6 py-4">
                                    @if(!$hierarchyItem->isUsed())
                                        <input type="checkbox" 
                                               name="hierarchy_ids[]" 
                                               value="{{ $hierarchyItem->id }}"
                                               class="hierarchy-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    @else
                                        <span title="Cannot delete - in use" class="text-gray-300 cursor-not-allowed">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    @endif
                                </td>
                            @endcan
                            
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $hierarchies->firstItem() + $index }} {{-- Changed $hierarchy to $hierarchies --}}
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-tag text-emerald-600 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-900">{{ $hierarchyItem->title }}</span> {{-- Changed to $hierarchyItem --}}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $hierarchyItem->order }} {{-- Changed to $hierarchyItem --}}
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($hierarchyItem->isUsed()) {{-- Changed to $hierarchyItem --}}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-link mr-1"></i> In Use
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Available
                                    </span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                {{ $hierarchyItem->created_at->format('M d, Y') }} {{-- Changed to $hierarchyItem --}}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="far fa-clock text-gray-400 mr-1"></i>
                                {{ $hierarchyItem->updated_at->format('M d, Y') }} {{-- Changed to $hierarchyItem --}}
                            </td>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('hierarchy.edit') || auth()->user()->can('hierarchy.delete'))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Edit Button --}}
                                        @can('hierarchy.edit')
                                            <a href="{{ route('admin.hierarchy.edit', $hierarchyItem) }}"  {{-- Changed to $hierarchyItem --}}
                                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                               title="Edit Hierarchy">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Delete Button - Only show if not in use --}}
                                        @can('hierarchy.delete')
                                            @if(!$hierarchyItem->isUsed()) {{-- Changed to $hierarchyItem --}}
                                                <button type="button"
                                                        onclick="confirmDelete({{ $hierarchyItem->id }}, '{{ addslashes($hierarchyItem->title) }}')"  {{-- Changed to $hierarchyItem --}}
                                                        class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                        title="Delete Hierarchy">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @else
                                                <span class="text-gray-400 p-2 cursor-not-allowed" title="Cannot delete - in use">
                                                    <i class="fas fa-trash-alt"></i>
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
                                    $colspan = 6; // Base columns (#, Title, Order, Status, Created At, Last Updated)
                                    if(auth()->user()->can('hierarchy.delete')) $colspan++; // Add checkbox column
                                    if(auth()->user()->can('hierarchy.edit') || auth()->user()->can('hierarchy.delete')) $colspan++; // Add actions column
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-tags text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No hierarchy entries found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.hierarchy.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear search
                                        </a>
                                    @else
                                        @can('hierarchy.create')
                                            <a href="{{ route('admin.hierarchy.add') }}" class="text-emerald-600 hover:underline text-sm">
                                                Create your first hierarchy entry →
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

    @if($hierarchies->hasPages()) {{-- Changed $hierarchy to $hierarchies --}}
        <div class="mt-4">
            {{ $hierarchies->appends(request()->query())->links() }} {{-- Changed $hierarchy to $hierarchies --}}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Hierarchy</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete hierarchy "<span id="deleteHierarchyName" class="font-semibold text-gray-700"></span>"?
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

{{-- Bulk Delete Confirmation Modal --}}
@can('hierarchy.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Hierarchy Entries</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> hierarchy entry(ies)?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. Entries in use will be skipped.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Bulk delete functionality - Only initialize if user has delete permission
        @can('hierarchy.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const hierarchyCheckboxes = document.querySelectorAll('.hierarchy-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            // Update selected count and show/hide bulk delete button
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.hierarchy-checkbox:checked');
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
            
            // Select/Deselect all checkboxes (only selectable ones)
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    hierarchyCheckboxes.forEach(checkbox => {
                        if (!checkbox.disabled) {
                            checkbox.checked = selectAllCheckbox.checked;
                        }
                    });
                    updateSelectedCount();
                });
            }
            
            // Individual checkbox change
            hierarchyCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    // Update select all checkbox state
                    if (selectAllCheckbox) {
                        const allChecked = hierarchyCheckboxes.length === document.querySelectorAll('.hierarchy-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            // Bulk delete button click - show modal
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.hierarchy-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one hierarchy entry to delete.');
                        return;
                    }
                    
                    bulkDeleteCountSpan.textContent = count;
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
                if (e.target === document.getElementById('deleteModal')) {
                    closeDeleteModal();
                }
            });
            
            // Initialize count on page load
            updateSelectedCount();
        @endcan
        
        // Delete confirmation functions - Only define if user has delete permission
        @can('hierarchy.delete')
            window.confirmDelete = function(hierarchyId, hierarchyTitle) {
                const modal = document.getElementById('deleteModal');
                const deleteHierarchyNameSpan = document.getElementById('deleteHierarchyName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteHierarchyNameSpan.textContent = hierarchyTitle;
                deleteForm.action = `/admin/hierarchy/${hierarchyId}`;
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Close modal on cancel
                document.getElementById('cancelDeleteBtn').onclick = function() {
                    closeDeleteModal();
                };
                
                // Close modal when clicking outside
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeDeleteModal();
                    }
                };
            };
            
            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    if (deleteForm) {
                        deleteForm.action = '';
                    }
                }
            }
        @endcan
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @can('hierarchy.delete')
                    const deleteModal = document.getElementById('deleteModal');
                    const bulkDeleteModal = document.getElementById('bulkDeleteModal');
                    
                    if (deleteModal && !deleteModal.classList.contains('hidden')) {
                        closeDeleteModal();
                    }
                    if (bulkDeleteModal && !bulkDeleteModal.classList.contains('hidden')) {
                        bulkDeleteModal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                @endcan
            }
        });
        
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const successMsg = document.querySelector('.bg-green-50');
            const errorMsg = document.querySelector('.bg-red-50');
            const warningMsg = document.querySelector('.bg-yellow-50');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
            if (warningMsg) warningMsg.style.display = 'none';
        }, 5000);
    });
</script>
@endpush
@endsection