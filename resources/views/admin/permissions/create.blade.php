@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.permissions.index') }}"
           class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Add Permission</h1>
            <p class="text-sm text-gray-500 mt-0.5">Create a new permission</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Permission Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. edit-posts, view-orders, delete-users"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-400 @enderror">
                <p class="mt-1.5 text-xs text-gray-400">
                    Use lowercase letters and hyphens only. Example: <code class="bg-gray-100 px-1 rounded">edit-posts</code>
                </p>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Create Permission
                </button>
                <a href="{{ route('admin.permissions.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection