@extends('layouts.admin')

@section('title', 'Edit User Role - PPP Department KPK')
@section('header-title', 'Edit User Role')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Users
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-linear-to-r from-emerald-50 to-green-50 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-edit mr-2 text-emerald-600"></i>
                    Edit User Role
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update role assignment for {{ $user->name }}</p>
            </div>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

       <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6">
    @csrf
    @method('PUT')
    
    {{-- Full Name (Read-only but submitted) --}}
    <div class="mb-6">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Full Name
        </label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-user"></i>
            </span>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ $user->name }}"
                readonly
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
            >
        </div>
        <p class="mt-1 text-xs text-gray-500">User's full name (read-only)</p>
    </div>

    {{-- Email Address (Read-only but submitted) --}}
    <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email Address
        </label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-envelope"></i>
            </span>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ $user->email }}"
                readonly
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
            >
        </div>
        <p class="mt-1 text-xs text-gray-500">User's email address (read-only)</p>
    </div>

    {{-- Hidden fields to ensure name and email are submitted --}}
    <input type="hidden" name="name" value="{{ $user->name }}">
    <input type="hidden" name="email" value="{{ $user->email }}">

    {{-- Role Selection --}}
    <div class="mb-6">
        <label for="primary_role" class="block text-sm font-medium text-gray-700 mb-2">
            Assign Role <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-user-shield"></i>
            </span>
            <select 
                id="primary_role" 
                name="roles[]"
                required
                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none @error('roles') border-red-500 @enderror"
            >
                <option value="">Select a role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $userRoles)) ? 'selected' : '' }}>
                        {{ $role->name }} 
                    </option>
                @endforeach
            </select>
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                <i class="fas fa-chevron-down"></i>
            </span>
        </div>
        <p class="mt-1 text-xs text-gray-500">Select the role that will define this user's permissions</p>
        @error('roles')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- User Information Summary --}}
    <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
        <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
            <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
            Account Information
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">User ID:</span>
                <span class="text-gray-700 font-medium ml-2">#{{ $user->id }}</span>
            </div>
            <div>
                <span class="text-gray-500">Created:</span>
                <span class="text-gray-700 ml-2">{{ $user->created_at->format('F d, Y h:i A') }}</span>
            </div>
            <div>
                <span class="text-gray-500">Last Updated:</span>
                <span class="text-gray-700 ml-2">{{ $user->updated_at->format('F d, Y h:i A') }}</span>
            </div>
            <div>
                <span class="text-gray-500">Email Verified:</span>
                <span class="ml-2">
                    @if($user->email_verified_at)
                        <span class="text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ $user->email_verified_at->format('F d, Y') }}
                        </span>
                    @else
                        <span class="text-yellow-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Not verified
                        </span>
                    @endif
                </span>
            </div>
            <div class="md:col-span-2">
                <span class="text-gray-500">Current Role{{ $user->roles->count() > 1 ? 's' : '' }}:</span>
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($user->roles as $role)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            @if($role->name === 'Super Admin') 
                                bg-purple-100 text-purple-800
                            @elseif($role->name === 'Admin')
                                bg-blue-100 text-blue-800
                            @elseif($role->name === 'Content Manager')
                                bg-green-100 text-green-800
                            @elseif($role->name === 'Editor')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ $role->name }}
                        </span>
                    @empty
                        <span class="text-gray-500 italic">No role assigned</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Preview Information --}}
    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
            <div>
                <h4 class="text-sm font-medium text-blue-900">About Role Changes</h4>
                <p class="text-xs text-blue-700 mt-1">
                    Changing a user's role will update their permissions immediately.
                    The user will have access to features based on their new role assignment.
                </p>
            </div>
        </div>
    </div>

    {{-- Form Actions --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.users.index') }}" 
           class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            <i class="fas fa-times mr-2"></i>
            Cancel
        </a>
        <button type="submit"
                class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
            <i class="fas fa-save mr-2"></i>
            Update Role
        </button>
    </div>
</form>
    </div>
</div>

<script>
    // Warn user when leaving page with unsaved changes
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const roleSelect = document.getElementById('primary_role');
        let originalRoleValue = roleSelect.value;
        
        form.addEventListener('submit', function() {
            window.removeEventListener('beforeunload', warnUnsaved);
        });
        
        function warnUnsaved(e) {
            if (roleSelect.value !== originalRoleValue) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        }
        
        window.addEventListener('beforeunload', warnUnsaved);
    });
</script>
@endsection