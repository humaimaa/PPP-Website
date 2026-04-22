{{-- resources/views/admin/projects/add.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Project - PPP Department KPK')
@section('header-title', 'Add New Project')

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
                <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                Project Information
            </h3>
            <p class="text-sm text-gray-500 mt-1">Fill in the details below to add a new project</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Project Name --}}
                <div>
                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="project_name" 
                        name="project_name" 
                        value="{{ old('project_name') }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('project_name') border-red-500 @enderror"
                        placeholder="Enter project name"
                    >
                    @error('project_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('category') border-red-500 @enderror"
                    >
                        <option value="">Select Category</option>
                        <option value="Transportation" {{ old('category') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                        <option value="Healthcare" {{ old('category') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Tourism" {{ old('category') == 'Tourism' ? 'selected' : '' }}>Tourism</option>
                        <option value="Water Infrastructure" {{ old('category') == 'Water Infrastructure' ? 'selected' : '' }}>Water Infrastructure</option>
                        <option value="Urban Development" {{ old('category') == 'Urban Development' ? 'selected' : '' }}>Urban Development</option>
                        <option value="Energy" {{ old('category') == 'Energy' ? 'selected' : '' }}>Energy</option>
                        <option value="Agriculture" {{ old('category') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Implementing Agency --}}
                <div>
                    <label for="implementing_agency" class="block text-sm font-medium text-gray-700 mb-2">
                        Implementing Agency <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="implementing_agency" 
                        name="implementing_agency" 
                        value="{{ old('implementing_agency') }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('implementing_agency') border-red-500 @enderror"
                        placeholder="Enter implementing agency"
                    >
                    @error('implementing_agency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Cost --}}
                <div>
                    <label for="project_cost" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Cost (Rs.) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.</span>
                        <input 
                            type="number" 
                            id="project_cost" 
                            name="project_cost" 
                            step="0.01" 
                            min="0"
                            value="{{ old('project_cost') }}"
                            required
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('project_cost') border-red-500 @enderror"
                            placeholder="0.00"
                        >
                    </div>
                    @error('project_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Government Funding --}}
                <div>
                    <label for="government_funding" class="block text-sm font-medium text-gray-700 mb-2">
                        Government Funding (Rs.) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.</span>
                        <input 
                            type="number" 
                            id="government_funding" 
                            name="government_funding" 
                            step="0.01" 
                            min="0"
                            value="{{ old('government_funding') }}"
                            required
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('government_funding') border-red-500 @enderror"
                            placeholder="0.00"
                        >
                    </div>
                    @error('government_funding')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sponsor Equity --}}
                <div>
                    <label for="sponsor_equity" class="block text-sm font-medium text-gray-700 mb-2">
                        Sponsor Equity (Rs.)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rs.</span>
                        <input 
                            type="number" 
                            id="sponsor_equity" 
                            name="sponsor_equity" 
                            step="0.01" 
                            min="0"
                            value="{{ old('sponsor_equity', '0.00') }}"
                            class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('sponsor_equity') border-red-500 @enderror"
                            placeholder="0.00"
                        >
                    </div>
                    @error('sponsor_equity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Status --}}
                <div>
                    <label for="project_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="project_status" 
                        name="project_status" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('project_status') border-red-500 @enderror"
                    >
                        <option value="">Select Status</option>
                        <option value="Planning" {{ old('project_status') == 'Planning' ? 'selected' : '' }}>Planning</option>
                        <option value="Feasibility Study" {{ old('project_status') == 'Feasibility Study' ? 'selected' : '' }}>Feasibility Study</option>
                        <option value="Bidding" {{ old('project_status') == 'Bidding' ? 'selected' : '' }}>Bidding</option>
                        <option value="Implementation" {{ old('project_status') == 'Implementation' ? 'selected' : '' }}>Implementation</option>
                        <option value="Completed" {{ old('project_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Operational" {{ old('project_status') == 'Operational' ? 'selected' : '' }}>Operational</option>
                    </select>
                    @error('project_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Image --}}
                <div class="md:col-span-2">
                    <label for="project_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Image <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input 
                                type="file" 
                                id="project_image" 
                                name="project_image" 
                                accept="image/jpeg,image/jpg,image/png,image/gif"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('project_image') border-red-500 @enderror"
                            >
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Max 5MB (JPG, JPEG, PNG, GIF)
                            </p>
                            @error('project_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <div id="imagePreview" class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center transition-all">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">No image selected</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Overview --}}
                <div class="md:col-span-2">
                    <label for="project_overview" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Overview <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="project_overview" 
                        name="project_overview" 
                        rows="5"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('project_overview') border-red-500 @enderror"
                        placeholder="Provide a detailed overview of the project..."
                    >{{ old('project_overview') }}</textarea>
                    @error('project_overview')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Project Benefits --}}
                <div class="md:col-span-2">
                    <label for="benefits" class="block text-sm font-medium text-gray-700 mb-2">
                        Project Benefits <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="benefits" 
                        name="benefits" 
                        rows="5"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('benefits') border-red-500 @enderror"
                        placeholder="List the key benefits of this project (one per line)&#10;• Benefit 1&#10;• Benefit 2&#10;• Benefit 3"
                    >{{ old('benefits') }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Tip: List benefits as bullet points (one per line)
                    </p>
                    @error('benefits')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="#" 
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                >
                    <i class="fas fa-plus mr-2"></i>
                    Add Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('project_image');
        const preview = document.getElementById('imagePreview');
        
        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                
                if (file) {
                    // Check file size
                    if (file.size > 5000000) {
                        alert('File is too large. Maximum size is 5MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Invalid file type. Please upload JPG, JPEG, PNG, or GIF.');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `
                            <img src="${e.target.result}" 
                                 class="w-full h-full object-contain rounded-lg" 
                                 alt="Project preview">
                        `;
                        preview.classList.add('border-emerald-500');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">No image selected</p>
                        </div>
                    `;
                    preview.classList.remove('border-emerald-500');
                }
            });
        }
        
        // Auto-calculate funding validation (optional)
        const projectCost = document.getElementById('project_cost');
        const govFunding = document.getElementById('government_funding');
        const sponsorEquity = document.getElementById('sponsor_equity');
        
        function validateFunding() {
            const total = parseFloat(projectCost.value) || 0;
            const gov = parseFloat(govFunding.value) || 0;
            const sponsor = parseFloat(sponsorEquity.value) || 0;
            
            if (gov > total) {
                govFunding.setCustomValidity('Government funding cannot exceed total project cost');
            } else {
                govFunding.setCustomValidity('');
            }
            
            if ((gov + sponsor) > total) {
                sponsorEquity.setCustomValidity('Total funding cannot exceed project cost');
            } else {
                sponsorEquity.setCustomValidity('');
            }
        }
        
        if (projectCost && govFunding && sponsorEquity) {
            projectCost.addEventListener('input', validateFunding);
            govFunding.addEventListener('input', validateFunding);
            sponsorEquity.addEventListener('input', validateFunding);
        }
    });
</script>
@endpush