@extends('layouts.app')

@section('title',
($status ?? 'all') === 'operational' ? 'PPP Department KPK - Operational Projects' :
(($status ?? 'all') === 'ongoing' ? 'PPP Department KPK - Ongoing Projects' :
(($status ?? 'all') === 'pipeline' ? 'PPP Department KPK - Pipeline Projects' : 'PPP Department KPK - All Projects')))

@section('content')

<!-- Page Header -->
<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                @if(($status ?? 'all') === 'operational')
                Operational Projects
                @elseif(($status ?? 'all') === 'ongoing')
                Ongoing Projects
                @elseif(($status ?? 'all') === 'pipeline')
                Pipeline Projects
                @else
                All Projects
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-text-primary text-lg mt-4 max-w-2xl mx-auto">
                @if(($status ?? 'all') === 'operational')
                Successfully completed and operational PPP projects transforming KPK
                @elseif(($status ?? 'all') === 'ongoing')
                Currently active projects shaping the future of Khyber Pakhtunkhwa
                @elseif(($status ?? 'all') === 'pipeline')
                Future initiatives in planning and development phase
                @else
                Explore all our public-private partnership initiatives across Khyber Pakhtunkhwa
                @endif
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Projects Banner" class="w-full h-full object-cover">
</section>

<section class="py-10 bg-background-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @php
            // Using database table structure: name, location, overview, category, division, cost, status, image
            $allProjects = [
            // PIPELINE PROJECTS (category = 'Pipeline')
            [
            'id' => 1,
            'name' => 'KPK Waste-to-Energy Plant',
            'location' => 'Peshawar',
            'overview' => 'Integrated waste management system with recycling facilities and energy generation from municipal solid waste, producing 25MW of clean energy. This project will help reduce landfill waste and provide sustainable energy to thousands of homes.',
            'category' => 'Pipeline',
            'division' => 'Peshawar',
            'cost' => 75000000,
            'status' => 'pipeline',
            'image' => 'project-4.jpg'
            ],
            [
            'id' => 2,
            'name' => 'Chitral Eco Resort',
            'location' => 'Chitral',
            'overview' => 'Eco-friendly resort complex promoting sustainable tourism and local employment in the scenic Chitral Valley. The resort will feature solar power, rainwater harvesting, and organic farming.',
            'category' => 'Pipeline',
            'division' => 'Malakand',
            'cost' => 20000000,
            'status' => 'pipeline',
            'image' => 'project-1.jpg'
            ],
            [
            'id' => 3,
            'name' => 'STEM Schools Program',
            'location' => 'Multiple Districts',
            'overview' => 'Establishment of 10 model schools focused on science, technology, engineering and mathematics education across KPK. These schools will provide quality education to underprivileged students.',
            'category' => 'Pipeline',
            'division' => 'Multiple',
            'cost' => 30000000,
            'status' => 'pipeline',
            'image' => 'project-3.jpg'
            ],

            // ONGOING PROJECTS (category = 'Ongoing')
            [
            'id' => 4,
            'name' => 'Peshawar Rapid Transit System',
            'location' => 'Peshawar',
            'overview' => 'Urban mass transit system with 30 km dedicated bus lanes connecting major city centers, reducing travel time by 60%. The project includes modern buses, dedicated lanes, and smart ticketing system.',
            'category' => 'Ongoing',
            'division' => 'Peshawar',
            'cost' => 120000000,
            'status' => 'ongoing',
            'image' => 'project-1.jpg'
            ],
            [
            'id' => 5,
            'name' => 'KPK Water Filtration Plants',
            'location' => 'Rural KPK',
            'overview' => 'Installation of 50 water filtration plants across rural KPK to provide clean drinking water to 1 million residents. Each plant can filter 10,000 gallons per day.',
            'category' => 'Ongoing',
            'division' => 'Multiple',
            'cost' => 25000000,
            'status' => 'ongoing',
            'image' => 'project-5.jpg'
            ],
            [
            'id' => 6,
            'name' => 'Kumrat Valley Development',
            'location' => 'Upper Dir',
            'overview' => 'Sustainable tourism infrastructure including eco-lodges, trails, and visitor centers in the scenic Kumrat Valley. The project aims to boost local economy while preserving natural beauty.',
            'category' => 'Ongoing',
            'division' => 'Malakand',
            'cost' => 15000000,
            'status' => 'ongoing',
            'image' => 'project-6.jpg'
            ],
            [
            'id' => 7,
            'name' => 'KPK Agri-Tech Initiative',
            'location' => 'Multiple Districts',
            'overview' => 'Modernization of agricultural practices through technology adoption, training centers, and supply chain improvements. Farmers will receive training in modern farming techniques.',
            'category' => 'Ongoing',
            'division' => 'Multiple',
            'cost' => 40000000,
            'status' => 'ongoing',
            'image' => 'project-2.jpg'
            ],
            [
            'id' => 8,
            'name' => 'Abbottabad IT Park',
            'location' => 'Abbottabad',
            'overview' => 'State-of-the-art technology park fostering innovation, startups, and IT education in the region. The park will house tech companies and provide training to youth.',
            'category' => 'Ongoing',
            'division' => 'Hazara',
            'cost' => 35000000,
            'status' => 'ongoing',
            'image' => 'project-5.jpg'
            ],

            // OPERATIONAL PROJECTS (category = 'Completed')
            [
            'id' => 9,
            'name' => 'Mardan Medical Complex',
            'location' => 'Mardan',
            'overview' => '500-bed specialized healthcare facility with modern equipment and specialized departments serving northern KPK. The hospital serves over 1000 patients daily.',
            'category' => 'Completed',
            'division' => 'Mardan',
            'cost' => 45000000,
            'status' => 'operational',
            'image' => 'project-2.jpg'
            ],
            [
            'id' => 10,
            'name' => 'Swat Hydropower Project',
            'location' => 'Swat',
            'overview' => '150MW run-of-the-river hydropower plant providing clean energy to 200,000 households in the region. The plant generates 500 GWh annually.',
            'category' => 'Completed',
            'division' => 'Malakand',
            'cost' => 180000000,
            'status' => 'operational',
            'image' => 'project-4.jpg'
            ],
            [
            'id' => 11,
            'name' => 'Peshawar Smart City - Phase 1',
            'location' => 'Peshawar',
            'overview' => 'Phase 1 implementation of smart city technologies including traffic management, surveillance, and digital services. The system has reduced traffic congestion by 40%.',
            'category' => 'Completed',
            'division' => 'Peshawar',
            'cost' => 60000000,
            'status' => 'operational',
            'image' => 'project-3.jpg'
            ],
            [
            'id' => 12,
            'name' => 'Karak Highway Project',
            'location' => 'Karak',
            'overview' => '4-lane highway connecting Karak to major trade routes, reducing travel time by 45%. The highway has boosted economic activity in the region.',
            'category' => 'Completed',
            'division' => 'Kohat',
            'cost' => 95000000,
            'status' => 'operational',
            'image' => 'project-6.jpg'
            ],
            [
            'id' => 13,
            'name' => 'Hayatabad Housing Scheme',
            'location' => 'Peshawar',
            'overview' => 'Affordable housing project providing 2,000 residential units for low and middle-income families. The scheme includes parks, schools, and community centers.',
            'category' => 'Completed',
            'division' => 'Peshawar',
            'cost' => 85000000,
            'status' => 'operational',
            'image' => 'project-1.jpg'
            ]
            ];

            // Filter projects based on status (using category field from database)
            if (($status ?? 'all') === 'operational') {
                $filteredProjects = array_filter($allProjects, function($project) {
                    return $project['category'] === 'Completed';
                });
            } elseif (($status ?? 'all') === 'ongoing') {
                $filteredProjects = array_filter($allProjects, function($project) {
                    return $project['category'] === 'Ongoing';
                });
            } elseif (($status ?? 'all') === 'pipeline') {
                $filteredProjects = array_filter($allProjects, function($project) {
                    return $project['category'] === 'Pipeline';
                });
            } else {
                $filteredProjects = $allProjects;
            }

            // Re-index the array
            $filteredProjects = array_values($filteredProjects);

            // Pagination logic
            $currentPage = request()->get('page', 1);
            $perPage = 9;
            $totalProjects = count($filteredProjects);
            $lastPage = ceil($totalProjects / $perPage);

            // Slice projects for current page
            $offset = ($currentPage - 1) * $perPage;
            $paginatedProjects = array_slice($filteredProjects, $offset, $perPage);
            @endphp

            @forelse($paginatedProjects as $project)
            <!-- Project Card -->
            <div class="bg-background-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('images/' . $project['image']) }}" alt="{{ $project['name'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 
                            @if($project['status'] === 'operational') bg-green-600
                            @elseif($project['status'] === 'ongoing') bg-yellow-500
                            @else bg-blue-600 @endif 
                            text-text-primary px-3 py-1 rounded-full text-xs font-medium capitalize">
                        {{ ucfirst($project['status']) }}
                    </div>
                </div>

                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-text-green mb-3 line-clamp-2">{{ $project['name'] }}</h3>
                    
                    <!-- Location -->
                    <div class="flex items-center text-text-muted text-sm mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $project['location'] }}
                    </div>

                    <!-- Overview/Description (4 lines with ellipsis) -->
                    <p class="text-text-muted mb-4 line-clamp-4">{{ $project['overview'] }}</p>

                    <!-- View Details Button -->
                    <div class="mt-4 pt-3 border-t border-background-light">
                        <a href="{{ route('projects.show', $project['id']) }}"
                            class="text-accent-1 font-medium hover:text-accent-2 transition-colors duration-300 inline-flex items-center text-sm">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-24 h-24 mx-auto text-text-muted mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-text-green mb-2">No Projects Found</h3>
                <p class="text-text-muted">No projects available in this category at the moment.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination Component -->
        @if($totalProjects > $perPage)
            @include('layouts.partials.pagination', [
                'currentPage' => $currentPage,
                'lastPage' => $lastPage,
                'total' => $totalProjects,
                'perPage' => $perPage,
                'status' => $status ?? 'all',
                'routeName' => 'projects.index'
            ])
        @endif
    </div>
</section>

<!-- Statistics Section -->
<section class="py-10 bg-background-light/50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Impact at a Glance</h2>
            <div class="w-20 h-1 bg-text-green mx-auto"></div>
            <p class="text-text-muted mt-4 max-w-2xl mx-auto">Making a difference through strategic partnerships</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-accent-1 mb-2">3</div>
                <p class="text-text-muted">Pipeline Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-accent-1 mb-2">5</div>
                <p class="text-text-muted">Ongoing Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-accent-1 mb-2">5</div>
                <p class="text-text-muted">Operational Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-accent-1 mb-2">$2.5B+</div>
                <p class="text-text-muted">Total Investment</p>
            </div>
        </div>
    </div>
</section>

@endsection