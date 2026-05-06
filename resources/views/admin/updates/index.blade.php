{{-- resources/views/admin/updates/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Updates - PPP Department KPK')
@section('header-title', 'Updates Management')

@section('content')
<div class="max-w-full mx-auto">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold text-gray-800">
                <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                All Updates
            </h2>
            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $total }} Total
            </span>
        </div>
        <a href="{{ route('admin.updates.add') }}"
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Add Update
        </a>
    </div>

    {{-- Filter Tabs --}}
    @php
        $activeFilter = request('type', 'all');
        $filters = [
            'all'          => ['label' => 'All',           'icon' => 'fa-list'],
            'Update'       => ['label' => 'Updates',       'icon' => 'fa-sync-alt'],
            'Event'        => ['label' => 'Events',        'icon' => 'fa-calendar-alt'],
            'Announcement' => ['label' => 'Announcements', 'icon' => 'fa-bullhorn'],
            'Press Release'=> ['label' => 'Press Releases','icon' => 'fa-newspaper'],
            'Notice'       => ['label' => 'Notices',       'icon' => 'fa-bell'],
            'featured'     => ['label' => 'Featured',      'icon' => 'fa-star'],
        ];
    @endphp
    <div class="mb-6 flex flex-wrap gap-2">
        @foreach($filters as $key => $filter)
            <a href="{{ route('admin.updates.index', $key !== 'all' ? ['type' => $key] : []) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                      {{ $activeFilter === $key
                          ? 'bg-emerald-600 text-white'
                          : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                <i class="fas {{ $filter['icon'] }} mr-1 {{ $key === 'featured' ? 'text-yellow-500' : '' }}"></i>
                {{ $filter['label'] }}
            </a>
        @endforeach
    </div>

    {{-- Updates Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title &amp; Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PDF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($news as $item)
                        @php
                            $typeColors = [
                                'Update'       => 'bg-green-100 text-green-800',
                                'Event'        => 'bg-purple-100 text-purple-800',
                                'Announcement' => 'bg-yellow-100 text-yellow-800',
                                'Press Release'=> 'bg-red-100 text-red-800',
                                'Notice'       => 'bg-orange-100 text-orange-800',
                                'Circular'     => 'bg-blue-100 text-blue-800',
                            ];
                            $badgeClass = $typeColors[$item->type] ?? 'bg-gray-100 text-gray-800';
                            $displayDate = $item->event_date ?? $item->created_at;
                            $dateLabel   = $item->event_date ? 'Event Date' : 'Published';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->title }}
                                    @if($item->is_featured)
                                        <i class="fas fa-star text-yellow-500 ml-2 text-xs"></i>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 mt-1 line-clamp-2">
                                    {{ Str::limit($item->content, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                    <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                    {{ \Carbon\Carbon::parse($displayDate)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400">{{ $dateLabel }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->is_featured)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i> Featured
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->pdf_path)
                                    <a href="{{ Storage::url($item->pdf_path) }}" target="_blank"
                                       class="text-emerald-600 hover:text-emerald-800 p-2 rounded hover:bg-emerald-50 inline-flex items-center">
                                        <i class="fas fa-file-pdf mr-1"></i>
                                        <span class="text-sm">View</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.updates.edit', $item) }}"
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.updates.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Delete \'{{ addslashes($item->title) }}\'? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-bullhorn text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500 text-lg mb-2">No updates found</p>
                                    <p class="text-gray-400 text-sm">Try changing your filter or
                                        <a href="{{ route('admin.updates.add') }}" class="text-emerald-600 hover:underline">add a new update</a>.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($news->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Showing
                        <span class="font-medium">{{ $news->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $news->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $news->total() }}</span>
                        results
                    </div>
                    {{ $news->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection