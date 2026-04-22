@extends('layouts.admin')

@section('title', 'Documents List - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Documents List</h2>
    <a href="{{ route('admin.downloads.add') }}" class="px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Document
    </a>
</div>

<main class="p-4 md:p-6">
    {{-- Static dummy documents --}}
    @php
    $dummyDocuments = [
        [
            'id' => 1,
            'document_name' => 'PPP Act 2023',
            'description' => 'Public Private Partnership Act 2023 with amendments and regulations.',
            'file_size' => 2457600, // 2.34 MB
            'uploaded_at' => '2024-03-15 10:30:00',
            'file_path' => '#',
        ],
        [
            'id' => 2,
            'document_name' => 'Project Guidelines',
            'description' => 'Comprehensive guidelines for PPP project preparation and implementation.',
            'file_size' => 1048576, // 1 MB
            'uploaded_at' => '2024-02-20 14:15:00',
            'file_path' => '#',
        ],
        [
            'id' => 3,
            'document_name' => 'Board Meeting Minutes',
            'description' => 'Minutes of the 5th Board Meeting held on January 15, 2024.',
            'file_size' => 512000, // 500 KB
            'uploaded_at' => '2024-01-16 09:45:00',
            'file_path' => '#',
        ],
        [
            'id' => 4,
            'document_name' => 'Annual Report 2023',
            'description' => 'Annual performance report of PPP projects for the year 2023.',
            'file_size' => 3145728, // 3 MB
            'uploaded_at' => '2024-01-05 11:20:00',
            'file_path' => '#',
        ],
        [
            'id' => 5,
            'document_name' => 'Policy Framework',
            'description' => 'PPP Policy Framework 2024-2029 outlining strategic objectives.',
            'file_size' => 1835008, // 1.75 MB
            'uploaded_at' => '2023-12-10 08:00:00',
            'file_path' => '#',
        ],
        [
            'id' => 6,
            'document_name' => 'Feasibility Study Template',
            'description' => 'Standard template for conducting feasibility studies of PPP projects.',
            'file_size' => 786432, // 768 KB
            'uploaded_at' => '2023-11-22 16:30:00',
            'file_path' => '#',
        ],
        [
            'id' => 7,
            'document_name' => 'Risk Management Guidelines',
            'description' => 'Guidelines for identifying and mitigating risks in PPP contracts.',
            'file_size' => 2097152, // 2 MB
            'uploaded_at' => '2023-10-05 13:10:00',
            'file_path' => '#',
        ],
        [
            'id' => 8,
            'document_name' => 'Stakeholder Engagement Plan',
            'description' => 'Plan for stakeholder consultation and communication.',
            'file_size' => 917504, // 896 KB
            'uploaded_at' => '2023-09-18 09:00:00',
            'file_path' => '#',
        ],
        [
            'id' => 9,
            'document_name' => 'Financial Model Template',
            'description' => 'Excel-based financial model for PPP project evaluation.',
            'file_size' => 1572864, // 1.5 MB
            'uploaded_at' => '2023-08-30 14:45:00',
            'file_path' => '#',
        ],
        [
            'id' => 10,
            'document_name' => 'Procurement Manual',
            'description' => 'Detailed procedures for procurement under PPP mode.',
            'file_size' => 2621440, // 2.5 MB
            'uploaded_at' => '2023-08-01 10:15:00',
            'file_path' => '#',
        ],
    ];

    // Pagination simulation
    $currentPage = request()->get('page', 1);
    $perPage = 10;
    $total = count($dummyDocuments);
    $totalPages = ceil($total / $perPage);
    $offset = ($currentPage - 1) * $perPage;
    $paginatedDocuments = array_slice($dummyDocuments, $offset, $perPage);
    @endphp

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paginatedDocuments as $document)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $document['document_name'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($document['description'], 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @php
                                        $size = $document['file_size'];
                                        if ($size >= 1073741824) {
                                            $size = number_format($size / 1073741824, 2) . ' GB';
                                        } elseif ($size >= 1048576) {
                                            $size = number_format($size / 1048576, 2) . ' MB';
                                        } elseif ($size >= 1024) {
                                            $size = number_format($size / 1024, 2) . ' KB';
                                        } else {
                                            $size = $size . ' bytes';
                                        }
                                    @endphp
                                    {{ $size }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ date('d M Y', strtotime($document['uploaded_at'])) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ $document['file_path'] }}" target="_blank" class="flex items-center text-emerald-600 hover:text-emerald-900">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.downloads.edit', $document['id']) }}" class="flex items-center text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-red-600 hover:text-red-900">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No documents found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $offset + 1 }}</span> to
                        <span class="font-medium">{{ min($offset + $perPage, $total) }}</span> of
                        <span class="font-medium">{{ $total }}</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{-- Previous --}}
                        @if($currentPage > 1)
                            <a href="?page={{ $currentPage - 1 }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif

                        {{-- Page Numbers (simplified) --}}
                        @for($i = 1; $i <= $totalPages; $i++)
                            @if($i == $currentPage)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-emerald-50 text-sm font-medium text-emerald-600">{{ $i }}</span>
                            @else
                                <a href="?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ $i }}</a>
                            @endif
                        @endfor

                        {{-- Next --}}
                        @if($currentPage < $totalPages)
                            <a href="?page={{ $currentPage + 1 }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>
@endsection