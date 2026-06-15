@extends('layouts.admin')

@section('title', 'Add User - PPP Unit KP')
@section('header-title', 'Add New User')

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
                    <i class="fas fa-user-plus mr-2 text-emerald-600"></i>
                    Add New User
                </h3>
                <p class="text-sm text-gray-500 mt-1">Create a new user account with role-based permissions</p>
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

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6">
            @csrf
            
            {{-- Full Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                        placeholder="Enter full name"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">Full name of the user</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Address --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror"
                        placeholder="user@example.com"
                    >
                </div>
                <p class="mt-1 text-xs text-gray-500">User's email address (used for login)</p>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror"
                        placeholder="Minimum 8 characters"
                    >
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye" id="password-toggle-icon"></i>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Re-enter password"
                    >
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye" id="password_confirmation-toggle-icon"></i>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Re-enter the password to confirm</p>
            </div>

            {{-- Role Selection --}}
            <div class="mb-6">
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Assign Role <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    <select 
                        id="role_id" 
                        name="roles[]"
                        required
                        class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 appearance-none @error('roles') border-red-500 @enderror"
                    >
                        <option value="">Select a role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('roles') && in_array($role->id, old('roles')) ? 'selected' : '' }}>
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

            {{-- Email Verification Option - ADD THIS SECTION --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email Verification
                </label>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input type="radio" 
                               id="verify_auto" 
                               name="send_verification" 
                               value="0" 
                               checked
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                        <label for="verify_auto" class="ml-2 text-sm text-gray-700">
                            Auto-verify email (user can login immediately)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" 
                               id="verify_send" 
                               name="send_verification" 
                               value="1"
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                        <label for="verify_send" class="ml-2 text-sm text-gray-700">
                            Send verification email (user must verify email before login)
                        </label>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Choose whether the user needs to verify their email address before accessing the system
                </p>
            </div>

            {{-- Preview Information --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900">About User Accounts</h4>
                        <p class="text-xs text-blue-700 mt-1">
                            Users can access the admin panel based on their assigned role and permissions.
                            Each user must have a unique email address and a strong password.
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
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-toggle-icon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // Password match validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        
        if (passwordInput && confirmInput) {
            function validatePasswordMatch() {
                if (confirmInput.value !== '') {
                    if (passwordInput.value !== confirmInput.value) {
                        confirmInput.setCustomValidity('Passwords do not match');
                    } else {
                        confirmInput.setCustomValidity('');
                    }
                }
            }
            
            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmInput.addEventListener('input', validatePasswordMatch);
        }
    });
</script>
@endsection