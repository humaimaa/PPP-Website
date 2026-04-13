@extends('layouts.app')

@section('title', 'PPP Department KPK - Photo Gallery')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Photo Gallery</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4 max-w-2xl mx-auto">
                Explore moments from our PPP projects, events, and initiatives across Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=400&fit=crop" alt="Gallery Banner" class="w-full h-full object-cover">
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        @php
            $albums = [
                [
                    'id' => 1,
                    'title' => 'PPP Investment Summit 2024',
                    'description' => 'Annual investment summit bringing together investors, government officials, and industry leaders to discuss PPP opportunities in KPK.',
                    'cover_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400&h=300&fit=crop',
                    'date' => 'June 22, 2024',
                    'image_count' => 24,
                    'event_location' => 'Peshawar',
                ],
                [
                    'id' => 2,
                    'title' => 'Mardan Medical Complex Inauguration',
                    'description' => 'Opening ceremony of the state-of-the-art 500-bed healthcare facility serving northern KPK.',
                    'cover_image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=400&h=300&fit=crop',
                    'date' => 'May 15, 2024',
                    'image_count' => 18,
                    'event_location' => 'Mardan',
                ],
                [
                    'id' => 3,
                    'title' => 'Peshawar Rapid Transit - Construction Progress',
                    'description' => 'Documenting the progress of the transformative mass transit project connecting major city centers.',
                    'cover_image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=400&h=300&fit=crop',
                    'date' => 'April 28, 2024',
                    'image_count' => 32,
                    'event_location' => 'Peshawar',
                ],
                [
                    'id' => 4,
                    'title' => 'KPK Agri-Tech Expo 2024',
                    'description' => 'Showcasing modern agricultural technologies and innovations for farmers across the province.',
                    'cover_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop',
                    'date' => 'March 10, 2024',
                    'image_count' => 28,
                    'event_location' => 'Abbottabad',
                ],
                [
                    'id' => 5,
                    'title' => 'Swat Hydropower Project Completion',
                    'description' => 'Celebrating the completion of the 150MW clean energy project benefiting 200,000 households.',
                    'cover_image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=400&h=300&fit=crop',
                    'date' => 'February 20, 2024',
                    'image_count' => 15,
                    'event_location' => 'Swat',
                ],
                [
                    'id' => 6,
                    'title' => 'International PPP Conference',
                    'description' => 'Knowledge sharing and collaboration with international PPP experts and practitioners.',
                    'cover_image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=400&h=300&fit=crop',
                    'date' => 'January 25, 2024',
                    'image_count' => 22,
                    'event_location' => 'Islamabad',
                ],
            ];
            
            // Pagination
            $currentPage = request()->get('page', 1);
            $perPage = 9;
            $totalAlbums = count($albums);
            $lastPage = ceil($totalAlbums / $perPage);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedAlbums = array_slice($albums, $offset, $perPage);
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($paginatedAlbums as $album)
            <div class="group cursor-pointer" onclick="window.location='{{ route('gallery.album', $album['id']) }}'">
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden h-64">
                        <img src="{{ $album['cover_image'] }}" 
                             alt="{{ $album['title'] }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy">
                        
                        <!-- Overlay with image count -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-[#0A612B] text-white px-4 py-2 rounded-full flex items-center">
                                <i class="fas fa-images mr-2"></i>
                                {{ $album['image_count'] }} Photos
                            </div>
                        </div>
                        
                        <!-- Category/Tag -->
                        <div class="absolute top-4 left-4 bg-[#0A612B] text-white px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $album['date'] }}
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#0D2818] mb-2 group-hover:text-[#0A612B] transition-colors duration-300">
                            {{ $album['title'] }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ $album['description'] }}
                        </p>
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-map-marker-alt text-[#0A612B] mr-1"></i>
                                {{ $album['event_location'] }}
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-images text-[#0A612B] mr-1"></i>
                                {{ $album['image_count'] }} photos
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Albums Found</h3>
                <p class="text-gray-500">No photo albums available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($totalAlbums > $perPage)
        @include('layouts.partials.pagination', [
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'total' => $totalAlbums,
            'perPage' => $perPage,
            'routeName' => 'gallery.index'
        ])
        @endif
    </div>
</section>

@endsection