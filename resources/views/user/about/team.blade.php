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
@endphp

@foreach($groupedTeam as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Other';
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($members as $member)
            <!-- Beautiful Simple Card Design -->
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
                    
                    <!-- Contact and Social Links -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="flex items-center gap-2 text-gray-500 hover:text-accent-1 transition-all duration-300 group/link">
                            <svg class="w-4 h-4 transition-transform group-hover/link:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Email</span>
                        </a>
                        @else
                        <div></div>
                        @endif
                        
                        <a href="#" 
                           class="flex items-center gap-2 text-gray-500 hover:text-accent-1 transition-all duration-300 group/link">
                            <svg class="w-4 h-4 transition-transform group-hover/link:-translate-y-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            <span class="text-sm">LinkedIn</span>
                        </a>
                    </div>
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