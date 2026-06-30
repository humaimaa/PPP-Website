@props([
    'currentPage' => 1, 
    'lastPage' => 1, 
    'total' => 0, 
    'perPage' => 9, 
    'status' => null,        // For projects (all, pipeline, ongoing, operational)
    'section' => null,       // For about page (overview, team)
    'tenderType' => null,    // For tenders (active, archived)
    'routeName' => null,     // Custom route name if needed
    'params' => []           // Additional route parameters
])

@php
    $start = ($currentPage - 1) * $perPage + 1;
    $end = min($currentPage * $perPage, $total);
    
    // Get current URL parameters
    $queryParams = request()->query();
    unset($queryParams['page']); // Remove page parameter to add it later
    
    // Build the base URL based on what's provided
    if ($routeName) {
        // If custom route name is provided
        $routeParams = [];
        
        // Add status for projects (only if not 'all' and not null)
        if ($status && $status !== 'all') {
            $routeParams['status'] = $status;
        }
        // Add section for about page
        elseif ($section) {
            $routeParams['section'] = $section;
        }
        // Add tenderType for tenders
        elseif ($tenderType) {
            $routeParams['section'] = $tenderType;
        }
        
        // Merge any additional params (like category, sector, etc.)
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
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);
                
                // First page
                if ($startPage > 1) {
                    echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, 1) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">1</a>';
                    if ($startPage > 2) {
                        echo '<span class="px-3 py-1 text-text-muted text-sm sm:text-base">...</span>';
                    }
                }
                
                // Page numbers
                for ($i = $startPage; $i <= $endPage; $i++) {
                    if ($i == $currentPage) {
                        echo '<span class="px-3 py-1 rounded-md bg-accent-1 text-text-primary text-sm sm:text-base shadow-sm">' . $i . '</span>';
                    } else {
                        echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $i) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">' . $i . '</a>';
                    }
                }
                
                // Last page
                if ($endPage < $lastPage) {
                    if ($endPage < $lastPage - 1) {
                        echo '<span class="px-3 py-1 text-text-muted text-sm sm:text-base">...</span>';
                    }
                    echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $lastPage) . '" class="px-3 py-1 rounded-md border border-background-light text-text-muted hover:bg-background-light hover:border-accent-1 hover:text-accent-1 text-sm sm:text-base transition duration-200">' . $lastPage . '</a>';
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