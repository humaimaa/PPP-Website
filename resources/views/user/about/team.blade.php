@extends('layouts.app')

@section('title', 'PPP Unit KP - Our Team')

@section('content')
<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Our Team
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/team.jpg') }}" alt="Team Banner" class="w-full h-full object-cover">
</section>

@php
    // Separate team members by hierarchy
    $leadershipMembers = collect();
    $otherMembers = collect();
    
    foreach ($team as $member) {
        $order = $member->hierarchy->order ?? 999;
        
        // Check if this is a leadership member (order 1)
        if ($order == 1) {
            $leadershipMembers->push($member);
        } else {
            $otherMembers->push($member);
        }
    }
    
    // Sort leadership members by ID (to show Chief first, then Assistant Chief)
    $leadershipMembers = $leadershipMembers->sortBy('id')->values();
    
    // Get chief (first leadership member) and assistant chief (second leadership member)
    $chief = $leadershipMembers->first();
    $assistantChief = $leadershipMembers->get(1); // Second leadership member
    
    // Group other members by hierarchy_id for section display
    $groupedMembers = $otherMembers->groupBy('hierarchy_id');
    
    // Sort groups by the hierarchy order
    $groupedMembers = $groupedMembers->sortBy(function($members) {
        return $members->first()->hierarchy->order ?? 999;
    });
    
    // Sort members within each group by ID (oldest first)
    foreach ($groupedMembers as $key => $group) {
        $groupedMembers[$key] = $group->sortBy('id')->values();
    }
@endphp

<!-- Leadership Section (Chief and Assistant Chief) -->
@if($leadershipMembers->isNotEmpty())
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text-green animate-on-scroll-title">Executives</h2>
            <div class="w-20 h-1.5 bg-accent-1 mx-auto mt-4 rounded"></div>
           
        </div>

        <div class="flex flex-wrap justify-center gap-8 max-w-3xl mx-auto">
            @foreach($leadershipMembers as $leadershipMember)
            <div class="bg-background-white rounded-lg overflow-hidden shadow-lg border border-gray-200/30 transition-all duration-300 hover:shadow-xl  w-full {{ $leadershipMembers->count() > 1 ? 'md:w-[calc(30%-1rem)]' : 'md:w-[calc(40%)]' }}">
                <div class="relative">
                    <div class="h-80 overflow-hidden">
                        <img src="{{ $leadershipMember->img ? asset('storage/' . $leadershipMember->img) : asset('images/boy.jpg') }}"
                             alt="{{ $leadershipMember->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                        <h3 class="text-2xl font-bold text-white">{{ formatTitle( Str::title($leadershipMember->name) ) }}</h3>
                        <p class="text-accent-1 text-lg font-semibold mt-1">{{ formatTitle( Str::title($leadershipMember->designation ?? 'Leadership') ) }}</p>
                    </div>
                </div>
                <div class="p-5">
                    @if($leadershipMember->email)
                    <div class="flex items-center justify-center space-x-2 text-text-muted">
                        <svg class="w-5 h-5 text-accent-1 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <span class="break-all text-sm">{{ $leadershipMember->email }}</span>
                    </div>
                    @endif
                    @if($leadershipMember->phone)
                    <div class="flex items-center justify-center space-x-2 text-text-muted mt-1">
                        <svg class="w-5 h-5 text-accent-1 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                        </svg>
                        <span class="text-sm">{{ $leadershipMember->phone }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Other Team Members by Hierarchy -->
@foreach($groupedMembers as $hierarchyId => $members)
@php
    $hierarchy = $members->first()->hierarchy;
    $hierarchyTitle = $hierarchy->title ?? 'Team Members';
    $hierarchyOrder = $hierarchy->order ?? 999;
    $loopIndex = $loop->index;

    // Create strip effect - alternate between gray and white
    $bgClass = ($loopIndex % 2 == 0) ? 'bg-background-light' : 'bg-background-white';
    
    // Card styling based on hierarchy order
    $isOfficerStyle = ($hierarchyOrder == 2);  // Research Officers
    $isAnalystStyle = ($hierarchyOrder == 3 || $hierarchyOrder == 4);  // Specialists and Analysts
@endphp

<section class="py-10 {{ $bgClass }} transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text-green animate-on-scroll-title">{{ $hierarchyTitle }}</h2>
            <div class="w-20 h-1.5 bg-accent-1 mx-auto mt-4 rounded"></div>
            @if($hierarchy->description)
            <p class="text-text-muted mt-4 max-w-2xl mx-auto text-sm md:text-md lg:text-base">{{ $hierarchy->description }}</p>
            @endif
        </div>

        <!-- Grid with flex to center when fewer cards -->
        <div class="flex flex-wrap justify-center -mx-3">
            @foreach($members as $member)
                <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
                    @if($isOfficerStyle)
                    {{-- Research Officer Style Card (Order 2) --}}
                    <div class="bg-background-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 h-full">
                        <div class="h-56 overflow-hidden">
                            <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                                 alt="{{ $member->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-text-green mb-1">{{ formatTitle( Str::title($member->name) ) }}</h3>
                            <p class="text-accent-1 font-semibold text-sm mb-2">{{ formatTitle( Str::title($member->designation ?? 'Team Member') ) }}</p>
                            @if($member->email)
                            <a href="mailto:{{ $member->email }}"
                               class="text-accent-1 hover:text-primary transition-colors duration-300 text-xs break-all inline-flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                {{ Str::limit($member->email, 30) }}
                            </a>
                            @endif
                        </div>
                    </div>

                    @elseif($isAnalystStyle)
                    {{-- Specialist/Analyst Style Card (Order 3 & 4) --}}
                    <div class="bg-background-white rounded-lg shadow-md p-5 text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 h-full">
                        <div class="w-29 h-29 mx-auto mb-3 rounded-full overflow-hidden bg-background-light">
                            <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                                 alt="{{ $member->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <h3 class="text-base font-bold text-text-green mb-1">{{ formatTitle( Str::title($member->name) ) }}</h3>
                        <p class="text-accent-1 text-xs font-medium mb-2">{{ formatTitle( Str::title($member->designation ?? 'Team Member') ) }}</p>
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}"
                           class="inline-block text-accent-1 hover:text-primary transition-colors duration-300 text-xs break-all">
                            {{ Str::limit($member->email, 30) }}
                        </a>
                        @endif
                    </div>
                    @else
                    {{-- Default Style Card --}}
                    <div class="bg-background-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 h-full">
                        <div class="h-56 overflow-hidden">
                            <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                                 alt="{{ $member->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-text-green mb-1">{{ formatTitle( Str::title($member->name) ) }}</h3>
                            <p class="text-accent-1 font-semibold text-sm mb-2">{{ formatTitle( Str::title($member->designation ?? 'Team Member') ) }}</p>
                            @if($member->email)
                            <a href="mailto:{{ $member->email }}"
                               class="text-accent-1 hover:text-primary transition-colors duration-300 text-xs break-all inline-flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                {{ Str::limit($member->email, 30) }}
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Empty state -->
@if($team->isEmpty())
<section class="py-20 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl text-center">
        <svg class="w-24 h-24 mx-auto text-text-muted mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-text-green mb-2">Team Members Coming Soon</h3>
        <p class="text-text-muted text-sm md:text-md lg:text-base max-w-md mx-auto">Information about our dedicated team members will be available shortly.</p>
    </div>
</section>
@endif

@endsection

@push('scripts')
@vite([
'resources/js/home-animate.js'
])
@endpush