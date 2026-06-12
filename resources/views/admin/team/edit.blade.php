@extends('layouts.admin')

@section('title', 'Edit Team Member - PPP Unit KPK')
@section('header-title', 'Edit Team Member')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.team.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Team Members
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-user-edit mr-2 text-emerald-600"></i>
                        Edit Team Member
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Update team member information</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('admin.team.destroy', $teamMember) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this team member? This action cannot be undone.');">
                        @csrf
                       
                    </form>
                </div>
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

        {{-- Success Message (if any from redirect) --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 m-6">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.team.update', $teamMember) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            {{-- Basic Information Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                    Basic Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Full Name --}}
                    <div>
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
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                placeholder="Enter full name"
                                value="{{ old('name', $teamMember->name) }}">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Designation --}}
                    <div>
                        <label for="designation_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Designation <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-briefcase"></i>
                            </span>
                            <select 
                                id="designation_id" 
                                name="designation_id" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('designation_id') border-red-500 @enderror">
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id', $teamMember->designation_id) == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the team member's official designation</p>
                        @error('designation_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror"
                                placeholder="Enter email address"
                                value="{{ old('email', $teamMember->email) }}">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Valid email address for contact purposes</p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('phone') border-red-500 @enderror"
                                placeholder="Enter phone number"
                                value="{{ old('phone', $teamMember->phone) }}">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Enter the team member's phone number</p>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Profile Photo Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-camera mr-2 text-emerald-600"></i>
                    Profile Photo
                </h4>
                <div class="grid grid-cols-1 gap-6">
                    {{-- Profile Image --}}
                    <div>
                        <label for="img" class="block text-sm font-medium text-gray-700 mb-2">
                            Profile Photo
                        </label>
                        
                        @if($teamMember->img)
                            <div class="mb-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $teamMember->img) }}" 
                                         alt="{{ $teamMember->name }}"
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
                                id="img" 
                                name="img" 
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('img') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                onchange="previewImage(event)">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Allowed formats: JPEG, PNG, JPG, WEBP. Max size: 2MB. Recommended: Square image (400x400px)
                        </p>
                        @error('img')
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
                </div>
            </div>

            {{-- Metadata Section --}}
            <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                    Record Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created At</label>
                        <div class="text-sm text-gray-700">
                            <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                            {{ $teamMember->created_at->format('F d, Y ') }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Last Updated</label>
                        <div class="text-sm text-gray-700">
                            <i class="far fa-clock text-gray-400 mr-1"></i>
                            {{ $teamMember->updated_at->format('F d, Y ') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Team Members</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Team members will be displayed on the frontend team page with their photo, name, designation, 
                            email, and phone number. This helps showcase the department's expertise and leadership.
                            <br><br>
                            <strong>Note:</strong> If you upload a new profile photo, the old one will be automatically deleted.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.team.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Team Member
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