@extends('layouts.admin')

@section('title', 'Leadership Messages - PPP Department KPK')

@section('content')

<div class="flex justify-between items-center p-4 pt-8">
    <h2 class="text-2xl font-bold ml-2 text-[#0A612B]">Leadership Messages</h2>
    <a href="{{ route('admin.leadership.add') }}" class="flex items-center px-4 py-2 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add New Message
    </a>
</div>

<main class="p-4 md:p-6">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Designation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($messages as $msg)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($msg->image)
                                    <img src="{{ asset('storage/' . $msg->image) }}"
                                         alt="{{ $msg->name }}"
                                         class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $msg->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $msg->designation }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-xs">{{ Str::limit($msg->message, 80) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    {{-- View Button --}}
                                    <a href="{{ route('admin.leadership.show', $msg->id) }}"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50 transition-colors"
                                       title="View Message">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.leadership.edit', $msg->id) }}"
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded hover:bg-emerald-50 transition-colors"
                                       title="Edit Message">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('admin.leadership.destroy', $msg->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50 transition-colors"
                                                title="Delete Message">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No leadership messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection