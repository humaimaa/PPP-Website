@extends('layouts.app')

@section('title', 'PPP Department KPK - News & Updates')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Updates</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4 max-w-2xl mx-auto">
                Stay informed about the latest developments in our public-private partnership initiatives
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="News Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl md:text-3xl font-bold text-[#0D2818] mb-8">Latest Updates</h2>

        @php
        $allNews = [
        [
        'id' => 1,
        'title' => 'PPP Department Launches New Healthcare Initiative',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. The Public-Private Partnership Department of Khyber Pakhtunkhwa is proud to announce a landmark healthcare initiative that will transform medical services across the province. The department announces a new public-private partnership to build three specialized hospitals across KPK, improving healthcare access for 2 million residents.lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'image' => 'project-2.jpg',
        'date' => 'May 15, 2024',
        ],
        [
        'id' => 2,
        'title' => 'PPP Investment Summit 2024',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Join us for the annual PPP Investment Summit on June 20-22 to explore partnership opportunities in infrastructure development.',
        'image' => 'project-1.jpg',
        'date' => 'May 10, 2024',
        ],
        [
        'id' => 3,
        'title' => 'Peshawar Rapid Transit Reaches 75% Completion',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. The mass transit project is on track for December launch with major infrastructure now in place.',
        'image' => 'project-6.jpg',
        'date' => 'Apr 28, 2024',
        ],
        [
        'id' => 4,
        'title' => 'New International Partners Join KPK Development',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. Three international firms have signed agreements to invest in KPK\'s infrastructure projects worth $250 million.',
        'image' => 'project-3.jpg',
        'date' => 'Apr 15, 2024',
        ],
        [
        'id' => 5,
        'title' => 'PPP Department Wins National Excellence Award',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Recognized for innovative approaches in healthcare PPP projects that improved access in rural areas.',
        'image' => 'project-4.jpg',
        'date' => 'Mar 30, 2024',
        ],
        [
        'id' => 6,
        'title' => 'Annual PPP Impact Report 2023 Released',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. The comprehensive report details how PPP projects have contributed to KPK\'s economic growth and service delivery.',
        'image' => 'project-5.jpg',
        'date' => 'Mar 15, 2024',
        ],
        [
        'id' => 7,
        'title' => 'New Solar Power Project Announced for Southern KPK',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 100MW solar project to provide clean energy to 500,000 households in Dera Ismail Khan and surrounding areas.',
        'image' => 'project-4.jpg',
        'date' => 'Mar 5, 2024',
        ],
        [
        'id' => 8,
        'title' => 'Training Program for PPP Professionals Concludes',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 50 government officials completed intensive training on PPP project management and financial modeling.',
        'image' => 'project-1.jpg',
        'date' => 'Feb 20, 2024',
        ],
        [
        'id' => 9,
        'title' => 'KPK Water Supply Project Phase II Launched',
        'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Second phase of the provincial water supply project aims to provide clean drinking water to 500,000 more residents.',
        'image' => 'project-5.jpg',
        'date' => 'Feb 10, 2024',
        ]
        ];

        // Pagination logic
        $currentPage = request()->input('page', 1);
        $perPage = 6;
        $totalNews = count($allNews);
        $lastPage = ceil($totalNews / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedNews = array_slice($allNews, $offset, $perPage);
        @endphp

        <div class="space-y-6">
            @forelse($paginatedNews as $news)
            <!-- News Card -->
            <div
                class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row h-auto md:h-64 relative group">
                <div class="md:w-1/3 h-48 md:h-full overflow-hidden relative">
                    <img src="{{ asset('images/' . $news['image']) }}" alt="{{ $news['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-12 md:w-2/3 flex flex-col">
                    <div>
                        <h3
                            class="text-xl font-bold text-[#0D2818] mb-3 hover:text-[#0A612B] transition-colors duration-300">
                            <a href="{{ route('updates.show', $news['id']) }}">{{ $news['title'] }}</a>
                        </h3>
                        <p class="text-gray-600 line-clamp-3 text-justify">{{ $news['description'] }}</p>
                    </div>
                    <div class="mt-auto pt-4 flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $news['date'] }}
                            </span>
                        </div>
                        <a href="{{ route('updates.show', $news['id']) }}"
                            class="text-[#0A612B] font-medium hover:text-[#0D2818] transition-colors duration-300 inline-flex items-center">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">No News Found</h3>
                <p class="text-gray-500">No news articles available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($totalNews > $perPage)
        @include('layouts.partials.pagination', [
        'currentPage' => $currentPage,
        'lastPage' => $lastPage,
        'total' => $totalNews,
        'perPage' => $perPage,
        'routeName' => 'updates.index'
        ])
        @endif
    </div>
</section>

@endsection