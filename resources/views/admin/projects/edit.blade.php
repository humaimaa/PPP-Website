{{-- resources/views/admin/projects/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Project - PPP Department KPK')
@section('header-title', 'Edit Project')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Success Message (Hidden by default) --}}
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
            Edit Project Details
        </h2>
        <a href="{{ route('admin.projects.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Projects
        </a>
    </div>

    {{-- Edit Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                Edit Project #<span id="projectId"></span>
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update the project information below</p>
        </div>

        <form id="editProjectForm" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-4">
                    {{-- Project Name --}}
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Project Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="project_name" 
                            name="project_name" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Enter project name"
                        >
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        >
                            <option value="">Select Category</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Education">Education</option>
                            <option value="Tourism">Tourism</option>
                            <option value="Energy">Energy</option>
                            <option value="Water Infrastructure">Water Infrastructure</option>
                            <option value="Urban Development">Urban Development</option>
                        </select>
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
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Enter implementing agency"
                        >
                    </div>

                    {{-- Location --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Location
                        </label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Enter project location"
                        >
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-4">
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
                                required
                                class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="0.00"
                            >
                        </div>
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
                                required
                                class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="0.00"
                            >
                        </div>
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
                                class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="0.00"
                            >
                        </div>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                        >
                            <option value="">Select Status</option>
                            <option value="Planning">Planning</option>
                            <option value="Feasibility Study">Feasibility Study</option>
                            <option value="Bidding">Bidding</option>
                            <option value="Implementation">Implementation</option>
                            <option value="Completed">Completed</option>
                            <option value="Operational">Operational</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Project Image --}}
            <div class="mt-6">
                <label for="project_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Project Image
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input 
                            type="file" 
                            id="project_image" 
                            name="project_image" 
                            accept="image/jpeg,image/jpg,image/png,image/gif"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Max 5MB (JPG, JPEG, PNG, GIF). Leave empty to keep current image.
                        </p>
                    </div>
                    <div>
                        <div id="imagePreview" class="w-full h-48 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center transition-all">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Current image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Overview --}}
            <div class="mt-6">
                <label for="project_overview" class="block text-sm font-medium text-gray-700 mb-2">
                    Project Overview <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="project_overview" 
                    name="project_overview" 
                    rows="5"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="Provide a detailed overview of the project..."
                ></textarea>
            </div>

            {{-- Project Benefits --}}
            <div class="mt-6">
                <label for="benefits" class="block text-sm font-medium text-gray-700 mb-2">
                    Project Benefits <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="benefits" 
                    name="benefits" 
                    rows="5"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    placeholder="List the key benefits of this project (one per line)&#10;• Benefit 1&#10;• Benefit 2&#10;• Benefit 3"
                ></textarea>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-lightbulb mr-1"></i>
                    Tip: List benefits as bullet points (one per line)
                </p>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('admin.projects.index') }}" 
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
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dummy project data (simulating data from database)
        const dummyProjects = {
            1: {
                id: 1,
                project_name: "Swat Expressway Extension",
                category: "Transportation",
                implementing_agency: "Pakhtunkhwa Highways Authority",
                location: "Swat, Khyber Pakhtunkhwa",
                project_cost: 35000000000,
                government_funding: 20000000000,
                sponsor_equity: 15000000000,
                project_status: "Implementation",
                project_overview: "The Swat Expressway Extension project aims to extend the existing expressway by 80 kilometers, connecting major cities and reducing travel time significantly. This project will include the construction of 6 interchanges, 3 major bridges, and modern toll plazas. The expressway will feature state-of-the-art traffic management systems and safety features.",
                benefits: "Reduced travel time between Swat and Peshawar by 2 hours\nEnhanced trade and tourism opportunities\nImproved road safety with modern infrastructure\nCreation of 5,000+ jobs during construction\nBoost to local economy and real estate development",
                image_path: "https://images.pexels.com/photos/1117210/pexels-photo-1117210.jpeg",
                created_at: "2024-01-15 10:30:00",
                updated_at: "2024-03-20 14:45:00"
            },
            2: {
                id: 2,
                project_name: "Peshawar Healthcare City",
                category: "Healthcare",
                implementing_agency: "Health Department KPK",
                location: "Peshawar, Khyber Pakhtunkhwa",
                project_cost: 12500000000,
                government_funding: 8000000000,
                sponsor_equity: 4500000000,
                project_status: "Bidding",
                project_overview: "Peshawar Healthcare City is a state-of-the-art medical complex spanning 500 acres. The project includes a 1000-bed tertiary care hospital, medical college, nursing school, research center, and specialized clinics. The facility will provide advanced healthcare services including cardiology, oncology, neurology, and transplant services.",
                benefits: "Access to world-class healthcare facilities\nMedical education and training opportunities\nReduced need for medical tourism abroad\nCreation of 3,000+ healthcare jobs\nResearch and innovation in medical sciences",
                image_path: "https://images.pexels.com/photos/263402/pexels-photo-263402.jpeg",
                created_at: "2024-02-01 09:15:00",
                updated_at: "2024-03-10 11:30:00"
            },
            3: {
                id: 3,
                project_name: "Chitral Hydropower Project",
                category: "Energy",
                implementing_agency: "Energy & Power Department KPK",
                location: "Chitral, Khyber Pakhtunkhwa",
                project_cost: 45000000000,
                government_funding: 25000000000,
                sponsor_equity: 20000000000,
                project_status: "Feasibility Study",
                project_overview: "The Chitral Hydropower Project is a 300 MW run-of-river hydropower facility on the Chitral River. The project includes construction of a dam, powerhouse, transmission lines, and associated infrastructure. This renewable energy project will contribute significantly to the national grid and reduce dependence on fossil fuels.",
                benefits: "300 MW of clean, renewable energy generation\nReduced carbon emissions by 1.2 million tons annually\nFlood control and water management benefits\nElectrification of remote villages\nSustainable development of Chitral region",
                image_path: "https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg",
                created_at: "2024-01-20 11:00:00",
                updated_at: "2024-03-25 16:20:00"
            }
        };

        // Get project ID from URL or use default
        const urlParams = new URLSearchParams(window.location.search);
        let projectId = urlParams.get('id') || '1'; // Default to project 1 if no ID provided
        
        // If ID not found in dummy data, use first project
        if (!dummyProjects[projectId]) {
            projectId = Object.keys(dummyProjects)[0];
        }
        
        const project = dummyProjects[projectId];
        
        // Populate form with project data
        document.getElementById('projectId').textContent = project.id;
        document.getElementById('project_name').value = project.project_name;
        document.getElementById('category').value = project.category;
        document.getElementById('implementing_agency').value = project.implementing_agency;
        document.getElementById('location').value = project.location || '';
        document.getElementById('project_cost').value = project.project_cost;
        document.getElementById('government_funding').value = project.government_funding;
        document.getElementById('sponsor_equity').value = project.sponsor_equity || 0;
        document.getElementById('project_status').value = project.project_status;
        document.getElementById('project_overview').value = project.project_overview;
        document.getElementById('benefits').value = project.benefits;
        
        // Display current image
        const preview = document.getElementById('imagePreview');
        if (project.image_path) {
            preview.innerHTML = `
                <img src="${project.image_path}" 
                     class="w-full h-full object-contain rounded-lg" 
                     alt="${project.project_name}"
                     onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
            `;
            preview.classList.add('border-emerald-500');
        }
        
        // Image preview functionality
        const imageInput = document.getElementById('project_image');
        
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Check file size
                if (file.size > 5000000) {
                    showError('File is too large. Maximum size is 5MB.');
                    this.value = '';
                    return;
                }
                
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    showError('Invalid file type. Please upload JPG, JPEG, PNG, or GIF.');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" 
                             class="w-full h-full object-contain rounded-lg" 
                             alt="Preview">
                    `;
                    preview.classList.add('border-emerald-500');
                }
                reader.readAsDataURL(file);
            } else {
                // Restore current image
                if (project.image_path) {
                    preview.innerHTML = `
                        <img src="${project.image_path}" 
                             class="w-full h-full object-contain rounded-lg" 
                             alt="${project.project_name}"
                             onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                    `;
                } else {
                    preview.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">Current image</p>
                        </div>
                    `;
                    preview.classList.remove('border-emerald-500');
                }
            }
        });
        
        // Form submission
        document.getElementById('editProjectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Validate required fields
            if (!data.project_name || !data.category || !data.implementing_agency || 
                !data.project_cost || !data.government_funding || !data.project_status || 
                !data.project_overview || !data.benefits) {
                showError('Please fill in all required fields.');
                return;
            }
            
            // Validate numeric fields
            if (isNaN(data.project_cost) || isNaN(data.government_funding) || 
                (data.sponsor_equity && isNaN(data.sponsor_equity))) {
                showError('Project cost, government funding, and sponsor equity must be numeric values.');
                return;
            }
            
            // Simulate successful update
            showSuccess(`Project "${data.project_name}" updated successfully!`);
            
            // Optional: Redirect after delay
            setTimeout(() => {
                // window.location.href = '{{ route("admin.projects.index") }}';
                console.log('Redirecting to projects list...');
            }, 2000);
        });
        
        // Helper functions for showing messages
        function showError(message) {
            const errorEl = document.getElementById('errorMessage');
            errorEl.querySelector('span').textContent = message;
            errorEl.classList.remove('hidden');
            
            setTimeout(() => {
                errorEl.classList.add('hidden');
            }, 5000);
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function showSuccess(message) {
            const successEl = document.getElementById('successMessage');
            successEl.querySelector('span').textContent = message;
            successEl.classList.remove('hidden');
            
            setTimeout(() => {
                successEl.classList.add('hidden');
            }, 5000);
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        // Auto-calculate funding validation
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
        
        projectCost.addEventListener('input', validateFunding);
        govFunding.addEventListener('input', validateFunding);
        sponsorEquity.addEventListener('input', validateFunding);
    });
</script>
@endpush