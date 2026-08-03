@extends('layouts.admin')

@section('title', 'Edit Project - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}"
            class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Projects
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-emerald-600"></i>
                    Edit Project
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update project information</p>
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

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="p-6"
            id="projectForm">
            @csrf
            @method('PUT')

            {{-- Basic Information Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                    Basic Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Project Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                placeholder="Enter project name">
                        </div>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sector Dropdown using sector_id --}}
                    <div>
                        <label for="sector_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Sector <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <select id="sector_id" name="sector_id" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sector_id') border-red-500 @enderror">
                                <option value="">Select Sector</option>
                                @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('sector_id', $project->sector_id) == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the sector this project belongs to</p>
                        @error('sector_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Implementing Authority --}}
                    <div>
                        <label for="implementing_authority" class="block text-sm font-medium text-gray-700 mb-2">
                            Implementing Authority <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-university"></i>
                            </span>
                            <input type="text" id="implementing_authority" name="implementing_authority"
                                value="{{ old('implementing_authority', $project->implementing_authority) }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('implementing_authority') border-red-500 @enderror"
                                placeholder="Enter implementing authority">
                        </div>
                        @error('implementing_authority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location (NOT REQUIRED) --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Location
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" id="location" name="location" value="{{ old('location', $project->location) }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('location') border-red-500 @enderror"
                                placeholder="Enter project location (optional)">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Optional field</p>
                        @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Division - Multiple Select --}}
                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 mb-2">
                            Division(s) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">
                                <i class="fas fa-building"></i>
                            </span>
                            <select id="division" name="division[]" multiple required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('division') border-red-500 @enderror"
                                style="min-height: 120px;">
                                @foreach($divisions as $division)
                                @php
                                    // Get old values or existing project divisions
                                    $oldDivisions = old('division');
                                    if (is_null($oldDivisions) && isset($project)) {
                                        $oldDivisions = $project->division ? explode(',', $project->division) : [];
                                    }
                                    if (!is_array($oldDivisions)) {
                                        $oldDivisions = [];
                                    }
                                @endphp
                                <option value="{{ $division }}" {{ in_array($division, $oldDivisions) ? 'selected' : '' }}>
                                    {{ $division }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Hold CTRL (or CMD on Mac) to select multiple divisions</p>
                        @error('division')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Project Cost --}}
                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Cost (PKR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-rupee-sign"></i>
                            </span>
                            <input type="text" id="cost" name="cost" value="{{ old('cost', $project->cost) }}"
                                required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('cost') border-red-500 @enderror"
                                placeholder="0.00">
                        </div>
                        @error('cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-tag"></i>
                            </span>
                            <select id="category" name="category" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('category') border-red-500 @enderror"
                                onchange="toggleProjectDetails()">
                                <option value="">Select Category</option>
                                <option value="Pipeline" {{ old('category', $project->category) == 'Pipeline' ? 'selected' : '' }}>Pipeline</option>
                                <option value="Ongoing" {{ old('category', $project->category) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="Construction & Operational" {{ old('category', $project->category) == 'Construction & Operational' ? 'selected' : '' }}>Construction & Operational</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the project category to show relevant fields</p>
                        @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Field --}}
                    <div id="status-wrapper" style="{{ old('category', $project->category) == 'Pipeline' ? 'display: none;' : 'display: block;' }}">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Status <span id="status-required" class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-chart-simple"></i>
                            </span>
                            <select id="status" name="status"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                @if(old('category', $project->category) == 'Ongoing')
                                    <option value="Private Partner Selection" {{ old('status', $project->status) == 'Private Partner Selection' ? 'selected' : '' }}>Private Partner Selection</option>
                                    <option value="Transaction Advisory" {{ old('status', $project->status) == 'Transaction Advisory' ? 'selected' : '' }}>Transaction Advisory</option>
                                @elseif(old('category', $project->category) == 'Construction & Operational')
                                    <option value="Operational" {{ old('status', $project->status) == 'Operational' ? 'selected' : '' }}>Operational</option>
                                    <option value="Construction" {{ old('status', $project->status) == 'Construction' ? 'selected' : '' }}>Construction</option>
                                @endif
                            </select>
                        </div>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Project Image Upload --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-image mr-2 text-emerald-600"></i>
                    Project Image
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Image
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-camera"></i>
                            </span>
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('image') border-red-500 @enderror file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                onchange="previewImage(event)">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image. Allowed formats: JPEG, PNG, JPG, GIF. Max size: 5MB</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        @if($project->image && Storage::disk('public')->exists($project->image))
                        <div id="imagePreview"
                            class="w-full h-48 bg-gray-50 border-2 border-solid border-emerald-500 rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div id="imagePreview"
                            class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">No image selected</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Project Overview --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-align-left mr-2 text-emerald-600"></i>
                    Project Details
                </h4>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="overview" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Overview <span class="text-red-500">*</span>
                        </label>
                        <textarea id="overview" name="overview" rows="5" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('overview') border-red-500 @enderror"
                            placeholder="Provide a detailed overview of the project including objectives, scope, and key features...">{{ old('overview', $project->overview) }}</textarea>
                        @error('overview')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Pipeline Projects Section --}}
            <div id="pipeline-section" class="mb-6"
                style="{{ old('category', $project->category) == 'Pipeline' ? 'display: block;' : 'display: none;' }}">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Pipeline Project</h4>
                            <p class="text-xs text-blue-700 mt-1">
                                Pipeline projects only require basic information. No additional details needed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ongoing Project Details Section --}}
            <div id="ongoing-section" class="mb-6 pb-4 border-b border-gray-200"
                style="{{ old('category', $project->category) == 'Ongoing' ? 'display: block;' : 'display: none;' }}">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line mr-2 text-emerald-600"></i>
                    Ongoing Project Details
                </h4>
                <p class="text-sm text-text-muted mb-4">These fields are optional. You can leave them empty.</p>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="implementing_modality" class="block text-sm font-medium text-gray-700 mb-2">
                            Implementing Modality
                        </label>
                        <textarea id="implementing_modality" name="implementing_modality" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe the implementing modality (e.g., BOT, BOOT, Concession, etc.)...">{{ old('implementing_modality', $project->ongoingDetail->implementing_modality ?? '') }}</textarea>
                        @error('implementing_modality')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="government_contribution" class="block text-sm font-medium text-gray-700 mb-2">
                            Government Contribution
                        </label>
                        <textarea id="government_contribution" name="government_contribution" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe government contribution (financial, land, infrastructure, etc.)...">{{ old('government_contribution', $project->ongoingDetail->government_contribution ?? '') }}</textarea>
                        @error('government_contribution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="government_return" class="block text-sm font-medium text-gray-700 mb-2">
                            Government Return
                        </label>
                        <textarea id="government_return" name="government_return" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe returns to government (revenue share, taxes, royalties, etc.)...">{{ old('government_return', $project->ongoingDetail->government_return ?? '') }}</textarea>
                        @error('government_return')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="private_party_return" class="block text-sm font-medium text-gray-700 mb-2">
                            Private Party Return
                        </label>
                        <textarea id="private_party_return" name="private_party_return" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe returns to private party (profit margin, ROI, etc.)...">{{ old('private_party_return', $project->ongoingDetail->private_party_return ?? '') }}</textarea>
                        @error('private_party_return')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Construction & Operational Project Details Section --}}
            <div id="completed-section" class="mb-6 pb-4 border-b border-gray-200"
                style="{{ old('category', $project->category) == 'Construction & Operational' ? 'display: block;' : 'display: none;' }}">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-hard-hat mr-2 text-emerald-600"></i>
                    Construction & Operational Project Details
                </h4>
                <p class="text-sm text-text-muted mb-4">These fields are optional. You can leave them empty.</p>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="scope" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Scope
                        </label>
                        <textarea id="scope" name="scope" rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe the scope of the project...">{{ old('scope', $project->completedDetail->scope ?? '') }}</textarea>
                        @error('scope')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cost_financing_mix" class="block text-sm font-medium text-gray-700 mb-2">
                            Cost Financing Mix
                        </label>
                        <textarea id="cost_financing_mix" name="cost_financing_mix" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe the financing mix (e.g., 60% Government, 40% Private, loans, grants, etc.)...">{{ old('cost_financing_mix', $project->completedDetail->cost_financing_mix ?? '') }}</textarea>
                        @error('cost_financing_mix')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="project_timeline" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Timeline
                        </label>
                        <textarea id="project_timeline" name="project_timeline" rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe the project timeline (start date, end date, milestones, etc.)...">{{ old('project_timeline', $project->completedDetail->project_timeline ?? '') }}</textarea>
                        @error('project_timeline')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_financial_benefits_to_government"
                            class="block text-sm font-medium text-gray-700 mb-2">
                            Financial Benefits to Government
                        </label>
                        <textarea id="expected_financial_benefits_to_government"
                            name="expected_financial_benefits_to_government" rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Describe the financial benefits to the government...">{{ old('expected_financial_benefits_to_government', $project->completedDetail->expected_financial_benefits_to_government ?? '') }}</textarea>
                        @error('expected_financial_benefits_to_government')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Projects</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Projects are categorized into three types: <strong>Pipeline</strong> (basic info only),
                            <strong>Ongoing</strong> (includes implementation details and returns), and
                            <strong>Construction & Operational</strong> (includes scope, timeline, and benefits).
                            Select the appropriate category to display relevant fields.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.projects.index') }}"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (file) {
            if (file.size > 5242880) {
                alert('File is too large. Maximum size is 5MB.');
                event.target.value = '';
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Please upload JPG, JPEG, PNG, or GIF.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
                `;
                preview.classList.remove('border-dashed');
                preview.classList.add('border-solid', 'border-emerald-500');
            }
            reader.readAsDataURL(file);
        }
        // If no file selected, keep the existing image
    }

    function toggleProjectDetails() {
        const category = document.getElementById('category').value;
        const pipelineSection = document.getElementById('pipeline-section');
        const ongoingSection = document.getElementById('ongoing-section');
        const completedSection = document.getElementById('completed-section');
        const statusWrapper = document.getElementById('status-wrapper');
        const statusSelect = document.getElementById('status');
        const statusRequired = document.getElementById('status-required');

        // Hide all sections
        if (pipelineSection) pipelineSection.style.display = 'none';
        if (ongoingSection) ongoingSection.style.display = 'none';
        if (completedSection) completedSection.style.display = 'none';

        // Clear and hide status by default
        statusWrapper.style.display = 'none';
        statusSelect.removeAttribute('required');
        statusSelect.innerHTML = '<option value="">Select Status</option>';

        if (category === 'Pipeline') {
            if (pipelineSection) pipelineSection.style.display = 'block';
            // status remains hidden

        } else if (category === 'Ongoing') {
            if (ongoingSection) ongoingSection.style.display = 'block';
            statusWrapper.style.display = 'block';
            statusSelect.setAttribute('required', 'required');
            statusRequired.style.display = 'inline';
            const options = ['Private Partner Selection', 'Transaction Advisory'];
            const currentStatus = "{{ old('status', $project->status ?? '') }}";
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                if (currentStatus === opt) option.selected = true;
                statusSelect.appendChild(option);
            });

        } else if (category === 'Construction & Operational') {
            if (completedSection) completedSection.style.display = 'block';
            statusWrapper.style.display = 'block';
            statusSelect.setAttribute('required', 'required');
            statusRequired.style.display = 'inline';
            const options = ['Operational', 'Construction'];
            const currentStatus = "{{ old('status', $project->status ?? '') }}";
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                if (currentStatus === opt) option.selected = true;
                statusSelect.appendChild(option);
            });
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleProjectDetails();
    });
</script>
@endsection