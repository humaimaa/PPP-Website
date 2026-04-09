<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'PPP Department KPK')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
</head>
<body class="font-sans">
    @include('.layouts.partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('.layouts.partials.footer')
</body>
</html>