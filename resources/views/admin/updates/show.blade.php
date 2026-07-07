@extends('layouts.admin')

@section('title', $news->title . ' - Update Details - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.updates.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Updates
        </a>
    </div>

    {{-- Update Header Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-bullhorn text-emerald-600 text-xl"></i>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $news->title }}</h3>
                        @php
                            $typeColors = [
                                'Update' => 'bg-green-100 text-green-800',
                                'Announcement' => 'bg-yellow-100 text-yellow-800',
                                'Press Release' => 'bg-red-100 text-red-800',
                                'Notice' => 'bg-orange-100 text-orange-800',
                                'Other' => 'bg-gray-100 text-gray-800',
                            ];
                            $badgeClass = $typeColors[$news->type] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                            <i class="fas fa-tag mr-1 text-xs"></i>
                            {{ $news->type }}
                        </span>
                        @if($news->is_featured)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1 text-xs"></i>
                                Featured
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-align-left mr-2 text-emerald-600"></i>
                Content
            </h4>
            <div class="prose max-w-none">
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $news->content }}</p>
                </div>
            </div>
        </div>

        {{-- Basic Information --}}
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                Information Details
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                    <p class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium {{ $badgeClass }}">
                        <i class="fas fa-tag mr-1 text-xs"></i>
                        {{ $news->type }}
                    </p>
                </div>
                
                {{-- News Date Field --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">News Date</label>
                    @php
                        $displayDate = $news->news_date ?? $news->created_at;
                    @endphp
                    <p class="text-gray-900">
                        <i class="fas fa-calendar-alt text-emerald-600 mr-1"></i>
                        {{ $displayDate->format('F d, Y') }}
                        @if($displayDate->format('H:i:s') != '00:00:00')
                            
                        @endif
                    </p>
                    @if($news->news_date && $news->created_at)
                        <p class="text-xs text-gray-400 mt-1">
                            <i class="far fa-clock mr-1"></i>
                            Created: {{ $news->created_at->format('F d, Y') }}
                        </p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Featured Status</label>
                    @if($news->is_featured)
                        <p class="text-yellow-600">
                            <i class="fas fa-star mr-1"></i>
                            Featured Update
                        </p>
                        <p class="text-xs text-gray-500 mt-1">This update appears prominently on the homepage</p>
                    @else
                        <p class="text-gray-500">
                            <i class="far fa-star mr-1"></i>
                            Not Featured
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Image Attachment Section --}}
        @if($news->img_path)
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-image mr-2 text-emerald-600"></i>
                Attached Image
            </h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <img src="{{ Storage::url($news->img_path) }}" alt="{{ $news->title }}"
                     class="w-full max-h-80 object-cover rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Uploaded: {{ $news->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
        @endif

        {{-- Timeline Information --}}
        <div class="p-6">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-history mr-2 text-emerald-600"></i>
                Timeline Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Created</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $news->created_at->format('F d, Y') }}</p>
                          
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Last Updated</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $news->updated_at->format('F d, Y') }}</p>
                           
                            @if($news->created_at != $news->updated_at)
                                <p class="text-xs text-gray-400 mt-1">(Updated {{ $news->updated_at->diffForHumans() }})</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Additional Info: Time difference between News Date and Created Date --}}
            @if($news->news_date && $news->created_at)
                @php
                    $newsDate = \Carbon\Carbon::parse($news->news_date);
                    $diffDays = $newsDate->diffInDays($news->created_at);
                @endphp
                
            @endif
        </div>
    </div>
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

{{-- Toggle Featured Form --}}
<form id="toggleFeaturedForm" method="POST" style="display: none;">
    @csrf
    @method('POST')
</form>

@push('scripts')
<script>
    // Delete confirmation
    window.confirmDelete = function(updateId, updateName) {
        const modal = document.getElementById('deleteModal');
        const deleteUpdateNameSpan = document.getElementById('deleteUpdateName');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteUpdateNameSpan.textContent = updateName;
        deleteForm.action = `/admin/updates/${updateId}`;
        
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
    
    // Toggle featured function
    window.toggleFeatured = function(updateId, isCurrentlyFeatured) {
        const action = isCurrentlyFeatured ? 'unfeature' : 'feature';
        const form = document.getElementById('toggleFeaturedForm');
        form.action = `/admin/updates/${updateId}/${action}`;
        
        const message = isCurrentlyFeatured 
            ? 'Remove this update from featured section?' 
            : 'Mark this update as featured? Featured updates appear prominently on the homepage.';
        
        if (confirm(message)) {
            form.submit();
        }
    };
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const deleteModal = document.getElementById('deleteModal');
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection