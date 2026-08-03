@extends('layouts.app')

@section('title',
isset($sectorFilter) ? 'PPP Department KP - ' . $sectorFilter . ' Projects' :
(($category ?? 'all') === 'pipeline' ? 'PPP Department KP - Pipeline Projects' :
(($category ?? 'all') === 'ongoing' ? 'PPP Department KP - Ongoing Projects' :
(($category ?? 'all') === 'construction-operational' ? 'PPP Department KP - Construction & Operational Projects' :
(($status ?? 'all') === 'private-partner' ? 'PPP Department KP - Private Partner Selection Projects' :
(($status ?? 'all') === 'transaction-advisory' ? 'PPP Department KP - Transaction Advisory Projects' :
(($status ?? 'all') === 'construction' ? 'PPP Department KP - Construction Projects' :
(($status ?? 'all') === 'operational' ? 'PPP Department KP - Operational Projects' : 'PPP Department KP - All
Projects'))))))))

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center"
        style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                @if(isset($sectorFilter) && $sectorData)
                {{ $sectorData->name }} Projects
                @elseif(isset($sectorFilter))
                {{ $sectorFilter }} Projects
                @elseif($category === 'pipeline' && $status === 'all')
                Pipeline Projects
                @elseif($category === 'ongoing' && $status === 'all')
                Ongoing Projects
                @elseif($category === 'construction-operational' && $status === 'all')
                Construction & Operational Projects
                @elseif($status === 'private-partner' && $category === 'ongoing')
                Private Partner Selection Projects
                @elseif($status === 'transaction-advisory' && $category === 'ongoing')
                Transaction Advisory Projects
                @elseif($status === 'construction' && $category === 'construction-operational')
                Construction Projects
                @elseif($status === 'operational' && $category === 'construction-operational')
                Operational Projects
                @else
                All Projects
                @endif
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    @if(isset($sectorFilter) && $sectorData && $sectorData->img)
    <!-- Use sector image from database -->
    <img src="{{ asset('storage/' . $sectorData->img) }}" alt="{{ $sectorData->name }} Sector"
        class="w-full h-full object-cover">
    @else
    <!-- Default fallback image -->
    <img src="{{ asset('images/project.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
    @endif
</section>

<!-- Projects Grid -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
            <!-- Project Card -->
            <div
                class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200/30">
                <!-- Image Section - Clickable -->
                <div class="h-48 overflow-hidden relative">
                    <a href="{{ route('projects.show', $project->slug) }}" class="block w-full h-full">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-placeholder.jpg') }}"
                            alt="{{ $project->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </a>

                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-medium capitalize text-white
                            @if($project->category === 'Construction & Operational') bg-green-600
                            @elseif($project->category === 'Ongoing') bg-yellow-500
                            @elseif($project->category === 'Pipeline') bg-purple-600
                            @else bg-gray-600 @endif">
                        {{ $project->category ?? 'N/A' }}
                    </div>

                    <!-- Status Badge - HIDDEN FOR PIPELINE PROJECTS -->
                    @if($project->category !== 'Pipeline')
                    <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-medium capitalize text-white
                            @if($project->status === 'Complete' || $project->status === 'Completed') bg-green-700
                            @elseif($project->status === 'Ongoing') bg-yellow-600
                            @elseif($project->status === 'Operational') bg-blue-600
                            @elseif($project->status === 'Private Partner Selection') bg-indigo-600
                            @elseif($project->status === 'Transaction Advisory') bg-cyan-600
                            @elseif($project->status === 'Construction') bg-orange-600
                            @else bg-gray-600 @endif">
                        {{ formatTitle( Str::title($project->status ?? 'N/A') ) }}
                    </div>
                    @endif
                </div>

                <div class="p-4">
                    <!-- Title - Clickable -->
                    <h3 class="text-lg font-bold h-14 text-text-green mb-3 line-clamp-2"
                        title="{{ formatTitle( Str::title($project->name) ) }}">
                        <a href="{{ route('projects.show', $project->slug) }}"
                            class="hover:text-accent-1 transition-colors duration-300">
                            {{ formatTitle( Str::title($project->name) ) }}
                        </a>
                    </h3>

                    <!-- Cost & Sector - Grid Layout (Row 1) -->
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <!-- Cost - Left Aligned -->
                        @if($project->cost)
                        <div class="flex items-center text-text-muted text-sm justify-start">
                            <svg class="w-4 h-4 mr-1.5 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <span class="truncate" title="{{ $project->cost }}">{{ $project->cost }}</span>
                        </div>
                        @else
                        <div></div> <!-- Empty cell to maintain grid -->
                        @endif

                        <!-- Sector - Right Aligned -->
                        <div class="flex items-center text-text-muted text-sm justify-end">
                            <svg class="w-4 h-4 mr-1.5 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span class="truncate"
                                title="{{ formatTitle( Str::title($project->sector ? $project->sector->name : 'N/A') ) }}">
                                {{ formatTitle( Str::title($project->sector ? $project->sector->name : 'N/A') ) }}
                            </span>
                        </div>
                    </div>

                    <!-- Location - Row 2 -->
                    @if($project->location)
                    <div class="flex items-center text-text-muted text-sm mb-2">
                        <svg class="w-4 h-4 mr-1.5 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="truncate" title="{{ $project->location }}">{{ $project->location }}</span>
                    </div>
                    @endif

                    <!-- View Details Button -->
                    <div class="mt-3 pt-3 border-t border-gray-200/30">
                        <a href="{{ route('projects.show', $project->slug) }}"
                            class="text-accent-1 font-medium hover:text-primary-hover transition-colors duration-300 inline-flex items-center text-sm">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($projects->hasPages())
        @php
        // Build the route parameters for projects.index
        $routeParams = [
        'category' => $category ?? 'all',
        'status' => $status ?? 'all'
        ];

        // Add sector as query parameter if it exists
        $queryParams = request()->query();
        if (isset($sectorFilter)) {
        $queryParams['sector'] = $sectorFilter;
        }

        // Remove page from query params to avoid duplication
        unset($queryParams['page']);
        @endphp

        @include('layouts.partials.pagination', [
        'currentPage' => $projects->currentPage(),
        'lastPage' => $projects->lastPage(),
        'total' => $projects->total(),
        'perPage' => $projects->perPage(),
        'routeName' => 'projects.index',
        'params' => $routeParams,
        'queryParams' => $queryParams, // Pass query parameters separately
        'status' => $status ?? 'all', // For backward compatibility
        ])
        @endif

        @else
        <!-- No Projects Found -->
        <div class="text-center py-10">
            <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-text-green mb-2">No Projects Found</h3>
            <p class="text-text-muted text-sm md:text-md lg:text-base">
                @if(isset($sectorFilter))
                No projects available in the <strong class="text-accent-1">{{ $sectorFilter }}</strong> sector.
                <br>
                <a href="{{ route('projects.index', ['category' => 'all', 'status' => 'all']) }}"
                    class="text-accent-1 hover:text-primary-hover font-medium inline-flex items-center mt-3 transition-colors duration-300">
                    View all projects
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                @else
                No projects available with the selected filters.
                @endif
            </p>
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
@vite([
'resources/js/home-animate.js'
])
@endpush