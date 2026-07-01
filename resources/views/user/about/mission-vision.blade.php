@extends('layouts.app')

@section('title', 'PPP Unit KP - Mission & Vision')

@section('content')
<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Vision & Mission
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/vision-mission.jpeg') }}" alt="Mission & Vision Banner" class="w-full h-full object-cover">
</section>

<!-- Vision & Mission Section -->
<section class="py-16 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Image Section -->
            <div class="lg:w-1/3">
                <div class="relative rounded-lg overflow-hidden shadow-lg group">
                    <img src="{{ asset('images/project-6.jpg') }}" alt="Vision and Mission" 
                        class="w-full h-75 md:h-96 object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 overlay-primary-dark opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="text-white font-semibold text-sm md:text-base">Building a Better KP Together</h3>
                    </div>
                </div>
            </div>
            
            <!-- Content Section -->
            <div class="lg:w-2/3">
                <div class="space-y-8">
                    <!-- Vision -->
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-text-green mb-4">
                            Our Vision
                        </h2>
                        <p class="text-text-muted text-sm md:text-md lg:text-base text-justify leading-relaxed">
                            To become a leading catalyst for sustainable economic growth and infrastructure development in Khyber Pakhtunkhwa through innovative, transparent, and effective Public Private Partnerships that create long-term value for citizens and investors.
                        </p>
                    </div>

                    <!-- Mission -->
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-text-green mb-4">
                            Our Mission
                        </h2>
                        <p class="text-text-muted text-sm md:text-md lg:text-base text-justify leading-relaxed mb-4">
                            To facilitate, strengthen, and promote Public Private Partnerships by providing technical, financial, legal, and institutional support for the development of sustainable, bankable, and high-impact projects that improve public services and accelerate provincial development.
                        </p>

                        <ul class="space-y-3 text-text-muted">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm md:text-md lg:text-base leading-relaxed">Promote private sector participation in public projects</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm md:text-md lg:text-base leading-relaxed">Ensure transparent, efficient, and sustainable PPP processes</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-accent-1 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm md:text-md lg:text-base leading-relaxed">Deliver value-driven projects for long-term socio-economic development</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@vite([
'resources/js/home-animate.js'
])
@endpush