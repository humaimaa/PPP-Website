@extends('layouts.app')

@section('title', 'PPP Department KPK - Home')

@section('content')
<!-- Hero Video Section -->
<section class="hero-video-section relative h-screen overflow-hidden">
    <!-- Background Video -->
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="{{ asset('videos/video-1.mp4') }}" type="video/mp4">
        <img src="{{ asset('images/hero-fallback.jpg') }}" alt="Background" class="w-full h-full object-cover">
    </video>
    
    <!-- Overlay that fades on scroll -->
    <div class="absolute inset-0 bg-black/50 transition-opacity duration-500" id="heroOverlay"></div>
    
    <!-- Center Text Content -->
    <div class="absolute inset-0 flex items-center justify-center z-10">
        <div class="text-center px-4 max-w-4xl">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 md:mt-28 animate-fade-in-up text-text-primary">
                Public Private Partnership Unit
            </h1>
            <p class="text-sm md:text-lg mb-8 animate-fade-in-up animation-delay-200 text-text-secondary">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta eos quia repudiandae iusto, voluptas ratione harum architecto iste molestiae facere neque explicabo hic! Aspernatur sapiente placeat voluptatibus necessitatibus reiciendis dignissimos!
            </p>
        </div>
    </div>

    <!-- Scroll Down Arrow -->
    <div id="arrow" class="absolute bottom-8 left-4 md:left-8 cursor-pointer z-30">
        <div class="w-10 h-10 md:w-14 md:h-14 border-2 border-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-white group animate-bounce-slow">
            <svg class="w-5 h-5 md:w-7 md:h-7 text-white group-hover:text-accent-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="bg-background-white" id="about-section">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="py-10 px-12 md:px-12 flex justify-center items-center w-full bg-background-gray/20">
            <div class="relative overflow-hidden shadow-lg w-full rounded-lg group">
                <img src="{{ asset('images/about-us-img.jpg') }}" alt="PPP Department KPK Headquarters"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-linear-to-t from-primary/80 to-transparent flex items-end p-3 lg:p-6">
                    <div class="bg-white/10 backdrop-blur-[10px] border border-white/20 rounded-lg p-2 mr-20 md:p-4 md:mr-10 lg:mr-2 transition-all duration-300 hover:bg-white/15 hover:-translate-y-1">
                        <h3 class="text-md lg:text-lg font-semibold text-text-primary pr-2">PPP Department Headquarters</h3>
                        <p class="text-xs text-text-secondary lg:text-sm">Peshawar, Khyber Pakhtunkhwa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:order-first py-10 px-12 md:px-12 bg-background-primary/5 flex justify-center items-center">
            <div class="w-full">
                <div class="w-24 h-2 bg-accent-1 mb-4 rounded"></div>
                <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl mb-4 text-text-black">About PPP Department KPK</h2>
                <p class="text-text-muted text-sm md:text-base mb-4 leading-normal text-justify">
                    The Public-Private Partnership (PPP) Department of Khyber Pakhtunkhwa is a pioneering initiative by
                    the Government of KPK to foster collaboration between the public and private sectors for sustainable
                    development.
                </p>
                <p class="text-text-muted text-sm md:text-base mb-4 leading-normal text-justify">
                    Established under the Khyber Pakhtunkhwa Public-Private Partnership Act, our department serves as
                    the nodal agency for planning, facilitating, and implementing PPP projects across various sectors
                    including infrastructure, health, education, and transportation.
                </p>
                <ul class="space-y-3 text-text-muted mb-6">
                    <li class="flex items-start group">
                        <svg class="h-5 w-5 text-accent-1 mr-2 mt-1 transform transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Promoting private sector participation in public projects</span>
                    </li>
                    <li class="flex items-start group">
                        <svg class="h-5 w-5 text-accent-1 mr-2 mt-1 transform transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Ensuring transparent and competitive bidding processes</span>
                    </li>
                    <li class="flex items-start group">
                        <svg class="h-5 w-5 text-accent-1 mr-2 mt-1 transform transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm md:text-base">Facilitating infrastructure development across KPK</span>
                    </li>
                </ul>
                <button class="btn-position-aware relative inline-block font-medium text-sm uppercase tracking-wider py-3 px-8 overflow-hidden z-10 border-2 border-accent-1 text-accent-1 rounded-lg hover:text-text-primary transition-colors duration-400">
                    Read more
                    <span class="position-aware-span absolute w-0 h-0 rounded-full bg-accent-1 transition-all duration-400 -translate-x-1/2 -translate-y-1/2 z-[-1]"></span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="w-full py-10 px-12 md:px-12 bg-background-white" id="stats-section">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Impact in Numbers</h2>
            <div class="w-24 h-1 bg-accent-1 mx-auto rounded"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            @php
                $stats = [
                    ['count' => 50, 'label' => 'Projects Completed'],
                    ['count' => 25, 'label' => 'Active Projects'],
                    ['count' => 100, 'label' => 'Trusted Partners'],
                    ['count' => 500, 'label' => 'Jobs Created']
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="text-center p-5 md:p-8 rounded-xl bg-background-primary/99 border border-background-primary/10 transition-all duration-300 hover:-translate-y-2 hover:bg-white/10 hover:border-accent-1/50 hover:shadow-lg">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-accent-1 mb-3" data-count="{{ $stat['count'] }}">0</div>
                <p class="text-text-secondary text-sm md:text-base font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="pt-10 w-full" id="projects-section">
    <div class="w-full px-0">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-primary">Our Project Categories</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 min-[550px]:grid-cols-2 lg:grid-cols-3 gap-0 w-full">
            @php
                $projects = [
                    ['name' => 'Transportation', 'image' => 'https://images.unsplash.com/photo-1601758003122-53c40e686a19', 'tagline' => 'Modern roads & highways • Safe travel • Smart mobility solutions for KPK'],
                    ['name' => 'Health', 'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118', 'tagline' => 'Quality healthcare • Modern hospitals • Accessible medicine for all citizens'],
                    ['name' => 'Education', 'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', 'tagline' => 'Quality education • Modern schools • Digital learning for future generations'],
                    ['name' => 'Tourism', 'image' => 'https://images.unsplash.com/photo-1464037866556-6812c9d1c72e', 'tagline' => 'Beautiful destinations • Cultural heritage • Eco tourism development'],
                    ['name' => 'Water Infrastructure', 'image' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35', 'tagline' => 'Clean water • Modern dams • Sustainable supply for communities'],
                    ['name' => 'Urban Development', 'image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df', 'tagline' => 'Smart cities • Modern housing • Green spaces for better living']
                ];
            @endphp
            @foreach($projects as $project)
            <div class="project-category-card relative h-64 overflow-hidden cursor-pointer group w-full" data-category="{{ strtolower(str_replace(' ', '-', $project['name'])) }}">
                <div class="absolute inset-0 bg-linear-to-t from-transparent to-black/50 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                <img src="{{ $project['image'] }}" alt="{{ $project['name'] }} Projects"
                    class="w-full h-full object-cover transition-all duration-600 group-hover:scale-110 group-hover:opacity-30">
                <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center p-5">
                    <h3 class="text-xl lg:text-2xl font-bold text-text-primary transition-all duration-400 group-hover:-translate-y-2">{{ $project['name'] }}</h3>
                    <p class="text-text-primary text-sm mt-2 max-w-[80%] opacity-0 translate-y-5 transition-all duration-400 group-hover:opacity-100 group-hover:translate-y-0">{{ $project['tagline'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pitchbook Section -->
<section class="py-10 bg-background-white w-full">
    <div class="w-full px-0">
        <div class="text-center mb-4 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black">Our Pitchbook</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>
        <div class="flex justify-center items-center w-full">
            <a href="{{ url('/pitchbook') }}" class="inline-block transition-all duration-300 hover:scale-105 hover:-translate-y-1">
                <img src="{{ asset('images/Pitchbook-Cover.png') }}" alt="Pitchbook Icon" 
                    class="w-60 h-40 md:w-90 md:h-50 drop-shadow-lg hover:drop-shadow-xl">
            </a>
        </div>
    </div>
</section>

<!-- Message Section -->
<section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/msg-img.jpg') }}" alt="Background" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-accent-3/70"></div>
    <div class="relative z-10 px-4 mx-auto text-center md:px-6 lg:px-8 max-w-7xl">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold leading-tight text-text-primary sm:text-4xl md:text-5xl md:leading-snug">
                Our Vision for Sustainable Development
            </h2>
            <p class="mt-6 text-md leading-relaxed text-text-primary md:text-xl md:leading-relaxed">
                We are committed to fostering public-private partnerships that drive innovation, infrastructure
                development, and economic growth across Khyber Pakhtunkhwa.
            </p>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="py-10 bg-background-white" id="news-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black">News & Updates</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $newsItems = [
            ['title' => 'Signing Ceremony for New Infrastructure Project', 'date' => 'June 15, 2023', 'category' => 'Announcement', 'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca', 'id' => 1, 'desc' => 'The PPP Department signed an agreement with private partners for the construction of a new highway connecting Peshawar to Chitral.'],
            ['title' => 'Groundbreaking of New Tertiary Care Hospital', 'date' => 'May 28, 2023', 'category' => 'Healthcare', 'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216', 'id' => 2, 'desc' => 'Construction begins on a 500-bed specialized healthcare facility in Mardan under the PPP model.'],
            ['title' => '10 New Model Schools Under PPP Framework', 'date' => 'April 10, 2023', 'category' => 'Education', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644', 'id' => 3, 'desc' => 'The department announced the establishment of 10 new model schools across KPK, with private sector partners managing operations.'],
            ];
            @endphp

            @foreach($newsItems as $news)
            <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="text-sm text-accent-1 font-medium">{{ $news['date'] }}</span>
                        <span class="mx-2 text-text-muted">|</span>
                        <span class="text-sm text-text-muted">{{ $news['category'] }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-text-black mb-3">{{ $news['title'] }}</h3>
                    <p class="text-text-muted mb-4 line-clamp-3">{{ $news['desc'] }}</p>
                    <a href="{{ url('news/' . $news['id']) }}"
                        class="text-accent-1 font-medium hover:text-primary transition-colors duration-300 inline-flex items-center group">
                        Read More
                        <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pt-8 flex justify-center">
            <a href="{{ route('updates.index') }}"
                class="inline-block rounded-lg text-text-primary text-sm uppercase tracking-widest bg-accent-1 py-3 px-8 hover:bg-accent-2 transition-all duration-300 hover:scale-105">
                More Updates
            </a>
        </div>
    </div>
</section>

<section class=" bg-background-white" id="map-section">
    <div class="container-fluid px-4 sm:px-6 lg:px-8 bg-background-gray/10 py-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary">Projects Distribution Across Khyber Pakhtunkhwa</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">Click on any division to view its projects and details</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Map Container - 50% width, increased height, no panning -->
            <div class="w-full lg:w-1/2 z-10">
                <div id="kp-choropleth-map" class="overflow-hidden h-100 md:h-160"
                    style="background-color: transparent; cursor: default;"></div>
            </div>

            <!-- Projects Stats Panel - 50% width, white background with gray shadow -->
            <div class="w-full lg:w-1/2">
                <div id="stats-panel"
                    class="bg-background-white shadow-lg rounded-lg p-6 transition-all duration-300 h-full border border-gray-100">
                    <!-- Default View (No Division Selected) -->
                    <div id="default-view">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <h3 class="text-xl font-bold text-text-black">Projects Overview</h3>
                            <button id="reset-view"
                                class="text-xs bg-gray-100 hover:bg-gray-200 text-text-black px-3 py-1 rounded transition">Show
                                All</button>
                        </div>

                        <!-- Stats Cards - 3 in a row -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="total-projects">0</div>
                                <div class="text-sm text-text-muted mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="total-investment">0</div>
                                <div class="text-sm text-text-muted mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="total-divisions">7</div>
                                <div class="text-sm text-text-muted mt-1">Divisions</div>
                            </div>
                        </div>

                        <h4 class="font-semibold mb-3 text-lg text-text-black">All Divisions</h4>
                        <div id="divisions-grid"
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-[400px] overflow-y-auto pr-1">
                        </div>
                    </div>

                    <!-- Division Detail View (Initially Hidden) -->
                    <div id="division-view" class="hidden">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <h3 class="text-xl font-bold text-text-black" id="division-title"></h3>
                            <button id="back-to-all"
                                class="text-xs bg-gray-100 hover:bg-gray-200 text-text-black px-3 py-1 rounded transition">Back
                                to All</button>
                        </div>

                        <!-- Stats Cards - 3 in a row -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="division-total-projects">0</div>
                                <div class="text-sm text-text-muted mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="division-total-investment">0</div>
                                <div class="text-sm text-text-muted mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-3 shadow-sm">
                                <div class="text-3xl font-bold text-primary" id="division-avg-cost">0</div>
                                <div class="text-sm text-text-muted mt-1">Avg Project Cost (Cr)</div>
                            </div>
                        </div>

                        <!-- Status Cards - 3 in a row -->
                        <div class="grid grid-cols-3 gap-2 text-center text-sm mb-4">
                            <div class="bg-green-50 rounded p-2">
                                <div class="font-bold text-primary text-lg" id="division-active">0</div>
                                <div class="text-xs text-text-muted">Active</div>
                            </div>
                            <div class="bg-blue-50 rounded p-2">
                                <div class="font-bold text-primary text-lg" id="division-completed">0</div>
                                <div class="text-xs text-text-muted">Completed</div>
                            </div>
                            <div class="bg-orange-50 rounded p-2">
                                <div class="font-bold text-primary text-lg" id="division-planned">0</div>
                                <div class="text-xs text-text-muted">Planned</div>
                            </div>
                        </div>

                        <!-- Pie Chart by Sector -->
                        <h4 class="font-semibold mb-2 text-sm text-text-black">Projects by Sector</h4>
                        <div id="sector-chart" class="mb-4" style="height: 200px;"></div>

                        <!-- Project List -->
                        <h4 class="font-semibold mb-2 text-sm text-text-black">Project Details</h4>
                        <div id="division-projects-list" class="space-y-2 max-h-[250px] overflow-y-auto pr-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @vite([ 
        'node_modules/leaflet/dist/leaflet.css', 
        'node_modules/leaflet/dist/leaflet.js', 
        'node_modules/chart.js/dist/chart.umd.js', 
        'resources/js/kp-map.js',
        'resources/js/home-animate.js'
    ])
    
    <!-- Leaflet CSS and JS (local) -->
    <link rel="stylesheet" href="{{ asset('node_modules/leaflet/dist/leaflet.css') }}" />
    <script src="{{ asset('node_modules/leaflet/dist/leaflet.js') }}"></script>

    <!-- Chart.js (local) -->
    <script src="{{ asset('node_modules/chart.js/dist/chart.umd.js') }}"></script>

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