{{-- resources/views/admin/updates/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Update - PPP Department KPK')
@section('header-title', 'Edit Update')

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
            Edit Update #<span id="updateId"></span>
        </h2>
        <a href="{{ route('admin.updates.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Updates List
        </a>
    </div>

    {{-- Edit Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                Edit Update Details
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update the information below</p>
        </div>

        <form id="editUpdateForm" class="p-6">
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
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Enter update title"
                        >
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        >
                            <option value="">Select Type</option>
                            <option value="Update">Update</option>
                            <option value="Event">Event</option>
                            <option value="Announcement">Announcement</option>
                            <option value="Press Release">Press Release</option>
                            <option value="Notice">Notice</option>
                            <option value="Circular">Circular</option>
                        </select>
                    </div>

                    {{-- Event Date --}}
                    <div id="eventDateField">
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Event Date
                        </label>
                        <input 
                            type="date" 
                            id="event_date" 
                            name="event_date"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Required for events only
                        </p>
                    </div>

                    {{-- Featured Toggle --}}
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                id="is_featured" 
                                name="is_featured" 
                                value="1"
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-file-pdf mr-1"></i>
                            PDF only (max 10MB). Leave empty to keep current file.
                        </p>
                        <div id="currentPdfInfo" class="mt-3 p-3 bg-gray-50 rounded-lg hidden">
                            <p class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                Current file: 
                                <a href="#" id="pdfLink" target="_blank" class="ml-1 text-emerald-600 hover:underline">View PDF</a>
                            </p>
                        </div>
                    </div>

                    {{-- Preview Card --}}
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-eye mr-1"></i>
                            Quick Preview
                        </h4>
                        <div id="previewCard" class="bg-white rounded-lg border border-gray-200 p-3">
                            <div class="flex items-start justify-between mb-2">
                                <span id="previewType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Update
                                </span>
                                <span id="previewFeatured" class="text-yellow-500 hidden">
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <h5 id="previewTitle" class="font-semibold text-gray-900 mb-1 text-sm">Title</h5>
                            <p id="previewContent" class="text-xs text-gray-600 line-clamp-2">Content preview...</p>
                        </div>
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
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="Write the update content here. This will appear as the short description below the title..."
                ></textarea>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-pencil-alt mr-1"></i>
                        <span id="charCount">0</span> characters
                    </p>
                    <p class="text-xs text-gray-400">
                        Recommended: 150-500 characters
                    </p>
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
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dummy updates data (simulating data from database)
        const dummyUpdates = {
            1: {
                id: 1,
                title: "PPP Department Launches New Infrastructure Initiative",
                type: "Update",
                content: "The PPP Department KPK has announced a groundbreaking infrastructure initiative aimed at developing sustainable public-private partnerships across the province. This initiative will focus on transportation, healthcare, and education sectors.",
                event_date: null,
                created_at: "2024-03-15 09:30:00",
                updated_at: "2024-03-18 14:20:00",
                is_featured: true,
                pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
            },
            2: {
                id: 2,
                title: "Investor Conference 2024 - Save the Date",
                type: "Event",
                content: "Join us for the annual PPP Investor Conference 2024, bringing together government officials, private investors, and industry experts to explore investment opportunities in Khyber Pakhtunkhwa.",
                event_date: "2024-05-20",
                created_at: "2024-03-10 14:15:00",
                updated_at: "2024-03-12 11:30:00",
                is_featured: true,
                pdf_path: null
            },
            3: {
                id: 3,
                title: "Swat Expressway Project Progress",
                type: "Update",
                content: "Construction of the Swat Expressway Extension has reached 65% completion. The project is on track for completion by December 2024, with all major bridges and interchanges now under construction.",
                event_date: null,
                created_at: "2024-03-05 11:00:00",
                updated_at: "2024-03-08 09:45:00",
                is_featured: false,
                pdf_path: null
            },
            4: {
                id: 4,
                title: "New Tender Announcement: Healthcare Facilities",
                type: "Announcement",
                content: "The PPP Department invites sealed bids for the development of modern healthcare facilities in Peshawar, Mardan, and Swat districts. Bid submission deadline is April 30, 2024.",
                event_date: null,
                created_at: "2024-02-28 16:45:00",
                updated_at: "2024-03-01 10:15:00",
                is_featured: false,
                pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
            }
        };

        // Get update ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        let updateId = urlParams.get('id') || '1';
        
        if (!dummyUpdates[updateId]) {
            updateId = Object.keys(dummyUpdates)[0];
        }
        
        const update = dummyUpdates[updateId];
        
        // Populate form
        document.getElementById('updateId').textContent = update.id;
        document.getElementById('title').value = update.title;
        document.getElementById('type').value = update.type;
        document.getElementById('content').value = update.content;
        document.getElementById('is_featured').checked = update.is_featured;
        
        if (update.event_date) {
            document.getElementById('event_date').value = update.event_date;
        }
        
        // Display dates
        document.getElementById('createdDate').textContent = new Date(update.created_at).toLocaleDateString('en-PK', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
        document.getElementById('updatedDate').textContent = new Date(update.updated_at).toLocaleDateString('en-PK', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
        
        // Display current PDF if exists
        if (update.pdf_path) {
            document.getElementById('currentPdfInfo').classList.remove('hidden');
            document.getElementById('pdfLink').href = update.pdf_path;
        }
        
        // Toggle event date field based on type
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
            }
            updatePreview();
        }
        
        typeSelect.addEventListener('change', toggleEventDate);
        toggleEventDate();
        
        // Character count
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');
        
        function updateCharCount() {
            const count = contentTextarea.value.length;
            charCount.textContent = count;
            
            if (count > 500) {
                charCount.classList.add('text-yellow-600');
                charCount.classList.remove('text-green-600');
            } else if (count >= 150) {
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
        const previewFeatured = document.getElementById('previewFeatured');
        
        function updatePreview() {
            const type = typeSelect.value || 'Update';
            previewType.textContent = type;
            
            const typeColors = {
                'Update': 'bg-green-100 text-green-800',
                'Event': 'bg-purple-100 text-purple-800',
                'Announcement': 'bg-yellow-100 text-yellow-800',
                'Press Release': 'bg-red-100 text-red-800',
                'Notice': 'bg-orange-100 text-orange-800',
                'Circular': 'bg-blue-100 text-blue-800'
            };
            previewType.className = `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${typeColors[type] || 'bg-gray-100 text-gray-800'}`;
            
            previewTitle.textContent = titleInput.value || 'Title will appear here';
            previewContent.textContent = contentTextarea.value || 'Content preview will appear here...';
            
            if (featuredCheckbox.checked) {
                previewFeatured.classList.remove('hidden');
            } else {
                previewFeatured.classList.add('hidden');
            }
        }
        
        titleInput.addEventListener('input', updatePreview);
        typeSelect.addEventListener('change', updatePreview);
        contentTextarea.addEventListener('input', updatePreview);
        featuredCheckbox.addEventListener('change', updatePreview);
        
        // File validation
        const pdfInput = document.getElementById('pdf_file');
        
        pdfInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    showError('Please select a valid PDF file.');
                    this.value = '';
                    return;
                }
                
                if (file.size > 10000000) {
                    showError('File size exceeds 10MB. Please choose a smaller file.');
                    this.value = '';
                    return;
                }
            }
        });
        
        // Form submission
        document.getElementById('editUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('title').value;
            const type = document.getElementById('type').value;
            const content = document.getElementById('content').value;
            
            if (!title || !type || !content) {
                showError('Please fill in all required fields.');
                return;
            }
            
            if (type === 'Event' && !eventDateInput.value) {
                showError('Event date is required for Event type.');
                return;
            }
            
            showSuccess(`"${title}" updated successfully!`);
            
            setTimeout(() => {
                // window.location.href = '{{ route("admin.updates.index") }}';
                console.log('Redirecting to updates list...');
            }, 2000);
        });
        
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
        
        updatePreview();
    });
</script>
@endpush