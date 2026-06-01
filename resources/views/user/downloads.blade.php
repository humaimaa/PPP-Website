@extends('layouts.app')

@section('title', 'PPP Department KPK - Resource Center')

@section('content')
<<<<<<< HEAD

<!-- Page Header with Dynamic Text Based on Section -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                @if($section == 'legal-framework')
                    Legal Framework
                @elseif($section == 'pre-qualified-advisors')
                    Prequalified Transaction Advisors
                @elseif($section == 'policies-regulations')
                    Policies & Regulations
                @else
                    Knowledge Hub
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                @if($section == 'legal-framework')
                Access legal frameworks, acts, and regulations governing PPP projects in Khyber Pakhtunkhwa
                @elseif($section == 'pre-qualified-advisors')
                Browse our panel of prequalified transaction advisory firms for PPP projects
                @elseif($section == 'policies-regulations')
                Explore policies, guidelines, and regulatory documents for PPP implementation
                @else
                Access knowledge resources, case studies, and best practices for PPP projects
                @endif
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Resource Center Banner" class="w-full h-full object-cover">
</section>

<!-- Downloads Table Section -->
<section class="py-12 bg-background-light/90">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header with Search and Sort -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <!-- Removed the table heading div -->
            
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto ml-auto">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Search documents..." 
                           class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-accent-1 focus:ring-2 focus:ring-accent-1/20 w-full md:w-64 bg-background-white text-text-black">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-text-muted"></i>
                </div>
                
                <!-- Sort Dropdown -->
                <div class="relative">
                    <select id="sortSelect" class="pl-10 pr-8 py-2 rounded-lg border border-gray-300 focus:border-accent-1 focus:ring-2 focus:ring-accent-1/20 appearance-none bg-background-white text-text-black cursor-pointer">
                        <option value="date_desc">Latest First</option>
                        <option value="date_asc">Oldest First</option>
                        <option value="title_asc">Title (A-Z)</option>
                        <option value="title_desc">Title (Z-A)</option>
                    </select>
                    <i class="fas fa-sort-amount-down-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-text-muted"></i>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-text-muted pointer-events-none"></i>
                </div>

            </div>
        </div>
        
        <!-- Downloads Table -->
        <div class="bg-background-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary text-text-primary">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fas fa-file-alt mr-2"></i> Document Title
                            </th>
                            <th class="px-6 py-4 text-left font-semibold w-32">
                                <i class="fas fa-calendar-alt mr-2"></i> Date
                            </th>
                            <th class="px-6 py-4 text-center font-semibold w-28">
                                <i class="fas fa-download mr-2"></i> Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="downloadsTableBody">
                        @forelse($downloads as $download)
                        <tr class="border-b border-gray-200 hover:bg-background-light/30 transition-colors duration-200 download-row"
                            data-title="{{ strtolower($download->title) }}"
                            data-date="{{ $download->date ? $download->date->format('Y-m-d') : '' }}"
                            data-formatted-date="{{ $download->formatted_date }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @php
                                        $extension = pathinfo($download->document_path, PATHINFO_EXTENSION);
                                    @endphp
                                    @if($extension == 'pdf')
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'doc' || $extension == 'docx')
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-file-word text-blue-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'xls' || $extension == 'xlsx')
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-file-excel text-green-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'ppt' || $extension == 'pptx')
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-file-powerpoint text-orange-600 text-xl"></i>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                            <i class="fas fa-file text-gray-600 text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-text-black">{{ $download->title }}</h3>
                                        <span class="text-xs text-text-muted uppercase">{{ $extension }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-text-muted">
                                <i class="far fa-calendar-alt mr-1 text-accent-1"></i>
                                {{ $download->formatted_date }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($download->document_url)
                                    @if($extension == 'pdf')
                                    <a href="{{ $download->document_url }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-text-primary transition-all duration-300 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    @else
                                    <a href="{{ $download->document_url }}" download 
                                       class="inline-flex items-center px-3 py-2 bg-accent-1/10 text-accent-1 rounded-lg hover:bg-accent-1 hover:text-text-primary transition-all duration-300 text-sm font-medium">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                    @endif
                                @else
                                    <span class="text-text-muted text-sm">File missing</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-text-muted text-lg">No documents found in this category.</p>
                                    <p class="text-text-secondary text-sm mt-1">Please check back later for new resources.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($downloads->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-background-light/30">
                {{ $downloads->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        const tableBody = document.getElementById('downloadsTableBody');
        const resultsCountSpan = document.getElementById('resultsCount');
        
        let currentRows = [];
        
        // Initialize rows data
        function initRows() {
            const rows = document.querySelectorAll('.download-row');
            currentRows = Array.from(rows).map(row => ({
                element: row,
                title: row.getAttribute('data-title'),
                date: row.getAttribute('data-date'),
                formattedDate: row.getAttribute('data-formatted-date')
            }));
            updateResultsCount();
        }
        
        // Update results count
        function updateResultsCount() {
            const visibleRows = currentRows.filter(row => row.element.style.display !== 'none');
            resultsCountSpan.textContent = visibleRows.length;
        }
        
        // Filter rows based on search input
        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            
            currentRows.forEach(row => {
                if (searchTerm === '' || row.title.includes(searchTerm)) {
                    row.element.style.display = '';
                } else {
                    row.element.style.display = 'none';
                }
            });
            
            sortRows(); // Re-sort after filtering
            updateResultsCount();
        }
        
        // Sort rows
        function sortRows() {
            const sortValue = sortSelect.value;
            const visibleRows = currentRows.filter(row => row.element.style.display !== 'none');
            
            visibleRows.sort((a, b) => {
                switch(sortValue) {
                    case 'date_desc':
                        return new Date(b.date) - new Date(a.date);
                    case 'date_asc':
                        return new Date(a.date) - new Date(b.date);
                    case 'title_asc':
                        return a.title.localeCompare(b.title);
                    case 'title_desc':
                        return b.title.localeCompare(a.title);
                    default:
                        return 0;
                }
            });
            
            // Reorder DOM elements
            visibleRows.forEach(row => {
                tableBody.appendChild(row.element);
            });
        }
        
        // Event listeners
        searchInput.addEventListener('input', filterRows);
        sortSelect.addEventListener('change', sortRows);
        
        // Initialize
        initRows();
    });
</script>
@endpush
=======

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">Resource Center</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                Access legal frameworks, policies, guidelines, and knowledge resources for PPP projects in Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Resource Center Banner" class="w-full h-full object-cover">
</section>

<!-- Main Content Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search and Sorting Controls -->
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <!-- Search Bar -->
            <div class="relative flex-1 max-w-md">
                <input type="text" id="searchInput" placeholder="Search documents..." 
                    class="w-full px-6 py-3 pl-12 border-2 border-text-green/10 rounded-lg focus:outline-none focus:border-accent-1 transition-colors duration-300 text-text-muted bg-background-white">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-text-green/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <button onclick="clearSearch()" id="clearSearchBtn" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-accent-1 hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Sorting Options -->
            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-text-green">Sort by:</span>
                <select id="sortBy" class="px-4 py-3 border-2 border-text-green/10 rounded-lg focus:outline-none focus:border-accent-1 transition-colors duration-300 text-sm bg-background-white text-text-muted">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                </select>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="overflow-x-auto bg-background-white rounded-lg shadow-lg border border-background-light">
            <table class="min-w-full divide-y divide-background-light">
                <thead class="bg-gradient-to-r from-background-primary to-background-secondary">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-text-primary uppercase tracking-wider">
                            Document Title
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-text-primary uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-text-primary uppercase tracking-wider">
                            Upload Date
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-text-primary uppercase tracking-wider">
                            Document
                        </th>
                    </tr>
                </thead>
                <tbody id="documentsTableBody" class="bg-background-white divide-y divide-background-light">
                    @forelse($downloads as $index => $doc)
                    <tr class="doc-row hover:bg-background-light/30 transition-colors duration-200" 
                        data-title="{{ strtolower($doc->title) }}" 
                        data-category="{{ strtolower($doc->category) }}"
                        data-date="{{ $doc->date->timestamp }}"
                        data-name="{{ strtolower($doc->title) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-accent-1/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                                        <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-text-green">{{ $doc->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-1/10 text-accent-1">
                                {{ $doc->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-muted">
                            {{ $doc->date->format('F d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ $doc->document_path ? asset('storage/' . $doc->document_path) : '#' }}" 
                               target="_blank" 
                               class="inline-flex items-center justify-center text-red-600 hover:text-red-700 transition-all duration-300 group"
                               title="Download PDF">
                                <!-- PDF Icon -->
                                <svg class="w-8 h-8 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 6h-8l-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-8 12v-4h-4v-2h4V8l4 5-4 5z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-text-green mb-2">No Documents Found</h3>
                            <p class="text-text-muted">No documents available at the moment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Empty State for Search -->
        <div id="emptyState" class="hidden text-center py-12">
            <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-bold text-text-green mb-2">No Matching Documents</h3>
            <p class="text-text-muted mb-6">Try adjusting your search criteria.</p>
            <button onclick="clearSearch()" class="px-6 py-3 bg-accent-1 text-text-primary font-semibold rounded-lg hover:bg-accent-2 transition-colors duration-300">
                Clear Search
            </button>
        </div>

        <!-- Pagination -->
        @if(isset($downloads) && method_exists($downloads, 'links') && $downloads->count() > 0)
        <div class="mt-8">
            {{ $downloads->links() }}
        </div>
        @endif
    </div>
</section>

<style>
    /* Smooth transitions */
    .doc-row {
        transition: all 0.2s ease;
    }
    
    .hidden {
        display: none;
    }
</style>

<script>
    // DOM Elements
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortBy');
    const tbody = document.getElementById('documentsTableBody');
    const emptyState = document.getElementById('emptyState');
    const clearSearchBtn = document.getElementById('clearSearchBtn');

    // Get all rows
    function getAllRows() {
        return Array.from(document.querySelectorAll('.doc-row'));
    }

    // Filter rows based on search
    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const rows = getAllRows();
        let visibleCount = 0;

        rows.forEach(row => {
            const title = row.getAttribute('data-title') || '';
            const category = row.getAttribute('data-category') || '';
            
            if (searchTerm === '' || title.includes(searchTerm) || category.includes(searchTerm)) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });

        // Show/hide clear button
        if (clearSearchBtn) {
            if (searchTerm.length > 0) {
                clearSearchBtn.classList.remove('hidden');
            } else {
                clearSearchBtn.classList.add('hidden');
            }
        }

        // Update empty state
        updateEmptyState(visibleCount);
        
        // Re-sort after filtering
        sortRows();
    }

    // Update empty state visibility
    function updateEmptyState(visibleCount) {
        const totalRows = getAllRows().length;
        const tableContainer = document.querySelector('.overflow-x-auto');
        
        if (totalRows > 0 && visibleCount === 0) {
            emptyState.classList.remove('hidden');
            if (tableContainer) tableContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            if (tableContainer) tableContainer.classList.remove('hidden');
        }
    }

    // Sort rows
    function sortRows() {
        const sortValue = sortSelect.value;
        const rows = getAllRows().filter(row => !row.classList.contains('hidden'));
        
        rows.sort((a, b) => {
            switch(sortValue) {
                case 'newest':
                    return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
                case 'oldest':
                    return parseInt(a.getAttribute('data-date')) - parseInt(b.getAttribute('data-date'));
                case 'name-asc':
                    return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
                case 'name-desc':
                    return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
                default:
                    return 0;
            }
        });
        
        // Reorder DOM
        rows.forEach(row => tbody.appendChild(row));
    }

    // Clear search
    function clearSearch() {
        if (searchInput) {
            searchInput.value = '';
            filterRows();
            searchInput.focus();
        }
    }

    // Event Listeners
    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
        searchInput.addEventListener('keyup', filterRows);
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', sortRows);
    }

    // Initialize
    if (typeof filterRows === 'function') {
        filterRows();
    }
</script>
>>>>>>> b32403fc1fe7700c15202303dd81552e1a18f5cd

@endsection