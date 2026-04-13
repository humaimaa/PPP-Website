@extends('layouts.app')

@section('title', ($section ?? 'active') === 'archived' ? 'PPP Department KPK - Archived Tenders' : 'PPP Department KPK - Active Tenders')

@section('content')

<!-- Page Header -->
<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                @if(($section ?? 'active') === 'archived')
                Archived Tenders
                @else
                Active Tenders
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white text-lg mt-4 max-w-2xl">
                @if(($section ?? 'active') === 'archived')
                Browse and download archived tender notices for past PPP projects
                @else
                Browse and download current tender notices for public-private partnership projects
                @endif
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Tenders Banner" class="w-full h-full object-cover">
</section>

<!-- Navigation Tabs -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-8">
            <a href="{{ route('tenders', 'active') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($section ?? 'active') === 'active' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Active Tenders
            </a>
            <a href="{{ route('tenders', 'archived') }}"
                class="inline-block py-4 px-2 font-semibold transition duration-300 border-b-2 {{ ($section ?? 'active') === 'archived' ? 'border-[#0A612B] text-[#0A612B]' : 'border-transparent text-gray-600 hover:text-[#0A612B]' }}">
                Archived Tenders
            </a>
        </div>
    </div>
</section>

@if(($section ?? 'active') === 'archived')
<!-- ==================== ARCHIVED TENDERS SECTION ==================== -->

@php
$archivedTenders = [
[
'name' => 'Peshawar Bus Rapid Transit System',
'subtitle' => 'Phase I - Completed Project',
'tender_no' => 'PPP-KPK-2022-089',
'category' => 'Transport',
'category_color' => 'purple',
'start_date' => '10 Jan 2022',
'end_date' => '10 Mar 2022'
],
[
'name' => 'Lady Reading Hospital Expansion',
'subtitle' => 'Healthcare Infrastructure Project',
'tender_no' => 'PPP-KPK-2022-156',
'category' => 'Healthcare',
'category_color' => 'blue',
'start_date' => '15 Mar 2022',
'end_date' => '15 May 2022'
],
[
'name' => 'Swat Hydropower Project',
'subtitle' => 'Renewable Energy Initiative',
'tender_no' => 'PPP-KPK-2022-234',
'category' => 'Energy',
'category_color' => 'yellow',
'start_date' => '05 Jun 2022',
'end_date' => '05 Aug 2022'
],
[
'name' => 'Hayatabad Housing Scheme',
'subtitle' => 'Affordable Housing Project',
'tender_no' => 'PPP-KPK-2022-312',
'category' => 'Housing',
'category_color' => 'green',
'start_date' => '20 Sep 2022',
'end_date' => '20 Nov 2022'
],
[
'name' => 'IT Park Abbottabad',
'subtitle' => 'Technology Infrastructure',
'tender_no' => 'PPP-KPK-2023-045',
'category' => 'Technology',
'category_color' => 'indigo',
'start_date' => '10 Jan 2023',
'end_date' => '10 Mar 2023'
],
[
'name' => 'Karak Highway Project',
'subtitle' => 'Transport Infrastructure',
'tender_no' => 'PPP-KPK-2023-078',
'category' => 'Transport',
'category_color' => 'purple',
'start_date' => '15 Feb 2023',
'end_date' => '15 Apr 2023'
],
[
'name' => 'Tourism Promotion Initiative',
'subtitle' => 'Tourism Development',
'tender_no' => 'PPP-KPK-2023-112',
'category' => 'Tourism',
'category_color' => 'pink',
'start_date' => '10 Mar 2023',
'end_date' => '10 May 2023'
],
[
'name' => 'Agriculture Modernization Project',
'subtitle' => 'Agriculture Sector',
'tender_no' => 'PPP-KPK-2023-156',
'category' => 'Agriculture',
'category_color' => 'green',
'start_date' => '05 Apr 2023',
'end_date' => '05 Jun 2023'
],
[
'name' => 'Urban Development Phase II',
'subtitle' => 'Urban Infrastructure',
'tender_no' => 'PPP-KPK-2023-189',
'category' => 'Urban',
'category_color' => 'blue',
'start_date' => '20 May 2023',
'end_date' => '20 Jul 2023'
],
[
'name' => 'Waste Management Facility',
'subtitle' => 'Sanitation Project',
'tender_no' => 'PPP-KPK-2023-223',
'category' => 'Sanitation',
'category_color' => 'teal',
'start_date' => '15 Jun 2023',
'end_date' => '15 Aug 2023'
]
];

// Pagination for archived tenders
$currentPage = request()->get('page', 1);
$perPage = 5;
$totalTenders = count($archivedTenders);
$lastPage = ceil($totalTenders / $perPage);
$offset = ($currentPage - 1) * $perPage;
$paginatedTenders = array_slice($archivedTenders, $offset, $perPage);
@endphp

<section class="py-1 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tender Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tender No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                End Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Documents</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($paginatedTenders as $tender)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $tender['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $tender['subtitle'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['tender_no'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $tender['category_color'] }}-100 text-{{ $tender['category_color'] }}-800">
                                    {{ $tender['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['start_date'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['end_date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-gray-600 hover:text-[#0A612B] mr-3"><i
                                        class="fas fa-file-pdf"></i> Download</a>
                                <a href="#" class="text-gray-600 hover:text-[#0A612B]"><i class="fas fa-eye"></i>
                                    View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Component for Archived Tenders -->
        @if($totalTenders > $perPage)
@include('layouts.partials.pagination', [
    'currentPage' => $currentPage,
    'lastPage' => $lastPage,
    'total' => $totalTenders,
    'perPage' => $perPage,
    'tenderType' => 'active',
    'routeName' => 'tenders'
])
@endif
    </div>
</section>

@else
<!-- ==================== ACTIVE TENDERS SECTION ==================== -->

@php
$activeTenders = [
[
'name' => 'Construction of Mardan Medical Complex',
'subtitle' => 'PPP Healthcare Initiative',
'tender_no' => 'PPP-KPK-2024-001',
'category' => 'Healthcare',
'category_color' => 'blue',
'start_date' => '15 Jan 2024',
'end_date' => '15 Mar 2024'
],
[
'name' => 'Peshawar Rapid Transit System',
'subtitle' => 'Phase II Development',
'tender_no' => 'PPP-KPK-2024-002',
'category' => 'Transport',
'category_color' => 'purple',
'start_date' => '01 Feb 2024',
'end_date' => '30 Apr 2024'
],
[
'name' => 'Solar Power Plant in Swat',
'subtitle' => '50MW Renewable Energy Project',
'tender_no' => 'PPP-KPK-2024-003',
'category' => 'Energy',
'category_color' => 'yellow',
'start_date' => '10 Mar 2024',
'end_date' => '10 Jun 2024'
],
[
'name' => 'STEM Schools Development',
'subtitle' => '10 Model Schools Across KPK',
'tender_no' => 'PPP-KPK-2024-004',
'category' => 'Education',
'category_color' => 'indigo',
'start_date' => '05 Apr 2024',
'end_date' => '05 Jul 2024'
],
[
'name' => 'Waste Management System',
'subtitle' => 'Peshawar City Cleanliness Project',
'tender_no' => 'PPP-KPK-2024-005',
'category' => 'Sanitation',
'category_color' => 'teal',
'start_date' => '20 Feb 2024',
'end_date' => '20 May 2024'
],
[
'name' => 'Kumrat Valley Cable Car',
'subtitle' => 'Tourism Infrastructure',
'tender_no' => 'PPP-KPK-2024-006',
'category' => 'Tourism',
'category_color' => 'pink',
'start_date' => '01 Mar 2024',
'end_date' => '01 Jun 2024'
],
[
'name' => 'Smart City Phase II',
'subtitle' => 'Urban Technology Integration',
'tender_no' => 'PPP-KPK-2024-007',
'category' => 'Technology',
'category_color' => 'indigo',
'start_date' => '15 Apr 2024',
'end_date' => '15 Jul 2024'
],
[
'name' => 'Agriculture Cold Chain',
'subtitle' => 'Food Storage & Distribution',
'tender_no' => 'PPP-KPK-2024-008',
'category' => 'Agriculture',
'category_color' => 'green',
'start_date' => '10 May 2024',
'end_date' => '10 Aug 2024'
]
];

// Pagination for active tenders
$currentPage = request()->get('page', 1);
$perPage = 5;
$totalTenders = count($activeTenders);
$lastPage = ceil($totalTenders / $perPage);
$offset = ($currentPage - 1) * $perPage;
$paginatedTenders = array_slice($activeTenders, $offset, $perPage);
@endphp

<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tender Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tender No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Start Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                End Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Documents</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($paginatedTenders as $tender)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $tender['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $tender['subtitle'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['tender_no'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $tender['category_color'] }}-100 text-{{ $tender['category_color'] }}-800">
                                    {{ $tender['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['start_date'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tender['end_date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-[#0A612B] hover:text-[#0D2818] mr-3"><i
                                        class="fas fa-file-pdf"></i> Download</a>
                                <a href="#" class="text-gray-600 hover:text-gray-900"><i class="fas fa-eye"></i>
                                    View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Component for Active Tenders -->
        @if($totalTenders > $perPage)
@include('layouts.partials.pagination', [
    'currentPage' => $currentPage,
    'lastPage' => $lastPage,
    'total' => $totalTenders,
    'perPage' => $perPage,
    'tenderType' => 'active',
    'routeName' => 'tenders'
])
@endif
    </div>
</section>

<!-- Improved Additional Information Section (Only for Active Tenders) -->
<section class="py-10 bg-[#DAD7CD]/50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-[#0A612B]">Tender Submission Guidelines</h2>
            <div class="w-24 h-1.5 bg-[#0A612B] mx-auto mb-6"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Essential information to ensure your tender submission
                meets all requirements</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div
                class="bg-white p-8 rounded-xl border border-gray-200 hover:border-[#0A612B]/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#0A612B]"></div>
                <div
                    class="w-16 h-16 bg-[#0A612B] rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-[#0D2818] transition-colors duration-300">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Submission Requirements</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <span class="text-[#0A612B] mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Sealed envelopes with tender number clearly marked</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#0A612B] mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Complete documentation package (technical & financial)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#0A612B] mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Original signed copies with company stamp</span>
                    </li>
                </ul>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white p-8 rounded-xl border border-gray-200 hover:border-[#0A612B]/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#0A612B]"></div>
                <div
                    class="w-16 h-16 bg-[#0A612B] rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-[#0D2818] transition-colors duration-300">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Deadlines & Process</h3>
                <div class="space-y-4">
                    <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                        <div
                            class="bg-[#0A612B] text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Submission Deadline</h4>
                            <p class="text-sm text-gray-600">Strictly enforced - no exceptions will be made</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                        <div
                            class="bg-[#0A612B] text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Evaluation Period</h4>
                            <p class="text-sm text-gray-600">30-45 working days after submission</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                        <div
                            class="bg-[#0A612B] text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Award Notification</h4>
                            <p class="text-sm text-gray-600">Published on our portal and via registered email</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white p-8 rounded-xl border border-gray-200 hover:border-[#0A612B]/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#0A612B]"></div>
                <div
                    class="w-16 h-16 bg-[#0A612B] rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-[#0D2818] transition-colors duration-300">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Support & Assistance</h3>
                <div class="space-y-4">
                    <div
                        class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0A612B]/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-gray-800 flex items-center">
                            <i class="fas fa-envelope text-[#0A612B] mr-2"></i> Email Support
                        </h4>
                        <p class="text-sm text-gray-600">procurement@pppdepartmentkpk.gov.pk</p>
                        <p class="text-xs mt-1 text-gray-500">Response within 24-48 hours</p>
                    </div>
                    <div
                        class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0A612B]/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-gray-800 flex items-center">
                            <i class="fas fa-phone-alt text-[#0A612B] mr-2"></i> Helpline
                        </h4>
                        <p class="text-sm text-gray-600">+92 91 921 1234 (9AM-5PM, Mon-Fri)</p>
                        <p class="text-xs mt-1 text-gray-500">For urgent queries only</p>
                    </div>
                    <div
                        class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-[#0A612B]/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-[#0A612B] mr-2"></i> Office Visit
                        </h4>
                        <p class="text-sm text-gray-600">PPP Department, Civil Secretariat, Peshawar</p>
                        <p class="text-xs mt-1 text-gray-500">By appointment only</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional CTA -->
        <div class="mt-16 text-center">
            <h3 class="text-xl font-medium mb-6 text-gray-800">Need personalized assistance with your tender
                application?</h3>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-6 py-3 bg-[#0A612B] text-white rounded-lg font-semibold hover:bg-[#0D2818] transition-colors duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i> Contact Us
            </a>
            <p class="text-sm text-gray-500 mt-3">Our experts are available Monday-Friday, 9AM to 5PM</p>
        </div>
    </div>
</section>
@endif

@endsection