@extends('layouts.app')

@section('title', $news->title . ' - PPP Unit KP')

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30 max-w-5xl">
        </div>
    </div>
    
    @if($news->img_path)
        <!-- Image exists - show image -->
        <img src="{{ asset('storage/' . $news->img_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    @elseif($news->featured_image)
        <!-- Featured image exists - show image -->
        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    @else
        <!-- No image - show plain background using theme colors -->
        <div class="w-full h-full" style="background: linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary) 100%);"></div>
    @endif
</section>

<!-- News Content Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm overflow-x-auto whitespace-nowrap">
            <a href="{{ route('home') }}" class="text-text-muted hover:text-accent-1 transition-colors duration-300">Home</a>
            <span class="mx-2 text-text-muted">/</span>
            <a href="{{ route('media.room.updates') }}" class="text-text-muted hover:text-accent-1 transition-colors duration-300">News & Updates</a>
            <span class="mx-2 text-text-muted">/</span>
            <span class="text-accent-1 truncate">{{ Str::limit($news->title, 50) }}</span>
        </nav>

        <!-- News Header Section -->
        <div class="mb-8 pb-6 border-b border-gray-200/30">
            <!-- Title -->
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-text-green mb-4 break-words">
                {{ formatTitle($news->title) }}
            </h1>
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div class="flex items-center text-text-muted">
                    <svg class="w-5 h-5 mr-2 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    @php
                        $displayDate = $news->news_date ?? $news->created_at;
                        $displayDate = $displayDate instanceof \Carbon\Carbon ? $displayDate : \Carbon\Carbon::parse($displayDate);
                    @endphp
                    {{ $displayDate->format('F d, Y') }}
                </div>
                <div class="flex items-center text-text-muted">
                    <svg class="w-5 h-5 mr-2 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                    {{ $news->type ?? 'News' }}
                </div>
                <div class="flex items-center text-text-muted">
                    <svg class="w-5 h-5 mr-2 text-accent-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    @php
                        $dateForHumans = $news->news_date ?? $news->created_at;
                        $dateForHumans = $dateForHumans instanceof \Carbon\Carbon ? $dateForHumans : \Carbon\Carbon::parse($dateForHumans);
                    @endphp
                    {{ $dateForHumans->diffForHumans() }}
                </div>
                @if($news->is_featured)
                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">
                    <i class="fas fa-star mr-1 text-xs"></i>
                    Featured
                </span>
                @endif
            </div>
        </div>  

        <!-- News Content -->
        <div class="prose prose-lg max-w-none text-text-muted text-justify leading-normal">
            {!! nl2br(e($news->content)) !!}
        </div>

        <!-- Navigation between posts -->
        <div class="mt-12 pt-6 border-t border-gray-200/30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(isset($previousNews))
                <a href="{{ route('media.room.updates.show', $previousNews->id) }}"
                    class="group p-4 bg-background-light/10 rounded-lg hover:bg-background-light/20 transition-all duration-300 border border-gray-200/30 hover:border-accent-1/30">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-accent-1 group-hover:-translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <div class="min-w-0">
                            <p class="text-xs text-text-muted">Previous</p>
                            <p class="text-sm font-medium text-text-green group-hover:text-accent-1 transition-colors line-clamp-1">
                                {{ $previousNews->title }}
                            </p>
                        </div>
                    </div>
                </a>
                @else
                <div></div>
                @endif
                
                @if(isset($nextNews))
                <a href="{{ route('media.room.updates.show', $nextNews->id) }}"
                    class="group p-4 bg-background-light/10 rounded-lg hover:bg-background-light/20 transition-all duration-300 md:text-right border border-gray-200/30 hover:border-accent-1/30">
                    <div class="flex items-center md:flex-row-reverse">
                        <svg class="w-5 h-5 ml-3 text-accent-1 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        <div class="min-w-0">
                            <p class="text-xs text-text-muted">Next</p>
                            <p class="text-sm font-medium text-text-green group-hover:text-accent-1 transition-colors line-clamp-1">
                                {{ $nextNews->title }}
                            </p>
                        </div>
                    </div>
                </a>
                @else
                <div></div>
                @endif
            </div>
            
            <!-- Back to all updates button -->
            <div class="text-center mt-8">
                <a href="{{ route('media.room.updates') }}"
                    class="inline-flex items-center text-accent-1 hover:text-primary-hover transition-colors duration-300 group font-medium">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 12l6-6m-6 6l6 6"></path>
                    </svg>
                    Back to all updates
                </a>
            </div>
        </div>
    </div>
</section>

@endsection