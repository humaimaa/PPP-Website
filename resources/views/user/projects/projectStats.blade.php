@extends('layouts.app')

@section('title', 'PPP Department KPK - Projects Statistics')

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
            <!-- Pipeline Projects Card -->
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-yellow-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-yellow-600 mb-3" data-count="{{ $pipelineCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Pipeline Projects</p>
                <p class="text-xs text-gray-500 mt-2">Investment: PKR {{ number_format(($pipelineInvestment ?? 0) / 10000000, 1) }} Cr</p>
            </div>
            
            <!-- Ongoing Projects Card -->
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-green-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-green-600 mb-3" data-count="{{ $ongoingCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Ongoing Projects</p>
                <p class="text-xs text-gray-500 mt-2">Investment: PKR {{ number_format(($ongoingInvestment ?? 0) / 10000000, 1) }} Cr</p>
            </div>
            
            <!-- Completed Projects Card -->
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-blue-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-blue-600 mb-3" data-count="{{ $completedCount ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Completed Projects</p>
                <p class="text-xs text-gray-500 mt-2">Investment: PKR {{ number_format(($completedInvestment ?? 0) / 10000000, 1) }} Cr</p>
            </div>
            
            <!-- Total Projects Card -->
            <div class="text-center p-5 md:p-8 rounded-xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border-t-4 border-purple-500">
                <div class="stat-number text-4xl md:text-5xl lg:text-6xl font-bold text-purple-600 mb-3" data-count="{{ $totalProjects ?? 0 }}">0</div>
                <p class="text-gray-700 text-sm md:text-base font-medium">Total Projects</p>
                <p class="text-xs text-gray-500 mt-2">Investment: PKR {{ number_format(($totalInvestment ?? 0) / 10000000, 1) }} Cr</p>
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
            <!-- Map Container -->
            <div class="w-full lg:w-1/2 z-10">
                <div id="kp-choropleth-map" class="overflow-hidden" style="height: 500px; background-color: transparent; cursor: default;"></div>
            </div>

            <!-- Projects Stats Panel -->
            <div class="w-full lg:w-1/2">
                <div id="stats-panel" class="bg-gradient-to-br from-[#0D2818] to-[#1a4a2a] shadow-lg rounded-lg p-6 transition-all duration-300 h-full">
                    <!-- Default View (No Division Selected) -->
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
                            <div class="bg-white/10 rounded-lg p-3 cursor-pointer hover:bg-white/20 transition-all duration-200 division-card" 
                                 data-division="{{ $division['name'] }}">
                                <div class="font-semibold text-white text-sm">{{ $division['name'] }}</div>
                                <div class="text-2xl font-bold text-green-400 mt-1">{{ $division['total'] }}</div>
                                <div class="text-xs text-gray-300">Total Projects</div>
                                <div class="flex justify-center gap-2 mt-2 text-xs">
                                    <span class="text-yellow-400">P: {{ $division['pipeline'] }}</span>
                                    <span class="text-green-400">O: {{ $division['ongoing'] }}</span>
                                    <span class="text-blue-400">C: {{ $division['completed'] }}</span>
                                </div>
                                <div class="text-xs text-green-500 mt-1">PKR {{ number_format($division['investment'] / 10000000, 1) }} Cr</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Division Detail View (Initially Hidden) -->
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

                        <!-- Merged Districts Section (for FATA) -->
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
    font-size: 12px !important;
    padding: 4px 8px !important;
}

.division-label {
    background: transparent !important;
    border: none !important;
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

.status-pipeline { background-color: #D97706; }
.status-ongoing { background-color: #10B981; }
.status-completed { background-color: #3B82F6; }

.division-card {
    transition: all 0.2s ease;
}
</style>
@endpush

@push('scripts')
<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Pass PHP data to JavaScript
window.divisionsDataFromDB = @json($divisionsDataForMap);
window.sectorChartDataFromDB = @json($sectorChartData);
</script>

<script src="{{ asset('js/kp-map.js') }}"></script>
@endpush

@endsection