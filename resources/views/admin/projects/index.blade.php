@extends('layouts.admin')

@section('title', 'Projects - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Projects</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage investment projects</p>
        </div>
        <div class="flex gap-3">
            {{-- Bulk Delete Button - Only show if user has delete permission --}}
            @can('projects.delete')
                <button type="button" id="bulkDeleteBtn" 
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                        style="display: none;">
                    <i class="fas fa-trash-alt"></i>
                    Delete Selected (<span id="selectedCount">0</span>)
                </button>
            @endcan
            
            @can('projects.create')
                <a href="{{ route('admin.projects.add') }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fas fa-plus"></i>
                    Add Project
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-project-diagram mr-2 text-emerald-600"></i>
                        All Projects
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total: <span class="font-semibold text-emerald-600">{{ $projects->total() }}</span> projects
                    </p>
                </div>
                <div class="flex gap-2">
                    <form method="GET" action="{{ route('admin.projects.index') }}" class="flex gap-2">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search projects by name..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <form id="bulkDeleteForm" action="{{ route('admin.projects.bulk-delete') }}" method="POST">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('projects.delete')
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" 
                                           id="selectAllCheckbox" 
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                            @endcan
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Image</th>
                            <th class="px-6 py-3 text-left">Project Name</th>
                            <th class="px-6 py-3 text-left">Sector</th>
                            <th class="px-6 py-3 text-left">Cost (PKR)</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            
                            {{-- Actions column - Only show if user has any action permissions --}}
                            @if(auth()->user()->can('projects.view') || auth()->user()->can('projects.edit') || auth()->user()->can('projects.delete'))
                                <th class="px-6 py-3 text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition" data-project-id="{{ $project->id }}">
                            {{-- Checkbox column - Only show if user has delete permission --}}
                            @can('projects.delete')
                                <td class="px-6 py-4">
                                    <input type="checkbox" 
                                           name="project_ids[]" 
                                           value="{{ $project->id }}"
                                           class="project-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </td>
                            @endcan
                            
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                #{{ $project->id }}
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($project->image && Storage::disk('public')->exists($project->image))
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($project->image) }}" 
                                             alt="{{ $project->name }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $project->name }}</span>
                                    @if($project->location)
                                        <div class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ Str::limit($project->location, 40) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-1 rounded-md">
                                    <i class="fas fa-chart-line mr-1 text-xs"></i>
                                    {{ $project->sector }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rs. {{ number_format($project->cost, 2) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $project->implementing_authority ? Str::limit($project->implementing_authority, 20) : 'N/A' }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($project->category == 'Pipeline') bg-blue-100 text-blue-800
                                    @elseif($project->category == 'Ongoing') bg-yellow-100 text-yellow-800
                                    @elseif($project->category == 'Completed') bg-green-100 text-green-800
                                    @endif">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    {{ $project->category }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                                    {{ $project->status ?? 'N/A' }}
                                </span>
                            </td>
                            
                            {{-- Actions column --}}
                            @if(auth()->user()->can('projects.view') || auth()->user()->can('projects.edit') || auth()->user()->can('projects.delete'))
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View Button --}}
                                        @can('projects.view')
                                            <a href="{{ route('admin.projects.show', $project) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                               title="View Project Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Edit Button --}}
                                        @can('projects.edit')
                                            <a href="{{ route('admin.projects.edit', $project) }}" 
                                               class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                               title="Edit Project">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        {{-- Delete Button --}}
                                        @can('projects.delete')
                                            <button type="button"
                                                    onclick="confirmDelete({{ $project->id }}, '{{ addslashes($project->name) }}')" 
                                                    class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                    title="Delete Project">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                @php
                                    $colspan = 8; // Base columns (ID, Image, Project Name, Sector, Cost, Category, Status)
                                    if(auth()->user()->can('projects.delete')) $colspan++; // Add checkbox column
                                    if(auth()->user()->can('projects.view') || auth()->user()->can('projects.edit') || auth()->user()->can('projects.delete')) $colspan++; // Add actions column
                                @endphp
                                <td colspan="{{ $colspan }}" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-project-diagram text-4xl mb-2"></i>
                                    <p class="text-lg mb-1">No projects found</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.projects.index') }}" class="text-emerald-600 hover:underline text-sm">
                                            Clear search
                                        </a>
                                    @else
                                        @can('projects.create')
                                            <a href="{{ route('admin.projects.add') }}" class="text-emerald-600 hover:underline text-sm">
                                                Create your first project →
                                            </a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    @if($projects->hasPages())
        <div class="mt-4">
            {{ $projects->appends(request()->query())->links() }}
        </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Project</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete project "<span id="deleteProjectName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All associated data will be removed.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelDeleteBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bulk Delete Confirmation Modal --}}
@can('projects.delete')
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Bulk Delete Projects</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="bulkDeleteCount" class="font-semibold text-gray-700"></span> project(s)?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelBulkDeleteBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button id="confirmBulkDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endcan

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bulk delete functionality - Only initialize if user has delete permission
        @can('projects.delete')
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const projectCheckboxes = document.querySelectorAll('.project-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
            const cancelBulkDeleteBtn = document.getElementById('cancelBulkDeleteBtn');
            const confirmBulkDeleteBtn = document.getElementById('confirmBulkDeleteBtn');
            
            // Update selected count and show/hide bulk delete button
            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.project-checkbox:checked');
                const count = checkedBoxes.length;
                if (selectedCountSpan) {
                    selectedCountSpan.textContent = count;
                }
                
                if (bulkDeleteBtn) {
                    if (count > 0) {
                        bulkDeleteBtn.style.display = 'inline-flex';
                    } else {
                        bulkDeleteBtn.style.display = 'none';
                    }
                }
            }
            
            // Select/Deselect all checkboxes
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    projectCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }
            
            // Individual checkbox change
            projectCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    // Update select all checkbox state
                    if (selectAllCheckbox) {
                        const allChecked = projectCheckboxes.length === document.querySelectorAll('.project-checkbox:checked').length;
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            
            // Bulk delete button click - show modal
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.project-checkbox:checked');
                    const count = checkedBoxes.length;
                    
                    if (count === 0) {
                        alert('Please select at least one project to delete.');
                        return;
                    }
                    
                    bulkDeleteCountSpan.textContent = count;
                    bulkDeleteModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            // Confirm bulk delete
            if (confirmBulkDeleteBtn) {
                confirmBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                    bulkDeleteForm.submit();
                });
            }
            
            // Cancel bulk delete
            if (cancelBulkDeleteBtn) {
                cancelBulkDeleteBtn.addEventListener('click', function() {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                });
            }
            
            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === bulkDeleteModal) {
                    bulkDeleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
                if (e.target === document.getElementById('deleteModal')) {
                    closeDeleteModal();
                }
            });
            
            // Initialize count on page load
            updateSelectedCount();
        @endcan
        
        // Delete confirmation functions - Only define if user has delete permission
        @can('projects.delete')
            window.confirmDelete = function(projectId, projectName) {
                const modal = document.getElementById('deleteModal');
                const deleteProjectNameSpan = document.getElementById('deleteProjectName');
                const deleteForm = document.getElementById('deleteForm');
                
                deleteProjectNameSpan.textContent = projectName;
                deleteForm.action = `/admin/projects/${projectId}`;
                
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Close modal on cancel
                document.getElementById('cancelDeleteBtn').onclick = function() {
                    closeDeleteModal();
                };
                
                // Close modal when clicking outside
                modal.onclick = function(e) {
                    if (e.target === modal) {
                        closeDeleteModal();
                    }
                };
            };
            
            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const deleteForm = document.getElementById('deleteForm');
                
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                    if (deleteForm) {
                        deleteForm.action = '';
                    }
                }
            }
        @endcan
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                @can('projects.delete')
                    const deleteModal = document.getElementById('deleteModal');
                    const bulkDeleteModal = document.getElementById('bulkDeleteModal');
                    
                    if (deleteModal && !deleteModal.classList.contains('hidden')) {
                        closeDeleteModal();
                    }
                    if (bulkDeleteModal && !bulkDeleteModal.classList.contains('hidden')) {
                        bulkDeleteModal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                @endcan
            }
        });
        
        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const successMsg = document.querySelector('.bg-green-50');
            const errorMsg = document.querySelector('.bg-red-50');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);
    });
</script>
@endpush
@endsection