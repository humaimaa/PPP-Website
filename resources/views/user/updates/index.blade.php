@extends('layouts.app')

@section('title', 'PPP Unit KP - News & Updates')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Updates</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
           
        </div>
    </div>
    <img src="{{ asset('images/resourse-center.jpg') }}" alt="News Banner" class="w-full h-full object-cover">
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
                    @if($news->img_path)
                        <!-- Show the update's image if available -->
                        <img src="{{ asset('storage/' . $news->img_path) }}" alt="{{ $news->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @elseif($news->featured_image)
                        <!-- Fallback to featured_image column if it exists -->
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @elseif($news->pdf_path)
                        <!-- PDF icon fallback -->
                        <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-primary to-primary-light">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5.414 5.414c.391.391.586.903.586 1.414V7c0-2.21-1.79-4-4-4H7z"></path>
                            </svg>
                        </div>
                    @else
                        <!-- Final fallback: gradient with type text -->
                        <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-primary to-primary-light">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <span class="text-white text-sm font-semibold uppercase">{{ $news->type ?? 'News' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="p-6 md:p-8 md:w-2/3 flex flex-col">
                    <div>
                        <div class="flex items-center mb-2 flex-wrap gap-2">
                            {{-- Date Logic: Show news_date if available, otherwise show created_at --}}
                            @php
    $displayDate = isset($news->news_date) && $news->news_date 
        ? \Carbon\Carbon::parse($news->news_date) 
        : ($news->created_at instanceof \Carbon\Carbon ? $news->created_at : \Carbon\Carbon::parse($news->created_at));
@endphp
<span class="text-sm text-accent-1 font-medium">
    <i class="fas fa-calendar-alt mr-1"></i>
    {{ $displayDate->format('F d, Y') }}
</span>
                            <span class="mx-2 text-text-muted hidden sm:inline">|</span>
                            <span class="text-sm text-text-muted">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $news->type ?? 'News' }}
                            </span>
                            @if($news->is_featured)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-star mr-1 text-xs"></i>
                                    Featured
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-text-black mb-3 hover:text-accent-1 transition-colors duration-300">
                            <a href="{{ route('media.room.updates.show', $news->id) }}">{{ $news->title }}</a>
                        </h3>
                        <p class="text-text-muted line-clamp-3 text-justify">{{ Str::limit(strip_tags($news->content), 150) }}</p>
                    </div>
                    <div class="mt-auto pt-4 flex justify-between items-center">
                        <div>
                            <!-- Category badge -->
                            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                                {{ $news->type ?? 'News' }}
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