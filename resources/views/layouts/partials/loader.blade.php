<!-- Simple Green Circular Page Loader -->
<div id="page-loader" class="fixed inset-0 z-9999 bg-white flex items-center justify-center transition-all duration-500">
    <div class="text-center">
        <!-- Simple Green Circular Loader -->
        <div class="relative inline-flex items-center justify-center">
            <!-- Main spinning circle -->
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-4 border-green-100 border-t-green-600 border-r-green-600 animate-spin"></div>
        </div>
        
        <!-- Optional Loading Text -->
        <div class="mt-6">
            <p class="text-gray-500 text-sm font-medium animate-pulse">Loading...</p>
        </div>
    </div>
</div>

<style>
    /* Simple spin animation for the loader */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Pulse animation for text */
    @keyframes pulse {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 1; }
    }
    
    .animate-pulse {
        animation: pulse 1.5s ease-in-out infinite;
    }
</style>

<script>
    // Hide loader when page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
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