@extends('layouts.app')

@section('title', ($section ?? 'overview') === 'team' ? 'PPP Department KPK - Our Team' : 'PPP Department KPK - About Us')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                @if(($section ?? 'overview') === 'team')
                    Our Leadership Team
                @else
                    About PPP Department
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="About Us Banner" class="w-full h-full object-cover">
</section>

<!-- Navigation Tabs -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8">
            <a href="{{ route('about', 'overview') }}" 
               class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($section ?? 'overview') === 'overview' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Overview
            </a>
            <a href="{{ route('about', 'team') }}" 
               class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($section ?? 'overview') === 'team' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Our Team
            </a>
        </div>
    </div>
</section>

@if(($section ?? 'overview') === 'team')
    <!-- ==================== TEAM SECTION ==================== -->
    
    <!-- Chief / Director Section -->
    <section class="py-12 bg-gradient-to-br from-[#0D2818] to-[#1a4d2e] text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Departmental Leadership</h2>
                <div class="w-20 h-1 bg-[#DAD7CD] mx-auto"></div>
            </div>
            
            <div class="flex flex-col lg:flex-row items-center justify-center gap-8">
                <!-- Chief's Photo -->
                <div class="lg:w-1/3">
                    <div class="relative rounded-lg overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/boy.jpg') }}" alt="Chief PPP Department" 
                             class="w-full h-[400px] object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                            <h3 class="text-2xl font-bold">Mr. Muhammad Ali</h3>
                            <p class="text-[#DAD7CD]">Chief Executive Officer</p>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2">
                    <div class="space-y-4">
                        <h3 class="text-2xl font-bold">Message from the Chief</h3>
                        <p class="text-gray-200 leading-relaxed">
                            As the Chief Executive of PPP Department KPK, I am honored to lead a team dedicated to transforming 
                            the province through strategic public-private partnerships. Our commitment to transparency, innovation, 
                            and excellence drives every project we undertake.
                        </p>
                        <div class="mt-6">
                            <div class="flex items-center space-x-2 text-[#DAD7CD]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <span>chief@pppdepartmentkpk.gov.pk</span>
                            </div>
                            <div class="flex items-center space-x-2 text-[#DAD7CD] mt-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                                </svg>
                                <span>+92 91 921 1234 Ext: 101</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Officers Section -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Research Officers</h2>
                <div class="w-20 h-1 bg-[#0A612B] mx-auto mt-4"></div>
                <p class="text-gray-600 mt-4">Leading research and analysis for PPP projects</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Research Officer 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/girl.jpg') }}" alt="Research Officer" 
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#0D2818]">Dr. Sarah Ahmed</h3>
                        <p class="text-[#0A612B] font-semibold mb-2">Senior Research Officer</p>
                        <p class="text-gray-600 text-sm mb-3">PhD in Economics, 12+ years experience</p>
                        <div class="flex space-x-3 mt-3">
                            <a href="mailto:sarah@pppdepartmentkpk.gov.pk" class="text-[#0A612B] hover:text-[#0D2818]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-[#0A612B] hover:text-[#0D2818]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Research Officer 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/boy.jpg') }}" alt="Research Officer" 
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#0D2818]">Mr. Kamran Khan</h3>
                        <p class="text-[#0A612B] font-semibold mb-2">Research Officer</p>
                        <p class="text-gray-600 text-sm mb-3">Masters in Public Policy, 8+ years experience</p>
                        <div class="flex space-x-3 mt-3">
                            <a href="mailto:kamran@pppdepartmentkpk.gov.pk" class="text-[#0A612B] hover:text-[#0D2818]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Research Officer 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/girl.jpg') }}" alt="Research Officer" 
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-[#0D2818]">Ms. Ayesha Malik</h3>
                        <p class="text-[#0A612B] font-semibold mb-2">Research Officer</p>
                        <p class="text-gray-600 text-sm mb-3">MBA Finance, 6+ years experience</p>
                        <div class="flex space-x-3 mt-3">
                            <a href="mailto:ayesha@pppdepartmentkpk.gov.pk" class="text-[#0A612B] hover:text-[#0D2818]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Research Analysts Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Research Analysts</h2>
                <div class="w-20 h-1 bg-[#0A612B] mx-auto mt-4"></div>
                <p class="text-gray-600 mt-4">Supporting project research and data analysis</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Analyst 1 -->
                <div class="bg-gray-100 rounded-lg p-6 text-center hover:shadow-md transition duration-300">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ asset('images/boy.jpg') }}" alt="Analyst" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-[#0D2818]">Usman Chaudhry</h3>
                    <p class="text-[#0A612B] text-sm">Senior Research Analyst</p>
                    <p class="text-gray-500 text-xs mt-2">Financial Modeling</p>
                </div>
                
                <!-- Analyst 2 -->
                <div class="bg-gray-100 rounded-lg p-6 text-center hover:shadow-md transition duration-300">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ asset('images/girl.jpg') }}" alt="Analyst" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-[#0D2818]">Fatima Zafar</h3>
                    <p class="text-[#0A612B] text-sm">Research Analyst</p>
                    <p class="text-gray-500 text-xs mt-2">Policy Research</p>
                </div>
                
                <!-- Analyst 3 -->
                <div class="bg-gray-100 rounded-lg p-6 text-center hover:shadow-md transition duration-300">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ asset('images/boy.jpg') }}" alt="Analyst" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-[#0D2818]">Ali Raza</h3>
                    <p class="text-[#0A612B] text-sm">Data Analyst</p>
                    <p class="text-gray-500 text-xs mt-2">Data Visualization</p>
                </div>
                
                <!-- Analyst 4 -->
                <div class="bg-gray-100 rounded-lg p-6 text-center hover:shadow-md transition duration-300">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                        <img src="{{ asset('images/girl.jpg') }}" alt="Analyst" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-[#0D2818]">Sana Tariq</h3>
                    <p class="text-[#0A612B] text-sm">Junior Analyst</p>
                    <p class="text-gray-500 text-xs mt-2">Project Support</p>
                </div>
            </div>
        </div>
    </section>

@else
    <!-- ==================== OVERVIEW SECTION (Original Content) ==================== -->
    
    <!-- Overview Section -->
    <section class="py-10 bg-[#DAD7CD]/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="lg:w-1/2 overflow-hidden">
                    <div class="space-y-6">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-6">Overview</h2>
                        <p class="text-lg text-gray-700">
                            The Public-Private Partnership (PPP) Department of Khyber Pakhtunkhwa serves as the nodal agency for planning, 
                            facilitating, and implementing PPP projects across the province. Established under the Khyber Pakhtunkhwa 
                            Public-Private Partnership Act, we bridge the gap between public needs and private sector expertise.
                        </p>
                        <p class="text-lg text-gray-700">
                            Our department works across various sectors including infrastructure, health, education, transportation, 
                            and urban development, ensuring sustainable growth and improved public services for the citizens of KPK.
                        </p>
                    </div>
                </div>
                <div class="lg:w-1/2 overflow-hidden">
                    <div class="relative rounded-lg overflow-hidden shadow-lg h-[300px] md:h-[400px]">
                        <img src="{{ asset('images/project-2.jpg') }}" alt="PPP Department Overview" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="py-10 bg-[#0A612B]/10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="lg:w-1/2 overflow-hidden">
                    <div class="relative rounded-lg overflow-hidden shadow-lg h-[300px] md:h-[500px]">
                        <img src="{{ asset('images/project-6.jpg') }}" alt="Vision and Mission" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-[#0A612B]/20 flex items-end p-6">
                            <div class="bg-white/90 backdrop-blur-sm p-4 rounded">
                                <h3 class="text-lg font-semibold text-[#0D2818]">Building a Better KPK Together</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 overflow-hidden">
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-4">Our Vision</h2>
                            <p class="text-lg text-gray-700">
                                To be the leading enabler of sustainable development in Khyber Pakhtunkhwa through innovative 
                                public-private partnerships that deliver world-class infrastructure and services to our citizens.
                            </p>
                        </div>
                        <div>
                            <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818] mb-4">Our Mission</h2>
                            <p class="text-lg text-gray-700 mb-4">
                                To facilitate and promote private sector participation in public infrastructure and service delivery 
                                through transparent, competitive, and mutually beneficial partnerships.
                            </p>
                            <ul class="space-y-3 text-gray-700">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Create an enabling environment for PPP projects</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Ensure value for money in all partnerships</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-[#0A612B] mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Promote innovation and efficiency in service delivery</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="py-10 bg-white ">
        <div class="container mx-auto px-8 sm:px-18 lg:px-32">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Our History</h2>
                <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
            </div>
            <div class="space-y-6 text-gray-700  text-justify">
                <p class="text-lg">
                    The PPP Department was established in 2014 following the enactment of the Khyber Pakhtunkhwa Public-Private 
                    Partnership Act, which provided the legal framework for private sector participation in public infrastructure 
                    projects.
                </p>
                <p class="text-lg">
                    Our first major project, the Peshawar Rapid Transit System, was launched in 2015 and set the standard for 
                    future PPP initiatives in the province. Since then, we have successfully facilitated over 50 projects 
                    across various sectors with a total investment exceeding $2 billion.
                </p>
                <p class="text-lg">
                    In 2020, the department underwent significant restructuring to enhance its capacity for project development 
                    and implementation, establishing specialized units for different sectors and introducing digital platforms 
                    for greater transparency.
                </p>
            </div>
        </div>
    </section>

    <!-- Functions Section -->
    <section class="py-10 bg-[#DAD7CD]/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Our Functions</h2>
                <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
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
                <div class="flex items-start">
                    <div class="bg-[#0A612B] text-white rounded-full p-2 mr-4 mt-1">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-[#0D2818] mb-2">{{ $function['title'] }}</h3>
                        <p class="text-gray-700">{{ $function['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Organogram Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0D2818]">Organizational Structure</h2>
                <div class="w-20 h-1 bg-[#5c5d5c] mx-auto mt-4"></div>
                <p class="text-lg text-gray-600 mt-4 max-w-3xl mx-auto">
                    Our organizational structure is designed to ensure efficient decision-making and effective implementation 
                    of PPP projects across Khyber Pakhtunkhwa.
                </p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <div class="flex justify-center">
                    <img src="{{ asset('images/Line-Organizational-Structure-1.png') }}" alt="PPP Department Organogram" class="max-w-full h-auto rounded-lg shadow-md">
                </div>
                <div class="text-center mt-6">
                    <a href="{{ asset('images/organogram.jpg') }}" download="PPP-Department-Organogram.jpg" 
                       class="inline-block px-6 py-3 bg-[#0A612B] text-white font-medium rounded-md hover:bg-[#0D2818] transition duration-300">
                        Download Organogram
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif

@endsection