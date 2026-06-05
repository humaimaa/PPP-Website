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
    $groupedTeam = $team->groupBy(function($member) {
        return $member->designation_id;
    })->sortBy(function($members) {
        return $members->first()->designation->order ?? 999;
    });

    // Orders 1 & 2 = Leadership (Chief + Assistant Chief)
    $leadershipGroups = $groupedTeam->filter(function($members) {
        return in_array($members->first()->designation->order, [1, 2]);
    });

    // Orders 3+ = rest of the team
    $otherGroups = $groupedTeam->filter(function($members) {
        return !in_array($members->first()->designation->order, [1, 2]);
    });
@endphp

<!-- ═══════════════════════════════════════════
     DEPARTMENTAL LEADERSHIP  (orders 1 & 2)
     Cards: tall image + info panel below,
     slightly larger than officer cards,
     centred on dark-green background
════════════════════════════════════════════ -->
@if($leadershipGroups->isNotEmpty())
<section class="py-16 bg-gradient-to-br from-[#0D2818] to-[#1a4d2e] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Departmental Leadership</h2>
            <div class="w-20 h-1 bg-[#DAD7CD] mx-auto"></div>
        </div>

        @foreach($leadershipGroups as $designationId => $members)
        @php
            $designation   = $members->first()->designation;
            $memberCount   = $members->count();
            // Centre 1 or 2 cards nicely
            $gridExtra = match(true) {
                $memberCount == 1 => 'lg:grid-cols-1 max-w-sm mx-auto',
                $memberCount == 2 => 'lg:grid-cols-2 max-w-3xl mx-auto',
                default           => '',
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10 {{ $gridExtra }}">
            @foreach($members as $member)
            {{-- ── Leadership Card ── --}}
            <div class="rounded-xl overflow-hidden shadow-2xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/15 transition duration-300">
                {{-- Tall photo --}}
                <div class="relative">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/boy.jpg') }}"
                         alt="{{ $member->name }}"
                         class="w-full h-72 object-cover">
                    {{-- Gradient badge at bottom of image --}}
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent px-5 py-4">
                        <span class="inline-block bg-[#0A612B] text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $member->designation->title ?? 'Leadership' }}
                        </span>
                    </div>
                </div>
                {{-- Info panel --}}
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-1">{{ $member->name }}</h3>
                    <p class="text-[#DAD7CD] text-sm leading-relaxed line-clamp-3">
                        {!! nl2br(e($member->message ?? $member->experience ?? '')) !!}
                    </p>
                    <div class="mt-4 space-y-2">
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}"
                           class="flex items-center gap-2 text-[#DAD7CD] hover:text-white text-sm break-all transition">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            {{ $member->email }}
                        </a>
                        @endif
                        @if($member->phone)
                        <div class="flex items-center gap-2 text-[#DAD7CD] text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                            </svg>
                            {{ $member->phone }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach

    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════
     OTHER DESIGNATIONS  (orders 3+)
════════════════════════════════════════════ -->
@foreach($otherGroups as $designationId => $members)
@php
    $designation     = $members->first()->designation;
    $designationName = $designation->title ?? 'Team Members';
    $designationOrder = $designation->order ?? 999;
    $memberCount     = $members->count();

    // Orders 3 & 4 → Officer card (tall image, white, shadow)
    // Orders 5+     → Analyst card (circular avatar, centered, gray)
    $isOfficerStyle = ($designationOrder <= 4);
    $bgClass        = $isOfficerStyle ? 'bg-gray-100' : 'bg-white';

    $gridExtra = match(true) {
        $memberCount == 1 => 'lg:grid-cols-1 max-w-md mx-auto',
        $memberCount == 2 => 'lg:grid-cols-2 max-w-3xl mx-auto',
        default           => '',
    };
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
                {{-- ── Research Officer Card ── --}}
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
                               class="text-[#0A612B] hover:text-[#0D2818] text-sm break-all inline-flex items-center gap-2 transition">
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
                {{-- ── Research Analyst Card ── --}}
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
                       class="inline-block mt-3 text-[#0A612B] hover:text-[#0D2818] text-xs break-all transition">
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