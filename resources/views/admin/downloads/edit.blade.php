@extends('layouts.admin')

@section('title', 'Edit Document - PPP Department KPK')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.downloads.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Documents
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Document
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update document information</p>
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

        <form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            {{-- Document Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Document Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-heading"></i>
                    </span>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $download->title) }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror"
                        placeholder="e.g., Annual Report 2024, Investment Guidelines, PPP Policy Framework"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">The name/title of the document</p>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Document Type --}}
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Document Type <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                    <select 
                        id="type" 
                        name="type" 
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('type') border-red-500 @enderror"
                    >
                        <option value="">Select Document Type</option>
                        <option value="pitchbook" {{ old('type', $download->type) == 'pitchbook' ? 'selected' : '' }}>Pitchbook</option>
                        <option value="guidelines" {{ old('type', $download->type) == 'guidelines' ? 'selected' : '' }}>Guidelines</option>
                        <option value="reports" {{ old('type', $download->type) == 'reports' ? 'selected' : '' }}>Reports</option>
                        <option value="agreements" {{ old('type', $download->type) == 'agreements' ? 'selected' : '' }}>Agreements</option>
                        <option value="act" {{ old('type', $download->type) == 'act' ? 'selected' : '' }}>Act</option>
                        <option value="policy" {{ old('type', $download->type) == 'policy' ? 'selected' : '' }}>Policy</option>
                    </select>
                </div>
                <p class="mt-1 text-xs text-gray-500">Select the category for this document</p>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Date --}}
            <div class="mb-6">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                    Document Date <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <input 
                        type="date" 
                        id="date" 
                        name="date" 
                        value="{{ old('date', $download->date->format('Y-m-d')) }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('date') border-red-500 @enderror"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">The publication/issue date of the document</p>
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current File --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Current File
                </label>
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700">Current document: {{ basename($download->document_path) }}</p>
                        </div>
                        <a href="{{ route('admin.downloads.download', $download) }}" 
                           class="text-emerald-600 hover:text-emerald-900">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>

            {{-- New File Upload --}}
            <div class="mb-6">
                <label for="document_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Replace Document File (Optional)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-file-pdf"></i>
                    </span>
                    <input 
                        type="file" 
                        id="document_path" 
                        name="document_path" 
                        accept=".pdf"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('document_path') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                        onchange="previewFileInfo(event)"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Leave empty to keep current file. Allowed format: PDF only. Maximum size: 10MB</p>
                @error('document_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- File info preview --}}
                <div id="file-preview" class="mt-3 hidden">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <div class="flex-1">
                            <p id="file-name" class="text-sm font-medium text-gray-700"></p>
                            <p id="file-size" class="text-xs text-gray-500"></p>
                        </div>
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.downloads.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Document
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFileInfo(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        
        if (!file) {
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file type
        if (file.type !== 'application/pdf') {
            alert('Please upload a valid PDF file.');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be less than 10MB.');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Display file info
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
        preview.classList.remove('hidden');
    }
</script>
@endsection