@extends('layouts.app')

@section('title', 'PPP Unit KP - Organizational Structure')

@section('content')
<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Organogram
            </h1>
            <div class="w-20 h-1.5 bg-background-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Organizational Structure Banner" class="w-full h-full object-cover">
</section>

<!-- Organogram Section -->
<section class="py-16 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
      
        
        <div class="flex justify-center">
            <div class="relative rounded-lg overflow-hidden shadow-lg group w-full max-w-4xl">
                <img src="{{ asset('images/Line-Organizational-Structure-1.jpg') }}" 
                     alt="PPP Unit Organogram" 
                     class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105 rounded-lg">
                <div class="absolute inset-0 overlay-primary-dark opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ asset('images/Line-Organizational-Structure-1.jpg') }}" 
               download="PPP-Department-Organogram.jpg" 
               class="inline-flex items-center px-6 py-3 bg-accent-1 text-white font-medium rounded-md hover:bg-accent-2 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Organogram
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@vite([
'resources/js/home-animate.js'
])
@endpush