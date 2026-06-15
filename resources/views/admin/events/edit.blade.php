@extends('layouts.admin')

@section('title', 'Edit Event - PPP Unit KP')
@section('header-title', 'Edit Event')

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
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Event
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update event information and manage gallery images</p>
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

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6" id="eventForm">
            @csrf
            @method('PUT')
            
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
                        value="{{ old('title', $event->title) }}"
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
                        Location
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-location-dot"></i>
                        </span>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            value="{{ old('location', $event->location) }}"
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
                            value="{{ old('event_date', $event->event_date instanceof \Carbon\Carbon ? $event->event_date->format('Y-m-d') : $event->event_date) }}"
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
                    Description
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </span>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror"
                        placeholder="Detailed description of the event..."
                    >{{ old('description', $event->description) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Provide details about the event agenda, speakers, etc.</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Gallery Images Section --}}
            @if($event->gallery->count() > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Current Gallery Images
                    </label>
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($event->gallery as $index => $galleryItem)
                                <div class="relative group" data-image-id="{{ $galleryItem->id }}">
                                    <img src="{{ asset('storage/' . $galleryItem->image) }}" 
                                         alt="Gallery image"
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                    
                                    {{-- Thumbnail Badge --}}
                                    @if($galleryItem->is_thumbnail)
                                        <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded flex items-center">
                                            <i class="fas fa-star mr-1 text-xs"></i>
                                            Thumbnail
                                        </div>
                                    @endif
                                    
                                    {{-- Action Buttons --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                        @if(!$galleryItem->is_thumbnail)
                                            <button type="button" 
                                                    onclick="setAsThumbnail({{ $galleryItem->id }})"
                                                    class="p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
                                                    title="Set as thumbnail">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        @endif
                                        <button type="button" 
                                                onclick="confirmImageDelete({{ $galleryItem->id }})"
                                                class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                                title="Delete image">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Hover over an image to set as thumbnail or delete it.
                        </p>
                    </div>
                </div>
            @endif

            {{-- Add New Images Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Add New Images
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
                        {{-- New image fields will be added here dynamically --}}
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            New images will be added to the gallery. If you want to set a new image as thumbnail, select the radio button.
                        </p>
                    </div>
                </div>
                
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hidden inputs for tracking deleted images --}}
            <div id="deletedImagesContainer"></div>

            {{-- Hidden input for thumbnail selection --}}
            <input type="hidden" name="thumbnail" id="thumbnailInput" value="{{ $event->gallery->where('is_thumbnail', true)->first()->id ?? '' }}">

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
                    Update Event
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Image Confirmation Modal --}}
<div id="deleteImageModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeImageDeleteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Delete Image</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to delete this image? This action cannot be undone.</p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" onclick="closeImageDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button type="button" onclick="deleteImage()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Image
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let imageToDelete = null;
    let deletedImages = [];
    let newImageCounter = 0;
    let selectedNewThumbnailIndex = null;

    // Set as thumbnail for existing images
    window.setAsThumbnail = function(imageId) {
        document.getElementById('thumbnailInput').value = imageId;
        
        // Update UI to show thumbnail badge
        document.querySelectorAll('[data-image-id]').forEach(container => {
            const badge = container.querySelector('.absolute.top-2.left-2');
            if (badge && container.dataset.imageId == imageId) {
                if (!badge.querySelector('.fa-star')) {
                    badge.innerHTML = '<i class="fas fa-star mr-1 text-xs"></i> Thumbnail';
                }
            } else if (badge) {
                badge.remove();
            }
        });
        
        // Add badge to newly selected thumbnail
        const selectedContainer = document.querySelector(`[data-image-id="${imageId}"]`);
        if (selectedContainer && !selectedContainer.querySelector('.absolute.top-2.left-2')) {
            const badge = document.createElement('div');
            badge.className = 'absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded flex items-center';
            badge.innerHTML = '<i class="fas fa-star mr-1 text-xs"></i> Thumbnail';
            selectedContainer.appendChild(badge);
        }
        
        alert('Thumbnail updated successfully!');
    };

    // Confirm image deletion
    window.confirmImageDelete = function(imageId) {
        imageToDelete = imageId;
        document.getElementById('deleteImageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Delete image
    window.deleteImage = function() {
        if (imageToDelete) {
            // Add to deleted images array
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = imageToDelete;
            document.getElementById('deletedImagesContainer').appendChild(input);
            
            // Remove the image from DOM
            const imageElement = document.querySelector(`[data-image-id="${imageToDelete}"]`);
            if (imageElement) {
                // Check if deleted image was thumbnail
                const thumbnailInput = document.getElementById('thumbnailInput');
                if (thumbnailInput.value == imageToDelete) {
                    thumbnailInput.value = '';
                }
                imageElement.remove();
            }
            
            closeImageDeleteModal();
            imageToDelete = null;
        }
    };

    // Close image delete modal
    window.closeImageDeleteModal = function() {
        document.getElementById('deleteImageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        imageToDelete = null;
    };

    // Add new image field
    function addNewImageField() {
        const container = document.getElementById('imagesContainer');
        const newIndex = newImageCounter++;
        
        const newFieldHtml = `
            <div class="new-image-field bg-white rounded-lg border border-gray-200 p-4" data-new-index="${newIndex}">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700">New Image ${newIndex + 1}</span>
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
                            onchange="previewNewImage(this, ${newIndex})"
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
                                name="new_thumbnail" 
                                value="${newIndex}"
                                class="new-thumbnail-radio h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded-full transition-colors"
                                onchange="selectNewThumbnail(${newIndex})"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-1 text-yellow-500"></i>
                                Set as Thumbnail
                            </span>
                        </label>
                    </div>
                </div>
                <div class="image-preview mt-3 hidden" id="preview-${newIndex}">
                    <img src="" alt="Preview" class="h-32 w-auto rounded-lg border border-gray-200 object-cover">
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newFieldHtml);
        
        // Add remove listener to the new button
        const removeBtn = container.querySelector(`.new-image-field:last-child .remove-image-btn`);
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.target.closest('.new-image-field').remove();
                updateNewImageLabels();
            });
        }
    }

    // Preview new image
    window.previewNewImage = function(input, index) {
        const file = input.files[0];
        const previewDiv = document.getElementById(`preview-${index}`);
        const previewImg = previewDiv.querySelector('img');
        
        if (file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, GIF, WEBP).');
                input.value = '';
                previewDiv.classList.add('hidden');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                alert('File size exceeds 5MB. Please choose a smaller file.');
                input.value = '';
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
    };

    // Select new thumbnail
    window.selectNewThumbnail = function(index) {
        selectedNewThumbnailIndex = index;
        
        // Uncheck all other new thumbnail radios
        document.querySelectorAll('.new-thumbnail-radio').forEach(radio => {
            if (radio.value != index) {
                radio.checked = false;
            }
        });
        
        // Clear existing thumbnail selection from current images
        document.getElementById('thumbnailInput').value = '';
    };

    // Update labels for new images
    function updateNewImageLabels() {
        const newFields = document.querySelectorAll('.new-image-field');
        newFields.forEach((field, idx) => {
            const label = field.querySelector('.text-sm.font-medium.text-gray-700');
            if (label) {
                label.textContent = `New Image ${idx + 1}`;
            }
            const radio = field.querySelector('.new-thumbnail-radio');
            if (radio) {
                radio.value = idx;
            }
        });
    }

    // Form validation before submit
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        const thumbnailInput = document.getElementById('thumbnailInput');
        const newThumbnailSelected = selectedNewThumbnailIndex !== null;
        const hasNewImages = document.querySelectorAll('.new-image-field').length > 0;
        const hasCurrentImages = {{ $event->gallery->count() }} > 0;
        
        // Check if there's at least one thumbnail
        if (!thumbnailInput.value && !newThumbnailSelected) {
            e.preventDefault();
            alert('Please select a thumbnail image for this event (either from existing images or from new images).');
            return;
        }
        
        // If new thumbnail is selected, set the thumbnail value to 'new' with index
        if (newThumbnailSelected) {
            const hiddenThumbnail = document.createElement('input');
            hiddenThumbnail.type = 'hidden';
            hiddenThumbnail.name = 'thumbnail';
            hiddenThumbnail.value = 'new_' + selectedNewThumbnailIndex;
            this.appendChild(hiddenThumbnail);
        }
    });

    // Initialize add image button
    document.getElementById('addImageBtn').addEventListener('click', addNewImageField);

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageDeleteModal();
        }
    });
</script>
@endpush
@endsection