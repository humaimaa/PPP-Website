@extends('layouts.app')

@section('title', 'PPP Unit KP - Events & Photo Gallery')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Events & Photo Gallery</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/events.jpg') }}" alt="Gallery Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Results Count -->
        @if($events->total() > 0)
            <p class="text-sm text-text-muted mb-4">
                Showing {{ $events->firstItem() }} - {{ $events->lastItem() }} of {{ $events->total() }} events
            </p>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
            <div class="group cursor-pointer" onclick="window.location='{{ route('media.room.events.gallery', $event->id) }}'">
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden h-64">
                        @php
                            $thumbnailUrl = null;
                            // Load gallery relationship for this event
                            $eventGallery = $event->gallery;
                            // Try to find thumbnail marked image
                            $thumbnail = $eventGallery->firstWhere('is_thumbnail', true);
                            if ($thumbnail) {
                                $thumbnailUrl = asset('storage/' . $thumbnail->image);
                            } else {
                                // If no thumbnail marked, get the first image
                                $firstImage = $eventGallery->first();
                                if ($firstImage) {
                                    $thumbnailUrl = asset('storage/' . $firstImage->image);
                                }
                            }
                        @endphp
                        
                        @if($thumbnailUrl)
                            <img src="{{ $thumbnailUrl }}" 
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-600 to-green-400 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-6xl"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay with image count -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-orange-500 text-white px-4 py-2 rounded-full flex items-center">
                                <i class="fas fa-images mr-2"></i>
                                {{ $event->gallery_count }} {{ Str::plural('Photo', $event->gallery_count) }}
                            </div>
                        </div>
                        
                        <!-- Date Badge -->
                        <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-calendar-alt mr-1"></i> 
                            {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                        </div>
                        
                        <!-- Featured Badge -->
                        @if($thumbnail && $thumbnail->is_thumbnail)
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white px-2 py-1 rounded-md text-xs">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-xl line-clamp-1 font-bold text-gray-800 mb-2 group-hover:text-orange-600 transition-colors duration-300">
                            {{formatTitle( Str::title($event->title) )}}
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            {{ Str::limit($event->description ?? 'No description available.', 100) }}
                        </p>
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-map-marker-alt text-orange-500 mr-1"></i>
                                {{ $event->location ?? 'Location TBA' }}
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-images text-orange-500 mr-1"></i>
                                {{ $event->gallery_count }} {{ Str::plural('photo', $event->gallery_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-images text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Events Found</h3>
                <p class="text-gray-500">No events or photo albums available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
        
        <!-- ===== PAGINATION ===== -->
        @if($events->hasPages())
            @include('layouts.partials.pagination', [
                'currentPage' => $events->currentPage(),
                'lastPage' => $events->lastPage(),
                'total' => $events->total(),
                'perPage' => $events->perPage(),
                'routeName' => 'media.room.events',
                'params' => request()->except('page') // Preserve all query parameters except page
            ])
        @endif
    </div>
</section>

@endsection