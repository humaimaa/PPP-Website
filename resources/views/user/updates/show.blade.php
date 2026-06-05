@extends('layouts.app')

@section('title', $news->title . ' - PPP Department KPK')

@section('content')

<!-- Page Header -->
<section class="relative h-[50vh] md:h-[60vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/50 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $news->title }}</h1>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
        </div>
    </div>
    @if($news->featured_image)
        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
            <span class="text-white text-4xl font-bold">{{ $news->type }}</span>
        </div>
    @endif
</section>

<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm">
                <a href="{{ route('home') }}" class="text-text-muted hover:text-accent-1">Home</a>
                <span class="mx-2 text-text-muted">/</span>
                <a href="{{ route('media.room.updates') }}" class="text-text-muted hover:text-accent-1">News & Updates</a>
                <span class="mx-2 text-text-muted">/</span>
                <span class="text-accent-1">{{ Str::limit($news->title, 50) }}</span>
            </nav>

            <!-- News Meta Info -->
            <div class="mb-8 pb-4 border-b border-gray-200">
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center text-text-muted">
                        <svg class="w-5 h-5 mr-2 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $news->created_at->format('F d, Y') }}
                    </div>
                    <div class="flex items-center text-text-muted">
                        <svg class="w-5 h-5 mr-2 text-accent-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                        {{ $news->type }}
                    </div>
                </div>
            </div>

            <!-- News Content -->
            <div class="prose prose-lg max-w-none text-text-muted">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- PDF Download (if available) -->
            @if($news->pdf_path)
            <div class="mt-8 p-6 bg-background-gray/10 rounded-lg">
                <h3 class="text-lg font-semibold text-text-black mb-3">Attachments</h3>
                <a href="{{ asset('storage/' . $news->pdf_path) }}" download
                    class="inline-flex items-center text-accent-1 hover:text-primary transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-6 4h6m-6 0H6"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
            @endif

            <!-- Navigation between posts -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                @if(isset($previousNews))
                <a href="{{ route('media.room.updates.show', $previousNews->id) }}"
                    class="inline-flex items-center text-accent-1 hover:text-primary transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Previous
                </a>
                @else
                <div></div>
                @endif
                
                <a href="{{ route('media.room.updates') }}"
                    class="inline-flex items-center text-accent-1 hover:text-primary transition-colors">
                    Back to all updates
                </a>
                
                @if(isset($nextNews))
                <a href="{{ route('media.room.updates.show', $nextNews->id) }}"
                    class="inline-flex items-center text-accent-1 hover:text-primary transition-colors">
                    Next
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                @else
                <div></div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection