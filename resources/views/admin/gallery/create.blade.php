{{-- resources/views/admin/gallery/add.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Gallery Item - PPP Department KPK')
@section('header-title', 'Add Gallery Item')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
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

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-images mr-2 text-emerald-600"></i>
                Gallery Information
            </h3>
            <p class="text-sm text-gray-500 mt-1">Fill in the details below to add a new gallery item</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('title') border-red-500 @enderror"
                        placeholder="Enter gallery title"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Location
                    </label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        value="{{ old('location') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('location') border-red-500 @enderror"
                        placeholder="Enter location (optional)"
                    >
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        Date
                    </label>
                    <input 
                        type="date" 
                        id="date" 
                        name="date" 
                        value="{{ old('date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('date') border-red-500 @enderror"
                    >
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('description') border-red-500 @enderror"
                    placeholder="Enter gallery description (optional)"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Images Section --}}
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-800">
                        <i class="fas fa-image mr-2 text-emerald-600"></i>
                        Gallery Images
                    </h4>
                    <button 
                        type="button" 
                        id="addImageBtn"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Add Another Image
                    </button>
                </div>

                {{-- Images Container --}}
                <div id="imagesContainer" class="space-y-4">
                    {{-- Initial Image Field --}}
                    <div class="image-field bg-gray-50 rounded-lg p-4 border border-gray-200" data-index="0">
                        <div class="flex items-start justify-between mb-3">
                            <span class="text-sm font-medium text-gray-700">Image 1</span>
                            <button 
                                type="button" 
                                class="remove-image-btn text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors hidden"
                                title="Remove Image"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- File Input --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Image <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="file" 
                                    name="images[]" 
                                    accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                    class="image-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                    required
                                >
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    JPG, PNG, GIF, WEBP (Max 5MB)
                                </p>
                            </div>
                            {{-- Thumbnail Checkbox --}}
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="thumbnail" 
                                        value="0"
                                        class="thumbnail-checkbox h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors"
                                    >
                                    <span class="ml-3 text-sm font-medium text-gray-700">
                                        <i class="fas fa-star mr-1 text-yellow-500"></i>
                                        Set as Thumbnail
                                    </span>
                                </label>
                            </div>
                        </div>
                        {{-- Preview Area --}}
                        <div class="image-preview mt-3 hidden">
                            <img src="" alt="Preview" class="max-h-32 rounded-lg border border-gray-200">
                        </div>
                        @error('images')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @error('thumbnail')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Info Message --}}
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        Select one image as the thumbnail. The thumbnail will be used as the cover image for this gallery item.
                    </p>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('admin.gallery.index') }}" 
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Gallery Item
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imagesContainer = document.getElementById('imagesContainer');
        const addImageBtn = document.getElementById('addImageBtn');
        let imageCount = 1;

        // ============================================
        // THUMBNAIL CHECKBOX HANDLER
        // Ensures only one thumbnail is selected at a time
        // ============================================
        function handleThumbnailCheckbox(clickedCheckbox) {
            if (clickedCheckbox.checked) {
                // Uncheck all other thumbnail checkboxes
                document.querySelectorAll('.thumbnail-checkbox').forEach(checkbox => {
                    if (checkbox !== clickedCheckbox) {
                        checkbox.checked = false;
                    }
                });
            }
        }

        // Attach event listeners to all thumbnail checkboxes
        function attachThumbnailListeners() {
            document.querySelectorAll('.thumbnail-checkbox').forEach(checkbox => {
                checkbox.removeEventListener('change', thumbnailChangeHandler);
                checkbox.addEventListener('change', thumbnailChangeHandler);
            });
        }

        function thumbnailChangeHandler(e) {
            handleThumbnailCheckbox(e.target);
        }

        // ============================================
        // IMAGE PREVIEW HANDLER
        // ============================================
        function attachImagePreviewListeners() {
            document.querySelectorAll('.image-input').forEach(input => {
                input.removeEventListener('change', imagePreviewHandler);
                input.addEventListener('change', imagePreviewHandler);
            });
        }

        function imagePreviewHandler(e) {
            const file = e.target.files[0];
            const imageField = e.target.closest('.image-field');
            const previewDiv = imageField.querySelector('.image-preview');
            const previewImg = previewDiv.querySelector('img');
            
            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, GIF, WEBP).');
                    e.target.value = '';
                    previewDiv.classList.add('hidden');
                    return;
                }
                
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size exceeds 5MB. Please choose a smaller file.');
                    e.target.value = '';
                    previewDiv.classList.add('hidden');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('hidden');
            }
        }

        // ============================================
        // REMOVE IMAGE FIELD HANDLER
        // ============================================
        function attachRemoveListeners() {
            document.querySelectorAll('.remove-image-btn').forEach(btn => {
                btn.removeEventListener('click', removeImageHandler);
                btn.addEventListener('click', removeImageHandler);
            });
        }

        function removeImageHandler(e) {
            const imageField = e.target.closest('.image-field');
            const imageFields = document.querySelectorAll('.image-field');
            
            // Don't remove if it's the last field
            if (imageFields.length <= 1) {
                alert('At least one image is required.');
                return;
            }
            
            imageField.remove();
            updateImageLabels();
            
            // If the removed field had the checked thumbnail, no thumbnail is selected
            // That's fine - validation will catch it on submit
        }

        // ============================================
        // UPDATE IMAGE LABELS AND VALUES
        // ============================================
        function updateImageLabels() {
            const imageFields = document.querySelectorAll('.image-field');
            imageFields.forEach((field, index) => {
                // Update data-index
                field.dataset.index = index;
                
                // Update label text
                const labelSpan = field.querySelector('span.text-sm.font-medium');
                if (labelSpan) {
                    labelSpan.textContent = `Image ${index + 1}`;
                }
                
                // Update thumbnail checkbox value
                const thumbnailCheckbox = field.querySelector('.thumbnail-checkbox');
                if (thumbnailCheckbox) {
                    thumbnailCheckbox.value = index;
                }
                
                // Show/hide remove button
                const removeBtn = field.querySelector('.remove-image-btn');
                if (removeBtn) {
                    if (imageFields.length > 1) {
                        removeBtn.classList.remove('hidden');
                    } else {
                        removeBtn.classList.add('hidden');
                    }
                }
            });
        }

        // ============================================
        // ADD NEW IMAGE FIELD
        // ============================================
        function addImageField() {
            imageCount++;
            const currentFieldCount = document.querySelectorAll('.image-field').length;
            const newIndex = currentFieldCount;
            
            const newFieldHtml = `
                <div class="image-field bg-gray-50 rounded-lg p-4 border border-gray-200" data-index="${newIndex}">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-sm font-medium text-gray-700">Image ${currentFieldCount + 1}</span>
                        <button 
                            type="button" 
                            class="remove-image-btn text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors"
                            title="Remove Image"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Image <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="file" 
                                name="images[]" 
                                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                class="image-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                JPG, PNG, GIF, WEBP (Max 5MB)
                            </p>
                        </div>
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="thumbnail" 
                                    value="${newIndex}"
                                    class="thumbnail-checkbox h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors"
                                >
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>
                                    Set as Thumbnail
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="image-preview mt-3 hidden">
                        <img src="" alt="Preview" class="max-h-32 rounded-lg border border-gray-200">
                    </div>
                </div>
            `;
            
            imagesContainer.insertAdjacentHTML('beforeend', newFieldHtml);
            
            // Update all labels and remove buttons
            updateImageLabels();
            
            // Attach event listeners to new elements
            attachThumbnailListeners();
            attachImagePreviewListeners();
            attachRemoveListeners();
        }

        // ============================================
        // FORM VALIDATION BEFORE SUBMIT
        // ============================================
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const imageInputs = document.querySelectorAll('.image-input');
            const thumbnailCheckboxes = document.querySelectorAll('.thumbnail-checkbox');
            
            // Check if at least one image is selected
            let hasImage = false;
            imageInputs.forEach(input => {
                if (input.files.length > 0) {
                    hasImage = true;
                }
            });
            
            if (!hasImage) {
                e.preventDefault();
                alert('Please select at least one image.');
                return;
            }
            
            // Check if a thumbnail is selected
            let hasThumbnail = false;
            thumbnailCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    hasThumbnail = true;
                }
            });
            
            if (!hasThumbnail) {
                e.preventDefault();
                alert('Please select one image as the thumbnail.');
                return;
            }
        });

        // ============================================
        // INITIALIZE
        // ============================================
        function initialize() {
            // Update initial field labels and remove button visibility
            updateImageLabels();
            
            // Attach initial listeners
            attachThumbnailListeners();
            attachImagePreviewListeners();
            attachRemoveListeners();
            
            // Add image button click handler
            addImageBtn.addEventListener('click', addImageField);
        }
        
        initialize();
    });
</script>

<style>
    /* Additional styles for image fields */
    .image-field {
        transition: all 0.3s ease;
    }
    
    .image-field:hover {
        border-color: #059669;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .image-preview img {
        object-fit: cover;
        width: auto;
    }
</style>
@endpush