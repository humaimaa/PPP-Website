@extends('layouts.app')

@section('title', 'PPP Unit KP - ' . ($project->name ?? 'Project Details'))

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        
    </div> 
        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/project-placeholder.jpg') }}" alt="Project Banner" class="w-full h-full object-cover">

    </section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('projects.index', 'all') }}" class="text-accent-1 hover:text-accent-2 inline-flex items-center transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
            
            <div class="bg-background-white  overflow-hidden">
                                
                <div class="px-6 md:px-8">
                    <div class="grid grid-cols-3  gap-6 justify-between items-start mb-6">
                        <div class="col-span-2 ">
                            <h2 class="text-xl md:text-2xl lg:text-2xl font-bold wrap-normal text-text-green mb-2 ">{{formatTitle( Str::title($project->name) )}}</h2>
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $project->sector }}</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium capitalize 
                                    @if($project->category === 'Completed') bg-green-100 text-green-800
                                    @elseif($project->category === 'Ongoing') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $project->category }}
                                </span>
                            </div>
                            <div class="flex items-center text-text-muted text-sm mb-2">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{  Str::upper($project->implementing_authority)  }}
                            </div>
                            <div class="flex items-center text-text-muted text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $project->location ?? 'Khyber Pakhtunkhwa' }}
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-right">
                            <p class="text-2xl font-bold text-accent-1">PKR {{ $project->cost  }} </p>
                            <p class="text-sm text-text-muted">Total Investment</p>
                        </div>
                    </div>
                    
                    <!-- Project Overview -->
                    <div class="mb-6">
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Overview</h2>
                        <div class="text-text-muted leading-normal space-y-3 text-justify">
                            {!! nl2br(e($project->overview)) !!}
                        </div>
                    </div>

                    <!-- Pipeline Projects Details -->
                    @if($project->category === 'Pipeline' && $pipelineDetails)
                    <div class="mb-6">
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Scope</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->scope)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->cost_financing_mix)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Timeline</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($pipelineDetails->project_timeline)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Expected Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-normal space-y-3">
                            {!! nl2br(e($pipelineDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Ongoing Projects Details -->
                    @if($project->category === 'Ongoing' && $ongoingDetails)
                    <div class="mb-6">
                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Implementing Modality</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->implementing_modality)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Government Contribution</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->government_contribution)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Government Return</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($ongoingDetails->government_return)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Private Party Return</h2>
                        <div class="text-text-muted leading-normal space-y-3">
                            {!! nl2br(e($ongoingDetails->private_party_return)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Completed Projects Details -->
                    @if($project->category === 'Completed' && $completedDetails)
                    <div class="mb-6">
                        <h2 class="text-lg md:text-xl   font-bold text-text-green mb-3">Project Scope</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->scope)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-normal space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->cost_financing_mix)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Project Timeline</h2>
                        <div class="text-text-muted  leading-normal space-y-3 mb-6">
                            {!! nl2br(e($completedDetails->project_timeline)) !!}
                        </div>

                        <h2 class="text-lg md:text-xl font-bold text-text-green mb-3">Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-normal space-y-3">
                            {!! nl2br(e($completedDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                    </div>
                    @endif


                    
                    <!-- Contact Section -->
                    <div class="bg-background-light/30 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-text-green mb-3">For More Information</h3>
                        <p class="text-text-muted mb-3">For detailed project documents or inquiries, please contact our office.</p>
                        <a href="{{ route('contact') }}" class="inline-block px-6 py-2 bg-accent-1 text-text-primary rounded-md hover:bg-accent-2 transition duration-300">
                            Contact Project Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection