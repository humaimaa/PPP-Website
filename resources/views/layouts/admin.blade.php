<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'PPP Unit KP - Admin')</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
</head>

<body class="font-sans bg-gray-50">
    @include('layouts.partials.admin-sidebar')

    @include('layouts.partials.admin-header')

     <main id="mainContent" class="main-content transition-all duration-300 ease-in-out">
        <div class="p-4 md:p-6">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>

</html>