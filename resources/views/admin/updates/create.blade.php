@extends('layouts.admin')

@section('title', 'Add Update - PPP Unit KP')
@section('header-title', 'Add New Update')

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
                    <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                    Add New Update
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new news update, announcement, or event</p>
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

        <form action="{{ route('admin.updates.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

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
                                value="{{ old('title') }}"
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
                                <option value="Update" {{ old('type') == 'Update' ? 'selected' : '' }}>Update</option>
                                <option value="Announcement" {{ old('type') == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                                <option value="Press Release" {{ old('type') == 'Press Release' ? 'selected' : '' }}>Press Release</option>
                                <option value="Notice" {{ old('type') == 'Notice' ? 'selected' : '' }}>Notice</option>
                                <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the type/category of this update</p>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- News Date --}}
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
            value="{{ old('news_date', date('Y-m-d')) }}"
            max="{{ date('Y-m-d') }}"
            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('news_date') border-red-500 @enderror"
        >
    </div>
    <p class="mt-1 text-xs text-gray-500">
        <i class="fas fa-info-circle mr-1"></i>
        Leave empty to use current date. Cannot select future dates.
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
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-1 text-yellow-500"></i>
                                Mark as Featured
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-8">Featured items appear prominently on the homepage</p>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    {{-- Image Attachment --}}
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Image Attachment
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
                                onchange="validateImage(event)"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            JPG, PNG, GIF, or WEBP (max 2MB). Leave empty for no attachment.
                        </p>
                        <div id="image-preview" class="mt-3 hidden">
                            <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-image text-emerald-600 text-2xl"></i>
                                    <div class="flex-1">
                                        <p id="image-name" class="text-sm font-medium text-gray-700"></p>
                                        <p id="image-size" class="text-xs text-gray-500"></p>
                                    </div>
                                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                                </div>
                                <img id="image-thumb" src="" alt="Preview"
                                     class="w-full max-h-40 object-cover rounded-lg border border-emerald-200">
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Live Preview --}}
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-eye mr-1"></i> Live Preview
                        </h4>
                        <div id="previewCard" class="bg-white rounded-lg border border-gray-200 p-4">
                            <div class="flex items-start justify-between mb-2">
                                <span id="previewType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Update</span>
                                <span id="previewFeatured" class="hidden text-yellow-500"><i class="fas fa-star"></i></span>
                            </div>
                            {{-- Image preview inside live preview card --}}
                            <div id="previewImageContainer" class="mb-3 hidden">
                                <img id="previewImage" src="" alt="Preview image" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            </div>
                            <h5 id="previewTitle" class="font-semibold text-gray-900 mb-2">Title will appear here</h5>
                            <p id="previewContent" class="text-sm text-gray-600 line-clamp-3">Content preview will appear here...</p>
                        </div>
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
                    >{{ old('content') }}</textarea>
                </div>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">
                        <span id="charCount">0</span> characters
                    </p>
                    <p class="text-xs text-gray-400">Tip: Use proper formatting for better readability</p>
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
                    Save Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');
    const titleInput = document.getElementById('title');
    const featuredChk = document.getElementById('is_featured');
    const previewType = document.getElementById('previewType');
    const previewTitle = document.getElementById('previewTitle');
    const previewContent = document.getElementById('previewContent');
    const previewFeatured = document.getElementById('previewFeatured');
    const imageInput = document.getElementById('image');
    const previewImageContainer = document.getElementById('previewImageContainer');
    const previewImage = document.getElementById('previewImage');
    const newsDateInput = document.getElementById('news_date');

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
        
        const title = titleInput.value.trim();
        previewTitle.textContent = title || 'Title will appear here';
        
        let content = contentTextarea.value.trim();
        if (content.length > 150) {
            content = content.substring(0, 150) + '...';
        }
        previewContent.textContent = content || 'Content preview will appear here...';
        
        if (featuredChk && featuredChk.checked) {
            previewFeatured.classList.remove('hidden');
        } else {
            previewFeatured.classList.add('hidden');
        }
    }

    // Update live preview when image is selected
    function updateImagePreview() {
        const file = imageInput.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImageContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewImageContainer.classList.add('hidden');
            previewImage.src = '';
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

    if (newsDateInput) {
        newsDateInput.addEventListener('change', updatePreview);
    }

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            updateImagePreview();
        });
    }

    // Initialize character count and preview
    if (charCount && contentTextarea) {
        charCount.textContent = contentTextarea.value.length;
    }
    updatePreview();
    updateImagePreview();
});

// Image validation function (also updates live preview)
function validateImage(event) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById('image-preview');
    const imgName = document.getElementById('image-name');
    const imgSize = document.getElementById('image-size');
    const imgThumb = document.getElementById('image-thumb');
    const previewImageContainer = document.getElementById('previewImageContainer');
    const previewImage = document.getElementById('previewImage');

    if (!file) {
        if (previewDiv) previewDiv.classList.add('hidden');
        if (previewImageContainer) previewImageContainer.classList.add('hidden');
        return;
    }

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Please upload a valid image file (JPG, PNG, GIF, or WEBP).');
        event.target.value = '';
        if (previewDiv) previewDiv.classList.add('hidden');
        if (previewImageContainer) previewImageContainer.classList.add('hidden');
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB. Current file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
        event.target.value = '';
        if (previewDiv) previewDiv.classList.add('hidden');
        if (previewImageContainer) previewImageContainer.classList.add('hidden');
        return;
    }

    // Display file info in the separate preview box
    if (imgName) imgName.textContent = file.name;
    if (imgSize) {
        imgSize.textContent = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(2) + ' KB'
            : (file.size / 1024 / 1024).toFixed(2) + ' MB';
    }

    // Show thumbnail in the separate preview box
    if (imgThumb) {
        const reader = new FileReader();
        reader.onload = e => { imgThumb.src = e.target.result; };
        reader.readAsDataURL(file);
    }

    if (previewDiv) previewDiv.classList.remove('hidden');

    // Also update the live preview image
    if (previewImageContainer && previewImage) {
        const readerLive = new FileReader();
        readerLive.onload = function(e) {
            previewImage.src = e.target.result;
            previewImageContainer.classList.remove('hidden');
        };
        readerLive.readAsDataURL(file);
    }
}
</script>
@endpush