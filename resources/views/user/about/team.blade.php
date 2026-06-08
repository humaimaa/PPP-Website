@extends('layouts.app')

@section('title', 'PPP Department KPK - Our Team')

@section('content')

<!-- Hero Section -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Our Leadership Team
            </h1>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                Meet the dedicated professionals driving public-private partnerships in Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Team Banner" class="w-full h-full object-cover">
</section>

@php
    // Separate team members by designation order
    $chief = null;
    $assistantChief = null;
    $otherMembers = collect();
    
    foreach ($team as $member) {
        $order = $member->designation->order ?? 999;
        
        if ($order == 1) {
            $chief = $member;
        } elseif ($order == 2) {
            $assistantChief = $member;
        } else {
            $otherMembers->push($member);
        }
    }
    
    // Group other members by designation_id for section display
    $groupedMembers = $otherMembers->groupBy('designation_id');
    
    // Sort groups by the designation order
    $groupedMembers = $groupedMembers->sortBy(function($members) {
        return $members->first()->designation->order ?? 999;
    });
@endphp

<!-- Departmental Leadership Section (Chief) - Order 1 -->
@if($chief)
<section class="py-12 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-text-black">Departmental Leadership</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-background-white rounded-lg overflow-hidden shadow-lg border border-gray-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="relative">
                        <img src="{{ $chief->img ? asset('storage/' . $chief->img) : asset('images/boy.jpg') }}"
                             alt="{{ $chief->name }}"
                             class="w-full h-100 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-black/80 to-transparent p-6">
                            <h3 class="text-2xl font-bold text-text-primary">{{ $chief->name }}</h3>
                            <p class="text-accent-1">{{ $chief->designation->title ?? 'Chief Executive Officer' }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($chief->email)
                        <div class="flex items-center justify-center space-x-2 text-text-black">
                            <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span class="break-all">{{ $chief->email }}</span>
                        </div>
                        @endif
                        @if($chief->phone)
                        <div class="flex items-center justify-center space-x-2 text-text-black mt-2">
                            <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                            </svg>
                            <span>{{ $chief->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Assistant Chief Section - Order 2 -->
@if($assistantChief)
<section class="py-12 bg-background-primary/5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-text-black">Assistant Chief's Office</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-background-white rounded-lg overflow-hidden shadow-lg border border-gray-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="relative">
                        <img src="{{ $assistantChief->img ? asset('storage/' . $assistantChief->img) : asset('images/boy.jpg') }}"
                             alt="{{ $assistantChief->name }}"
                             class="w-full h-100 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-black/80 to-transparent p-6">
                            <h3 class="text-2xl font-bold text-text-primary">{{ $assistantChief->name }}</h3>
                            <p class="text-accent-1">{{ $assistantChief->designation->title ?? 'Assistant Chief' }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($assistantChief->email)
                        <div class="flex items-center justify-center space-x-2 text-text-black">
                            <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span class="break-all">{{ $assistantChief->email }}</span>
                        </div>
                        @endif
                        @if($assistantChief->phone)
                        <div class="flex items-center justify-center space-x-2 text-text-black mt-2">
                            <svg class="w-5 h-5 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                            </svg>
                            <span>{{ $assistantChief->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Other Team Members by Designation -->
@foreach($groupedMembers as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Team Members';
    $designationOrder = $designation->order ?? 999;
    $memberCount = $members->count();

    // Style based on designation order
    $isOfficerStyle = ($designationOrder == 3);
    $isAnalystStyle = ($designationOrder >= 4);
    $bgClass = $isOfficerStyle ? 'bg-background-light' : 'bg-background-white';
@endphp

<section class="py-12 {{ $bgClass }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-text-black">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto mt-4"></div>
            @if($designation->description)
            <p class="text-text-muted mt-4">{{ $designation->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($members as $member)
                @if($isOfficerStyle)
                {{-- Officer Style Card (Order 3) --}}
                <div class="bg-background-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="h-64 overflow-hidden">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                             alt="{{ $member->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-text-black mb-1">{{ $member->name }}</h3>
                        <p class="text-accent-1 font-semibold mb-3">{{ $member->designation->title ?? 'Team Member' }}</p>
                        <p class="text-text-muted text-sm mb-4 line-clamp-2">{!! nl2br(e($member->experience)) !!}</p>
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}"
                           class="text-accent-1 hover:text-primary transition-colors duration-300 text-sm break-all inline-flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            {{ $member->email }}
                        </a>
                        @endif
                    </div>
                </div>

                @elseif($isAnalystStyle)
                {{-- Analyst Style Card (Order 4+) --}}
                <div class="bg-background-light rounded-lg p-6 text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="w-28 h-28 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                             alt="{{ $member->name }}"
                             class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-text-black mb-1">{{ $member->name }}</h3>
                    <p class="text-accent-1 text-sm font-medium mb-2">{{ $member->designation->title ?? 'Team Member' }}</p>
                    <p class="text-text-muted text-xs mb-3 line-clamp-2">{!! nl2br(e($member->experience)) !!}</p>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}"
                       class="inline-block text-accent-1 hover:text-primary transition-colors duration-300 text-xs break-all">
                        {{ Str::limit($member->email, 20) }}
                    </a>
                    @endif
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Empty state -->
@if($team->isEmpty())
<section class="py-20 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <svg class="w-24 h-24 mx-auto text-text-muted mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-text-black mb-2">Team Members Coming Soon</h3>
        <p class="text-text-muted">Information about our dedicated team members will be available shortly.</p>
    </div>
</section>
@endif

@endsection