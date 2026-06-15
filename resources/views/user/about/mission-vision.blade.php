@extends('layouts.app')

@section('title', 'PPP Unit KP - Mission & Vision')

@section('content')

<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Mission & Vision
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Mission & Vision Banner" class="w-full h-full object-cover">
</section>

<!-- Vision & Mission Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <div class="lg:w-1/2 overflow-hidden">
                <div class="relative rounded-lg overflow-hidden shadow-lg h-75 md:h-125">
                    <img src="{{ asset('images/project-6.jpg') }}" alt="Vision and Mission" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-primary/20 flex items-end p-6">
                        <div class="bg-white/90 backdrop-blur-sm p-4 rounded">
                            <h3 class="text-lg font-semibold text-text-green">Building a Better KP Together</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 overflow-hidden">
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Vision</h2>
                        <p class="text-lg text-text-muted">
                            To be the leading enabler of sustainable development in Khyber Pakhtunkhwa through innovative 
                            public-private partnerships that deliver world-class infrastructure and services to our citizens.
                        </p>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Mission</h2>
                        <p class="text-lg text-text-muted mb-4">
                            To facilitate and promote private sector participation in public infrastructure and service delivery 
                            through transparent, competitive, and mutually beneficial partnerships.
                        </p>
                        <ul class="space-y-3 text-text-muted">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Create an enabling environment for PPP projects</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Ensure value for money in all partnerships</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Promote innovation and efficiency in service delivery</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection