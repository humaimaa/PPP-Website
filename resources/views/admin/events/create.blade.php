@extends('layouts.admin')

@section('title', 'Add Event - PPP Unit KP')
@section('header-title', 'Add New Event')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Events
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-calendar-plus mr-2 text-emerald-600"></i>
                    Add New Event
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new event and upload gallery images</p>
            </div>
        </div>

        {{-- Error Messages --}}
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

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            {{-- Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Event Title <span class="text-red-500">*</span>
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
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror"
                        placeholder="Enter event title"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Descriptive title for the event</p>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Location --}}
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-location-dot"></i>
                        </span>
                        <input required
                            type="text" 
                            id="location" 
                            name="location" 
                            value="{{ old('location') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('location') border-red-500 @enderror"
                            placeholder="Event venue or location"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Where the event will take place</p>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Event Date --}}
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Event Date <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-calendar-day"></i>
                        </span>
                        <input 
                            type="date" 
                            id="event_date" 
                            name="event_date" 
                            value="{{ old('event_date') }}"
                            required
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('event_date') border-red-500 @enderror"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Date when the event will be held</p>
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <textarea  required
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror"
                        placeholder="Detailed description of the event..."
                    >{{ old('description') }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Provide details about the event agenda, speakers, etc.</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gallery Images Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Gallery Images <span class="text-red-500">*</span>
                    </label>
                    <button 
                        type="button" 
                        id="addImageBtn"
                        class="inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                    >
                        <i class="fas fa-plus mr-1"></i>
                        Add Image
                    </button>
                </div>

                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                    <div id="imagesContainer" class="space-y-4">
                        {{-- Initial Image Field --}}
                        <div class="image-field bg-white rounded-lg border border-gray-200 p-4" data-index="0">
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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Image <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="file" 
                                        name="images[]" 
                                        accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                        class="image-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
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
                                            type="radio" 
                                            name="thumbnail" 
                                            value="0"
                                            class="thumbnail-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded-full transition-colors"
                                            checked
                                        >
                                        <span class="ml-3 text-sm font-medium text-gray-700">
                                            <i class="fas fa-star mr-1 text-yellow-500"></i>
                                            Set as Thumbnail
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="image-preview mt-3 hidden">
                                <img src="" alt="Preview" class="h-32 w-auto rounded-lg border border-gray-200 object-cover">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            Select one image as the thumbnail. The thumbnail will be used as the cover image for this event.
                        </p>
                    </div>
                </div>
                
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('thumbnail')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Events Gallery</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Events can have multiple gallery images. The thumbnail image will be displayed as the cover photo
                            on the events listing page. All images will be displayed in the event detail page.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imagesContainer = document.getElementById('imagesContainer');
        const addImageBtn = document.getElementById('addImageBtn');
        let imageCount = 1;

        // Handle thumbnail radio buttons - ensures only one is selected
        function handleThumbnailRadio(clickedRadio) {
            if (clickedRadio.checked) {
                document.querySelectorAll('.thumbnail-radio').forEach(radio => {
                    if (radio !== clickedRadio) {
                        radio.checked = false;
                    }
                });
            }
        }

        function attachThumbnailListeners() {
            document.querySelectorAll('.thumbnail-radio').forEach(radio => {
                radio.removeEventListener('change', function(e) {
                    handleThumbnailRadio(e.target);
                });
                radio.addEventListener('change', function(e) {
                    handleThumbnailRadio(e.target);
                });
            });
        }

        // Image preview
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
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, GIF, WEBP).');
                    e.target.value = '';
                    previewDiv.classList.add('hidden');
                    return;
                }
                
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

        // Remove image field
        function attachRemoveListeners() {
            document.querySelectorAll('.remove-image-btn').forEach(btn => {
                btn.removeEventListener('click', removeImageHandler);
                btn.addEventListener('click', removeImageHandler);
            });
        }

        function removeImageHandler(e) {
            const imageField = e.target.closest('.image-field');
            const imageFields = document.querySelectorAll('.image-field');
            
            if (imageFields.length <= 1) {
                alert('At least one image is required.');
                return;
            }
            
            imageField.remove();
            updateImageLabels();
        }

        // Update labels and indices
        function updateImageLabels() {
            const imageFields = document.querySelectorAll('.image-field');
            imageFields.forEach((field, index) => {
                field.dataset.index = index;
                
                const labelSpan = field.querySelector('span.text-sm.font-medium');
                if (labelSpan) {
                    labelSpan.textContent = `Image ${index + 1}`;
                }
                
                const thumbnailRadio = field.querySelector('.thumbnail-radio');
                if (thumbnailRadio) {
                    thumbnailRadio.value = index;
                }
                
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

        // Add new image field
        function addImageField() {
            const currentFieldCount = document.querySelectorAll('.image-field').length;
            const newIndex = currentFieldCount;
            
            const newFieldHtml = `
                <div class="image-field bg-white rounded-lg border border-gray-200 p-4" data-index="${newIndex}">
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
                                class="image-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
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
                                    type="radio" 
                                    name="thumbnail" 
                                    value="${newIndex}"
                                    class="thumbnail-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded-full transition-colors"
                                >
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>
                                    Set as Thumbnail
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="image-preview mt-3 hidden">
                        <img src="" alt="Preview" class="h-32 w-auto rounded-lg border border-gray-200 object-cover">
                    </div>
                </div>
            `;
            
            imagesContainer.insertAdjacentHTML('beforeend', newFieldHtml);
            updateImageLabels();
            attachThumbnailListeners();
            attachImagePreviewListeners();
            attachRemoveListeners();
        }

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const imageInputs = document.querySelectorAll('.image-input');
            const thumbnailRadios = document.querySelectorAll('.thumbnail-radio');
            
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
            
            let hasThumbnail = false;
            thumbnailRadios.forEach(radio => {
                if (radio.checked) {
                    hasThumbnail = true;
                }
            });
            
            if (!hasThumbnail) {
                e.preventDefault();
                alert('Please select one image as the thumbnail.');
                return;
            }
        });

        // Initialize
        function initialize() {
            updateImageLabels();
            attachThumbnailListeners();
            attachImagePreviewListeners();
            attachRemoveListeners();
            addImageBtn.addEventListener('click', addImageField);
        }
        
        initialize();
    });
</script>
@endpush
@endsection