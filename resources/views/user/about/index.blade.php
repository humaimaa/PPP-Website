@extends('layouts.app')

@section('title', 'PPP Unit KP - About Us')

@section('content')

<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                About PPP Unit
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="About Us Banner" class="w-full h-full object-cover">
</section>


<!-- Overview Section -->
<section class="py-10 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            
            <div class="lg:w-1/2">
                <div class="space-y-6 text-justify leading-relaxed">
                    
                    <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-6">
                        Overview
                    </h2>

<p class="text-lg text-text-muted">
    The Public Private Partnership (PPP) Support Unit, established under the Planning & Development Department, Government of Khyber Pakhtunkhwa, serves as a specialized mechanism for promoting and facilitating PPP projects across the province.
</p>

<p class="text-lg text-text-muted">
    The Unit provides technical, financial, legal, and institutional support to the PPP Committee, PPP Unit, and departmental PPP Nodes. It assists in identifying, evaluating, and developing viable PPP opportunities while promoting private sector participation in public infrastructure and service delivery.
</p>

<p class="text-lg text-text-muted">
    The PPP Support Unit ensures that projects are legally, technically, and financially feasible, comply with the PPP Act and procurement regulations, and safeguard the interests of the Government of Khyber Pakhtunkhwa.
</p>

<p class="text-lg text-text-muted">
    Through specialized expertise and capacity-building initiatives, the Unit supports the development of sustainable and bankable PPP projects that contribute to the province's economic growth and development objectives.
</p>
                </div>
            </div>

            <div class="lg:w-1/2">
                <div class="relative rounded-lg overflow-hidden shadow-lg h-75 md:h-100">
                    <img src="{{ asset('images/project-2.jpg') }}" alt="PPP Unit Overview" class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- History Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-8 sm:px-18 lg:px-32">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green">Our History</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
        </div>
        <div class="space-y-6 text-text-muted text-justify">
            <p class="text-lg">
                The PPP Unit was established in 2014 following the enactment of the Khyber Pakhtunkhwa Public-Private 
                Partnership Act, which provided the legal framework for private sector participation in public infrastructure 
                projects.
            </p>
            <p class="text-lg">
                Our first major project, the Peshawar Rapid Transit System, was launched in 2015 and set the standard for 
                future PPP initiatives in the province. Since then, we have successfully facilitated over 50 projects 
                across various sectors with a total investment exceeding $2 billion.
            </p>
            <p class="text-lg">
                In 2020, the department underwent significant restructuring to enhance its capacity for project development 
                and implementation, establishing specialized units for different sectors and introducing digital platforms 
                for greater transparency.
            </p>
        </div>
    </div>
</section>



<!-- Core Values Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Core Values</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">The principles that guide our work and partnerships</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $values = [
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Transparency', 'desc' => 'Open and honest communication in all our dealings'],
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Innovation', 'desc' => 'Embracing new ideas and creative solutions'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Excellence', 'desc' => 'Striving for the highest quality in everything we do'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Partnership', 'desc' => 'Building strong collaborative relationships']
                ];
            @endphp

            @foreach($values as $value)
            <div class="text-center p-6 rounded-lg bg-background-light/30 hover:bg-background-light/50 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                <div class="w-16 h-16 bg-accent-1/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-accent-1/20 transition-all duration-300">
                    <svg class="w-8 h-8 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text-green mb-2">{{ $value['title'] }}</h3>
                <p class="text-text-muted text-sm">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


@endsection