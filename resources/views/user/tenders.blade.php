@extends('layouts.app')

@section('title', 'PPP Department KPK - Tenders & Opportunities')

@section('content')

<section class="relative h-[60vh] md:h-[70vh] overflow-hidden">
    <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center">
        <div class="text-center px-4 pt-26">
            <h1 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Tenders & Opportunities
            </h1>
            <div class="w-20 h-1 bg-white mx-auto"></div>
            <p class="text-white mt-4 text-lg">
                @if($section == 'general-procurement') General Procurement
                @elseif($section == 'transaction-advisory') Transaction Advisory
                @else Private Partner Selection
                @endif
            </p>
        </div>
    </div>
    <img src="{{ asset('images/project-1.jpg') }}" alt="Tenders Banner" class="w-full h-full object-cover">
</section>


<!-- ==================== ALL TENDERS SECTION ==================== -->
<section class="py-10 bg-background-light/90">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-text-green mb-4">All Tenders</h2>
            <div class="w-20 h-1 bg-accent-1 mx-auto"></div>
            <p class="text-text-muted mt-4">Browse all tenders and bidding opportunities</p>
        </div>

        <div class="space-y-6">
            @forelse($allTenders as $tender)
            @php
                // Use start-of-day for both sides so "closing 10 Jun, today is 9 Jun" = 1 day left
                $today       = now()->startOfDay();
                $closingDate = $tender->closing_date instanceof \Carbon\Carbon
                    ? $tender->closing_date->copy()->startOfDay()
                    : \Carbon\Carbon::parse($tender->closing_date)->startOfDay();

                // Extended logic:
                // - closing_date          = the ORIGINAL closing date (never changes)
                // - extended_closing_date = the NEW closing date (nullable column)
                // The effective deadline for active/days-left is extended_closing_date if present, else closing_date.
                $isExtended   = !empty($tender->extended_closing_date);
                $extendedDate = null;
                $deadlineDate = $closingDate; // what we actually count down to

                if ($isExtended) {
                    $extendedDate = $tender->extended_closing_date instanceof \Carbon\Carbon
                        ? $tender->extended_closing_date->copy()->startOfDay()
                        : \Carbon\Carbon::parse($tender->extended_closing_date)->startOfDay();
                    $deadlineDate = $extendedDate;
                }

                $isActive      = $deadlineDate->gte($today);
                $daysLeft      = $isActive ? (int) $today->diffInDays($deadlineDate) : 0;
                $isClosingSoon = $isActive && $daysLeft <= 15;
            @endphp

            <div class="bg-background-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 relative">

                {{-- Status badges --}}
                <div class="absolute top-4 right-4 z-10 flex flex-col items-end gap-1">

                    @if($isExtended)
                        <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-history mr-1"></i> Extended
                        </span>
                    @endif

                    @if($isClosingSoon)
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold animate-pulse">
                            <i class="fas fa-clock mr-1"></i> Closing Soon!
                        </span>
                    @elseif($isActive)
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                    @else
                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-archive mr-1"></i> Archived
                        </span>
                    @endif

                </div>

                <div class="p-6">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-text-black mb-2">{{ $tender->name }}</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">

                                {{-- Opening date --}}
                                <div class="flex items-center text-sm text-text-muted">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                    <span>Opening:
                                        {{ ($tender->opening_date instanceof \Carbon\Carbon
                                            ? $tender->opening_date
                                            : \Carbon\Carbon::parse($tender->opening_date))->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Closing date --}}
                                <div class="flex flex-col justify-center text-sm">
                                    @if($isExtended)
                                        {{-- Show original date with strikethrough, then extended date --}}
                                        <div class="flex items-center flex-wrap gap-x-1">
                                            <i class="fas fa-calendar-check text-gray-400 mr-1"></i>
                                            <span class="text-text-muted">Closing:</span>
                                            <span class="line-through text-text-muted ml-1">
                                                {{ $closingDate->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center flex-wrap gap-x-1 mt-0.5">
                                            <i class="fas fa-calendar-plus text-purple-500 mr-1"></i>
                                            <span class="font-semibold {{ $isClosingSoon ? 'text-red-600' : 'text-purple-600' }}">
                                                {{ $extendedDate->format('d M Y') }}
                                            </span>
                                            <span class="text-xs font-semibold text-purple-500 border border-purple-400 rounded px-1 ml-1">
                                                Extended
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-check text-gray-400 mr-2"></i>
                                            <span class="text-text-muted">Closing:</span>
                                            <span class="ml-1 font-semibold {{ $isClosingSoon ? 'text-red-600' : ($isActive ? 'text-text-black' : 'text-text-muted') }}">
                                                {{ $closingDate->format('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Days left --}}
                                <div class="flex items-center text-sm">
                                    @if($isActive)
                                        <i class="fas fa-hourglass-half text-gray-400 mr-2"></i>
                                        @if($daysLeft === 0)
                                            <span class="font-semibold text-red-600">Closing today</span>
                                        @elseif($daysLeft === 1)
                                            <span class="font-semibold text-red-600">1 day left</span>
                                        @else
                                            <span class="font-semibold {{ $isClosingSoon ? 'text-red-600' : 'text-text-black' }}">
                                                {{ $daysLeft }} days left
                                            </span>
                                        @endif
                                    @else
                                        <i class="fas fa-ban text-gray-400 mr-2"></i>
                                        <span class="text-text-muted text-xs italic">Closed</span>
                                    @endif
                                </div>

                            </div>{{-- /grid --}}
                        </div>

                        {{-- Document buttons --}}
                        <div class="flex gap-3">
                            @if($tender->document)
                            <a href="{{ asset('storage/' . $tender->document) }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 {{ $isActive ? 'bg-primary hover:bg-primary-hover' : 'bg-gray-600 hover:bg-gray-700' }} text-text-primary rounded-lg transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i> Tender Doc
                            </a>
                            @endif
                            @if($tender->advertisement)
                            <a href="{{ asset('storage/' . $tender->advertisement) }}" target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-text-primary rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-image mr-2"></i> Advt
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Additional Documents --}}
                @if($tender->additionalDocs && $tender->additionalDocs->count() > 0)
                <div class="bg-background-light border-t border-gray-200 px-6 py-4">
                    <h4 class="text-sm font-semibold text-text-black mb-3 flex items-center">
                        <i class="fas fa-paperclip mr-2 text-text-muted"></i>
                        Additional Documents ({{ $tender->additionalDocs->count() }})
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($tender->additionalDocs as $doc)
                        <div class="flex justify-between items-center p-3 bg-background-white rounded border border-gray-200 hover:border-accent-1/30 transition-colors">
                            <div>
                                <p class="font-medium text-text-black text-sm">{{ $doc->title }}</p>
                                <p class="text-xs text-text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    Published: {{ ($doc->publish_date instanceof \Carbon\Carbon
                                        ? $doc->publish_date
                                        : \Carbon\Carbon::parse($doc->publish_date))->format('d M Y') }}
                                </p>
                            </div>
                            <a href="{{ asset('storage/' . $doc->document) }}" target="_blank"
                               class="text-primary hover:text-primary-hover text-sm font-medium">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>{{-- /card --}}

            @empty
            <div class="bg-background-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-text-muted text-lg">No tenders available in this category.</p>
                <p class="text-text-secondary mt-2">Please check back later for new opportunities.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- Tender Submission Guidelines Section -->
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
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-text-primary group-hover:bg-primary-hover transition-colors duration-300">
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
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-text-primary group-hover:bg-primary-hover transition-colors duration-300">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-text-black">Deadlines & Process</h3>
                <div class="space-y-4">
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-text-primary rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-black">Submission Deadline</h4>
                            <p class="text-sm text-text-muted">Strictly enforced - no exceptions will be made</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-text-primary rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text-black">Evaluation Period</h4>
                            <p class="text-sm text-text-muted">30-45 working days after submission</p>
                        </div>
                    </div>
                    <div class="flex items-start bg-background-light p-3 rounded-lg">
                        <div class="bg-primary text-text-primary rounded-lg w-10 h-10 flex items-center justify-center mr-3 shrink-0">
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
                <div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-6 text-2xl text-text-primary group-hover:bg-primary-hover transition-colors duration-300">
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
                        <p class="text-sm text-text-muted">PPP Department, Civil Secretariat, Peshawar</p>
                        <p class="text-xs mt-1 text-text-muted">By appointment only</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional CTA -->
        <div class="mt-16 text-center">
            <h3 class="text-xl font-medium mb-6 text-text-black">Need personalized assistance with your tender application?</h3>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary text-text-primary rounded-lg font-semibold hover:bg-primary-hover transition-colors duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i> Contact Us
            </a>
            <p class="text-sm text-text-muted mt-3">Our experts are available Monday-Friday, 9AM to 5PM</p>
        </div>
    </div>
</section>

@endsection