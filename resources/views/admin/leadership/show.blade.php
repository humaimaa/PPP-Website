@extends('layouts.admin')

@section('title', 'Leadership Message Details - PPP Department KPK')
@section('header-title', 'Leadership Message Details')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.leadership.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Messages
        </a>
    </div>

    {{-- Message Information Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-comment-dots mr-2 text-emerald-600"></i>
                        Leadership Message Information
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View leadership message details</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.leadership.edit', $message->id) }}" 
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        <i class="fas fa-edit"></i>
                        Edit Message
                    </a>
                    <a href="{{ route('admin.leadership.index') }}" 
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                        <i class="fas fa-list"></i>
                        All Messages
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            {{-- Profile Image --}}
            <div class="flex justify-center mb-8">
                @if ($message->image)
                    <img src="{{ asset('storage/' . $message->image) }}"
                         alt="{{ $message->name }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-emerald-100 shadow">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-100 border-4 border-emerald-100 shadow flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-4xl"></i>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center bg-gray-800 text-white text-base font-medium px-3 py-1.5 rounded-md">
                            {{ $message->name }}
                        </span>
                    </div>
                </div>

                {{-- Designation --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Designation</label>
                    <div class="text-gray-700 text-base">
                        <i class="fas fa-briefcase text-gray-400 mr-2"></i>
                        {{ $message->designation }}
                    </div>
                </div>

                {{-- Created At --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Created At</label>
                    <div class="text-gray-700">
                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                        {{ $message->created_at->format('F d, Y h:i A') }}
                    </div>
                </div>

                {{-- Last Updated --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                    <div class="text-gray-700">
                        <i class="far fa-clock text-gray-400 mr-2"></i>
                        {{ $message->updated_at->format('F d, Y h:i A') }}
                    </div>
                </div>
            </div>

            {{-- Message Content --}}
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Message</label>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed">
                    <i class="fas fa-quote-left text-gray-400 mr-2"></i>
                    <div class="whitespace-pre-line mt-2">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection