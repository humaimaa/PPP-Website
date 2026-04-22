{{-- resources/views/admin/gallery/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Gallery Item - PPP Department KPK')
@section('header-title', 'Edit Gallery Item')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Success Message --}}
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 hidden items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Error Message --}}
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 hidden items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-edit mr-2 text-emerald-600"></i>
            Edit Gallery Item #<span id="galleryId"></span>
        </h2>
        <a href="{{ route('admin.gallery.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Gallery
        </a>
    </div>

    {{-- Edit Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-images mr-2 text-emerald-600"></i>
                Edit Gallery Information
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update the gallery item details below</p>
        </div>

        <form id="editGalleryForm" class="p-6">
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
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        placeholder="Enter gallery title"
                    >
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        placeholder="Enter location (optional)"
                    >
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    >
                </div>

                {{-- Created/Updated Info --}}
                <div class="bg-gray-50 rounded-lg p-4 text-sm">
                    <p class="text-gray-600">
                        <i class="far fa-calendar-plus mr-2"></i>
                        Created: <span id="createdDate"></span>
                    </p>
                    <p class="text-gray-600 mt-1">
                        <i class="far fa-calendar-check mr-2"></i>
                        Last Updated: <span id="updatedDate"></span>
                    </p>
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
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="Enter gallery description (optional)"
                ></textarea>
            </div>

            {{-- Current Images Section --}}
            <div class="mt-8">
                <h4 class="text-md font-medium text-gray-800 mb-4">
                    <i class="fas fa-image mr-2 text-emerald-600"></i>
                    Current Images
                </h4>
                <div id="currentImagesContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {{-- Current images will be inserted here via JavaScript --}}
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Click the star icon to set an image as thumbnail. Click the trash icon to remove an image.
                </p>
            </div>

            {{-- Add New Images Section --}}
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-800">
                        <i class="fas fa-plus-circle mr-2 text-emerald-600"></i>
                        Add New Images
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

                {{-- New Images Container --}}
                <div id="newImagesContainer" class="space-y-4">
                    {{-- New image fields will be added here --}}
                </div>
            </div>

            {{-- Info Message --}}
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    One image must be selected as the thumbnail. The thumbnail will be used as the cover image for this gallery item.
                </p>
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
                    Update Gallery Item
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Hidden input template for new image fields --}}
<template id="newImageTemplate">
    <div class="new-image-field bg-gray-50 rounded-lg p-4 border border-gray-200">
        <div class="flex items-start justify-between mb-3">
            <span class="text-sm font-medium text-gray-700">New Image</span>
            <button 
                type="button" 
                class="remove-new-image-btn text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors"
                title="Remove"
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
                    name="new_images[]" 
                    accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                    class="new-image-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                >
                <p class="text-xs text-gray-500 mt-1">
                    JPG, PNG, GIF, WEBP (Max 5MB)
                </p>
            </div>
            <div class="flex items-center">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="new_thumbnail" 
                        class="new-thumbnail-checkbox h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors"
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
</template>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dummy gallery data (simulating data from database)
        const dummyGallery = {
            1: {
                id: 1,
                title: "Swat Expressway Inauguration Ceremony",
                location: "Swat, Khyber Pakhtunkhwa",
                date: "2024-03-15",
                description: "The inauguration ceremony of the Swat Expressway Extension project was attended by government officials and local community leaders.",
                thumbnail: 0,
                images: [
                    "https://images.pexels.com/photos/1117210/pexels-photo-1117210.jpeg",
                    "https://images.pexels.com/photos/169647/pexels-photo-169647.jpeg",
                    "https://images.pexels.com/photos/262367/pexels-photo-262367.jpeg"
                ],
                created_at: "2024-03-15 10:30:00",
                updated_at: "2024-03-18 14:20:00"
            },
            2: {
                id: 2,
                title: "Healthcare City Groundbreaking",
                location: "Peshawar, Khyber Pakhtunkhwa",
                date: "2024-02-20",
                description: "Groundbreaking ceremony for the Peshawar Healthcare City project, a state-of-the-art medical complex spanning 500 acres.",
                thumbnail: 1,
                images: [
                    "https://images.pexels.com/photos/263402/pexels-photo-263402.jpeg",
                    "https://images.pexels.com/photos/127873/pexels-photo-127873.jpeg",
                    "https://images.pexels.com/photos/416754/pexels-photo-416754.jpeg",
                    "https://images.pexels.com/photos/236380/pexels-photo-236380.jpeg"
                ],
                created_at: "2024-02-20 14:15:00",
                updated_at: "2024-02-25 09:30:00"
            },
            3: {
                id: 3,
                title: "Investor Conference 2024",
                location: "Islamabad",
                date: "2024-03-10",
                description: "Annual PPP Investor Conference bringing together government officials, private investors, and industry experts.",
                thumbnail: 0,
                images: [
                    "https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg",
                    "https://images.pexels.com/photos/3184339/pexels-photo-3184339.jpeg",
                    "https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg"
                ],
                created_at: "2024-03-10 09:00:00",
                updated_at: "2024-03-12 11:15:00"
            }
        };

        // Get gallery ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        let galleryId = urlParams.get('id') || '1';
        
        if (!dummyGallery[galleryId]) {
            galleryId = Object.keys(dummyGallery)[0];
        }
        
        const gallery = dummyGallery[galleryId];
        
        // Store current images (for deletion tracking)
        let currentImages = [...gallery.images];
        let currentThumbnail = gallery.thumbnail;
        let deletedImages = [];
        let newImageCount = 0;

        // Populate form
        document.getElementById('galleryId').textContent = gallery.id;
        document.getElementById('title').value = gallery.title;
        document.getElementById('location').value = gallery.location || '';
        document.getElementById('date').value = gallery.date || '';
        document.getElementById('description').value = gallery.description || '';
        
        // Display dates
        document.getElementById('createdDate').textContent = new Date(gallery.created_at).toLocaleDateString('en-PK', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
        document.getElementById('updatedDate').textContent = new Date(gallery.updated_at).toLocaleDateString('en-PK', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        // ============================================
        // RENDER CURRENT IMAGES
        // ============================================
        function renderCurrentImages() {
            const container = document.getElementById('currentImagesContainer');
            
            if (currentImages.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class="fas fa-images text-3xl mb-2"></i>
                        <p>No images remaining. Please add new images.</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = currentImages.map((img, index) => `
                <div class="current-image-item relative group bg-gray-50 rounded-lg p-2 border border-gray-200" data-index="${index}">
                    <img src="${img}" 
                         alt="Gallery image ${index + 1}" 
                         class="w-full h-32 object-cover rounded-lg"
                         onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                    <div class="absolute top-1 right-1 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button type="button" 
                                class="set-thumbnail-btn p-1.5 rounded-full shadow-md ${currentThumbnail === index ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-yellow-100'}"
                                title="Set as thumbnail"
                                data-index="${index}">
                            <i class="fas fa-star text-xs"></i>
                        </button>
                        ${currentImages.length > 1 ? `
                            <button type="button" 
                                    class="delete-image-btn p-1.5 bg-white text-red-600 rounded-full shadow-md hover:bg-red-100"
                                    title="Delete image"
                                    data-index="${index}">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        ` : ''}
                    </div>
                    ${currentThumbnail === index ? `
                        <span class="absolute bottom-1 left-1 bg-yellow-500 text-white text-xs px-2 py-0.5 rounded">
                            <i class="fas fa-star mr-1"></i>Thumbnail
                        </span>
                    ` : ''}
                </div>
            `).join('');
            
            // Attach event listeners to buttons
            attachCurrentImageListeners();
        }

        // ============================================
        // ATTACH LISTENERS TO CURRENT IMAGE BUTTONS
        // ============================================
        function attachCurrentImageListeners() {
            // Set thumbnail buttons
            document.querySelectorAll('.set-thumbnail-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    setThumbnail(index);
                });
            });
            
            // Delete image buttons
            document.querySelectorAll('.delete-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    deleteImage(index);
                });
            });
        }

        // ============================================
        // SET THUMBNAIL
        // ============================================
        function setThumbnail(index) {
            currentThumbnail = index;
            
            // Uncheck any new thumbnail checkboxes
            document.querySelectorAll('.new-thumbnail-checkbox').forEach(cb => {
                cb.checked = false;
            });
            
            renderCurrentImages();
        }

        // ============================================
        // DELETE CURRENT IMAGE
        // ============================================
        function deleteImage(index) {
            if (currentImages.length <= 1) {
                alert('Cannot delete the last image. Gallery items must have at least one image.');
                return;
            }
            
            // Track deleted image (for server-side processing)
            deletedImages.push(index);
            
            // Remove image from array
            currentImages.splice(index, 1);
            
            // Adjust thumbnail if needed
            if (currentThumbnail === index) {
                currentThumbnail = 0;
            } else if (currentThumbnail > index) {
                currentThumbnail--;
            }
            
            renderCurrentImages();
        }

        // ============================================
        // THUMBNAIL CHECKBOX HANDLER (for new images)
        // ============================================
        function handleNewThumbnailCheckbox(clickedCheckbox) {
            if (clickedCheckbox.checked) {
                // Uncheck all other new thumbnail checkboxes
                document.querySelectorAll('.new-thumbnail-checkbox').forEach(checkbox => {
                    if (checkbox !== clickedCheckbox) {
                        checkbox.checked = false;
                    }
                });
                
                // Clear current thumbnail selection
                currentThumbnail = -1;
                renderCurrentImages();
            }
        }

        function attachNewThumbnailListeners() {
            document.querySelectorAll('.new-thumbnail-checkbox').forEach(checkbox => {
                checkbox.removeEventListener('change', newThumbnailChangeHandler);
                checkbox.addEventListener('change', newThumbnailChangeHandler);
            });
        }

        function newThumbnailChangeHandler(e) {
            handleNewThumbnailCheckbox(e.target);
        }

        // ============================================
        // IMAGE PREVIEW FOR NEW IMAGES
        // ============================================
        function attachNewImagePreviewListeners() {
            document.querySelectorAll('.new-image-input').forEach(input => {
                input.removeEventListener('change', newImagePreviewHandler);
                input.addEventListener('change', newImagePreviewHandler);
            });
        }

        function newImagePreviewHandler(e) {
            const file = e.target.files[0];
            const imageField = e.target.closest('.new-image-field');
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

        // ============================================
        // REMOVE NEW IMAGE FIELD
        // ============================================
        function attachNewRemoveListeners() {
            document.querySelectorAll('.remove-new-image-btn').forEach(btn => {
                btn.removeEventListener('click', removeNewImageHandler);
                btn.addEventListener('click', removeNewImageHandler);
            });
        }

        function removeNewImageHandler(e) {
            const imageField = e.target.closest('.new-image-field');
            imageField.remove();
            newImageCount--;
            updateNewImageLabels();
        }

        function updateNewImageLabels() {
            const fields = document.querySelectorAll('.new-image-field');
            fields.forEach((field, index) => {
                const labelSpan = field.querySelector('span.text-sm.font-medium');
                if (labelSpan) {
                    labelSpan.textContent = `New Image ${index + 1}`;
                }
            });
        }

        // ============================================
        // ADD NEW IMAGE FIELD
        // ============================================
        function addNewImageField() {
            const container = document.getElementById('newImagesContainer');
            const template = document.getElementById('newImageTemplate');
            const clone = template.content.cloneNode(true);
            
            newImageCount++;
            const labelSpan = clone.querySelector('span.text-sm.font-medium');
            if (labelSpan) {
                labelSpan.textContent = `New Image ${newImageCount}`;
            }
            
            container.appendChild(clone);
            
            attachNewThumbnailListeners();
            attachNewImagePreviewListeners();
            attachNewRemoveListeners();
        }

        // ============================================
        // FORM SUBMISSION
        // ============================================
        document.getElementById('editGalleryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('title').value;
            
            if (!title) {
                showError('Please enter a title.');
                return;
            }
            
            // Check if there's at least one image (current or new)
            const hasNewImages = document.querySelectorAll('.new-image-input').length > 0 && 
                                Array.from(document.querySelectorAll('.new-image-input')).some(input => input.files.length > 0);
            
            if (currentImages.length === 0 && !hasNewImages) {
                showError('Gallery must have at least one image.');
                return;
            }
            
            // Check if a thumbnail is selected
            const hasNewThumbnail = Array.from(document.querySelectorAll('.new-thumbnail-checkbox')).some(cb => cb.checked);
            
            if (currentThumbnail === -1 && !hasNewThumbnail) {
                showError('Please select one image as the thumbnail.');
                return;
            }
            
            showSuccess(`"${title}" updated successfully!`);
            
            setTimeout(() => {
                // window.location.href = '{{ route("admin.gallery.index") }}';
                console.log('Redirecting to gallery list...');
            }, 2000);
        });

        // ============================================
        // HELPER FUNCTIONS
        // ============================================
        function showError(message) {
            const errorEl = document.getElementById('errorMessage');
            errorEl.querySelector('span').textContent = message;
            errorEl.classList.remove('hidden');
            
            setTimeout(() => errorEl.classList.add('hidden'), 5000);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function showSuccess(message) {
            const successEl = document.getElementById('successMessage');
            successEl.querySelector('span').textContent = message;
            successEl.classList.remove('hidden');
            
            setTimeout(() => successEl.classList.add('hidden'), 5000);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ============================================
        // INITIALIZE
        // ============================================
        function initialize() {
            renderCurrentImages();
            
            document.getElementById('addImageBtn').addEventListener('click', addNewImageField);
        }
        
        initialize();
    });
</script>

<style>
    .current-image-item {
        transition: all 0.3s ease;
    }
    
    .current-image-item:hover {
        border-color: #059669;
    }
    
    .new-image-field {
        transition: all 0.3s ease;
    }
    
    .new-image-field:hover {
        border-color: #059669;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .image-preview img {
        object-fit: cover;
        width: auto;
    }
</style>
@endpush