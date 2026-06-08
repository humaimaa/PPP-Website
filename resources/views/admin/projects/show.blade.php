@extends('layouts.admin')

@section('title', 'Project Details - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Projects
        </a>
    </div>

    {{-- Project Details Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                        Project Details
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View complete project information</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            {{-- Image and Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1">
                    @if($project->image && Storage::disk('public')->exists($project->image))
                        <img src="{{ Storage::url($project->image) }}" 
                             alt="{{ $project->name }}"
                             class="w-full rounded-lg object-cover border border-gray-200 shadow-sm">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">No image available</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $project->name }}</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Sector</p>
                            <p class="text-sm font-medium text-gray-900">
                                <i class="fas fa-chart-line text-gray-400 mr-1"></i>
                                {{ $project->sector }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Implementing Authority</p>
                            <p class="text-sm font-medium text-gray-900">
                                <i class="fas fa-building text-gray-400 mr-1"></i>
                                {{ $project->implementing_authority }}
                            </p>
                        </div>
                        <div>
    <p class="text-xs text-gray-500 uppercase tracking-wider">Project Cost</p>
    <p class="text-sm font-semibold text-gray-900">
        {{ $project->cost }}
    </p>
</div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Category</p>
                            <p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($project->category == 'Pipeline') bg-blue-100 text-blue-800
                                    @elseif($project->category == 'Ongoing') bg-yellow-100 text-yellow-800
                                    @elseif($project->category == 'Completed') bg-green-100 text-green-800
                                    @endif">
                                    {{ $project->category }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Status</p>
                            <p>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($project->status == 'Planning') bg-blue-100 text-blue-800
                                    @elseif($project->status == 'Feasibility Study') bg-purple-100 text-purple-800
                                    @elseif($project->status == 'Bidding') bg-yellow-100 text-yellow-800
                                    @elseif($project->status == 'Implementation') bg-orange-100 text-orange-800
                                    @elseif($project->status == 'Completed') bg-green-100 text-green-800
                                    @elseif($project->status == 'Operational') bg-emerald-100 text-emerald-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $project->status ?? 'N/A' }}
                                </span>
                            </p>
                        </div>
                        @if($project->location)
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Location</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                    {{ $project->location }}
                                </p>
                            </div>
                        @endif
                        @if($project->division)
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Division</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <i class="fas fa-building text-gray-400 mr-1"></i>
                                    {{ $project->division }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Project Overview --}}
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-800 mb-3">
                    <i class="fas fa-align-left mr-2 text-emerald-600"></i>
                    Project Overview
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-line">{{ $project->overview }}</p>
                </div>
            </div>

            {{-- Ongoing Project Details --}}
            @if($project->category == 'Ongoing' && $project->ongoingDetail)
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 mb-3">
                        <i class="fas fa-chart-line mr-2 text-emerald-600"></i>
                        Ongoing Project Details
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Implementing Modality</p>
                            <p class="text-gray-600">{{ $project->ongoingDetail->implementing_modality }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Government Contribution</p>
                                <p class="text-gray-600">{{ $project->ongoingDetail->government_contribution }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Government Return</p>
                                <p class="text-gray-600">{{ $project->ongoingDetail->government_return }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Private Party Return</p>
                                <p class="text-gray-600">{{ $project->ongoingDetail->private_party_return }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Completed Project Details --}}
            @if($project->category == 'Completed' && $project->completedDetail)
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 mb-3">
                        <i class="fas fa-check-circle mr-2 text-emerald-600"></i>
                        Completed Project Details
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Project Scope</p>
                            <p class="text-gray-600">{{ $project->completedDetail->scope }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Cost Financing Mix</p>
                                <p class="text-gray-600">{{ $project->completedDetail->cost_financing_mix }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Project Timeline</p>
                                <p class="text-gray-600">{{ $project->completedDetail->project_timeline }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Financial Benefits to Government</p>
                            <p class="text-gray-600">{{ $project->completedDetail->expected_financial_benefits_to_government }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Metadata --}}
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex gap-6 text-xs text-gray-500">
                    <div>
                        <i class="far fa-calendar-alt mr-1"></i>
                        Created: {{ $project->created_at->format('F d, Y ') }}
                    </div>
                    <div>
                        <i class="far fa-clock mr-1"></i>
                        Last Updated: {{ $project->updated_at->format('F d, Y ') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection