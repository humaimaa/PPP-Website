@extends('layouts.admin')

@section('title', 'Add New Tender - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.tenders.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Tenders
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-file-alt mr-2 text-emerald-600"></i>
                    Add New Tender
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new tender advertisement</p>
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

        <form action="{{ route('admin.tenders.store') }}" method="POST" enctype="multipart/form-data" class="p-6" id="tenderForm">
            @csrf
            
            {{-- Basic Information Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                    Basic Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tender Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tender Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-file-signature"></i>
                            </span>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                placeholder="Enter tender name"
                            >
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-tag"></i>
                            </span>
                            <select 
                                id="category" 
                                name="category" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('category') border-red-500 @enderror"
                            >
                                <option value="">Select Category</option>
                                <option value="General Procurement" {{ old('category') == 'General Procurement' ? 'selected' : '' }}>General Procurement</option>
                                <option value="Transaction Advisory" {{ old('category') == 'Transaction Advisory' ? 'selected' : '' }}>Transaction Advisory</option>
                                <option value="Private Partner Selection" {{ old('category') == 'Private Partner Selection' ? 'selected' : '' }}>Private Partner Selection</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the tender category</p>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Opening Date --}}
                    <div>
                        <label for="opening_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Opening Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input 
                                type="date" 
                                id="opening_date" 
                                name="opening_date" 
                                value="{{ old('opening_date') }}"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('opening_date') border-red-500 @enderror"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Date when tender will be opened</p>
                        @error('opening_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Closing Date --}}
                    <div>
                        <label for="closing_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Closing Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-calendar-times"></i>
                            </span>
                            <input 
                                type="date" 
                                id="closing_date" 
                                name="closing_date" 
                                value="{{ old('closing_date') }}"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('closing_date') border-red-500 @enderror"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Date when tender submission closes</p>
                        @error('closing_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Documents Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-file-upload mr-2 text-emerald-600"></i>
                    Documents
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tender Document (PDF Only) --}}
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                            Tender Document <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-file-pdf"></i>
                            </span>
                            <input 
                                type="file" 
                                id="document" 
                                name="document" 
                                accept=".pdf"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('document') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                onchange="validateDocument(event)"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-check-circle text-emerald-600 mr-1"></i>
                            Only PDF files are allowed. Max size: 10MB
                        </p>
                        <div id="document-preview" class="mt-3 hidden">
                            <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-lg">
                                <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-emerald-600 mr-1"></i>
                                    PDF document ready to upload
                                </div>
                            </div>
                        </div>
                        @error('document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Advertisement Image (PDF or Image) --}}
                    <div>
                        <label for="advertisement" class="block text-sm font-medium text-gray-700 mb-2">
                            Advertisement
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-image"></i>
                            </span>
                            <input 
                                type="file" 
                                id="advertisement" 
                                name="advertisement" 
                                accept=".pdf,.jpg,.jpeg,.png,.webp"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('advertisement') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                onchange="validateAdvertisement(event)"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Allowed formats: PDF, JPEG, PNG, JPG, WEBP. Max size: 5MB
                        </p>
                        <div id="advertisement-preview" class="mt-3 hidden">
                            <div class="flex items-center gap-3">
                                <div id="ad-preview-content"></div>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-emerald-600 mr-1"></i>
                                    File ready to upload
                                </div>
                            </div>
                        </div>
                        @error('advertisement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Additional Documents Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-paperclip mr-2 text-emerald-600"></i>
                    Additional Documents (Optional)
                </h4>
                <div id="additional-docs-container">
                    <div class="additional-doc-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 relative">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Title</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-heading"></i>
                                </span>
                                <input type="text" name="additional_docs[0][title]" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       placeholder="e.g., BOQ Document, Terms of Reference">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <input type="date" name="additional_docs[0][publish_date]" 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document File</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-file-upload"></i>
                                </span>
                                <input type="file" name="additional_docs[0][document]" 
                                       accept=".pdf,.doc,.docx"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                       onchange="validateAdditionalDoc(this)">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX  (Max: 10MB)</p>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-more-docs" 
                        class="mt-2 inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium transition">
                    <i class="fas fa-plus-circle"></i>
                    Add More Documents
                </button>
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Tenders</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Tenders are categorized into three types: <strong>General Procurement</strong> (standard procurement), 
                            <strong>Transaction Advisory</strong> (advisory services), and 
                            <strong>Private Partner Selection</strong> (PPP partner selection). 
                            <br><br>
                            <strong>File Requirements:</strong>
                            <br>• Tender Document: <strong>PDF only</strong> (max 10MB)
                            <br>• Advertisement: <strong>PDF or Images</strong> (max 5MB)
                            <br>• Additional Documents: PDF, DOC, DOCX (max 10MB each)
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tenders.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Create Tender
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let docIndex = 1;
    
    // Validate tender document (PDF only)
    function validateDocument(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('document-preview');
        
        if (file) {
            // Check file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('File is too large. Maximum size is 10MB.');
                event.target.value = '';
                preview.classList.add('hidden');
                return;
            }
            
            // Check if file is PDF
            if (file.type !== 'application/pdf') {
                alert('Invalid file type. Only PDF files are allowed for tender document.');
                event.target.value = '';
                preview.classList.add('hidden');
                return;
            }
            
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }
    
    // Validate advertisement (PDF or Images)
    function validateAdvertisement(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('advertisement-preview');
        const previewContent = document.getElementById('ad-preview-content');
        
        if (!file) {
            preview.classList.add('hidden');
            return;
        }
        
        // Check file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File is too large. Maximum size is 5MB.');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please upload PDF, JPEG, PNG, JPG, or WEBP files.');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Show preview based on file type
        if (file.type === 'application/pdf') {
            previewContent.innerHTML = `
                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-file-pdf text-red-500 text-3xl"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-700">${file.name}</p>
                        <p class="text-xs text-gray-500">PDF Document</p>
                    </div>
                </div>
            `;
        } else {
            // Image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `
                    <img src="${e.target.result}" alt="Advertisement Preview"
                         class="w-32 h-32 object-cover rounded-lg border-2 border-emerald-100 shadow">
                `;
            };
            reader.readAsDataURL(file);
        }
        
        preview.classList.remove('hidden');
    }
    
    // Validate additional documents
    function validateAdditionalDoc(input) {
        const file = input.files[0];
        if (file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('File is too large. Maximum size is 10MB.');
                input.value = '';
                return;
            }
            
            const allowedTypes = ['application/pdf', 'application/msword', 
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg', 'image/png', 'image/jpg'];
            
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Please upload PDF, DOC, DOCX, JPG, or PNG files.');
                input.value = '';
                return;
            }
        }
    }
    
    // Add more document fields
    document.getElementById('add-more-docs').addEventListener('click', function() {
        const container = document.getElementById('additional-docs-container');
        const newDocItem = document.createElement('div');
        newDocItem.className = 'additional-doc-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 relative';
        newDocItem.innerHTML = `
            <button type="button" class="absolute -top-2 -right-2 text-red-500 hover:text-red-700 bg-white rounded-full w-6 h-6 flex items-center justify-center shadow-md transition" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Document Title</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-heading"></i>
                    </span>
                    <input type="text" name="additional_docs[${docIndex}][title]" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="e.g., BOQ Document, Terms of Reference">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-calendar"></i>
                    </span>
                    <input type="date" name="additional_docs[${docIndex}][publish_date]" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Document File</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-file-upload"></i>
                    </span>
                    <input type="file" name="additional_docs[${docIndex}][document]" 
                           accept=".pdf,.doc,.docx"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                           onchange="validateAdditionalDoc(this)">
                </div>
                <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX  (Max: 10MB)</p>
            </div>
        `;
        container.appendChild(newDocItem);
        docIndex++;
    });
    
    // Validate closing date is after opening date
    const openingDate = document.getElementById('opening_date');
    const closingDate = document.getElementById('closing_date');
    
    function validateDates() {
        if (openingDate.value && closingDate.value) {
            if (new Date(closingDate.value) <= new Date(openingDate.value)) {
                closingDate.setCustomValidity('Closing date must be after opening date');
                closingDate.reportValidity();
            } else {
                closingDate.setCustomValidity('');
            }
        }
    }
    
    if (openingDate) {
        openingDate.addEventListener('change', validateDates);
    }
    if (closingDate) {
        closingDate.addEventListener('change', validateDates);
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        if (openingDate && openingDate.value && closingDate && closingDate.value) {
            validateDates();
        }
    });
</script>
@endsection