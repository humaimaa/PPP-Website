@extends('layouts.app')

@section('title', 'PPP Unit KP - Tenders & Opportunities')

@section('content')

<section class="relative h-[40vh] md:h-[50vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-30">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                @if($section == 'general-procurement') General Procurement
                @elseif($section == 'transaction-advisory') Transaction Advisory
                @else Private Partner Selection
                @endif
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Tenders Banner" class="w-full h-full object-cover">
</section>

<!-- ==================== TABS NAVIGATION ==================== -->
<section class="py-6 bg-background-light border-b border-gray-200 sticky top-0 z-20 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('tenders', ['section' => $section, 'status' => 'active']) }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all duration-300
               {{ $status == 'active' ? 'bg-primary text-white shadow-lg' : 'bg-white text-text-black hover:bg-gray-100 border border-gray-300' }}">
                <i class="fas fa-play-circle mr-2"></i>Active Tenders
            </a>
            <a href="{{ route('tenders', ['section' => $section, 'status' => 'archived']) }}"
               class="px-6 py-3 rounded-lg font-semibold transition-all duration-300
               {{ $status == 'archived' ? 'bg-primary text-white shadow-lg' : 'bg-white text-text-black hover:bg-gray-100 border border-gray-300' }}">
                <i class="fas fa-archive mr-2"></i>Archived Tenders
            </a>
        </div>
    </div>
</section>

<!-- ==================== TENDERS TABLE SECTION ==================== -->
<section class="py-10 bg-background-light/90">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Status banner --}}
        @if($status == 'active')
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-green-500 mr-3 text-lg"></i>
                    <div>
                        <p class="text-green-700 font-medium">Active Tenders</p>
                        <p class="text-green-600 text-sm">These tenders are currently open for submission. Please review the deadlines carefully.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-50 border-l-4 border-gray-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-gray-500 mr-3 text-lg"></i>
                    <div>
                        <p class="text-gray-700 font-medium">Archived Tenders</p>
                        <p class="text-gray-600 text-sm">These tenders have closed. Documents are available for reference only.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== TABLE ===== --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">

            {{-- Table Header --}}
            <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-primary text-white text-xs font-semibold uppercase tracking-wider">
                <div class="col-span-1">#</div>
                <div class="col-span-6">Tender Name</div>
                <div class="col-span-2">Opening Date</div>
                <div class="col-span-2">Closing Date</div>
                <div class="col-span-1 text-center">Docs</div>
            </div>

            {{-- Table Rows --}}
            @forelse($tenders as $index => $tender)
            @php
                $today        = now()->startOfDay();
                $closingDate  = $tender->closing_date instanceof \Carbon\Carbon
                                    ? $tender->closing_date->copy()->startOfDay()
                                    : \Carbon\Carbon::parse($tender->closing_date)->startOfDay();

                $isExtended   = !empty($tender->extended_closing_date);
                $extendedDate = null;
                $deadlineDate = $closingDate;

                if ($isExtended) {
                    $extendedDate = $tender->extended_closing_date instanceof \Carbon\Carbon
                                       ? $tender->extended_closing_date->copy()->startOfDay()
                                       : \Carbon\Carbon::parse($tender->extended_closing_date)->startOfDay();
                    $deadlineDate = $extendedDate;
                }

                $isActive      = $deadlineDate->gte($today);
                $daysLeft      = $isActive ? (int) $today->diffInDays($deadlineDate) : 0;
                $isClosingSoon = $isActive && $daysLeft <= 15 && $daysLeft > 0;

                $hasAdditionalDocs = $tender->additionalDocs && $tender->additionalDocs->count() > 0;
                $rowBg = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                
                // Helper function to get file extension and icon
                $getFileInfo = function($filePath) {
                    if (!$filePath) return null;
                    
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $icon = '';
                    $color = '';
                    
                    switch($extension) {
                        case 'pdf':
                            $icon = 'fa-file-pdf';
                            $color = 'text-red-600';
                            break;
                        case 'doc':
                        case 'docx':
                            $icon = 'fa-file-word';
                            $color = 'text-blue-600';
                            break;
                        case 'xls':
                        case 'xlsx':
                            $icon = 'fa-file-excel';
                            $color = 'text-green-600';
                            break;
                        case 'ppt':
                        case 'pptx':
                            $icon = 'fa-file-powerpoint';
                            $color = 'text-orange-600';
                            break;
                        default:
                            $icon = 'fa-file';
                            $color = 'text-gray-600';
                    }
                    
                    return [
                        'extension' => strtoupper($extension),
                        'icon' => $icon,
                        'color' => $color
                    ];
                };
            @endphp

            <div class="border-b border-gray-200 last:border-b-0 {{ $rowBg }} hover:bg-amber-50/40 transition-colors duration-150">

                <div class="grid grid-cols-12 gap-4 px-6 py-4 items-start">

                    {{-- # --}}
                    <div class="col-span-1 text-sm font-semibold text-text-muted pt-0.5">
                        {{ $index + 1 }}
                    </div>

                    {{-- Tender Name + status badges + additional doc titles only --}}
                    <div class="col-span-6">
                        <div class="flex items-start gap-2">
                            <span class="mt-1.5 shrink-0">
                                @if($isActive)
                                    <span class="block w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                @else
                                    <span class="block w-2 h-2 rounded-full bg-gray-400"></span>
                                @endif
                            </span>
                            <div>
                                <p class="font-semibold text-text-black leading-snug {{ !$isActive ? 'text-gray-500' : '' }}">
                                    {{ Str::title($tender->name) }}
                                </p>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    @if($isExtended)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700">
                                            <i class="fas fa-history mr-1 text-[10px]"></i> Extended
                                        </span>
                                    @endif
                                    @if($isClosingSoon && $isActive)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                            <i class="fas fa-clock mr-1 text-[10px]"></i> Closing Soon
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Additional doc titles with label --}}
                        @if($hasAdditionalDocs)
                            <div class="mt-3 ml-4">
                                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide mb-1.5">Additional Documents</p>
                                <ul class="space-y-2 border-l-2 border-accent-1/40 pl-3">
                                    @foreach($tender->additionalDocs as $doc)
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-circle text-[5px] text-accent-1 shrink-0"></i>
                                        <span class="text-sm text-text-black">{{ $doc->title }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Opening Date --}}
                    <div class="col-span-2 text-sm {{ !$isActive ? 'text-gray-400' : 'text-text-black' }}">
                        {{ ($tender->opening_date instanceof \Carbon\Carbon
                            ? $tender->opening_date
                            : \Carbon\Carbon::parse($tender->opening_date))->format('d, M Y') }}
                    </div>

                    {{-- Closing Date --}}
                    <div class="col-span-2 text-sm">
                        @if($isExtended)
                            <span class="line-through text-text-muted text-xs block">{{ $closingDate->format('d, M Y') }}</span>
                            <span class="font-semibold {{ $isClosingSoon ? 'text-red-600' : ($isActive ? 'text-purple-600' : 'text-gray-400') }}">
                                {{ $extendedDate->format('d, M Y') }}
                            </span>
                        @else
                            <span class="{{ $isClosingSoon ? 'text-red-600 font-bold' : ($isActive ? 'text-text-black' : 'text-gray-400') }}">
                                {{ $closingDate->format('d, M Y') }}
                            </span>
                        @endif

                        @if($isActive)
                            <span class="block text-xs mt-0.5 {{ $isClosingSoon ? 'text-red-500 font-semibold' : 'text-text-muted' }}">
                                @if($daysLeft === 0) Closing today
                                @elseif($daysLeft === 1) 1 day left
                                @else {{ $daysLeft }} days left
                                @endif
                            </span>
                        @endif
                    </div>

                    {{-- Docs column: Show PDF and Word documents only --}}
                    <div class="col-span-1 flex flex-col items-center gap-2">
                        {{-- Main tender document --}}
                        @if($tender->document)
                            @php
                                $fileInfo = $getFileInfo($tender->document);
                            @endphp
                            @if($fileInfo)
                                <a href="{{ asset('storage/' . $tender->document) }}" target="_blank" 
                                   title="Tender Document ({{ $fileInfo['extension'] }})"
                                   class="{{ $fileInfo['color'] }} hover:opacity-75 transition-opacity">
                                    <div class="flex flex-col items-center">
                                        <i class="fas {{ $fileInfo['icon'] }} text-3xl"></i>
                                        <span class="text-[10px] font-semibold mt-0.5">{{ $fileInfo['extension'] }}</span>
                                    </div>
                                </a>
                            @endif
                        @endif

                        {{-- Advertisement --}}
                        @if($tender->advertisement)
                            @php
                                $fileInfo = $getFileInfo($tender->advertisement);
                            @endphp
                            @if($fileInfo)
                                <a href="{{ asset('storage/' . $tender->advertisement) }}" target="_blank" 
                                   title="Advertisement ({{ $fileInfo['extension'] }})"
                                   class="{{ $fileInfo['color'] }} hover:opacity-75 transition-opacity">
                                    <div class="flex flex-col items-center">
                                        <i class="fas {{ $fileInfo['icon'] }} text-3xl"></i>
                                        <span class="text-[10px] font-semibold mt-0.5">{{ $fileInfo['extension'] }}</span>
                                    </div>
                                </a>
                            @endif
                        @endif

                        {{-- Additional documents --}}
                        @if($hasAdditionalDocs)
                            @foreach($tender->additionalDocs as $doc)
                                @if($doc->document)
                                    @php
                                        $fileInfo = $getFileInfo($doc->document);
                                    @endphp
                                    @if($fileInfo)
                                        <a href="{{ asset('storage/' . $doc->document) }}" target="_blank" 
                                           title="{{ $doc->title }} ({{ $fileInfo['extension'] }})"
                                           class="{{ $fileInfo['color'] }} hover:opacity-75 transition-opacity">
                                            <div class="flex flex-col items-center">
                                                <i class="fas {{ $fileInfo['icon'] }} text-3xl"></i>
                                                <span class="text-[10px] font-semibold mt-0.5">{{ $fileInfo['extension'] }}</span>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

            @empty
            <div class="text-center py-16">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                <p class="text-text-muted text-lg">No {{ $status }} tenders available in this category.</p>
                <p class="text-text-secondary mt-2 text-sm">Please check back later for new opportunities.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>

<!-- ==================== TENDER SUBMISSION GUIDELINES ==================== -->
<section class="py-10 bg-background-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-text-green">Tender Submission Guidelines</h2>
            <div class="w-24 h-1.5 bg-accent-1 mx-auto mb-6"></div>
            <p class="text-lg text-text-muted max-w-3xl mx-auto">Essential information to ensure your tender submission meets all requirements</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-background-white p-8 rounded-xl border border-gray-200 hover:border-accent-1/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-primary-hover transition-colors duration-300">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-text-black">Submission Requirements</h3>
                <ul class="space-y-3 text-text-muted">
                    <li class="flex items-start">
                        <span class="text-primary mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Sealed envelopes with tender number clearly marked</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Complete documentation package (technical & financial)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                        <span class="flex-1">Original signed copies with company stamp</span>
                    </li>
                </ul>
            </div>

            <!-- Card 2 -->
            <div class="bg-background-white p-8 rounded-xl border border-gray-200 hover:border-accent-1/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-primary-hover transition-colors duration-300">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-text-black">Deadlines & Process</h3>
                <div class="space-y-4">
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-black">Submission Deadline</h4>
                            <p class="text-sm text-text-muted">Strictly enforced - no exceptions will be made</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-black">Evaluation Period</h4>
                            <p class="text-sm text-text-muted">30-45 working days after submission</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-white rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-black">Award Notification</h4>
                            <p class="text-sm text-text-muted">Published on our portal and via registered email</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-background-white p-8 rounded-xl border border-gray-200 hover:border-accent-1/50 transition-all duration-300 hover:shadow-lg group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-white group-hover:bg-primary-hover transition-colors duration-300">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-text-black">Support & Assistance</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-background-light rounded-lg border border-gray-200 hover:border-accent-1/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-text-black flex items-center">
                            <i class="fas fa-envelope text-primary mr-2"></i> Email Support
                        </h4>
                        <p class="text-sm text-text-muted">procurement@pppdepartmentkpk.gov.pk</p>
                        <p class="text-xs mt-1 text-text-muted">Response within 24-48 hours</p>
                    </div>
                    <div class="p-4 bg-background-light rounded-lg border border-gray-200 hover:border-accent-1/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-text-black flex items-center">
                            <i class="fas fa-phone-alt text-primary mr-2"></i> Helpline
                        </h4>
                        <p class="text-sm text-text-muted">+92 91 921 1234 (9AM-5PM, Mon-Fri)</p>
                        <p class="text-xs mt-1 text-text-muted">For urgent queries only</p>
                    </div>
                    <div class="p-4 bg-background-light rounded-lg border border-gray-200 hover:border-accent-1/50 transition-colors duration-200">
                        <h4 class="font-semibold mb-2 text-text-black flex items-center">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i> Office Visit
                        </h4>
                        <p class="text-sm text-text-muted">PPP Unit, P&D Department, Civil Secretariat, Peshawar</p>
                        <p class="text-xs mt-1 text-text-muted">By appointment only</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="mt-16 text-center">
            <h3 class="text-xl font-medium mb-6 text-text-black">Need personalized assistance with your tender application?</h3>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary-hover transition-colors duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i> Contact Us
            </a>
            <p class="text-sm text-text-muted mt-3">Our experts are available Monday-Friday, 9AM to 5PM</p>
        </div>
    </div>
</section>

@endsection