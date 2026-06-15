@extends('layouts.app')

@section('title', 'PPP Unit KP - Functions')

@section('content')

<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Our Functions
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Functions Banner" class="w-full h-full object-cover">
</section>

<!-- Functions Section -->
<section class="py-10 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">Our Functions</h2>
            <div class="w-20 h-1 bg-text-muted mx-auto"></div>
        </div>
        <div class="space-y-6">
            @php
                $functions = [
                    ['title' => 'Policy Formulation', 'desc' => 'Develop PPP policies, guidelines, and frameworks for the province'],
                    ['title' => 'Project Identification', 'desc' => 'Identify and prioritize potential PPP projects across sectors'],
                    ['title' => 'Transaction Advisory', 'desc' => 'Provide technical and financial advisory services for PPP projects'],
                    ['title' => 'Capacity Building', 'desc' => 'Conduct training programs for government officials on PPP processes'],
                    ['title' => 'Monitoring & Evaluation', 'desc' => 'Monitor implementation and performance of PPP projects']
                ];
            @endphp
            
            @foreach($functions as $function)
            <div class="flex items-start group hover:transform hover:translate-x-2 transition-all duration-300">
                <div class="bg-accent-1 text-text-primary rounded-full p-2 mr-4 mt-1 group-hover:bg-accent-2 transition-colors duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-text-green mb-2">{{ $function['title'] }}</h3>
                    <p class="text-text-muted">{{ $function['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection