@extends('layouts.admin')

@section('title', 'Events - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Events</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all events and their gallery images</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button - Only show if user has delete permission --}}
            @can('gallery.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            {{-- Add New Event Button --}}
            @can('gallery.create')
                <a href="{{ route('admin.events.add') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add New Event
                </a>
            @endcan
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Events Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                        All Events
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $events->total() }}</span> events
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.events.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by title or location..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.events.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('gallery.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">Thumbnail</th>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-left">Location</th>
                            <th class="px-6 py-3 text-left">Event Date</th>
                            <th class="px-6 py-3 text-left">Images</th>
                            <th class="px-6 py-3 text-left">Created</th>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('gallery.view') || auth()->user()->can('gallery.edit') || auth()->user()->can('gallery.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($events as $event)
                            @php
                                $thumbnail = $event->gallery->where('is_thumbnail', true)->first();
                                $thumbnailUrl = $thumbnail ? asset('storage/' . $thumbnail->image) : asset('images/default-event.jpg');
                                $imageCount = $event->gallery->count();
                                $description = $event->description ? Str::limit($event->description, 100) : '';
                            @endphp
                            <tr class="hover:bg-gray-50 transition" data-event-id="{{ $event->id }}">
                                {{-- Checkbox column - Only show if user has delete permission --}}
                                @can('gallery.delete')
                                    <td class="px-6 py-4">
                                        <input type="checkbox" 
                                               name="event_ids[]" 
                                               value="{{ $event->id }}"
                                               class="event-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    </td>
                                @endcan
                                
                                <td class="px-6 py-4">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ $thumbnailUrl }}" 
                                             alt="{{ $event->title }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://via.placeholder.com/48?text=No+Image'">
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900">{{ Str::limit($event->title, 50) }}</span>
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($description)
                                        <span class="text-gray-600 line-clamp-2 max-w-xs" title="{{ $event->description }}">
                                            {{ $description }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($event->location)
                                        <div class="text-gray-600">
                                            <i class="fas fa-map-marker-alt text-emerald-500 text-xs mr-1"></i>
                                            {{ Str::limit($event->location, 30) }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-600">
                                        <i class="far fa-calendar-alt text-emerald-500 text-xs mr-1"></i>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-md">
                                        <i class="fas fa-images mr-1"></i>
                                        {{ $imageCount }} {{ $imageCount === 1 ? 'image' : 'images' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                    {{ $event->created_at->format('M d, Y') }}
                                </td>
                                
                                {{-- Actions column - Only show if user has any action permissions --}}
                                @if(auth()->user()->can('gallery.view') || auth()->user()->can('gallery.edit') || auth()->user()->can('gallery.delete'))
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- View Button --}}
                                            @can('gallery.view')
                                                <a href="{{ route('admin.events.show', $event) }}" 
                                                   class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan
                                            
                                            {{-- Edit Button --}}
                                            @can('gallery.edit')
                                                <a href="{{ route('admin.events.edit', $event) }}" 
                                                   class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                                   title="Edit Event">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            
                                            {{-- Delete Button --}}
                                            @can('gallery.delete')
                                                <button type="button" 
                                                        onclick="confirmDelete({{ $event->id }}, '{{ addslashes($event->title) }}')"
                                                        class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                        title="Delete Event">
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
                                    $colspan = 8; // Base columns (Thumbnail, Title, Description, Location, Event Date, Images, Created)
                                    if(auth()->user()->can('gallery.delete')) $colspan++; // Add checkbox column
                                    if(auth()->user()->can('gallery.view') || auth()->user()->can('gallery.edit') || auth()->user()->can('gallery.delete')) $colspan++; // Add actions column
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-calendar-alt text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No events found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.events.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear search
                                        </a>
                                    @else
                                        @can('gallery.create')
                                            <a href="{{ route('admin.events.add') }}" class="text-emerald-600 hover:underline text-sm">
                                                Add your first event →
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

    {{-- Pagination --}}
    @if($events->hasPages())
        <div class="mt-4">
            {{ $events->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Event</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete "<span id="deleteEventName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All gallery images will be permanently deleted.</p>
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
@can('gallery.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Events</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> event(s)?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All gallery images will be permanently deleted.</p>
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
        @can('gallery.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const eventCheckboxes = document.querySelectorAll('.event-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.event-checkbox:checked');
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
                    eventCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }
            
            eventCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    if (selectAllCheckbox) {
                        const allChecked = eventCheckboxes.length === document.querySelectorAll('.event-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.event-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one event to delete.');
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
        
        // Delete confirmation function - Only define if user has delete permission
        @can('gallery.delete')
            window.confirmDelete = function(eventId, eventName) {
                const modal = document.getElementById('deleteModal');
                const deleteEventNameSpan = document.getElementById('deleteEventName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteEventNameSpan.textContent = eventName;
                deleteForm.action = `/admin/events/${eventId}`;
                
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
                @can('gallery.delete')
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
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);
    });
</script>
@endpush
@endsection