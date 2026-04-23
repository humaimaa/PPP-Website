@extends('layouts.admin')

@section('title', 'Tender List - PPP Department KPK')

@section('content')

@php
use Carbon\Carbon;

$tenders = collect([
    (object)[
        'id' => 1,
        'tender_no' => 'TND-001',
        'tender_name' => 'Construction of Highway Section A',
        'description' => 'Development of a 4-lane highway project connecting major cities.',
        'category' => 'Infrastructure',
        'start_date' => Carbon::parse('2026-04-01'),
        'end_date' => Carbon::parse('2026-05-01'),
        'document_path' => 'dummy/sample.pdf'
    ],
    (object)[
        'id' => 2,
        'tender_no' => 'TND-002',
        'tender_name' => 'Solar Energy Installation Project',
        'description' => 'Installation of solar panels in rural and remote areas.',
        'category' => 'Energy',
        'start_date' => Carbon::parse('2026-04-05'),
        'end_date' => Carbon::parse('2026-05-10'),
        'document_path' => 'dummy/sample.pdf'
    ],
    (object)[
        'id' => 3,
        'tender_no' => 'TND-003',
        'tender_name' => 'Hospital Equipment Supply',
        'description' => 'Procurement and installation of modern medical equipment.',
        'category' => 'Health',
        'start_date' => Carbon::parse('2026-04-10'),
        'end_date' => Carbon::parse('2026-05-20'),
        'document_path' => 'dummy/sample.pdf'
    ]
]);
@endphp

<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Tender List</h2>
    <a href="{{ route('admin.tenders.add') }}" class="flex items-center px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Tender
    </a>
</div>

<main class="p-4 md:p-6">

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tender No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tender Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tenders as $tender)
                        <tr>
                            <td class="px-6 py-4">{{ $tender->tender_no }}</td>

                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ Str::limit($tender->tender_name, 30) }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit($tender->description, 50) }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 text-xs rounded-full bg-green-100 text-green-800">
                                    {{ $tender->category }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $tender->start_date->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $tender->end_date->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    {{-- View PDF Button - Opens in new blank page --}}
                                    <a href="#" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                       title="View PDF">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    {{-- Edit Button - Opens edit page --}}
                                    <a href="{{ route('admin.tenders.edit', $tender->id) }}" 
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                       title="Edit Tender">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    
                                    {{-- Delete Button --}}
                                    <button onclick="confirmDelete({{ $tender->id }}, '{{ $tender->tender_name }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                            title="Delete Tender">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No tenders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination disabled for dummy data --}}
    </div>
</main>

@endsection