@extends('layouts.admin')

@section('title', 'Leadership Messages - PPP Department KPK')
@section('header-title', 'Leadership Messages')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Header with Add Button --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Leadership Messages</h2>
            <p class="text-sm text-gray-500 mt-1">Manage leadership and staff messages</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button --}}
            <button type="button" id="bulkDeleteBtn" 
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition"
                    style="display: none;">
                <i class="fas fa-trash-alt"></i>
                Delete Selected (<span id="selectedCount">0</span>)
            </button>
            
            <a href="{{ route('admin.leadership.add') }}" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-plus"></i>
                Add New Message
            </a>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Messages Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-comment-dots mr-2 text-emerald-600"></i>
                        All Messages
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $messages->total() }}</span> messages
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.leadership.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name or designation..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.leadership.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.leadership.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <input type="checkbox" 
                                       id="selectAllCheckbox" 
                                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($messages as $msg)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           name="message_ids[]" 
                                           value="{{ $msg->id }}"
                                           class="message-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($msg->image)
                                        <img src="{{ asset('storage/' . $msg->image) }}"
                                             alt="{{ $msg->name }}"
                                             class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900">{{ $msg->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $msg->designation }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 max-w-xs">
                                        {{ Str::limit($msg->message, 80) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                    {{ $msg->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View Button --}}
                                        <a href="{{ route('admin.leadership.show', $msg->id) }}"
                                           class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                           title="View Message">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin.leadership.edit', $msg->id) }}"
                                           class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                           title="Edit Message">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete Form --}}
                                        <button onclick="confirmDelete({{ $msg->id }}, '{{ $msg->name }}')" 
                                                class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                title="Delete Message">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </table>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-comment-dots text-4xl mb-3 opacity-50"></i>
                                    <p class="text-lg">No messages found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.leadership.index') }}" class="text-emerald-600 hover:underline text-sm mt-2 inline-block">
                                            Clear search
                                        </a>
                                    @else
                                        <p class="text-sm mt-1">Click "Add New Message" to create your first message</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Pagination --}}
        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $messages->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Message</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete message from "<span id="deleteMessageName" class="font-semibold text-gray-700"></span>"?
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
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Messages</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> message(s)?
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const messageCheckboxes = document.querySelectorAll('.message-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
        const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
        const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
        
        // Update selected count and show/hide bulk delete button
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
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
                messageCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedCount();
            });
        }
        
        // Individual checkbox change
        messageCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                
                // Update select all checkbox state
                if (selectAllCheckbox) {
                    const allChecked = messageCheckboxes.length === document.querySelectorAll('.message-checkbox:checked').length;
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
        
        // Bulk delete button click - show modal
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function(e) {
                const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
                const count = checkedBoxes.length;
                
                if (count === 0) {
                    alert('Please select at least one message to delete.');
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
        });
        
        // Initialize count on page load
        updateSelectedCount();
    });
    
    // Delete confirmation function
    function confirmDelete(messageId, messageName) {
        const modal = document.getElementById('deleteModal');
        const deleteMessageNameSpan = document.getElementById('deleteMessageName');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteMessageNameSpan.textContent = messageName;
        deleteForm.action = `/admin/leadership/${messageId}`;
        
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