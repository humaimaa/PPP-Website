@extends('layouts.admin')

@section('title', 'Edit Sector - PPP Unit KP')
@section('header-title', 'Edit Sector')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.sectors.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Sectors
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Sector
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update sector information</p>
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

        <form action="{{ route('admin.sectors.update', $sector) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            {{-- Sector Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Sector Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-building"></i>
                    </span>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $sector->name) }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Infrastructure, Energy, Health, Education"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">The name of the investment sector</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tagline --}}
            <div class="mb-6">
                <label for="tagline" class="block text-sm font-medium text-gray-700 mb-2">
                    Tagline <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                    <textarea 
                        id="tagline" 
                        name="tagline" 
                        rows="3"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tagline') border-red-500 @enderror"
                        placeholder="Enter a compelling tagline or description for this sector..."
                    >{{ old('tagline', $sector->tagline) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Brief description that will appear on the sector cards</p>
                @error('tagline')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Current Image
                </label>
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-4">
                        <div class="w-32 h-32 rounded-lg overflow-hidden border-2 border-emerald-200 bg-gray-50">
                            <img src="{{ asset('storage/' . $sector->img) }}" 
                                 alt="{{ $sector->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Current sector image</p>
                            <p class="text-xs text-gray-500 mt-1">Upload a new image below to replace it</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- New Image (Optional) --}}
            <div class="mb-6">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-2">
                    New Image (Optional)
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-image"></i>
                    </span>
                    <input 
                        type="file" 
                        id="img" 
                        name="img" 
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('img') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                        onchange="previewImage(event)"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Leave empty to keep the current image. Allowed formats: JPEG, PNG, JPG, GIF. Maximum size: 2MB. Recommended: 800x600px</p>
                @error('img')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Live preview for new image --}}
                <div id="image-preview" class="mt-3 hidden">
                    <div class="flex items-center gap-3">
                        <img id="preview-img" src="" alt="Preview"
                             class="w-32 h-32 object-cover rounded-lg border-4 border-emerald-100 shadow">
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-check-circle text-emerald-600 mr-1"></i>
                            New image preview
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Sectors</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Sectors represent different investment categories (e.g., Infrastructure, Energy, Health). 
                            Each sector will be displayed on the frontend with its name, tagline, and image.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.sectors.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Sector
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (!file) {
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a valid image file (JPEG, PNG, JPG, or GIF).');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection