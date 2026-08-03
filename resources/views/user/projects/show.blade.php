@extends('layouts.app')

@section('title', 'PPP Unit KP - ' . ($project->name ?? 'Project Details'))

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            
        </div>
    </div>
    <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-placeholder.jpg') }}" 
         alt="{{ $project->name }}" 
         class="w-full h-full object-cover">
</section>

<!-- Project Details Section -->
<section class="py-16 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="max-w-5xl mx-auto">
            <!-- Back Button with preserved filters -->
            <div class="mb-6">
                @php
                    // Get filters from session or use defaults
                    $filters = $filters ?? session()->get('projects_filters', [
                        'category' => 'all',
                        'status' => 'all',
                        'sector' => null,
                        'page' => 1
                    ]);
                    
                    // Build the route parameters
                    $category = $filters['category'] ?? 'all';
                    $status = $filters['status'] ?? 'all';
                    
                    // Build query parameters
                    $queryParams = [];
                    if (!empty($filters['sector'])) {
                        $queryParams['sector'] = $filters['sector'];
                    }
                    if (!empty($filters['page']) && $filters['page'] > 1) {
                        $queryParams['page'] = $filters['page'];
                    }
                    
                    // Build the URL
                    $backUrl = route('projects.index', [
                        'category' => $category,
                        'status' => $status
                    ]);
                    
                    // Add query parameters if they exist
                    if (!empty($queryParams)) {
                        $backUrl .= '?' . http_build_query($queryParams);
                    }
                @endphp
                
                <a href="{{ $backUrl }}" 
                   class="text-accent-1 hover:text-primary-hover inline-flex items-center transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
            
            <div class="bg-background-white overflow-hidden">
                <div>
                    <!-- Project Header -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-between items-start mb-6">
                        <div class="md:col-span-2">
                            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-text-green mb-2">
                                {{ formatTitle( Str::title($project->name) ) }}
                            </h2>
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <!-- UPDATED: Sector display using relationship -->
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $project->sector ? $project->sector->name : 'N/A' }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium capitalize 
                                    @if($project->category === 'Completed') bg-green-100 text-green-800
                                    @elseif($project->category === 'Ongoing') bg-yellow-100 text-yellow-800
                                    @elseif($project->category === 'Construction & Operational') bg-orange-100 text-orange-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $project->category }}
                                </span>
                            </div>
                            <div class="flex items-center text-text-muted text-sm mb-2">
                                <svg class="w-4 h-4 mr-1.5 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ Str::upper($project->implementing_authority) }}
                            </div>
                            <div class="flex items-center text-text-muted text-sm">
                                <svg class="w-4 h-4 mr-1.5 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $project->location ?? 'Khyber Pakhtunkhwa' }}
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-left md:text-right">
                            <p class="text-2xl font-bold text-accent-1">PKR {{ Str::title($project->cost)  }}</p>
                            <p class="text-sm text-text-muted">Total Investment</p>
                        </div>
                    </div>
                    
                    <!-- Project Overview -->
                    @if($project->overview)
                    <div class="mb-8">
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Overview</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 text-justify">
                            {!! nl2br(e($project->overview)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Pipeline Projects Details -->
                    @if($project->category === 'Pipeline' && $pipelineDetails)
                    <div class="mb-8">
                        @if($pipelineDetails->scope)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Scope</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->scope)) !!}
                        </div>
                        @endif

                        @if($pipelineDetails->cost_financing_mix)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->cost_financing_mix)) !!}
                        </div>
                        @endif

                        @if($pipelineDetails->project_timeline)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Timeline</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->project_timeline)) !!}
                        </div>
                        @endif

                        @if($pipelineDetails->expected_financial_benefits_to_government)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Expected Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-relaxed space-y-3">
                            {!! nl2br(e($pipelineDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Ongoing Projects Details -->
                    @if($project->category === 'Ongoing' && $ongoingDetails)
                    <div class="mb-8">
                        @if($ongoingDetails->implementing_modality)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Implementing Modality</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->implementing_modality)) !!}
                        </div>
                        @endif

                        @if($ongoingDetails->government_contribution)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Government Contribution</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->government_contribution)) !!}
                        </div>
                        @endif

                        @if($ongoingDetails->government_return)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Government Return</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->government_return)) !!}
                        </div>
                        @endif

                        @if($ongoingDetails->private_party_return)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Private Party Return</h2>
                        <div class="text-text-muted leading-relaxed space-y-3">
                            {!! nl2br(e($ongoingDetails->private_party_return)) !!}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Construction & Operational Projects Details -->
                    @if($project->category === 'Construction & Operational' && $completedDetails)
                    <div class="mb-8">
                        @if($completedDetails->scope)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Scope</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->scope)) !!}
                        </div>
                        @endif

                        @if($completedDetails->cost_financing_mix)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->cost_financing_mix)) !!}
                        </div>
                        @endif

                        @if($completedDetails->project_timeline)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Timeline</h2>
                        <div class="text-text-muted leading-relaxed space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->project_timeline)) !!}
                        </div>
                        @endif

                        @if($completedDetails->expected_financial_benefits_to_government)
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-relaxed space-y-3">
                            {!! nl2br(e($completedDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Contact Section -->
                    <div class="bg-background-light/30 p-6 rounded-lg mb-4 border border-gray-200/30">
                        <h3 class="text-xl font-bold text-text-green mb-2">For More Information</h3>
                        <p class="text-text-muted text-sm mb-4">For detailed project documents or inquiries, please contact our office.</p>
                        
                        <!-- Clickable Icon Buttons -->
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Email Button -->
                            <a href="{{ route('contact') }}" 
                               class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent-1 text-text-green border border-gray-200/50 rounded-md hover:text-white hover:border-accent-1 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection