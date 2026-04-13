@extends('layouts.app')

@section('title', 'PPP Department KPK - News Details')

@section('content')

@php
    // News data (in production, this would come from a database)
    $newsData = [
        1 => [
            'title' => 'PPP Department Launches New Healthcare Initiative',
            'category' => 'Announcement',
            'category_color' => 'blue',
            'type' => 'Announcement',
            'type_color' => 'blue',
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
            'tags' => ['Healthcare', 'Infrastructure', 'PPP Initiative']
        ],
        2 => [
            'title' => 'PPP Investment Summit 2024',
            'category' => 'Conference',
            'category_color' => 'green',
            'type' => 'Event',
            'type_color' => 'green',
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
            'tags' => ['Investment', 'Summit', 'Networking']
        ],
        // Add more news entries as needed
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
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('news.index') }}" class="text-[#0A612B] hover:text-[#0D2818] inline-flex items-center transition-colors duration-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to News
                </a>
            </div>

            <!-- News Content -->
            <article class="bg-white rounded-lg overflow-hidden">
                <!-- Header Info -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                            @if($news['type_color'] == 'blue') bg-blue-100 text-blue-600
                            @elseif($news['type_color'] == 'green') bg-green-100 text-green-600
                            @elseif($news['type_color'] == 'yellow') bg-yellow-100 text-yellow-600
                            @elseif($news['type_color'] == 'purple') bg-purple-100 text-purple-600
                            @elseif($news['type_color'] == 'red') bg-red-100 text-red-600
                            @else bg-indigo-100 text-indigo-600 @endif">
                            {{ $news['type'] }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            {{ $news['category'] }}
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i> {{ $news['date'] }}
                            </span>
                            <span>
                                <i class="far fa-clock mr-1"></i> 5 min read
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="text-gray-500 hover:text-[#0A612B] transition-colors duration-200">
                                <i class="far fa-bookmark"></i> Save
                            </button>
                            <div class="relative group">
                                <button class="text-gray-500 hover:text-[#0A612B] transition-colors duration-200">
                                    <i class="far fa-share-square"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="flex items-center gap-4 p-6 bg-gray-50 rounded-lg mb-8">
                    <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ asset('images/' . $news['author_image']) }}" alt="{{ $news['author'] }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#0D2818]">{{ $news['author'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $news['author_role'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">Published on {{ $news['date'] }}</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $news['content'] !!}
                </div>

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mt-8 pt-6 border-t border-gray-200">
                    @foreach($news['tags'] as $tag)
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full hover:bg-[#0A612B] hover:text-white transition-colors duration-300 cursor-pointer">
                        #{{ $tag }}
                    </span>
                    @endforeach
                </div>

                <!-- Share Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="font-semibold text-[#0D2818] mb-3">Share this article</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-[#1877F2] text-white rounded-full flex items-center justify-center hover:opacity-80 transition-opacity duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#1DA1F2] text-white rounded-full flex items-center justify-center hover:opacity-80 transition-opacity duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#0077B5] text-white rounded-full flex items-center justify-center hover:opacity-80 transition-opacity duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:opacity-80 transition-opacity duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-600 text-white rounded-full flex items-center justify-center hover:opacity-80 transition-opacity duration-300">
                            <i class="far fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Related News -->
            @if(count($relatedNews) > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-[#0D2818] mb-6">Related News</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedNews as $relatedId => $related)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                        <div class="h-40 overflow-hidden">
                            <img src="{{ asset('images/' . $related['image']) }}" alt="{{ $related['title'] }}" 
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-2 h-2 rounded-full 
                                    @if($related['category_color'] == 'blue') bg-blue-600
                                    @elseif($related['category_color'] == 'green') bg-green-600
                                    @elseif($related['category_color'] == 'yellow') bg-yellow-500
                                    @else bg-purple-600 @endif">
                                </span>
                                <span class="text-xs text-gray-500">{{ $related['category'] }}</span>
                            </div>
                            <h4 class="font-bold text-[#0D2818] mb-2 line-clamp-2 hover:text-[#0A612B] transition-colors duration-300">
                                <a href="{{ route('news.show', $relatedId) }}">{{ $related['title'] }}</a>
                            </h4>
                            <p class="text-xs text-gray-500">{{ $related['date'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection