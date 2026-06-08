@extends('layouts.admin')

@section('title', 'Edit Leadership Message - PPP Department KPK')
@section('header-title', 'Edit Leadership Message')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.leadership.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Messages
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Leadership Message
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update the leadership message and profile photo</p>
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

        <form action="{{ route('admin.leadership.update', $message->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $message->name) }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                        placeholder="Enter full name (e.g., Mr. Ahmad Khan)"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Full name of the leadership person</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Designation Dropdown --}}
<div class="mb-6">
    <label for="designation" class="block text-sm font-medium text-gray-700 mb-2">
        Designation <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
            <i class="fas fa-briefcase"></i>
        </span>
        <select 
            id="designation" 
            name="designation" 
            required
            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('designation') border-red-500 @enderror appearance-none bg-white"
        >
            <option value="">Select Designation</option>
            <option value="Chief Minister" {{ old('designation', $message->designation) == 'Chief Minister' ? 'selected' : '' }}>Chief Minister</option>
            <option value="Chief Secretary" {{ old('designation', $message->designation) == 'Chief Secretary' ? 'selected' : '' }}>Chief Secretary</option>
            <option value="Chief Secretary Development" {{ old('designation', $message->designation) == 'Chief Secretary Development' ? 'selected' : '' }}>Chief Secretary Development</option>
            <option value="Secretary P&D" {{ old('designation', $message->designation) == 'Secretary P&D' ? 'selected' : '' }}>Secretary P&D</option>
            <option value="Chief PPP" {{ old('designation', $message->designation) == 'Chief PPP' ? 'selected' : '' }}>Chief PPP</option>
          
        </select>
        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="fas fa-chevron-down"></i>
        </span>
    </div>
    <p class="mt-1 text-xs text-gray-500">Select the official designation from the list</p>
    @error('designation')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

            {{-- Message --}}
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Leadership Message <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-quote-left"></i>
                    </span>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6" 
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('message') border-red-500 @enderror"
                        placeholder="Write the leadership message here... (e.g., It is my privilege to lead the PPP Department...)"
                    >{{ old('message', $message->message) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Write a meaningful message that will inspire and connect with the audience</p>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Profile Photo
                </label>
                
                {{-- Current Image Display --}}
                @if($message->image)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $message->image) }}" 
                                 alt="Current image"
                                 class="w-20 h-20 rounded-full object-cover border-2 border-emerald-200 shadow">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Current Photo</p>
                                <p class="text-xs text-gray-500">Leave empty to keep this image</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-camera"></i>
                    </span>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('image') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                        onchange="previewImage(event)"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Allowed formats: JPEG, PNG, JPG, WEBP. Maximum size: 2MB. Recommended: Square image (400x400px)</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                {{-- Live preview for new image --}}
                <div id="image-preview" class="mt-3 hidden">
                    <div class="flex items-center gap-3">
                        <img id="preview-img" src="" alt="Preview"
                             class="w-24 h-24 rounded-full object-cover border-4 border-emerald-100 shadow">
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
                        <h4 class="text-sm font-medium text-blue-900">About Leadership Messages</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Leadership messages will be displayed on the frontend with the photo, name, designation, and message.
                            Each message helps connect the department leadership with the public.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.leadership.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Message
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
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a valid image file (JPEG, PNG, JPG, or WEBP).');
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