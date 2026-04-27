{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>Admin Login - PPP Department KPK</title>

    {{-- Tailwind + Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background: #f5f7fa;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 font-sans antialiased bg-gray-50">

<div class="w-full max-w-md">
    {{-- Logo and Title --}}
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4 border-2 border-emerald-200">
            <img src="{{ asset('images/logo.png') }}" alt="PPP Logo" class="h-12 w-12 object-contain">
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">PPP Department KPK</h1>
        <p class="text-gray-500 text-sm font-medium">Public Private Partnership</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        {{-- Card Header - Green Only --}}
        <div class="bg-emerald-800 px-8 py-5">
            <h2 class="text-xl font-bold text-white mb-0.5">Welcome Back</h2>
            <p class="text-emerald-100 text-sm">Please sign in to access the admin panel</p>
        </div>

        {{-- Card Body --}}
        <div class="p-8">
            {{-- Session Status --}}
            @if(session('status'))
                <div class="mb-5 p-4 bg-emerald-50 border-l-4 border-emerald-700 text-emerald-800 rounded-r-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-3 text-lg mt-0.5"></i>
                        <div class="w-full">
                            <p class="font-medium mb-1">Please check the following:</p>
                            <ul class="text-sm list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        <i class="fas fa-envelope mr-1.5 text-emerald-700 w-4"></i>Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('email') border-red-500 @enderror"
                        placeholder="admin@pppkpk.gov.pk"
                    >
                    @error('email')
                        <p class="text-red-600 text-xs mt-1.5 flex items-center"><i class="fas fa-info-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        <i class="fas fa-lock mr-1.5 text-emerald-700 w-4"></i>Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all pr-12 @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-emerald-700 transition-colors p-1 rounded-full hover:bg-gray-100"
                            aria-label="Toggle password visibility"
                        >
                            <i id="toggleIcon" class="fas fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1.5 flex items-center"><i class="fas fa-info-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-500 shadow-sm"
                        >
                        <span class="ml-2 text-sm text-gray-700">Remember me</span>
                    </label>

                    <a href="#" class="text-sm text-emerald-700 hover:text-emerald-800 hover:underline font-medium transition">
                        Forgot Password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 mt-2"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In to Dashboard
                </button>
            </form>

            {{-- Footer Info --}}
            <div class="mt-6 pt-5 border-t border-gray-200">
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-500">
                    <span class="flex items-center"><i class="fas fa-shield-alt mr-1.5 text-emerald-700"></i>Secure Login</span>
                    <span class="flex items-center"><i class="fas fa-clock mr-1.5 text-emerald-700"></i>Session: 120 min</span>
                </div>
                <p class="text-center text-xs text-gray-400 mt-5">
                    &copy; {{ date('Y') }} PPP Department KPK. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    {{-- Back to Website Link --}}
    <div class="text-center mt-6">
        <a href="{{ url('/') }}" class="inline-flex items-center text-gray-600 hover:text-emerald-700 transition-colors text-sm font-medium">
            <i class="fas fa-arrow-left mr-2 text-xs"></i>Back to Public Website
        </a>
    </div>
</div>

<script>
    // Toggle Password Visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Auto-hide messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.style.display = 'none';
                    }
                }, 500);
            }, 5000);
        });
    });
</script>
</body>
</html>