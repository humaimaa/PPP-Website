@extends('layouts.app')

@section('title', $event->title . ' - Photo Gallery - PPP Unit KPK')

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $event->title }}</h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4 max-w-2xl mx-auto">
                {{ Str::limit($event->description ?? 'View moments from this memorable event', 150) }}
            </p>
        </div>
    </div>
    @php
        $bannerImage = $event->thumbnail_url ?? 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=400&fit=crop';
    @endphp
    <img src="{{ $bannerImage }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('media.room.events.index') }}" class="text-accent-1 hover:text-accent-2 inline-flex items-center transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Events
            </a>
        </div>
        
        <!-- Event Info -->
        <div class="max-w-4xl mx-auto mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-text-green mb-4">{{ $event->title }}</h1>
            <div class="flex flex-wrap gap-4 text-text-muted mb-6 pb-6 border-b border-background-light">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-accent-1 mr-2"></i>
                    <span>{{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-accent-1 mr-2"></i>
                    <span>{{ $event->location ?? 'Location TBA' }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-images text-accent-1 mr-2"></i>
                    <span>{{ $event->galleries->count() }} {{ Str::plural('Photo', $event->galleries->count()) }}</span>
                </div>
            </div>
            <p class="text-text-muted text-lg leading-relaxed">{{ $event->description }}</p>
        </div>
        
        <!-- Photo Gallery Grid -->
        @if($event->galleries->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="galleryGrid">
            @foreach($event->galleries as $index => $gallery)
            <div class="group cursor-pointer gallery-item" 
                 data-index="{{ $index }}" 
                 data-src="{{ asset('storage/' . $gallery->image) }}" 
                 data-title="{{ $event->title }} - Photo {{ $loop->iteration }}" 
                 data-description="Photo from {{ $event->title }} event at {{ $event->location }}"
                 role="button"
                 tabindex="0"
                 aria-label="View image: {{ $event->title }} - Photo {{ $loop->iteration }}">
                <div class="block overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="relative overflow-hidden aspect-square">
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             alt="{{ $event->title }} - Photo {{ $loop->iteration }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="text-white text-center">
                                <i class="fas fa-search-plus text-2xl mb-1"></i>
                                <p class="text-xs">Click to view</p>
                            </div>
                        </div>
                        @if($gallery->is_thumbnail)
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-md text-xs">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Download All Button (only if images exist) -->
        <div class="text-center mt-12">
            <button id="downloadAllBtn" 
                    class="inline-flex items-center px-6 py-3 bg-accent-1 text-white rounded-lg font-semibold hover:bg-accent-2 transition-colors duration-300 shadow-md">
                <i class="fas fa-download mr-2"></i>
                Download All Photos (ZIP)
            </button>
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <i class="fas fa-camera text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Photos Available</h3>
            <p class="text-gray-500">No photos have been added to this gallery yet.</p>
        </div>
        @endif
    </div>
</section>

<!-- Toast Notification Container -->
<div id="toastContainer" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

<!-- Enhanced Lightbox Modal with Zoom Controls -->
<div id="lightboxModal" 
     class="fixed inset-0 bg-black/95 z-50 hidden justify-center items-center overflow-hidden"
     role="dialog"
     aria-modal="true"
     aria-label="Image gallery lightbox"
     aria-hidden="true">
    <div class="relative w-full h-full flex justify-center items-center overflow-hidden">
        
        <!-- Top Right Controls Group -->
        <div class="absolute top-5 right-5 flex gap-2.5 z-10">
            <button id="downloadCurrentBtn" 
                    class="bg-black/60 text-white border-none w-11 h-11 rounded-full text-lg cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110"
                    aria-label="Download current image">
                <i class="fas fa-download"></i>
            </button>
            <button id="closeLightbox" 
                    class="bg-black/60 text-white border-none w-11 h-11 rounded-full text-3xl cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110"
                    aria-label="Close lightbox">
                &times;
            </button>
        </div>
        
        <!-- Bottom Left Zoom Controls -->
        <div class="absolute bottom-5 left-5 flex gap-2.5 bg-black/60 px-4 py-2 rounded-full z-10">
            <button id="zoomOutBtn" 
                    class="bg-transparent text-white border-none w-10 h-10 text-xl cursor-pointer flex items-center justify-center rounded-full transition-all duration-300 hover:bg-black/80 hover:scale-110"
                    aria-label="Zoom out">
                <i class="fas fa-search-minus"></i>
            </button>
            <span id="zoomLevel" class="text-white text-sm min-w-[45px] text-center leading-10">100%</span>
            <button id="zoomInBtn" 
                    class="bg-transparent text-white border-none w-10 h-10 text-xl cursor-pointer flex items-center justify-center rounded-full transition-all duration-300 hover:bg-black/80 hover:scale-110"
                    aria-label="Zoom in">
                <i class="fas fa-search-plus"></i>
            </button>
            <button id="resetZoomBtn" 
                    class="bg-transparent text-white border-none w-10 h-10 text-sm cursor-pointer flex items-center justify-center rounded-full transition-all duration-300 hover:bg-black/80 hover:scale-110"
                    aria-label="Reset zoom">
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
        <button id="prevImage" 
                class="absolute left-5 top-1/2 -translate-y-1/2 bg-black/50 text-white border-none w-12 h-12 rounded-full text-3xl font-bold cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110 z-10"
                aria-label="Previous image">
            &lt;
        </button>
        <button id="nextImage" 
                class="absolute right-5 top-1/2 -translate-y-1/2 bg-black/50 text-white border-none w-12 h-12 rounded-full text-3xl font-bold cursor-pointer flex items-center justify-center transition-all duration-300 hover:bg-black/80 hover:scale-110 z-10"
                aria-label="Next image">
            &gt;
        </button>
    </div>
</div>

<style>
    /* Hide scrollbars */
    #lightboxModal, #imageContainer {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    #lightboxModal::-webkit-scrollbar, #imageContainer::-webkit-scrollbar {
        display: none;
    }
    
    /* Toast animations */
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        #closeLightbox, #prevImage, #nextImage, #downloadCurrentBtn {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
        
        #prevImage, #nextImage {
            font-size: 28px;
            font-weight: bold;
        }
        
        #zoomInBtn, #zoomOutBtn, #resetZoomBtn {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }
        
        #prevImage {
            left: 10px;
        }
        
        #nextImage {
            right: 10px;
        }
        
        #lightboxCounter {
            top: 10px;
            left: 10px;
            font-size: 12px;
        }
        
        #lightboxCaption {
            bottom: 60px;
            font-size: 11px;
            padding: 8px 16px;
            max-width: 85%;
        }
    }
    
    @media (max-width: 480px) {
        #lightboxCaption {
            bottom: 50px;
            font-size: 10px;
            padding: 6px 12px;
        }
    }
    
    /* Prevent body scroll when lightbox is open */
    body.lightbox-open {
        overflow: hidden;
    }
</style>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
(function() {
    // ==================== CONSTANTS ====================
    const ZOOM_CONFIG = {
        MIN: 0.5,
        MAX: 3,
        STEP: 0.25,
        DEFAULT: 1
    };
    
    const ANIMATION_DURATIONS = {
        ZOOM: 200,
        TOAST: 3000,
        BUTTON_RESET: 1500
    };
    
    // ==================== DOM ELEMENTS ====================
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
    
    // ==================== STATE ====================
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
    
    // ==================== UTILITY FUNCTIONS ====================
    function showToast(message, type = 'info') {
        if (!elements.toastContainer) return;
        
        const toast = document.createElement('div');
        let bgColor = '';
        let icon = '';
        
        if (type === 'success') {
            bgColor = '#10B981';
            icon = '<i class="fas fa-check-circle"></i>';
        } else if (type === 'error') {
            bgColor = '#EF4444';
            icon = '<i class="fas fa-exclamation-circle"></i>';
        } else {
            bgColor = '#3B82F6';
            icon = '<i class="fas fa-info-circle"></i>';
        }
        
        toast.className = 'toast text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 min-w-[250px]';
        toast.style.backgroundColor = bgColor;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'polite');
        
        toast.innerHTML = `${icon}<span>${message}</span>`;
        elements.toastContainer.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('fade-out');
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }, ANIMATION_DURATIONS.TOAST);
    }
    
    function sanitizeFilename(title) {
        return title.replace(/[^a-zA-Z0-9]/g, '_').substring(0, 50);
    }
    
    function updateCursor() {
        if (!elements.imageContainer) return;
        elements.imageContainer.style.cursor = state.currentZoom > 1 ? 'grab' : 'default';
    }
    
    function applyTransform() {
        if (!elements.lightboxImage) return;
        elements.lightboxImage.style.transform = `scale(${state.currentZoom}) translate(${state.translateX}px, ${state.translateY}px)`;
    }
    
    function resetZoomAndPan() {
        state.currentZoom = ZOOM_CONFIG.DEFAULT;
        state.translateX = 0;
        state.translateY = 0;
        state.lastTranslateX = 0;
        state.lastTranslateY = 0;
        applyTransform();
        if (elements.zoomLevelSpan) elements.zoomLevelSpan.textContent = '100%';
        updateCursor();
    }
    
    // ==================== LIGHTBOX FUNCTIONS ====================
    function openLightbox(index) {
        if (!state.imagesArray.length) return;
        
        state.currentIndex = index;
        resetZoomAndPan();
        updateLightboxContent();
        elements.lightbox.style.display = 'flex';
        document.body.classList.add('lightbox-open');
        elements.lightbox.setAttribute('aria-hidden', 'false');
        state.isLightboxOpen = true;
    }
    
    function closeLightbox() {
        elements.lightbox.style.display = 'none';
        document.body.classList.remove('lightbox-open');
        elements.lightbox.setAttribute('aria-hidden', 'true');
        state.isLightboxOpen = false;
        resetZoomAndPan();
    }
    
    function updateLightboxContent() {
        if (!state.imagesArray[state.currentIndex]) return;
        
        const image = state.imagesArray[state.currentIndex];
        elements.lightboxImage.src = image.src;
        elements.lightboxImage.alt = image.title;
        elements.lightboxCaption.textContent = image.description || image.title;
        elements.lightboxCounter.textContent = `${state.currentIndex + 1} / ${state.imagesArray.length}`;
        resetZoomAndPan();
    }
    
    // ==================== ZOOM FUNCTIONS ====================
    function zoomIn() {
        if (state.currentZoom < ZOOM_CONFIG.MAX) {
            state.currentZoom = Math.min(ZOOM_CONFIG.MAX, state.currentZoom + ZOOM_CONFIG.STEP);
            if (elements.zoomLevelSpan) elements.zoomLevelSpan.textContent = Math.round(state.currentZoom * 100) + '%';
            applyTransform();
            updateCursor();
        }
    }
    
    function zoomOut() {
        if (state.currentZoom > ZOOM_CONFIG.MIN) {
            state.currentZoom = Math.max(ZOOM_CONFIG.MIN, state.currentZoom - ZOOM_CONFIG.STEP);
            if (elements.zoomLevelSpan) elements.zoomLevelSpan.textContent = Math.round(state.currentZoom * 100) + '%';
            
            if (state.currentZoom <= 1) {
                state.translateX = 0;
                state.translateY = 0;
                state.lastTranslateX = 0;
                state.lastTranslateY = 0;
            }
            applyTransform();
            updateCursor();
        }
    }
    
    function resetZoom() {
        resetZoomAndPan();
    }
    
    // ==================== PANNING FUNCTIONS ====================
    function startPan(e) {
        if (state.currentZoom <= 1) return;
        e.preventDefault();
        state.isPanning = true;
        if (elements.imageContainer) elements.imageContainer.style.cursor = 'grabbing';
        const clientX = e.clientX || (e.touches ? e.touches[0].clientX : 0);
        const clientY = e.clientY || (e.touches ? e.touches[0].clientY : 0);
        state.startX = clientX - state.lastTranslateX;
        state.startY = clientY - state.lastTranslateY;
    }
    
    function pan(e) {
        if (!state.isPanning || state.currentZoom <= 1) return;
        e.preventDefault();
        const clientX = e.clientX || (e.touches ? e.touches[0].clientX : 0);
        const clientY = e.clientY || (e.touches ? e.touches[0].clientY : 0);
        state.translateX = clientX - state.startX;
        state.translateY = clientY - state.startY;
        
        applyTransform();
    }
    
    function endPan() {
        if (state.isPanning) {
            state.isPanning = false;
            state.lastTranslateX = state.translateX;
            state.lastTranslateY = state.translateY;
            updateCursor();
        }
    }
    
    // ==================== DOWNLOAD FUNCTIONS ====================
    async function downloadCurrentImage() {
        if (!state.imagesArray[state.currentIndex]) return;
        
        const image = state.imagesArray[state.currentIndex];
        const btn = elements.downloadCurrentBtn;
        const originalIcon = btn.innerHTML;
        
        try {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            const response = await fetch(image.src);
            if (!response.ok) throw new Error('Failed to fetch image');
            
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
            }, ANIMATION_DURATIONS.BUTTON_RESET);
        } catch (error) {
            console.error('Error downloading image:', error);
            btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            showToast(`Failed to download: ${image.title}`, 'error');
            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.disabled = false;
            }, ANIMATION_DURATIONS.BUTTON_RESET);
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
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Preparing download...';
        btn.disabled = true;
        
        try {
            const images = state.imagesArray;
            const zip = new JSZip();
            const eventTitle = "{{ $event->title }}";
            const folderName = sanitizeFilename(eventTitle);
            const folder = zip.folder(folderName);
            
            let downloaded = 0;
            const total = images.length;
            
            for (let i = 0; i < images.length; i++) {
                const image = images[i];
                try {
                    btn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Downloading ${i+1}/${total}...`;
                    
                    const response = await fetch(image.src);
                    if (!response.ok) throw new Error(`Failed to fetch ${image.title}`);
                    
                    const blob = await response.blob();
                    const extension = blob.type.split('/')[1] || 'jpg';
                    const filename = `${(i + 1).toString().padStart(2, '0')}_${sanitizeFilename(image.title)}.${extension}`;
                    folder.file(filename, blob);
                    downloaded++;
                } catch (error) {
                    console.error(`Error downloading ${image.title}:`, error);
                    showToast(`Failed to download: ${image.title}`, 'error');
                }
            }
            
            if (downloaded === 0) {
                throw new Error('No images were downloaded');
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
            
            btn.innerHTML = '<i class="fas fa-check mr-2"></i> Download Complete!';
            showToast(`Successfully downloaded ${downloaded} of ${total} images`, 'success');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }, ANIMATION_DURATIONS.BUTTON_RESET);
        } catch (error) {
            console.error('Error creating ZIP:', error);
            btn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Error! Try Again';
            showToast('Failed to create ZIP archive. Please try again.', 'error');
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }, ANIMATION_DURATIONS.BUTTON_RESET);
        }
    }
    
    // ==================== NAVIGATION ====================
    function prevImage() {
        state.currentIndex = (state.currentIndex > 0) ? state.currentIndex - 1 : state.imagesArray.length - 1;
        updateLightboxContent();
    }
    
    function nextImage() {
        state.currentIndex = (state.currentIndex < state.imagesArray.length - 1) ? state.currentIndex + 1 : 0;
        updateLightboxContent();
    }
    
    // ==================== EVENT LISTENERS ====================
    function initEventListeners() {
        if (elements.closeBtn) elements.closeBtn.addEventListener('click', closeLightbox);
        if (elements.prevBtn) elements.prevBtn.addEventListener('click', prevImage);
        if (elements.nextBtn) elements.nextBtn.addEventListener('click', nextImage);
        if (elements.downloadCurrentBtn) elements.downloadCurrentBtn.addEventListener('click', downloadCurrentImage);
        if (elements.zoomInBtn) elements.zoomInBtn.addEventListener('click', zoomIn);
        if (elements.zoomOutBtn) elements.zoomOutBtn.addEventListener('click', zoomOut);
        if (elements.resetZoomBtn) elements.resetZoomBtn.addEventListener('click', resetZoom);
        if (elements.downloadAllBtn) elements.downloadAllBtn.addEventListener('click', downloadAllImages);
        
        // Panning events
        if (elements.imageContainer) {
            elements.imageContainer.addEventListener('mousedown', startPan);
            elements.imageContainer.addEventListener('touchstart', startPan);
            window.addEventListener('mousemove', pan);
            window.addEventListener('touchmove', pan);
            window.addEventListener('mouseup', endPan);
            window.addEventListener('touchend', endPan);
        }
        
        // Close on background click
        if (elements.lightbox) {
            elements.lightbox.addEventListener('click', function(e) {
                if (e.target === elements.lightbox) closeLightbox();
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!state.isLightboxOpen) return;
            
            switch(e.key) {
                case 'ArrowLeft': prevImage(); break;
                case 'ArrowRight': nextImage(); break;
                case 'Escape': closeLightbox(); break;
                case '+': case '=': zoomIn(); e.preventDefault(); break;
                case '-': zoomOut(); e.preventDefault(); break;
                case '0': resetZoom(); e.preventDefault(); break;
            }
        });
        
        // Mouse wheel zoom with Ctrl key
        if (elements.lightbox) {
            elements.lightbox.addEventListener('wheel', function(e) {
                if (state.isLightboxOpen && e.ctrlKey) {
                    e.preventDefault();
                    e.deltaY < 0 ? zoomIn() : zoomOut();
                }
            });
        }
    }
    
    // ==================== INITIALIZATION ====================
    function init() {
        // Build images array from gallery items
        elements.galleryItems = document.querySelectorAll('.gallery-item');
        
        if (elements.galleryItems.length === 0) {
            console.log('No gallery items found');
            return;
        }
        
        elements.galleryItems.forEach((item, index) => {
            state.imagesArray.push({
                src: item.getAttribute('data-src'),
                title: item.getAttribute('data-title'),
                description: item.getAttribute('data-description')
            });
            
            item.addEventListener('click', function(e) {
                e.preventDefault();
                openLightbox(parseInt(this.getAttribute('data-index')));
            });
            
            // Keyboard accessibility for gallery items
            item.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openLightbox(parseInt(this.getAttribute('data-index')));
                }
            });
        });
        
        initEventListeners();
        console.log(`Gallery initialized with ${state.imagesArray.length} images`);
    }
    
    // Start initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush