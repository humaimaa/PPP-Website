@extends('layouts.app')

@section('title', 'PPP Unit KP - Organizational Structure')

@section('content')

<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Organizational Structure
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Organizational Structure Banner" class="w-full h-full object-cover">
</section>

<!-- Organogram Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green">Organizational Structure</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
            <p class="text-lg text-text-muted mt-4 max-w-3xl mx-auto">
                Our organizational structure is designed to ensure efficient decision-making and effective implementation 
                of PPP projects across Khyber Pakhtunkhwa.
            </p>
        </div>
        <div class="bg-background-light/30 p-6 rounded-lg shadow-inner">
            <div class="flex justify-center">
                <img src="{{ asset('images/Line-Organizational-Structure-1.png') }}" alt="PPP Unit Organogram" class="max-w-full h-auto rounded-lg shadow-md">
            </div>
            <div class="text-center mt-6">
                <a href="{{ asset('images/organogram.jpg') }}" download="PPP-Department-Organogram.jpg" 
                   class="inline-block px-6 py-3 bg-accent-1 text-text-primary font-medium rounded-md hover:bg-accent-2 transition duration-300">
                    Download Organogram
                </a>
            </div>
        </div>
    </div>
</section>

@endsection