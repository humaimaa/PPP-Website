{{-- resources/views/admin/updates/add.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Update - PPP Department KPK')
@section('header-title', 'Add Update')

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
                <div class="flex-shrink-0">
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
                <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                Update Information
            </h3>
            <p class="text-sm text-gray-500 mt-1">Fill in the details below to add an update</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-4">
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
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('title') border-red-500 @enderror"
                            placeholder="Enter update title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="type" 
                            name="type" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('type') border-red-500 @enderror"
                        >
                            <option value="">Select Type</option>
                            <option value="Update" {{ old('type') == 'Update' ? 'selected' : '' }}>Update</option>
                            <option value="Event" {{ old('type') == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Announcement" {{ old('type') == 'Announcement' ? 'selected' : '' }}>Announcement</option>
                            <option value="Press Release" {{ old('type') == 'Press Release' ? 'selected' : '' }}>Press Release</option>
                            <option value="Notice" {{ old('type') == 'Notice' ? 'selected' : '' }}>Notice</option>
                            <option value="Circular" {{ old('type') == 'Circular' ? 'selected' : '' }}>Circular</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Event Date --}}
                    <div id="eventDateField" class="{{ old('type') == 'Event' ? '' : 'hidden' }}">
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Event Date
                        </label>
                        <input 
                            type="date" 
                            id="event_date" 
                            name="event_date"
                            value="{{ old('event_date') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('event_date') border-red-500 @enderror"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Required for events only
                        </p>
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Featured Toggle --}}
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                id="is_featured" 
                                name="is_featured" 
                                value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-1 text-yellow-500"></i>
                                Mark as Featured
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-8">
                            Featured items appear prominently on the homepage
                        </p>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-4">
                    {{-- PDF Attachment --}}
                    <div>
                        <label for="pdf_file" class="block text-sm font-medium text-gray-700 mb-2">
                            PDF Attachment
                        </label>
                        <input 
                            type="file" 
                            id="pdf_file" 
                            name="pdf_file" 
                            accept=".pdf,application/pdf"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('pdf_file') border-red-500 @enderror"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-file-pdf mr-1"></i>
                            PDF only (max 10MB)
                        </p>
                        @error('pdf_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Quick Info Card --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Quick Tips
                        </h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Title should be clear and descriptive</li>
                            <li>• Select "Event" type if this has a specific date</li>
                            <li>• Content appears as short description</li>
                            <li>• PDF attachments are optional</li>
                            <li>• Featured items get priority display</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Content Field (Full Width) --}}
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="6"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('content') border-red-500 @enderror"
                    placeholder="Write the update content here. This will appear as the short description below the title..."
                >{{ old('content') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-pencil-alt mr-1"></i>
                        <span id="charCount">0</span> characters
                    </p>
                    <p class="text-xs text-gray-400">
                        Recommended: 150-500 characters for best display
                    </p>
                </div>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Section --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-eye mr-1"></i>
                    Preview
                </h4>
                <div id="previewCard" class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span id="previewType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Update
                            </span>
                        </div>
                        <span id="previewFeatured" class="hidden text-yellow-500">
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <h5 id="previewTitle" class="font-semibold text-gray-900 mb-2">Title will appear here</h5>
                    <p id="previewContent" class="text-sm text-gray-600 mb-2">Content preview will appear here...</p>
                    <div id="previewDate" class="text-xs text-gray-500"></div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('admin.updates.index') }}" 
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
                    Save Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide event date field based on type selection
        const typeSelect = document.getElementById('type');
        const eventDateField = document.getElementById('eventDateField');
        const eventDateInput = document.getElementById('event_date');
        
        function toggleEventDate() {
            if (typeSelect.value === 'Event') {
                eventDateField.classList.remove('hidden');
                eventDateInput.required = true;
            } else {
                eventDateField.classList.add('hidden');
                eventDateInput.required = false;
                eventDateInput.value = '';
            }
            updatePreview();
        }
        
        typeSelect.addEventListener('change', toggleEventDate);
        toggleEventDate(); // Initial state
        
        // Character count for content
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');
        
        function updateCharCount() {
            const count = contentTextarea.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                charCount.classList.add('text-yellow-600');
            } else if (count > 150) {
                charCount.classList.add('text-green-600');
                charCount.classList.remove('text-yellow-600');
            } else {
                charCount.classList.remove('text-green-600', 'text-yellow-600');
            }
            
            updatePreview();
        }
        
        contentTextarea.addEventListener('input', updateCharCount);
        updateCharCount();
        
        // Live Preview
        const titleInput = document.getElementById('title');
        const featuredCheckbox = document.getElementById('is_featured');
        
        const previewType = document.getElementById('previewType');
        const previewTitle = document.getElementById('previewTitle');
        const previewContent = document.getElementById('previewContent');
        const previewDate = document.getElementById('previewDate');
        const previewFeatured = document.getElementById('previewFeatured');
        
        function updatePreview() {
            // Update type badge
            const type = typeSelect.value || 'Update';
            previewType.textContent = type;
            
            // Type badge colors
            const typeColors = {
                'Update': 'bg-green-100 text-green-800',
                'Event': 'bg-purple-100 text-purple-800',
                'Announcement': 'bg-yellow-100 text-yellow-800',
                'Press Release': 'bg-red-100 text-red-800',
                'Notice': 'bg-orange-100 text-orange-800',
                'Circular': 'bg-blue-100 text-blue-800'
            };
            previewType.className = `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${typeColors[type] || 'bg-gray-100 text-gray-800'}`;
            
            // Update title
            previewTitle.textContent = titleInput.value || 'Title will appear here';
            
            // Update content
            previewContent.textContent = contentTextarea.value || 'Content preview will appear here...';
            
            // Update event date
            if (type === 'Event' && eventDateInput.value) {
                const date = new Date(eventDateInput.value);
                previewDate.innerHTML = `<i class="far fa-calendar-alt mr-1"></i>Event Date: ${date.toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'})}`;
                previewDate.classList.remove('hidden');
            } else {
                previewDate.classList.add('hidden');
            }
            
            // Update featured star
            if (featuredCheckbox.checked) {
                previewFeatured.classList.remove('hidden');
            } else {
                previewFeatured.classList.add('hidden');
            }
        }
        
        titleInput.addEventListener('input', updatePreview);
        typeSelect.addEventListener('change', updatePreview);
        contentTextarea.addEventListener('input', updatePreview);
        eventDateInput.addEventListener('change', updatePreview);
        featuredCheckbox.addEventListener('change', updatePreview);
        
        // File upload validation
        const pdfInput = document.getElementById('pdf_file');
        
        pdfInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Check file type
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    alert('Please select a valid PDF file.');
                    this.value = '';
                    return;
                }
                
                // Check file size (10MB)
                if (file.size > 10000000) {
                    alert('File size exceeds 10MB. Please choose a smaller file.');
                    this.value = '';
                    return;
                }
            }
        });
        
        // Initialize preview
        updatePreview();
    });
</script>
@endpush