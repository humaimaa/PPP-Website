@extends('layouts.admin')

@section('title', 'Leadership Message - PPP Department KPK')

@section('content')
<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Leadership Message</h2>
    <a href="{{ route('admin.leadership.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
        Back to Messages
    </a>
</div>

<main class="p-4 md:p-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Name</h3>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $message->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Designation</h3>
                <p class="mt-1 text-lg text-gray-700">{{ $message->designation }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Message</h3>
            <div class="prose max-w-none text-gray-800 leading-relaxed whitespace-pre-line">
                {{ $message->message }}
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.leadership.edit', $message->id) }}"
               class="px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
                Edit Message
            </a>
            <form action="{{ route('admin.leadership.destroy', $message->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Delete Message
                </button>
            </form>
        </div>
    </div>
</main>
@endsection