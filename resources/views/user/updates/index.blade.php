@extends('layouts.app')

@section('title', 'PPP Department KPK - News & Updates')

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
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
        <h2 class="text-2xl md:text-3xl font-bold text-primary mb-8">Latest Updates</h2>

        <div class="space-y-6">
            @forelse($updates as $news)
            <!-- News Card -->
            <div
                class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row h-auto md:h-64 relative group">
                <div class="md:w-1/3 h-48 md:h-full overflow-hidden relative bg-background-primary/10">
                    @if($news->featured_image)
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @elseif($news->pdf_path)
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-primary-light">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-primary-light">
                            <span class="text-white text-xl font-bold">{{ $news->type }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-6 md:p-8 md:w-2/3 flex flex-col">
                    <div>
                        <div class="flex items-center mb-2">
                            <span class="text-sm text-accent-1 font-medium">{{ $news->created_at->format('F d, Y') }}</span>
                            <span class="mx-2 text-text-muted">|</span>
                            <span class="text-sm text-text-muted">{{ $news->type }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-text-black mb-3 hover:text-accent-1 transition-colors duration-300">
                            <a href="{{ route('media.room.updates.show', $news->id) }}">{{ $news->title }}</a>
                        </h3>
                        <p class="text-text-muted line-clamp-3 text-justify">{{ Str::limit(strip_tags($news->content), 150) }}</p>
                    </div>
                    <div class="mt-auto pt-4 flex justify-between items-center">
                        <div>
                            <!-- Optional: Add category badge -->
                            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                                {{ $news->type }}
                            </span>
                        </div>
                        <a href="{{ route('media.room.updates.show', $news->id) }}"
                            class="text-accent-1 font-medium hover:text-primary transition-colors duration-300 inline-flex items-center group">
                            Read More
                            <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
        @if($updates->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $updates->links() }}
        </div>
        @endif
    </div>
</section>

@endsection