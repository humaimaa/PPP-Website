<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'PPP KP - Pitchbook')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{--
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
</head>

<body class="font-sans">

    <main>
        <section class="h-screen w-full">
            <iframe src="https://publuu.com/flip-book/1086690/2424970/page/1?embed" width="100%" height="100%"
                scrolling="no" frameborder="0" allow="clipboard-write; autoplay; fullscreen"
                allowfullscreen="allowfullscreen" class="publuuflip">
            </iframe>
        </section>
    </main>

</body>

</html>