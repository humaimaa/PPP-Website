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

    // Color scale for choropleth (using theme accent and primary colors)
    const colors = [
        '#B39339', // accent-1 (highest)
        '#c4a747', // accent-2
        '#8a7a2e', // darker gold
        '#6a5d24', // even darker
        '#4a401a', // dark
        '#2a2510', // very dark
        '#1a180a', // nearly black
        '#0D2617'  // primary (lowest)
    ];

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
        // Count unique projects across all divisions (avoid double counting)
        const allProjectsMap = {};
        Object.values(divisionsData).forEach(division => {
            if (division && division.projects_list) {
                division.projects_list.forEach(project => {
                    allProjectsMap[project.id] = true;
                });
            }
        });
        
        const totalUniqueProjects = Object.keys(allProjectsMap).length;
        const totalProjectsEl = document.getElementById('total-projects');
        if (totalProjectsEl) totalProjectsEl.textContent = totalUniqueProjects;
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
            html: '<div style="background: rgba(13, 38, 23, 0.9); color: white; padding: 10px; border-radius: 5px; border: 1px solid #B39339;">Map data loading failed. Please check GeoJSON file.</div>',
            iconSize: [200, 60]
        });
        L.marker([33.5, 71.5], { icon: msgDiv }).addTo(map);
    }

    function formatDivisionLabel(divisionName) {
        // Special handling for FATA
        if (divisionName === 'FATA' || divisionName === 'F.A.T.A.') {
            return 'Merged<br>Districts';
        }
        
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

    function getDisplayName(divisionName) {
        // Special handling for FATA
        if (divisionName === 'FATA' || divisionName === 'F.A.T.A.') {
            return 'Merged Districts';
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
                        fillColor: '#6b7280',
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
                const displayName = isFATA ? 'Merged Districts' : divisionName;
                const dataKey = isFATA ? 'FATA' : divisionName;
                
                const division = divisionsData[dataKey];
                
                let tooltipContent = `<div style="font-size: 11px; color: white;"><strong>${displayName || 'Unknown'}</strong><br>`;
                
                if (division) {
                    tooltipContent += `Total Projects: ${division.total_projects || 0}<br>`;
                    tooltipContent += `<span style="color: #B39339;">Pipeline: ${division.projects?.pipeline || 0}</span> | `;
                    tooltipContent += `<span style="color: #10B981;">Ongoing: ${division.projects?.ongoing || 0}</span> | `;
                    tooltipContent += `<span style="color: #3B82F6;">Completed: ${division.projects?.completed || 0}</span>`;
                } else {
                    tooltipContent += `No project data available`;
                }
                tooltipContent += `</div>`;
                
                layer.bindTooltip(tooltipContent, { 
                    sticky: true, 
                    className: 'custom-tooltip',
                    direction: 'center'
                });
                
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
                        color: '#B39339'
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
                            html: `<div style="background: rgba(13, 38, 23, 0.8); color: white; padding: 2px 4px; border-radius: 3px; font-size: 8px; font-weight: 500; text-align: center; line-height: 1.3; white-space: normal; text-shadow: 1px 1px 0 rgba(0,0,0,0.3); backdrop-filter: blur(2px); border: 1px solid rgba(179, 147, 57, 0.3);">${formattedLabel}</div>`,
                            iconSize: [45, 20],
                            iconAnchor: [22, 10]
                        });
                        
                        L.marker(center, { icon: label, interactive: false }).addTo(map);
                    }
                } else if (isFATA) {
                    // Add label for FATA as "Merged Districts"
                    const bounds = layer.getBounds();
                    if (bounds && bounds.isValid()) {
                        const center = bounds.getCenter();
                        const label = L.divIcon({
                            className: 'division-label',
                            html: `<div style="background: rgba(13, 38, 23, 0.8); color: white; padding: 2px 4px; border-radius: 3px; font-size: 8px; font-weight: 500; text-align: center; line-height: 1.3; white-space: normal; text-shadow: 1px 1px 0 rgba(0,0,0,0.3); backdrop-filter: blur(2px); border: 1px solid rgba(179, 147, 57, 0.3);">Merged<br>Districts</div>`,
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
                        color: '#B39339'
                    });
                    layer.bringToFront();
                }
            });
        }
    }

    const sectorColorPalette = [
        '#B39339', // accent-1
        '#c4a747', // accent-2
        '#FF6B6B', 
        '#4ECDC4', 
        '#45B7D1', 
        '#96CEB4', 
        '#FFEAA7',
        '#DDA0DD', 
        '#98D8C8', 
        '#F7B731', 
        '#A569BD', 
        '#5DADE2',
        '#E74C3C', 
        '#2ECC71', 
        '#F39C12', 
        '#1ABC9C', 
        '#3498DB',
        '#9B59B6', 
        '#E67E22', 
        '#16A085', 
        '#27AE60', 
        '#2980B9'
    ];

    function createSectorChart(division) {
        // Set Chart.js global defaults so canvas-rendered text is white
        Chart.defaults.color = '#ffffff';
        Chart.defaults.borderColor = 'rgba(255,255,255,0.15)';

        const chartContainer = document.getElementById('sector-chart');
        if (!chartContainer) return;

        if (sectorChart) {
            sectorChart.destroy();
            sectorChart = null;
        }

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

        // Dynamic height: 24px per bar, min 80px
        const chartHeight = Math.max(80, sectors.length * 24 + 20);
        chartContainer.style.height = chartHeight + 'px';
        chartContainer.style.position = 'relative';

        const chartColors = sectors.map(sector => {
            let hash = 0;
            for (let i = 0; i < sector.length; i++) {
                hash = ((hash << 5) - hash) + sector.charCodeAt(i);
                hash |= 0;
            }
            return sectorColorPalette[Math.abs(hash) % sectorColorPalette.length];
        });

        const canvas = document.createElement('canvas');
        chartContainer.appendChild(canvas);

        sectorChart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: sectors,
                datasets: [{
                    data: counts,
                    backgroundColor: chartColors,
                    borderWidth: 0,
                    borderRadius: 3,
                    barThickness: 12
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 300 },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.x || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${value} project${value !== 1 ? 's' : ''} (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff',
                            font: { size: 10 },
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.15)'
                        },
                        border: {
                            color: 'rgba(255,255,255,0.2)'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ffffff',
                            font: { size: 10 },
                            autoSkip: false
                        },
                        grid: { display: false },
                        border: {
                            color: 'rgba(255,255,255,0.2)'
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
            case 'Construction & Operational': return 'text-blue-400 border-blue-500';
            default: return 'text-gray-400 border-gray-500';
        }
    }

    function getStatusBadge(category) {
        switch(category) {
            case 'Pipeline': return '<span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded">Pipeline</span>';
            case 'Ongoing': return '<span class="text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded">Ongoing</span>';
            case 'Construction & Operational': return '<span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded">Completed</span>';
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
        // Use "Merged Districts" for FATA
        const displayTitle = division.is_merged ? 'Merged Districts (Former FATA)' : (division.name + ' Division');
        
        const titleEl = document.getElementById('division-title');
        const totalProjectsEl = document.getElementById('division-total-projects');
        const pipelineEl = document.getElementById('division-pipeline');
        const ongoingEl = document.getElementById('division-ongoing');
        const completedEl = document.getElementById('division-completed');
        
        if (titleEl) titleEl.textContent = displayTitle;
        if (totalProjectsEl) totalProjectsEl.textContent = total;
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
                // Show all projects (not just first 10) for better visibility
                division.projects_list.forEach(project => {
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

    function syncMapHeight() {
        const statsPanel = document.getElementById('stats-panel');
        const mapColumn = document.getElementById('map-column');
        const mapContainer = document.getElementById('kp-choropleth-map');

        if (!statsPanel || !mapColumn || !mapContainer) return;

        if (window.innerWidth >= 1024) {
            const panelHeight = statsPanel.offsetHeight;
            mapColumn.style.height = panelHeight + 'px';
            mapContainer.style.height = '100%';
        } else {
            mapColumn.style.height = '';
            mapContainer.style.height = '';
            mapContainer.style.minHeight = '400px';
        }

        if (map) {
            setTimeout(() => map.invalidateSize(), 50);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');
        initStatNumberAnimation();
        updateTotalStats();
        initMap();

        const statsPanel = document.getElementById('stats-panel');
        if (statsPanel && window.ResizeObserver) {
            const ro = new ResizeObserver(() => syncMapHeight());
            ro.observe(statsPanel);
        }

        window.addEventListener('resize', syncMapHeight);
        
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