@extends('layouts.app')

@section('title', 'PPP Department KPK - Our Team')

@section('content')

<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Our Leadership Team
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                Meet the dedicated professionals driving public-private partnerships in Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Team Banner" class="w-full h-full object-cover">
</section>

<!-- Team Sections Grouped by Designation -->
@php
    // Group team members by designation_id and sort by designation order
    $groupedTeam = $team->groupBy(function($member) {
        return $member->designation_id;
    })->sortBy(function($members) {
        // Get the first member's designation order for sorting
        return $members->first()->designation->order ?? 999;
    });
@endphp

@foreach($groupedTeam as $designationId => $members)
@php
    // Get the designation object from the first member
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Other';
    $designationOrder = $designation->order ?? 999;
    
    // Determine card style based on designation order or title
    $cardStyle = 'default';
    if ($designationOrder == 1 || stripos($designationName, 'Chief') !== false) {
        $cardStyle = 'chief';
    } elseif ($designationOrder == 2 || stripos($designationName, 'Assistant Chief') !== false) {
        $cardStyle = 'assistant-chief';
    } elseif (stripos($designationName, 'Research Officer') !== false) {
        $cardStyle = 'research-officer';
    } elseif (stripos($designationName, 'Research Analyst') !== false) {
        $cardStyle = 'research-analyst';
    } else {
        $cardStyle = 'default';
    }
@endphp

<section class="py-12 {{ $loop->first ? 'bg-background-primary/5' : ($loop->iteration % 2 == 0 ? 'bg-background-white' : 'bg-background-light/20') }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold {{ $cardStyle == 'chief' ? 'text-accent-1' : 'text-text-green' }} mb-4">
                {{ $designationName }}
            </h2>
            <div class="w-20 h-1 {{ $cardStyle == 'chief' ? 'bg-accent-1' : 'bg-text-muted' }} mx-auto"></div>
            @if($cardStyle == 'chief')
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">Our leadership team providing strategic direction and vision</p>
            @endif
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($members as $member)
            <!-- Dynamic Card based on designation -->
            @if($cardStyle == 'chief')
            <!-- Chief Style Card - Premium/Large -->
            <div class="group relative bg-gradient-to-br from-primary to-primary-light rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:transform hover:-translate-y-2">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent-1/10 rounded-bl-full z-0"></div>
                <div class="relative z-10">
                    <div class="h-72 overflow-hidden">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 text-text-primary">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-2xl font-bold">{{ $member->name }}</h3>
                            <svg class="w-6 h-6 text-accent-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <p class="text-accent-1 font-semibold mb-4">{{ $member->designation->title ?? 'Team Member' }}</p>
                        <div class="text-text-secondary text-sm mb-4 line-clamp-3">
                            {!! nl2br(e($member->experience)) !!}
                        </div>
                        <div class="flex space-x-4 pt-3 border-t border-white/20">
                            @if($member->email)
                            <a href="mailto:{{ $member->email }}" 
                               class="text-text-primary hover:text-accent-1 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </a>
                            @endif
                            <a href="#" class="text-text-primary hover:text-accent-1 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @elseif($cardStyle == 'assistant-chief')
            <!-- Assistant Chief Style Card - Featured -->
            <div class="group bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:transform hover:-translate-y-2 border-t-4 border-accent-1">
                <div class="h-64 overflow-hidden">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-text-green mb-1">{{ $member->name }}</h3>
                    <p class="text-accent-1 font-semibold mb-3">{{ $member->designation->title ?? 'Team Member' }}</p>
                    <div class="text-text-muted text-sm mb-4 line-clamp-3">
                        {!! nl2br(e($member->experience)) !!}
                    </div>
                    <div class="flex space-x-3 pt-3 border-t border-background-light">
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="text-accent-1 hover:text-accent-2 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </a>
                        @endif
                        <a href="#" class="text-accent-1 hover:text-accent-2 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            @elseif($cardStyle == 'research-officer')
            <!-- Research Officer Style Card - Professional -->
            <div class="group bg-background-light/10 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="flex flex-col sm:flex-row h-full">
                    <div class="sm:w-1/3 h-48 sm:h-auto overflow-hidden">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="sm:w-2/3 p-5">
                        <h3 class="text-lg font-bold text-text-green mb-1">{{ $member->name }}</h3>
                        <p class="text-accent-1 text-sm font-semibold mb-2">{{ $member->designation->title ?? 'Team Member' }}</p>
                        <div class="text-text-muted text-xs mb-3 line-clamp-2">
                            {!! nl2br(e($member->experience)) !!}
                        </div>
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="text-accent-1 hover:text-accent-2 transition-colors duration-300 inline-flex items-center text-xs">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Contact
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            @elseif($cardStyle == 'research-analyst')
            <!-- Research Analyst Style Card - Compact -->
            <div class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 hover:transform hover:-translate-y-1 border-l-4 border-accent-1">
                <div class="p-5">
                    <div class="flex items-center mb-3">
                        <div class="w-16 h-16 rounded-full overflow-hidden bg-background-primary mr-4">
                            <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-text-green">{{ $member->name }}</h3>
                            <p class="text-accent-1 text-sm font-semibold">{{ $member->designation->title ?? 'Team Member' }}</p>
                        </div>
                    </div>
                    <div class="text-text-muted text-xs mb-3 line-clamp-2">
                        {!! nl2br(e($member->experience)) !!}
                    </div>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="text-accent-1 hover:text-accent-2 transition-colors duration-300 text-xs">
                        {{ $member->email }}
                    </a>
                    @endif
                </div>
            </div>
            
            @else
            <!-- Default Style Card -->
            <div class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="h-64 overflow-hidden">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-text-green mb-1">{{ $member->name }}</h3>
                    <p class="text-accent-1 font-semibold text-sm mb-3">{{ $member->designation->title ?? 'Team Member' }}</p>
                    <div class="text-text-muted text-sm mb-4 line-clamp-2">
                        {!! nl2br(e($member->experience)) !!}
                    </div>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" 
                       class="inline-flex items-center text-accent-1 hover:text-accent-2 transition-colors duration-300 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        Email
                    </a>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- If no team members exist -->
@if($team->isEmpty())
<section class="py-20 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <svg class="w-24 h-24 mx-auto text-text-muted mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-text-green mb-2">Team Members Coming Soon</h3>
        <p class="text-text-muted">Information about our dedicated team members will be available shortly.</p>
    </div>
</section>
@endif

@endsection