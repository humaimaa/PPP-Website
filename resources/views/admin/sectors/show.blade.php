@extends('layouts.admin')

@section('title', 'Sector Details - PPP Unit KP')
@section('header-title', 'Sector Details')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.sectors.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Sectors
        </a>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Sector Information Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-chart-line mr-2 text-emerald-600"></i>
                        Sector Information
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View sector details and information</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sector ID --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        <i class="fas fa-hashtag mr-1"></i> Sector ID
                    </label>
                    <div class="flex items-center">
                        <span class="text-2xl font-mono font-bold text-gray-800">
                            #{{ $sector->id }}
                        </span>
                    </div>
                </div>

                {{-- Sector Name --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        <i class="fas fa-building mr-1"></i> Sector Name
                    </label>
                    <div class="flex items-center">
                        <span class="text-xl font-semibold text-emerald-600">
                            {{ $sector->name }}
                        </span>
                    </div>
                </div>

                {{-- Created At --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i> Created At
                    </label>
                    <div class="text-gray-700">
                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                        {{ $sector->created_at->format('F d, Y') }}
                    </div>
                    
                </div>

                {{-- Last Updated --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        <i class="fas fa-clock mr-1"></i> Last Updated
                    </label>
                    <div class="text-gray-700">
                        <i class="far fa-clock text-gray-400 mr-2"></i>
                        {{ $sector->updated_at->format('F d, Y') }}
                    </div>
                   
                </div>

                {{-- Tagline/Description --}}
                <div class="md:col-span-2">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-5 border border-blue-100">
                        <label class="block text-xs font-medium text-blue-600 uppercase tracking-wider mb-3">
                            <i class="fas fa-tag mr-1"></i> Tagline
                        </label>
                        <div class="text-gray-700 leading-relaxed">
                            <i class="fas fa-quote-left text-blue-400 mr-2"></i>
                            {{ $sector->tagline }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sector Image Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-image mr-2 text-emerald-600"></i>
                        Sector Image
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Sector representative image</p>
                </div>
                @if($sector->img)
                    <div class="flex gap-2">
                        <a href="{{ asset('storage/' . $sector->img) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition">
                            <i class="fas fa-external-link-alt"></i>
                            View Full Size
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            @if($sector->img)
                @php
                    $imageUrl = asset('storage/' . $sector->img);
                @endphp
                
                <div class="text-center">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $sector->name }}"
                         style="max-width: 100%; max-height: 500px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-image text-4xl mb-3 opacity-50"></i>
                    <p class="text-lg">No image uploaded for this sector</p>
                    <p class="text-sm mt-1">Edit the sector to add an image</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add keyboard event listener for Escape key if needed
    document.addEventListener('keydown', function(e) {
        // Add any keyboard shortcuts here if needed
    });
</script>
@endpush
@endsection