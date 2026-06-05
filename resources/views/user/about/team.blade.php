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
                        @if($chief->phone)
                        <div class="flex items-center space-x-2 text-[#DAD7CD] mt-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
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

<!-- Other Designation Sections -->
@foreach($otherGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Team Members';
    $designationOrder = $designation->order ?? 999;
    $memberCount = $members->count();

    // Orders 2 & 3 → Research Officer card style (tall image, white card, shadow)
    // Orders 4+   → Research Analyst card style (circular avatar, centered, gray card)
    $isOfficerStyle = ($designationOrder == 2 || $designationOrder == 3);
    $bgClass = $isOfficerStyle ? 'bg-gray-100' : 'bg-white';

    // Grid centering helpers
    $gridExtra = '';
    if ($memberCount == 1) {
        $gridExtra = 'lg:grid-cols-1 max-w-md mx-auto';
    } elseif ($memberCount == 2) {
        $gridExtra = 'lg:grid-cols-2 max-w-3xl mx-auto';
    }
@endphp

<section class="py-12 {{ $bgClass }}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-[#0A612B] mx-auto mt-4"></div>
            <p class="text-gray-600 mt-4">{{ $designation->description ?? 'Dedicated professionals supporting PPP initiatives' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $gridExtra }}">
            @foreach($members as $member)

                @if($isOfficerStyle)
                {{-- ── Research Officer Card (tall image, white card with shadow) ── --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                         alt="{{ $member->name }}"
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#0D2818]">{{ $member->name }}</h3>
                        <p class="text-[#0A612B] font-semibold mb-2">{{ $member->designation->title ?? 'Team Member' }}</p>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{!! nl2br(e($member->experience)) !!}</p>
                        @if($member->email)
                        <div class="mt-3">
                            <a href="mailto:{{ $member->email }}"
                               class="text-[#0A612B] hover:text-[#0D2818] text-sm break-all inline-flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                {{ $member->email }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                @else
                {{-- ── Research Analyst Card (circular avatar, centered, gray card) ── --}}
                <div class="bg-gray-100 rounded-lg p-6 text-center hover:shadow-md transition duration-300">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}"
                             alt="{{ $member->name }}"
                             class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-[#0D2818]">{{ $member->name }}</h3>
                    <p class="text-[#0A612B] text-sm font-medium">{{ $member->designation->title ?? 'Team Member' }}</p>
                    <p class="text-gray-500 text-xs mt-2 line-clamp-2">{!! nl2br(e($member->experience)) !!}</p>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}"
                       class="inline-block mt-3 text-[#0A612B] hover:text-[#0D2818] text-xs break-all">
                        {{ Str::limit($member->email, 25) }}
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