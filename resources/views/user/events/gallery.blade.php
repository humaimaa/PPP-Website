@extends('layouts.app')

@section('title', $event->title . ' - Photo Gallery - PPP Unit KP')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/60 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">{{formatTitle(Str::title( $event->title ))}}</h1>
            <div class="w-20 h-1 bg-white-500 mx-auto"></div>

        </div>
    </div>
    @php
        $bannerImage = null;
        $thumbnail = $event->gallery->firstWhere('is_thumbnail', true);
        if ($thumbnail) {
            $bannerImage = asset('storage/' . $thumbnail->image);
        } else {
            $firstImage = $event->gallery->first();
            if ($firstImage) {
                $bannerImage = asset('storage/' . $firstImage->image);
            }
        }
        $bannerImage = $bannerImage ?? 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=400&fit=crop';
    @endphp
    <img src="{{ $bannerImage }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('media.room.events') }}" class="text-orange-600 hover:text-orange-700 inline-flex items-center transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Events
            </a>
        </div>
        
        <!-- Event Info -->
        <div class="max-w-4xl mx-auto mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">{{formatTitle( Str::title($event->title) )}}</h1>
            <div class="flex flex-wrap gap-4 text-gray-600 mb-6 pb-6 border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-orange-500 mr-2"></i>
                    <span>{{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                    <span>{{ $event->location ?? 'Location TBA' }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-images text-orange-500 mr-2"></i>
                    <span>{{ $event->gallery->count() }} {{ Str::plural('Photo', $event->gallery->count()) }}</span>
                </div>
            </div>
            <p class="text-gray-700 text-lg leading-relaxed">{{ $event->description }}</p>
        </div>
        
        <!-- Photo Gallery Grid -->
        @if($event->gallery->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="galleryGrid">
            @foreach($event->gallery as $index => $galleryItem)
            <div class="group cursor-pointer gallery-item" 
                 data-index="{{ $index }}" 
                 data-src="{{ asset('storage/' . $galleryItem->image) }}" 
                 data-title="{{ $event->title }} - Photo {{ $loop->iteration }}" 
                 data-description="Photo from {{ $event->title }} event at {{ $event->location }}"
                 role="button"
                 tabindex="0"
                 aria-label="View image: {{ $event->title }} - Photo {{ $loop->iteration }}">
                <div class="block overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="relative overflow-hidden aspect-square">
                        <img src="{{ asset('storage/' . $galleryItem->image) }}" 
                             alt="{{ $event->title }} - Photo {{ $loop->iteration }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="text-white text-center">
                                <i class="fas fa-search-plus text-2xl mb-1"></i>
                                <p class="text-xs">Click to view</p>
                            </div>
                        </div>
                        @if($galleryItem->is_thumbnail)
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-md text-xs">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Download All Button -->
        <div class="text-center mt-12">
            <button id="downloadAllBtn" 
                    class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition-colors duration-300 shadow-md">
                <i class="fas fa-download mr-2"></i>
                Download All Photos (ZIP)
            </button>
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-lg">
            <i class="fas fa-camera text-6xl text-gray-400 mb-3"></i>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Photos Available</h3>
            <p class="text-gray-500">No photos have been added to this gallery yet.</p>
        </div>
        @endif
    </div>
</section>

<!-- Toast Notification Container -->
<div id="toastContainer" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

<!-- Lightbox Modal -->
<div id="lightboxModal" 
     class="fixed inset-0 bg-black/95 z-50 hidden justify-center items-center overflow-hidden"
     role="dialog"
     aria-modal="true"
     aria-label="Image gallery lightbox"
     aria-hidden="true">
    <div class="relative w-full h-full flex justify-center items-center overflow-hidden">
        
        <!-- Top Right Controls -->
        <div class="absolute top-5 right-5 flex gap-2.5 z-10">
            <button id="downloadCurrentBtn" 
                    class="bg-black/60 text-white border-none w-11 h-11 rounded-full text-lg cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110">
                <i class="fas fa-download"></i>
            </button>
            <button id="closeLightbox" 
                    class="bg-black/60 text-white border-none w-11 h-11 rounded-full text-3xl cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110">
                &times;
            </button>
        </div>
        
        <!-- Zoom Controls -->
        <div class="absolute bottom-5 left-5 flex gap-2.5 bg-black/60 px-4 py-2 rounded-full z-10">
            <button id="zoomOutBtn" class="bg-transparent text-white border-none w-10 h-10 text-xl cursor-pointer flex items-center justify-center rounded-full hover:bg-black/80 hover:scale-110">
                <i class="fas fa-search-minus"></i>
            </button>
            <span id="zoomLevel" class="text-white text-sm min-w-[45px] text-center leading-10">100%</span>
            <button id="zoomInBtn" class="bg-transparent text-white border-none w-10 h-10 text-xl cursor-pointer flex items-center justify-center rounded-full hover:bg-black/80 hover:scale-110">
                <i class="fas fa-search-plus"></i>
            </button>
            <button id="resetZoomBtn" class="bg-transparent text-white border-none w-10 h-10 text-sm cursor-pointer flex items-center justify-center rounded-full hover:bg-black/80 hover:scale-110">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        
        <!-- Image Counter -->
        <div id="lightboxCounter" class="absolute top-5 left-5 bg-black/60 text-white px-4 py-2 rounded-full text-sm z-10"></div>
        
        <!-- Image Container -->
        <div id="imageContainer" class="relative flex justify-center items-center w-full h-full overflow-hidden cursor-default">
            <img id="lightboxImage" 
                class="block max-w-[90%] max-h-[90%] w-auto h-auto object-contain transition-transform duration-200 origin-center cursor-default"
                alt="">
        </div>
        
        <!-- Caption -->
        <div id="lightboxCaption" class="absolute bg-black/70 text-white px-5 py-3 rounded-md text-center text-sm z-10 max-w-[80%] md:max-w-[60%] backdrop-blur-sm"
             style="bottom: 80px; left: 50%; transform: translateX(-50%);">
        </div>
        
        <!-- Navigation Buttons -->
        <button id="prevImage" class="absolute left-5 top-1/2 -translate-y-1/2 bg-black/50 text-white border-none w-12 h-12 rounded-full text-3xl font-bold cursor-pointer flex items-center justify-center hover:bg-black/80 hover:scale-110 z-10">
            &lt;
        </button>
        <button id="nextImage" class="absolute right-5 top-1/2 -translate-y-1/2 bg-black/50 text-white border-none w-12 h-12 rounded-full text-3xl font-bold cursor-pointer flex items-center justify-center hover:bg-black/80 hover:scale-110 z-10">
            &gt;
        </button>
    </div>
</div>

<style>
    #lightboxModal, #imageContainer {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    #lightboxModal::-webkit-scrollbar, #imageContainer::-webkit-scrollbar {
        display: none;
    }
    
    .toast {
        animation: slideIn 0.3s ease-out forwards;
    }
    
    .toast.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    body.lightbox-open {
        overflow: hidden;
    }
</style>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
(function() {
    const ZOOM_CONFIG = {
        MIN: 0.5,
        MAX: 3,
        STEP: 0.25,
        DEFAULT: 1
    };
    
    const elements = {
        galleryItems: null,
        lightbox: document.getElementById('lightboxModal'),
        imageContainer: document.getElementById('imageContainer'),
        lightboxImage: document.getElementById('lightboxImage'),
        lightboxCaption: document.getElementById('lightboxCaption'),
        lightboxCounter: document.getElementById('lightboxCounter'),
        closeBtn: document.getElementById('closeLightbox'),
        prevBtn: document.getElementById('prevImage'),
        nextBtn: document.getElementById('nextImage'),
        downloadCurrentBtn: document.getElementById('downloadCurrentBtn'),
        zoomInBtn: document.getElementById('zoomInBtn'),
        zoomOutBtn: document.getElementById('zoomOutBtn'),
        resetZoomBtn: document.getElementById('resetZoomBtn'),
        zoomLevelSpan: document.getElementById('zoomLevel'),
        downloadAllBtn: document.getElementById('downloadAllBtn'),
        toastContainer: document.getElementById('toastContainer')
    };
    
    let state = {
        currentIndex: 0,
        imagesArray: [],
        currentZoom: ZOOM_CONFIG.DEFAULT,
        isPanning: false,
        startX: 0,
        startY: 0,
        translateX: 0,
        translateY: 0,
        lastTranslateX: 0,
        lastTranslateY: 0,
        isLightboxOpen: false
    };
    
    function showToast(message, type = 'info') {
        if (!elements.toastContainer) return;
        
        const toast = document.createElement('div');
        let bgColor = type === 'success' ? '#10B981' : (type === 'error' ? '#EF4444' : '#3B82F6');
        let icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : (type === 'error' ? '<i class="fas fa-exclamation-circle"></i>' : '<i class="fas fa-info-circle"></i>');
        
        toast.className = 'toast text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 min-w-[250px]';
        toast.style.backgroundColor = bgColor;
        toast.innerHTML = `${icon}<span>${message}</span>`;
        elements.toastContainer.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('fade-out');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    function sanitizeFilename(title) {
        return title.replace(/[^a-zA-Z0-9]/g, '_').substring(0, 50);
    }
    
    function applyTransform() {
        if (elements.lightboxImage) {
            elements.lightboxImage.style.transform = `scale(${state.currentZoom}) translate(${state.translateX}px, ${state.translateY}px)`;
        }
    }
    
    function resetZoomAndPan() {
        state.currentZoom = ZOOM_CONFIG.DEFAULT;
        state.translateX = 0;
        state.translateY = 0;
        state.lastTranslateX = 0;
        state.lastTranslateY = 0;
        applyTransform();
        if (elements.zoomLevelSpan) elements.zoomLevelSpan.textContent = '100%';
    }
    
    function openLightbox(index) {
        if (!state.imagesArray.length) return;
        state.currentIndex = index;
        resetZoomAndPan();
        updateLightboxContent();
        elements.lightbox.style.display = 'flex';
        document.body.classList.add('lightbox-open');
        state.isLightboxOpen = true;
    }
    
    function closeLightbox() {
        elements.lightbox.style.display = 'none';
        document.body.classList.remove('lightbox-open');
        state.isLightboxOpen = false;
        resetZoomAndPan();
    }
    
    function updateLightboxContent() {
        const image = state.imagesArray[state.currentIndex];
        if (!image) return;
        
        elements.lightboxImage.src = image.src;
        elements.lightboxImage.alt = image.title;
        elements.lightboxCaption.textContent = image.description || image.title;
        elements.lightboxCounter.textContent = `${state.currentIndex + 1} / ${state.imagesArray.length}`;
        resetZoomAndPan();
    }
    
    function zoomIn() {
        if (state.currentZoom < ZOOM_CONFIG.MAX) {
            state.currentZoom = Math.min(ZOOM_CONFIG.MAX, state.currentZoom + ZOOM_CONFIG.STEP);
            elements.zoomLevelSpan.textContent = Math.round(state.currentZoom * 100) + '%';
            applyTransform();
        }
    }
    
    function zoomOut() {
        if (state.currentZoom > ZOOM_CONFIG.MIN) {
            state.currentZoom = Math.max(ZOOM_CONFIG.MIN, state.currentZoom - ZOOM_CONFIG.STEP);
            elements.zoomLevelSpan.textContent = Math.round(state.currentZoom * 100) + '%';
            if (state.currentZoom <= 1) {
                state.translateX = 0;
                state.translateY = 0;
                state.lastTranslateX = 0;
                state.lastTranslateY = 0;
            }
            applyTransform();
        }
    }
    
    function prevImage() {
        state.currentIndex = (state.currentIndex > 0) ? state.currentIndex - 1 : state.imagesArray.length - 1;
        updateLightboxContent();
    }
    
    function nextImage() {
        state.currentIndex = (state.currentIndex < state.imagesArray.length - 1) ? state.currentIndex + 1 : 0;
        updateLightboxContent();
    }
    
    async function downloadCurrentImage() {
        const image = state.imagesArray[state.currentIndex];
        const btn = elements.downloadCurrentBtn;
        const originalIcon = btn.innerHTML;
        
        try {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            const response = await fetch(image.src);
            const blob = await response.blob();
            const extension = blob.type.split('/')[1] || 'jpg';
            const filename = `${sanitizeFilename(image.title)}.${extension}`;
            
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            btn.innerHTML = '<i class="fas fa-check"></i>';
            showToast(`Downloaded: ${image.title}`, 'success');
            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.disabled = false;
            }, 1500);
        } catch (error) {
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            showToast(`Failed to download`, 'error');
            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.disabled = false;
            }, 1500);
        }
    }
    
    async function downloadAllImages() {
        if (typeof JSZip === 'undefined') {
            showToast('JSZip is loading. Please try again.', 'error');
            return;
        }
        
        const btn = elements.downloadAllBtn;
        if (!btn) return;
        
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Preparing...';
        btn.disabled = true;
        
        try {
            const zip = new JSZip();
            const folderName = sanitizeFilename("{{ $event->title }}");
            const folder = zip.folder(folderName);
            
            let downloaded = 0;
            for (let i = 0; i < state.imagesArray.length; i++) {
                const image = state.imagesArray[i];
                try {
                    btn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> ${i+1}/${state.imagesArray.length}`;
                    const response = await fetch(image.src);
                    const blob = await response.blob();
                    const extension = blob.type.split('/')[1] || 'jpg';
                    const filename = `${(i+1).toString().padStart(2, '0')}_${sanitizeFilename(image.title)}.${extension}`;
                    folder.file(filename, blob);
                    downloaded++;
                } catch (error) {
                    console.error('Error downloading:', error);
                }
            }
            
            const content = await zip.generateAsync({ type: "blob" });
            const link = document.createElement('a');
            const url = URL.createObjectURL(content);
            link.href = url;
            link.download = `${folderName}.zip`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Complete!';
            showToast(`Downloaded ${downloaded} of ${state.imagesArray.length} images`, 'success');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }, 1500);
        } catch (error) {
            btn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Error!';
            showToast('Failed to create ZIP', 'error');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }, 1500);
        }
    }
    
    function initEventListeners() {
        if (elements.closeBtn) elements.closeBtn.addEventListener('click', closeLightbox);
        if (elements.prevBtn) elements.prevBtn.addEventListener('click', prevImage);
        if (elements.nextBtn) elements.nextBtn.addEventListener('click', nextImage);
        if (elements.downloadCurrentBtn) elements.downloadCurrentBtn.addEventListener('click', downloadCurrentImage);
        if (elements.zoomInBtn) elements.zoomInBtn.addEventListener('click', zoomIn);
        if (elements.zoomOutBtn) elements.zoomOutBtn.addEventListener('click', zoomOut);
        if (elements.resetZoomBtn) elements.resetZoomBtn.addEventListener('click', resetZoomAndPan);
        if (elements.downloadAllBtn) elements.downloadAllBtn.addEventListener('click', downloadAllImages);
        
        document.addEventListener('keydown', (e) => {
            if (!state.isLightboxOpen) return;
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'Escape') closeLightbox();
        });
    }
    
    function init() {
        elements.galleryItems = document.querySelectorAll('.gallery-item');
        if (elements.galleryItems.length === 0) return;
        
        elements.galleryItems.forEach((item, index) => {
            state.imagesArray.push({
                src: item.getAttribute('data-src'),
                title: item.getAttribute('data-title'),
                description: item.getAttribute('data-description')
            });
            
            item.addEventListener('click', () => openLightbox(index));
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') openLightbox(index);
            });
        });
        
        initEventListeners();
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush