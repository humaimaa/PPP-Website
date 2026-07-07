@extends('layouts.admin')

@section('title', 'Updates - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Updates</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage news, announcements, and press releases</p>
        </div>
        <div class="flex gap-3">
            @can('news.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            @can('news.create')
                <a href="{{ route('admin.updates.create') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add Update
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
                        <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                        All Updates
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $news->total() }}</span> updates
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.updates.index') }}" class="flex gap-2">
                        <select name="type" 
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Types</option>
                            <option value="Update" {{ request('type') == 'Update' ? 'selected' : '' }}>Update</option>
                            <option value="Announcement" {{ request('type') == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                            <option value="Press Release" {{ request('type') == 'Press Release' ? 'selected' : '' }}>Press Release</option>
                            <option value="Notice" {{ request('type') == 'Notice' ? 'selected' : '' }}>Notice</option>
                            <option value="Other" {{ request('type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        
                        <select name="featured" 
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Status</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
                        </select>
                        
                        <select name="publish" 
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">All Publish Status</option>
                            <option value="yes" {{ request('publish') == 'yes' ? 'selected' : '' }}>Published</option>
                            <option value="no" {{ request('publish') == 'no' ? 'selected' : '' }}>Draft</option>
                        </select>
                        
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search updates by title..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search') || request('type') || request('featured') || request('publish'))
                            <a href="{{ route('admin.updates.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- BULK DELETE FORM --}}
        <form id="bulkDeleteForm" action="{{ route('admin.updates.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="update_ids" id="bulkDeleteIds" value="">
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        @can('news.delete')
                            <th class="px-6 py-3 text-left w-10">
                                <input type="checkbox" 
                                       id="selectAllCheckbox" 
                                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </th>
                        @endcan
                        <th class="px-6 py-3 text-left">Title & Content</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Featured</th>
                        <th class="px-6 py-3 text-left">Published</th>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        @if(auth()->user()->can('news.view') || auth()->user()->can('news.edit') || auth()->user()->can('news.delete'))
                            <th class="px-6 py-3 text-right">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($news as $item)
                    <tr class="hover:bg-gray-50 transition" data-update-id="{{ $item->id }}">
                        @can('news.delete')
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       name="update_ids[]" 
                                       value="{{ $item->id }}"
                                       class="update-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </td>
                        @endcan
                        
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-medium text-gray-900">{{ $item->title }}</span>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ Str::limit($item->content, 80) }}
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            @php
                                $typeColors = [
                                    'Update' => 'bg-green-100 text-green-800',
                                    'Announcement' => 'bg-yellow-100 text-yellow-800',
                                    'Press Release' => 'bg-red-100 text-red-800',
                                    'Notice' => 'bg-orange-100 text-orange-800',
                                    'Other' => 'bg-gray-100 text-gray-800',
                                ];
                                $badgeClass = $typeColors[$item->type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $badgeClass }}">
                                <i class="fas fa-tag mr-1 text-xs"></i>
                                {{ $item->type }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($item->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-star mr-1 text-xs"></i>
                                    Featured
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>

                        {{-- PUBLISH TOGGLE --}}
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.updates.toggle-publish', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                    class="relative inline-flex items-center h-8 rounded-full w-14 transition-colors duration-300 focus:outline-none
                                    {{ $item->publish == 'yes' ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                    <span class="sr-only">{{ $item->publish == 'yes' ? 'Published' : 'Draft' }}</span>
                                    <span class="inline-block h-6 w-6 transform rounded-full bg-white shadow-lg transition-transform duration-300
                                        {{ $item->publish == 'yes' ? 'translate-x-7' : 'translate-x-1' }}">
                                    </span>
                                </button>
                            </form>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($item->img_path)
                                <img src="{{ Storage::url($item->img_path) }}" alt="{{ $item->title }}"
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4">
                            @php
                                $displayDate = $item->news_date ? \Carbon\Carbon::parse($item->news_date) : $item->created_at;
                            @endphp
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600">
                                    <i class="far fa-calendar-alt mr-1 text-emerald-600"></i>
                                    {{ $displayDate->format('M d, Y') }}
                                </span>
                                @if($item->news_date)
                                    <span class="text-xs text-gray-400 mt-1">
                                        <i class="far fa-clock mr-1"></i>
                                        Created: {{ $item->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        @if(auth()->user()->can('news.view') || auth()->user()->can('news.edit') || auth()->user()->can('news.delete'))
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @can('news.view')
                                        <a href="{{ route('admin.updates.show', $item) }}" 
                                           class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                           title="View Update Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                    
                                    @can('news.edit')
                                        <a href="{{ route('admin.updates.edit', $item) }}" 
                                           class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                           title="Edit Update">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    
                                    @can('news.edit')
                                        <button type="button"
                                                onclick="toggleFeatured({{ $item->id }}, {{ $item->is_featured ? 'true' : 'false' }})" 
                                                class="{{ $item->is_featured ? 'text-yellow-600 hover:text-yellow-900' : 'text-gray-500 hover:text-yellow-600' }} p-2 rounded hover:bg-yellow-50 transition-colors"
                                                title="{{ $item->is_featured ? 'Remove Featured' : 'Mark as Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @endcan
                                    
                                    @can('news.delete')
                                        <button type="button"
                                                onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->title) }}')" 
                                                class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                title="Delete Update">
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
                                $colspan = 7; // title, type, featured, published, image, date, actions
                                if(auth()->user()->can('news.delete')) $colspan++; // checkbox
                                if(auth()->user()->can('news.view') || auth()->user()->can('news.edit') || auth()->user()->can('news.delete')) $colspan++; // actions
                            @endphp
                            <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-bullhorn text-4xl mb-2"></i>
                                <p class="text-lg mb-1">No updates found</p>
                                @if(request('search') || request('type') || request('featured') || request('publish'))
                                    <a href="{{ route('admin.updates.index') }}" class="text-emerald-600 hover:underline text-sm">
                                        Clear filters
                                    </a>
                                @else
                                    @can('news.create')
                                        <a href="{{ route('admin.updates.create') }}" class="text-emerald-600 hover:underline text-sm">
                                            Create your first update →
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

    @if($news->hasPages())
        <div class="mt-4">
            {{ $news->appends(request()->query())->links() }}
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
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Update</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete update "<span id="deleteUpdateName" class="font-semibold text-gray-700"></span>"?
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

{{-- Bulk Delete Confirmation Modal --}}
@can('news.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Updates</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> update(s)?
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

{{-- Toggle Featured Form --}}
<form id="toggleFeaturedForm" method="POST" style="display: none;">
    @csrf
    @method('POST')
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @can('news.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const updateCheckboxes = document.querySelectorAll('.update-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.update-checkbox:checked');
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
                    updateCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }
            
            updateCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    if (selectAllCheckbox) {
                        const allChecked = updateCheckboxes.length === document.querySelectorAll('.update-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.update-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one update to delete.');
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
                    
                    const checkedBoxes = document.querySelectorAll('.update-checkbox:checked');
                    // Get IDs as array and join with comma
                    const ids = Array.from(checkedBoxes).map(cb => cb.value);
                    
                    // Set the hidden input value as comma-separated string
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
        
        @can('news.delete')
            window.confirmDelete = function(updateId, updateName) {
                const modal = document.getElementById('deleteModal');
                const deleteUpdateNameSpan = document.getElementById('deleteUpdateName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteUpdateNameSpan.textContent = updateName;
                deleteForm.action = `/admin/updates/${updateId}`;
                
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
        
        @can('news.edit')
            window.toggleFeatured = function(updateId, isCurrentlyFeatured) {
                const action = isCurrentlyFeatured ? 'unfeature' : 'feature';
                const form = document.getElementById('toggleFeaturedForm');
                form.action = `/admin/updates/${updateId}/${action}`;
                form.submit();
            };
        @endcan
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @can('news.delete')
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