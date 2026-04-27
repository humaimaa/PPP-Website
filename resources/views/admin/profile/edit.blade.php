@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile Information Form --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Information</h2>
            
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-emerald-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-emerald-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">
                    Update Profile
                </button>
            </form>
        </div>

        {{-- Change Password Form --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Change Password</h2>
            
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 font-medium mb-2">Current Password</label>
                    <input type="password" 
                           name="current_password" 
                           id="current_password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-emerald-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-emerald-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm New Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-emerald-500">
                </div>

                <button type="submit" 
                        class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">
                    Change Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection