@extends('layouts.app')

@section('title', 'PPP Unit KP - Functions')

@section('content')

<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Our Functions
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/function-hero.jpg') }}" alt="Functions Banner" class="w-full h-full object-cover">
</section>

<!-- Functions Section -->
<section class="py-10 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
       
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
@endphp
            
            @foreach($functions as $function)
            <div class="flex items-start group hover:transform hover:translate-x-2 transition-all duration-300 mb-2">
                <div class="bg-accent-1 text-text-primary rounded-full p-2 mr-4 mt-1 group-hover:bg-accent-2 transition-colors duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-text-green">{{ $function['title'] }}</h3>
                    <p class="text-text-muted">{{ $function['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection