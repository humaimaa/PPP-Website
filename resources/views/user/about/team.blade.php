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
    
    // Find chief/CEO (designation order 1)
    $chiefMembers = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order == 1;
    })->flatten();
    
    // Get other groups (excluding chief)
    $otherGroups = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order != 1;
    });
@endphp

<!-- Departmental Leadership Section (Chief/Director) -->
@if($chiefMembers->isNotEmpty())
@php $chief = $chiefMembers->first(); @endphp
<section class="py-12 bg-gradient-to-br from-[#0D2818] to-[#1a4d2e] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Departmental Leadership</h2>
            <div class="w-20 h-1 bg-[#DAD7CD] mx-auto"></div>
        </div>
        
        <div class="flex flex-col lg:flex-row items-center justify-center gap-8">
            <!-- Chief's Photo -->
            <div class="lg:w-1/3">
                <div class="relative rounded-lg overflow-hidden shadow-2xl">
                    <img src="{{ $chief->img ? asset('storage/' . $chief->img) : asset('images/boy.jpg') }}" 
                         alt="{{ $chief->name }}" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                        <h3 class="text-2xl font-bold">{{ $chief->name }}</h3>
                        <p class="text-[#DAD7CD]">{{ $chief->designation->title ?? 'Chief Executive Officer' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold">Message from the Chief</h3>
                    <p class="text-gray-200 leading-relaxed text-justify">
                        {!! nl2br(e($chief->message ?? $chief->experience ?? 'As the Chief Executive of PPP Department KPK, I am honored to lead a team dedicated to transforming the province through strategic public-private partnerships. Our commitment to transparency, innovation, and excellence drives every project we undertake.')) !!}
                    </p>
                    <div class="mt-6">
                        @if($chief->email)
                        <div class="flex items-center space-x-2 text-[#DAD7CD]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span class="break-all">{{ $chief->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- All Other Team Members Grouped by Designation -->
@foreach($otherGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Other';
    $memberCount = $members->count();
@endphp

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : ($memberCount == 2 ? 'lg:grid-cols-2 max-w-3xl mx-auto' : '') }}">
            @foreach($members as $member)
            <!-- Original Card Design -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-accent-1/20">
                <!-- Image Container with subtle overlay -->
                <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                    <div class="h-72 overflow-hidden">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <!-- Subtle gradient overlay on image -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Name and Designation -->
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-text-black mb-1 group-hover:text-accent-1 transition-colors duration-300">
                            {{ $member->name }}
                        </h3>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-0.5 bg-accent-1/50 rounded-full"></div>
                            <p class="text-sm font-medium text-accent-1">
                                {{ $member->designation->title ?? 'Team Member' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Experience/Description -->
                    <div class="text-text-muted text-sm leading-relaxed mb-5 line-clamp-3 min-h-[60px]">
                        {!! nl2br(e($member->experience)) !!}
                    </div>
                    
                    <!-- Email Displayed Directly -->
                    @if($member->email)
                    <div class="pt-4 border-t border-gray-100">
                        <a href="mailto:{{ $member->email }}" 
                           class="flex items-center gap-2 text-gray-500 hover:text-accent-1 transition-all duration-300 group/link break-all">
                            <svg class="w-4 h-4 transition-transform group-hover/link:-translate-y-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">{{ $member->email }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
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