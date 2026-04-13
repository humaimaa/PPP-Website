@extends('layouts.app')

@section('title', 'PPP Department KPK - Project Details')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Project Details</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4">Comprehensive information about our PPP initiatives</p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Project Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('projects.index', 'all') }}" class="text-[#0A612B] hover:text-[#0D2818] inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-[400px] overflow-hidden">
                    <img src="{{ asset('images/project-2.jpg') }}" alt="Project Image" class="w-full h-full object-cover">
                </div>
                
                <div class="p-8">
                    <div class="flex flex-wrap justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-2">Project Name Here</h1>
                            <div class="flex items-center space-x-4">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Category</span>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium capitalize">Status</span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 text-right">
                            <p class="text-2xl font-bold text-[#0A612B]">$XX Million</p>
                            <p class="text-sm text-gray-500">Total Investment</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-[#0D2818] mb-2">Project Timeline</h3>
                            <p class="text-gray-600"><strong>Start Date:</strong> January 2023</p>
                            <p class="text-gray-600"><strong>Expected Completion:</strong> December 2024</p>
                            
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-[#0D2818] mb-2">Key Partners</h3>
                            <p class="text-gray-600">Private Partner Consortium</p>
                            <p class="text-gray-600">Government Departments</p>
                            <p class="text-gray-600">International Development Agencies</p>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#0D2818] mb-4">Project Overview</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Detailed project description will be displayed here. This section provides comprehensive information about the project's objectives, scope, and expected outcomes.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Additional information about implementation strategy, stakeholder engagement, and community benefits will be included in this section.
                        </p>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#0D2818] mb-4">Key Achievements</h2>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#0A612B] mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Achievement milestone 1</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#0A612B] mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Achievement milestone 2</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-[#0A612B] mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">Achievement milestone 3</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-[#DAD7CD]/30 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-[#0D2818] mb-3">For More Information</h3>
                        <p class="text-gray-700 mb-4">For detailed project documents or inquiries, please contact our project management office.</p>
                        <a href="{{ route('contact') }}" class="inline-block px-6 py-2 bg-[#0A612B] text-white rounded-md hover:bg-[#0D2818] transition duration-300">
                            Contact Project Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection