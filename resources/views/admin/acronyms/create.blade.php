@extends('layouts.admin')

@section('title', 'Add Acronym - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.acronyms.index') }}"
            class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Acronyms
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-font mr-2 text-emerald-600"></i>
                    Add New Acronym
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new acronym with its full form</p>
            </div>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
            <div class="flex">
                <div class="shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
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

        <form action="{{ route('admin.acronyms.store') }}" method="POST" class="p-6" id="acronymForm">
            @csrf

            {{-- Basic Information Section --}}
            <div class="mb-6 pb-4 border-b border-gray-200">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                    Acronym Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Acronym --}}
                    <div>
                        <label for="acronym" class="block text-sm font-medium text-gray-700 mb-2">
                            Acronym <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-font"></i>
                            </span>
                            <input type="text" id="acronym" name="acronym" value="{{ old('acronym') }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('acronym') border-red-500 @enderror"
                                placeholder="Enter acronym (e.g., PPP)">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Enter a unique acronym (max 50 characters)</p>
                        @error('acronym')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stands For --}}
                    <div>
                        <label for="standfor" class="block text-sm font-medium text-gray-700 mb-2">
                            Stands For <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <input type="text" id="standfor" name="standfor" value="{{ old('standfor') }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('standfor') border-red-500 @enderror"
                                placeholder="Enter the full form (e.g., Public Private Partnership)">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Enter the full meaning of the acronym (max 255 characters)</p>
                        @error('standfor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Acronyms</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Acronyms are abbreviations formed from the initial letters of a phrase. 
                            They help in creating short, memorable names for organizations, programs, and terms. 
                            Each acronym must be unique in the system.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.acronyms.index') }}"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Create Acronym
                </button>
            </div>
        </form>
    </div>
</div>
@endsection