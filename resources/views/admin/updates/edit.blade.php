{{-- resources/views/admin/updates/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Update - PPP Department KPK')
@section('header-title', 'Edit Update')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            <i class="fas fa-edit mr-2 text-emerald-600"></i>
            Edit Update #{{ $news->id }}
        </h2>
        <a href="{{ route('admin.updates.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Updates List
        </a>
    </div>

    {{-- Edit Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-bullhorn mr-2 text-emerald-600"></i>
                Edit Update Details
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update the information below</p>
        </div>

        <form action="{{ route('admin.updates.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div class="space-y-4">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $news->title) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('title') border-red-500 @enderror"
                            placeholder="Enter update title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="type"
                            name="type"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('type') border-red-500 @enderror"
                        >
                            <option value="">Select Type</option>
                            @foreach(['Update','Event','Announcement','Press Release','Notice','Circular'] as $t)
                                <option value="{{ $t }}" {{ old('type', $news->type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Event Date --}}
                    <div id="eventDateField" class="{{ old('type', $news->type) === 'Event' ? '' : 'hidden' }}">
                        <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Event Date <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="event_date"
                            name="event_date"
                            value="{{ old('event_date', $news->event_date?->format('Y-m-d')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('event_date') border-red-500 @enderror"
                        >
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Featured --}}
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-1 text-yellow-500"></i>
                                Mark as Featured
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-8">Featured items appear prominently on the homepage</p>
                    </div>

                    {{-- Timestamps --}}
                    <div class="bg-gray-50 rounded-lg p-4 text-sm">
                        <p class="text-gray-600">
                            <i class="far fa-calendar-plus mr-2"></i>
                            Created: {{ $news->created_at->format('d M Y, H:i') }}
                        </p>
                        <p class="text-gray-600 mt-1">
                            <i class="far fa-calendar-check mr-2"></i>
                            Last Updated: {{ $news->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="space-y-4">
                    {{-- PDF Attachment --}}
                    <div>
                        <label for="pdf_file" class="block text-sm font-medium text-gray-700 mb-2">
                            PDF Attachment
                        </label>
                        <input
                            type="file"
                            id="pdf_file"
                            name="pdf_file"
                            accept=".pdf,application/pdf"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('pdf_file') border-red-500 @enderror"
                        >
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-file-pdf mr-1"></i>
                            PDF only (max 10MB). Leave empty to keep the current file.
                        </p>
                        @if($news->pdf_path)
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg flex items-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                <span class="text-sm text-gray-600">Current file:</span>
                                <a href="{{ Storage::url($news->pdf_path) }}" target="_blank"
                                   class="text-sm text-emerald-600 hover:underline">View PDF</a>
                            </div>
                        @endif
                        @error('pdf_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Live Preview --}}
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-eye mr-1"></i> Quick Preview
                        </h4>
                        <div class="bg-white rounded-lg border border-gray-200 p-3">
                            <div class="flex items-start justify-between mb-2">
                                <span id="previewType" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $news->type }}
                                </span>
                                <span id="previewFeatured" class="text-yellow-500 {{ $news->is_featured ? '' : 'hidden' }}">
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <h5 id="previewTitle" class="font-semibold text-gray-900 mb-1 text-sm">{{ $news->title }}</h5>
                            <p id="previewContent" class="text-xs text-gray-600 line-clamp-2">{{ $news->content }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="6"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('content') border-red-500 @enderror"
                >{{ old('content', $news->content) }}</textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500"><span id="charCount">0</span> characters</p>
                    <p class="text-xs text-gray-400">Recommended: 150–500 characters</p>
                </div>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.updates.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect      = document.getElementById('type');
    const eventDateField  = document.getElementById('eventDateField');
    const eventDateInput  = document.getElementById('event_date');
    const contentTextarea = document.getElementById('content');
    const charCount       = document.getElementById('charCount');
    const titleInput      = document.getElementById('title');
    const featuredChk     = document.getElementById('is_featured');
    const previewType     = document.getElementById('previewType');
    const previewTitle    = document.getElementById('previewTitle');
    const previewContent  = document.getElementById('previewContent');
    const previewFeatured = document.getElementById('previewFeatured');

    const typeColors = {
        'Update':        'bg-green-100 text-green-800',
        'Event':         'bg-purple-100 text-purple-800',
        'Announcement':  'bg-yellow-100 text-yellow-800',
        'Press Release': 'bg-red-100 text-red-800',
        'Notice':        'bg-orange-100 text-orange-800',
        'Circular':      'bg-blue-100 text-blue-800',
    };

    function toggleEventDate() {
        if (typeSelect.value === 'Event') {
            eventDateField.classList.remove('hidden');
            eventDateInput.required = true;
        } else {
            eventDateField.classList.add('hidden');
            eventDateInput.required = false;
        }
        updatePreview();
    }

    function updatePreview() {
        const type = typeSelect.value || 'Update';
        previewType.textContent = type;
        previewType.className   = `inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${typeColors[type] || 'bg-gray-100 text-gray-800'}`;
        previewTitle.textContent   = titleInput.value || 'Title will appear here';
        previewContent.textContent = contentTextarea.value || 'Content preview will appear here...';
        previewFeatured.classList.toggle('hidden', !featuredChk.checked);
    }

    typeSelect.addEventListener('change', toggleEventDate);
    titleInput.addEventListener('input', updatePreview);
    contentTextarea.addEventListener('input', () => {
        charCount.textContent = contentTextarea.value.length;
        updatePreview();
    });
    featuredChk.addEventListener('change', updatePreview);
    eventDateInput.addEventListener('change', updatePreview);

    // File validation
    document.getElementById('pdf_file').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (!file.name.toLowerCase().endsWith('.pdf')) {
            alert('Please select a valid PDF file.');
            this.value = '';
            return;
        }
        if (file.size > 10 * 1024 * 1024) {
            alert('File size exceeds 10 MB.');
            this.value = '';
        }
    });

    // Init
    charCount.textContent = contentTextarea.value.length;
    toggleEventDate();
    updatePreview();
});
</script>
@endpush