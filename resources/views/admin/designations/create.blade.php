@extends('layouts.admin')

@section('title', 'Add Designation - PPP Department KPK')
@section('header-title', 'Add New Designation')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.designations.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Designations
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-plus-circle mr-2 text-emerald-600"></i>
                    Add New Designation
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new designation/title for leadership or staff positions</p>
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

        <form action="{{ route('admin.designations.store') }}" method="POST" class="p-6">
            @csrf

            {{-- Designation Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Designation Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-tag"></i>
                    </span>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror"
                        placeholder="Enter designation title."
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">This title will be used for staff positions</p>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About Designations</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Designations represent official titles/positions.
                            These can be assigned to leadership messages and staff members to provide clarity about their roles.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.designations.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Create Designation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection