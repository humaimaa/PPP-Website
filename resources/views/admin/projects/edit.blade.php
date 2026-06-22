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

                    {{-- Sector Dropdown from Database --}}
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-2">
                            Sector <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <select id="sector" name="sector" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sector') border-red-500 @enderror">
                                <option value="">Select Sector</option>
                                @foreach($sectors as $sector)
                                <option value="{{ $sector->name }}" {{ old('sector', $project->sector) == $sector->name ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Select the sector this project belongs to</p>
                        @error('sector')
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

            {{-- Rest of the form (image, overview, sections) remains the same as create.blade.php --}}
            {{-- ... (copy the rest from create.blade.php) ... --}}

        </form>
    </div>
</div>

<script>
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

        // Remove required attributes from all conditional fields first
        removeRequiredAttributes();

        // Clear and hide status by default
        statusWrapper.style.display = 'none';
        statusSelect.removeAttribute('required');
        statusSelect.innerHTML = '<option value="">Select Status</option>';

        if (category === 'Pipeline') {
            if (pipelineSection) pipelineSection.style.display = 'block';

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
            addRequiredAttributes(['implementing_modality', 'government_contribution', 'government_return', 'private_party_return']);

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
            addRequiredAttributes(['scope', 'cost_financing_mix', 'project_timeline', 'expected_financial_benefits_to_government']);
        }
    }

    function removeRequiredAttributes() {
        const allConditionalFields = [
            'implementing_modality', 'government_contribution', 'government_return',
            'private_party_return', 'scope', 'cost_financing_mix',
            'project_timeline', 'expected_financial_benefits_to_government'
        ];

        allConditionalFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.removeAttribute('required');
                field.disabled = false;
            }
        });
    }

    function addRequiredAttributes(fieldIds) {
        fieldIds.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.setAttribute('required', 'required');
                field.disabled = false;
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleProjectDetails();
    });
</script>
@endsection