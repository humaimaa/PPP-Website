// kp-map.js - Interactive Map for KPK Projects Distribution

// Division data for all KPK divisions
const divisionsData = {
    'Bannu': {
        name: 'Bannu',
        projects: { active: 4, completed: 2, planned: 3 },
        investment: 520.40,
        projects_list: [
            { name: 'Bannu Medical College', type: 'active', cost: 280.0, sector: 'Health', description: 'Medical education facility' },
            { name: 'Bannu Industrial Estate', type: 'planned', cost: 150.0, sector: 'Industrial', description: 'Industrial zone development' },
            { name: 'Lakki Marwat Road', type: 'completed', cost: 90.4, sector: 'Transport', description: 'Road connectivity project' }
        ]
    },
    'Dera Ismail Khan': {
        name: 'Dera Ismail Khan',
        projects: { active: 4, completed: 2, planned: 2 },
        investment: 440.60,
        projects_list: [
            { name: 'DI Khan Airport Upgrade', type: 'active', cost: 210.0, sector: 'Transport', description: 'Airport expansion and upgrade' },
            { name: 'DI Khan Teaching Hospital', type: 'completed', cost: 180.0, sector: 'Health', description: 'Teaching hospital facility' },
            { name: 'Daraban Road Project', type: 'planned', cost: 50.6, sector: 'Transport', description: 'Road construction project' }
        ]
    },
    'Hazara': {
        name: 'Hazara',
        projects: { active: 10, completed: 6, planned: 4 },
        investment: 2150.25,
        projects_list: [
            { name: 'Abbottabad Cable Car', type: 'active', cost: 320.0, sector: 'Tourism', description: 'Scenic cable car project' },
            { name: 'Mansehra-Muzaffarabad Road', type: 'completed', cost: 890.0, sector: 'Transport', description: 'Strategic road link' },
            { name: 'Hazara University Expansion', type: 'active', cost: 185.0, sector: 'Education', description: 'Campus expansion project' },
            { name: 'Haripur Industrial Zone', type: 'planned', cost: 755.25, sector: 'Industrial', description: 'New industrial estate' }
        ]
    },
    'Kohat': {
        name: 'Kohat',
        projects: { active: 5, completed: 3, planned: 2 },
        investment: 675.80,
        projects_list: [
            { name: 'Kohat Tunnel Second Tube', type: 'active', cost: 420.0, sector: 'Transport', description: 'Second tube of Kohat Tunnel' },
            { name: 'Kohat Water Supply Scheme', type: 'completed', cost: 155.0, sector: 'Water', description: 'Water supply for Kohat city' },
            { name: 'Kohat University Expansion', type: 'planned', cost: 100.8, sector: 'Education', description: 'University campus expansion' }
        ]
    },
    'Malakand': {
        name: 'Malakand',
        projects: { active: 8, completed: 3, planned: 6 },
        investment: 1875.50,
        projects_list: [
            { name: 'Swat Expressway', type: 'active', cost: 1250.0, sector: 'Transport', description: 'High-speed road connecting Malakand division' },
            { name: 'Malam Jabba Chairlift Upgrade', type: 'active', cost: 180.0, sector: 'Tourism', description: 'Modern chairlift system' },
            { name: 'Kalam Tourism Development', type: 'planned', cost: 250.0, sector: 'Tourism', description: 'Tourism infrastructure development' },
            { name: 'Lower Dir Water Supply', type: 'completed', cost: 95.5, sector: 'Water', description: 'Clean water supply project' }
        ]
    },
    'Mardan': {
        name: 'Mardan',
        projects: { active: 6, completed: 4, planned: 3 },
        investment: 985.30,
        projects_list: [
            { name: 'Mardan Sports Complex', type: 'active', cost: 125.0, sector: 'Sports', description: 'Multi-purpose sports facility' },
            { name: 'Mardan Industrial Zone', type: 'completed', cost: 350.0, sector: 'Industrial', description: 'Industrial park for small businesses' },
            { name: 'Women University Mardan', type: 'active', cost: 210.0, sector: 'Education', description: 'Higher education for women' },
            { name: 'Mardan Bypass Road', type: 'planned', cost: 300.3, sector: 'Transport', description: 'Ring road project' }
        ]
    },
    'Peshawar': {
        name: 'Peshawar',
        projects: { active: 12, completed: 8, planned: 5 },
        investment: 2450.75,
        projects_list: [
            { name: 'Peshawar Bus Rapid Transit', type: 'active', cost: 850.5, sector: 'Transport', description: 'Modern BRT system connecting major areas of Peshawar' },
            { name: 'Hayatabad Medical Complex Expansion', type: 'active', cost: 320.0, sector: 'Health', description: 'Expansion of tertiary care facility' },
            { name: 'Regi Model Town Development', type: 'completed', cost: 450.0, sector: 'Urban', description: 'Modern residential and commercial area' },
            { name: 'Peshawar Sustainable Water Supply', type: 'planned', cost: 280.0, sector: 'Water', description: 'Clean water supply project' }
        ]
    }
};

// Color scale for choropleth (green shades matching the design)
const colors = ['#2E7D32', '#1B5E20', '#0A612B', '#06451F', '#043015', '#03200E', '#021508', '#010A04'];

// Global variables
let currentSelectedDivision = null;
let geoJsonLayer = null;
let map = null;
let sectorChart = null;

// Calculate totals
const divisionProjectCounts = {};
Object.keys(divisionsData).forEach(div => {
    const d = divisionsData[div];
    divisionProjectCounts[div] = d.projects.active + d.projects.completed + d.projects.planned;
});

const maxProjects = Math.max(...Object.values(divisionProjectCounts));
const minProjects = Math.min(...Object.values(divisionProjectCounts));

function getColorForProjectCount(count) {
    if (maxProjects === minProjects) return colors[4];
    const index = Math.floor(((count - minProjects) / (maxProjects - minProjects)) * (colors.length - 1));
    return colors[Math.min(index, colors.length - 1)];
}

function updateTotalStats() {
    let totalProjects = 0;
    let totalInvestment = 0;
    Object.values(divisionsData).forEach(division => {
        totalProjects += division.projects.active + division.projects.completed + division.projects.planned;
        totalInvestment += division.investment;
    });
    
    const totalProjectsEl = document.getElementById('total-projects');
    const totalInvestmentEl = document.getElementById('total-investment');
    
    if (totalProjectsEl) totalProjectsEl.textContent = totalProjects;
    if (totalInvestmentEl) totalInvestmentEl.textContent = totalInvestment.toFixed(1);
}

// Initialize Leaflet Map with NO zoom controls
function initMap() {
    map = L.map('kp-choropleth-map', {
        center: [33.5, 71.5],
        zoom: 7,
        zoomControl: false,  // Disable zoom control
        scrollWheelZoom: true,
        doubleClickZoom: true,
        boxZoom: false,
        attributionControl: false,
        touchZoom: true
    });
    
    loadGeoJSONFromFile();
}

function loadGeoJSONFromFile() {
    fetch('/json/kp_divisions.geojson')
        .then(response => response.json())
        .then(data => {
            console.log('GeoJSON loaded successfully');
            const filteredData = {
                type: 'FeatureCollection',
                features: data.features
            };
            addGeoJsonToMap(filteredData);
        })
        .catch(error => {
            console.error('Error loading GeoJSON:', error);
        });
}

function addGeoJsonToMap(geoJsonData) {
    geoJsonLayer = L.geoJSON(geoJsonData, {
        style: function(feature) {
            let divisionName = feature.properties.NAME_2;
            if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
            if (divisionName === 'F.A.T.A.') divisionName = 'FATA';
            
            const division = divisionsData[divisionName];
            if (division && divisionName !== 'FATA') {
                const total = division.projects.active + division.projects.completed + division.projects.planned;
                return {
                    fillColor: getColorForProjectCount(total),
                    weight: 1.5,
                    color: '#ffffff',
                    fillOpacity: 0.85
                };
            } else if (divisionName === 'FATA') {
                return {
                    fillColor: '#9e9e9e',
                    weight: 1,
                    color: '#ffffff',
                    fillOpacity: 0.5,
                    dashArray: '5, 5'
                };
            }
            return {
                fillColor: '#888888',
                weight: 1,
                color: '#ffffff',
                fillOpacity: 0.5
            };
        },
        onEachFeature: function(feature, layer) {
            let divisionName = feature.properties.NAME_2;
            if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
            
            const division = divisionsData[divisionName];
            
            if (division && divisionName !== 'FATA') {
                layer.on('click', function() {
                    showDivisionDetail(divisionName);
                });
                
                layer.on('mouseover', function(e) {
                    const layer = e.target;
                    layer.setStyle({
                        fillOpacity: 0.95,
                        weight: 2.5,
                        color: '#f59e0b'
                    });
                    layer.bringToFront();
                });
                
                layer.on('mouseout', function(e) {
                    if (geoJsonLayer) {
                        geoJsonLayer.resetStyle(e.target);
                    }
                });
            }
        }
    }).addTo(map);
    
    const bounds = geoJsonLayer.getBounds();
    if (bounds.isValid()) {
        map.fitBounds(bounds);
    } else {
        map.setView([33.5, 71.5], 7);
    }
}

function resetDivisionHighlights() {
    if (geoJsonLayer) {
        geoJsonLayer.eachLayer(function(layer) {
            geoJsonLayer.resetStyle(layer);
        });
    }
}

function highlightDivision(divisionName) {
    resetDivisionHighlights();
    if (geoJsonLayer) {
        geoJsonLayer.eachLayer(function(layer) {
            let layerDivision = layer.feature.properties.NAME_2;
            if (layerDivision === 'DeraIsmailKhan') layerDivision = 'Dera Ismail Khan';
            if (layerDivision === divisionName) {
                layer.setStyle({
                    fillOpacity: 0.95,
                    weight: 3,
                    color: '#f59e0b'
                });
                layer.bringToFront();
            }
        });
    }
}

// Display all divisions in grid (Default View)
function displayAllDivisions() {
    const container = document.getElementById('divisions-grid');
    if (!container) return;
    
    container.innerHTML = '';
    
    const sortedDivisions = Object.keys(divisionsData).sort();
    
    sortedDivisions.forEach(divisionName => {
        const division = divisionsData[divisionName];
        const total = division.projects.active + division.projects.completed + division.projects.planned;
        
        const card = document.createElement('div');
        card.className = 'bg-white/10 rounded-lg p-3 cursor-pointer hover:bg-white/20 transition-all duration-200 text-center';
        card.onclick = () => showDivisionDetail(divisionName);
        
        if (total === 0) {
            card.innerHTML = `
                <div class="font-semibold text-white text-sm">${division.name}</div>
                <div class="text-2xl font-bold text-gray-400 mt-1">0</div>
                <div class="text-xs text-gray-400 mt-1">Projects</div>
                <div class="text-xs text-gray-500 mt-2">No active projects yet</div>
            `;
        } else {
            card.innerHTML = `
                <div class="font-semibold text-white text-sm">${division.name}</div>
                <div class="text-2xl font-bold text-green-400 mt-1">${total}</div>
                <div class="text-xs text-gray-300">Projects</div>
                <div class="text-xs text-green-500 mt-1">PKR ${division.investment.toFixed(0)} Cr</div>
            `;
        }
        
        container.appendChild(card);
    });
}

// Create Pie Chart for sectors
function createSectorChart(division) {
    const sectorData = {};
    division.projects_list.forEach(project => {
        sectorData[project.sector] = (sectorData[project.sector] || 0) + 1;
    });
    
    const sectors = Object.keys(sectorData);
    const counts = Object.values(sectorData);
    const chartColors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
    
    const chartContainer = document.getElementById('sector-chart');
    if (!chartContainer) return;
    
    chartContainer.innerHTML = '';
    
    if (sectors.length === 0) {
        chartContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No sector data available</div>';
        return;
    }
    
    const canvas = document.createElement('canvas');
    chartContainer.appendChild(canvas);
    
    if (sectorChart) {
        sectorChart.destroy();
    }
    
    sectorChart = new Chart(canvas, {
        type: 'pie',
        data: {
            labels: sectors,
            datasets: [{
                data: counts,
                backgroundColor: chartColors.slice(0, sectors.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'white',
                        font: { size: 10 },
                        generateLabels: function(chart) {
                            const original = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                            original.forEach(label => {
                                label.text = label.text + ' (' + sectorData[label.text] + ')';
                            });
                            return original;
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} projects (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Show division detail view
function showDivisionDetail(divisionName) {
    const division = divisionsData[divisionName];
    if (!division) return;
    
    currentSelectedDivision = divisionName;
    highlightDivision(divisionName);
    
    // Switch views
    document.getElementById('default-view').classList.add('hidden');
    document.getElementById('division-view').classList.remove('hidden');
    
    // Make parent div transparent
    const statsPanel = document.getElementById('stats-panel');
    statsPanel.classList.remove('bg-gradient-to-br', 'from-[#0D2818]', 'to-[#1a4a2a]');
    statsPanel.classList.add('bg-black/50', 'backdrop-blur-sm');
    
    // Update division details
    const total = division.projects.active + division.projects.completed + division.projects.planned;
    document.getElementById('division-title').textContent = division.name + ' Division';
    document.getElementById('division-total-projects').textContent = total;
    document.getElementById('division-total-investment').textContent = division.investment.toFixed(1);
    document.getElementById('division-active').textContent = division.projects.active;
    document.getElementById('division-completed').textContent = division.projects.completed;
    document.getElementById('division-planned').textContent = division.projects.planned;
    
    createSectorChart(division);
    
    const projectsContainer = document.getElementById('division-projects-list');
    projectsContainer.innerHTML = '';
    
    if (division.projects_list.length === 0) {
        projectsContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No projects found for this division</div>';
    } else {
        division.projects_list.forEach(project => {
            let borderColor, textColor;
            if (project.type === 'active') {
                borderColor = 'border-green-500';
                textColor = 'text-green-400';
            } else if (project.type === 'completed') {
                borderColor = 'border-blue-500';
                textColor = 'text-blue-400';
            } else {
                borderColor = 'border-orange-500';
                textColor = 'text-orange-400';
            }
            
            const projectDiv = document.createElement('div');
            projectDiv.className = `bg-white/10 rounded-lg p-3 hover:bg-white/20 transition-all duration-200 border-l-4 ${borderColor} relative group`;
            projectDiv.innerHTML = `
                <div class="font-medium text-white text-sm">${project.name}</div>
                <div class="text-xs text-gray-300 mt-1">${project.sector}</div>
                <div class="text-xs ${textColor}">Cost: PKR ${project.cost} Cr</div>
                <div class="hidden group-hover:block absolute left-0 top-full mt-1 z-10 bg-gray-900 text-white text-xs rounded p-2 whitespace-nowrap shadow-lg">
                    ${project.description}
                </div>
            `;
            projectsContainer.appendChild(projectDiv);
        });
    }
}

// Reset to default view
function resetToDefaultView() {
    currentSelectedDivision = null;
    resetDivisionHighlights();
    
    document.getElementById('default-view').classList.remove('hidden');
    document.getElementById('division-view').classList.add('hidden');
    
    const statsPanel = document.getElementById('stats-panel');
    statsPanel.classList.remove('bg-black/50', 'backdrop-blur-sm');
    
    if (sectorChart) {
        sectorChart.destroy();
        sectorChart = null;
    }
    
    updateTotalStats();
    displayAllDivisions();
}

// Initialize everything
document.addEventListener('DOMContentLoaded', function() {
    updateTotalStats();
    initMap();
    displayAllDivisions();
    
    const resetViewBtn = document.getElementById('reset-view');
    if (resetViewBtn) {
        resetViewBtn.addEventListener('click', resetToDefaultView);
    }
    
    const backToAllBtn = document.getElementById('back-to-all');
    if (backToAllBtn) {
        backToAllBtn.addEventListener('click', resetToDefaultView);
    }
});