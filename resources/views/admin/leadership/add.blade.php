@extends('layouts.admin')

@section('title', 'Add Leadership Message - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Add Leadership Message</h2>
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

    {{-- enctype is required for file uploads --}}
    <form action="{{ route('admin.leadership.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name<span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('name') border-red-500 @enderror"
                       value="{{ old('name') }}">
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Designation --}}
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

        {{-- Message --}}
        <div class="mb-4">
            <label for="message" class="block text-gray-700 font-medium mb-2">Message<span class="text-red-500">*</span></label>
            <textarea id="message" name="message" rows="5" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
            @error('message')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-medium mb-2">Photo <span class="text-gray-400 text-sm font-normal">(optional, max 2MB — jpeg/png/jpg/webp)</span></label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent @error('image') border-red-500 @enderror"
                   onchange="previewImage(event)">
            @error('image')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            {{-- Live preview --}}
            <div id="image-preview" class="mt-3 hidden">
                <img id="preview-img" src="" alt="Preview"
                     class="w-24 h-24 rounded-full object-cover border-2 border-emerald-400 shadow">
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit"
                    class="px-6 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Save Message
            </button>
        </div>
    </form>
</main>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection