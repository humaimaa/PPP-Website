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
        
        // Add status for projects
        if ($status) {
            $routeParams = ['status' => $status];
        }
        // Add section for about page
        elseif ($section) {
            $routeParams = ['section' => $section];
        }
        // Add tenderType for tenders
        elseif ($tenderType) {
            $routeParams = ['section' => $tenderType];
        }
        
        // Merge any additional params
        $routeParams = array_merge($routeParams, $params);
        
        $baseUrl = route($routeName, $routeParams);
    } else {
        // Fallback to current URL
        $baseUrl = url()->current();
    }
    
    // Helper function to build pagination URL
    function buildPaginationUrl($baseUrl, $queryParams, $page) {
        $queryParams['page'] = $page;
        return $baseUrl . '?' . http_build_query($queryParams);
    }
@endphp

@if($total > $perPage)
    <div class="mt-12 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
        <div class="text-sm text-gray-500">
            Showing <span class="font-medium">{{ $start }}</span> to <span class="font-medium">{{ $end }}</span> of 
            <span class="font-medium">{{ $total }}</span> results
        </div>
        
        <nav class="flex items-center space-x-1 sm:space-x-2" aria-label="Pagination">
            {{-- Previous Button --}}
            @if($currentPage > 1)
                <a href="{{ buildPaginationUrl($baseUrl, $queryParams, $currentPage - 1) }}" 
                   class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-[#0A612B] text-sm sm:text-base transition duration-200">
                    <span class="sr-only">Previous</span>
                    Previous
                </a>
            @else
                <span class="px-3 py-1 rounded-md border border-gray-200 text-gray-400 text-sm sm:text-base cursor-not-allowed">
                    Previous
                </span>
            @endif
            
            {{-- Page Numbers --}}
            @php
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);
                
                // First page
                if ($startPage > 1) {
                    echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, 1) . '" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-[#0A612B] text-sm sm:text-base transition duration-200">1</a>';
                    if ($startPage > 2) {
                        echo '<span class="px-3 py-1 text-gray-500 text-sm sm:text-base">...</span>';
                    }
                }
                
                // Page numbers
                for ($i = $startPage; $i <= $endPage; $i++) {
                    if ($i == $currentPage) {
                        echo '<span class="px-3 py-1 rounded-md bg-[#0A612B] text-white text-sm sm:text-base shadow-sm">' . $i . '</span>';
                    } else {
                        echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $i) . '" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-[#0A612B] text-sm sm:text-base transition duration-200">' . $i . '</a>';
                    }
                }
                
                // Last page
                if ($endPage < $lastPage) {
                    if ($endPage < $lastPage - 1) {
                        echo '<span class="px-3 py-1 text-gray-500 text-sm sm:text-base">...</span>';
                    }
                    echo '<a href="' . buildPaginationUrl($baseUrl, $queryParams, $lastPage) . '" class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-[#0A612B] text-sm sm:text-base transition duration-200">' . $lastPage . '</a>';
                }
            @endphp
            
            {{-- Next Button --}}
            @if($currentPage < $lastPage)
                <a href="{{ buildPaginationUrl($baseUrl, $queryParams, $currentPage + 1) }}" 
                   class="px-3 py-1 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-[#0A612B] text-sm sm:text-base transition duration-200">
                    Next
                    <span class="sr-only">Next</span>
                </a>
            @else
                <span class="px-3 py-1 rounded-md border border-gray-200 text-gray-400 text-sm sm:text-base cursor-not-allowed">
                    Next
                </span>
            @endif
        </nav>
    </div>
@endif