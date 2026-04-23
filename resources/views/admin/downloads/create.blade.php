@extends('layouts.admin')

@section('title', 'Add Document - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Add New Document</h2>
</div>

<main class="p-4 md:p-6">
    {{-- Success/Error messages (static placeholders) --}}
    {{-- @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif --}}

    <form action="#" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-lg shadow-md p-6">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            {{-- Document Name --}}
            <div class="mb-4">
                <label for="document_name" class="block text-gray-700 font-medium mb-2">Document Name*</label>
                <input type="text" id="document_name" name="document_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0A612B]"
                    value="{{ old('document_name', 'Sample Document Name') }}">
            </div>

            {{-- Document Type --}}
            <div class="mb-4">
                <label for="document_type" class="block text-gray-700 font-medium mb-2">Document Type*</label>
                <select id="document_type" name="document_type" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0A612B]">
                    <option value="">Select Document Type</option>
                    <option value="Act" {{ old('document_type') == 'Act' ? 'selected' : '' }}>Act</option>
                    <option value="Guideline" {{ old('document_type') == 'Guideline' ? 'selected' : '' }}>Guideline</option>
                    <option value="Minutes" {{ old('document_type') == 'Minutes' ? 'selected' : '' }}>Minutes</option>
                    <option value="Policy" {{ old('document_type') == 'Policy' ? 'selected' : '' }}>Policy</option>
                    <option value="Report" {{ old('document_type') == 'Report' ? 'selected' : '' }}>Report</option>
                    <option value="Other" {{ old('document_type') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0A612B]">{{ old('description', 'Sample description for the document.') }}</textarea>
            </div>

            {{-- File Upload --}}
            <div class="mb-4">
                <label for="document_file" class="block text-gray-700 font-medium mb-2">Document File (PDF)*</label>
                <input type="file" id="document_file" name="document_file" accept=".pdf" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#0A612B]">
                <p class="text-sm text-gray-500 mt-1">Max 10MB (PDF only)</p>
            </div>

            {{-- File Info Preview (static placeholder) --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">File Information</label>
                <div id="fileInfo" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md">
                    <span class="text-gray-400">No file selected</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-6 py-2 bg-[#0A612B] text-white rounded-md hover:bg-[#0D2818] transition-colors">
                Upload Document
            </button>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    // Simple file info preview (static demo)
    document.getElementById('document_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const infoDiv = document.getElementById('fileInfo');
        if (file) {
            infoDiv.innerHTML = `
                <span class="text-gray-700">Name: ${file.name}<br>Size: ${(file.size / 1024).toFixed(2)} KB</span>
            `;
        } else {
            infoDiv.innerHTML = '<span class="text-gray-400">No file selected</span>';
        }
    });
</script>
@endpush