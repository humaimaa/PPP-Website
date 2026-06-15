@extends('layouts.app')

@section('title', 'PPP Unit KP - Home')

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
         <!-- Scroll Down Arrow - Sidcup Style (White, Left Side) -->
         <div id="arrow" class="absolute bottom-8 left-4 md:left-8 cursor-pointer z-30">
            <div class="arrow-circle w-10 h-10 md:w-14 md:h-14 border-2 border-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-white group">
                 <svg class="arrow-icon w-5 h-5 md:w-7 md:h-7 text-white group-hover:text-[#0A612B] transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <img src="{{ asset('images/about-us-img.jpg') }}" alt="PPP Unit KP Headquarters"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-linear-to-t from-primary/80 to-transparent flex items-end p-3 lg:p-6">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-lg p-2 mr-20 md:p-4 md:mr-10 lg:mr-2 transition-all duration-300 hover:bg-white/15 hover:-translate-y-1">
                        <h3 class="text-md lg:text-lg font-semibold text-text-primary pr-2">PPP Unit Headquarters</h3>
                        <p class="text-xs text-text-secondary lg:text-sm">Peshawar, Khyber Pakhtunkhwa</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-first md:order-last py-10 px-12 md:px-12 bg-background-primary/5 flex justify-center items-center">
            <div class="w-full about-content">
                <div class="w-24 h-2 bg-accent-1 mb-4 rounded"></div>
                <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl mb-4 text-text-black">About PPP Unit KP</h2>
                <p class="text-text-muted text-sm md:text-base mb-4 leading-normal text-justify">
                    The Public-Private Partnership (PPP) Department of Khyber Pakhtunkhwa is a pioneering initiative by
                    the Government of KP to foster collaboration between the public and private sectors for sustainable
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
                        <span class="text-sm md:text-base">Facilitating infrastructure development across KP</span>
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

<!-- Departmental Leadership Section - Dynamic from Database (Chief Minister) -->
<section class="py-12 bg-linear-to-br from-primary to-primary-light text-text-primary">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Message from Leadership</h2>
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
                    <div class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-black/80 to-transparent p-6">
                        <h3 class="text-2xl font-bold text-text-primary">{{ $leadershipMessage->name }}</h3>
                        <p class="text-accent-1">{{ $leadershipMessage->designation }}</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold">Message from the {{ $leadershipMessage->designation }}</h3>
                    <p class="text-text-secondary text-justify leading-relaxed">
                        {{ $leadershipMessage->message }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Sectors Section - Dynamic from Database (4 per row) -->
<section class="pt-10 w-full bg-background-light" id="sectors-section">
    <div class="w-full px-0">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green animate-on-scroll-title">Our Project Sectors</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 min-[550px]:grid-cols-2 lg:grid-cols-4 gap-0 w-full">
            @foreach($sectors as $sector)
            <div class="sector-card relative h-64 overflow-hidden group w-full">
                <!-- Gradient overlay - changes on hover to lighter green -->
                <div class="absolute inset-0 z-10 transition-all duration-500" 
                     style="background: linear-gradient(to top, rgba(13, 38, 23, 0.8), rgba(13, 38, 23, 0.4));"></div>
                <div class="absolute inset-0 z-10 transition-all duration-500 opacity-0 group-hover:opacity-100" 
                     style="background: linear-gradient(to top, rgba(26, 58, 40, 0.95), rgba(179, 147, 57, 0.3), rgba(13, 38, 23, 0.6));"></div>
                
                <img src="{{ asset('storage/' . $sector->img) }}" alt="{{ $sector->name }} Sector"
                    class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                
                <div class="absolute inset-0 z-20 flex flex-col items-center justify-center text-center p-5">
                    <h3 class="text-xl lg:text-2xl font-bold text-text-primary transition-all duration-400 group-hover:-translate-y-2 group-hover:text-white">{{ $sector->name }}</h3>
                    <p class="text-text-secondary text-sm  mt-2 max-w-[80%] opacity-0 translate-y-5 transition-all duration-400 group-hover:opacity-100 group-hover:translate-y-0 group-hover:text-gray-200">{{ $sector->tagline }}</p>
                </div>
            </div>
            @endforeach
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

<!-- News Section - Dynamic from Database using existing route (with images) -->
<section class="py-10 bg-background-white" id="news-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black animate-on-scroll-title">News & Updates</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestNews as $news)
            <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="h-48 overflow-hidden bg-background-primary/10">
                    @if($news->img_path)
                        <!-- Show the update's image if available -->
                        <img src="{{ Storage::url($news->img_path) }}" alt="{{ $news->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @elseif($news->pdf_path)
                        <!-- Fallback: PDF icon -->
                        <div class="w-full h-full flex items-center justify-center bg-background-primary/5">
                            <svg class="w-16 h-16 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @else
                        <!-- Final fallback: gradient with type text -->
                        <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-primary to-primary-light">
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
                    <a href="{{ url('/media-room/updates/' . $news->id) }}"
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
            <a href="{{ url('/media-room/updates') }}"
                class="inline-block rounded-lg text-text-primary text-sm uppercase tracking-widest bg-accent-1 py-3 px-8 hover:bg-accent-2 transition-all duration-300 hover:scale-105">
                More Updates
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Our Partners Section with Scrolling Logos -->
<section class="py-12 bg-background-white overflow-hidden">
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
                    <!-- Original set of logos -->
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_1.jpeg') }}" alt="Partner 1" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_2.jpeg') }}" alt="Partner 2" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_3.png') }}" alt="Partner 3" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_4.png') }}" alt="Partner 4" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_5.jpeg') }}" alt="Partner 5" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>

                    <!-- Duplicate set for seamless loop -->
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_1.jpeg') }}" alt="Partner 1" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_2.jpeg') }}" alt="Partner 2" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_3.png') }}" alt="Partner 3" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_4.png') }}" alt="Partner 4" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_5.jpeg') }}" alt="Partner 5" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    
                    <!-- Third set for smoother infinite scroll -->
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_1.jpeg') }}" alt="Partner 1" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_2.jpeg') }}" alt="Partner 2" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_3.png') }}" alt="Partner 3" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_4.png') }}" alt="Partner 4" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
                    </div>
                    <div class="partner-logo shrink-0">
                        <img src="{{ asset('images/partner_5.jpeg') }}" alt="Partner 5" class="partner-img h-20 md:h-28 w-auto transition-all duration-300 opacity-80 hover:opacity-100">
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