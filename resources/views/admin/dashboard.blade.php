@extends('layouts.admin')

@section('title', 'Dashboard - PPP Department KPK')
@section('header-title', 'Dashboard Overview')

@section('content')
<div class="dashboard-container">
    {{-- Stats Cards --}}
    <div id="dashboardCards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 transition-all duration-300">
        
        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-700 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-emerald-100 text-emerald-700">
                        <i class="fas fa-project-diagram text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Projects</p>
                        <h3 class="text-2xl font-bold">{{ $totalProjects ?? 0 }}</h3>
                        <a href="{{ route('admin.projects.index') }}" 
                           class="text-sm text-emerald-700 hover:underline mt-1 inline-block">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-file-signature text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Open Tenders</p>
                        <h3 class="text-2xl font-bold">{{ $openTenders ?? 0 }}</h3>
                        <a href="{{ route('admin.tenders.index') }}" 
                           class="text-sm text-blue-600 hover:underline mt-1 inline-block">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-newspaper text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">News Items</p>
                        <h3 class="text-2xl font-bold">{{ $newsItems ?? 0 }}</h3>
                        <a href="{{ route('admin.updates.index') }}" 
                           class="text-sm text-yellow-600 hover:underline mt-1 inline-block">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-folder-open text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Public Documents</p>
                        <h3 class="text-2xl font-bold">{{ $publicDocuments ?? 0 }}</h3>
                        <a href="{{ route('admin.downloads.index') }}" 
                           class="text-sm text-purple-600 hover:underline mt-1 inline-block">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Events</p>
                    <h3 class="text-2xl font-bold">{{ $totalEvents ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Team Members</p>
                    <h3 class="text-2xl font-bold">{{ $teamMembers ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-full bg-teal-100 text-teal-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">System Users</p>
                    <h3 class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Tenders Section --}}
    @if(isset($upcomingTenders) && $upcomingTenders->count() > 0)
    <section class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-emerald-900">Tenders Closing Soon</h2>
            <a href="{{ route('admin.tenders.index') }}" class="text-sm text-emerald-600 hover:underline">View All →</a>
        </div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tender Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Closing Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days Left</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($upcomingTenders as $tender)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.tenders.show', $tender) }}" class="text-emerald-600 hover:underline">
                                    {{ $tender->name }}
                                </a>
                                @if($tender->is_extended)
                                    <span class="ml-2 text-xs text-orange-600">
                                        <i class="fas fa-calendar-plus"></i> Extended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">{{ $tender->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($tender->is_extended)
                                    <div>
                                        <span class="text-gray-500 line-through text-sm">
                                            {{ $tender->closing_date->format('M d, Y') }}
                                        </span>
                                        <div class="text-orange-600 font-medium">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                            {{ $tender->effective_closing_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                @else
                                    <span>{{ $tender->effective_closing_date->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    // Use effective closing date and ensure integer
                                    $effectiveDate = $tender->is_extended ? $tender->extended_closing_date : $tender->closing_date;
                                    $daysLeft = $effectiveDate ? (int)floor(now()->diffInDays($effective_date, false)) : 0;
                                    if ($daysLeft < 0) $daysLeft = 0;
                                @endphp
                                @if($daysLeft <= 7 && $daysLeft > 0)
                                    <span class="text-red-600 font-semibold">{{ $daysLeft }} day(s)</span>
                                @elseif($daysLeft > 0)
                                    <span class="text-gray-600">{{ $daysLeft }} day(s)</span>
                                @else
                                    <span class="text-gray-400">Closed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    {{-- Recent Activity Section --}}
    <section class="mb-8">
        <h2 class="text-xl font-bold text-emerald-900 mb-4">Recent Activity</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @forelse(($recentActivities ?? collect()) as $activity)
            <div class="p-4 border-b hover:bg-gray-50 transition">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="p-2 rounded-full bg-gray-100 text-{{ $activity->icon_color ?? 'gray' }}-600 mr-3">
                            <i class="fas fa-{{ $activity->icon ?? 'bell' }} text-xl"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $activity->title ?? '' }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $activity->action ?? '' }} • {{ $activity->time->diffForHumans() ?? '' }}
                                @if(isset($activity->status))
                                    • <span class="capitalize">{{ $activity->status }}</span>
                                @endif
                                @if(isset($activity->category))
                                    • {{ $activity->category }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @if(isset($activity->link) && $activity->link != '#')
                    <a href="{{ $activity->link }}" class="text-emerald-600 hover:text-emerald-700 text-sm">
                        View <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-12 text-center text-gray-400">
                <i class="fas fa-inbox text-4xl mb-2"></i>
                <p>No recent activities found</p>
            </div>
            @endforelse
        </div>
    </section>

    {{-- Document Categories Distribution --}}
    @if(isset($documentCategories) && $documentCategories->count() > 0)
    <section class="mb-8">
        <h2 class="text-xl font-bold text-emerald-900 mb-4">Document Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($documentCategories as $cat)
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 
                @if($cat->category == 'Legal Framework') border-purple-500
                @elseif($cat->category == 'Prequalified Transaction Advisory') border-blue-500
                @elseif($cat->category == 'Policies ,Regulations and Guidelines') border-green-500
                @elseif($cat->category == 'Knowledge Hub') border-yellow-500
                @elseif($cat->category == 'Pitchbook') border-orange-500
                @else border-gray-500
                @endif">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Documents</p>
                        <h4 class="font-semibold">{{ Str::limit($cat->category, 30) }}</h4>
                    </div>
                    <div class="text-2xl font-bold text-gray-700">{{ $cat->count }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection