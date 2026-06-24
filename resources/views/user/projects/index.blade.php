@extends('layouts.app')

@section('title', 
    ($category ?? 'all') === 'pipeline' ? 'PPP Department KP - Pipeline Projects' :
    (($category ?? 'all') === 'ongoing' ? 'PPP Department KP - Ongoing Projects' :
    (($category ?? 'all') === 'construction-operational' ? 'PPP Department KP - Construction & Operational Projects' :
    (($status ?? 'all') === 'private-partner' ? 'PPP Department KP - Private Partner Selection Projects' :
    (($status ?? 'all') === 'transaction-advisory' ? 'PPP Department KP - Transaction Advisory Projects' :
    (($status ?? 'all') === 'construction' ? 'PPP Department KP - Construction Projects' :
    (($status ?? 'all') === 'operational' ? 'PPP Department KP - Operational Projects' : 'PPP Department KP - All Projects')))))))

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                @if($category  === 'pipeline' && $status === 'all')
                Pipeline Projects
                @elseif($category  === 'ongoing' && $status === 'all')
                Ongoing Projects
                @elseif($category  === 'construction-operational' && $status === 'all')
                Construction &  Operational Projects
                @elseif($status  === 'private-partner' && $category  === 'ongoing')
                Private Partner Selection Projects
                @elseif($status  === 'transaction-advisory' && $category  === 'ongoing')
                Transaction Advisory Projects
                @elseif($status  === 'construction' && $category  === 'construction-operational')
                Construction Projects
                @elseif($status  === 'operational' && $category  === 'construction-operational')
                Operational Projects
                @else
                All Projects
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
</section>

<!-- ===== FILTER SECTION - Hierarchical Dropdown ===== -->
<section class="bg-gray-50 border-b border-gray-200 py-4">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <span class="text-sm font-medium text-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter:
                </span>
                
                <!-- Single Hierarchical Dropdown -->
                <select id="filterSelect" 
                        onchange="updateFilter()"
                        class="w-full sm:w-auto px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-sm text-gray-700 appearance-none bg-no-repeat bg-right-2 bg-[length:1.5em] transition hover:border-emerald-400 min-w-[220px]">
                    <!-- All Projects -->
                    <option value="all_all" {{ ($category ?? 'all') === 'all' && ($status ?? 'all') === 'all' ? 'selected' : '' }}>
                        All Projects
                    </option>
                    
                    <!-- Pipeline -->
                    <option value="pipeline_all" {{ ($category ?? 'all') === 'pipeline' && ($status ?? 'all') === 'all' ? 'selected' : '' }}>
                        Pipeline
                    </option>
                    
                    <!-- Ongoing -->
                    <option value="ongoing_all" {{ ($category ?? 'all') === 'ongoing' && ($status ?? 'all') === 'all' ? 'selected' : '' }}>
                        Ongoing
                    </option>
                    <option value="ongoing_private-partner" {{ ($category ?? 'all') === 'ongoing' && ($status ?? 'all') === 'private-partner' ? 'selected' : '' }}>
                        &nbsp;&nbsp;&nbsp;Private Partner Selection
                    </option>
                    <option value="ongoing_transaction-advisory" {{ ($category ?? 'all') === 'ongoing' && ($status ?? 'all') === 'transaction-advisory' ? 'selected' : '' }}>
                        &nbsp;&nbsp;&nbsp;Transaction Advisory
                    </option>
                    
                    <!-- Construction & Operational -->
                    <option value="construction-operational_all" {{ ($category ?? 'all') === 'construction-operational' && ($status ?? 'all') === 'all' ? 'selected' : '' }}>
                        Construction & Operational
                    </option>
                    <option value="construction-operational_construction" {{ ($category ?? 'all') === 'construction-operational' && ($status ?? 'all') === 'construction' ? 'selected' : '' }}>
                        &nbsp;&nbsp;&nbsp;Construction
                    </option>
                    <option value="construction-operational_operational" {{ ($category ?? 'all') === 'construction-operational' && ($status ?? 'all') === 'operational' ? 'selected' : '' }}>
                        &nbsp;&nbsp;&nbsp;Operational
                    </option>
                </select>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-end">
                <span class="text-xs sm:text-sm text-gray-500 bg-white px-3 py-1.5 rounded-full border border-gray-200 shadow-sm whitespace-nowrap">
                    Showing <span class="font-medium text-gray-700">{{ $projects->firstItem() ?? 0 }}</span> - 
                    <span class="font-medium text-gray-700">{{ $projects->lastItem() ?? 0 }}</span> of 
                    <span class="font-medium text-gray-700">{{ $projects->total() }}</span> projects
                </span>
            </div>
        </div>
    </div>
</section>

<script>
function updateFilter() {
    const value = document.getElementById('filterSelect').value;
    const parts = value.split('_');
    const category = parts[0];
    const status = parts[1] || 'all';
    
    // Build URL with both parameters
    let url = '{{ route("projects.index", ["category" => ":category", "status" => ":status"]) }}';
    url = url.replace(':category', category);
    url = url.replace(':status', status);
    
    window.location.href = url;
}
</script>

<section class="py-10 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
            <!-- Project Card -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-placeholder.jpg') }}" 
                         alt="{{ $project->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">

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
                        {{ formatTitle( str :: title($project->status ?? 'N/A') )   }}         }}
                    </div>
                    @endif
                </div>

                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-emerald-800 mb-2 line-clamp-2">{{ formatTitle( str :: title($project->name) ) }}</h3>
                    
                    <!-- Cost -->
                    @if($project->cost)
                    <div class="flex items-center text-gray-600 text-sm mb-2">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cost: {{ $project->cost }}
                    </div>
                    @endif

                    <!-- Sector -->
                    <div class="flex items-center text-gray-600 text-sm mb-3">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ formatTitle( str :: title($project->sector) ) }}
                    </div>

                    <!-- View Details Button -->
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('projects.show', $project->id) }}"
                            class="text-emerald-600 font-medium hover:text-emerald-800 transition-colors duration-300 inline-flex items-center text-sm">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="col-span-full text-center py-12">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-2xl font-semibold text-emerald-800 mb-2">No Projects Found</h3>
            <p class="text-gray-500">No projects available with the selected filters.</p>
        </div>
        @endif

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-10">
            {{ $projects->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</section>

@endsection