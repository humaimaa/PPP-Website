@props([
    'currentPage' => 1, 
    'lastPage' => 1, 
    'total' => 0, 
    'perPage' => 9, 
    'status' => null,        // For projects (all, pipeline, ongoing, operational)
    'section' => null,       // For about page (overview, team)
    'tenderType' => null,    // For tenders (active, archived)
    'routeName' => null,     // Custom route name if needed
    'params' => [],          // Additional route parameters
    'queryParams' => []      // Query string parameters
])

@php
    $start = ($currentPage - 1) * $perPage + 1;
    $end = min($currentPage * $perPage, $total);
    
    // Get current URL parameters if not explicitly passed
    if (empty($queryParams)) {
        $queryParams = request()->query();
        unset($queryParams['page']);
    }
    
    // Build the base URL based on what's provided
    if ($routeName) {
        // Build route parameters
        $routeParams = [];
        
        // For projects index route: {category}/{status}
        if ($routeName === 'projects.index') {
            // Use the params passed explicitly or build from status/category
            if (!empty($params)) {
                $routeParams = $params;
            } else {
                // Fallback: use status and category from props
                $routeParams['category'] = 'all';
                $routeParams['status'] = 'all';
            }
        }
        // For about routes: {section?}
        elseif ($routeName === 'about.index' || $routeName === 'about.functions' || 
                $routeName === 'about.message' || $routeName === 'about.vision-mission' ||
                $routeName === 'about.team' || $routeName === 'about.organogram') {
            if ($section) {
                $routeParams['section'] = $section;
            }
        }
        // For tenders: {section?}
        elseif ($routeName === 'tenders') {
            if ($tenderType) {
                $routeParams['section'] = $tenderType;
            }
        }
        // For resource center: {section?}
        elseif ($routeName === 'resource.center') {
            if ($section) {
                $routeParams['section'] = $section;
            }
        }
        // For sectors: {sector}
        elseif ($routeName === 'projects.sector') {
            if (isset($params['sector'])) {
                $routeParams['sector'] = $params['sector'];
            }
        }
        
        // Merge any additional params
        $routeParams = array_merge($routeParams, $params);
        
        try {
            $baseUrl = route($routeName, $routeParams);
        } catch (\Exception $e) {
            // If route fails, use current URL as fallback
            $baseUrl = url()->current();
        }
    } else {
        // Fallback to current URL
        $baseUrl = url()->current();
    }
    
    // Helper function to build pagination URL
    function buildPaginationUrl($baseUrl, $queryParams, $page) {
        // Add page to query parameters
        $queryParams['page'] = $page;
        
        // Check if the base URL already has query parameters
        if (parse_url($baseUrl, PHP_URL_QUERY)) {
            // If it has query params, append with & instead of ?
            $baseUrlWithoutQuery = strtok($baseUrl, '?');
            $existingQuery = parse_url($baseUrl, PHP_URL_QUERY);
            
            // Parse existing query parameters
            parse_str($existingQuery, $existingParams);
            
            // Merge with new query parameters
            $allParams = array_merge($existingParams, $queryParams);
            
            return $baseUrlWithoutQuery . '?' . http_build_query($allParams);
        } else {
            // No existing query parameters, just add them
            return $baseUrl . '?' . http_build_query($queryParams);
        }
    }
@endphp

@if($total > $perPage)
    <div class="mt-12 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
        <div class="text-sm text-text-muted">
            Showing <span class="font-medium text-text-green">{{ $start }}</span> to 
            <span class="font-medium text-text-green">{{ $end }}</span> of 
            <span class="font-medium text-text-green">{{ $total }}</span> results
        </div>
        
        <nav class="flex items-center space-x-1 sm:space-x-2" aria-label="Pagination">
            {{-- Previous Button --}}
            @if($currentPage > 1)
                <a href="{{ buildPaginationUrl($baseUrl, $queryParams, $currentPage - 1) }}" 
                   class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">
                    <span class="sr-only">Previous</span>
                    Previous
                </a>
            @else
                <span class="px-3 py-1 rounded-md border border-background-light text-text-muted/50 text-sm sm:text-base cursor-not-allowed">
                    Previous
                </span>
            @endif
            
            {{-- Page Numbers --}}
            @php
                // Show first 2 pages, then "...", then last page
                // But if total pages is 3 or less, show all
                if ($lastPage <= 3) {
                    // Show all pages
                    for ($i = 1; $i <= $lastPage; $i++) {
                        if ($i == $currentPage) {
                            echo '<span class="px-3 py-1 rounded-md bg-accent-1 text-text-primary text-sm sm:text-base shadow-sm">' . $i . '</span>';
                        } else {
                            echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $i) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">' . $i . '</a>';
                        }
                    }
                } else {
                    // Show first 2 pages
                    for ($i = 1; $i <= 2; $i++) {
                        if ($i == $currentPage) {
                            echo '<span class="px-3 py-1 rounded-md bg-accent-1 text-text-primary text-sm sm:text-base shadow-sm">' . $i . '</span>';
                        } else {
                            echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $i) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">' . $i . '</a>';
                        }
                    }
                    
                    // Show dots if current page is not within first 2 or last page
                    // But don't show dots if current page is 3 (it would create duplicates)
                    if ($currentPage > 3) {
                        echo '<span class="px-3 py-1 text-text-muted text-sm sm:text-base">...</span>';
                    }
                    
                    // Show current page if it's not in first 2 and not the last page
                    if ($currentPage > 2 && $currentPage < $lastPage) {
                        echo '<span class="px-3 py-1 rounded-md bg-accent-1 text-text-primary text-sm sm:text-base shadow-sm">' . $currentPage . '</span>';
                    }
                    
                    // Show dots if current page is not the last page and not adjacent to last page
                    if ($currentPage < $lastPage - 1 && $currentPage > 2) {
                        echo '<span class="px-3 py-1 text-text-muted text-sm sm:text-base">...</span>';
                    }
                    
                    // Show last page
                    if ($lastPage != $currentPage) {
                        echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $lastPage) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">' . $lastPage . '</a>';
                    } else {
                        echo '<span class="px-3 py-1 rounded-md bg-accent-1 text-text-primary text-sm sm:text-base shadow-sm">' . $lastPage . '</span>';
                    }
                }
            @endphp
            
            {{-- Next Button --}}
            @if($currentPage < $lastPage)
                <a href="{{ buildPaginationUrl($baseUrl, $queryParams, $currentPage + 1) }}" 
                   class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">
                    Next
                    <span class="sr-only">Next</span>
                </a>
            @else
                <span class="px-3 py-1 rounded-md border border-background-light text-text-muted/50 text-sm sm:text-base cursor-not-allowed">
                    Next
                </span>
            @endif
        </nav>
    </div>
@endif