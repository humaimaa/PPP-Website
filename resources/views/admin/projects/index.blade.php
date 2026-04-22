{{-- resources/views/admin/projects/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Projects List - PPP Department KPK')
@section('header-title', 'Projects Management')

@section('content')
<div class="max-w-full mx-auto">
    {{-- Success Message (Hidden by default) --}}
    <div id="successMessage"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 hidden items-center"
        role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Error Message (Hidden by default) --}}
    <div id="errorMessage"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 hidden items-center"
        role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span></span>
    </div>

    {{-- Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                All Projects
            </h2>
            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full"
                id="totalProjects">
                6 Total
            </span>
        </div>
        <a href="#"
            class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Add New Project
        </a>
    </div>

    {{-- Projects Table Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Image
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Project Details
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cost (PKR)
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="projectsTableBody">
                    {{-- Dummy data will be inserted here via JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Showing
                    <span class="font-medium">1</span>
                    to
                    <span class="font-medium">6</span>
                    of
                    <span class="font-medium">6</span>
                    results
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-emerald-600 text-sm font-medium text-white">1</a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Project Details Modal --}}
<div id="projectModal" class="fixed inset-0 z-50 top-10 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

        {{-- Modal Content --}}
        <div
            class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden transform transition-all">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                    <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                    Project Details
                </h3>
                <button type="button" onclick="closeModal()"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none p-1 rounded hover:bg-gray-100 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-130px)]">
                <div id="modalContent">
                    {{-- Content will be loaded dynamically --}}
                    <div class="flex items-center justify-center py-12">
                        <i class="fas fa-spinner fa-spin text-2xl text-emerald-600"></i>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                    Close
                </button>
                <a href="#" id="modalEditBtn"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Project
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="delete-modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900" id="delete-modal-title">Delete Project</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Are you sure you want to delete this project? This action cannot be undone.
                    </p>
                    <p class="mt-2 text-sm font-medium text-gray-700" id="deleteProjectName"></p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button type="button" onclick="deleteProject()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Dummy Projects Data
    const dummyProjects = [
        {
            id: 1,
            project_name: "Swat Expressway Extension",
            implementing_agency: "Pakhtunkhwa Highways Authority",
            category: "Transportation",
            project_cost: 35000000000,
            government_funding: 20000000000,
            sponsor_equity: 15000000000,
            project_status: "Implementation",
            location: "Swat, Khyber Pakhtunkhwa",
            project_overview: "The Swat Expressway Extension project aims to extend the existing expressway by 80 kilometers, connecting major cities and reducing travel time significantly. This project will include the construction of 6 interchanges, 3 major bridges, and modern toll plazas. The expressway will feature state-of-the-art traffic management systems and safety features.",
            benefits: "Reduced travel time between Swat and Peshawar by 2 hours\nEnhanced trade and tourism opportunities\nImproved road safety with modern infrastructure\nCreation of 5,000+ jobs during construction\nBoost to local economy and real estate development",
            image_path: "https://images.pexels.com/photos/1117210/pexels-photo-1117210.jpeg",
            created_at: "2024-01-15 10:30:00",
            updated_at: "2024-03-20 14:45:00"
        },
        {
            id: 2,
            project_name: "Peshawar Healthcare City",
            implementing_agency: "Health Department KPK",
            category: "Healthcare",
            project_cost: 12500000000,
            government_funding: 8000000000,
            sponsor_equity: 4500000000,
            project_status: "Bidding",
            location: "Peshawar, Khyber Pakhtunkhwa",
            project_overview: "Peshawar Healthcare City is a state-of-the-art medical complex spanning 500 acres. The project includes a 1000-bed tertiary care hospital, medical college, nursing school, research center, and specialized clinics. The facility will provide advanced healthcare services including cardiology, oncology, neurology, and transplant services.",
            benefits: "Access to world-class healthcare facilities\nMedical education and training opportunities\nReduced need for medical tourism abroad\nCreation of 3,000+ healthcare jobs\nResearch and innovation in medical sciences",
            image_path: "https://images.pexels.com/photos/263402/pexels-photo-263402.jpeg",
            created_at: "2024-02-01 09:15:00",
            updated_at: "2024-03-10 11:30:00"
        },
        {
            id: 3,
            project_name: "Chitral Hydropower Project",
            implementing_agency: "Energy & Power Department KPK",
            category: "Energy",
            project_cost: 45000000000,
            government_funding: 25000000000,
            sponsor_equity: 20000000000,
            project_status: "Feasibility Study",
            location: "Chitral, Khyber Pakhtunkhwa",
            project_overview: "The Chitral Hydropower Project is a 300 MW run-of-river hydropower facility on the Chitral River. The project includes construction of a dam, powerhouse, transmission lines, and associated infrastructure. This renewable energy project will contribute significantly to the national grid and reduce dependence on fossil fuels.",
            benefits: "300 MW of clean, renewable energy generation\nReduced carbon emissions by 1.2 million tons annually\nFlood control and water management benefits\nElectrification of remote villages\nSustainable development of Chitral region",
            image_path: "https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg",
            created_at: "2024-01-20 11:00:00",
            updated_at: "2024-03-25 16:20:00"
        },
        {
            id: 4,
            project_name: "KPK Tourism Development Zone",
            implementing_agency: "Tourism Department KPK",
            category: "Tourism",
            project_cost: 8500000000,
            government_funding: 5000000000,
            sponsor_equity: 3500000000,
            project_status: "Planning",
            location: "Naran, Kaghan Valley",
            project_overview: "The KPK Tourism Development Zone is an integrated tourism infrastructure project aimed at developing world-class tourism facilities in the scenic Kaghan Valley. The project includes construction of eco-friendly resorts, adventure sports facilities, ski resorts, hiking trails, and cultural heritage centers.",
            benefits: "Boost to tourism industry and local economy\nCreation of 10,000+ direct and indirect jobs\nPreservation of cultural heritage\nSustainable tourism practices\nYear-round tourism opportunities",
            image_path: "https://images.pexels.com/photos/1365425/pexels-photo-1365425.jpeg",
            created_at: "2024-02-10 13:45:00",
            updated_at: "2024-03-15 10:10:00"
        },
        {
            id: 5,
            project_name: "D.I. Khan Smart City",
            implementing_agency: "Urban Development Authority",
            category: "Urban Development",
            project_cost: 65000000000,
            government_funding: 35000000000,
            sponsor_equity: 30000000000,
            project_status: "Completed",
            location: "Dera Ismail Khan, KPK",
            project_overview: "D.I. Khan Smart City is a modern urban development project featuring smart infrastructure, sustainable housing, commercial zones, and digital governance systems. The project spans 10,000 acres and includes smart grids, IoT-enabled services, green buildings, and integrated public transportation.",
            benefits: "Modern housing for 500,000+ residents\nSmart city infrastructure and services\nEconomic hub for southern KPK\nSustainable urban planning model\nImproved quality of life with modern amenities",
            image_path: "https://images.pexels.com/photos/323705/pexels-photo-323705.jpeg",
            created_at: "2023-06-15 08:30:00",
            updated_at: "2024-03-01 12:15:00"
        },
        {
            id: 6,
            project_name: "Abbottabad IT Park",
            implementing_agency: "Science & Technology Department",
            category: "Education",
            project_cost: 5500000000,
            government_funding: 3500000000,
            sponsor_equity: 2000000000,
            project_status: "Operational",
            location: "Abbottabad, Khyber Pakhtunkhwa",
            project_overview: "Abbottabad IT Park is a technology hub designed to foster innovation and entrepreneurship. The facility includes incubation centers, co-working spaces, research labs, and training facilities. The IT Park aims to create a vibrant ecosystem for tech startups and established IT companies.",
            benefits: "Creation of technology jobs and startups\nIT skills development and training\nAttraction of foreign investment in tech sector\nInnovation and research opportunities\nDigital transformation of regional economy",
            image_path: "https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg",
            created_at: "2023-08-20 10:00:00",
            updated_at: "2024-03-18 09:30:00"
        }
    ];

    // Current project ID for delete operation
    let currentDeleteId = null;

    // Render projects table
    function renderProjects() {
        const tbody = document.getElementById('projectsTableBody');
        const totalSpan = document.getElementById('totalProjects');
        
        totalSpan.textContent = `${dummyProjects.length} Total`;
        
        tbody.innerHTML = dummyProjects.map(project => {
            const statusColors = {
                'Planning': 'bg-blue-100 text-blue-800',
                'Feasibility Study': 'bg-purple-100 text-purple-800',
                'Bidding': 'bg-yellow-100 text-yellow-800',
                'Implementation': 'bg-orange-100 text-orange-800',
                'Completed': 'bg-green-100 text-green-800',
                'Operational': 'bg-emerald-100 text-emerald-800',
            };
            const statusColor = statusColors[project.project_status] || 'bg-gray-100 text-gray-800';
            
            return `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex-shrink-0 h-12 w-12">
                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200" 
                                 src="${project.image_path}" 
                                 alt="${project.project_name}"
                                 onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900" title="${project.project_name}">
                            ${project.project_name}
                        </div>
                        <div class="text-sm text-gray-500" title="${project.implementing_agency}">
                            <i class="fas fa-building mr-1 text-xs"></i>
                            ${project.implementing_agency.length > 40 ? project.implementing_agency.substring(0, 40) + '...' : project.implementing_agency}
                        </div>
                        ${project.location ? `
                            <div class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                ${project.location.length > 30 ? project.location.substring(0, 30) + '...' : project.location}
                            </div>
                        ` : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-tag mr-1 text-xs"></i>
                            ${project.category}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">
                            Rs. ${project.project_cost.toLocaleString('en-PK', {minimumFractionDigits: 2})}
                        </div>
                        ${project.government_funding ? `
                            <div class="text-xs text-gray-500">
                                Govt: Rs. ${project.government_funding.toLocaleString('en-PK', {minimumFractionDigits: 2})}
                            </div>
                        ` : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                            <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                            ${project.project_status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <button onclick="showProjectModal(${project.id})" 
                                    class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition-colors"
                                    title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                           <a href="/admin/projects/${project.id}/edit" 
   class="text-emerald-600 hover:text-emerald-900 p-1 rounded hover:bg-emerald-50 transition-colors"
   title="Edit Project">
    <i class="fas fa-edit"></i>
</a>
                            <button onclick="confirmDelete(${project.id})" 
                                    class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition-colors"
                                    title="Delete Project">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Show project details modal
    window.showProjectModal = function(projectId) {
        const project = dummyProjects.find(p => p.id === projectId);
        if (!project) return;
        
        const modal = document.getElementById('projectModal');
        const modalContent = document.getElementById('modalContent');
        const modalEditBtn = document.getElementById('modalEditBtn');
        
        modalEditBtn.href = '#';
        
        const statusColors = {
            'Planning': 'bg-blue-100 text-blue-800',
            'Feasibility Study': 'bg-purple-100 text-purple-800',
            'Bidding': 'bg-yellow-100 text-yellow-800',
            'Implementation': 'bg-orange-100 text-orange-800',
            'Completed': 'bg-green-100 text-green-800',
            'Operational': 'bg-emerald-100 text-emerald-800',
        };
        const statusColor = statusColors[project.project_status] || 'bg-gray-100 text-gray-800';
        
        let benefitsHtml = '';
        if (project.benefits) {
            const benefits = project.benefits.split('\n').filter(b => b.trim());
            if (benefits.length > 0) {
                benefitsHtml = '<ul class="list-disc list-inside space-y-1">';
                benefits.forEach(benefit => {
                    benefitsHtml += `<li class="text-gray-700">${benefit.trim()}</li>`;
                });
                benefitsHtml += '</ul>';
            } else {
                benefitsHtml = '<p class="text-gray-500 italic">No benefits listed</p>';
            }
        } else {
            benefitsHtml = '<p class="text-gray-500 italic">No benefits listed</p>';
        }
        
        modalContent.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <img src="${project.image_path}" 
                         alt="${project.project_name}"
                         class="w-full rounded-lg object-cover border border-gray-200"
                         onerror="this.src='https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg'">
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">${project.project_name}</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Category</p>
                                <p class="text-sm font-medium text-gray-900">${project.category || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Implementing Agency</p>
                                <p class="text-sm font-medium text-gray-900">${project.implementing_agency || 'N/A'}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Project Cost</p>
                                <p class="text-sm font-semibold text-gray-900">Rs. ${project.project_cost.toLocaleString('en-PK', {minimumFractionDigits: 2})}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Government Funding</p>
                                <p class="text-sm font-medium text-gray-900">Rs. ${(project.government_funding || 0).toLocaleString('en-PK', {minimumFractionDigits: 2})}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Sponsor Equity</p>
                                <p class="text-sm font-medium text-gray-900">Rs. ${(project.sponsor_equity || 0).toLocaleString('en-PK', {minimumFractionDigits: 2})}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Status</p>
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full ${statusColor}">
                                    ${project.project_status || 'N/A'}
                                </span>
                            </div>
                            ${project.location ? `
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">Location</p>
                                    <p class="text-sm font-medium text-gray-900"><i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>${project.location}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Project Overview</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 whitespace-pre-line">${project.project_overview || 'No overview provided'}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Project Benefits</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            ${benefitsHtml}
                        </div>
                    </div>
                    
                    <div class="text-xs text-gray-400 pt-2">
                        <p><i class="far fa-calendar-alt mr-1"></i>Created: ${new Date(project.created_at).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'})}</p>
                        ${project.updated_at ? `<p class="mt-1"><i class="far fa-clock mr-1"></i>Last Updated: ${new Date(project.updated_at).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'})}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };
    
    // Close modal
    window.closeModal = function() {
        const modal = document.getElementById('projectModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    };
    
    // Confirm delete
    window.confirmDelete = function(projectId) {
        const project = dummyProjects.find(p => p.id === projectId);
        if (!project) return;
        
        currentDeleteId = projectId;
        const deleteModal = document.getElementById('deleteModal');
        const deleteProjectName = document.getElementById('deleteProjectName');
        
        deleteProjectName.textContent = project.project_name;
        deleteModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };
    
    // Delete project
    window.deleteProject = function() {
        if (!currentDeleteId) return;
        
        const index = dummyProjects.findIndex(p => p.id === currentDeleteId);
        if (index > -1) {
            const projectName = dummyProjects[index].project_name;
            dummyProjects.splice(index, 1);
            
            // Re-render table
            renderProjects();
            
            // Show success message
            const successMsg = document.getElementById('successMessage');
            successMsg.querySelector('span').textContent = `Project "${projectName}" deleted successfully!`;
            successMsg.classList.remove('hidden');
            setTimeout(() => successMsg.classList.add('hidden'), 3000);
        }
        
        closeDeleteModal();
        currentDeleteId = null;
    };
    
    // Close delete modal
    window.closeDeleteModal = function() {
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    };
    
    // Close modals on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
    });
    
    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const projectModal = document.getElementById('projectModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === projectModal) {
            closeModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
    
    // Initialize table on page load
    document.addEventListener('DOMContentLoaded', function() {
        renderProjects();
    });
</script>
@endpush