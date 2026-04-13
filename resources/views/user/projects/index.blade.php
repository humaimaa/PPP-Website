@extends('layouts.app')

@section('title',
($status ?? 'all') === 'operational' ? 'PPP Department KPK - Operational Projects' :
(($status ?? 'all') === 'ongoing' ? 'PPP Department KPK - Ongoing Projects' :
(($status ?? 'all') === 'pipeline' ? 'PPP Department KPK - Pipeline Projects' : 'PPP Department KPK - All Projects')))

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
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
            <p class="text-white text-lg mt-4 max-w-2xl mx-auto">
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

<!-- Navigation Tabs -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap space-x-4 md:space-x-8">
            <a href="{{ route('projects.index', 'all') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($status ?? 'all') === 'all' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                All Projects
            </a>
            <a href="{{ route('projects.index', 'pipeline') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($status ?? 'all') === 'pipeline' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Pipeline
            </a>
            <a href="{{ route('projects.index', 'ongoing') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($status ?? 'all') === 'ongoing' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Ongoing
            </a>
            <a href="{{ route('projects.index', 'operational') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($status ?? 'all') === 'operational' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Operational
            </a>
        </div>
    </div>
</section>

<section class="py-10 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @php
            // Define all projects with pipeline, ongoing, operational statuses
            $allProjects = [
            // PIPELINE PROJECTS (Upcoming/Planning Phase)
            [
            'id' => 1,
            'title' => 'KPK Waste-to-Energy Plant',
            'category' => 'Energy',
            'category_color' => 'yellow',
            'status' => 'pipeline',
            'status_color' => 'blue',
            'timeline' => 'Starting: Q1 2025',
            'description' => 'Integrated waste management system with recycling facilities and energy generation from
            municipal solid waste, producing 25MW of clean energy.',
            'image' => 'project-4.jpg',
            'investment' => '$75 Million',
            'partner' => 'EcoEnergy International',
            'progress' => '30%',
            'location' => 'Peshawar'
            ],
            [
            'id' => 2,
            'title' => 'Chitral Eco Resort',
            'category' => 'Tourism',
            'category_color' => 'purple',
            'status' => 'pipeline',
            'status_color' => 'blue',
            'timeline' => 'Starting: Q2 2025',
            'description' => 'Eco-friendly resort complex promoting sustainable tourism and local employment in the
            scenic Chitral Valley.',
            'image' => 'project-1.jpg',
            'investment' => '$20 Million',
            'partner' => 'EcoResorts International',
            'progress' => '15%',
            'location' => 'Chitral'
            ],
            [
            'id' => 3,
            'title' => 'STEM Schools Program',
            'category' => 'Education',
            'category_color' => 'yellow',
            'status' => 'pipeline',
            'status_color' => 'blue',
            'timeline' => 'Starting: Q3 2025',
            'description' => 'Establishment of 10 model schools focused on science, technology, engineering and
            mathematics education across KPK.',
            'image' => 'project-3.jpg',
            'investment' => '$30 Million',
            'partner' => 'Education First Foundation',
            'progress' => '45%',
            'location' => 'Multiple Districts'
            ],

            // ONGOING PROJECTS (Currently in progress)
            [
            'id' => 4,
            'title' => 'Peshawar Rapid Transit System',
            'category' => 'Transportation',
            'category_color' => 'green',
            'status' => 'ongoing',
            'status_color' => 'green',
            'timeline' => 'Est. Completion: Dec 2024',
            'description' => 'Urban mass transit system with 30 km dedicated bus lanes connecting major city centers,
            reducing travel time by 60%.',
            'image' => 'project-1.jpg',
            'investment' => '$120 Million',
            'partner' => 'TransPeshawar Pvt Ltd',
            'progress' => '75%',
            'location' => 'Peshawar'
            ],
            [
            'id' => 5,
            'title' => 'KPK Water Filtration Plants',
            'category' => 'Water',
            'category_color' => 'green',
            'status' => 'ongoing',
            'status_color' => 'green',
            'timeline' => 'Est. Completion: Jun 2024',
            'description' => 'Installation of 50 water filtration plants across rural KPK to provide clean drinking
            water to 1 million residents.',
            'image' => 'project-5.jpg',
            'investment' => '$25 Million',
            'partner' => 'Clean Water Initiative',
            'progress' => '80%',
            'location' => 'Rural KPK'
            ],
            [
            'id' => 6,
            'title' => 'Kumrat Valley Development',
            'category' => 'Tourism',
            'category_color' => 'purple',
            'status' => 'ongoing',
            'status_color' => 'purple',
            'timeline' => 'Est. Completion: May 2024',
            'description' => 'Sustainable tourism infrastructure including eco-lodges, trails, and visitor centers in
            the scenic Kumrat Valley.',
            'image' => 'project-6.jpg',
            'investment' => '$15 Million',
            'partner' => 'KPK Tourism Development Corp',
            'progress' => '85%',
            'location' => 'Upper Dir'
            ],
            [
            'id' => 7,
            'title' => 'KPK Agri-Tech Initiative',
            'category' => 'Agriculture',
            'category_color' => 'green',
            'status' => 'ongoing',
            'status_color' => 'green',
            'timeline' => 'Est. Completion: Dec 2025',
            'description' => 'Modernization of agricultural practices through technology adoption, training centers, and
            supply chain improvements.',
            'image' => 'project-2.jpg',
            'investment' => '$40 Million',
            'partner' => 'AgriTech Pakistan',
            'progress' => '40%',
            'location' => 'Multiple Districts'
            ],
            [
            'id' => 8,
            'title' => 'Abbottabad IT Park',
            'category' => 'Technology',
            'category_color' => 'indigo',
            'status' => 'ongoing',
            'status_color' => 'indigo',
            'timeline' => 'Est. Completion: Aug 2024',
            'description' => 'State-of-the-art technology park fostering innovation, startups, and IT education in the
            region.',
            'image' => 'project-5.jpg',
            'investment' => '$35 Million',
            'partner' => 'TechHub Pakistan',
            'progress' => '60%',
            'location' => 'Abbottabad'
            ],

            // OPERATIONAL PROJECTS (Completed and running)
            [
            'id' => 9,
            'title' => 'Mardan Medical Complex',
            'category' => 'Healthcare',
            'category_color' => 'blue',
            'status' => 'operational',
            'status_color' => 'green',
            'timeline' => 'Operational since: Jun 2022',
            'description' => '500-bed specialized healthcare facility with modern equipment and specialized departments
            serving northern KPK.',
            'image' => 'project-2.jpg',
            'investment' => '$45 Million',
            'partner' => 'Mardan Healthcare Consortium',
            'progress' => '100%',
            'location' => 'Mardan'
            ],
            [
            'id' => 10,
            'title' => 'Swat Hydropower Project',
            'category' => 'Energy',
            'category_color' => 'blue',
            'status' => 'operational',
            'status_color' => 'green',
            'timeline' => 'Operational since: Mar 2021',
            'description' => '150MW run-of-the-river hydropower plant providing clean energy to 200,000 households in
            the region.',
            'image' => 'project-4.jpg',
            'investment' => '$180 Million',
            'partner' => 'Green Energy Solutions',
            'progress' => '100%',
            'location' => 'Swat'
            ],
            [
            'id' => 11,
            'title' => 'Peshawar Smart City - Phase 1',
            'category' => 'Urban Development',
            'category_color' => 'blue',
            'status' => 'operational',
            'status_color' => 'green',
            'timeline' => 'Operational since: Jan 2023',
            'description' => 'Phase 1 implementation of smart city technologies including traffic management,
            surveillance, and digital services.',
            'image' => 'project-3.jpg',
            'investment' => '$60 Million',
            'partner' => 'Smart City Solutions',
            'progress' => '100%',
            'location' => 'Peshawar'
            ],
            [
            'id' => 12,
            'title' => 'Karak Highway Project',
            'category' => 'Transportation',
            'category_color' => 'green',
            'status' => 'operational',
            'status_color' => 'green',
            'timeline' => 'Operational since: Oct 2022',
            'description' => '4-lane highway connecting Karak to major trade routes, reducing travel time by 45%.',
            'image' => 'project-6.jpg',
            'investment' => '$95 Million',
            'partner' => 'National Highway Authority',
            'progress' => '100%',
            'location' => 'Karak'
            ],
            [
            'id' => 13,
            'title' => 'Hayatabad Housing Scheme',
            'category' => 'Housing',
            'category_color' => 'blue',
            'status' => 'operational',
            'status_color' => 'green',
            'timeline' => 'Operational since: Dec 2022',
            'description' => 'Affordable housing project providing 2,000 residential units for low and middle-income
            families.',
            'image' => 'project-1.jpg',
            'investment' => '$85 Million',
            'partner' => 'Habib Construction Services',
            'progress' => '100%',
            'location' => 'Peshawar'
            ]
            ];

            // Filter projects based on status
            if (($status ?? 'all') === 'all') {
            $filteredProjects = $allProjects;
            } else {
            $filteredProjects = array_filter($allProjects, function($project) use ($status) {
            return $project['status'] === $status;
            });
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
            <div
                class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="h-48 overflow-hidden relative">
                    <img src="{{ asset('images/' . $project['image']) }}" alt="{{ $project['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 
                            @if($project['status'] === 'operational') bg-green-600
                            @elseif($project['status'] === 'ongoing') bg-yellow-500
                            @else bg-blue-600 @endif 
                            text-white px-3 py-1 rounded-full text-xs font-medium capitalize">
                        {{ ucfirst($project['status']) }}
                    </div>

                    <!-- Investment Badge -->
                    <div
                        class="absolute bottom-4 left-4 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-medium">
                        {{ $project['investment'] }}
                    </div>

                    <!-- Progress Badge for Ongoing Projects -->
                    @if($project['status'] === 'ongoing')
                    <div
                        class="absolute bottom-4 right-4 bg-black/60 text-white px-3 py-1 rounded-full text-xs font-medium">
                        {{ $project['progress'] }} Complete
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="w-3 h-3 rounded-full 
                                @if($project['category_color'] === 'blue') bg-blue-600
                                @elseif($project['category_color'] === 'green') bg-green-600
                                @elseif($project['category_color'] === 'yellow') bg-yellow-500
                                @elseif($project['category_color'] === 'purple') bg-purple-600
                                @else bg-indigo-600 @endif 
                                mr-2"></span>
                        <span class="text-sm font-medium 
                                @if($project['category_color'] === 'blue') text-blue-600
                                @elseif($project['category_color'] === 'green') text-green-600
                                @elseif($project['category_color'] === 'yellow') text-yellow-600
                                @elseif($project['category_color'] === 'purple') text-purple-600
                                @else text-indigo-600 @endif">
                            {{ $project['category'] }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-[#0D2818] mb-3">{{ $project['title'] }}</h3>
                    <p class="text-gray-600 mb-3 line-clamp-3">{{ $project['description'] }}</p>

                    <!-- Location -->
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $project['location'] }}
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <span class="text-sm text-gray-500">
                                @if($project['status'] === 'operational')
                                {{ $project['timeline'] }}
                                @elseif($project['status'] === 'ongoing')
                                {{ $project['timeline'] }}
                                @else
                                {{ $project['timeline'] }}
                                @endif
                            </span>
                            <p class="text-xs text-gray-400 mt-1">{{ $project['partner'] }}</p>
                        </div>
                        <a href="{{ route('projects.show', $project['id']) }}"
                            class="text-[#0A612B] font-medium hover:text-[#0D2818] transition-colors duration-300 inline-flex items-center">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Progress Bar for Ongoing Projects -->
                    @if($project['status'] === 'ongoing')
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#0A612B] h-2 rounded-full" style="width: {{ $project['progress'] }}"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Projects Found</h3>
                <p class="text-gray-500">No projects available in this category at the moment.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination Component -->
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
<section class="py-10 bg-[#DAD7CD] text-[#0D2818]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Impact at a Glance</h2>
            <div class="w-20 h-1 bg-[#0D2818] mx-auto"></div>
            <p class="text-[#0D2818]-300 mt-4 max-w-2xl mx-auto">Making a difference through strategic partnerships</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-[#0D2818] mb-2">3</div>
                <p class="text-[#0D2818]-300">Pipeline Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#0D2818] mb-2">5</div>
                <p class="text-[#0D2818]-300">Ongoing Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#0D2818] mb-2">5</div>
                <p class="text-[#0D2818]-300">Operational Projects</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#0D2818] mb-2">$2.5B+</div>
                <p class="text-[#0D2818]-300">Total Investment</p>
            </div>
        </div>
    </div>
</section>

@endsection