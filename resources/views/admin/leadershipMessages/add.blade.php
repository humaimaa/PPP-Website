@extends('layouts.admin')

@section('title', 'Add Leadership Message - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Add Leadership Message</h2>
</div>

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

    <form action="{{ route('admin.leadershipMessages.store') }}" method="POST"
          class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Left Column --}}
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name<span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Right Column --}}
            <div>
                <div class="mb-4">
                    <label for="designation" class="block text-gray-700 font-medium mb-2">Designation<span class="text-red-500">*</span></label>
                    <input type="text" id="designation" name="designation" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('designation') border-red-500 @enderror"
                           value="{{ old('designation') }}">
                    @error('designation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Full width field --}}
        <div class="mb-4">
            <label for="message" class="block text-gray-700 font-medium mb-2">Message<span class="text-red-500">*</span></label>
            <textarea id="message" name="message" rows="5" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
            @error('message')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Save Message
            </button>
        </div>
    </form>
</main>
@endsection