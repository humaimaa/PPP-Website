@extends('layouts.admin')

@section('title', 'Add New Tender - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Add New Tender</h2>
</div>

<!-- Main Form -->
<main class="p-4 md:p-6">
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="#" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-lg shadow-md p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-4">
                    <label for="tender_name" class="block text-gray-700 font-medium mb-2">Tender Name<span class="text-red-500">*</span></label>
                    <input type="text" id="tender_name" name="tender_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('tender_name') border-red-500 @enderror"
                        value="{{ old('tender_name') }}">
                    @error('tender_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tender_no" class="block text-gray-700 font-medium mb-2">Tender Number<span class="text-red-500">*</span></label>
                    <input type="text" id="tender_no" name="tender_no" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('tender_no') border-red-500 @enderror"
                        value="{{ old('tender_no') }}">
                    <p class="text-sm text-gray-500 mt-1">Format: PPP-KPK-YYYY-XXX</p>
                    @error('tender_no')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-gray-700 font-medium mb-2">Category<span class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="Healthcare" @selected(old('category') === 'Healthcare')>Healthcare</option>
                        <option value="Transport" @selected(old('category') === 'Transport')>Transport</option>
                        <option value="Energy" @selected(old('category') === 'Energy')>Energy</option>
                        <option value="Education" @selected(old('category') === 'Education')>Education</option>
                        <option value="Sanitation" @selected(old('category') === 'Sanitation')>Sanitation</option>
                        <option value="Infrastructure" @selected(old('category') === 'Infrastructure')>Infrastructure</option>
                        <option value="Other" @selected(old('category') === 'Other')>Other</option>
                    </select>
                    @error('category')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date<span class="text-red-500">*</span></label>
                    <input type="date" id="start_date" name="start_date" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('start_date') border-red-500 @enderror"
                        value="{{ old('start_date') }}">
                    @error('start_date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">End Date<span class="text-red-500">*</span></label>
                    <input type="date" id="end_date" name="end_date" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('end_date') border-red-500 @enderror"
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tender_document" class="block text-gray-700 font-medium mb-2">Tender Document<span class="text-red-500">*</span></label>
                    <input type="file" id="tender_document" name="tender_document" accept=".pdf,.doc,.docx" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('tender_document') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">PDF or Word document (max 10MB)</p>
                    @error('tender_document')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Full width field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description<span class="text-red-500">*</span></label>
            <textarea id="description" name="description" rows="4" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Brief description of the tender (shown below the title in listings)</p>
            @error('description')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                class="px-6 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Save Tender
            </button>
        </div>
    </form>
</main>
@endsection
