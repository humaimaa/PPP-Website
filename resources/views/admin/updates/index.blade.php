{{-- resources/views/admin/updates/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Updates - PPP Department KPK')
@section('header-title', 'Updates Management')

@section('content')
<div class="max-w-full mx-auto">
    {{-- Success Message --}}
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
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                All Updates
            </h2>
            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="totalUpdates">
                8 Total
            </span>
        </div>
        <a href="{{ route('admin.updates.add') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Add Update
        </a>
    </div>

    {{-- Filter Tabs --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <button onclick="filterUpdates('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium bg-emerald-600 text-white" data-filter="all">
            <i class="fas fa-list mr-1"></i> All
        </button>
        <button onclick="filterUpdates('Update')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="Update">
            <i class="fas fa-sync-alt mr-1"></i> Updates
        </button>
        <button onclick="filterUpdates('Event')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="Event">
            <i class="fas fa-calendar-alt mr-1"></i> Events
        </button>
        <button onclick="filterUpdates('Announcement')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="Announcement">
            <i class="fas fa-bullhorn mr-1"></i> Announcements
        </button>
        <button onclick="filterUpdates('Press Release')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="Press Release">
            <i class="fas fa-newspaper mr-1"></i> Press Releases
        </button>
        <button onclick="filterUpdates('Notice')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="Notice">
            <i class="fas fa-bell mr-1"></i> Notices
        </button>
        <button onclick="filterFeatured()" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
            <i class="fas fa-star mr-1 text-yellow-500"></i> Featured
        </button>
    </div>

    {{-- Updates Table Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title & Content
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Featured
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            PDF
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="updatesTableBody">
                    {{-- Dummy data will be inserted here via JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Showing 
                    <span class="font-medium" id="showingStart">1</span> 
                    to 
                    <span class="font-medium" id="showingEnd">8</span> 
                    of 
                    <span class="font-medium" id="totalRecords">8</span> 
                    results
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-emerald-600 text-sm font-medium text-white">1</a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Update Details Modal --}}
<div id="updateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeUpdateModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden transform transition-all">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                    <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                    Update Details
                </h3>
                <button type="button" onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="px-6 py-4 overflow-y-auto max-h-[calc(90vh-130px)]">
                <div id="modalContent"></div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
                <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                    Close
                </button>
                <a href="#" id="modalEditBtn" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" onclick="closeDeleteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Delete Update</h3>
                    <p class="mt-2 text-sm text-gray-500">Are you sure you want to delete this item? This action cannot be undone.</p>
                    <p class="mt-2 text-sm font-medium text-gray-700" id="deleteItemTitle"></p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="button" onclick="deleteUpdate()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
    // Dummy Updates Data
    const dummyUpdates = [
        {
            id: 1,
            title: "PPP Department Launches New Infrastructure Initiative",
            type: "Update",
            content: "The PPP Department KPK has announced a groundbreaking infrastructure initiative aimed at developing sustainable public-private partnerships across the province. This initiative will focus on transportation, healthcare, and education sectors.",
            event_date: null,
            created_at: "2024-03-15 09:30:00",
            is_featured: true,
            pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
        },
        {
            id: 2,
            title: "Investor Conference 2024 - Save the Date",
            type: "Event",
            content: "Join us for the annual PPP Investor Conference 2024, bringing together government officials, private investors, and industry experts to explore investment opportunities in Khyber Pakhtunkhwa.",
            event_date: "2024-05-20",
            created_at: "2024-03-10 14:15:00",
            is_featured: true,
            pdf_path: null
        },
        {
            id: 3,
            title: "Swat Expressway Project Progress",
            type: "Update",
            content: "Construction of the Swat Expressway Extension has reached 65% completion. The project is on track for completion by December 2024, with all major bridges and interchanges now under construction.",
            event_date: null,
            created_at: "2024-03-05 11:00:00",
            is_featured: false,
            pdf_path: null
        },
        {
            id: 4,
            title: "New Tender Announcement: Healthcare Facilities",
            type: "Announcement",
            content: "The PPP Department invites sealed bids for the development of modern healthcare facilities in Peshawar, Mardan, and Swat districts. Bid submission deadline is April 30, 2024.",
            event_date: null,
            created_at: "2024-02-28 16:45:00",
            is_featured: false,
            pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
        },
        {
            id: 5,
            title: "Capacity Building Workshop for Government Officials",
            type: "Event",
            content: "A three-day capacity building workshop on PPP project management will be held for government officials from various departments. Expert trainers from international organizations will conduct the sessions.",
            event_date: "2024-04-10",
            created_at: "2024-02-20 10:30:00",
            is_featured: false,
            pdf_path: null
        },
        {
            id: 6,
            title: "Quarterly Performance Report Released",
            type: "Press Release",
            content: "The PPP Department has released its quarterly performance report showing significant progress across all ongoing projects. The report highlights key achievements and future milestones.",
            event_date: null,
            created_at: "2024-02-15 13:20:00",
            is_featured: false,
            pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
        },
        {
            id: 7,
            title: "D.I. Khan Smart City Project Completion",
            type: "Update",
            content: "We are pleased to announce the successful completion of the D.I. Khan Smart City project. The project has delivered modern infrastructure and smart services to over 500,000 residents.",
            event_date: null,
            created_at: "2024-02-01 08:00:00",
            is_featured: true,
            pdf_path: null
        },
        {
            id: 8,
            title: "Public Consultation on New PPP Policy",
            type: "Announcement",
            content: "The PPP Department invites stakeholders and the general public to participate in consultations regarding the proposed new PPP Policy framework. Sessions will be held across all major cities.",
            event_date: null,
            created_at: "2024-01-25 15:10:00",
            is_featured: false,
            pdf_path: "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf"
        }
    ];

    let currentDeleteId = null;
    let currentFilter = 'all';
    let filteredUpdates = [...dummyUpdates];

    // Render updates table
    function renderUpdates() {
        const tbody = document.getElementById('updatesTableBody');
        const totalSpan = document.getElementById('totalUpdates');
        const showingStart = document.getElementById('showingStart');
        const showingEnd = document.getElementById('showingEnd');
        const totalRecords = document.getElementById('totalRecords');
        
        totalSpan.textContent = `${filteredUpdates.length} Total`;
        showingStart.textContent = filteredUpdates.length > 0 ? 1 : 0;
        showingEnd.textContent = filteredUpdates.length;
        totalRecords.textContent = filteredUpdates.length;
        
        if (filteredUpdates.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-bullhorn text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500 text-lg mb-2">No updates found</p>
                            <p class="text-gray-400 text-sm">Try changing your filter or add new content</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = filteredUpdates.map(item => {
            const typeColors = {
                'Update': 'bg-green-100 text-green-800',
                'Event': 'bg-purple-100 text-purple-800',
                'Announcement': 'bg-yellow-100 text-yellow-800',
                'Press Release': 'bg-red-100 text-red-800',
                'Notice': 'bg-orange-100 text-orange-800',
                'Circular': 'bg-blue-100 text-blue-800'
            };
            const typeColor = typeColors[item.type] || 'bg-gray-100 text-gray-800';
            
            const displayDate = item.event_date 
                ? new Date(item.event_date).toLocaleDateString('en-PK', {year: 'numeric', month: 'short', day: 'numeric'})
                : new Date(item.created_at).toLocaleDateString('en-PK', {year: 'numeric', month: 'short', day: 'numeric'});
            
            const dateLabel = item.event_date ? 'Event Date' : 'Published';
            
            return `
                <tr class="hover:bg-gray-50 transition-colors" data-type="${item.type}" data-featured="${item.is_featured}">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">
                            ${item.title}
                            ${item.is_featured ? '<i class="fas fa-star text-yellow-500 ml-2 text-xs"></i>' : ''}
                        </div>
                        <div class="text-sm text-gray-500 mt-1 line-clamp-2">
                            ${item.content.length > 100 ? item.content.substring(0, 100) + '...' : item.content}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${typeColor}">
                            <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                            ${item.type}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                            ${displayDate}
                        </div>
                        <div class="text-xs text-gray-400">${dateLabel}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${item.is_featured ? `
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        ` : `
                            <span class="text-gray-400 text-sm">—</span>
                        `}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${item.pdf_path ? `
                            <a href="${item.pdf_path}" target="_blank" 
                               class="text-emerald-600 hover:text-emerald-800 p-2 rounded hover:bg-emerald-50 inline-flex items-center">
                                <i class="fas fa-file-pdf mr-1"></i>
                                <span class="text-sm">View</span>
                            </a>
                        ` : `
                            <span class="text-gray-400 text-sm">—</span>
                        `}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-1">
                            <button onclick="viewUpdate(${item.id})" 
                                    class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50"
                                    title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="/admin/updates/${item.id}/edit" 
                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(${item.id})" 
                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Filter functions
    function filterUpdates(type) {
        currentFilter = type;
        
        document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
            if (btn.dataset.filter === type) {
                btn.classList.remove('bg-gray-100', 'text-gray-700');
                btn.classList.add('bg-emerald-600', 'text-white');
            } else {
                btn.classList.remove('bg-emerald-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
        
        if (type === 'all') {
            filteredUpdates = [...dummyUpdates];
        } else {
            filteredUpdates = dummyUpdates.filter(item => item.type === type);
        }
        
        renderUpdates();
    }

    function filterFeatured() {
        filteredUpdates = dummyUpdates.filter(item => item.is_featured);
        currentFilter = 'featured';
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-emerald-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        renderUpdates();
    }

    // View update details
    window.viewUpdate = function(id) {
        const item = dummyUpdates.find(u => u.id === id);
        if (!item) return;
        
        const modal = document.getElementById('updateModal');
        const modalContent = document.getElementById('modalContent');
        const modalEditBtn = document.getElementById('modalEditBtn');
        
        modalEditBtn.href = `/admin/updates/${id}/edit`;
        
        const typeColors = {
            'Update': 'bg-green-100 text-green-800',
            'Event': 'bg-purple-100 text-purple-800',
            'Announcement': 'bg-yellow-100 text-yellow-800',
            'Press Release': 'bg-red-100 text-red-800',
            'Notice': 'bg-orange-100 text-orange-800',
            'Circular': 'bg-blue-100 text-blue-800'
        };
        const typeColor = typeColors[item.type] || 'bg-gray-100 text-gray-800';
        
        modalContent.innerHTML = `
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full ${typeColor}">
                            ${item.type}
                        </span>
                        ${item.is_featured ? '<span class="ml-2 text-yellow-500"><i class="fas fa-star"></i> Featured</span>' : ''}
                    </div>
                </div>
                
                <h4 class="text-xl font-bold text-gray-900">${item.title}</h4>
                
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span><i class="far fa-calendar-alt mr-1"></i> ${item.event_date ? 'Event: ' + new Date(item.event_date).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'}) : 'Published: ' + new Date(item.created_at).toLocaleDateString('en-PK', {year: 'numeric', month: 'long', day: 'numeric'})}</span>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-line">${item.content}</p>
                </div>
                
                ${item.pdf_path ? `
                    <div class="pt-4 border-t border-gray-200">
                        <a href="${item.pdf_path}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Download PDF Attachment
                        </a>
                    </div>
                ` : ''}
            </div>
        `;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeUpdateModal = function() {
        document.getElementById('updateModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    // Delete functions
    window.confirmDelete = function(id) {
        const item = dummyUpdates.find(u => u.id === id);
        if (!item) return;
        
        currentDeleteId = id;
        document.getElementById('deleteItemTitle').textContent = item.title;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.deleteUpdate = function() {
        if (!currentDeleteId) return;
        
        const index = dummyUpdates.findIndex(u => u.id === currentDeleteId);
        if (index > -1) {
            const itemTitle = dummyUpdates[index].title;
            dummyUpdates.splice(index, 1);
            
            if (currentFilter === 'all') {
                filteredUpdates = [...dummyUpdates];
            } else if (currentFilter === 'featured') {
                filteredUpdates = dummyUpdates.filter(item => item.is_featured);
            } else {
                filteredUpdates = dummyUpdates.filter(item => item.type === currentFilter);
            }
            
            renderUpdates();
            
            const successMsg = document.getElementById('successMessage');
            successMsg.querySelector('span').textContent = `"${itemTitle}" deleted successfully!`;
            successMsg.classList.remove('hidden');
            setTimeout(() => successMsg.classList.add('hidden'), 3000);
        }
        
        closeDeleteModal();
        currentDeleteId = null;
    };

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    };

    // Keyboard events
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeUpdateModal();
            closeDeleteModal();
        }
    });

    document.addEventListener('click', function(event) {
        const updateModal = document.getElementById('updateModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === updateModal) closeUpdateModal();
        if (event.target === deleteModal) closeDeleteModal();
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderUpdates();
    });

    // Make functions globally available
    window.filterUpdates = filterUpdates;
    window.filterFeatured = filterFeatured;
</script>
@endpush