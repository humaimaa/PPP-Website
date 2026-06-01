@extends('layouts.app')

@section('title', 'PPP Department KPK - ' . ($project->name ?? 'Project Details'))

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">{{ $project->name ?? 'Project Details' }}</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4">Comprehensive information about our PPP initiatives</p>
        </div>
    </div>
    <img src="{{ asset('images/' . ($project->image ?? 'project-1.jpg')) }}" alt="Project Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('projects.index', 'all') }}" class="text-accent-1 hover:text-accent-2 inline-flex items-center transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
            
            <div class="bg-background-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-[400px] overflow-hidden">
                    <img src="{{ asset('images/' . ($project->image ?? 'project-2.jpg')) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-text-green mb-2">{{ $project->name }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $project->sector }}</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium capitalize 
                                    @if($project->category === 'Completed') bg-green-100 text-green-800
                                    @elseif($project->category === 'Ongoing') bg-yellow-100 text-yellow-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ $project->category }}
                                </span>
                            </div>
                            <div class="flex items-center text-text-muted text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ $project->implementing_authority }}
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-right">
                            <p class="text-2xl font-bold text-accent-1">${{ number_format($project->cost / 1000000, 1) }} Million</p>
                            <p class="text-sm text-text-muted">Total Investment</p>
                            <p class="text-sm text-text-muted mt-1">Division: {{ $project->division }}</p>
                            <p class="text-sm text-text-muted">Location: {{ $project->location }}</p>
                        </div>
                    </div>
                    
                    <!-- Project Overview (with line break support) -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-text-green mb-4">Project Overview</h2>
                        <div class="text-text-muted leading-relaxed space-y-4">
                            {!! nl2br(e($project->overview)) !!}
                        </div>
                    </div>

                    <!-- Pipeline Projects (Category = 'Pipeline') -->
                    @if($project->category === 'Pipeline' && isset($pipelineDetails))
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-text-green mb-4">Project Scope</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($pipelineDetails->scope)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($pipelineDetails->cost_financing_mix)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Project Timeline</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($pipelineDetails->project_timeline)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Expected Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-relaxed space-y-4">
                            {!! nl2br(e($pipelineDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Ongoing Projects (Category = 'Ongoing') -->
                    @if($project->category === 'Ongoing' && isset($ongoingDetails))
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-text-green mb-4">Implementing Modality</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($ongoingDetails->implementing_modality)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Government Contribution</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($ongoingDetails->government_contribution)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Government Return</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($ongoingDetails->government_return)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Private Party Return</h2>
                        <div class="text-text-muted leading-relaxed space-y-4">
                            {!! nl2br(e($ongoingDetails->private_party_return)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Completed/Operational Projects (Category = 'Completed') -->
                    @if($project->category === 'Completed' && isset($completedDetails))
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-text-green mb-4">Project Scope</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($completedDetails->scope)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Cost & Financing Mix</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($completedDetails->cost_financing_mix)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Project Timeline</h2>
                        <div class="text-text-muted leading-relaxed space-y-4 mb-6">
                            {!! nl2br(e($completedDetails->project_timeline)) !!}
                        </div>

                        <h2 class="text-2xl font-bold text-text-green mb-4">Financial Benefits to Government</h2>
                        <div class="text-text-muted leading-relaxed space-y-4">
                            {!! nl2br(e($completedDetails->expected_financial_benefits_to_government)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Key Achievements Section (for all project types) -->
                    @if(isset($achievements) && count($achievements) > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-text-green mb-4">Key Achievements</h2>
                        <ul class="space-y-2">
                            @foreach($achievements as $achievement)
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 text-accent-1 mr-2 mt-0.5 transform transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-text-muted">{{ $achievement }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="bg-background-light/30 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-text-green mb-3">For More Information</h3>
                        <p class="text-text-muted mb-4">For detailed project documents or inquiries, please contact our project management office.</p>
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