@extends('layouts.admin')

@section('title', 'Edit Leadership Message - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Edit Leadership Message</h2>
    <a href="{{ route('admin.leadership.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
        Back to Messages
    </a>
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <form action="{{ route('admin.leadership.update', $message->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name<span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                           value="{{ old('name', $message->name) }}">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</span>
                    @enderror
                </div>

                <div>
                    <label for="designation" class="block text-sm font-medium text-gray-700">Designation<span class="text-red-500">*</span></label>
                    <input type="text" id="designation" name="designation" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('designation') border-red-500 @enderror"
                           value="{{ old('designation', $message->designation) }}">
                    @error('designation')
                        <span class="text-red-500 text-sm mt-1">{{ $errors->first('designation') }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="message_text" class="block text-sm font-medium text-gray-700">Message<span class="text-red-500">*</span></label>
                <textarea id="message_text" name="message" rows="5" required
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('message') border-red-500 @enderror">{{ old('message', $message->message) }}</textarea>
                @error('message')
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('message') }}</span>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Profile Image</label>

                @if ($message->image)
                    <div class="mt-2 mb-3 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $message->image) }}"
                             alt="Current image"
                             class="w-20 h-20 rounded-full object-cover border border-gray-300 shadow">
                        <span class="text-sm text-gray-500">Current image</span>
                    </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-medium
                              file:bg-emerald-50 file:text-emerald-700
                              hover:file:bg-emerald-100">
                <p class="mt-1 text-xs text-gray-400">Leave empty to keep the current image. Accepted: JPG, PNG, WEBP.</p>

                @error('image')
                    <span class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</span>
                @enderror
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
                    Update Message
                </button>
            </div>
        </form>
    </div>
</main>
@endsection