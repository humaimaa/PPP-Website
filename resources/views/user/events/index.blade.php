@extends('layouts.app')

@section('title', 'PPP Unit KPK - Events & Photo Gallery')

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">Events & Photo Gallery</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                Explore moments from our PPP projects, events, and initiatives across Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=400&fit=crop" alt="Gallery Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
            <div class="group cursor-pointer" onclick="window.location='{{ route('media.room.events.gallery', $event->id) }}'">
                <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Image Container -->
                    <div class="relative overflow-hidden h-64">
                        @if($event->thumbnail_url)
                            <img src="{{ $event->thumbnail_url }}" 
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-6xl"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay with image count -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-accent-1 text-text-primary px-4 py-2 rounded-full flex items-center">
                                <i class="fas fa-images mr-2"></i>
                                {{ $event->galleries_count }} {{ Str::plural('Photo', $event->galleries_count) }}
                            </div>
                        </div>
                        
                        <!-- Date Badge -->
                        <div class="absolute top-4 left-4 bg-accent-1 text-text-primary px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-calendar-alt mr-1"></i> 
                            {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-text-green mb-2 group-hover:text-accent-1 transition-colors duration-300">
                            {{ $event->title }}
                        </h3>
                        <p class="text-text-muted text-sm mb-3 line-clamp-2">
                            {{ Str::limit($event->description ?? 'No description available.', 100) }}
                        </p>
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-background-light">
                            <div class="flex items-center text-text-muted text-sm">
                                <i class="fas fa-map-marker-alt text-accent-1 mr-1"></i>
                                {{ $event->location ?? 'Location TBA' }}
                            </div>
                            <div class="flex items-center text-text-muted text-sm">
                                <i class="fas fa-images text-accent-1 mr-1"></i>
                                {{ $event->galleries_count }} {{ Str::plural('photo', $event->galleries_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-images text-6xl text-text-muted mb-4"></i>
                <h3 class="text-2xl font-semibold text-text-green mb-2">No Events Found</h3>
                <p class="text-text-muted">No events or photo albums available at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($events->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</section>

@endsection