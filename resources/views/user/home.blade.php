@extends('layouts.app')

@section('title', 'PPP Department KPK - Home')

@section('content')
<!-- Hero Slider Section -->
<section class="hero-slider relative h-[70vh] md:h-[90vh] overflow-hidden">
    <div class="hero-slides relative h-full w-full">
        <!-- Slide 1 -->
        <div class="hero-slide absolute inset-0 z-10 hidden"
            style="background: url('{{ asset('images/hero-img-1.jpg') }}') no-repeat center center; background-size: cover;">
            <div class="absolute inset-0 bg-[#5c5d5c]/50 flex items-center justify-center">
                <div class="slide-content text-center px-4 max-w-4xl">
                    <h1 class="slide-heading text-3xl md:text-5xl font-bold mb-6 text-white">Infrastructure Development
                    </h1>
                    <p class="slide-text text-xl mb-8 text-white">Building roads, hospitals, and schools through
                        collaborative partnerships</p>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide absolute inset-0 z-10"
            style="background: url('{{ asset('images/hero-img-3.jpg') }}') no-repeat center center; background-size: cover;">
            <div class="absolute inset-0 bg-[#5c5d5c]/50 flex items-center justify-center">
                <div class="slide-content text-center px-12 max-w-4xl lg:px-6">
                    <h1 class="slide-heading text-3xl md:text-5xl font-bold mb-6 text-white">Promoting Sustainable
                        Development</h1>
                    <p class="slide-text text-lg lg:text-xl mb-8 text-white">Public-Private Partnerships for
                        infrastructure and economic growth in Khyber Pakhtunkhwa</p>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide absolute inset-0 z-10 hidden"
            style="background: url('{{ asset('images/hero-img-2.jpg') }}') no-repeat center center; background-size: cover;">
            <div class="absolute inset-0 bg-[#5c5d5c]/50 flex items-center justify-center">
                <div class="slide-content text-center px-4 max-w-4xl">
                    <h1 class="slide-heading text-3xl md:text-5xl font-bold mb-6 text-white">Economic Growth</h1>
                    <p class="slide-text text-xl mb-8 text-white">Creating opportunities for investment and job creation
                        across KPK</p>
                </div>
            </div>
        </div>
    </div>

    <button
        class="slider-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/50 hover:bg-[#0A612B] text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button
        class="slider-next absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/50 hover:bg-[#0A612B] text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <div class="slider-dots absolute bottom-8 left-0 right-0 flex justify-center space-x-2 z-20">
        <button class="slide-dot w-3 h-3 rounded-full bg-white bg-opacity-50 transition-colors duration-300"
            data-index="0"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white bg-opacity-50 transition-colors duration-300"
            data-index="1"></button>
        <button class="slide-dot w-3 h-3 rounded-full bg-white bg-opacity-50 transition-colors duration-300"
            data-index="2"></button>
    </div>
</section>

<!-- About Section -->
<section class="bg-[#DAD7CD]/50" id="about-section">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="py-10 px-12 flex justify-center items-center w-full">
            <div class="relative overflow-hidden shadow-lg w-full">
                <img src="{{ asset('images/about-us-img.jpg') }}" alt="PPP Department KPK Headquarters"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#5c5d5c]/20 flex items-end p-3 lg:p-6">
                    <div class="bg-white/90 backdrop-blur-sm p-2 mr-20 md:p-4 md:mr-10 rounded lg:mr-2">
                        <h3 class="text-md lg:text-lg font-semibold text-[#0D2818] pr-2">PPP Department Headquarters
                        </h3>
                        <p class="text-xs text-gray-600 lg:text-sm">Peshawar, Khyber Pakhtunkhwa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:order-first bg-gray-50 py-10 px-12 md:px-12 flex justify-center items-center">
            <div class="w-full">
                <div class="w-24 h-2 bg-[#0A612B] mb-4"></div>
                <h2 class="font-display font-bold text-2xl md:text-3xl lg:text-4xl mb-4 text-[#0D2818]">About PPP
                    Department KPK</h2>
                <p class="text-gray-600 text-sm md:text-base mb-4 leading-normal text-justify">
                    The Public-Private Partnership (PPP) Department of Khyber Pakhtunkhwa is a pioneering initiative by
                    the Government of KPK to foster collaboration between the public and private sectors for sustainable
                    development.
                </p>
                <p class="text-gray-600 text-sm md:text-base mb-4 leading-normal text-justify">
                    Established under the Khyber Pakhtunkhwa Public-Private Partnership Act, our department serves as
                    the nodal agency for planning, facilitating, and implementing PPP projects across various sectors
                    including infrastructure, health, education, and transportation.
                </p>
                <ul class="space-y-3 text-gray-600 mb-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Promoting private sector participation in public
                            projects</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Ensuring transparent and competitive bidding processes</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Facilitating infrastructure development across KPK</span>
                    </li>
                </ul>
                <a href="{{ route('about', 'overview') }}"
                    class="inline-block border-2 border-[#0A612B] font-light text-[#0A612B] text-sm uppercase tracking-widest py-3 px-8 hover:bg-[#0A612B] hover:text-white transition duration-300">
                    Read more
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="py-10 bg-white w-full" id="projects-section">
    <div class="w-full px-0">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Our Project Categories</h2>
            <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 min-[550px]:grid-cols-2 lg:grid-cols-3 gap-0 w-full">
            <div class="project-category-card transport-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1601758003122-53c40e686a19" alt="Transportation Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Transportation</h3>
                </div>
            </div>

            <div
                class="project-category-card healthcare-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118" alt="Healthcare Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Health</h3>
                </div>
            </div>

            <div class="project-category-card education-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1" alt="Education Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Education</h3>
                </div>
            </div>

            <div class="project-category-card tourism-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e" alt="Tourism Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Tourism</h3>
                </div>
            </div>

            <div class="project-category-card water-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1509316785289-025f5b846b35"
                    alt="Water Infrastructure Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Water Infrastructure</h3>
                </div>
            </div>

            <div class="project-category-card urban-card relative h-64 overflow-hidden cursor-pointer group w-full">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70 z-10"></div>
                <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df" alt="Urban Development Projects"
                    class="w-full h-full object-cover absolute group-hover:scale-105 transition-transform duration-600">
                <div class="relative z-20 h-full flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white lg:text-2xl">Urban Development</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pitchbook Section -->
<section class="pb-10 bg-white w-full">
    <div class="w-full px-0">
        <div class="text-center mb-4 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Our Pitchbook</h2>
            <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
        </div>
        <div class="flex justify-center items-center w-full">
            <a href="{{ route('pitchbook') }}" class="inline-block">
                <img src="{{ asset('images/pitchbook-Cover.png') }}" alt="Pitchbook Icon" 
                    class="w-60 h-40 md:w-90 md:h-50 transition-all duration-300 hover:scale-105  cursor-pointer">

            </a>
        </div>


    </div>
</section>

<!-- Message Section -->
<section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/msg-img.jpg') }}" alt="Background" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-[#0A612B]/40"></div>
    <div class="relative z-10 px-4 mx-auto text-center md:px-6 lg:px-8 max-w-7xl">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold leading-tight text-white sm:text-4xl md:text-5xl md:leading-snug">
                Our Vision for Sustainable Development
            </h2>
            <p class="mt-6 text-md leading-relaxed text-white md:text-xl md:leading-relaxed">
                We are committed to fostering public-private partnerships that drive innovation, infrastructure
                development, and economic growth across Khyber Pakhtunkhwa.
            </p>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="py-10 bg-[#f8f9fa]" id="news-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">News & Updates</h2>
            <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $newsItems = [
            ['title' => 'Signing Ceremony for New Infrastructure Project', 'date' => 'June 15, 2023', 'category' =>
            'Announcement', 'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca', 'id' => 1, 'desc'
            => 'The PPP Department signed an agreement with private partners for the construction of a new highway
            connecting Peshawar to Chitral.'],
            ['title' => 'Groundbreaking of New Tertiary Care Hospital', 'date' => 'May 28, 2023', 'category' =>
            'Healthcare', 'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216', 'id' => 2, 'desc'
            => 'Construction begins on a 500-bed specialized healthcare facility in Mardan under the PPP model.'],
            ['title' => '10 New Model Schools Under PPP Framework', 'date' => 'April 10, 2023', 'category' =>
            'Education', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644', 'id' => 3, 'desc' =>
            'The department announced the establishment of 10 new model schools across KPK, with private sector partners
            managing operations.'],
            ];
            @endphp

            @foreach($newsItems as $news)
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 overflow-hidden">
                    <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="text-sm text-[#0A612B] font-medium">{{ $news['date'] }}</span>
                        <span class="mx-2 text-gray-400">|</span>
                        <span class="text-sm text-gray-500">{{ $news['category'] }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-[#0D2818] mb-3">{{ $news['title'] }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $news['desc'] }}</p>
                    <a href="{{ url('news/' . $news['id']) }}"
                        class="text-[#0A612B] font-medium hover:text-[#0D2818] transition-colors duration-300 inline-flex items-center">
                        Read More
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pt-8 flex justify-center">
            <a href="#"
                class="inline-block rounded-lg text-white text-sm uppercase tracking-widest bg-[#0A612B] py-3 px-8 hover:bg-[#074d22] transition duration-300">
                More News
            </a>
        </div>
    </div>
</section>

<!-- KP Projects Interactive Map Section -->
<section class="py-10 bg-white" id="map-section">
    <div class="container-fluid px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Projects Distribution Across Khyber Pakhtunkhwa
            </h2>
            <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Click on any division to view its projects and details</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Map Container - 50% width, increased height, no panning -->
            <div class="w-full lg:w-1/2 z-10">
                <div id="kp-choropleth-map" class="overflow-hidden h-100  md:h-160"
                    style=" background-color: transparent; cursor: default;"></div>
            </div>

            <!-- Projects Stats Panel - 50% width, white background with gray shadow -->
            <div class="w-full lg:w-1/2">
                <div id="stats-panel"
                    class="bg-white shadow-lg rounded-lg p-6 transition-all duration-300 h-full border border-gray-100">
                    <!-- Default View (No Division Selected) -->
                    <div id="default-view">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <h3 class="text-xl font-bold text-gray-800">Projects Overview</h3>
                            <button id="reset-view"
                                class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded transition">Show
                                All</button>
                        </div>

                        <!-- Stats Cards - 3 in a row -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="total-projects">0</div>
                                <div class="text-sm text-gray-600 mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="total-investment">0</div>
                                <div class="text-sm text-gray-600 mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="total-divisions">7</div>
                                <div class="text-sm text-gray-600 mt-1">Divisions</div>
                            </div>
                        </div>

                        <h4 class="font-semibold mb-3 text-lg text-gray-800">All Divisions</h4>
                        <div id="divisions-grid"
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-[400px] overflow-y-auto pr-1">
                        </div>
                    </div>

                    <!-- Division Detail View (Initially Hidden) -->
                    <div id="division-view" class="hidden">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <h3 class="text-xl font-bold text-gray-800" id="division-title"></h3>
                            <button id="back-to-all"
                                class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded transition">Back
                                to All</button>
                        </div>

                        <!-- Stats Cards - 3 in a row -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="division-total-projects">0</div>
                                <div class="text-sm text-gray-600 mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="division-total-investment">0</div>
                                <div class="text-sm text-gray-600 mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-green-700" id="division-avg-cost">0</div>
                                <div class="text-sm text-gray-600 mt-1">Avg Project Cost (Cr)</div>
                            </div>
                        </div>

                        <!-- Status Cards - 3 in a row -->
                        <div class="grid grid-cols-3 gap-2 text-center text-sm mb-4">
                            <div class="bg-green-50 rounded p-2">
                                <div class="font-bold text-green-700 text-lg" id="division-active">0</div>
                                <div class="text-xs text-gray-600">Active</div>
                            </div>
                            <div class="bg-blue-50 rounded p-2">
                                <div class="font-bold text-blue-700 text-lg" id="division-completed">0</div>
                                <div class="text-xs text-gray-600">Completed</div>
                            </div>
                            <div class="bg-orange-50 rounded p-2">
                                <div class="font-bold text-orange-700 text-lg" id="division-planned">0</div>
                                <div class="text-xs text-gray-600">Planned</div>
                            </div>
                        </div>

                        <!-- Pie Chart by Sector -->
                        <h4 class="font-semibold mb-2 text-sm text-gray-800">Projects by Sector</h4>
                        <div id="sector-chart" class="mb-4" style="height: 200px;"></div>

                        <!-- Project List -->
                        <h4 class="font-semibold mb-2 text-sm text-gray-800">Project Details</h4>
                        <div id="division-projects-list" class="space-y-2 max-h-[250px] overflow-y-auto pr-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
     @vite([ 'node_modules/leaflet/dist/leaflet.css' , 'node_modules/leaflet/dist/leaflet.js'
    , 'node_modules/chart.js/dist/chart.umd.js' , 'resources/js/kp-map.js' ])<!-- Leaflet CSS and JS (local) -->
    <link rel="stylesheet" href="{{ asset('node_modules/leaflet/dist/leaflet.css') }}" />
    <script src="{{ asset('node_modules/leaflet/dist/leaflet.js') }}"></script>

    <!-- Chart.js (local) -->
    <script src="{{ asset('node_modules/chart.js/dist/chart.umd.js') }}"></script>

    <!-- Include the map JavaScript file -->
    @vite(['resources/js/kp-map.js'])
    <style>
        /* Division grid cards styling */
        #divisions-grid .bg-white\/10 {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        #divisions-grid .bg-white\/10 .text-white {
            color: #1f2937;
        }

        #divisions-grid .bg-white\/10 .text-green-400 {
            color: #15803d;
        }

        #divisions-grid .bg-white\/10 .text-gray-300 {
            color: #6b7280;
        }

        #divisions-grid .bg-white\/10 .text-gray-400 {
            color: #9ca3af;
        }

        #divisions-grid .bg-white\/10 .text-gray-500 {
            color: #6b7280;
        }

        #divisions-grid .bg-white\/10:hover {
            background-color: #f3f4f6;
        }

        /* Division detail project list items */
        #division-projects-list .bg-white\/10 {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        #division-projects-list .bg-white\/10 .text-white {
            color: #1f2937;
        }

        #division-projects-list .bg-white\/10 .text-gray-300 {
            color: #6b7280;
        }

        #division-projects-list .bg-white\/10 .text-green-400 {
            color: #15803d;
        }

        #division-projects-list .bg-white\/10 .text-blue-400 {
            color: #1d4ed8;
        }

        #division-projects-list .bg-white\/10 .text-orange-400 {
            color: #c2410c;
        }

        /* Hover tooltip styles */
        .group:hover .group-hover\:block {
            display: block !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.4);
        }

        /* Leaflet map container - disable panning/dragging */
        .leaflet-container {
            cursor: default !important;
        }

        .leaflet-grab {
            cursor: default !important;
        }

        /* Hide zoom controls */
        .leaflet-control-zoom {
            display: none !important;
        }

        /* Disable map dragging */
        .leaflet-container:active {
            cursor: default;
        }
    </style>
    @endpush