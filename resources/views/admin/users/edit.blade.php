@extends('layouts.admin')

@section('title', 'Edit User Role - PPP Department KPK')
@section('header-title', 'Edit User Role')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
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

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-user-edit mr-2 text-emerald-600"></i>
                Edit User Role
            </h3>
            <p class="text-sm text-gray-500 mt-1">Update role assignment for {{ $user->name }}</p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Full Name (Read-only) --}}
                <div>
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
                            disabled
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                        >
                    </div>
                </div>

                {{-- Email Address (Read-only) --}}
                <div>
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
                            disabled
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                        >
                    </div>
                </div>

                {{-- Role Selection (Editable) --}}
                <div class="md:col-span-2">
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
                            class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors appearance-none @error('roles') border-red-500 @enderror"
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
                    @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Select the role that will define this user's permissions
                    </p>
                </div>

                {{-- User Information Summary --}}
                <div class="md:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-emerald-600"></i>
                            Account Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">User ID:</span>
                                <span class="text-gray-700 font-medium">#{{ $user->id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Created:</span>
                                <span class="text-gray-700">{{ $user->created_at->format('F d, Y h:i A') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Last Updated:</span>
                                <span class="text-gray-700">{{ $user->updated_at->format('F d, Y h:i A') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Email Verified:</span>
                                <span class="text-gray-700">
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
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
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
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300"
                >
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                >
                    <i class="fas fa-save mr-2"></i>
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush