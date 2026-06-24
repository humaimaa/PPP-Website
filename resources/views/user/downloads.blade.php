@extends('layouts.app')

@section('title', 'PPP Unit KP - Resource Center')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                @if($section == 'legal-framework')
                    Legal Framework
                @elseif($section == 'pre-qualified-advisors')
                    Prequalified Transaction Advisors
                @elseif($section == 'policies-regulations')
                    Policies, Regulations and Guidelines
                @else
                    Knowledge Hub
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            
        </div>
    </div>
    <img src="{{ asset('images/resourse-center.jpg') }}" alt="Resource Center Banner" class="w-full h-full object-cover">
</section>

<!-- Downloads Table Section -->
<section class="py-12 bg-background-light/90">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header with Search and Sort -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <p class="text-text-muted text-sm">
                    Showing <span id="resultsCount">{{ $downloads->total() }}</span> documents
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text"
                           id="searchInput"
                           placeholder="Search documents..."
                           class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 w-full md:w-64 bg-white text-text-black">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
                </div>

                <!-- Sort Dropdown -->
                <div class="relative">
                    <select id="sortSelect" class="pl-10 pr-8 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 appearance-none bg-white text-text-black cursor-pointer">
                        <option value="date_desc">Latest First</option>
                        <option value="date_asc">Oldest First</option>
                        <option value="title_asc">Title (A-Z)</option>
                        <option value="title_desc">Title (Z-A)</option>
                    </select>
                    <i class="fas fa-sort-amount-down-alt absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"></i>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-text-muted pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Downloads Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">
                                <i class="fas fa-file-alt mr-2"></i> Document Title
                            </th>
                            <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider w-36">
                                <i class="fas fa-calendar-alt mr-2"></i> Date
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-sm uppercase tracking-wider w-28">
                                <i class="fas fa-download mr-2"></i> Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="downloadsTableBody">
                        @forelse($downloads as $index => $download)
                        @php
                            $extension = pathinfo($download->document_path, PATHINFO_EXTENSION);
                            $rowBg = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                        @endphp
                        <tr class="border-b border-gray-200 hover:bg-amber-50/40 transition-colors duration-150 download-row {{ $rowBg }}"
                            data-title="{{ strtolower($download->title) }}"
                            data-date="{{ $download->date ? $download->date->format('Y-m-d') : '' }}"
                            data-formatted-date="{{ $download->formatted_date }}">

                            <!-- Document Title -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($extension == 'pdf')
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'doc' || $extension == 'docx')
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-file-word text-blue-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'xls' || $extension == 'xlsx')
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-file-excel text-green-600 text-xl"></i>
                                        </div>
                                    @elseif($extension == 'ppt' || $extension == 'pptx')
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-file-powerpoint text-orange-600 text-xl"></i>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-file text-gray-600 text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-text-black">{{formatTitle( Str::title($download->title) ?? $download->title )}}</h3>
                                        <span class="text-xs text-text-muted uppercase">{{ $extension }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 text-text-muted text-sm">
                                <i class="far fa-calendar-alt mr-1 text-accent-1"></i>
                                {{ $download->formatted_date }}
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 text-center">
                                @if($download->document_url)
                                    @if($extension == 'pdf')
                                        <a href="{{ $download->document_url }}" target="_blank"
                                           class="inline-flex items-center px-3 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all duration-300 text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    @else
                                        <a href="{{ $download->document_url }}" download
                                           class="inline-flex items-center px-3 py-2 bg-accent-1/10 text-accent-1 rounded-lg hover:bg-accent-1 hover:text-white transition-all duration-300 text-sm font-medium">
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
                            <td colspan="3" class="px-6 py-16 text-center">
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
            <div class="px-6 py-4 border-t border-gray-200 bg-background-light/60">
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

        function updateResultsCount() {
            const visibleRows = currentRows.filter(row => row.element.style.display !== 'none');
            if (resultsCountSpan) {
                resultsCountSpan.textContent = visibleRows.length;
            }
        }

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            currentRows.forEach(row => {
                row.element.style.display = (searchTerm === '' || row.title.includes(searchTerm)) ? '' : 'none';
            });
            sortRows();
            updateResultsCount();
        }

        function sortRows() {
            const sortValue = sortSelect.value;
            const visibleRows = currentRows.filter(row => row.element.style.display !== 'none');

            visibleRows.sort((a, b) => {
                switch(sortValue) {
                    case 'date_desc': return new Date(b.date) - new Date(a.date);
                    case 'date_asc':  return new Date(a.date) - new Date(b.date);
                    case 'title_asc': return a.title.localeCompare(b.title);
                    case 'title_desc':return b.title.localeCompare(a.title);
                    default: return 0;
                }
            });

            visibleRows.forEach(row => tableBody.appendChild(row.element));
        }

        if (searchInput) searchInput.addEventListener('input', filterRows);
        if (sortSelect)  sortSelect.addEventListener('change', sortRows);

        initRows();
    });
</script>
@endpush

@endsection