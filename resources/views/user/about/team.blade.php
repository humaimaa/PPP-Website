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
    
    // Assistant Chief (designation order 2)
    $assistantChiefGroups = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order == 2;
    });
    
    // Research Officers (designation order 3)
    $researchOfficerGroups = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order == 3;
    });
    
    // Research Analysts (designation order 4)
    $researchAnalystGroups = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order == 4;
    });
    
    // Other Staff (designation order 5 and above)
    $otherGroups = $groupedTeam->filter(function($members) {
        return $members->first()->designation->order >= 5;
    });
@endphp

<!-- Departmental Leadership Section (Chief/Director) -->
@if($chiefMembers->isNotEmpty())
@php $chief = $chiefMembers->first(); @endphp
<section class="py-16 bg-gradient-to-br from-[#0D2818] to-[#1a4d2e] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Departmental Leadership</h2>
            <div class="w-20 h-1 bg-[#DAD7CD] mx-auto"></div>
        </div>
        
        <div class="flex flex-col lg:flex-row items-center justify-center gap-8 max-w-5xl mx-auto">
            <!-- Chief's Photo -->
            <div class="lg:w-2/5">
                <div class="relative rounded-lg overflow-hidden shadow-2xl">
                    <img src="{{ $chief->img ? asset('storage/' . $chief->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $chief->name }}" 
                         class="w-full h-[400px] object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                        <h3 class="text-2xl font-bold">{{ $chief->name }}</h3>
                        <p class="text-[#DAD7CD]">{{ $chief->designation->title ?? 'Chief Executive Officer' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-3/5">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold">Message from the Chief</h3>
                    <p class="text-gray-200 leading-relaxed text-justify">
                        {!! nl2br(e($chief->message ?? $chief->experience ?? 'As the Chief Executive of PPP Department KPK, I am honored to lead a team dedicated to transforming the province through strategic public-private partnerships. Our commitment to transparency, innovation, and excellence drives every project we undertake.')) !!}
                    </p>
                    <div class="mt-6">
                        @if($chief->email)
                        <div class="flex items-center space-x-3 text-[#DAD7CD]">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
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

<!-- Assistant Chief Section -->
@foreach($assistantChiefGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Assistant Chief';
    $memberCount = $members->count();
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-3">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-[#0A612B] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Supporting the Chief in strategic planning and execution</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : ($memberCount == 2 ? 'lg:grid-cols-2 max-w-3xl mx-auto' : '') }}">
            @foreach($members as $member)
            <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden hover:transform hover:-translate-y-2 border border-gray-100">
                <div class="relative overflow-hidden h-72 bg-gray-100">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                        <div class="inline-block bg-[#0A612B] text-white px-3 py-1 rounded-full text-xs font-semibold">
                            Senior Leadership
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#0D2818] mb-1 group-hover:text-[#0A612B] transition-colors">
                        {{ $member->name }}
                    </h3>
                    <p class="text-[#0A612B] font-semibold text-sm mb-3">{{ $member->designation->title ?? 'Assistant Chief' }}</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                        {!! nl2br(e($member->experience)) !!}
                    </p>
                    @if($member->email)
                    <a href="mailto:{{ $member->email }}" 
                       class="inline-flex items-center gap-2 text-gray-600 hover:text-[#0A612B] transition-colors text-sm break-all">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $member->email }}</span>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Research Officers Section -->
@foreach($researchOfficerGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Research Officers';
    $memberCount = $members->count();
@endphp

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-3">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-[#0A612B] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Leading research and analysis for PPP projects</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : ($memberCount == 2 ? 'lg:grid-cols-2 max-w-3xl mx-auto' : '') }}">
            @foreach($members as $member)
            <div class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:transform hover:-translate-y-1 border border-gray-100">
                <div class="flex flex-col sm:flex-row">
                    <div class="sm:w-2/5 h-56 sm:h-auto overflow-hidden bg-gray-100">
                        <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="sm:w-3/5 p-5">
                        <h3 class="text-lg font-bold text-[#0D2818] group-hover:text-[#0A612B] transition-colors">
                            {{ $member->name }}
                        </h3>
                        <p class="text-[#0A612B] text-xs font-semibold uppercase tracking-wider mt-1 mb-3">
                            {{ $member->designation->title ?? 'Research Officer' }}
                        </p>
                        <p class="text-gray-600 text-xs leading-relaxed mb-3 line-clamp-3">
                            {!! nl2br(e($member->experience)) !!}
                        </p>
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" 
                           class="inline-flex items-center gap-1 text-[#0A612B] hover:text-[#0D2818] text-xs transition-colors break-all">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ Str::limit($member->email, 30) }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Research Analysts Section -->
@foreach($researchAnalystGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Research Analysts';
    $memberCount = $members->count();
@endphp

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-3">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-[#0A612B] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Supporting project research and data analysis</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : ($memberCount == 2 ? 'lg:grid-cols-2 max-w-3xl mx-auto' : ($memberCount == 3 ? 'lg:grid-cols-3 max-w-5xl mx-auto' : '')) }}">
            @foreach($members as $member)
            <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-all duration-300 border border-gray-100 hover:border-[#0A612B]/20 hover:transform hover:-translate-y-1">
                <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-100 border-4 border-[#0A612B]/20 group-hover:border-[#0A612B] transition-all">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="text-lg font-bold text-[#0D2818] mb-1">{{ $member->name }}</h3>
                <p class="text-[#0A612B] text-sm font-medium mb-2">{{ $member->designation->title ?? 'Research Analyst' }}</p>
                <p class="text-gray-500 text-xs leading-relaxed mb-3 line-clamp-2">
                    {!! nl2br(e($member->experience)) !!}
                </p>
                @if($member->email)
                <a href="mailto:{{ $member->email }}" 
                   class="inline-block text-[#0A612B] hover:text-[#0D2818] text-xs transition-colors break-all">
                    {{ Str::limit($member->email, 25) }}
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach

<!-- Other Staff Section (Order 5 and above) -->
@foreach($otherGroups as $designationId => $members)
@php
    $designation = $members->first()->designation;
    $designationName = $designation->title ?? 'Support Staff';
    $memberCount = $members->count();
@endphp

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-3">{{ $designationName }}</h2>
            <div class="w-20 h-1 bg-[#0A612B] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Dedicated professionals supporting departmental operations</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 {{ $memberCount == 1 ? 'lg:grid-cols-1 max-w-md mx-auto' : ($memberCount == 2 ? 'lg:grid-cols-2 max-w-3xl mx-auto' : ($memberCount == 3 ? 'lg:grid-cols-3 max-w-5xl mx-auto' : '')) }}">
            @foreach($members as $member)
            <div class="bg-gray-50 rounded-lg p-5 text-center hover:shadow-md transition-all duration-300 hover:transform hover:-translate-y-1">
                <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden bg-gray-200">
                    <img src="{{ $member->img ? asset('storage/' . $member->img) : asset('images/default-avatar.jpg') }}" 
                         alt="{{ $member->name }}" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="text-md font-bold text-[#0D2818]">{{ $member->name }}</h3>
                <p class="text-[#0A612B] text-xs font-medium mb-2">{{ $member->designation->title ?? 'Staff Member' }}</p>
                <p class="text-gray-500 text-xs leading-relaxed mb-2 line-clamp-2">
                    {!! nl2br(e(Str::limit($member->experience, 80))) !!}
                </p>
                @if($member->email)
                <a href="mailto:{{ $member->email }}" 
                   class="text-[#0A612B] hover:text-[#0D2818] text-xs transition-colors break-all">
                    Contact
                </a>
                @endif
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