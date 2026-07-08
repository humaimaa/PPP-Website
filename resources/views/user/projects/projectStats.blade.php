@extends('layouts.app')

@section('title', 'PPP Unit KP - Projects Statistics')

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Projects Statistics
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
</section>

<!-- Stats Section with 4 Cards -->
<section class="py-10 bg-background-light" id="stats-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text-green animate-on-scroll-title">Our Impact in Numbers</h2>
            <div class="w-20 h-1.5 bg-accent-1 mx-auto mt-4 rounded"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto text-sm md:text-md lg:text-base">
                Tracking the progress and success of PPP projects across Khyber Pakhtunkhwa
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Pipeline Projects -->
            <div class="text-center p-6 md:p-8 rounded-xl bg-background-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-accent-1">
                <div class="stat-number text-3xl md:text-4xl lg:text-5xl font-bold text-accent-1 mb-3"
                    data-count="{{ $pipelineCount ?? 0 }}">0</div>
                <p class="text-text-muted text-sm md:text-base font-medium">Pipeline Projects</p>
            </div>

            <!-- Ongoing Projects -->
            <div class="text-center p-6 md:p-8 rounded-xl bg-background-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-green-500">
                <div class="stat-number text-3xl md:text-4xl lg:text-5xl font-bold text-green-600 mb-3"
                    data-count="{{ $ongoingCount ?? 0 }}">0</div>
                <p class="text-text-muted text-sm md:text-base font-medium">Ongoing Projects</p>
            </div>

            <!-- Completed Projects -->
            <div class="text-center p-6 md:p-8 rounded-xl bg-background-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-blue-500">
                <div class="stat-number text-3xl md:text-4xl lg:text-5xl font-bold text-blue-600 mb-3"
                    data-count="{{ $completedCount ?? 0 }}">0</div>
                <p class="text-text-muted text-sm md:text-base font-medium">Completed Projects</p>
            </div>

            <!-- Total Projects -->
            <div class="text-center p-6 md:p-8 rounded-xl bg-background-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-purple-500">
                <div class="stat-number text-3xl md:text-4xl lg:text-5xl font-bold text-purple-600 mb-3"
                    data-count="{{ $totalProjects ?? 0 }}">0</div>
                <p class="text-text-muted text-sm md:text-base font-medium">Total Projects</p>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-10 bg-background-white" id="map-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text-green animate-on-scroll-title">Projects Distribution Across Khyber Pakhtunkhwa</h2>
            <div class="w-20 h-1.5 bg-accent-1 mx-auto mt-4 rounded"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto text-sm md:text-md lg:text-base">
                Click on any division to view its projects and details
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 lg:items-stretch">
            <div class="w-full lg:w-1/2 z-10 flex flex-col" id="map-column">
                <div id="kp-choropleth-map"
                    style="flex: 1; min-height: 400px; width: 100%; background-color: var(--color-background-light); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div id="stats-panel"
                    class="bg-gradient-to-br from-primary to-primary-light rounded-lg p-6 transition-all duration-300 h-full border border-gray-200/30">
                    <div id="default-view">
                        <div class="flex justify-between items-center mb-3 border-b border-gray-600/30 pb-2">
                            <h3 class="text-xl font-bold text-white">Projects Overview</h3>
                            <button id="reset-view"
                                class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1 rounded transition-all duration-300">Show All</button>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-accent-1" id="total-projects">{{ $totalProjects ?? 0 }}</div>
                                <div class="text-sm text-text-secondary mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-accent-1" id="total-divisions">8</div>
                                <div class="text-sm text-text-secondary mt-1">Divisions</div>
                            </div>
                        </div>

                        <h4 class="font-semibold mb-3 text-lg text-white">All Divisions</h4>
                        <div id="divisions-grid"
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-96 overflow-y-auto pr-1">
                            @foreach($divisionsGrid as $division)
                            <div class="bg-white/10 rounded-lg p-3 cursor-pointer hover:bg-white/20 transition-all duration-200 division-card text-center"
                                data-division="{{ $division['name'] }}">
                                <div class="font-semibold text-white text-sm">
                                    @if($division['name'] === 'FATA')
                                    Merged Districts
                                    @else
                                    {{ $division['name'] }}
                                    @endif
                                </div>
                                <div class="text-2xl font-bold text-accent-1 mt-1">{{ $division['total'] }}</div>
                                <div class="text-xs text-text-secondary">Total Projects</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="division-view" class="hidden">
                        <div class="flex justify-between items-center mb-3 border-b border-gray-600/30 pb-2">
                            <h3 class="text-xl font-bold text-white" id="division-title"></h3>
                            <button id="back-to-all"
                                class="text-xs bg-white/10 hover:bg-white/20 text-white px-3 py-1 rounded transition-all duration-300">Back to All</button>
                        </div>

                        <div class="flex flex-row gap-2 text-center text-sm mb-3">
                            <div class="bg-white/10 rounded-lg p-2 flex-1 min-w-0">
                                <div class="font-bold text-accent-1 text-lg" id="division-total-projects">0</div>
                                <div class="text-xs text-text-secondary">Total</div>
                            </div>
                            <div class="bg-yellow-500/20 rounded-lg p-2 flex-1 min-w-0">
                                <div class="font-bold text-yellow-400 text-lg" id="division-pipeline">0</div>
                                <div class="text-xs text-text-secondary">Pipeline</div>
                            </div>
                            <div class="bg-green-500/20 rounded-lg p-2 flex-1 min-w-0">
                                <div class="font-bold text-green-400 text-lg" id="division-ongoing">0</div>
                                <div class="text-xs text-text-secondary">Ongoing</div>
                            </div>
                            <div class="bg-blue-500/20 rounded-lg p-2 flex-1 min-w-0">
                                <div class="font-bold text-blue-400 text-lg" id="division-completed">0</div>
                                <div class="text-xs text-text-secondary">Completed</div>
                            </div>
                        </div>

                        <div id="merged-districts-section" class="hidden mb-3">
                            <h4 class="font-semibold mb-2 text-sm text-white">Merged Districts</h4>
                            <div id="merged-districts-list" class="flex flex-wrap gap-2 mb-3"></div>
                        </div>

                        <h4 class="font-semibold mb-2 text-sm text-white">Projects by Sector</h4>
                        <div id="sector-chart" class="mb-3" style="height: 200px;"></div>

                        <h4 class="font-semibold mb-2 text-sm text-white">Project Details</h4>
                        <div id="division-projects-list" class="space-y-2 max-h-64 overflow-y-auto pr-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pitchbook Section -->
<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-text-green animate-on-scroll-title">Our Pitchbook</h2>
            <div class="w-20 h-1.5 bg-accent-1 mx-auto mt-4 rounded"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto text-sm md:text-md lg:text-base">
                Explore our comprehensive pitchbook showcasing PPP opportunities in Khyber Pakhtunkhwa
            </p>
        </div>
        
        <div class="flex justify-center items-center">
            <a href="{{ url('/pitchbook') }}"
                class="inline-block transition-all duration-300 hover:scale-105 hover:-translate-y-1 group">
                <div class="relative rounded-lg overflow-hidden  hover:scale-105 transition-all duration-300">
                    <img src="{{ asset('images/Pitchbook-Cover.png') }}" alt="Pitchbook Cover"
                        class="w-60 h-40 md:w-80 md:h-50 ">
                    
                </div>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Only custom styles not covered by app.css */
    
    /* Map tooltip styles */
    .custom-tooltip {
        background: rgba(0, 0, 0, 0.8) !important;
        border: none !important;
        border-radius: 4px !important;
        color: white !important;
        font-size: 11px !important;
        padding: 4px 8px !important;
    }

    .division-label {
        background: transparent !important;
        border: none !important;
    }

    .division-label div {
        font-size: 8px !important;
        padding: 2px 4px !important;
        white-space: normal !important;
        text-align: center !important;
        line-height: 1.3 !important;
    }

    /* Scrollbar styles for division projects list */
    #division-projects-list::-webkit-scrollbar {
        width: 6px;
    }

    #division-projects-list::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    #division-projects-list::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    #division-projects-list::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Map container styles */
    #kp-choropleth-map {
        background-color: var(--color-background-light);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .leaflet-container {
        background-color: var(--color-background-light);
    }

    /* Chart.js overrides */
    #sector-chart canvas {
        color: white !important;
    }

    /* Stats panel text overrides */
    #stats-panel .text-text-secondary {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Remove card effects from division cards */
    .division-card {
        transition: background-color 0.2s ease !important;
    }
    
    .division-card:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
        transform: none !important;
    }

    /* Remove shadow from stats panel */
    #stats-panel {
        box-shadow: none !important;
    }

    /* Remove hover effects from project items */
    #division-projects-list .bg-white\/10 {
        transition: background-color 0.2s ease !important;
    }
    
    #division-projects-list .bg-white\/10:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
        transform: none !important;
    }
</style>
@endpush

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    window.divisionsDataFromDB = @json($divisionsDataForMap);
    window.sectorChartDataFromDB = @json($sectorChartData);
</script>
<script>
    // Override Chart.js defaults AFTER chart.js loads but BEFORE kp-map.js runs
    document.querySelector('script[src*="chart"]') && (function waitForChart() {
        if (typeof Chart !== 'undefined') {
            Chart.defaults.color = '#ffffff';
            Chart.defaults.borderColor = 'rgba(255,255,255,0.15)';
        } else {
            setTimeout(waitForChart, 50);
        }
    })();
</script>
@vite([
'resources/js/kp-map.js'
])
@endpush

@endsection