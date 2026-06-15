@extends('layouts.app')

@section('title', 
    ($status ?? 'all') === 'operational' ? 'PPP Department KP - Operational Projects' :
    (($status ?? 'all') === 'ongoing' ? 'PPP Department KP - Ongoing Projects' :
    (($status ?? 'all') === 'pipeline' ? 'PPP Department KP - Pipeline Projects' : 'PPP Department KP - All Projects')))

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                @if(($status ?? 'all') === 'operational')
                Operational Projects
                @elseif(($status ?? 'all') === 'ongoing')
                Ongoing Projects
                @elseif(($status ?? 'all') === 'pipeline')
                Pipeline Projects
                @else
                All Projects
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto "></div>
           
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
</section>

<!-- Navigation Tabs -->
<section class="bg-background-white border-b border-gray-200 sticky top-0 z-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-2 py-4">
            <a href="{{ route('projects.index', 'pipeline') }}" 
               class="px-6 py-2 rounded-lg transition-all duration-300 {{ $status === 'pipeline' ? 'bg-accent-1 text-text-primary' : 'bg-gray-100 text-text-muted hover:bg-gray-200' }}">
                Pipeline Projects
            </a>
            <a href="{{ route('projects.index', 'ongoing') }}" 
               class="px-6 py-2 rounded-lg transition-all duration-300 {{ $status === 'ongoing' ? 'bg-accent-1 text-text-primary' : 'bg-gray-100 text-text-muted hover:bg-gray-200' }}">
                Ongoing Projects
            </a>
            <a href="{{ route('projects.index', 'operational') }}" 
               class="px-6 py-2 rounded-lg transition-all duration-300 {{ $status === 'operational' ? 'bg-accent-1 text-text-primary' : 'bg-gray-100 text-text-muted hover:bg-gray-200' }}">
                Operational Projects
            </a>
            <a href="{{ route('projects.index', 'all') }}" 
               class="px-6 py-2 rounded-lg transition-all duration-300 {{ $status === 'all' ? 'bg-accent-1 text-text-primary' : 'bg-gray-100 text-text-muted hover:bg-gray-200' }}">
                All Projects
            </a>
        </div>
    </div>
</section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
            <!-- Project Card -->
            <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-placeholder.jpg') }}" 
                         alt="{{ $project->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 
                            @if($project->category === 'Completed') bg-green-600
                            @elseif($project->category === 'Ongoing') bg-yellow-500
                            @else bg-blue-600 @endif 
                            text-text-primary px-3 py-1 rounded-full text-xs font-medium capitalize">
                        {{ $project->category }}
                    </div>
                </div>

                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-text-green mb-3 line-clamp-2">{{ $project->name }}</h3>
                    
                    <!-- Location -->
                    <div class="flex items-center text-text-muted text-sm mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $project->location ?? 'Khyber Pakhtunkhwa' }}
                    </div>

                    <!-- Sector -->
                    <div class="flex items-center text-text-muted text-sm mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ $project->sector }}
                    </div>

                    <!-- Cost -->
                    <div class="text-sm font-semibold text-accent-1 mb-3">
                        PKR {{$project->cost  }} 
                    </div>

                    <!-- Overview/Description (3 lines with ellipsis) -->
                    <p class="text-text-muted mb-4 line-clamp-3">{{ Str::limit(strip_tags($project->overview), 150) }}</p>

                    <!-- View Details Button -->
                    <div class="mt-4 pt-3 border-t border-background-light">
                        <a href="{{ route('projects.show', $project->id) }}"
                            class="text-accent-1 font-medium hover:text-accent-2 transition-colors duration-300 inline-flex items-center text-sm">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-text-green mb-2">No Projects Found</h3>
                <p class="text-text-muted">No projects available in this category at the moment.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
        <div class="mt-10">
            {{ $projects->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</section>



@endsection