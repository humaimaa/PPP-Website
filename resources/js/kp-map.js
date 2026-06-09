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

    // Color scale for choropleth (green shades matching the design)
    const colors = ['#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c', '#2e7d32'];

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

    function addGeoJsonToMap(geoJsonData) {
        console.log('Adding GeoJSON to map');
        
        geoJsonLayer = L.geoJSON(geoJsonData, {
            style: function(feature) {
                let divisionName = feature.properties?.NAME_2;
                // Handle special cases
                if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
                if (divisionName === 'F.A.T.A.') divisionName = 'FATA';
                
                const division = divisionsData[divisionName];
                if (division && divisionName !== 'FATA') {
                    const total = division.total_projects || 0;
                    return {
                        fillColor: getColorForProjectCount(total),
                        weight: 1.5,
                        color: '#ffffff',
                        fillOpacity: 0.85
                    };
                } else if (divisionName === 'FATA') {
                    return {
                        fillColor: '#9e9e9e',
                        weight: 1.5,
                        color: '#ffffff',
                        fillOpacity: 0.7,
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
                let divisionName = feature.properties?.NAME_2;
                if (divisionName === 'DeraIsmailKhan') divisionName = 'Dera Ismail Khan';
                const isFATA = divisionName === 'F.A.T.A.';
                const displayName = isFATA ? 'FATA (Merged Districts)' : divisionName;
                
                const division = divisionsData[isFATA ? 'FATA' : divisionName];
                
                let tooltipContent = `<div style="font-size: 12px;"><strong>${displayName || 'Unknown'}</strong><br>`;
                
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
                
                // Add click handler for non-FATA regions that have data
                if (division && !isFATA) {
                    layer.on('click', function() {
                        showDivisionDetail(divisionName);
                    });
                } else if (isFATA && divisionsData['FATA']) {
                    layer.on('click', function() {
                        showDivisionDetail('FATA');
                    });
                }
                
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
        }).addTo(map);
        
        // Fit map to bounds
        try {
            const bounds = geoJsonLayer.getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds);
            } else {
                map.setView([33.5, 71.5], 7);
            }
        } catch(e) {
            console.warn('Error fitting bounds:', e);
            map.setView([33.5, 71.5], 7);
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

    function createSectorChart(division) {
        const chartContainer = document.getElementById('sector-chart');
        if (!chartContainer) return;
        
        if (!division || !division.projects_list || division.projects_list.length === 0) {
            chartContainer.innerHTML = '<div class="text-center text-gray-400 py-4">No sector data available</div>';
            return;
        }
        
        const sectorData = {};
        division.projects_list.forEach(project => {
            if (project.sector && project.sector !== '' && project.sector !== 'undefined') {
                let sectorName = project.sector.trim();
                sectorName = sectorName.split(' ').map(word => 
                    word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
                ).join(' ');
                sectorData[sectorName] = (sectorData[sectorName] || 0) + 1;
            }
        });
        
        const sectors = Object.keys(sectorData);
        const counts = Object.values(sectorData);
        const chartColors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16', '#FF6B6B', '#4ECDC4'];
        
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
                            window.location.href = `/projects/${project.id}`;
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

    // Initialize everything
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