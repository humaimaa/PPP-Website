@extends('layouts.admin')

@section('title', 'Team Member Details - PPP Unit KP')
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
                <div class="flex gap-2">
                    @can('team.edit')
                        <a href="{{ route('admin.team.edit', $teamMember) }}" 
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                            Edit Member
                        </a>
                    @endcan
                    @can('team.delete')
                        <form action="{{ route('admin.team.destroy', $teamMember) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this team member? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                <i class="fas fa-trash-alt"></i>
                                Delete
                            </button>
                        </form>
                    @endcan
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

                {{-- Hierarchy Level --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Hierarchy Level</label>
                    <div class="text-gray-700 text-base">
                        <i class="fas fa-sitemap text-gray-400 mr-2"></i>
                        <span class="inline-flex items-center bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-md">
                            {{ $teamMember->hierarchy->title ?? 'N/A' }}
                        </span>
                        @if($teamMember->hierarchy)
                            <span class="text-xs text-gray-400 ml-2">
                                (Order: {{ $teamMember->hierarchy->order }})
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Designation (Job Title) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Designation / Job Title</label>
                    <div class="text-gray-700 text-base">
                        <i class="fas fa-briefcase text-gray-400 mr-2"></i>
                        <span class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-md">
                            {{ $teamMember->designation ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                    <div class="text-gray-700">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        <a href="mailto:{{ $teamMember->email }}" class="text-emerald-600 hover:text-emerald-800 transition">
                            {{ $teamMember->email }}
                        </a>
                    </div>
                </div>

                {{-- Phone Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                    <div class="text-gray-700">
                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                        <a href="tel:{{ $teamMember->phone }}" class="text-emerald-600 hover:text-emerald-800 transition">
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

                {{-- Status / Additional Info --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    <div class="text-gray-700">
                        <i class="fas fa-circle text-emerald-500 mr-2" style="font-size: 0.6rem;"></i>
                        <span class="text-sm">Active</span>
                    </div>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-xs text-gray-400">
                        <i class="far fa-clock mr-1"></i>
                        Last updated: {{ $teamMember->updated_at->format('F d, Y h:i A') }}
                    </div>
                    <div class="text-xs text-gray-400">
                        <i class="far fa-id-card mr-1"></i>
                        ID: #{{ $teamMember->id }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection