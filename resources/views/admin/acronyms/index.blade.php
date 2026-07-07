@extends('layouts.admin')

@section('title', 'Acronyms - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Acronyms</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage acronyms with their full forms</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button --}}
            @can('acronyms.delete')
            <button type="button" id="bulkDeleteBtn"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                style="display: none;">
                <i class="fas fa-trash-alt"></i>
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            @endcan

            @can('acronyms.create')
            <a href="{{ route('admin.acronyms.add') }}"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                <i class="fas fa-plus"></i>
                Add Acronym
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
                        <i class="fas fa-font mr-2 text-emerald-600"></i>
                        All Acronyms
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $acronyms->total() }}</span> acronyms
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.acronyms.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by acronym or full form..."
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('admin.acronyms.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- BULK DELETE FORM - Outside the table and hidden --}}
        <form id="bulkDeleteForm" action="{{ route('admin.acronyms.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="acronym_ids" id="bulkDeleteIds" value="">
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        @can('acronyms.delete')
                        <th class="px-6 py-3 text-left w-10">
                            <input type="checkbox" id="selectAllCheckbox"
                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </th>
                        @endcan
                        <th class="px-6 py-3 text-left">Acronym</th>
                        <th class="px-6 py-3 text-left">Stands For</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        @if(auth()->user()->can('acronyms.edit') || auth()->user()->can('acronyms.delete'))
                        <th class="px-6 py-3 text-right">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($acronyms as $acronym)
                    <tr class="hover:bg-gray-50 transition" data-acronym-id="{{ $acronym->id }}">

                        

                        <td class="px-6 py-4 text-gray-500 text-xs">
                            #{{ $acronym->id }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md text-sm">
                                {{ $acronym->acronym }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-gray-800">{{ $acronym->standfor }}</span>
                        </td>

                        <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $acronym->created_at->format('M d, Y') }}
                        </td>

                        @if(auth()->user()->can('acronyms.edit') || auth()->user()->can('acronyms.delete'))
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                @can('acronyms.edit')
                                <a href="{{ route('admin.acronyms.edit', $acronym) }}"
                                    class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                    title="Edit Acronym">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('acronyms.delete')
                                <button type="button"
                                    onclick="confirmDelete({{ $acronym->id }}, '{{ addslashes($acronym->acronym) }}')"
                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                    title="Delete Acronym">
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
                        $colspan = 5; // ID, Acronym, Stands For, Created
                        if(auth()->user()->can('acronyms.delete')) $colspan++; // Checkbox
                        if(auth()->user()->can('acronyms.edit') || auth()->user()->can('acronyms.delete')) $colspan++; // Actions
                        @endphp
                        <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-font text-4xl mb-2"></i>
                            <p class="text-lg mb-1">No acronyms found</p>
                            @if(request('search'))
                            <a href="{{ route('admin.acronyms.index') }}"
                                class="text-emerald-600 hover:underline text-sm">
                                Clear search
                            </a>
                            @else
                            @can('acronyms.create')
                            <a href="{{ route('admin.acronyms.add') }}"
                                class="text-emerald-600 hover:underline text-sm">
                                Create your first acronym →
                            </a>
                            @endcan
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($acronyms->hasPages())
    <div class="mt-4">
        {{ $acronyms->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Acronym</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete acronym "<span id="deleteAcronymName"
                        class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All associated data will be removed.
                </p>
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
@can('acronyms.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Acronyms</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount"
                        class="font-semibold text-gray-700"></span> acronym(s)?
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

        @can('acronyms.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const acronymCheckboxes = document.querySelectorAll('.acronym-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.acronym-checkbox:checked');
                const count = checkedBoxes.length;
                if (selectedCountSpan) selectedCountSpan.textContent = count;
                if (bulkDeleteBtn) {
                    bulkDeleteBtn.style.display = count > 0 ? 'inline-flex' : 'none';
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    acronymCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }

            acronymCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked =
                            acronymCheckboxes.length === document.querySelectorAll('.acronym-checkbox:checked').length;
                    }
                });
            });

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.acronym-checkbox:checked');
                    const count = checkedBoxes.length;
                    if (count === 0) {
                        alert('Please select at least one acronym to delete.');
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
                    
                    // Get all checked checkboxes
                    const checkedBoxes = document.querySelectorAll('.acronym-checkbox:checked');
                    const ids = Array.from(checkedBoxes).map(cb => cb.value);
                    
                    // Set the hidden input value
                    document.getElementById('bulkDeleteIds').value = ids.join(',');
                    
                    // Submit the form
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
            });

            updateSelectedCount();
        @endcan

        @can('acronyms.delete')
            window.confirmDelete = function(acronymId, acronymName) {
                const modal = document.getElementById('deleteModal');
                const deleteAcronymNameSpan = document.getElementById('deleteAcronymName');
                const deleteForm = document.getElementById('deleteForm');

                deleteAcronymNameSpan.textContent = acronymName;
                deleteForm.action = `/admin/acronyms/${acronymId}`;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                document.getElementById('cancelDeleteBtn').onclick = function() {
                    closeDeleteModal();
                };

                modal.onclick = function(e) {
                    if (e.target === modal) closeDeleteModal();
                };
            };

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    if (deleteForm) deleteForm.action = '';
                }
            }
        @endcan

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @can('acronyms.delete')
                    const deleteModal = document.getElementById('deleteModal');
                    const bulkDeleteModal = document.getElementById('bulkDeleteModal');
                    if (deleteModal && !deleteModal.classList.contains('hidden')) closeDeleteModal();
                    if (bulkDeleteModal && !bulkDeleteModal.classList.contains('hidden')) {
                        bulkDeleteModal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                @endcan
            }
        });

        // Auto-hide flash messages after 5 seconds
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