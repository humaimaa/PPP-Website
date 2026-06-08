@extends('layouts.admin')

@section('title', 'Event Details - PPP Department KPK')
@section('header-title', 'Event Details')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Events
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Event Details Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                        Event Information
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Complete details of the event and gallery images</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            {{-- Event Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                        Event Title
                    </label>
                    <p class="text-gray-900 font-medium">{{ $event->title }}</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                        Event Date
                    </label>
                    <p class="text-gray-900">
                        <i class="far fa-calendar-alt mr-1 text-emerald-500"></i>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}
                    </p>
                </div>

                @if($event->location)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Location
                        </label>
                        <p class="text-gray-900">
                            <i class="fas fa-map-marker-alt mr-1 text-emerald-500"></i>
                            {{ $event->location }}
                        </p>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                        Created At
                    </label>
                    <p class="text-gray-900">
                        <i class="far fa-clock mr-1 text-emerald-500"></i>
                        {{ $event->created_at->format('l, d F Y ') }}
                    </p>
                </div>
            </div>

            {{-- Description --}}
            @if($event->description)
                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        Description
                    </label>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                </div>
            @endif

            {{-- Gallery Images Section --}}
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Gallery Images
                        </label>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-images mr-1 text-emerald-500"></i>
                            Total Images: {{ $event->gallery->count() }}
                        </p>
                    </div>
                    @if($event->gallery->where('is_thumbnail', true)->first())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-1.5">
                            <span class="text-xs text-yellow-700">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                Thumbnail selected
                            </span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($event->gallery as $gallery)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $gallery->image) }}" 
                                 alt="Gallery image"
                                 class="w-full h-48 object-cover rounded-lg border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                                 onclick="openImageModal('{{ asset('storage/' . $gallery->image) }}', '{{ $gallery->is_thumbnail ? 'Thumbnail Image' : 'Gallery Image' }}')">
                            @if($gallery->is_thumbnail)
                                <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-lg flex items-center">
                                    <i class="fas fa-star mr-1 text-xs"></i>
                                    Thumbnail
                                </div>
                            @endif
                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-search-plus mr-1"></i>
                                Click to enlarge
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($event->gallery->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-images text-5xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">No images uploaded for this event yet.</p>
                    </div>
                @endif
            </div>

            {{-- Info Box --}}
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Event Gallery</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Click on any image to view it in full size. The image marked with a star is the thumbnail 
                            that appears on the events listing page.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        
       
    </div>
</div>

{{-- Image Modal for Full Size View --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-90 transition-opacity" onclick="closeImageModal()"></div>

        <div class="relative bg-transparent rounded-lg max-w-5xl w-full max-h-[90vh] transform transition-all">
            <div class="absolute top-4 right-4 z-10">
                <button type="button" onclick="closeImageModal()" class="text-white hover:text-gray-300 p-2 rounded-full bg-black bg-opacity-50 hover:bg-opacity-70 transition">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <div class="flex items-center justify-center h-full">
                <img id="modalImage" src="" alt="Full size image" class="max-w-full max-h-[85vh] object-contain rounded-lg">
            </div>
            
            <div id="imageCaption" class="absolute bottom-4 left-0 right-0 text-center text-white text-sm bg-black bg-opacity-50 py-2 mx-auto w-auto inline-block rounded-lg" style="width: fit-content; margin: 0 auto; bottom: 20px; left: 50%; transform: translateX(-50%);">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openImageModal(imageUrl, caption) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalCaption = document.getElementById('imageCaption');
        
        modalImage.src = imageUrl;
        modalCaption.textContent = caption;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('imageModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection