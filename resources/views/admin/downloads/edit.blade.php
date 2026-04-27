@extends('layouts.admin')

@section('title', 'Edit Document - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Edit Document</h2>
    <a href="{{ route('admin.downloads.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
        Back to Documents List
    </a>
</div>

<main class="p-4 md:p-6">
    {{-- Static dummy document data --}}
    @php
    $document = [
        'id' => request()->route('id', 1),
        'document_name' => 'PPP Act 2023',
        'description' => 'Public Private Partnership Act 2023 with amendments and regulations.',
        'file_path' => '#',
        'file_size' => 2457600, // 2.34 MB
        'uploaded_at' => '2024-03-15 10:30:00',
    ];
    @endphp

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

    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6">
                {{-- Document Name --}}
                <div>
                    <label for="document_name" class="block text-sm font-medium text-gray-700">Document Name*</label>
                    <input type="text" id="document_name" name="document_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                        value="{{ old('document_name', $document['document_name']) }}">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $document['description']) }}</textarea>
                </div>

                {{-- Current File Info --}}
                <div class="border border-gray-200 rounded-md p-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Document</h3>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <a href="{{ $document['file_path'] }}" target="_blank" class="text-emerald-600 hover:underline">
                                View Current PDF
                            </a>
                            <p class="text-xs text-gray-500 mt-1">
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
                                Uploaded: {{ date('d M Y', strtotime($document['uploaded_at'])) }} | Size: {{ $size }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- File Upload (for replacement) --}}
                <div>
                    <label for="document_file" class="block text-sm font-medium text-gray-700">Replace Document (PDF)</label>
                    <input type="file" id="document_file" name="document_file" accept=".pdf"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <p class="text-sm text-gray-500 mt-1">Max 10MB (PDF only). Leave empty to keep current file.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
                    Update Document
                </button>
            </div>
        </form>
    </div>
</main>
@endsection