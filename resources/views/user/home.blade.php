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
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 md:mt-28 text-text-primary animate-text-fade-in-up">
                Public Private Partnership Unit
            </h1>
            <p class="text-sm md:text-lg mb-8 text-text-secondary animate-text-fade-in-up animation-delay-200">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta eos quia repudiandae iusto, voluptas ratione harum architecto iste molestiae facere neque explicabo hic! Aspernatur sapiente placeat voluptatibus necessitatibus reiciendis dignissimos!
            </p>
        </div>
    </div>

    <!-- Scroll Down Arrow -->
    <div id="scroll-down-arrow" class="absolute bottom-8 left-4 md:left-8 cursor-pointer z-30">
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
                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex items-end p-3 lg:p-6">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-lg p-2 mr-20 md:p-4 md:mr-10 lg:mr-2 transition-all duration-300 hover:bg-white/15 hover:-translate-y-1">
                        <h3 class="text-md lg:text-lg font-semibold text-text-primary pr-2">PPP Department Headquarters</h3>
                        <p class="text-xs text-text-secondary lg:text-sm">Peshawar, Khyber Pakhtunkhwa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-first md:order-last py-10 px-12 md:px-12 bg-background-primary/5 flex justify-center items-center">
            <div class="w-full about-content">
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

<!-- Departmental Leadership Section - Dynamic -->
<section class="py-12 bg-gradient-to-br from-primary to-primary-light text-text-primary">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Departmental Leadership</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
        </div>
        
        @if($leadershipMessage)
        <div class="flex flex-col lg:flex-row items-center justify-center gap-8">
            <!-- Leader's Photo -->
            <div class="lg:w-1/3">
                <div class="relative rounded-lg overflow-hidden shadow-2xl">
                    <img src="{{ $leadershipMessage->image ? asset('storage/' . $leadershipMessage->image) : asset('images/boy.jpg') }}" 
                         alt="{{ $leadershipMessage->name }}" 
                         class="w-full h-96 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                        <h3 class="text-2xl font-bold text-text-primary">{{ $leadershipMessage->name }}</h3>
                        <p class="text-accent-1">{{ $leadershipMessage->designation }}</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold">Message from the {{ $leadershipMessage->designation }}</h3>
                    <p class="text-text-secondary leading-relaxed">
                        {{ $leadershipMessage->message }}
                    </p>
                    <div class="mt-6">
                        <div class="flex flex-col space-y-2 text-text-secondary">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <span>ceo@ppp.kp.gov.pk</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                                </svg>
                                <span>+92 91 921 1234 Ext: 101</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Stats Section -->
<section class="w-full py-10 px-12 md:px-12 bg-background-white" id="stats-section">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4 animate-on-scroll-title">Our Impact in Numbers</h2>
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
            <div class="text-center p-5 md:p-8 rounded-xl bg-background-primary border border-background-primary/10 transition-all duration-300 hover:-translate-y-2 hover:bg-white/10 hover:border-accent-1/50 hover:shadow-lg">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-accent-1 mb-3" data-count="{{ $stat['count'] }}">0</div>
                <p class="text-text-muted text-sm md:text-base font-medium animate-on-scroll-text">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sectors Section - Dynamic from Database (4 per row) -->
<section class="pt-10 w-full bg-background-light" id="sectors-section">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green animate-on-scroll-title">Our Project Sectors</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            @foreach($sectors as $sector)
            <div class="sector-card relative h-64 overflow-hidden rounded-lg shadow-md group w-full">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-primary/30 to-transparent z-10"></div>
                <img src="{{ asset('storage/' . $sector->img) }}" alt="{{ $sector->name }} Sector"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 z-20 flex flex-col items-center justify-end text-center p-5">
                    <h3 class="text-xl lg:text-2xl font-bold text-text-primary transition-all duration-400">{{ $sector->name }}</h3>
                    <p class="text-text-secondary text-sm mt-2 max-w-[90%] opacity-0 translate-y-5 transition-all duration-400 group-hover:opacity-100 group-hover:translate-y-0">{{ $sector->tagline }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pitchbook Section -->
<section class="py-10 bg-background-white w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-4 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black animate-on-scroll-title">Our Pitchbook</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto mt-4"></div>
        </div>
        <div class="flex justify-center items-center w-full">
            <a href="{{ url('/pitchbook') }}" class="inline-block transition-all duration-300 hover:scale-105 hover:-translate-y-1">
                <img src="{{ asset('images/Pitchbook-Cover.png') }}" alt="Pitchbook Icon" 
                    class="w-60 h-40 md:w-90 md:h-50 drop-shadow-lg hover:drop-shadow-xl">
            </a>
        </div>
    </div>
</section>

<!-- Vision Message Section -->
<section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/msg-img.jpg') }}" alt="Background" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-accent-3/70"></div>
    <div class="relative z-10 px-4 mx-auto text-center md:px-6 lg:px-8 max-w-7xl">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold leading-tight text-text-primary sm:text-4xl md:text-5xl md:leading-snug animate-on-scroll-title">
                Our Vision for Sustainable Development
            </h2>
            <p class="mt-6 text-md leading-relaxed text-text-primary md:text-xl md:leading-relaxed animate-on-scroll-text">
                We are committed to fostering public-private partnerships that drive innovation, infrastructure
                development, and economic growth across Khyber Pakhtunkhwa.
            </p>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="bg-background-white" id="map-section">
    <div class="container-fluid px-4 sm:px-6 lg:px-8 bg-background-gray/10 py-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary animate-on-scroll-title">Projects Distribution Across Khyber Pakhtunkhwa</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto mt-4"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto animate-on-scroll-text">Click on any division to view its projects and details</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Map Container -->
            <div class="w-full lg:w-1/2 z-10">
                <div id="kp-choropleth-map" class="overflow-hidden h-96 md:h-[500px]"
                    style="background-color: transparent; cursor: default;"></div>
            </div>

            <!-- Projects Stats Panel -->
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
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-96 overflow-y-auto pr-1">
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

                        <h4 class="font-semibold mb-2 text-sm text-text-black">Projects by Sector</h4>
                        <div id="sector-chart" class="mb-4" style="height: 200px;"></div>

                        <h4 class="font-semibold mb-2 text-sm text-text-black">Project Details</h4>
                        <div id="division-projects-list" class="space-y-2 max-h-60 overflow-y-auto pr-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section - Dynamic from Database -->
<section class="py-10 bg-background-light" id="news-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green animate-on-scroll-title">News & Updates</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestNews as $news)
            <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="h-48 overflow-hidden bg-background-primary/10">
                    @if($news->pdf_path)
                        <div class="w-full h-full flex items-center justify-center bg-background-primary/5">
                            <svg class="w-16 h-16 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-primary-light">
                            <span class="text-text-primary text-lg font-semibold">{{ $news->type }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="text-sm text-accent-1 font-medium">{{ $news->created_at->format('F d, Y') }}</span>
                        <span class="mx-2 text-text-muted">|</span>
                        <span class="text-sm text-text-muted">{{ $news->type }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-text-black mb-3 line-clamp-2">{{ $news->title }}</h3>
                    <p class="text-text-muted mb-4 line-clamp-3">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                    <a href="{{ route('news.show', $news->id) }}"
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

        @if($latestNews->count() > 0)
        <div class="pt-8 flex justify-center">
            <a href="{{ route('media.room.updates') }}"
                class="inline-block rounded-lg text-text-primary text-sm uppercase tracking-widest bg-accent-1 py-3 px-8 hover:bg-accent-2 transition-all duration-300 hover:scale-105">
                More Updates
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Our Partners Section with Scrolling Logos -->
<section class="py-12 bg-background-gray/10 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black mb-4">Our Trusted Partners</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto rounded-full"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">Collaborating with leading organizations to drive sustainable development in Khyber Pakhtunkhwa</p>
        </div>

        <!-- Infinite scrolling logo carousel -->
        <div class="relative">
            <div class="logo-scroll-container overflow-hidden">
                <div class="logo-track flex items-center gap-12 md:gap-16">
                    <!-- First set of logos -->
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Infosys_logo.png/800px-Infosys_logo.png" alt="Infosys" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/1200px-Google_2015_logo.svg.png" alt="Google" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Microsoft_logo.svg/800px-Microsoft_logo.svg.png" alt="Microsoft" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d3/Starbucks_Corporation_Logo_2011.svg/1200px-Starbucks_Corporation_Logo_2011.svg.png" alt="Starbucks" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/1200px-IBM_logo.svg.png" alt="IBM" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png" alt="Instagram" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Pepsi_logo_2014.svg/1200px-Pepsi_logo_2014.svg.png" alt="Pepsi" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/BMW.svg/1200px-BMW.svg.png" alt="BMW" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    
                    <!-- Duplicate set for seamless loop -->
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Infosys_logo.png/800px-Infosys_logo.png" alt="Infosys" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/1200px-Google_2015_logo.svg.png" alt="Google" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Microsoft_logo.svg/800px-Microsoft_logo.svg.png" alt="Microsoft" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d3/Starbucks_Corporation_Logo_2011.svg/1200px-Starbucks_Corporation_Logo_2011.svg.png" alt="Starbucks" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/1200px-IBM_logo.svg.png" alt="IBM" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png" alt="Instagram" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Pepsi_logo_2014.svg/1200px-Pepsi_logo_2014.svg.png" alt="Pepsi" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/BMW.svg/1200px-BMW.svg.png" alt="BMW" class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @vite([ 
        'resources/js/kp-map.js',
        'resources/js/home-animate.js'
    ])
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush