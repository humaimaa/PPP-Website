@extends('layouts.app')

@section('title', 'PPP Unit KP - Events & Photo Gallery')

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Events & Photo Gallery
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/events.jpg') }}" alt="Gallery Banner" class="w-full h-full object-cover">
</section>

<!-- Events Section -->
<section class="py-16 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        
  
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
            <div class="group cursor-pointer" onclick="window.location='{{ route('media.room.events.gallery', $event->id) }}'">
                <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200/30">
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
                            <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-6xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay with image count -->
                        <div class="absolute inset-0 overlay-primary-dark opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-accent-1 text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold">
                                <i class="fas fa-images mr-2"></i>
                                {{ $event->gallery_count }} {{ Str::plural('Photo', $event->gallery_count) }}
                            </div>
                        </div>
                        
                        <!-- Date Badge -->
                        <div class="absolute top-4 left-4 bg-accent-1 text-white px-3 py-1.5 rounded-full text-xs font-medium">
                            <i class="fas fa-calendar-alt mr-1"></i> 
                            {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                        </div>
                        
                        <!-- Featured Badge -->
                        @if($thumbnail && $thumbnail->is_thumbnail)
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-text-green mb-2 line-clamp-1 group-hover:text-accent-1 transition-colors duration-300">
                            {{ formatTitle( Str::title($event->title) ) }}
                        </h3>
                        <p class="text-text-muted text-sm mb-3 line-clamp-3 leading-normal">
                            {{ Str::limit($event->description ?? 'No description available.', 100) }}
                        </p>
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-200/30">
                            <div class="flex items-center text-text-muted text-sm">
                                <i class="fas fa-map-marker-alt text-accent-1 mr-1.5"></i>
                                {{ $event->location ?? 'Location TBA' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 bg-background-white rounded-lg border border-gray-200/30">
                <i class="fas fa-images text-6xl text-text-muted mb-4"></i>
                <h3 class="text-2xl font-bold text-text-green mb-2">No Events Found</h3>
                <p class="text-text-muted text-sm md:text-md lg:text-base">No events or photo albums available at the moment. Please check back later.</p>
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