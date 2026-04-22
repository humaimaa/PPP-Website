{{-- resources/views/admin/downloads/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Downloads List - PPP Department KPK')
@section('header-title', 'Downloads Management')

@section('content')
<div class="max-w-full mx-auto">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Message --}}
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
                <i class="fas fa-download mr-2 text-emerald-600"></i>
                All Downloads
            </h2>
            {{-- <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $total }} Total
            </span> --}}
        </div>
        <a href="{{ route('admin.downloads.add') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i>
            Add New Download
        </a>
    </div>

    {{-- Static dummy downloads --}}
    @php
    $dummyDownloads = [
        [
            'id' => 1,
            'title' => 'PPP Act 2023',
            'description' => 'Public Private Partnership Act 2023 with amendments and regulations.',
            'file_size' => 2457600, // 2.34 MB
            'uploaded_at' => '2024-03-15 10:30:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Legislation',
        ],
        [
            'id' => 2,
            'title' => 'Project Guidelines',
            'description' => 'Comprehensive guidelines for PPP project preparation and implementation.',
            'file_size' => 1048576, // 1 MB
            'uploaded_at' => '2024-02-20 14:15:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Guidelines',
        ],
        [
            'id' => 3,
            'title' => 'Board Meeting Minutes',
            'description' => 'Minutes of the 5th Board Meeting held on January 15, 2024.',
            'file_size' => 512000, // 500 KB
            'uploaded_at' => '2024-01-16 09:45:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Minutes',
        ],
        [
            'id' => 4,
            'title' => 'Annual Report 2023',
            'description' => 'Annual performance report of PPP projects for the year 2023.',
            'file_size' => 3145728, // 3 MB
            'uploaded_at' => '2024-01-05 11:20:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Reports',
        ],
        [
            'id' => 5,
            'title' => 'Policy Framework',
            'description' => 'PPP Policy Framework 2024-2029 outlining strategic objectives.',
            'file_size' => 1835008, // 1.75 MB
            'uploaded_at' => '2023-12-10 08:00:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Policy',
        ],
        [
            'id' => 6,
            'title' => 'Feasibility Study Template',
            'description' => 'Standard template for conducting feasibility studies of PPP projects.',
            'file_size' => 786432, // 768 KB
            'uploaded_at' => '2023-11-22 16:30:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Templates',
        ],
        [
            'id' => 7,
            'title' => 'Risk Management Guidelines',
            'description' => 'Guidelines for identifying and mitigating risks in PPP contracts.',
            'file_size' => 2097152, // 2 MB
            'uploaded_at' => '2023-10-05 13:10:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Guidelines',
        ],
        [
            'id' => 8,
            'title' => 'Stakeholder Engagement Plan',
            'description' => 'Plan for stakeholder consultation and communication.',
            'file_size' => 917504, // 896 KB
            'uploaded_at' => '2023-09-18 09:00:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Plans',
        ],
        [
            'id' => 9,
            'title' => 'Financial Model Template',
            'description' => 'Excel-based financial model for PPP project evaluation.',
            'file_size' => 1572864, // 1.5 MB
            'uploaded_at' => '2023-08-30 14:45:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Templates',
        ],
        [
            'id' => 10,
            'title' => 'Procurement Manual',
            'description' => 'Detailed procedures for procurement under PPP mode.',
            'file_size' => 2621440, // 2.5 MB
            'uploaded_at' => '2023-08-01 10:15:00',
            'file_path' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            'category' => 'Manuals',
        ],
    ];

    // Pagination simulation
    $currentPage = request()->get('page', 1);
    $perPage = 10;
    $total = count($dummyDownloads);
    $totalPages = ceil($total / $perPage);
    $offset = ($currentPage - 1) * $perPage;
    $paginatedDownloads = array_slice($dummyDownloads, $offset, $perPage);
    @endphp

    {{-- Downloads Table Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            File Info
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Uploaded
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paginatedDownloads as $download)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 mr-3 text-lg"></i>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $download['title'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    {{ $download['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-md">
                                    {{ Str::limit($download['description'], 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @php
                                        $size = $download['file_size'];
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-database mr-1"></i>
                                        {{ $size }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                    {{ date('d M Y', strtotime($download['uploaded_at'])) }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ date('h:i A', strtotime($download['uploaded_at'])) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    {{-- View PDF Button - Opens in new blank page --}}
                                    <a href="{{ $download['file_path'] }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                       title="View PDF">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    {{-- Edit Button - Opens edit page --}}
                                    <a href="{{ route('admin.downloads.edit', $download['id']) }}" 
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                       title="Edit Download">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    
                                    {{-- Delete Button --}}
                                    <button onclick="confirmDelete({{ $download['id'] }}, '{{ $download['title'] }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                            title="Delete Download">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-download text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500 text-lg mb-2">No downloads found</p>
                                    <p class="text-gray-400 text-sm mb-4">Get started by adding your first download</p>
                                    <a href="{{ route('admin.downloads.add') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add New Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($totalPages > 1)
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-medium">{{ $offset + 1 }}</span> to
                        <span class="font-medium">{{ min($offset + $perPage, $total) }}</span> of
                        <span class="font-medium">{{ $total }}</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        {{-- Previous --}}
                        @if($currentPage > 1)
                            <a href="?page={{ $currentPage - 1 }}" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max(1, $currentPage - 2);
                            $end = min($totalPages, $currentPage + 2);
                        @endphp

                        @if($start > 1)
                            <a href="?page=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                            @if($start > 2)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $currentPage)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-emerald-600 text-sm font-medium text-white">{{ $i }}</span>
                            @else
                                <a href="?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $totalPages)
                            @if($end < $totalPages - 1)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                            @endif
                            <a href="?page={{ $totalPages }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">{{ $totalPages }}</a>
                        @endif

                        {{-- Next --}}
                        @if($currentPage < $totalPages)
                            <a href="?page={{ $currentPage + 1 }}" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDeleteModal()"></div>

        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="mt-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Delete Download</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Are you sure you want to delete this download? This action cannot be undone.
                    </p>
                    <p class="mt-2 text-sm font-medium text-gray-700" id="deleteDownloadTitle"></p>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentDeleteId = null;

    window.confirmDelete = function(id, title) {
        currentDeleteId = id;
        document.getElementById('deleteDownloadTitle').textContent = title;
        document.getElementById('deleteForm').action = `/admin/downloads/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentDeleteId = null;
    };

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const deleteModal = document.getElementById('deleteModal');
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
</script>
@endpush