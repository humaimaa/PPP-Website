@extends('layouts.admin')

@section('title', 'Edit Update - PPP Unit KP')

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

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Update
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update news, announcement, or press release details</p>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 m-6">
                <div class="flex">
                    <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.updates.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div>
                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-heading"></i>
                            </span>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title', $news->title) }}"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('title') border-red-500 @enderror"
                                placeholder="Enter update title"
                            >
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-tag"></i>
                            </span>
                            <select
                                id="type"
                                name="type"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('type') border-red-500 @enderror"
                            >
                                <option value="">Select Type</option>
                                <option value="Update" {{ old('type', $news->type) == 'Update' ? 'selected' : '' }}>Update</option>
                                <option value="Announcement" {{ old('type', $news->type) == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                                <option value="Press Release" {{ old('type', $news->type) == 'Press Release' ? 'selected' : '' }}>Press Release</option>
                                <option value="Notice" {{ old('type', $news->type) == 'Notice' ? 'selected' : '' }}>Notice</option>
                                <option value="Other" {{ old('type', $news->type) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the type/category of this update</p>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- News Date --}}
                    <div class="mb-4">
                        <label for="news_date" class="block text-sm font-medium text-gray-700 mb-2">
                            News Date
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input
                                type="date"
                                id="news_date"
                                name="news_date"
                                value="{{ old('news_date', $news->news_date ? date('Y-m-d', strtotime($news->news_date)) : '') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('news_date') border-red-500 @enderror"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Leave empty to keep existing date or use current date. Cannot select future dates.
                        </p>
                        @error('news_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Featured --}}
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-1 text-yellow-500"></i>
                                Mark as Featured
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-8">Featured items appear prominently on the homepage</p>
                    </div>

                    {{-- Timestamps Info --}}
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mt-4">
                        <p class="text-sm text-gray-600">
                            <i class="far fa-calendar-plus mr-2 text-emerald-600"></i>
                            Created: <span class="font-medium">{{ $news->created_at->format('F d, Y') }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="far fa-calendar-check mr-2 text-emerald-600"></i>
                            Last Updated: <span class="font-medium">{{ $news->updated_at->format('F d, Y') }}</span>
                        </p>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    {{-- Current Image Container --}}
                    @if($news->img_path)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <img src="{{ Storage::url($news->img_path) }}" alt="Current image"
                                 class="w-full max-h-48 object-cover rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2 text-center">Current attached image</p>
                        </div>
                    </div>
                    @endif

                    {{-- New Image Selection --}}
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Replace Image (optional)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-image"></i>
                            </span>
                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/jpeg,image/png,image/gif,image/webp"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('image') border-red-500 @enderror"
                                onchange="validateAndPreviewImage(event)"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            JPG, PNG, GIF or WEBP (max 2MB). Leave empty to keep the current image.
                        </p>

                        {{-- New image preview (temporary) --}}
                        <div id="new-image-preview" class="mt-3 hidden">
                            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-image text-emerald-600 text-2xl"></i>
                                    <div class="flex-1">
                                        <p id="new-image-name" class="text-sm font-medium text-gray-700"></p>
                                        <p id="new-image-size" class="text-xs text-gray-500"></p>
                                    </div>
                                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                                </div>
                                <img id="new-image-thumb" src="" alt="New image preview"
                                     class="w-full max-h-40 object-cover rounded-lg border border-emerald-200">
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Live Preview (with image support) --}}
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-eye mr-1"></i> Live Preview
                        </h4>
                        <div id="previewCard" class="bg-white rounded-lg border border-gray-200 p-4">
                            <div class="flex items-start justify-between mb-2">
                                <span id="previewType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                    @if(old('type', $news->type) == 'Update') bg-green-100 text-green-800
                                    @elseif(old('type', $news->type) == 'Announcement') bg-yellow-100 text-yellow-800
                                    @elseif(old('type', $news->type) == 'Press Release') bg-red-100 text-red-800
                                    @elseif(old('type', $news->type) == 'Notice') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ old('type', $news->type) }}
                                </span>
                                <span id="previewFeatured" class="{{ old('is_featured', $news->is_featured) ? '' : 'hidden' }} text-yellow-500">
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            {{-- Live preview image - always present, but hidden if no image --}}
                            <div id="livePreviewImageContainer" class="mb-3 relative">
                                <img id="livePreviewImage" src="{{ $news->img_path ? Storage::url($news->img_path) : '' }}" 
                                     alt="Preview image" 
                                     class="w-full h-32 object-cover rounded-lg border border-gray-200 {{ $news->img_path ? '' : 'hidden' }}">
                                <div id="livePreviewImagePlaceholder" class="w-full h-32 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 {{ $news->img_path ? 'hidden' : 'flex' }}">
                                    <i class="fas fa-image text-2xl"></i>
                                    <span class="ml-2 text-sm">No image</span>
                                </div>
                            </div>
                            <h5 id="previewTitle" class="font-semibold text-gray-900 mb-2">{{ old('title', $news->title) }}</h5>
                            <p id="previewContent" class="text-sm text-gray-600 line-clamp-3">{{ old('content', Str::limit($news->content, 150)) }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Preview updates as you type or select a new image
                        </p>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <textarea
                        id="content"
                        name="content"
                        rows="8"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('content') border-red-500 @enderror"
                        placeholder="Write the update content here..."
                    >{{ old('content', $news->content) }}</textarea>
                </div>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-keyboard mr-1"></i>
                        <span id="charCount">{{ strlen(old('content', $news->content)) }}</span> characters
                    </p>
                    <p class="text-xs text-gray-400">Tip: Use clear and concise language for better engagement</p>
                </div>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Information --}}
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Updates</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Updates can be of various types: <strong>Update</strong>, <strong>Announcement</strong>, 
                            <strong>Press Release</strong>, <strong>Notice</strong>, or <strong>Other</strong>. 
                            Featured updates will be highlighted on the homepage. You can attach an image for 
                            visual context or illustration.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                <a href="{{ route('admin.updates.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect      = document.getElementById('type');
    const contentTextarea = document.getElementById('content');
    const charCount       = document.getElementById('charCount');
    const titleInput      = document.getElementById('title');
    const featuredChk     = document.getElementById('is_featured');
    const previewType     = document.getElementById('previewType');
    const previewTitle    = document.getElementById('previewTitle');
    const previewContent  = document.getElementById('previewContent');
    const previewFeatured = document.getElementById('previewFeatured');
    const imageInput      = document.getElementById('image');
    const livePreviewImg  = document.getElementById('livePreviewImage');
    const livePreviewPlaceholder = document.getElementById('livePreviewImagePlaceholder');

    const typeColors = {
        'Update':        'bg-green-100 text-green-800',
        'Announcement':  'bg-yellow-100 text-yellow-800',
        'Press Release': 'bg-red-100 text-red-800',
        'Notice':        'bg-orange-100 text-orange-800',
        'Other':         'bg-gray-100 text-gray-800',
    };

    function updatePreview() {
        const type = typeSelect.value || 'Update';
        previewType.textContent = type;
        previewType.className = `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${typeColors[type] || 'bg-gray-100 text-gray-800'}`;
        previewTitle.textContent = titleInput.value.trim() || 'Title will appear here';
        
        let contentPreview = contentTextarea.value.trim();
        if (contentPreview.length > 150) {
            contentPreview = contentPreview.substring(0, 150) + '...';
        }
        previewContent.textContent = contentPreview || 'Content preview will appear here...';
        
        if (featuredChk && featuredChk.checked) {
            previewFeatured.classList.remove('hidden');
        } else {
            previewFeatured.classList.add('hidden');
        }
    }

    // Update live preview image when a new file is selected
    function updateLivePreviewImage(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                livePreviewImg.src = e.target.result;
                livePreviewImg.classList.remove('hidden');
                livePreviewPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            // No new file: revert to current image if exists
            const currentSrc = "{{ $news->img_path ? Storage::url($news->img_path) : '' }}";
            if (currentSrc) {
                livePreviewImg.src = currentSrc;
                livePreviewImg.classList.remove('hidden');
                livePreviewPlaceholder.classList.add('hidden');
            } else {
                livePreviewImg.classList.add('hidden');
                livePreviewPlaceholder.classList.remove('hidden');
            }
        }
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', updatePreview);
    }
    
    if (titleInput) {
        titleInput.addEventListener('input', updatePreview);
    }
    
    if (contentTextarea) {
        contentTextarea.addEventListener('input', () => {
            if (charCount) charCount.textContent = contentTextarea.value.length;
            updatePreview();
        });
    }
    
    if (featuredChk) {
        featuredChk.addEventListener('change', updatePreview);
    }

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            updateLivePreviewImage(file);
        });
    }

    // Initialize character count and preview
    if (charCount && contentTextarea) {
        charCount.textContent = contentTextarea.value.length;
    }
    updatePreview();
});

// Image validation and preview (separate box for new image selection)
function validateAndPreviewImage(event) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById('new-image-preview');
    const imgName = document.getElementById('new-image-name');
    const imgSize = document.getElementById('new-image-size');
    const imgThumb = document.getElementById('new-image-thumb');

    if (!file) {
        if (previewDiv) previewDiv.classList.add('hidden');
        return;
    }

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Please upload a valid image file (JPG, PNG, GIF, or WEBP).');
        event.target.value = '';
        if (previewDiv) previewDiv.classList.add('hidden');
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB. Current file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
        event.target.value = '';
        if (previewDiv) previewDiv.classList.add('hidden');
        return;
    }

    // Display file info
    if (imgName) imgName.textContent = file.name;
    if (imgSize) {
        imgSize.textContent = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(2) + ' KB'
            : (file.size / 1024 / 1024).toFixed(2) + ' MB';
    }

    // Show thumbnail preview in the separate box
    if (imgThumb) {
        const reader = new FileReader();
        reader.onload = e => { imgThumb.src = e.target.result; };
        reader.readAsDataURL(file);
    }

    if (previewDiv) previewDiv.classList.remove('hidden');
}
</script>
@endpush