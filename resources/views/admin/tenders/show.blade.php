@extends('layouts.admin')

@section('title', $tender->name . ' - Tender Details - PPP Department KPK')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.tenders.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Tenders
        </a>
    </div>

    {{-- Tender Header Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                        <i class="fas fa-file-alt text-emerald-600 text-xl"></i>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $tender->name }}</h3>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($tender->statusColor == 'green') bg-green-100 text-green-800
                            @elseif($tender->statusColor == 'yellow') bg-yellow-100 text-yellow-800
                            @elseif($tender->statusColor == 'red') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            <i class="fas fa-circle mr-1 text-[8px] align-middle"></i>
                            {{ $tender->status }}
                        </span>
                        @if($tender->is_extended)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                <i class="fas fa-calendar-plus mr-1 text-xs"></i>
                                Extended
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Created: {{ $tender->created_at->format('F d, Y') }}  
                    </p>
                </div>
                <div class="flex gap-2">
                    @can('tenders.edit')
                        <a href="{{ route('admin.tenders.edit', $tender) }}" 
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                            Edit Tender
                        </a>
                    @endcan
                    @can('tenders.delete')
                        <button type="button"
                                onclick="confirmDelete({{ $tender->id }}, '{{ addslashes($tender->name) }}')" 
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        {{-- Basic Information --}}
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                Basic Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tender Name</label>
                    <p class="text-gray-900 font-medium">{{ $tender->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                    <p class="inline-flex items-center bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-md">
                        <i class="fas fa-tag mr-1 text-xs"></i>
                        {{ $tender->category }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Opening Date</label>
                    <p class="text-gray-900">
                        <i class="fas fa-calendar-alt text-emerald-600 mr-1"></i>
                        {{ $tender->opening_date ? $tender->opening_date->format('F d, Y') : 'N/A' }}
                        @if($tender->opening_date)
                            <span class="text-gray-500 text-sm ml-2">
                                ({{ $tender->opening_date->format('l') }})
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Closing Date</label>
                    <div>
                        @if($tender->is_extended)
                            <p class="text-gray-500 line-through">
                                <i class="fas fa-calendar-times text-gray-400 mr-1"></i>
                                {{ $tender->closing_date ? $tender->closing_date->format('F d, Y') : 'N/A' }}
                                @if($tender->closing_date)
                                    <span class="text-gray-400 text-sm ml-2">
                                        ({{ $tender->closing_date->format('l') }})
                                    </span>
                                @endif
                            </p>
                            <p class="text-orange-600 font-medium mt-1">
                                <i class="fas fa-calendar-plus text-orange-600 mr-1"></i>
                                {{ $tender->effective_closing_date ? $tender->effective_closing_date->format('F d, Y') : 'N/A' }}
                                @if($tender->effective_closing_date)
                                    <span class="text-orange-400 text-sm ml-2">
                                        ({{ $tender->effective_closing_date->format('l') }})
                                    </span>
                                @endif
                                <span class="text-xs text-orange-500 ml-2">
                                    (Extended)
                                </span>
                            </p>
                        @else
                            <p class="text-gray-900">
                                <i class="fas fa-calendar-times text-red-600 mr-1"></i>
                                {{ $tender->closing_date ? $tender->closing_date->format('F d, Y') : 'N/A' }}
                                @if($tender->closing_date)
                                    <span class="text-gray-500 text-sm ml-2">
                                        ({{ $tender->closing_date->format('l') }})
                                    </span>
                                @endif
                            </p>
                        @endif
                        
                        @if($tender->isOpen())
                            <div class="mt-2">
                                @php
                                    $daysRemaining = $tender->days_remaining;
                                @endphp
                                @if($daysRemaining <= 7)
                                    <div class="text-sm text-red-600 font-semibold">
                                        <i class="fas fa-hourglass-end mr-1"></i>
                                        {{ $tender->days_remaining_text }}
                                    </div>
                                @else
                                    <div class="text-sm text-emerald-600">
                                        <i class="fas fa-hourglass-half mr-1"></i>
                                        {{ $tender->days_remaining_text }}
                                    </div>
                                @endif
                            </div>
                        @elseif($tender->isClosed())
                            <div class="mt-1 text-sm text-red-600">
                                <i class="fas fa-clock mr-1"></i>
                                Closed on {{ $tender->effective_closing_date->format('F d, Y') }}
                            </div>
                        @elseif($tender->isUpcoming())
                            <div class="mt-1 text-sm text-yellow-600">
                                <i class="fas fa-calendar-week mr-1"></i>
                                Opening on {{ $tender->opening_date->format('F d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Documents Section --}}
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-file-upload mr-2 text-emerald-600"></i>
                Documents
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Main Tender Document --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-pdf text-red-500 mr-1"></i>
                        Tender Document
                    </label>
                    @if($tender->document && Storage::disk('public')->exists($tender->document))
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 mb-1">Main tender document</p>
                                <a href="{{ Storage::url($tender->document) }}" target="_blank" 
                                   class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                    <i class="fas fa-download"></i>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400 italic">No document uploaded</p>
                    @endif
                </div>

                {{-- Advertisement --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image text-emerald-500 mr-1"></i>
                        Advertisement
                    </label>
                    @if($tender->advertisement && Storage::disk('public')->exists($tender->advertisement))
                        @php
                            $extension = pathinfo($tender->advertisement, PATHINFO_EXTENSION);
                        @endphp
                        <div class="flex items-center gap-3">
                            @if(strtolower($extension) == 'pdf')
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Advertisement document</p>
                                    <a href="{{ Storage::url($tender->advertisement) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <i class="fas fa-download"></i>
                                        View Document
                                    </a>
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-emerald-200">
                                    <img src="{{ Storage::url($tender->advertisement) }}" 
                                         alt="Advertisement"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Advertisement image</p>
                                    <a href="{{ Storage::url($tender->advertisement) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <i class="fas fa-expand"></i>
                                        View Full Size
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-400 italic">No advertisement uploaded</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Additional Documents Section --}}
        @if($tender->additionalDocs && $tender->additionalDocs->count() > 0)
        <div class="p-6 border-b border-gray-200">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-paperclip mr-2 text-emerald-600"></i>
                Additional Documents ({{ $tender->additionalDocs->count() }})
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($tender->additionalDocs as $doc)
                    <div class="bg-gray-50 rounded-lg p-3 hover:bg-gray-100 transition">
                        <div class="flex items-start gap-3">
                            @php
                                $docExtension = pathinfo($doc->document, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($docExtension), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-emerald-600"></i>
                                </div>
                            @elseif(strtolower($docExtension) == 'pdf')
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-red-600"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $doc->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Published: {{ $doc->publish_date ? $doc->publish_date->format('M d, Y') : 'N/A' }}
                                </p>
                                <a href="{{ Storage::url($doc->document) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 text-xs mt-2">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Timeline Information --}}
        <div class="p-6">
            <h4 class="text-md font-semibold text-gray-800 mb-4">
                <i class="fas fa-history mr-2 text-emerald-600"></i>
                Timeline Information
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500 uppercase mb-1">Created</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $tender->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-400">{{ $tender->created_at->format('h:i A') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500 uppercase mb-1">Last Updated</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $tender->updated_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-400">{{ $tender->updated_at->format('h:i A') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500 uppercase mb-1">Time Remaining</p>
                    @if($tender->isOpen())
                        <p class="text-sm font-semibold text-emerald-600">
                            {{ $tender->days_remaining }} days
                        </p>
                        <p class="text-xs text-gray-500">until closing</p>
                    @elseif($tender->isClosed())
                        <p class="text-sm font-semibold text-red-600">Closed</p>
                        <p class="text-xs text-gray-500">on {{ $tender->effective_closing_date->format('M d, Y') }}</p>
                    @elseif($tender->isUpcoming())
                        <p class="text-sm font-semibold text-yellow-600">Upcoming</p>
                        <p class="text-xs text-gray-500">opens on {{ $tender->opening_date->format('M d, Y') }}</p>
                    @else
                        <p class="text-sm font-semibold text-gray-600">N/A</p>
                    @endif
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-gray-500 uppercase mb-1">Tender ID</p>
                    <p class="text-sm font-semibold text-gray-800 font-mono">#{{ $tender->id }}</p>
                    <p class="text-xs text-gray-400">Reference Number</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons Footer --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.tenders.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
            <i class="fas fa-arrow-left"></i>
            Back to Tenders
        </a>
        
        <div class="flex gap-2">
            @can('tenders.edit')
                @if($tender->is_extended)
                    <button type="button"
                            onclick="confirmRemoveExtension({{ $tender->id }}, '{{ addslashes($tender->name) }}')" 
                            class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        <i class="fas fa-calendar-minus"></i>
                        Remove Extension
                    </button>
                @else
                    <button type="button"
                            onclick="showExtendModal({{ $tender->id }}, '{{ addslashes($tender->name) }}', '{{ $tender->closing_date ? $tender->closing_date->format('Y-m-d') : '' }}')" 
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        <i class="fas fa-calendar-plus"></i>
                        Extend Date
                    </button>
                @endif
            @endcan
        </div>
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Tender</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete tender "<span id="deleteTenderName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-red-500 mt-2">This action cannot be undone. All associated documents will be removed.</p>
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

{{-- Extend Date Modal --}}
<div id="extendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-calendar-plus text-blue-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4 text-center">Extend Closing Date</h3>
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-3">
                    Extend closing date for tender: <strong id="extendTenderName" class="text-emerald-600"></strong>
                </p>
                <p class="text-xs text-gray-500 mb-3">
                    Current closing date: <strong id="currentClosingDate"></strong>
                </p>
                <form id="extendForm" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Closing Date</label>
                        <input type="date" id="new_closing_date" name="new_closing_date" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <p class="text-xs text-gray-500 mt-1">Must be after current closing date</p>
                    </div>
                    <div class="flex justify-center gap-3 mt-6">
                        <button type="button" id="cancelExtendBtn" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition">
                            Extend Date
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Remove Extension Modal --}}
<div id="removeExtensionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100">
                <i class="fas fa-calendar-minus text-orange-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Remove Extension</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to remove the extension for tender "<span id="removeExtendTenderName" class="font-semibold text-gray-700"></span>"?
                </p>
                <p class="text-xs text-orange-500 mt-2">This will reset the closing date to the original date.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button id="cancelRemoveExtendBtn" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <form id="removeExtensionForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-md hover:bg-orange-700 transition">
                        Remove Extension
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Delete confirmation
    window.confirmDelete = function(tenderId, tenderName) {
        const modal = document.getElementById('deleteModal');
        const deleteTenderNameSpan = document.getElementById('deleteTenderName');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteTenderNameSpan.textContent = tenderName;
        deleteForm.action = `/admin/tenders/${tenderId}`;
        
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
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    // Extend date modal
    window.showExtendModal = function(tenderId, tenderName, currentClosingDate) {
        const modal = document.getElementById('extendModal');
        const extendTenderNameSpan = document.getElementById('extendTenderName');
        const extendForm = document.getElementById('extendForm');
        const newClosingDateInput = document.getElementById('new_closing_date');
        const currentClosingDateSpan = document.getElementById('currentClosingDate');
        
        extendTenderNameSpan.textContent = tenderName;
        extendForm.action = `/admin/tenders/${tenderId}/extend`;
        
        // Format current closing date
        if (currentClosingDate) {
            const date = new Date(currentClosingDate);
            currentClosingDateSpan.textContent = date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            // Set minimum date to current closing date + 1 day
            const minDate = new Date(currentClosingDate);
            minDate.setDate(minDate.getDate() + 1);
            const year = minDate.getFullYear();
            const month = String(minDate.getMonth() + 1).padStart(2, '0');
            const day = String(minDate.getDate()).padStart(2, '0');
            newClosingDateInput.min = `${year}-${month}-${day}`;
        }
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Close modal on cancel
        document.getElementById('cancelExtendBtn').onclick = function() {
            closeExtendModal();
        };
    };
    
    function closeExtendModal() {
        const modal = document.getElementById('extendModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    // Remove extension modal
    window.confirmRemoveExtension = function(tenderId, tenderName) {
        const modal = document.getElementById('removeExtensionModal');
        const removeExtendTenderNameSpan = document.getElementById('removeExtendTenderName');
        const removeExtensionForm = document.getElementById('removeExtensionForm');
        
        removeExtendTenderNameSpan.textContent = tenderName;
        removeExtensionForm.action = `/admin/tenders/${tenderId}/remove-extension`;
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Close modal on cancel
        document.getElementById('cancelRemoveExtendBtn').onclick = function() {
            closeRemoveExtensionModal();
        };
        
        // Close modal when clicking outside
        modal.onclick = function(e) {
            if (e.target === modal) {
                closeRemoveExtensionModal();
            }
        };
    };
    
    function closeRemoveExtensionModal() {
        const modal = document.getElementById('removeExtensionModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
            closeExtendModal();
            closeRemoveExtensionModal();
        }
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        const deleteModal = document.getElementById('deleteModal');
        const extendModal = document.getElementById('extendModal');
        const removeExtensionModal = document.getElementById('removeExtensionModal');
        
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
        if (e.target === extendModal) {
            closeExtendModal();
        }
        if (e.target === removeExtensionModal) {
            closeRemoveExtensionModal();
        }
    });
</script>
@endpush
@endsection