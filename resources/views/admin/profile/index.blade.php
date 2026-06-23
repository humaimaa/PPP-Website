@extends('layouts.admin')

@section('title', 'My Profile - PPP Unit KP')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your account information and security settings</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="mb-4 flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-700 text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-info-circle"></i>
            {{ session('info') }}
        </div>
    @endif

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-8 text-center">
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto border-4 border-white shadow-lg">
                            <span class="text-4xl font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </span>
                        </div>
                        @if(Auth::user()->email_verified_at)
                            <div class="absolute bottom-0 right-0 bg-green-500 rounded-full p-1 border-2 border-white">
                                <i class="fas fa-check-circle text-white text-xs"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-xl font-semibold text-white mt-4">{{ Auth::user()->name }}</h3>
                    <p class="text-emerald-100 mt-1 text-sm">{{ Auth::user()->email }}</p>
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white">
                            <i class="fas fa-user-shield mr-1"></i>
                            {{ Auth::user()->roles->first()->name ?? 'User' }}
                        </span>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-shield-alt text-emerald-600 mr-2"></i>
                    Account Status
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Email Verification:</span>
                        @if(Auth::user()->email_verified_at)
                            <span class="inline-flex items-center text-green-700">
                                <i class="fas fa-check-circle mr-1 text-green-500"></i>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center text-yellow-700">
                                <i class="fas fa-clock mr-1 text-yellow-500"></i>
                                Pending
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Account Status:</span>
                        @if(Auth::user()->is_active)
                            <span class="inline-flex items-center text-green-700">
                                <i class="fas fa-circle text-green-500 text-xs mr-1"></i>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center text-red-700">
                                <i class="fas fa-circle text-red-500 text-xs mr-1"></i>
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-emerald-600 mr-2"></i>
                    Quick Actions
                </h4>
                <div class="space-y-2">
                    <button onclick="document.getElementById('profileForm').scrollIntoView({behavior: 'smooth'})" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-user-edit mr-2 text-emerald-600"></i>
                        Edit Profile Information
                    </button>
                    <button onclick="document.getElementById('passwordForm').scrollIntoView({behavior: 'smooth'})" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <i class="fas fa-key mr-2 text-emerald-600"></i>
                        Change Password
                    </button>
                    @if(!Auth::user()->email_verified_at)
                        <form action="{{ route('admin.profile.resend-verification') }}" method="POST" class="inline-block w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                <i class="fas fa-envelope mr-2 text-emerald-600"></i>
                                Resend Verification Email
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Information Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="profileForm">
                <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-edit text-emerald-600 mr-2"></i>
                        Profile Information
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Update your account details and email address</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', Auth::user()->name) }}"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('name') border-red-500 @enderror"
                                       placeholder="Enter your full name">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                </div>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('email') border-red-500 @enderror"
                                       placeholder="Enter your email address">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-xs text-gray-500">Changing your email will require verification.</p>
                            @enderror
                            
                            @if(!Auth::user()->email_verified_at)
                                <div class="mt-3 rounded-md bg-yellow-50 p-3 border border-yellow-200">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Your email address is not verified.
                                            </p>
                                            <form action="{{ route('profile.resend-verification') }}" method="POST" class="mt-2">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-sm text-yellow-700 underline hover:text-yellow-800 font-medium">
                                                    Resend verification email
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-2"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="passwordForm">
                <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-lock text-emerald-600 mr-2"></i>
                        Change Password
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Ensure your account is using a strong password</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-400 text-sm"></i>
                                </div>
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password"
                                       class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('current_password') border-red-500 @enderror"
                                       placeholder="Enter your current password">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" 
                                        data-target="current_password">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('password') border-red-500 @enderror"
                                       placeholder="Enter new password">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" 
                                        data-target="password">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div id="passwordStrength" class="hidden">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500">Password strength:</span>
                                        <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div id="strengthBar" class="h-full transition-all duration-300" style="width: 0%"></div>
                                        </div>
                                        <span id="strengthText" class="text-xs font-medium"></span>
                                    </div>
                                </div>
                                <ul class="mt-2 text-xs text-gray-500 space-y-1">
                                    <li id="lengthCheck" class="flex items-center">
                                        <i class="fas fa-circle text-gray-300 text-[8px] mr-2"></i>
                                        Minimum 8 characters
                                    </li>
                                    <li id="uppercaseCheck" class="flex items-center">
                                        <i class="fas fa-circle text-gray-300 text-[8px] mr-2"></i>
                                        At least one uppercase letter
                                    </li>
                                    <li id="numberCheck" class="flex items-center">
                                        <i class="fas fa-circle text-gray-300 text-[8px] mr-2"></i>
                                        At least one number
                                    </li>
                                </ul>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-check-circle text-gray-400 text-sm"></i>
                                </div>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                                       placeholder="Confirm new password">
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password" 
                                        data-target="password_confirmation">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <i class="fas fa-key mr-2"></i>
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Session Management -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-desktop text-emerald-600 mr-2"></i>
                        Session Management
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Manage your active sessions and devices</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-laptop-code text-gray-600"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Current Session</p>
                                <p class="text-xs text-gray-500">{{ request()->userAgent() }}</p>
                                <p class="text-xs text-gray-500 mt-1">IP: {{ request()->ip() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active Now
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthContainer = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const lengthCheck = document.getElementById('lengthCheck');
    const uppercaseCheck = document.getElementById('uppercaseCheck');
    const numberCheck = document.getElementById('numberCheck');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length > 0) {
                strengthContainer.classList.remove('hidden');
                
                // Check criteria
                const hasMinLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasNumber = /\d/.test(password);
                
                // Update checkmarks
                updateCheckmark(lengthCheck, hasMinLength);
                updateCheckmark(uppercaseCheck, hasUppercase);
                updateCheckmark(numberCheck, hasNumber);
                
                // Calculate strength
                let strength = 0;
                if (hasMinLength) strength++;
                if (hasUppercase) strength++;
                if (hasNumber) strength++;
                
                // Update UI
                let strengthPercent = (strength / 3) * 100;
                strengthBar.style.width = strengthPercent + '%';
                
                let strengthColor = 'bg-red-500';
                let strengthLabel = 'Weak';
                
                if (strength === 3) {
                    strengthColor = 'bg-green-500';
                    strengthLabel = 'Strong';
                } else if (strength === 2) {
                    strengthColor = 'bg-yellow-500';
                    strengthLabel = 'Medium';
                }
                
                strengthBar.className = 'h-full transition-all duration-300 ' + strengthColor;
                strengthText.textContent = strengthLabel;
                strengthText.className = 'text-xs font-medium ' + (strength === 3 ? 'text-green-600' : (strength === 2 ? 'text-yellow-600' : 'text-red-600'));
            } else {
                strengthContainer.classList.add('hidden');
            }
        });
    }
});

function updateCheckmark(element, isValid) {
    const icon = element.querySelector('i');
    if (isValid) {
        icon.className = 'fas fa-check-circle text-green-500 text-xs mr-2';
        element.classList.add('text-green-700');
    } else {
        icon.className = 'fas fa-circle text-gray-300 text-[8px] mr-2';
        element.classList.remove('text-green-700');
    }
}
</script>
@endpush

@push('styles')
<style>
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    html {
        scroll-behavior: smooth;
    }
    
    input:focus {
        outline: none;
    }
    
    .bg-white {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .bg-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
    }
</style>
@endpush
@endsection