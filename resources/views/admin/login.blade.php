{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>Admin Login - PPP Department KPK</title>
    
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .login-bg {
            background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #059669 100%);
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.1);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        {{-- Logo and Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-landmark text-4xl text-emerald-800"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">PPP Department KPK</h1>
            <p class="text-emerald-100">Public Private Partnership</p>
        </div>
        
        {{-- Login Card --}}
        <div class="login-card rounded-2xl shadow-2xl p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Welcome Back</h2>
                <p class="text-gray-500 text-sm">Please sign in to access admin panel</p>
            </div>
            
            {{-- Session Status --}}
            @if(session('status'))
                <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-700 text-emerald-700 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif
            
            {{-- Error Messages --}}
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                        <div>
                            <p class="font-medium mb-1">Please check the following:</p>
                            <ul class="text-sm list-disc list-inside">
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
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-1 text-emerald-700"></i>Email Address
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            autocomplete="email"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent input-focus transition-all @error('email') border-red-500 @enderror"
                            placeholder="admin@pppkpk.gov.pk"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1 text-emerald-700"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent input-focus transition-all @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-emerald-700"
                        >
                            <i id="toggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-700"
                        >
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    
                    <a href="#" class="text-sm text-emerald-700 hover:text-emerald-800 hover:underline">
                        Forgot Password?
                    </a>
                </div>
                
                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg flex items-center justify-center"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </button>
            </form>
            
            {{-- Additional Info --}}
            <div class="mt-6 pt-5 border-t border-gray-200">
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                    <span><i class="fas fa-shield-alt mr-1 text-emerald-700"></i>Secure Login</span>
                    <span><i class="fas fa-clock mr-1 text-emerald-700"></i>Session: 120 min</span>
                </div>
                <p class="text-center text-xs text-gray-400 mt-4">
                    &copy; {{ date('Y') }} PPP Department KPK. All rights reserved.
                </p>
            </div>
        </div>
        
        {{-- Back to Site Link --}}
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-emerald-100 hover:text-white transition-colors text-sm">
                <i class="fas fa-arrow-left mr-1"></i>Back to Website
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
        
        // Auto-hide error messages after 5 seconds
        setTimeout(() => {
            const errorDivs = document.querySelectorAll('[class*="bg-red-50"]');
            errorDivs.forEach(div => {
                div.style.transition = 'opacity 0.5s';
                div.style.opacity = '0';
                setTimeout(() => div.style.display = 'none', 500);
            });
        }, 5000);
    </script>
</body>
</html>