@extends('layouts.admin')

@section('title', 'Add Team Member - PPP Department KPK')
@section('header-title', 'Add New Team Member')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    <div class="mb-6">
        <a href="{{ route('admin.team.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Team Members
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-plus mr-2 text-emerald-600"></i>
                    Add New Team Member
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new team member profile</p>
            </div>
        </div>

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

        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" id="name" name="name" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                               placeholder="Enter full name"
                               value="{{ old('name') }}">
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
                        <select id="designation_id" name="designation_id" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('designation_id') border-red-500 @enderror">
                            <option value="">Select Designation</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
                        <input type="email" id="email" name="email" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror"
                               placeholder="Enter email address"
                               value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Profile Image --}}
                <div>
                    <label for="img" class="block text-sm font-medium text-gray-700 mb-2">
                        Profile Image <span class="text-red-500">*</span>
                    </label>
                    <input type="file" id="img" name="img" accept="image/jpeg,image/png,image/jpg,image/webp" required
                           class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('img') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                           onchange="previewImage(event)">
                    <p class="mt-1 text-xs text-gray-500">Allowed formats: JPEG, PNG, JPG, WEBP. Max size: 2MB. Recommended: Square image (400x400px)</p>
                    @error('img')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <div id="image-preview" class="mt-3 hidden">
                        <div class="flex items-center gap-3">
                            <img id="preview-img" src="" alt="Preview"
                                 class="w-20 h-20 rounded-full object-cover border-4 border-emerald-100 shadow">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-check-circle text-emerald-600 mr-1"></i>
                                Image preview
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Experience --}}
            <div class="mt-6">
                <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">
                    Experience / Bio <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-history"></i>
                    </span>
                    <textarea id="experience" name="experience" rows="6" required
                              class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('experience') border-red-500 @enderror"
                              placeholder="Enter professional experience, qualifications, and background...">{{ old('experience') }}</textarea>
                </div>
                <p class="mt-1 text-xs text-gray-500">Include professional background, years of experience, key achievements, and qualifications</p>
                @error('experience')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                <a href="{{ route('admin.team.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Save Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a valid image file (JPEG, PNG, JPG, or WEBP).');
            event.target.value = '';
            document.getElementById('image-preview').classList.add('hidden');
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            event.target.value = '';
            document.getElementById('image-preview').classList.add('hidden');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection