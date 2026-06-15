// kp-map.js - Interactive Map for KPK Projects Distribution

(function() {
    'use strict';

    console.log('kp-map.js loaded');

    let currentSelectedDivision = null;
    let geoJsonLayer = null;
    let map = null;
    let sectorChart = null;

    // Get dynamic data from PHP
    const divisionsData = typeof window.divisionsDataFromDB !== 'undefined' && window.divisionsDataFromDB ? window.divisionsDataFromDB : {};
    
    console.log('Divisions Data from DB:', divisionsData);

    // Color scale for choropleth (green shades)
    const colors = ['#2E7D32', '#1B5E20', '#0A612B', '#06451F', '#043015', '#03200E', '#021508', '#010A04'];

    // Calculate totals for coloring
    const divisionProjectCounts = {};
    Object.keys(divisionsData).forEach(div => {
        if (divisionsData[div]) {
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
            if (division) {
                totalProjects += division.total_projects || 0;
                totalInvestment += division.investment || 0;
            }
        });
        
        const totalProjectsEl = document.getElementById('total-projects');
        const totalInvestmentEl = document.getElementById('total-investment');
        
        if (totalProjectsEl) totalProjectsEl.textContent = totalProjects;
        if (totalInvestmentEl) totalInvestmentEl.textContent = (totalInvestment / 10000000).toFixed(1);
    }

    function initMap() {
        console.log('Initializing map...');
        
        const mapContainer = document.getElementById('kp-choropleth-map');
        if (!mapContainer) {
            console.error('Map container not found!');
            return;
        }
        
        map = L.map('kp-choropleth-map', {
            center: [33.5, 71.5],
            zoom: 8,
            zoomControl: false,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: false,
            attributionControl: false,
            touchZoom: true,
            fadeAnimation: true,
            zoomAnimation: true
        });
        
        loadGeoJSONFromFile();
    }

    function loadGeoJSONFromFile() {
        console.log('Loading GeoJSON file...');
        
        fetch('/json/kp_divisions.geojson')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('GeoJSON loaded successfully');
                addGeoJsonToMap(data);
            })
            .catch(error => {
                console.error('Error loading GeoJSON:', error);
                showFallbackMessage();
            });
    }

    function showFallbackMessage() {
        const msgDiv = L.divIcon({
            className: 'fallback-msg',
            html: '<div style="background: rgba(0,0,0,0.7); color: white; padding: 10px; border-radius: 5px;">Map data loading failed. Please check GeoJSON file.</div>',
            iconSize: [200, 60]
        });
        L.marker([33.5, 71.5], { icon: msgDiv }).addTo(map);
    }

    function formatDivisionLabel(divisionName) {
        const words = divisionName.split(' ');
        if (words.length > 1) {
            if (words.length === 2) {
                return `${words[0]}<br>${words[1]}`;
            }
            else if (words.length === 3) {
                return `${words[0]}<br>${words[1]} ${words[2]}`;
            }
            else {
                return `${words[0]}<br>${words.slice(1).join(' ')}`;
            }
        }
        return divisionName;
    }

    function addGeoJsonToMap(geoJsonData) {
        console.log('Adding GeoJSON to map');
        
        geoJsonLayer = L.geoJSON(geoJsonData, {
            style: function(feature) {
                let divisionName = feature.properties?.NAME_2;
                if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
                if (divisionName === 'F.A.T.A.') divisionName = 'FATA';
                
                const division = divisionsData[divisionName];
                if (division && divisionName !== 'FATA') {
                    const total = division.total_projects || 0;
                    return {
                        fillColor: getColorForProjectCount(total),
                        weight: 2,
                        color: '#ffffff',
                        fillOpacity: 0.85,
                        opacity: 1
                    };
                } else if (divisionName === 'FATA') {
                    return {
                        fillColor: '#9e9e9e',
                        weight: 2,
                        color: '#ffffff',
                        fillOpacity: 0.7,
                        dashArray: '5, 5',
                        opacity: 1
                    };
                }
                return {
                    fillColor: '#888888',
                    weight: 1.5,
                    color: '#ffffff',
                    fillOpacity: 0.5,
                    opacity: 1
                };
            },
            onEachFeature: function(feature, layer) {
                let divisionName = feature.properties?.NAME_2;
                if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
                const isFATA = divisionName === 'F.A.T.A.';
                const displayName = isFATA ? 'FATA' : divisionName;
                
                const division = divisionsData[isFATA ? 'FATA' : divisionName];
                
                let tooltipContent = `<div style="font-size: 11px;"><strong>${displayName || 'Unknown'}</strong><br>`;
                
                if (division) {
                    tooltipContent += `Total Projects: ${division.total_projects || 0}<br>`;
                    tooltipContent += `<span style="color: #F59E0B;">Pipeline: ${division.projects?.pipeline || 0}</span> | `;
                    tooltipContent += `<span style="color: #10B981;">Ongoing: ${division.projects?.ongoing || 0}</span> | `;
                    tooltipContent += `<span style="color: #3B82F6;">Completed: ${division.projects?.completed || 0}</span><br>`;
                    tooltipContent += `Investment: PKR ${((division.investment || 0) / 10000000).toFixed(1)} Cr`;
                } else {
                    tooltipContent += `No project data available`;
                }
                tooltipContent += `</div>`;
                
                layer.bindTooltip(tooltipContent, { sticky: true, className: 'custom-tooltip' });
                
                if (division) {
                    layer.on('click', function() {
                        if (isFATA) {
                            showDivisionDetail('FATA');
                        } else {
                            showDivisionDetail(divisionName);
                        }
                    });
                }
                
                layer.on('mouseover', function(e) {
                    const layer = e.target;
                    layer.setStyle({
                        fillOpacity: 0.95,
                        weight: 3,
                        color: '#f59e0b'
                    });
                    layer.bringToFront();
                });
                
                layer.on('mouseout', function(e) {
                    if (geoJsonLayer) {
                        geoJsonLayer.resetStyle(e.target);
                    }
                });
                
                if (!isFATA && divisionName && divisionName !== 'F.A.T.A.' && divisionsData[divisionName]) {
                    const bounds = layer.getBounds();
                    if (bounds && bounds.isValid()) {
                        const center = bounds.getCenter();
                        const formattedLabel = formatDivisionLabel(divisionName);
                        
                        const label = L.divIcon({
                            className: 'division-label',
                            html: `<div style="background: rgba(0,0,0,0.6); color: white; padding: 2px 4px; border-radius: 3px; font-size: 8px; font-weight: 500; text-align: center; line-height: 1.3; white-space: normal; text-shadow: 1px 1px 0 rgba(0,0,0,0.3); backdrop-filter: blur(2px);">${formattedLabel}</div>`,
                            iconSize: [45, 20],
                            iconAnchor: [22, 10]
                        });
                        
                        L.marker(center, { icon: label, interactive: false }).addTo(map);
                    }
                }
            }
        }).addTo(map);
        
        try {
            const bounds = geoJsonLayer.getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds);
                map.padBounds(0.05);
            } else {
                map.setView([33.5, 71.5], 8);
            }
        } catch(e) {
            console.warn('Error fitting bounds:', e);
            map.setView([33.5, 71.5], 8);
        }
        
        console.log('GeoJSON added to map successfully');
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
                let layerDivision = layer.feature?.properties?.NAME_2;
                if (layerDivision === 'DeraIsmailKhan') layerDivision = 'Dera Ismail Khan';
                const isFATA = layerDivision === 'F.A.T.A.';
                
                if (layerDivision === divisionName || (isFATA && divisionName === 'FATA')) {
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

    const sectorColorPalette = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
        '#DDA0DD', '#98D8C8', '#F7B731', '#A569BD', '#5DADE2',
        '#E74C3C', '#2ECC71', '#F39C12', '#1ABC9C', '#3498DB',
        '#9B59B6', '#E67E22', '#16A085', '#27AE60', '#2980B9'
    ];
function createSectorChart(division) {
    const chartContainer = document.getElementById('sector-chart');
    if (!chartContainer) return;

    // Destroy previous chart instance immediately to avoid flicker
    if (sectorChart) {
        sectorChart.destroy();
        sectorChart = null;
    }

    // Pre-set container to exact height to prevent layout jump
    chartContainer.style.height = '200px';
    chartContainer.style.position = 'relative';
    chartContainer.innerHTML = '';

    if (!division || !division.projects_list || division.projects_list.length === 0) {
        chartContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No sector data available</div>';
        return;
    }

    const sectorData = {};
    division.projects_list.forEach(project => {
        let sectorName = project.sector;

        if (!sectorName || sectorName === '' || sectorName === 'undefined' || sectorName === 'null') {
            sectorName = 'Other';
        } else {
            sectorName = sectorName.trim();
            sectorName = sectorName.split(' ').map(word =>
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            ).join(' ');
        }

        sectorData[sectorName] = (sectorData[sectorName] || 0) + 1;
    });

    const sectors = Object.keys(sectorData);
    const counts = Object.values(sectorData);

    if (sectors.length === 0) {
        chartContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No sector data available</div>';
        return;
    }

    const sectorColors = {};
    sectors.forEach((sector) => {
        let hash = 0;
        for (let i = 0; i < sector.length; i++) {
            hash = ((hash << 5) - hash) + sector.charCodeAt(i);
            hash |= 0;
        }
        const colorIndex = Math.abs(hash) % sectorColorPalette.length;
        sectorColors[sector] = sectorColorPalette[colorIndex];
    });

    const chartColors = sectors.map(sector => sectorColors[sector]);

    // Create canvas with explicit dimensions to prevent resize flash
    const canvas = document.createElement('canvas');
    canvas.style.display = 'block';
    chartContainer.appendChild(canvas);

    sectorChart = new Chart(canvas, {
        type: 'pie',
        data: {
            labels: sectors,
            datasets: [{
                data: counts,
                backgroundColor: chartColors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // false so the container height (200px) is respected without resize jump
            animation: {
                duration: 300  // Short animation so it feels instant but still smooth
            },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#ffffff',       // Primary legend text color
                        font: { size: 10, weight: 'normal', family: 'sans-serif' },
                        boxWidth: 12,
                        boxHeight: 12,
                        padding: 8,
                        generateLabels: function(chart) {
                            const data = chart.data;
                            const datasets = data.datasets;
                            const labels = data.labels;

                            return labels.map((label, i) => {
                                const displayLabel = label && label !== 'undefined' ? label : 'Other';

                                return {
                                    text: displayLabel,
                                    fillStyle: datasets[0].backgroundColor[i],
                                    strokeStyle: datasets[0].backgroundColor[i],
                                    fontColor: '#ffffff',   // Explicit per-item color (Chart.js v3/v4)
                                    lineWidth: 0,
                                    hidden: false,
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || 'Other';
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
    function getStatusColorClass(category) {
        switch(category) {
            case 'Pipeline': return 'text-yellow-400 border-yellow-500';
            case 'Ongoing': return 'text-green-400 border-green-500';
            case 'Completed': return 'text-blue-400 border-blue-500';
            default: return 'text-gray-400 border-gray-500';
        }
    }

    function getStatusBadge(category) {
        switch(category) {
            case 'Pipeline': return '<span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded">Pipeline</span>';
            case 'Ongoing': return '<span class="text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded">Ongoing</span>';
            case 'Completed': return '<span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded">Completed</span>';
            default: return '';
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showDivisionDetail(divisionName) {
        console.log('Showing division detail for:', divisionName);
        
        const division = divisionsData[divisionName];
        if (!division) {
            console.error('Division not found:', divisionName);
            alert('No data available for this division');
            return;
        }
        
        currentSelectedDivision = divisionName;
        highlightDivision(divisionName);
        
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
        const pipelineEl = document.getElementById('division-pipeline');
        const ongoingEl = document.getElementById('division-ongoing');
        const completedEl = document.getElementById('division-completed');
        
        if (titleEl) titleEl.textContent = displayTitle;
        if (totalProjectsEl) totalProjectsEl.textContent = total;
        if (totalInvestmentEl) totalInvestmentEl.textContent = (investment / 10000000).toFixed(1);
        if (avgCostEl) avgCostEl.textContent = avgCost.toFixed(1);
        if (pipelineEl) pipelineEl.textContent = division.projects?.pipeline || 0;
        if (ongoingEl) ongoingEl.textContent = division.projects?.ongoing || 0;
        if (completedEl) completedEl.textContent = division.projects?.completed || 0;
        
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
                division.projects_list.slice(0, 10).forEach(project => {
                    const borderColorClass = getStatusColorClass(project.category);
                    const statusBadge = getStatusBadge(project.category);
                    const costDisplay = project.cost_display || `PKR ${((project.cost || 0) / 10000000).toFixed(1)} Cr`;
                    
                    const projectDiv = document.createElement('div');
                    projectDiv.className = `bg-white/10 rounded-lg p-3 hover:bg-white/20 transition-all duration-200 border-l-4 ${borderColorClass} cursor-pointer`;
                    projectDiv.onclick = () => {
                        if (project.id) {
                            window.location.href = `/project/${project.id}`;
                        }
                    };
                    projectDiv.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="font-medium text-white text-sm flex-1">${escapeHtml(project.name)}</div>
                            ${statusBadge}
                        </div>
                        <div class="text-xs text-gray-300 mt-1">${escapeHtml(project.sector || 'N/A')}</div>
                        <div class="text-xs ${borderColorClass} mt-1">Cost: ${escapeHtml(costDisplay)}</div>
                    `;
                    projectsContainer.appendChild(projectDiv);
                });
            }
        }
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

    function initStatNumberAnimation() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        const animateNumber = (element) => {
            const target = parseInt(element.getAttribute('data-count'));
            if (isNaN(target)) return;
            
            let current = 0;
            const increment = target / 50;
            const updateNumber = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current);
                    requestAnimationFrame(updateNumber);
                } else {
                    element.textContent = target;
                }
            };
            updateNumber();
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        statNumbers.forEach(number => observer.observe(number));
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');
        initStatNumberAnimation();
        updateTotalStats();
        initMap();
        
        const resetViewBtn = document.getElementById('reset-view');
        if (resetViewBtn) {
            resetViewBtn.addEventListener('click', resetToDefaultView);
        }
        
        const backToAllBtn = document.getElementById('back-to-all');
        if (backToAllBtn) {
            backToAllBtn.addEventListener('click', resetToDefaultView);
        }
    });
})();