@extends('layouts.admin')

@section('title', 'Tenders - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Tenders</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage tender advertisements</p>
        </div>
        <div class="flex gap-3">
            @can('tenders.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            @can('tenders.create')
                <a href="{{ route('admin.tenders.create') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add Tender
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
                        <i class="fas fa-file-alt mr-2 text-emerald-600"></i>
                        All Tenders
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $tenders->total() }}</span> tenders
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.tenders.index') }}" class="flex gap-2" id="filterForm">
                        <select name="category" 
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Categories</option>
                            <option value="General Procurement" {{ request('category') == 'General Procurement' ? 'selected' : '' }}>General Procurement</option>
                            <option value="Transaction Advisory" {{ request('category') == 'Transaction Advisory' ? 'selected' : '' }}>Transaction Advisory</option>
                            <option value="Private Partner Selection" {{ request('category') == 'Private Partner Selection' ? 'selected' : '' }}>Private Partner Selection</option>
                        </select>
                        
                        <select name="status" 
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        </select>
                        
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search tenders by name..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search') || request('category') || request('status'))
                            <a href="{{ route('admin.tenders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.tenders.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            @can('tenders.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Document</th>
                            <th class="px-6 py-3 text-left">Tender Name</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Opening Date</th>
                            <th class="px-6 py-3 text-left">Closing Date</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Days Left</th>
                            @if(auth()->user()->can('tenders.view') || auth()->user()->can('tenders.edit') || auth()->user()->can('tenders.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($tenders as $tender)
                        <tr class="hover:bg-gray-50 transition" data-tender-id="{{ $tender->id }}">
                            @can('tenders.delete')
                                <td class="px-6 py-4">
                                    <input type="checkbox" 
                                           name="tender_ids[]" 
                                           value="{{ $tender->id }}"
                                           class="tender-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </td>
                            @endcan
                            
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                #{{ $tender->id }}
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($tender->document && Storage::disk('public')->exists($tender->document))
                                    <a href="{{ Storage::url($tender->document) }}" target="_blank" 
                                       class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700">
                                        <i class="fas fa-file-pdf text-lg"></i>
                                        <span class="text-xs">View</span>
                                    </a>
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-file text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $tender->name }}</span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-clock mr-1"></i>
                                        Created: {{ $tender->created_at->format('M d, Y') }}
                                    </div>
                                    @if($tender->is_extended)
                                        <div class="text-xs text-orange-600 mt-1">
                                            <i class="fas fa-calendar-plus mr-1"></i>
                                            Extended
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-1 rounded-md">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    {{ $tender->category }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $tender->opening_date ? $tender->opening_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    @if($tender->is_extended)
                                        <span class="text-gray-500 line-through">
                                            {{ $tender->closing_date->format('M d, Y') }}
                                        </span>
                                        <div class="text-orange-600 font-medium mt-1">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                            {{ $tender->effective_closing_date->format('M d, Y') }}
                                        </div>
                                    @else
                                        <span class="text-gray-900">
                                            {{ $tender->closing_date->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                @php
                                    $status = $tender->status;
                                    $statusColor = $tender->statusColor;
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($statusColor == 'green') bg-green-100 text-green-800
                                    @elseif($statusColor == 'yellow') bg-yellow-100 text-yellow-800
                                    @elseif($statusColor == 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                                    {{ $status }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($tender->isOpen())
                                    @php
                                        $daysRemaining = $tender->days_remaining;
                                    @endphp
                                    <div class="text-sm">
                                        @if($daysRemaining <= 7)
                                            <span class="text-red-600 font-semibold">
                                                <i class="fas fa-hourglass-end mr-1"></i>
                                                {{ $tender->days_remaining_text }}
                                            </span>
                                        @else
                                            <span class="text-emerald-600">
                                                <i class="fas fa-hourglass-half mr-1"></i>
                                                {{ $tender->days_remaining_text }}
                                            </span>
                                        @endif
                                    </div>
                                @elseif($tender->isClosed())
                                    <span class="text-red-600 text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Closed
                                    </span>
                                @elseif($tender->isUpcoming())
                                    <span class="text-yellow-600 text-sm">
                                        <i class="fas fa-clock mr-1"></i>
                                        Upcoming
                                    </span>
                                @endif
                            </td>
                            
                            @if(auth()->user()->can('tenders.view') || auth()->user()->can('tenders.edit') || auth()->user()->can('tenders.delete'))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('tenders.view')
                                            <a href="{{ route('admin.tenders.show', $tender) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                               title="View Tender Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('tenders.edit')
                                            <a href="{{ route('admin.tenders.edit', $tender) }}" 
                                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                               title="Edit Tender">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('tenders.edit')
                                            @if($tender->is_extended)
                                                <button type="button"
                                                        onclick="confirmRemoveExtension({{ $tender->id }}, '{{ addslashes($tender->name) }}')" 
                                                        class="text-orange-600 hover:text-orange-900 p-2 rounded hover:bg-orange-50 transition-colors"
                                                        title="Remove Extension">
                                                    <i class="fas fa-calendar-minus"></i>
                                                </button>
                                            @else
                                                <button type="button"
                                                        onclick="showExtendModal({{ $tender->id }}, '{{ addslashes($tender->name) }}', '{{ $tender->closing_date ? $tender->closing_date->format('Y-m-d') : '' }}')" 
                                                        class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                                        title="Extend Closing Date">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </button>
                                            @endif
                                        @endcan
                                        
                                        @can('tenders.delete')
                                            <button type="button"
                                                    onclick="confirmDelete({{ $tender->id }}, '{{ addslashes($tender->name) }}')" 
                                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                    title="Delete Tender">
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
                                    $colspan = 9;
                                    if(auth()->user()->can('tenders.delete')) $colspan++;
                                    if(auth()->user()->can('tenders.view') || auth()->user()->can('tenders.edit') || auth()->user()->can('tenders.delete')) $colspan++;
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-file-alt text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No tenders found</p>
                                    @if(request('search') || request('category') || request('status'))
                                        <a href="{{ route('admin.tenders.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear filters
                                        </a>
                                    @else
                                        @can('tenders.create')
                                            <a href="{{ route('admin.tenders.create') }}" class="text-emerald-600 hover:underline text-sm">
                                                Create your first tender →
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

    @if($tenders->hasPages())
        <div class="mt-4">
            {{ $tenders->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Tender</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete tender "<span id="deleteTenderName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All associated documents will be removed.</p>
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

{{-- Extend Date Modal --}}
<div id="extendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-calendar-plus text-blue-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4 text-center">Extend Closing Date</h3>
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-3">
                    Extend closing date for tender: <strong id="extendTenderName" class="text-emerald-600"></strong>
                </p>
                <p class="text-xs text-gray-500 mb-3">
                    Current closing date: <strong id="currentClosingDate"></strong>
                </p>
                <form id="extendForm" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Closing Date</label>
                        <input type="date" id="new_closing_date" name="new_closing_date" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <p class="text-xs text-gray-500 mt-1">Must be after the current closing date</p>
                    </div>
                    <div class="flex justify-center gap-3 mt-6">
                        <button type="button" id="cancelExtendBtn" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition">
                            Extend Date
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Remove Extension Confirmation Modal --}}
<div id="removeExtensionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100">
                <i class="fas fa-calendar-minus text-orange-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Remove Extension</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to remove the extension for tender "<span id="removeExtendTenderName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-orange-500 mt-2">This will reset the closing date to the original date.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelRemoveExtendBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="removeExtensionForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-md hover:bg-orange-700 transition">
                        Remove Extension
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bulk Delete Confirmation Modal --}}
@can('tenders.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Tenders</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> tender(s)?
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
        // Bulk delete functionality
        @can('tenders.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const tenderCheckboxes = document.querySelectorAll('.tender-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.tender-checkbox:checked');
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
            
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    tenderCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }
            
            tenderCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    if (selectAllCheckbox) {
                        const allChecked = tenderCheckboxes.length === document.querySelectorAll('.tender-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.tender-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one tender to delete.');
                        return;
                    }
                    
                    bulkDeleteCountSpan.textContent = count;
                    bulkDeleteModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            if (confirmBulkDeleteBtn) {
                confirmBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                    
                    const checkedBoxes = document.querySelectorAll('.tender-checkbox:checked');
                    checkedBoxes.forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'tender_ids[]';
                        input.value = checkbox.value;
                        bulkDeleteForm.appendChild(input);
                    });
                    bulkDeleteForm.submit();
                });
            }
            
            if (cancelBulkDeleteBtn) {
                cancelBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                });
            }
            
            window.addEventListener('click', function(e) {
                if (e.target === bulkDeleteModal) {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
                if (e.target === document.getElementById('deleteModal')) {
                    closeDeleteModal();
                }
                if (e.target === document.getElementById('extendModal')) {
                    closeExtendModal();
                }
                if (e.target === document.getElementById('removeExtensionModal')) {
                    closeRemoveExtensionModal();
                }
            });
            
            updateSelectedCount();
        @endcan
        
        // Delete confirmation functions
        @can('tenders.delete')
            window.confirmDelete = function(tenderId, tenderName) {
                const modal = document.getElementById('deleteModal');
                const deleteTenderNameSpan = document.getElementById('deleteTenderName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteTenderNameSpan.textContent = tenderName;
                deleteForm.action = `/admin/tenders/${tenderId}`;
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                document.getElementById('cancelDeleteBtn').onclick = function() {
                    closeDeleteModal();
                };
                
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeDeleteModal();
                    }
                };
            };
            
            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        @endcan
        
        // Extend date modal functions
        @can('tenders.edit')
            window.showExtendModal = function(tenderId, tenderName, currentClosingDate) {
                const modal = document.getElementById('extendModal');
                const extendTenderNameSpan = document.getElementById('extendTenderName');
                const extendForm = document.getElementById('extendForm');
                const newClosingDateInput = document.getElementById('new_closing_date');
                const currentClosingDateSpan = document.getElementById('currentClosingDate');
                
                extendTenderNameSpan.textContent = tenderName;
                extendForm.action = `/admin/tenders/${tenderId}/extend`;
                
                // Format current closing date
                if (currentClosingDate) {
                    const date = new Date(currentClosingDate);
                    currentClosingDateSpan.textContent = date.toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                    
                    // Set minimum date to current closing date + 1 day
                    const minDate = new Date(currentClosingDate);
                    minDate.setDate(minDate.getDate() + 1);
                    const year = minDate.getFullYear();
                    const month = String(minDate.getMonth() + 1).padStart(2, '0');
                    const day = String(minDate.getDate()).padStart(2, '0');
                    newClosingDateInput.min = `${year}-${month}-${day}`;
                }
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                document.getElementById('cancelExtendBtn').onclick = function() {
                    closeExtendModal();
                };
            };
            
            function closeExtendModal() {
                const modal = document.getElementById('extendModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
            
            // Remove extension modal functions
            window.confirmRemoveExtension = function(tenderId, tenderName) {
                const modal = document.getElementById('removeExtensionModal');
                const removeExtendTenderNameSpan = document.getElementById('removeExtendTenderName');
                const removeExtensionForm = document.getElementById('removeExtensionForm');
                
                removeExtendTenderNameSpan.textContent = tenderName;
                removeExtensionForm.action = `/admin/tenders/${tenderId}/remove-extension`;
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                document.getElementById('cancelRemoveExtendBtn').onclick = function() {
                    closeRemoveExtensionModal();
                };
                
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeRemoveExtensionModal();
                    }
                };
            };
            
            function closeRemoveExtensionModal() {
                const modal = document.getElementById('removeExtensionModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        @endcan
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @can('tenders.delete')
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
                @can('tenders.edit')
                    const extendModal = document.getElementById('extendModal');
                    const removeExtensionModal = document.getElementById('removeExtensionModal');
                    
                    if (extendModal && !extendModal.classList.contains('hidden')) {
                        closeExtendModal();
                    }
                    if (removeExtensionModal && !removeExtensionModal.classList.contains('hidden')) {
                        closeRemoveExtensionModal();
                    }
                @endcan
            }
        });
        
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