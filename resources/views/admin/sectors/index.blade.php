@extends('layouts.admin')

@section('title', 'Sectors - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Sectors</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage investment sectors</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button - Only show if user has delete permission --}}
            @can('sectors.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            {{-- Add Sector Button --}}
            @can('sectors.create')
                <a href="{{ route('admin.sectors.add') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add Sector
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
                        <i class="fas fa-chart-line mr-2 text-emerald-600"></i>
                        All Sectors
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $sectors->total() }}</span> sectors
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.sectors.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search sectors by name..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.sectors.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.sectors.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('sectors.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Image</th>
                            <th class="px-6 py-3 text-left">Sector Name</th>
                            <th class="px-6 py-3 text-left">Tagline</th>
                            <th class="px-6 py-3 text-left">Created At</th>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('sectors.view') || auth()->user()->can('sectors.edit') || auth()->user()->can('sectors.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($sectors as $sector)
                        <tr class="hover:bg-gray-50 transition" data-sector-id="{{ $sector->id }}">
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('sectors.delete')
                                <td class="px-6 py-4">
                                    <input type="checkbox" 
                                           name="sector_ids[]" 
                                           value="{{ $sector->id }}"
                                           class="sector-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </td>
                            @endcan
                            
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                #{{ $sector->id }}
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($sector->img)
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $sector->img) }}" 
                                             alt="{{ $sector->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-1 rounded-md">
                                    {{ $sector->name }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="text-gray-600 line-clamp-2 max-w-xs">
                                    {{ $sector->tagline }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $sector->created_at->format('M d, Y') }}
                            </td>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('sectors.view') || auth()->user()->can('sectors.edit') || auth()->user()->can('sectors.delete'))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View Button --}}
                                        @can('sectors.view')
                                            <a href="{{ route('admin.sectors.show', $sector) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                               title="View Sector Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Edit Button --}}
                                        @can('sectors.edit')
                                            <a href="{{ route('admin.sectors.edit', $sector) }}" 
                                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                               title="Edit Sector">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Delete Button --}}
                                        @can('sectors.delete')
                                            <button onclick="confirmDelete({{ $sector->id }}, '{{ addslashes($sector->name) }}')" 
                                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                    title="Delete Sector">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                @php
                                    $colspan = 6; // Base columns (ID, Image, Sector Name, Tagline, Created At)
                                    if(auth()->user()->can('sectors.delete')) $colspan++; // Add checkbox column
                                    if(auth()->user()->can('sectors.view') || auth()->user()->can('sectors.edit') || auth()->user()->can('sectors.delete')) $colspan++; // Add actions column
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-chart-line text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No sectors found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.sectors.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear search
                                        </a>
                                    @else
                                        @can('sectors.create')
                                            <a href="{{ route('admin.sectors.add') }}" class="text-emerald-600 hover:underline text-sm">
                                                Create your first sector →
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

    @if($sectors->hasPages())
        <div class="mt-4">
            {{ $sectors->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Sector</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete sector "<span id="deleteSectorName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All associated data will be removed.</p>
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

{{-- Bulk Delete Confirmation Modal - Only show if user has delete permission --}}
@can('sectors.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Sectors</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> sector(s)?
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
    document.addEventListener('DOMContentLoaded', function() {
        // Bulk delete functionality - Only initialize if user has delete permission
        @can('sectors.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const sectorCheckboxes = document.querySelectorAll('.sector-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            // Update selected count and show/hide bulk delete button
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.sector-checkbox:checked');
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
                    sectorCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }
            
            // Individual checkbox change
            sectorCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    // Update select all checkbox state
                    if (selectAllCheckbox) {
                        const allChecked = sectorCheckboxes.length === document.querySelectorAll('.sector-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            // Bulk delete button click - show modal
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.sector-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one sector to delete.');
                        return;
                    }
                    
                    bulkDeleteCountSpan.textContent = count;
                    bulkDeleteModal.classList.remove('hidden');
                });
            }
            
            // Confirm bulk delete
            if (confirmBulkDeleteBtn) {
                confirmBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                    bulkDeleteForm.submit();
                });
            }
            
            // Cancel bulk delete
            if (cancelBulkDeleteBtn) {
                cancelBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                });
            }
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === bulkDeleteModal) {
                    bulkDeleteModal.classList.add('hidden');
                }
                if (e.target === document.getElementById('deleteModal')) {
                    document.getElementById('deleteModal').classList.add('hidden');
                }
            });
            
            // Initialize count on page load
            updateSelectedCount();
        @endcan
        
        // Delete confirmation function - Only define if user has delete permission
        @can('sectors.delete')
            window.confirmDelete = function(sectorId, sectorName) {
                const modal = document.getElementById('deleteModal');
                const deleteSectorNameSpan = document.getElementById('deleteSectorName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteSectorNameSpan.textContent = sectorName;
                deleteForm.action = `/admin/sectors/${sectorId}`;
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Close modal on cancel
                document.getElementById('cancelDeleteBtn').onclick = function() {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                };
                
                // Close modal when clicking outside
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                };
            };
        @endcan
        
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const successMsg = document.querySelector('.bg-green-50');
            const errorMsg = document.querySelector('.bg-red-50');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);
    });
</script>
@endpush
@endsection