@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Profile</h1>
            <p class="text-gray-600 mt-2">Manage your account information and security settings</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6 shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-8 text-center">
                        <div class="relative inline-block">
                            <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto border-4 border-white shadow-lg">
                                <span class="text-4xl font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-white mt-4">{{ Auth::user()->name }}</h3>
                        <p class="text-emerald-100 mt-1">{{ Auth::user()->email }}</p>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white">
                                <i class="fas fa-user-shield mr-1"></i>
                                {{ Auth::user()->roles->first()->name ?? 'Admin User' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Member since:</span>
                            <span class="font-medium text-gray-800">{{ Auth::user()->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm mt-2">
                            <span class="text-gray-600">Last updated:</span>
                            <span class="font-medium text-gray-800">{{ Auth::user()->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Account Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-shield-alt text-emerald-600 mr-2"></i>
                        Account Status
                    </h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Email Verification:</span>
                            @if(Auth::user()->email_verified_at)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                            @else
                                <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i> Pending</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">2FA Status:</span>
                            <span class="text-gray-600">Disabled</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Update Profile Information -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-edit text-emerald-600 mr-2"></i>
                            Profile Information
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Update your account details and email address</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('admin.profile.update') }}" method="POST" id="profileForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-5">
                                <label for="name" class="block text-gray-700 font-medium mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', Auth::user()->name) }}"
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition @error('name') border-red-500 @enderror"
                                           placeholder="Enter your full name">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="email" class="block text-gray-700 font-medium mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', Auth::user()->email) }}"
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition @error('email') border-red-500 @enderror"
                                           placeholder="Enter your email address">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @if(!Auth::user()->email_verified_at)
                                    <p class="text-yellow-600 text-sm mt-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Your email is not verified. 
                                        <a href="#" class="text-emerald-600 hover:underline">Resend verification?</a>
                                    </p>
                                @endif
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-lock text-emerald-600 mr-2"></i>
                            Change Password
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Ensure your account is using a strong password</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('admin.profile.password') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-5">
                                <label for="current_password" class="block text-gray-700 font-medium mb-2">
                                    Current Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-gray-400"></i>
                                    </div>
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password"
                                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition @error('current_password') border-red-500 @enderror"
                                           placeholder="Enter your current password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="current_password">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="password" class="block text-gray-700 font-medium mb-2">
                                    New Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition @error('password') border-red-500 @enderror"
                                           placeholder="Enter new password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Minimum 8 characters</li>
                                        <li>At least one uppercase letter</li>
                                        <li>At least one number</li>
                                    </ul>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
                                    Confirm New Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-check-circle text-gray-400"></i>
                                    </div>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition"
                                           placeholder="Confirm new password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" data-target="password_confirmation">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    <i class="fas fa-key mr-2"></i>
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Activity (Optional) -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history text-emerald-600 mr-2"></i>
                            Recent Activity
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">Last login: <span class="font-medium">{{ now()->format('F d, Y h:i A') }}</span></p>
                                    <p class="text-xs text-gray-500">IP Address: {{ request()->ip() }}</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-user-edit text-green-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">Profile last updated: <span class="font-medium">{{ Auth::user()->updated_at->format('F d, Y h:i A') }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Strength Meter Script -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Password strength meter (optional enhancement)
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            updatePasswordStrengthIndicator(strength);
        });
    }
});

function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;
    return strength;
}

function updatePasswordStrengthIndicator(strength) {
    // You can add a password strength indicator UI here
    console.log('Password strength:', strength);
}
</script>
@endpush

@push('styles')
<style>
    /* Smooth transitions */
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    /* Custom focus styles */
    input:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    /* Hover effects for cards */
    .bg-white {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .bg-white:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endpush
@endsection