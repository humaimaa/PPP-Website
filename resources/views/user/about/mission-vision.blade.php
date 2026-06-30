@extends('layouts.app')

@section('title', 'PPP Unit KP - Mission & Vision')

@section('content')

<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-text-primary mb-3">
                Vision & Mission
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/vision-mission.jpeg') }}" alt="Mission & Vision Banner" class="w-full h-full object-cover">
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
    <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-3">
        Our Vision
    </h2>
    
    <p class="text-lg text-text-muted text-justify leading-relaxed">
        To become a leading catalyst for sustainable economic growth and infrastructure development in Khyber Pakhtunkhwa through innovative, transparent, and effective Public Private Partnerships that create long-term value for citizens and investors.
    </p>
</div>

<div>
    <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-3">
        Our Mission
    </h2>

    <p class="text-lg text-text-muted mb-3 text-justify leading-relaxed">
        To facilitate, strengthen, and promote Public Private Partnerships by providing technical, financial, legal, and institutional support for the development of sustainable, bankable, and high-impact projects that improve public services and accelerate provincial development.
    </p>

    <ul class="space-y-3 text-text-muted">

        <li class="flex items-start">
            <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span>Promote private sector participation in public projects</span>
        </li>

        <li class="flex items-start">
            <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span>Ensure transparent, efficient, and sustainable PPP processes</span>
        </li>

        <li class="flex items-start">
            <svg class="h-5 w-5 text-accent-1 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span>Deliver value-driven projects for long-term socio-economic development</span>
        </li>

    </ul>
</div>
            </div>
        </div>
    </div>
</section>

@endsection