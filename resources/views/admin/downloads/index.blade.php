@extends('layouts.admin')

@section('title', 'Manage Documents - PPP Unit KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Documents</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all uploaded documents</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button --}}
            <button type="button" id="bulkDeleteBtn" 
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                    style="display: none;">
                <i class="fas fa-trash-alt"></i>
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            
            {{-- Add Document Button --}}
            <a href="{{ route('admin.downloads.add') }}" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                <i class="fas fa-plus"></i>
                Add New Document
            </a>
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
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-file-alt mr-2 text-emerald-600"></i>
                        All Documents
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $downloads->total() }}</span> documents
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.downloads.index') }}" class="flex gap-2">
                        <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Categories</option>
                            <option value="Legal Framework" {{ request('category') == 'Legal Framework' ? 'selected' : '' }}>Legal Framework</option>
                            <option value="Prequalified Transaction Advisory" {{ request('category') == 'Prequalified Transaction Advisory' ? 'selected' : '' }}>Prequalified Transaction Advisory</option>
                            <option value="Policies ,Regulations and Guidelines" {{ request('category') == 'Policies ,Regulations and Guidelines' ? 'selected' : '' }}>Policies, Regulations and Guidelines</option>
                            <option value="Knowledge Hub" {{ request('category') == 'Knowledge Hub' ? 'selected' : '' }}>Knowledge Hub</option>
                            <option value="Pitchbook" {{ request('category') == 'Pitchbook' ? 'selected' : '' }}>Pitchbook</option>
                        </select>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by title..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('admin.downloads.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.downloads.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left w-10">
                                <input type="checkbox" 
                                       id="selectAllCheckbox" 
                                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </th>
                          
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Document Date</th>
                            <th class="px-6 py-3 text-left">Uploaded At</th>
                            <th class="px-6 py-3 text-left">File</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($downloads as $download)
                        <tr class="hover:bg-gray-50 transition" data-download-id="{{ $download->id }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       name="document_ids[]" 
                                       value="{{ $download->id }}"
                                       class="download-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </td>
                           
                               
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $download->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($download->category == 'Legal Framework') bg-purple-100 text-purple-800
                                    @elseif($download->category == 'Prequalified Transaction Advisory') bg-blue-100 text-blue-800
                                    @elseif($download->category == 'Policies ,Regulations and Guidelines') bg-indigo-100 text-indigo-800
                                    @elseif($download->category == 'Knowledge Hub') bg-green-100 text-green-800
                                    @elseif($download->category == 'Pitchbook') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    <i class="fas fa-folder mr-1 text-xs"></i>
                                    @if($download->category == 'Policies ,Regulations and Guidelines')
                                        Policies & Guidelines
                                    @else
                                        {{ $download->category }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-600">
                                    <i class="far fa-calendar-alt text-emerald-500 text-xs mr-1"></i>
                                    {{ \Carbon\Carbon::parse($download->date)->format('M d, Y') }}
                                </div>
                             </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-500 text-xs">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $download->created_at->format('M d, Y ') }}
                                </div>
                             </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ asset('storage/' . $download->document_path) }}" 
                                   target="_blank"
                                   class="text-emerald-600 hover:text-emerald-900 flex items-center gap-1">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <span>View PDF</span>
                                </a>
                             </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.downloads.edit', $download) }}" 
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                       title="Edit Document">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            onclick="confirmDelete({{ $download->id }}, '{{ addslashes($download->title) }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                            title="Delete Document">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                             </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-file-alt text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No documents found</p>
                                    @if(request('search') || request('category'))
                                        <a href="{{ route('admin.downloads.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear filters
                                        </a>
                                    @else
                                        <a href="{{ route('admin.downloads.add') }}" class="text-emerald-600 hover:underline text-sm">
                                            Upload your first document →
                                        </a>
                                    @endif
                                 </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    @if($downloads->hasPages())
        <div class="mt-4">
            {{ $downloads->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Document</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete document "<span id="deleteDocumentName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. The file will be permanently deleted.</p>
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
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Documents</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> document(s)?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All files will be permanently deleted.</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const downloadCheckboxes = document.querySelectorAll('.download-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
        const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
        const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
        
        // Update selected count and show/hide bulk delete button
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.download-checkbox:checked');
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
                downloadCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedCount();
            });
        }
        
        // Individual checkbox change
        downloadCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                
                // Update select all checkbox state
                if (selectAllCheckbox) {
                    const allChecked = downloadCheckboxes.length === document.querySelectorAll('.download-checkbox:checked').length;
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
        
        // Bulk delete button click - show modal
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkedBoxes = document.querySelectorAll('.download-checkbox:checked');
                const count = checkedBoxes.length;
                
                if (count === 0) {
                    alert('Please select at least one document to delete.');
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
        
        // Delete confirmation functions
        window.confirmDelete = function(downloadId, downloadTitle) {
            const modal = document.getElementById('deleteModal');
            const deleteDocumentNameSpan = document.getElementById('deleteDocumentName');
            const deleteForm = document.getElementById('deleteForm');
            
            deleteDocumentNameSpan.textContent = downloadTitle;
            deleteForm.action = `/admin/downloads/${downloadId}`;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Close modal on cancel
            document.getElementById('cancelDeleteBtn').onclick = function() {
                closeDeleteModal();
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
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const deleteModal = document.getElementById('deleteModal');
                const bulkDeleteModalElem = document.getElementById('bulkDeleteModal');
                
                if (deleteModal && !deleteModal.classList.contains('hidden')) {
                    closeDeleteModal();
                }
                if (bulkDeleteModalElem && !bulkDeleteModalElem.classList.contains('hidden')) {
                    bulkDeleteModalElem.classList.add('hidden');
                    document.body.style.overflow = '';
                }
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
@endsection