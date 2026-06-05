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
        return $members->first()->designation->order ?? 999;
    });
    
    // Define hierarchy levels
    $hierarchyLevels = [
        1 => 'chief',
        2 => 'assistant-chief',
        3 => 'research-officer',
    ];
@endphp

@foreach($groupedTeam as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Other';
    $designationOrder = $designation->order ?? 999;
    $memberCount = $members->count();
    
    // Determine card style based on order
    if ($designationOrder == 1) {
        $cardStyle = 'chief';
    } elseif ($designationOrder == 2) {
        $cardStyle = 'assistant-chief';
    } elseif ($designationOrder == 3) {
        $cardStyle = 'research-officer';
    } else {
        $cardStyle = 'default';
    }
@endphp

<section class="py-16 {{ $loop->first ? 'pt-16' : '' }} bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-3">
                {{ $designationName }}
            </h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto rounded-full"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">
                {{ $designation->description ?? 'Leading with excellence and dedication' }}
            </p>
        </div>
        
        <!-- Dynamic Grid - Centers cards if only one -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : '' }}">
            @foreach($members as $member)
            
            <!-- CHIEF LEVEL CARD - Premium Executive Card -->
            @if($cardStyle == 'chief')
            <div class="group relative bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden hover:transform hover:-translate-y-2">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-accent-1/10 rounded-bl-full"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-accent-1/5 rounded-tr-full"></div>
                
                <div class="relative z-10">
                    <!-- Image -->
                    <div class="relative overflow-hidden h-80">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
                        <!-- Badge -->
                        <div class="absolute top-4 right-4 bg-accent-1 text-text-primary px-3 py-1 rounded-full text-xs font-semibold">
                            Leadership
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 text-white">
                        <h3 class="text-2xl font-bold mb-1 group-hover:text-accent-1 transition-colors">
                            {{ $member->name }}
                        </h3>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-0.5 bg-accent-1 rounded-full"></div>
                            <p class="text-sm font-medium text-accent-1">
                                {{ $member->designation->title ?? 'Team Member' }}
                            </p>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed mb-5 line-clamp-3">
                            {!! nl2br(e($member->experience)) !!}
                        </p>
                        
                        <!-- Contact -->
                        <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                            @if($member->email)
                            <a href="mailto:{{ $member->email }}" 
                               class="flex items-center gap-2 text-gray-400 hover:text-accent-1 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Contact</span>
                            </a>
                            @endif
                            <a href="#" class="flex items-center gap-2 text-gray-400 hover:text-accent-1 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                                <span class="text-sm">Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ASSISTANT CHIEF CARD - Modern Glass Card -->
            @elseif($cardStyle == 'assistant-chief')
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden hover:transform hover:-translate-y-2 border-2 border-transparent hover:border-accent-1/30">
                <div class="relative overflow-hidden h-64">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-accent-1 text-text-primary px-3 py-1 rounded-full text-xs font-semibold">
                            Senior Leadership
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-text-black mb-1 group-hover:text-accent-1 transition-colors">
                        {{ $member->name }}
                    </h3>
                    <p class="text-accent-1 text-sm font-semibold mb-4">
                        {{ $member->designation->title ?? 'Team Member' }}
                    </p>
                    <p class="text-text-muted text-sm leading-relaxed mb-5 line-clamp-3">
                        {!! nl2br(e($member->experience)) !!}
                    </p>
                    
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-50 hover:bg-accent-1 text-gray-600 hover:text-white rounded-lg transition-all duration-300 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email
                        </a>
                        @endif
                        <a href="#" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-gray-50 hover:bg-accent-1 text-gray-600 hover:text-white rounded-lg transition-all duration-300 text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5z"/>
                            </svg>
                            Connect
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- RESEARCH OFFICER CARD - Professional Minimal Card -->
            @elseif($cardStyle == 'research-officer')
            <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:transform hover:-translate-y-1">
                <div class="flex flex-col sm:flex-row">
                    <div class="sm:w-2/5 h-48 sm:h-auto overflow-hidden bg-gray-100">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="sm:w-3/5 p-5">
                        <div class="mb-2">
                            <h3 class="text-lg font-bold text-text-black group-hover:text-accent-1 transition-colors">
                                {{ $member->name }}
                            </h3>
                            <p class="text-accent-1 text-xs font-semibold uppercase tracking-wider mt-1">
                                {{ $member->designation->title ?? 'Team Member' }}
                            </p>
                        </div>
                        <p class="text-text-muted text-xs leading-relaxed mb-3 line-clamp-3">
                            {!! nl2br(e($member->experience)) !!}
                        </p>
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="inline-flex items-center gap-1 text-accent-1 hover:text-accent-2 text-xs font-medium transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $member->email }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- DEFAULT CARD - For Research Analyst and below (Simple & Clean) -->
            @else
            <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden hover:transform hover:-translate-y-1">
                <div class="relative overflow-hidden h-56 bg-gray-100">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-text-black mb-1 group-hover:text-accent-1 transition-colors line-clamp-1">
                        {{ $member->name }}
                    </h3>
                    <p class="text-accent-1 text-xs font-medium mb-2">
                        {{ $member->designation->title ?? 'Team Member' }}
                    </p>
                    <p class="text-text-muted text-xs leading-relaxed mb-3 line-clamp-2">
                        {!! nl2br(e($member->experience)) !!}
                    </p>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" 
                       class="inline-flex items-center gap-1 text-gray-500 hover:text-accent-1 text-xs transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact
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
<section class="py-20 bg-white">
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