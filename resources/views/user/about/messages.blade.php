@extends('layouts.app')

@section('title', 'PPP Unit KP - Leadership Messages')

@section('content')
<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Leadership Messages
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/leadership.jpg') }}" alt="Leadership Messages Banner" class="w-full h-full object-cover">
</section>

<!-- Messages Section -->
<section class="py-16 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        
        @php
            // Define hierarchy order based on enum values (excluding Chief Minister)
            $hierarchyOrder = [
                'Chief Secretary',
                'Additional Chief Secretary Development / Chairman of PDF Committee',
                'Secretary P&D / Chairman of PPP Unit',
                'Chief PPP'
            ];
            
            // Filter out Chief Minister and sort messages by hierarchy
            $filteredMessages = $messages->filter(function($message) {
                return $message->designation !== 'Chief Minister / Chairman of PPP Committee';
            });
            
            // Sort messages by hierarchy
            $sortedMessages = $filteredMessages->sortBy(function($message) use ($hierarchyOrder) {
                $position = array_search($message->designation, $hierarchyOrder);
                return $position === false ? 999 : $position;
            });
        @endphp
        
        @forelse($sortedMessages as $message)
        <!-- Message Card -->
        <div class="mb-8 last:mb-0">
            <div class="bg-background-light/30 rounded-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 {{ $loop->first ? 'border-l-4 border-accent-1' : '' }}">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div class="md:w-1/3 lg:w-1/4">
                        <div class="h-64 md:h-full w-full overflow-hidden">
                            @if($message->image && file_exists(public_path('storage/' . $message->image)))
                                <img src="{{ asset('storage/' . $message->image) }}" 
                                     alt="{{ $message->name }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                                    <div class="text-center p-4">
                                        <svg class="w-20 h-20 text-accent-1 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <p class="text-text-secondary text-sm">No Image Available</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="md:w-2/3 lg:w-3/4 p-6 md:p-8">
                        <!-- Designation Badge -->
                        <div class="inline-block mb-4">
                            <span class="px-4 py-1.5 rounded-full text-sm font-semibold bg-primary text-white">
                                {{ $message->designation }}
                            </span>
                        </div>
                        
                        <!-- Name -->
                        <h2 class="text-xl md:text-2xl font-bold text-text-green mb-4">
                            {{ formatTitle( Str::title($message->name) ) }}
                        </h2>

                        
                        <!-- Message with line break support -->
                        <div class="text-text-muted leading-relaxed text-sm md:text-md lg:text-base text-justify space-y-4 mb-4">
                            {!! nl2br(e($message->message)) !!}
                        </div>
                        
                        <!-- Quote Icon -->
                        <div class="flex justify-end">
                            <svg class="w-10 h-10 text-accent-1/30" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- No Messages Found -->
        <div class="text-center py-16 bg-background-light/20 rounded-xl">
            <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-text-green mb-2">No Messages Available</h3>
            <p class="text-text-muted text-sm md:text-md lg:text-base">Leadership messages will be displayed here soon.</p>
        </div>
        @endforelse

    </div>
</section>
@endsection

@push('scripts')
@vite([
'resources/js/home-animate.js'
])
@endpush