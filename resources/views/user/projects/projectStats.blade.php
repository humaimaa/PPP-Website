<!-- Only the sector chart section changes - add this CSS for better legend display -->
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
/* Sector chart legend styles */
#sector-chart {
    position: relative;
}
.chart-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
    justify-content: center;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
    color: white;
}
.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}
</style>
@endpush