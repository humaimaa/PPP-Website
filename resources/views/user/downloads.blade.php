@extends('layouts.app')

@section('title', 'Downloads - PPP Department KPK')

@section('content')
    <!-- Hero Section -->
   <section class="relative h-[40vh] md:h-[50vh] overflow-hidden" 
        style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&h=600&fit=crop'); background-size: cover; background-position: center;">
       
     <!-- Dark Overlay for Text Readability -->
        <div class="absolute inset-0 bg-linear-to-b from-black/50 via-black/40 to-black/60"></div>
    <!-- Geometric Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 opacity-10" style="background-image: radial-gradient(circle, #c9a84c 1px, transparent 1px); background-size: 40px 40px;"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 opacity-10" style="background-image: radial-gradient(circle, #c9a84c 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="absolute inset-0 bg-linear-to-b from-transparent via-transparent to-[#0D2818]/20"></div>

        <div class="relative z-10 h-full flex flex-col items-center justify-center px-4 text-center animate-fade-in">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 animate-slide-up" style="animation-delay: 0.1s;">Downloads</h1>
            <p class="text-lg md:text-xl text-[#DAD7CD] mb-6 max-w-2xl animate-slide-up" style="animation-delay: 0.2s;">Access important documents, reports, agreements, and guidelines</p>

            <!-- Breadcrumb -->
           
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-10  bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filter Controls -->
            <div class="mb-12 space-y-6">
                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search documents..." 
                        class="w-full px-6 py-4 pl-12 border-2 border-[#0D2818]/10 rounded-lg focus:outline-none focus:border-[#c9a84c] transition-colors duration-300 text-gray-700"
                        style="box-shadow: 0 4px 6px rgba(13, 40, 24, 0.05);">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#0D2818]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap gap-3 items-center justify-center md:justify-start">
                    <span class="text-sm font-semibold text-[#0D2818] mr-2">Filter by:</span>
                    <button class="filter-btn active px-4 py-2 border-2 border-[#c9a84c] text-[#c9a84c] font-medium rounded-lg hover:bg-[#c9a84c] hover:text-white transition-all duration-300 text-sm" data-filter="all">
                        All Documents
                    </button>
                    <button class="filter-btn px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] font-medium rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-all duration-300 text-sm" data-filter="reports">
                        Reports
                    </button>
                    <button class="filter-btn px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] font-medium rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-all duration-300 text-sm" data-filter="agreements">
                        Agreements
                    </button>
                    <button class="filter-btn px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] font-medium rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-all duration-300 text-sm" data-filter="tenders">
                        Tenders
                    </button>
                    <button class="filter-btn px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] font-medium rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-all duration-300 text-sm" data-filter="guidelines">
                        Guidelines
                    </button>
                </div>

                <!-- View Toggle & Sorting -->
                <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-medium text-[#0D2818]">View:</span>
                        <button id="gridViewBtn" class="view-toggle active p-2 border-2 border-[#c9a84c] text-[#c9a84c] rounded-lg hover:bg-[#c9a84c] hover:text-white transition-all duration-300" title="Grid View">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm10 0h8v8h-8v-8z"></path>
                            </svg>
                        </button>
                        <button id="listViewBtn" class="view-toggle p-2 border-2 border-[#0D2818]/20 text-[#0D2818] rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-all duration-300" title="List View">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-3">
                        <label for="sortBy" class="text-sm font-medium text-[#0D2818]">Sort by:</label>
                        <select id="sortBy" class="px-4 py-2 border-2 border-[#0D2818]/10 rounded-lg focus:outline-none focus:border-[#c9a84c] transition-colors duration-300 text-sm">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="size-asc">Size (Small-Large)</option>
                            <option value="size-desc">Size (Large-Small)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Documents Grid/List -->
            <div id="documentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Grid View Cards (will be populated dynamically) -->
                @forelse($documents ?? [] as $index => $doc)
                    <div class="doc-card grid-view group" data-category="{{ $doc['category'] ?? 'reports' }}" data-search="{{ strtolower($doc['title'] ?? '') }}" data-date="{{ strtotime($doc['date'] ?? now()) }}" data-size="{{ $doc['size'] ?? 0 }}" style="animation-delay: {{ $index * 0.1 }}s;">
                        <!-- Glass Morphism Card -->
                        <div class="bg-white rounded-2xl overflow-hidden border-2 border-white/30 backdrop-blur-xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col hover:border-[#c9a84c] hover:-translate-y-2">
                            <!-- Card Header with Icon -->
                            <div class="bg-linear-to-r from-[#0D2818] to-[#1a3d2e] p-6 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-[#c9a84c]/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-[#c9a84c]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                                            <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[#c9a84c] font-semibold text-sm">PDF</span>
                                </div>
                                <span class="text-[#DAD7CD] text-xs">v{{ $doc['version'] ?? '1.0' }}</span>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-1 flex flex-col">
                                <!-- Title -->
                                <h3 class="text-lg font-bold text-[#0D2818] mb-3 line-clamp-2 group-hover:text-[#c9a84c] transition-colors duration-300">
                                    {{ $doc['title'] ?? 'Document Title' }}
                                </h3>

                                <!-- Category Badge -->
                                <div class="mb-3 inline-flex">
                                    <span class="px-3 py-1 bg-[#0A612B]/10 text-[#0A612B] text-xs font-semibold rounded-full uppercase tracking-wide">
                                        {{ $doc['category'] ?? 'Reports' }}
                                    </span>
                                </div>

                                <!-- Document Info -->
                                <div class="space-y-2 text-sm text-gray-600 mb-4 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-[#0D2818]/40" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54c-.37-.46-.98-.46-1.35 0-.37.46-.37 1.2 0 1.66l2 2.45c.37.46.98.46 1.35 0l4.1-5.07c.37-.46.37-1.2 0-1.66-.37-.46-.98-.46-1.35 0z"></path>
                                        </svg>
                                        <span class="text-[#0D2818]">File Size: <strong>{{ $doc['size'] ?? '2.4' }} MB</strong></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-[#0D2818]/40" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"></path>
                                        </svg>
                                        <span class="text-[#0D2818]">Uploaded: <strong>{{ date('M d, Y', strtotime($doc['date'] ?? now())) }}</strong></span>
                                    </div>
                                </div>

                                <!-- Description (truncated) -->
                                <p class="text-sm text-gray-600 line-clamp-2 mb-6">
                                    {{ $doc['description'] ?? 'Document description goes here.' }}
                                </p>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 mt-auto">
                                    <button class="flex-1 btn-preview bg-white border-2 border-[#0D2818] text-[#0D2818] font-semibold py-2 px-4 rounded-lg hover:bg-[#0D2818] hover:text-white transition-all duration-300 text-sm uppercase tracking-wide" data-doc-url="{{ $doc['file_url'] ?? '#' }}">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Preview
                                    </button>
                                    <button class="flex-1 btn-download bg-[#c9a84c] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#b39339] transition-all duration-300 text-sm uppercase tracking-wide relative overflow-hidden group/btn" data-doc-id="{{ $doc['id'] ?? $index }}" data-doc-name="{{ $doc['title'] ?? 'document' }}">
                                        <span class="relative z-10 flex items-center justify-center">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19v-7m0 0V5m0 7H5m7 0h7"></path>
                                            </svg>
                                            Download
                                        </span>
                                        <!-- Shimmer Effect -->
                                        <div class="absolute inset-0 bg-linear-to-r from-transparent via-white/30 to-transparent transform -translate-x-full group-hover/btn:translate-x-full transition-transform duration-500"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Sample Documents (Demo Data) -->
                    @php
                        $sampleDocs = [
                            [
                                'id' => 1,
                                'title' => 'PPP Department Annual Report 2024',
                                'category' => 'reports',
                                'size' => '4.2',
                                'date' => '2024-01-15',
                                'description' => 'Comprehensive annual report detailing all PPP initiatives, project completions, and strategic outcomes for the year.',
                                'file_url' => '#',
                                'version' => '1.0'
                            ],
                            [
                                'id' => 2,
                                'title' => 'Public-Private Partnership Agreement Template',
                                'category' => 'agreements',
                                'size' => '2.8',
                                'date' => '2023-11-20',
                                'description' => 'Standard agreement template for PPP projects with comprehensive terms and conditions.',
                                'file_url' => '#',
                                'version' => '2.1'
                            ],
                            [
                                'id' => 3,
                                'title' => 'Infrastructure Development Tender 2024-Q2',
                                'category' => 'tenders',
                                'size' => '3.5',
                                'date' => '2024-04-01',
                                'description' => 'Detailed tender documents for Q2 2024 infrastructure projects across multiple sectors.',
                                'file_url' => '#',
                                'version' => '1.0'
                            ],
                            [
                                'id' => 4,
                                'title' => 'PPP Implementation Guidelines & Best Practices',
                                'category' => 'guidelines',
                                'size' => '5.1',
                                'date' => '2023-09-30',
                                'description' => 'Comprehensive guidelines for implementing PPP projects with best practices and compliance requirements.',
                                'file_url' => '#',
                                'version' => '3.0'
                            ],
                            [
                                'id' => 5,
                                'title' => 'Healthcare Sector PPP Framework Report',
                                'category' => 'reports',
                                'size' => '3.8',
                                'date' => '2024-02-10',
                                'description' => 'In-depth analysis of healthcare sector PPP opportunities and implementation strategies.',
                                'file_url' => '#',
                                'version' => '1.5'
                            ],
                            [
                                'id' => 6,
                                'title' => 'Transportation Projects Agreement 2024',
                                'category' => 'agreements',
                                'size' => '2.3',
                                'date' => '2024-03-05',
                                'description' => 'Partnership agreements for transportation infrastructure projects including roads and transit systems.',
                                'file_url' => '#',
                                'version' => '2.0'
                            ],
                            [
                                'id' => 7,
                                'title' => 'Education Sector Tender - Phase 2',
                                'category' => 'tenders',
                                'size' => '4.6',
                                'date' => '2024-03-15',
                                'description' => 'Tender documentation for educational infrastructure development projects in KPK.',
                                'file_url' => '#',
                                'version' => '1.0'
                            ],
                            [
                                'id' => 8,
                                'title' => 'Financial Management Guidelines for PPP',
                                'category' => 'guidelines',
                                'size' => '2.9',
                                'date' => '2023-10-12',
                                'description' => 'Guidelines for financial management, budgeting, and accounting in PPP projects.',
                                'file_url' => '#',
                                'version' => '2.2'
                            ],
                            [
                                'id' => 9,
                                'title' => 'Environmental Compliance Framework',
                                'category' => 'guidelines',
                                'size' => '3.3',
                                'date' => '2024-01-08',
                                'description' => 'Environmental sustainability and compliance framework for all PPP projects.',
                                'file_url' => '#',
                                'version' => '1.8'
                            ],
                        ];
                    @endphp

                    @foreach($sampleDocs as $index => $doc)
                        <div class="doc-card grid-view group" data-category="{{ $doc['category'] }}" data-search="{{ strtolower($doc['title']) }}" data-date="{{ strtotime($doc['date']) }}" data-size="{{ $doc['size'] }}" style="animation-delay: {{ $index * 0.05 }}s;">
                            <!-- Glass Morphism Card -->
                            <div class="bg-white rounded-2xl overflow-hidden border-2 border-white/30 backdrop-blur-xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col hover:border-[#c9a84c] hover:-translate-y-2">
                                <!-- Card Header with Icon -->
                                <div class="bg-linear-to-r from-[#0D2818] to-[#1a3d2e] p-6 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-[#c9a84c]/20 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-[#c9a84c]" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"></path>
                                                <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-[#c9a84c] font-semibold text-sm">PDF</span>
                                    </div>
                                    <span class="text-[#DAD7CD] text-xs">v{{ $doc['version'] }}</span>
                                </div>

                                <!-- Card Body -->
                                <div class="p-6 flex-1 flex flex-col">
                                    <!-- Title -->
                                    <h3 class="text-lg font-bold text-[#0D2818] mb-3 line-clamp-2 group-hover:text-[#c9a84c] transition-colors duration-300">
                                        {{ $doc['title'] }}
                                    </h3>

                                    <!-- Category Badge -->
                                    <div class="mb-3 inline-flex">
                                        <span class="px-3 py-1 bg-[#0A612B]/10 text-[#0A612B] text-xs font-semibold rounded-full uppercase tracking-wide">
                                            {{ ucfirst($doc['category']) }}
                                        </span>
                                    </div>

                                    <!-- Document Info -->
                                    <div class="space-y-2 text-sm text-gray-600 mb-4 flex-1">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-[#0D2818]/40" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54c-.37-.46-.98-.46-1.35 0-.37.46-.37 1.2 0 1.66l2 2.45c.37.46.98.46 1.35 0l4.1-5.07c.37-.46.37-1.2 0-1.66-.37-.46-.98-.46-1.35 0z"></path>
                                            </svg>
                                            <span class="text-[#0D2818]">File Size: <strong>{{ $doc['size'] }} MB</strong></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-[#0D2818]/40" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"></path>
                                            </svg>
                                            <span class="text-[#0D2818]">Uploaded: <strong>{{ date('M d, Y', strtotime($doc['date'])) }}</strong></span>
                                        </div>
                                    </div>

                                    <!-- Description (truncated) -->
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-6">
                                        {{ $doc['description'] }}
                                    </p>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3 mt-auto">
                                        <button class="flex-1 btn-preview bg-white border-2 border-[#0D2818] text-[#0D2818] font-semibold py-2 px-4 rounded-lg hover:bg-[#0D2818] hover:text-white transition-all duration-300 text-sm uppercase tracking-wide" data-doc-url="{{ $doc['file_url'] }}" title="Preview Document">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview
                                        </button>
                                        <button class="flex-1 btn-download bg-[#c9a84c] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#b39339] transition-all duration-300 text-sm uppercase tracking-wide relative overflow-hidden group/btn" data-doc-id="{{ $doc['id'] }}" data-doc-name="{{ str_replace(' ', '-', strtolower($doc['title'])) }}" title="Download Document">
                                            <span class="relative z-10 flex items-center justify-center">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19v-7m0 0V5m0 7H5m7 0h7"></path>
                                                </svg>
                                                Download
                                            </span>
                                            <!-- Shimmer Effect -->
                                            <div class="absolute inset-0 bg-linear-to-r from-transparent via-white/30 to-transparent transform -translate-x-full group-hover/btn:translate-x-full transition-transform duration-500"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-10 px-6">
                <div class="mb-6 flex justify-center">
                    <svg class="w-24 h-24 text-[#0D2818]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#0D2818] mb-2">No Documents Found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your search or filter criteria to find what you're looking for.</p>
                <button onclick="document.getElementById('searchInput').value = ''; document.getElementById('documentsContainer').querySelectorAll('.doc-card').forEach(el => el.classList.remove('hidden')); document.getElementById('emptyState').classList.add('hidden');" class="px-6 py-3 bg-[#0A612B] text-white font-semibold rounded-lg hover:bg-[#074d22] transition-colors duration-300">
                    Clear Filters
                </button>
            </div>

            <!-- Pagination (if applicable) -->
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <button class="px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-colors duration-300" title="Previous Page">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"></path>
                        </svg>
                    </button>
                    <button class="px-4 py-2 bg-[#c9a84c] text-white rounded-lg font-semibold hover:bg-[#b39339] transition-colors duration-300">1</button>
                    <button class="px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-colors duration-300">2</button>
                    <button class="px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-colors duration-300">3</button>
                    <button class="px-4 py-2 border-2 border-[#0D2818]/20 text-[#0D2818] rounded-lg hover:border-[#c9a84c] hover:text-[#c9a84c] transition-colors duration-300" title="Next Page">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"></path>
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </section>

    <!-- PDF Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Modal Backdrop -->
            <div class="fixed inset-0 bg-black/60 transition-opacity" id="modalBackdrop"></div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-4xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-linear-to-r from-[#0D2818] to-[#1a3d2e]">
                    <h3 class="text-xl font-bold text-white" id="modalTitle">Document Preview</h3>
                    <button id="closeModalBtn" class="text-white hover:text-[#c9a84c] transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 bg-gray-50">
                    <div class="relative w-full h-96 bg-white rounded-lg overflow-hidden shadow-md border-2 border-gray-200">
                        <iframe id="pdfViewer" src="" class="w-full h-full" title="PDF Preview"></iframe>
                        <div class="absolute inset-0 hidden items-center justify-center bg-white" id="loadingSpinner">
                            <div class="text-center">
                                <div class="inline-block">
                                    <svg class="animate-spin h-12 w-12 text-[#c9a84c]" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <p class="mt-3 text-gray-600 font-medium">Loading PDF...</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-4 text-center">Note: Some PDFs may require downloading if they cannot be displayed inline.</p>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end">
                    <button id="downloadFromModal" class="px-6 py-2 bg-[#c9a84c] text-white font-semibold rounded-lg hover:bg-[#b39339] transition-colors duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19v-7m0 0V5m0 7H5m7 0h7"></path>
                        </svg>
                        Download
                    </button>
                    <button id="closeModalBtnFooter" class="px-6 py-2 border-2 border-[#0D2818] text-[#0D2818] font-semibold rounded-lg hover:bg-[#0D2818] hover:text-white transition-colors duration-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bottom-6 right-6 bg-white rounded-lg shadow-2xl border-l-4 border-[#0A612B] p-4 max-w-sm z-50 animate-slide-up">
        <div class="flex items-center gap-3">
            <div class="shrink-0">
                <svg class="h-5 w-5 text-[#0A612B]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-[#0D2818]" id="toastMessage">Download started successfully!</p>
                <p class="text-sm text-gray-600 mt-1" id="toastSubtext">Your file will be downloaded to your downloads folder.</p>
            </div>
            <button onclick="document.getElementById('toast').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Animations CSS -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }

        .doc-card {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .doc-card.hidden {
            display: none !important;
        }

        #previewModal.hidden {
            display: none;
        }

        #previewModal:not(.hidden) {
            display: flex;
        }

        /* Glass Morphism Effect */
        .bg-white {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        /* Smooth underline indicator for filter tabs */
        .filter-btn {
            position: relative;
            padding-bottom: 0.5rem;
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #c9a84c;
            transition: width 0.3s ease;
        }

        .filter-btn:hover::after {
            width: 100%;
        }

        /* Smooth gradient for buttons on hover */
        .btn-download {
            position: relative;
        }
    </style>

    <!-- JavaScript for Interactivity -->
    <script>
        // Initialize state
        let currentView = 'grid';
        let currentFilter = 'all';
        let currentSort = 'newest';

        // DOM Elements
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const viewToggleBtns = document.querySelectorAll('.view-toggle');
        const sortSelect = document.getElementById('sortBy');
        const documentsContainer = document.getElementById('documentsContainer');
        const docCards = document.querySelectorAll('.doc-card');
        const previewBtns = document.querySelectorAll('.btn-preview');
        const downloadBtns = document.querySelectorAll('.btn-download');
        const previewModal = document.getElementById('previewModal');
        const closeModalBtns = [document.getElementById('closeModalBtn'), document.getElementById('closeModalBtnFooter')];
        const modalBackdrop = document.getElementById('modalBackdrop');
        const pdfViewer = document.getElementById('pdfViewer');
        const toast = document.getElementById('toast');
        const gridViewBtn = document.getElementById('gridViewBtn');
        const listViewBtn = document.getElementById('listViewBtn');

        // Search functionality
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            filterCards();
        });

        // Filter functionality
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('border-[#c9a84c]', 'text-[#c9a84c]', 'bg-[#c9a84c]', 'text-white', 'active');
                    b.classList.add('border-[#0D2818]/20', 'text-[#0D2818]');
                });
                btn.classList.remove('border-[#0D2818]/20', 'text-[#0D2818]');
                btn.classList.add('border-[#c9a84c]', 'text-[#c9a84c]', 'bg-[#c9a84c]', 'text-white', 'active');
                currentFilter = btn.dataset.filter;
                filterCards();
            });
        });

        // View toggle
        gridViewBtn.addEventListener('click', () => {
            currentView = 'grid';
            gridViewBtn.classList.add('border-[#c9a84c]', 'text-[#c9a84c]', 'bg-[#c9a84c]', 'text-white');
            gridViewBtn.classList.remove('border-[#0D2818]/20', 'text-[#0D2818]');
            listViewBtn.classList.remove('border-[#c9a84c]', 'text-[#c9a84c]');
            listViewBtn.classList.add('border-[#0D2818]/20', 'text-[#0D2818]');
            documentsContainer.classList.remove('grid-cols-1');
            documentsContainer.classList.add('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
        });

        listViewBtn.addEventListener('click', () => {
            currentView = 'list';
            listViewBtn.classList.add('border-[#c9a84c]', 'text-[#c9a84c]', 'bg-[#c9a84c]', 'text-white');
            listViewBtn.classList.remove('border-[#0D2818]/20', 'text-[#0D2818]');
            gridViewBtn.classList.remove('border-[#c9a84c]', 'text-[#c9a84c]');
            gridViewBtn.classList.add('border-[#0D2818]/20', 'text-[#0D2818]');
            documentsContainer.classList.remove('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
            documentsContainer.classList.add('grid-cols-1');
        });

        // Sorting functionality
        sortSelect.addEventListener('change', (e) => {
            currentSort = e.target.value;
            sortCards();
        });

        // Filter cards based on search and category
        function filterCards() {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;

            docCards.forEach(card => {
                const category = card.dataset.category;
                const searchText = card.dataset.search;
                const matchesFilter = currentFilter === 'all' || category === currentFilter;
                const matchesSearch = searchText.includes(searchTerm);

                if (matchesFilter && matchesSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            document.getElementById('emptyState').classList.toggle('hidden', visibleCount > 0);
        }

        // Sort cards
        function sortCards() {
            const cardsArray = Array.from(docCards).filter(card => !card.classList.contains('hidden'));
            
            cardsArray.sort((a, b) => {
                const titleA = a.querySelector('h3').textContent.toLowerCase();
                const titleB = b.querySelector('h3').textContent.toLowerCase();
                const dateA = parseInt(a.dataset.date);
                const dateB = parseInt(b.dataset.date);
                const sizeA = parseFloat(a.dataset.size);
                const sizeB = parseFloat(b.dataset.size);

                switch(currentSort) {
                    case 'newest': return dateB - dateA;
                    case 'oldest': return dateA - dateB;
                    case 'name-asc': return titleA.localeCompare(titleB);
                    case 'name-desc': return titleB.localeCompare(titleA);
                    case 'size-asc': return sizeA - sizeB;
                    case 'size-desc': return sizeB - sizeA;
                    default: return 0;
                }
            });

            // Reorder in DOM
            cardsArray.forEach((card, index) => {
                card.style.order = index;
                card.style.animationDelay = (index * 0.05) + 's';
            });
        }

        // Preview functionality
        previewBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const docUrl = btn.dataset.docUrl;
                const docName = btn.closest('.doc-card').querySelector('h3').textContent;
                
                document.getElementById('modalTitle').textContent = `Preview: ${docName}`;
                pdfViewer.src = docUrl;
                previewModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });

        // Close modal
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                previewModal.classList.add('hidden');
                pdfViewer.src = '';
                document.body.style.overflow = 'auto';
            });
        });

        modalBackdrop.addEventListener('click', () => {
            previewModal.classList.add('hidden');
            pdfViewer.src = '';
            document.body.style.overflow = 'auto';
        });

        // Download functionality
        downloadBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const docId = btn.dataset.docId;
                const docName = btn.dataset.docName;
                
                // Show loading state
                btn.innerHTML = '<span class="relative z-10 flex items-center justify-center"><svg class="animate-spin w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Downloading...</span>';
                btn.disabled = true;

                // Simulate download (replace with actual API call)
                setTimeout(() => {
                    btn.innerHTML = '<span class="relative z-10 flex items-center justify-center"><svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19v-7m0 0V5m0 7H5m7 0h7"></path></svg> Download</span>';
                    btn.disabled = false;

                    // Show toast notification
                    document.getElementById('toastMessage').textContent = `${docName}.pdf started downloading!`;
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 4000);
                }, 1500);
            });
        });

        // Download from modal
        document.getElementById('downloadFromModal').addEventListener('click', () => {
            const title = document.getElementById('modalTitle').textContent;
            document.getElementById('toastMessage').textContent = `${title} started downloading!`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 4000);
        });

        // Keyboard shortcut to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !previewModal.classList.contains('hidden')) {
                previewModal.classList.add('hidden');
                pdfViewer.src = '';
                document.body.style.overflow = 'auto';
            }
        });
    </script>
@endsection
