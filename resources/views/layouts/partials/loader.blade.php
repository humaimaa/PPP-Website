<!-- Sand Hourglass Page Loader -->
<div id="page-loader" class="fixed inset-0 z-[9999] bg-primary flex items-center justify-center transition-all duration-500">
    <div class="text-center">
        <!-- Sand Hourglass Icon -->
        <div class="relative mb-8 inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20">
            <div class="hourglass-container animate-rotate-slow">
                <svg class="w-16 h-16 md:w-20 md:h-20 text-accent-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Hourglass top -->
                    <path d="M5 2h14" class="stroke-accent-1"/>
                    <path d="M5 2v4c0 2 1 3 3 4c-2 1-3 2-3 4v4" class="stroke-accent-1/60"/>
                    <path d="M19 2v4c0 2-1 3-3 4c2 1 3 2 3 4v4" class="stroke-accent-1/40"/>
                    <path d="M5 22h14" class="stroke-accent-1"/>
                    
                    <!-- Sand particles falling -->
                    <circle cx="12" cy="8" r="0.8" class="fill-accent-1 animate-fall-1"/>
                    <circle cx="11.5" cy="10" r="0.7" class="fill-accent-1 animate-fall-2"/>
                    <circle cx="12.3" cy="12" r="0.6" class="fill-accent-1 animate-fall-3"/>
                    <circle cx="11.8" cy="14" r="0.8" class="fill-accent-1 animate-fall-4"/>
                    <circle cx="12.2" cy="16" r="0.7" class="fill-accent-1 animate-fall-5"/>
                    
                    <!-- Sand pile at bottom -->
                    <path d="M10 20h4" class="stroke-accent-1 animate-sand-pile"/>
                </svg>
            </div>
            
            <!-- Outer rotating ring -->
            <div class="absolute inset-0 rounded-full border-2 border-accent-1/20 animate-spin-slow"></div>
            <div class="absolute inset-0 rounded-full border-t-2 border-accent-1 animate-spin-slow-reverse"></div>
        </div>
        
        <!-- Loading Text with Animated Dots -->
        <div class="mt-6">
            <div class="flex items-center justify-center space-x-1">
               
                <div class="flex space-x-1">
                    <span class="w-2 h-2 bg-accent-1 rounded-full animate-bounce-dot" style="animation-delay: 0s"></span>
                    <span class="w-2 h-2 bg-accent-1 rounded-full animate-bounce-dot" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 bg-accent-1 rounded-full animate-bounce-dot" style="animation-delay: 0.4s"></span>
                </div>
            </div>
           
        </div>
    </div>
</div>

<style>
    /* Hourglass rotation animations */
    @keyframes rotateSlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes rotateSlowReverse {
        0% { transform: rotate(360deg); }
        100% { transform: rotate(0deg); }
    }
    
    /* Sand falling animations */
    @keyframes fall1 {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(12px); opacity: 0; }
    }
    
    @keyframes fall2 {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(14px); opacity: 0; }
    }
    
    @keyframes fall3 {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(16px); opacity: 0; }
    }
    
    @keyframes fall4 {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(18px); opacity: 0; }
    }
    
    @keyframes fall5 {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(20px); opacity: 0; }
    }
    
    /* Sand pile animation */
    @keyframes sandPile {
        0%, 100% { d: path("M10 20h4"); }
        50% { d: path("M9 20h6"); }
    }
    
    /* Bounce dots for loading text */
    @keyframes bounceDot {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }
    
    /* Text pulse */
    @keyframes pulseText {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 1; }
    }
    
    /* Animation classes */
    .animate-rotate-slow {
        animation: rotateSlow 3s linear infinite;
        transform-origin: center;
    }
    
    .animate-spin-slow {
        animation: rotateSlow 4s linear infinite;
    }
    
    .animate-spin-slow-reverse {
        animation: rotateSlowReverse 4s linear infinite;
    }
    
    .animate-fall-1 {
        animation: fall1 1.5s ease-in infinite;
    }
    
    .animate-fall-2 {
        animation: fall2 1.8s ease-in infinite 0.3s;
    }
    
    .animate-fall-3 {
        animation: fall3 2s ease-in infinite 0.6s;
    }
    
    .animate-fall-4 {
        animation: fall4 1.7s ease-in infinite 0.9s;
    }
    
    .animate-fall-5 {
        animation: fall5 1.9s ease-in infinite 1.2s;
    }
    
    .animate-sand-pile {
        animation: sandPile 2s ease-in-out infinite;
    }
    
    .animate-bounce-dot {
        animation: bounceDot 1.4s ease-in-out infinite;
    }
    
    .animate-pulse-text {
        animation: pulseText 2s ease-in-out infinite;
    }
</style>

<script>
    // Hide loader when page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            // Add a slight delay for smoother transition
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 800);
        }
    });
    
    // Also hide loader if page loads faster
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        if (loader && loader.style.display !== 'none') {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    });
</script>