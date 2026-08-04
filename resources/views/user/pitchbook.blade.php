<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PPP KP - Digital Pitchbook' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Load CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/css/pitchbook.css', 'resources/css/home-animate.css', 'resources/css/admin.css'])

    <!-- Load jQuery and dependencies directly from public directory -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.8.20.custom.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ asset('js/modernizr.2.5.3.min.js') }}"></script>
    <script src="{{ asset('js/turn.min.js') }}"></script>
    <script src="{{ asset('js/zoom.min.js') }}"></script>
</head>

<body>

    <!-- Flip sound -->
    <audio id="flipSound" preload="auto">
        <source src="{{ asset('videos/flip_sound.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Loading -->
    <div id="loading">
        <div id="loading-spinner"></div>
        <div id="loading-text">Loading Pitchbook&hellip;</div>
    </div>

    <!-- Canvas -->
    <div id="canvas" style="visibility:hidden;">
        <div id="book-zoom">
            <div id="flipbook">
                @for ($i = 1; $i <= 111; $i++)
                    <div class="page" data-page="{{ $i }}">
                        <img
                            src="{{ asset('images/Pitchbook/Slide' . $i . '.PNG') }}"
                            alt="Slide {{ $i }}"
                            loading="{{ $i <= 6 ? 'eager' : 'lazy' }}"
                            draggable="false"
                        />
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Nav -->
    <nav id="nav-bar">
        <button id="prevBtn">&#9664; Prev</button>
        <div id="page-counter">
            Page <span id="currentPage">1</span> / <span id="totalPages">111</span>
        </div>
        <button id="nextBtn">Next &#9654;</button>
    </nav>

    <!-- Load other JS via Vite (excluding jQuery and turn.js which are loaded above) -->
    @vite([
        'resources/js/app.js',
        'resources/js/home-animate.js',
        'resources/js/kp-map.js',
        'resources/js/admin.js',
        'resources/js/hash.js'
    ])

    <script>
        // Wait for DOM and all scripts to load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if jQuery is loaded
            if (typeof jQuery === 'undefined') {
                document.getElementById('loading').innerHTML =
                    '<p style="color:#333;font-family:sans-serif;text-align:center;padding:2rem;">' +
                    '&#9888; <strong>jQuery not loaded.</strong><br><br>' +
                    '<small>Check that jQuery files exist in public/js/</small></p>';
                return;
            }

            // Use jQuery's ready function
            jQuery(document).ready(function($) {
                var TOTAL_PAGES = 111;

                // Set audio volume to 50%
                var audioElement = document.getElementById('flipSound');
                if (audioElement) {
                    audioElement.volume = 0.5;
                }

                function calcBookSize() {
                    var availW = window.innerWidth - 32;
                    var availH = window.innerHeight - 100;
                    var bookH = availH;
                    var bookW = Math.round(bookH * 32 / 9);
                    if (bookW > availW) {
                        bookW = availW;
                        bookH = Math.round(bookW * 9 / 32);
                    }
                    return { w: bookW, h: bookH };
                }

                function numberOfViews(book) {
                    return Math.ceil((book.turn('pages') + 2) / 2);
                }

                function getViewNumber(book, page) {
                    return Math.ceil(((page || book.turn('page')) + 1) / 2);
                }

                function updatePageCounter(page) {
                    $('#currentPage').text(page);
                }

                function preloadImages(start, end) {
                    for (var i = start; i <= Math.min(end, TOTAL_PAGES); i++) {
                        (new Image()).src = '/images/Pitchbook/Slide' + i + '.PNG';
                    }
                }

                function playFlipSound() {
                    var snd = document.getElementById('flipSound');
                    if (snd) { 
                        snd.currentTime = 0; 
                        snd.play().catch(function () {}); 
                    }
                }

                function loadApp() {
                    if (typeof $.fn.turn === 'undefined') {
                        $('#loading').html(
                            '<p style="color:#333;font-family:sans-serif;text-align:center;padding:2rem;">' +
                            '&#9888; <strong>turn.js not loaded.</strong><br><br>' +
                            '<small>Check that turn.min.js exists in public/js/</small></p>'
                        );
                        return;
                    }

                    var flipbook = $('#flipbook');
                    var size = calcBookSize();

                    $('#book-zoom').css({ width: size.w, height: size.h });
                    flipbook.css({ width: size.w, height: size.h });

                    flipbook.turn({
                        width: size.w,
                        height: size.h,
                        duration: 650,
                        gradients: true,
                        acceleration: true,
                        display: 'double',
                        autoCenter: true,
                        elevation: 50,
                        pages: TOTAL_PAGES,
                        when: {
                            turning: function(e, page) {
                                var book = $(this);
                                var current = book.turn('page');
                                var pages = book.turn('pages');
                                if (current > 3 && current < pages - 3) {
                                    if (page === 1) {
                                        book.turn('page', 2).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    } else if (page === pages) {
                                        book.turn('page', pages - 1).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    }
                                }
                                playFlipSound();
                            },
                            turned: function(e, page) {
                                updatePageCounter(page);
                                $(this).turn('center');
                                preloadImages(page + 2, page + 12);
                            },
                            missing: function(e, pages) {
                                console.warn('Missing pages:', pages);
                            }
                        }
                    });

                    // Mousewheel
                    $('#book-zoom').on('wheel', function(e) {
                        e.preventDefault();
                        var d = e.originalEvent.deltaX || e.originalEvent.deltaY;
                        if (d > 20) flipbook.turn('next');
                        else if (d < -20) flipbook.turn('previous');
                    });

                    // Keyboard
                    $(document).keydown(function(e) {
                        switch (e.keyCode) {
                            case 37:
                                flipbook.turn('previous');
                                e.preventDefault();
                                break;
                            case 39:
                                flipbook.turn('next');
                                e.preventDefault();
                                break;
                            case 36:
                                flipbook.turn('page', 1);
                                e.preventDefault();
                                break;
                            case 35:
                                flipbook.turn('page', TOTAL_PAGES);
                                e.preventDefault();
                                break;
                        }
                    });

                    // Buttons
                    $('#prevBtn').on('click', function() { 
                        flipbook.turn('previous'); 
                    });
                    $('#nextBtn').on('click', function() { 
                        flipbook.turn('next'); 
                    });

                    // Resize
                    $(window).on('resize', function() {
                        var s = calcBookSize();
                        $('#book-zoom').css({ width: s.w, height: s.h });
                        flipbook.turn('size', s.w, s.h);
                        flipbook.turn('center');
                    });

                    $('#totalPages').text(TOTAL_PAGES);
                    updatePageCounter(1);
                    $('#canvas').css({ visibility: 'visible' });
                    setTimeout(function() { 
                        $('#loading').fadeOut(400); 
                    }, 400);
                    preloadImages(1, 20);
                }

                loadApp();
            });
        });
    </script>
</body>
</html>