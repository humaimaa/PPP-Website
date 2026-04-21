@extends('layouts.app')

@section('title', 'PPP Department KPK - News Details')

@section('content')

@php
    // News data (in production, this would come from a database)
    $newsData = [
        1 => [
            'title' => 'PPP Department Launches New Healthcare Initiative',
            'image' => 'project-2.jpg',
            'date' => 'May 15, 2024',
            'author' => 'PPP Department',
            'author_role' => 'Communications Director',
            'author_image' => 'team/officer1.jpg',
            'content' => '
                <p>The Public-Private Partnership Department of Khyber Pakhtunkhwa is proud to announce a landmark healthcare initiative that will transform medical services across the province. This new public-private partnership aims to establish three specialized hospitals in strategic locations, bringing world-class healthcare to underserved communities.</p>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Project Overview</h3>
                <p>The initiative includes the construction and operation of three state-of-the-art hospitals in Mardan, Swat, and Dera Ismail Khan. Each facility will feature:</p>
                <ul class="list-disc pl-6 my-4 space-y-2">
                    <li>300-bed capacity with expansion capability</li>
                    <li>Specialized cardiac and oncology centers</li>
                    <li>Modern diagnostic and surgical equipment</li>
                    <li>Telemedicine facilities for remote consultations</li>
                    <li>Training centers for medical professionals</li>
                </ul>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Impact on Communities</h3>
                <p>This project is expected to benefit over 2 million residents across northern and southern KPK. The hospitals will reduce travel time for specialized care and create approximately 1,500 direct jobs in the healthcare sector.</p>
                
                <div class="bg-[#DAD7CD]/30 p-6 rounded-lg my-6 border-l-4 border-[#0A612B]">
                    <p class="text-lg italic text-gray-700">"This initiative represents a significant milestone in our commitment to improving healthcare access for all citizens of Khyber Pakhtunkhwa. By leveraging private sector expertise and efficiency, we can deliver quality healthcare services more rapidly and sustainably."</p>
                    <p class="font-semibold text-[#0D2818] mt-2">- Chief Minister, Khyber Pakhtunkhwa</p>
                </div>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Partnership Structure</h3>
                <p>The PPP arrangement follows a Design-Build-Finance-Operate-Maintain (DBFOM) model with a 25-year concession period. The private partner will be responsible for construction, equipment, and operations, while the government provides land, regulatory support, and quality oversight.</p>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Timeline</h3>
                <p>The project is expected to break ground in Q3 2024, with the first hospital operational by late 2026. Requests for proposals will be issued in the coming months, with pre-qualification of interested bidders beginning next quarter.</p>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">How to Participate</h3>
                <p>Interested healthcare providers and investors can register on the PPP Department\'s procurement portal to receive updates about this opportunity. A pre-bid conference will be held on June 15, 2024, at the PPP Complex in Peshawar.</p>
            ',
        ],
        2 => [
            'title' => 'PPP Investment Summit 2024',
            'image' => 'project-1.jpg',
            'date' => 'May 10, 2024',
            'author' => 'Events Team',
            'author_role' => 'Event Coordinator',
            'author_image' => 'team/officer2.jpg',
            'content' => '
                <p>The Public-Private Partnership Department of Khyber Pakhtunkhwa is pleased to announce the annual PPP Investment Summit 2024, scheduled to take place from June 20-22 at the Pearl Continental Hotel in Peshawar.</p>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Summit Highlights</h3>
                <ul class="list-disc pl-6 my-4 space-y-2">
                    <li>Keynote speeches from international PPP experts</li>
                    <li>Panel discussions on emerging PPP sectors</li>
                    <li>Project showcase of upcoming opportunities</li>
                    <li>B2B networking sessions</li>
                    <li>Investment matching platform</li>
                </ul>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Who Should Attend</h3>
                <p>This summit is designed for:</p>
                <ul class="list-disc pl-6 my-4 space-y-2">
                    <li>International and local investors</li>
                    <li>Infrastructure developers and contractors</li>
                    <li>Financial institutions and banks</li>
                    <li>Government officials and policymakers</li>
                    <li>Legal and advisory firms</li>
                </ul>
                
                <div class="bg-[#DAD7CD]/30 p-6 rounded-lg my-6 border-l-4 border-[#0A612B]">
                    <p class="text-lg italic text-gray-700">"The PPP Investment Summit is the premier platform for connecting investors with transformative infrastructure opportunities in Khyber Pakhtunkhwa. We look forward to welcoming delegates from around the world."</p>
                    <p class="font-semibold text-[#0D2818] mt-2">- Minister for Planning & Development, KPK</p>
                </div>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Registration</h3>
                <p>Early bird registration is now open until May 30, 2024. Interested participants can register online through the PPP Department website. Limited seats are available, so early registration is encouraged.</p>
                
                <h3 class="text-xl font-bold text-[#0D2818] mt-6 mb-3">Contact Information</h3>
                <p>For summit inquiries, sponsorship opportunities, or registration assistance, please contact the Events Team at events@pppdepartmentkpk.gov.pk or call +92 91 921 1234.</p>
            ',
        ],
    ];
    
    $news = $newsData[$id] ?? $newsData[1];
    
    // Related news (excluding current)
    $relatedNews = array_filter($newsData, function($key) use ($id) {
        return $key != $id;
    }, ARRAY_FILTER_USE_KEY);
    $relatedNews = array_slice($relatedNews, 0, 3);
@endphp

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 line-clamp-2">{{ $news['title'] }}</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/' . $news['image']) }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('news.index') }}" class="text-[#0A612B] hover:text-[#0D2818] inline-flex items-center transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to News
                </a>
            </div>

            <!-- Date -->
            <div class="mb-4">
                <span class="text-sm text-gray-500">
                    <i class="far fa-calendar-alt mr-1"></i> {{ $news['date'] }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-8">{{ $news['title'] }}</h1>



            <!-- Content with Image on Right -->
            <div class="flex flex-col lg:flex-row gap-8 mb-8">
                <!-- Text Content - Left Side -->
                <div class="lg:w-2/3">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br($news['content']) !!}
                    </div>
                </div>
                
                <!-- Image - Right Side -->
                <div class="lg:w-1/3">
                    <div class="sticky top-20">
                        <div class=" overflow-hidden shadow-lg">
                            <img src="{{ asset('images/' . $news['image']) }}" alt="{{ $news['title'] }}" class="w-full h-auto object-cover">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection