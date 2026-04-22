@extends('layouts.admin')

@section('title', 'Edit Tender - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Edit Tender</h2>
    <a href="/tenders" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
        Back to Tenders List
    </a>
</div>

<!-- Main Content -->
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <form action="{{ route('tenders.update', $tender->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tender_no" class="block text-sm font-medium text-gray-700">Tender Number<span class="text-red-500">*</span></label>
                    <input type="text" id="tender_no" name="tender_no" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('tender_no') border-red-500 @enderror"
                        value="{{ old('tender_no', $tender->tender_no) }}">
                    @error('tender_no')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="tender_name" class="block text-sm font-medium text-gray-700">Tender Name<span class="text-red-500">*</span></label>
                    <input type="text" id="tender_name" name="tender_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('tender_name') border-red-500 @enderror"
                        value="{{ old('tender_name', $tender->tender_name) }}">
                    @error('tender_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description<span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('description') border-red-500 @enderror">{{ old('description', $tender->description) }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category<span class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="Healthcare" @selected(old('category', $tender->category) === 'Healthcare')>Healthcare</option>
                        <option value="Transport" @selected(old('category', $tender->category) === 'Transport')>Transport</option>
                        <option value="Energy" @selected(old('category', $tender->category) === 'Energy')>Energy</option>
                        <option value="Education" @selected(old('category', $tender->category) === 'Education')>Education</option>
                        <option value="Sanitation" @selected(old('category', $tender->category) === 'Sanitation')>Sanitation</option>
                        <option value="Infrastructure" @selected(old('category', $tender->category) === 'Infrastructure')>Infrastructure</option>
                        <option value="Construction" @selected(old('category', $tender->category) === 'Construction')>Construction</option>
                        <option value="Consultancy" @selected(old('category', $tender->category) === 'Consultancy')>Consultancy</option>
                        <option value="Services" @selected(old('category', $tender->category) === 'Services')>Services</option>
                        <option value="Supplies" @selected(old('category', $tender->category) === 'Supplies')>Supplies</option>
                        <option value="Other" @selected(old('category', $tender->category) === 'Other')>Other</option>
                    </select>
                    @error('category')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700">Tender Document (PDF)</label>
                    <input type="file" id="document" name="document" accept=".pdf,.doc,.docx"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('document') border-red-500 @enderror">
                    @if (!empty($tender->document_path))
                        <p class="mt-2 text-sm text-gray-500">
                            Current file: <a href="{{ Storage::url($tender->document_path) }}" target="_blank" class="text-emerald-600 hover:underline">View PDF</a>
                        </p>
                    @endif
                    @error('document')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date<span class="text-red-500">*</span></label>
                    <input type="date" id="start_date" name="start_date" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('start_date') border-red-500 @enderror"
                        value="{{ old('start_date', $tender->start_date->format('Y-m-d')) }}">
                    @error('start_date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date<span class="text-red-500">*</span></label>
                    <input type="date" id="end_date" name="end_date" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('end_date') border-red-500 @enderror"
                        value="{{ old('end_date', $tender->end_date->format('Y-m-d')) }}">
                    @error('end_date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
                    Update Tender
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
