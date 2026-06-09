// kp-map.js - Interactive Map for KPK Projects Distribution (Dynamic from Database)

// Global variables
let currentSelectedDivision = null;
let geoJsonLayer = null;
let map = null;
let sectorChart = null;

// Use divisions data passed from PHP
const divisionsData = typeof divisionsDataFromDB !== 'undefined' ? divisionsDataFromDB : {};

// Color scale for choropleth (green shades matching the design)
const colors = ['#2E7D32', '#1B5E20', '#0A612B', '#06451F', '#043015', '#03200E', '#021508', '#010A04'];

// Calculate totals for coloring
const divisionProjectCounts = {};
Object.keys(divisionsData).forEach(div => {
    if (divisionsData[div] && divisionsData[div].projects) {
        divisionProjectCounts[div] = divisionsData[div].total_projects || 0;
    }
});

const maxProjects = Math.max(...Object.values(divisionProjectCounts), 1);
const minProjects = Math.min(...Object.values(divisionProjectCounts), 0);

function getColorForProjectCount(count) {
    if (maxProjects === minProjects) return colors[4];
    const index = Math.floor(((count - minProjects) / (maxProjects - minProjects)) * (colors.length - 1));
    return colors[Math.min(index, colors.length - 1)];
}

function updateTotalStats() {
    let totalProjects = 0;
    let totalInvestment = 0;
    Object.values(divisionsData).forEach(division => {
        if (division && division.projects) {
            totalProjects += division.total_projects || 0;
            totalInvestment += division.investment || 0;
        }
    });
    
    const totalProjectsEl = document.getElementById('total-projects');
    const totalInvestmentEl = document.getElementById('total-investment');
    
    if (totalProjectsEl) totalProjectsEl.textContent = totalProjects;
    if (totalInvestmentEl) totalInvestmentEl.textContent = (totalInvestment / 10000000).toFixed(1);
}

// Initialize Leaflet Map
function initMap() {
    map = L.map('kp-choropleth-map', {
        center: [33.5, 71.5],
        zoom: 7,
        zoomControl: false,
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
            addGeoJsonToMap(data);
        })
        .catch(error => {
            console.error('Error loading GeoJSON:', error);
        });
}

function isFATARegion(feature) {
    const name2 = feature.properties.NAME_2;
    const name1 = feature.properties.NAME_1;
    return name2 === 'F.A.T.A.' || 
           name2 === 'FATA' || 
           name1 === 'FederallyAdministeredTribalAr' ||
           (name1 && name1.includes('Federally'));
}

function addGeoJsonToMap(geoJsonData) {
    geoJsonLayer = L.geoJSON(geoJsonData, {
        style: function(feature) {
            let divisionName = feature.properties.NAME_2;
            if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
            
            const isFATA = isFATARegion(feature);
            
            if (!isFATA) {
                const division = divisionsData[divisionName];
                if (division) {
                    const total = division.total_projects || 0;
                    return {
                        fillColor: getColorForProjectCount(total),
                        weight: 1.5,
                        color: '#ffffff',
                        fillOpacity: 0.85
                    };
                }
                return {
                    fillColor: '#888888',
                    weight: 1,
                    color: '#ffffff',
                    fillOpacity: 0.5
                };
            } else {
                return {
                    fillColor: '#9e9e9e',
                    weight: 1.5,
                    color: '#ffffff',
                    fillOpacity: 0.7,
                    dashArray: '3, 3'
                };
            }
        },
        onEachFeature: function(feature, layer) {
            let divisionName = feature.properties.NAME_2;
            if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
            
            const isFATA = isFATARegion(feature);
            
            let displayName = divisionName;
            if (isFATA) {
                displayName = 'Merged Districts';
            }
            
            const division = divisionsData[divisionName === 'F.A.T.A.' ? 'FATA' : divisionName];
            
            let tooltipContent = `<div style="font-size: 11px;"><strong>${displayName}</strong><br>`;
            if (!isFATA && division) {
                tooltipContent += `Projects: ${division.total_projects || 0}<br>Investment: PKR ${((division.investment || 0) / 10000000).toFixed(1)} Cr</div>`;
            } else if (isFATA && divisionsData['FATA']) {
                tooltipContent += `Projects: ${divisionsData['FATA'].total_projects || 0}<br>Investment: PKR ${((divisionsData['FATA'].investment || 0) / 10000000).toFixed(1)} Cr<br><span style="font-size: 9px;">(7 Merged Districts)</span></div>`;
            } else {
                tooltipContent += `No projects data available</div>`;
            }
            
            layer.bindTooltip(tooltipContent, {
                sticky: true,
                className: 'custom-tooltip'
            });
            
            layer.on('click', function() {
                if (isFATA) {
                    showDivisionDetail('FATA');
                } else if (division) {
                    showDivisionDetail(divisionName);
                }
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
            
            // Add labels for regular divisions only (not for Merged Districts)
            if (!isFATA && divisionName && divisionName !== 'F.A.T.A.' && divisionName !== 'FATA') {
                const bounds = layer.getBounds();
                if (bounds && bounds.isValid()) {
                    const center = bounds.getCenter();
                    
                    const label = L.divIcon({
                        className: 'division-label',
                        html: `<div style="background: rgba(0,0,0,0.6); color: white; padding: 2px 5px; border-radius: 3px; font-size: 9px; font-weight: 500; white-space: nowrap; text-shadow: 1px 1px 0 rgba(0,0,0,0.3); backdrop-filter: blur(2px);">${displayName}</div>`,
                        iconSize: [50, 16],
                        iconAnchor: [25, 8]
                    });
                    
                    L.marker(center, { icon: label, interactive: false }).addTo(map);
                }
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
            
            const isFATA = isFATARegion(layer.feature);
            
            if ((layerDivision === divisionName) || (isFATA && divisionName === 'FATA')) {
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

function displayAllDivisions() {
    const container = document.getElementById('divisions-grid');
    if (!container) return;
    
    const cards = container.querySelectorAll('.division-card');
    if (cards.length > 0) {
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const divisionName = this.getAttribute('data-division');
                showDivisionDetail(divisionName);
            });
        });
    }
}

// Create Pie Chart for sectors - FIXED to show sector names correctly
function createSectorChart(division) {
    if (!division || !division.projects_list || division.projects_list.length === 0) {
        const chartContainer = document.getElementById('sector-chart');
        if (chartContainer) {
            chartContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No sector data available</div>';
        }
        return;
    }
    
    const sectorData = {};
    division.projects_list.forEach(project => {
        if (project.sector && project.sector !== '' && project.sector !== 'undefined') {
            let sectorName = project.sector;
            // Capitalize first letter of each word for better display
            sectorName = sectorName.split(' ').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');
            sectorData[sectorName] = (sectorData[sectorName] || 0) + 1;
        }
    });
    
    const sectors = Object.keys(sectorData);
    const counts = Object.values(sectorData);
    const chartColors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16', '#FF6B6B', '#4ECDC4'];
    
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
                                const count = sectorData[label.text];
                                label.text = `${label.text} (${count})`;
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
                            return `${label}: ${value} project${value !== 1 ? 's' : ''} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Show division detail view
function showDivisionDetail(divisionName) {
    let actualDivisionName = divisionName;
    if (divisionName === 'F.A.T.A.' || divisionName === 'FATA' || divisionName === 'Merged Districts' || divisionName === 'FATA (Merged Districts)') {
        actualDivisionName = 'FATA';
    }
    
    const division = divisionsData[actualDivisionName];
    if (!division) {
        console.error('Division not found:', actualDivisionName);
        const projectsContainer = document.getElementById('division-projects-list');
        if (projectsContainer) {
            projectsContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No project data available for this region</div>';
        }
        return;
    }
    
    currentSelectedDivision = actualDivisionName;
    highlightDivision(actualDivisionName);
    
    const defaultView = document.getElementById('default-view');
    const divisionView = document.getElementById('division-view');
    
    if (defaultView) defaultView.classList.add('hidden');
    if (divisionView) divisionView.classList.remove('hidden');
    
    const total = division.total_projects || 0;
    const investment = division.investment || 0;
    const avgCost = total > 0 ? (investment / total) / 10000000 : 0;
    
    const displayTitle = division.is_merged ? 'Merged Districts (Former FATA)' : (division.name + ' Division');
    
    const titleEl = document.getElementById('division-title');
    const totalProjectsEl = document.getElementById('division-total-projects');
    const totalInvestmentEl = document.getElementById('division-total-investment');
    const avgCostEl = document.getElementById('division-avg-cost');
    const activeEl = document.getElementById('division-active');
    const completedEl = document.getElementById('division-completed');
    const plannedEl = document.getElementById('division-planned');
    
    if (titleEl) titleEl.textContent = displayTitle;
    if (totalProjectsEl) totalProjectsEl.textContent = total;
    if (totalInvestmentEl) totalInvestmentEl.textContent = (investment / 10000000).toFixed(1);
    if (avgCostEl) avgCostEl.textContent = avgCost.toFixed(1);
    if (activeEl) activeEl.textContent = division.projects?.active || 0;
    if (completedEl) completedEl.textContent = division.projects?.completed || 0;
    if (plannedEl) plannedEl.textContent = division.projects?.planned || 0;
    
    const mergedDistrictsSection = document.getElementById('merged-districts-section');
    if (division.is_merged && division.merged_districts && mergedDistrictsSection) {
        mergedDistrictsSection.classList.remove('hidden');
        const mergedList = document.getElementById('merged-districts-list');
        if (mergedList) {
            mergedList.innerHTML = '';
            division.merged_districts.forEach(district => {
                const badge = document.createElement('span');
                badge.className = 'bg-gray-700 text-white text-xs px-2 py-1 rounded';
                badge.textContent = district;
                mergedList.appendChild(badge);
            });
        }
    } else if (mergedDistrictsSection) {
        mergedDistrictsSection.classList.add('hidden');
    }
    
    createSectorChart(division);
    
    const projectsContainer = document.getElementById('division-projects-list');
    if (projectsContainer) {
        projectsContainer.innerHTML = '';
        
        if (!division.projects_list || division.projects_list.length === 0) {
            projectsContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No projects found for this division</div>';
        } else {
            division.projects_list.forEach(project => {
                let borderColor, textColor;
                const projectType = (project.category || project.type || '').toLowerCase();
                
                if (projectType === 'ongoing') {
                    borderColor = 'border-green-500';
                    textColor = 'text-green-400';
                } else if (projectType === 'completed') {
                    borderColor = 'border-blue-500';
                    textColor = 'text-blue-400';
                } else {
                    borderColor = 'border-orange-500';
                    textColor = 'text-orange-400';
                }
                
                const costInCrores = ((project.cost || 0) / 10000000).toFixed(1);
                const costDisplay = project.cost_display || `PKR ${costInCrores} Cr`;
                
                const projectDiv = document.createElement('div');
                projectDiv.className = `bg-white/10 rounded-lg p-3 hover:bg-white/20 transition-all duration-200 border-l-4 ${borderColor} relative group cursor-pointer`;
                projectDiv.onclick = () => {
                    if (project.id) {
                        window.location.href = `/projects/${project.id}`;
                    }
                };
                projectDiv.innerHTML = `
                    <div class="font-medium text-white text-sm">${escapeHtml(project.name)}</div>
                    <div class="text-xs text-gray-300 mt-1">${escapeHtml(project.sector || 'N/A')}</div>
                    <div class="text-xs ${textColor}">Cost: ${escapeHtml(costDisplay)}</div>
                    <div class="hidden group-hover:block absolute left-0 top-full mt-1 z-10 bg-gray-900 text-white text-xs rounded p-2 whitespace-normal max-w-xs shadow-lg">
                        ${escapeHtml(project.description || 'No description available')}
                    </div>
                `;
                projectsContainer.appendChild(projectDiv);
            });
        }
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function resetToDefaultView() {
    currentSelectedDivision = null;
    resetDivisionHighlights();
    
    const defaultView = document.getElementById('default-view');
    const divisionView = document.getElementById('division-view');
    
    if (defaultView) defaultView.classList.remove('hidden');
    if (divisionView) divisionView.classList.add('hidden');
    
    if (sectorChart) {
        sectorChart.destroy();
        sectorChart = null;
    }
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