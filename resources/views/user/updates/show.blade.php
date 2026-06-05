@extends('layouts.app')

@section('title', $news->title . ' - PPP Department KPK')

@section('content')

<!-- Page Header -->
<section class="relative h-[50vh] md:h-[60vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center">
        <div class="text-center px-4 max-w-4xl">
            <!-- Type Badge -->
            <div class="inline-block mb-4">
                <span class="px-4 py-1.5 rounded-full text-sm font-semibold bg-accent-1 text-text-primary">
                    {{ $news->type ?? 'News' }}
                </span>
            </div>
            <!-- Title with word wrap and line clamp for long titles -->
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-4 break-words hyphens-auto">
                {{ $news->title }}
            </h1>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
            <!-- Date -->
            <p class="text-white/80 text-sm md:text-base mt-4">
                {{ $news->created_at->format('F d, Y') }}
            </p>
        </div>
    </div>
    @if($news->img_path)
        <img src="{{ asset('storage/' . $news->img_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    @elseif($news->featured_image)
        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
            <div class="text-center">
                <svg class="w-20 h-20 text-white/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span class="text-white text-2xl md:text-4xl font-bold">{{ $news->type ?? 'News' }}</span>
            </div>
        </div>
    @endif
</section>

<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm overflow-x-auto whitespace-nowrap">
                <a href="{{ route('home') }}" class="text-text-muted hover:text-accent-1 transition-colors">Home</a>
                <span class="mx-2 text-text-muted">/</span>
                <a href="{{ route('media.room.updates') }}" class="text-text-muted hover:text-accent-1 transition-colors">News & Updates</a>
                <span class="mx-2 text-text-muted">/</span>
                <span class="text-accent-1 truncate">{{ Str::limit($news->title, 50) }}</span>
            </nav>

            <!-- News Header Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <!-- Title (repeated for better readability) -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-text-black mb-4 break-words">
                    {{ $news->title }}
                </h1>
                
                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center text-text-muted">
                        <svg class="w-5 h-5 mr-2 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $news->created_at->format('F d, Y') }}
                        @if($news->created_at != $news->updated_at)
                            <span class="ml-2 text-xs text-text-muted">(Updated: {{ $news->updated_at->format('F d, Y') }})</span>
                        @endif
                    </div>
                    <div class="flex items-center text-text-muted">
                        <svg class="w-5 h-5 mr-2 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                        {{ $news->type ?? 'News' }}
                    </div>
                    <div class="flex items-center text-text-muted">
                        <svg class="w-5 h-5 mr-2 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ $news->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- Short Description/Excerpt (if content is long) -->
            @php
                $firstParagraph = strip_tags($news->content);
                $excerpt = Str::limit($firstParagraph, 200);
                $hasLongContent = strlen($firstParagraph) > 300;
            @endphp
            
            @if($hasLongContent)
            <div class="mb-6 p-4 bg-background-light/20 rounded-lg border-l-4 border-accent-1">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-accent-1 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="text-sm font-semibold text-accent-1">Summary</span>
                        <p class="text-text-muted text-sm mt-1 leading-relaxed">{{ $excerpt }}...</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- News Content -->
            <div class="prose prose-lg max-w-none text-text-muted">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- PDF Download (if available) -->
            @if($news->pdf_path)
            <div class="mt-8 p-6 bg-background-gray/10 rounded-lg">
                <h3 class="text-lg font-semibold text-text-black mb-3 flex items-center">
                    <svg class="w-6 h-6 text-accent-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Attachments
                </h3>
                <a href="{{ asset('storage/' . $news->pdf_path) }}" download
                    class="inline-flex items-center text-accent-1 hover:text-primary transition-colors group">
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-6 4h6m-6 0H6"></path>
                    </svg>
                    Download PDF Document
                    <span class="text-xs text-text-muted ml-2">({{ $news->pdf_path ? 'PDF File' : '' }})</span>
                </a>
            </div>
            @endif

            <!-- Share Section -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-text-black mb-3">Share this update:</h3>
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="p-2 bg-gray-100 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="p-2 bg-gray-100 rounded-full hover:bg-blue-400 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($news->title) }}" 
                       target="_blank"
                       class="p-2 bg-gray-100 rounded-full hover:bg-blue-700 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Navigation between posts -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(isset($previousNews))
                    <a href="{{ route('media.room.updates.show', $previousNews->id) }}"
                        class="group p-4 bg-background-light/10 rounded-lg hover:bg-background-light/20 transition-all duration-300">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-accent-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-text-muted">Previous</p>
                                <p class="text-sm font-medium text-text-black group-hover:text-accent-1 transition-colors line-clamp-1">
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
                        class="group p-4 bg-background-light/10 rounded-lg hover:bg-background-light/20 transition-all duration-300 md:text-right">
                        <div class="flex items-center md:flex-row-reverse">
                            <svg class="w-5 h-5 ml-3 text-accent-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-text-muted">Next</p>
                                <p class="text-sm font-medium text-text-black group-hover:text-accent-1 transition-colors line-clamp-1">
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
                <div class="text-center mt-6">
                    <a href="{{ route('media.room.updates') }}"
                        class="inline-flex items-center text-accent-1 hover:text-primary transition-colors group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 12l6-6m-6 6l6 6"></path>
                        </svg>
                        Back to all updates
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection