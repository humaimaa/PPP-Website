@extends('layouts.app')

@section('title', 'PPP Unit KP - Functions')

@section('content')

<!-- Hero Banner Section -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <!-- Using theme variables for overlay -->
    <div class="absolute inset-0 z-10 flex items-center justify-center" style="background: rgba(var(--color-primary-rgb), 0.6);">
        <div class="text-center px-4 pt-30">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-text-fade-in-up">
                Our Functions
            </h1>
            <div class="w-20 h-1.5 bg-white mx-auto animate-text-fade-in-up animation-delay-200 rounded"></div>
        </div>
    </div>
    <img src="{{ asset('images/function-hero.jpg') }}" alt="Functions Banner" class="w-full h-full object-cover">
</section>

<!-- Functions Section -->
<section class="py-16 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $functions = [
                    [
                        'title' => 'Advisory Support',
                        'desc' => 'Advise the PPP Committee, PPP Unit, and departmental PPP Nodes on different aspects of PPP projects.'
                    ],
                    [
                        'title' => 'Sector Development',
                        'desc' => 'Explore, recommend, and develop new sectors for PPP projects.'
                    ],
                    [
                        'title' => 'Project Evaluation',
                        'desc' => 'Evaluate proposals, feasibility studies, and project designs related to PPP projects.'
                    ],
                    [
                        'title' => 'Government Interest Protection',
                        'desc' => 'Ensure protection of the rights and interests of the provincial government in PPP projects.'
                    ],
                    [
                        'title' => 'PPP Act Compliance',
                        'desc' => 'Ensure all PPP projects are undertaken in conformity with the PPP Act.'
                    ],
                    [
                        'title' => 'Procurement Compliance',
                        'desc' => 'Ensure procurement for PPP projects is carried out in line with KPPRA Rules.'
                    ],
                    [
                        'title' => 'Feasibility Assessment',
                        'desc' => 'Ensure that PPP projects are legally, technically, and financially feasible.'
                    ],
                    [
                        'title' => 'Legislative Improvement',
                        'desc' => 'Recommend improvements to the PPP Act on an ongoing basis.'
                    ],
                    [
                        'title' => 'Capacity Building for PPP Nodes',
                        'desc' => 'Build the capacity of departmental PPP Nodes on PPP projects.'
                    ],
                    [
                        'title' => 'Stakeholder Training',
                        'desc' => 'Build the capacity of relevant stakeholders on the PPP Act.'
                    ]
                ];

                $icons = [
                    'Advisory Support' => 'fa-handshake',
                    'Sector Development' => 'fa-chart-line',
                    'Project Evaluation' => 'fa-clipboard-check',
                    'Government Interest Protection' => 'fa-shield-alt',
                    'PPP Act Compliance' => 'fa-gavel',
                    'Procurement Compliance' => 'fa-file-contract',
                    'Feasibility Assessment' => 'fa-search-dollar',
                    'Legislative Improvement' => 'fa-balance-scale',
                    'Capacity Building for PPP Nodes' => 'fa-users-cog',
                    'Stakeholder Training' => 'fa-chalkboard-teacher'
                ];

                $bgColors = ['bg-accent-1/10', 'bg-primary/10', 'bg-blue-100/30', 'bg-green-100/30', 'bg-purple-100/30'];
            @endphp
            
            @foreach($functions as $index => $function)
            @php
                $icon = $icons[$function['title']] ?? 'fa-tasks';
                $bgColor = $bgColors[$index % count($bgColors)];
            @endphp
            <div class="bg-background-white rounded-lg p-6 border border-gray-200/30 hover:border-accent-1/50 transition-all duration-300 group hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-14 h-14 rounded-lg {{ $bgColor }} flex items-center justify-center text-2xl text-accent-1 group-hover:bg-accent-1 group-hover:text-white transition-all duration-300">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-text-green mb-2 group-hover:text-accent-1 transition-colors duration-300">
                            {{ $function['title'] }}
                        </h3>
                        <p class="text-text-muted text-sm md:text-md leading-relaxed">
                            {{ $function['desc'] }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection