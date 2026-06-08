@extends('layouts.admin')

@section('title', 'Team Member Details - PPP Department KPK')
@section('header-title', 'Team Member Details')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    <div class="mb-6">
        <a href="{{ route('admin.team.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Team Members
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-user-circle mr-2 text-emerald-600"></i>
                        Team Member Information
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View team member details</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            {{-- Profile Image --}}
            <div class="flex justify-center mb-8">
                @if($teamMember->img)
                    <img src="{{ asset('storage/' . $teamMember->img) }}"
                         alt="{{ $teamMember->name }}"
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
                    <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center bg-gray-800 text-white text-base font-medium px-3 py-1.5 rounded-md">
                            {{ $teamMember->name }}
                        </span>
                    </div>
                </div>

                {{-- Designation --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Designation</label>
                    <div class="text-gray-700 text-base">
                        <i class="fas fa-briefcase text-gray-400 mr-2"></i>
                        {{ $teamMember->designation->title }}
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                    <div class="text-gray-700">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        <a href="mailto:{{ $teamMember->email }}" class="text-emerald-600 hover:text-emerald-800">
                            {{ $teamMember->email }}
                        </a>
                    </div>
                </div>

                {{-- Phone Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                    <div class="text-gray-700">
                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                        <a href="tel:{{ $teamMember->phone }}" class="text-emerald-600 hover:text-emerald-800">
                            {{ $teamMember->phone }}
                        </a>
                    </div>
                </div>

                {{-- Created At --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                    <div class="text-gray-700">
                        <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                        {{ $teamMember->created_at->format('F d, Y') }}
                    </div>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="text-xs text-gray-400">
                    <i class="far fa-clock mr-1"></i>
                    Last updated: {{ $teamMember->updated_at->format('F d, Y ') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection