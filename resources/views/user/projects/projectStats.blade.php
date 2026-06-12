@extends('layouts.app')

@section('title', 'PPP Unit KPK - Projects Statistics')

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Projects Statistics
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4 max-w-2xl mx-auto">
                Comprehensive overview of all public-private partnership initiatives across Khyber Pakhtunkhwa
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
</section>

<!-- Stats Section with 4 Cards -->
<section class="w-full py-10 px-12 md:px-12 bg-gray-50" id="stats-section">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">Our Impact in Numbers</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto rounded"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-yellow-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-yellow-600 mb-3" data-count="{{ $pipelineCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Pipeline Projects</p>
            </div>
            
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-green-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-green-600 mb-3" data-count="{{ $ongoingCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Ongoing Projects</p>
            </div>
            
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-blue-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-blue-600 mb-3" data-count="{{ $completedCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Completed Projects</p>
           </div>
            
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-purple-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-purple-600 mb-3" data-count="{{ $totalProjects ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Total Projects</p>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="bg-background-white" id="map-section">
    <div class="container-fluid px-4 sm:px-6 lg:px-8 bg-background-gray/10 py-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary">Projects Distribution Across Khyber Pakhtunkhwa</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto mt-4"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">Click on any division to view its projects and details</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="w-full lg:w-1/2 z-10">
                <div id="kp-choropleth-map" style="height: 550px; width: 100%; background-color: #e8f0e8; border-radius: 8px;"></div>
            </div>

            <div class="w-full lg:w-1/2">
                <div id="stats-panel" class="bg-gradient-to-br from-[#0D2818] to-[#1a4a2a] shadow-lg rounded-lg p-6 transition-all duration-300 h-full">
                    <div id="default-view">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-600 pb-2">
                            <h3 class="text-xl font-bold text-white">Projects Overview</h3>
                            <button id="reset-view" class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded transition">Show All</button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="total-projects">{{ $totalProjects ?? 0 }}</div>
                                <div class="text-sm text-gray-300 mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="total-investment">{{ number_format(($totalInvestment ?? 0) / 10000000, 1) }}</div>
                                <div class="text-sm text-gray-300 mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="total-divisions">8</div>
                                <div class="text-sm text-gray-300 mt-1">Divisions</div>
                            </div>
                        </div>

                        <h4 class="font-semibold mb-3 text-lg text-white">All Divisions</h4>
                        <div id="divisions-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 max-h-96 overflow-y-auto pr-1">
                            @foreach($divisionsGrid as $division)
                            <div class="bg-white/10 rounded-lg p-3 cursor-pointer hover:bg-white/20 transition-all duration-200 division-card text-center" 
                                 data-division="{{ $division['name'] }}">
                                <div class="font-semibold text-white text-sm">{{ $division['name'] }}</div>
                                <div class="text-2xl font-bold text-green-400 mt-1">{{ $division['total'] }}</div>
                                <div class="text-xs text-gray-300">Total Projects</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="division-view" class="hidden">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-600 pb-2">
                            <h3 class="text-xl font-bold text-white" id="division-title"></h3>
                            <button id="back-to-all" class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded transition">Back to All</button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="division-total-projects">0</div>
                                <div class="text-sm text-gray-300 mt-1">Total Projects</div>
                            </div>
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="division-total-investment">0</div>
                                <div class="text-sm text-gray-300 mt-1">Total Investment (PKR Cr)</div>
                            </div>
                            <div class="text-center bg-white/10 rounded-lg p-3">
                                <div class="text-3xl font-bold text-green-400" id="division-avg-cost">0</div>
                                <div class="text-sm text-gray-300 mt-1">Avg Project Cost (Cr)</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center text-sm mb-4">
                            <div class="bg-yellow-500/20 rounded p-2">
                                <div class="font-bold text-yellow-400 text-lg" id="division-pipeline">0</div>
                                <div class="text-xs text-gray-300">Pipeline</div>
                            </div>
                            <div class="bg-green-500/20 rounded p-2">
                                <div class="font-bold text-green-400 text-lg" id="division-ongoing">0</div>
                                <div class="text-xs text-gray-300">Ongoing</div>
                            </div>
                            <div class="bg-blue-500/20 rounded p-2">
                                <div class="font-bold text-blue-400 text-lg" id="division-completed">0</div>
                                <div class="text-xs text-gray-300">Completed</div>
                            </div>
                        </div>

                        <div id="merged-districts-section" class="hidden mb-4">
                            <h4 class="font-semibold mb-2 text-sm text-white">Merged Districts</h4>
                            <div id="merged-districts-list" class="flex flex-wrap gap-2 mb-4"></div>
                        </div>

                        <h4 class="font-semibold mb-2 text-sm text-white">Projects by Sector</h4>
                        <div id="sector-chart" class="mb-4" style="height: 200px;"></div>

                        <h4 class="font-semibold mb-2 text-sm text-white">Project Details</h4>
                        <div id="division-projects-list" class="space-y-2 max-h-64 overflow-y-auto pr-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pitchbook Section -->
<section class="py-10 bg-gray-50 w-full">
    <div class="w-full px-0">
        <div class="text-center mb-4 overflow-hidden">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800">Our Pitchbook</h2>
            <div class="w-20 h-1 bg-yellow-500 mx-auto mt-4"></div>
        </div>
        <div class="flex justify-center items-center w-full">
            <a href="{{ url('/pitchbook') }}" class="inline-block transition-all duration-300 hover:scale-105 hover:-translate-y-1">
                <img src="{{ asset('images/Pitchbook-Cover.png') }}" alt="Pitchbook Icon" 
                    class="w-60 h-40 md:w-90 md:h-50 drop-shadow-lg hover:drop-shadow-xl">
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
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
.division-card {
    transition: all 0.2s ease;
}
#kp-choropleth-map {
    background-color: #e8f0e8;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.leaflet-container {
    background-color: #e8f0e8;
}

/* Sector Chart Legend - Make text white */
#sector-chart {
    position: relative;
}

/* Force white text for Chart.js legend - Multiple selectors for full coverage */
.chartjs-legend,
.chartjs-legend ul,
.chartjs-legend li,
.chartjs-legend li span,
.chartjs-legend ul li,
.chartjs-legend ul li span,
canvas + div,
canvas + div ul,
canvas + div li,
canvas + div li span,
.legend-label,
.legend-label span,
.chart-legend,
.chart-legend span {
    color: white !important;
}

/* Target the legend text specifically */
.chartjs-legend ul li span:last-child,
canvas + div ul li span:last-child,
.legend-text {
    color: white !important;
}

/* Target any legend elements */
[class*="legend"] span,
[class*="legend"] li,
div[class*="legend"] {
    color: white !important;
}

/* Target the legend label text */
.legend-label-text {
    color: white !important;
}

/* Target Chart.js generated legend items */
.chartjs-legend li span:last-child {
    color: white !important;
}

/* Force white text on all legend related elements */
#sector-chart ~ div span,
#sector-chart + div span,
.canvasjs-chart-legend span {
    color: white !important;
}

/* Ensure tooltip text is also white */
.custom-tooltip {
    color: white !important;
}

/* Division grid text colors */
.division-card {
    color: white !important;
}

/* Stats panel text colors */
#stats-panel,
#stats-panel * {
    color: white;
}

/* Override any black text specifically in legend */
.legend-item span,
.chartjs-legend ul li span {
    color: white !important;
    fill: white !important;
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
  @vite([ 
        'resources/js/kp-map.js'
    ])
@endpush

@endsection